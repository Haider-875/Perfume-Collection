<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\FragranceFamily;
use App\Models\Brand;
use App\Models\ScentNote;
use App\Models\Review;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'fragranceFamily', 'scentNotes'])->active();

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

        // 2. Category Filter
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 3. Fragrance Family Filter
        if ($request->filled('family')) {
            $query->whereHas('fragranceFamily', function($q) use ($request) {
                $q->where('slug', $request->family);
            });
        }

        // 4. Gender Filter
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        // 5. Concentration Filter
        if ($request->filled('concentration')) {
            $query->where('concentration', 'like', '%' . $request->concentration . '%');
        }

        // 6. Price Range (in PKR)
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float)$request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float)$request->max_price);
        }

        // 7. Scent Note Filter
        if ($request->filled('note')) {
            $query->whereHas('scentNotes', function($q) use ($request) {
                $q->where('scent_notes.slug', $request->note);
            });
        }

        // 8. Sorting
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

        $categories = Category::where('is_active', true)->withCount('activeProducts')->get();
        $fragranceFamilies = FragranceFamily::withCount('products')->get();
        $scentNotes = ScentNote::orderBy('name')->take(20)->get();

        $currentCategory = $request->filled('category') ? Category::where('slug', $request->category)->first() : null;
        $currentFamily = $request->filled('family') ? FragranceFamily::where('slug', $request->family)->first() : null;

        return view('pages.shop', compact(
            'products',
            'categories',
            'fragranceFamilies',
            'scentNotes',
            'currentCategory',
            'currentFamily'
        ));
    }

    public function show($slug)
    {
        $product = Product::with([
            'category',
            'brand',
            'fragranceFamily',
            'images',
            'variants',
            'reviews',
            'scentNotes'
        ])->where('slug', $slug)->firstOrFail();

        // Increment view count
        $product->increment('views_count');

        // Top, Heart, Base notes
        $topNotes = $product->topNotes()->get();
        $heartNotes = $product->heartNotes()->get();
        $baseNotes = $product->baseNotes()->get();

        // Related Olfactory Pairings
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where(function($q) use ($product) {
                $q->where('category_id', $product->category_id)
                  ->orWhere('fragrance_family_id', $product->fragrance_family_id);
            })
            ->active()
            ->take(4)
            ->get();

        return view('pages.product-detail', compact(
            'product',
            'topNotes',
            'heartNotes',
            'baseNotes',
            'relatedProducts'
        ));
    }

    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_city' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:150',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $product = Product::findOrFail($id);

        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_city' => $request->customer_city,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'verified_purchase' => true,
            'is_approved' => true,
        ]);

        // Recalculate average rating
        $avg = $product->reviews()->where('is_approved', true)->avg('rating');
        $count = $product->reviews()->where('is_approved', true)->count();
        $product->update([
            'rating_avg' => round($avg, 2),
            'reviews_count' => $count,
        ]);

        return back()->with('success', 'Your verified review has been published to our olfactory ledger!');
    }
}
