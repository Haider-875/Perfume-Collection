<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Category;
use App\Models\FragranceFamily;
use App\Models\ScentNote;
use App\Models\Bundle;

class CollectionController extends Controller
{
    public function show(Request $request, $slug = 'all')
    {
        // Special case: Bundles page
        if ($slug === 'bundles') {
            // Auto-heal / Ensure standard 10 luxury bundles exist (vital for serverless / Wasmer deployments)
            if (Bundle::where('slug', 'imperial-leather-tobacco-duo')->doesntExist() || Bundle::count() < 10) {
                try {
                    $seeder = new \Database\Seeders\BundleSeeder();
                    $seeder->run();
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning('Automatic BundleSeeder execution notice: ' . $e->getMessage());
                }
            }

            $bundles = Bundle::where('is_active', true)
                ->with([
                    'items.product.variants',
                    'items.product.prices',
                    'products.variants',
                    'products.prices'
                ])
                ->paginate(12)
                ->withQueryString();
            $bundleProducts = Product::where('is_bundle', true)->active()->get();
            return view('pages.bundles', compact('bundles', 'bundleProducts'));
        }

        // Explicitly disallow candles & attar pages
        if (in_array($slug, ['candles', 'candle', 'attar', 'attars'])) {
            abort(404);
        }

        $collection = null;
        if ($slug !== 'all') {
            if ($slug === 'exclusive') {
                \App\Http\Controllers\Admin\AdminCategoryController::ensureCoreCategoriesExist();
            }

            // Find collection by slug
            $collection = Collection::where('slug', $slug)->first();

            // Find category by slug or alias (managed via Admin Categories)
            $category = Category::where('slug', $slug)->first();

            if (!$collection && !$category) {
                abort(404);
            }

            // Fallback for view presentation (both models share name, description, image, badge_text, slug)
            if (!$collection) {
                $collection = $category;
            }

            $query = Product::active()->where(function($q) use ($collection, $category) {
                $q->where(function($sub) use ($collection, $category) {
                    $hasClause = false;
                    if ($category) {
                        $sub->where('category_id', $category->id);
                        $hasClause = true;
                    }
                    if ($collection instanceof Collection) {
                        if ($hasClause) {
                            $sub->orWhereHas('collections', function($cq) use ($collection) {
                                $cq->where('collections.id', $collection->id);
                            });
                        } else {
                            $sub->whereHas('collections', function($cq) use ($collection) {
                                $cq->where('collections.id', $collection->id);
                            });
                        }
                    }
                });
            });
        } else {
            $query = Product::active();
        }

        // 1. Search Query
        if ($request->filled('q')) {
            $searchTerm = '%' . $request->q . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm)
                  ->orWhere('tagline', 'like', $searchTerm)
                  ->orWhere('top_notes_summary', 'like', $searchTerm)
                  ->orWhere('heart_notes_summary', 'like', $searchTerm)
                  ->orWhere('base_notes_summary', 'like', $searchTerm);
            });
        }

        // 2. Fragrance Family Filter
        if ($request->filled('family')) {
            $query->whereHas('fragranceFamily', function($q) use ($request) {
                $q->where('slug', $request->family);
            });
        }

        // 3. Scent Note Filter
        if ($request->filled('note')) {
            $noteSlug = $request->note;
            $query->where(function($q) use ($noteSlug) {
                $q->whereHas('scentNotes', function($sq) use ($noteSlug) {
                    $sq->where('scent_notes.slug', $noteSlug);
                });

                $noteWord = str_replace('-', ' ', $noteSlug);
                $q->orWhere('top_notes_summary', 'like', '%' . $noteWord . '%')
                  ->orWhere('heart_notes_summary', 'like', '%' . $noteWord . '%')
                  ->orWhere('base_notes_summary', 'like', '%' . $noteWord . '%')
                  ->orWhere('tagline', 'like', '%' . $noteWord . '%')
                  ->orWhere('description', 'like', '%' . $noteWord . '%');

                $keywords = explode('-', $noteSlug);
                foreach ($keywords as $kw) {
                    if (strlen($kw) >= 4 && !in_array($kw, ['noir', 'white', 'royal', 'golden', 'bark', 'leaf', 'bean', 'dew'])) {
                        $q->orWhere('top_notes_summary', 'like', '%' . $kw . '%')
                          ->orWhere('heart_notes_summary', 'like', '%' . $kw . '%')
                          ->orWhere('base_notes_summary', 'like', '%' . $kw . '%')
                          ->orWhere('tagline', 'like', '%' . $kw . '%');
                    }
                }
            });
        }

        // 4. Size / Volume (ml)
        if ($request->filled('volume_ml')) {
            $vol = (int) $request->volume_ml;
            $query->where(function($q) use ($vol) {
                $q->where('volume_ml', $vol)
                  ->orWhereHas('prices', function($pq) use ($vol) {
                      $pq->where('size', 'like', $vol . '%');
                  })
                  ->orWhereHas('variants', function($vq) use ($vol) {
                      $vq->where('volume_ml', $vol);
                  });
            });
        }

        // 5. Price Range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float)$request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float)$request->max_price);
        }

        // 6. Sorting
        $sort = $request->get('sort', 'featured');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating_avg', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'bestseller':
                $query->orderBy('is_bestseller', 'desc')->latest();
                break;
            default:
                $query->orderBy('is_featured', 'desc')->orderBy('is_bestseller', 'desc')->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        $fragranceFamilies = FragranceFamily::has('products')->withCount('products')->orderBy('name')->get();
        $scentNotes = ScentNote::has('products')->withCount('products')->orderBy('name')->get();
        $allCollections = Collection::where('is_active', true)->orderBy('sort_order')->get();
        $allCategories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.collection-detail', compact(
            'collection',
            'slug',
            'products',
            'fragranceFamilies',
            'scentNotes',
            'allCollections',
            'allCategories'
        ));
    }
}
