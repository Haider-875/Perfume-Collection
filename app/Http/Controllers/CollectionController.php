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
            $bundles = Bundle::where('is_active', true)->with(['items.product', 'products'])->paginate(12)->withQueryString();
            $bundleProducts = Product::where('is_bundle', true)->active()->get();
            return view('pages.bundles', compact('bundles', 'bundleProducts'));
        }

        $collection = null;
        if ($slug !== 'all') {
            $collection = Collection::where('slug', $slug)
                ->orWhere(function($q) use ($slug) {
                    if ($slug === 'exclusive') {
                        $q->where('slug', 'exclusive-reserve');
                    }
                })->firstOrFail();
            $query = $collection->products()->active();
        } else {
            $query = Product::active();
        }

        // 1. Search Query
        if ($request->filled('q')) {
            $searchTerm = '%' . $request->q . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm)
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
            $query->whereHas('scentNotes', function($q) use ($request) {
                $q->where('scent_notes.slug', $request->note);
            });
        }

        // 4. Size / Volume (ml)
        if ($request->filled('volume_ml')) {
            $query->where('volume_ml', $request->volume_ml);
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

        $fragranceFamilies = FragranceFamily::withCount('products')->get();
        $scentNotes = ScentNote::orderBy('name')->take(20)->get();
        $allCollections = Collection::where('is_active', true)->get();

        return view('pages.collection-detail', compact(
            'collection',
            'slug',
            'products',
            'fragranceFamilies',
            'scentNotes',
            'allCollections'
        ));
    }
}
