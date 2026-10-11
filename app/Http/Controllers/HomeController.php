<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeroSlide;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Category;
use App\Models\Bundle;
use App\Models\Blog;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $heroSlides = HeroSlide::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        
        $featuredCategories = Category::where('is_active', true)->orderBy('sort_order', 'asc')->take(4)->get();
        $collections = Collection::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        // Featured Collection: All newly added products / latest impressions
        $featuredProducts = Product::with(['category', 'fragranceFamily', 'scentNotes'])
            ->active()
            ->where('is_featured', true)
            ->orderBy('id', 'desc')
            ->get();

        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::with(['category', 'fragranceFamily', 'scentNotes'])
                ->active()
                ->orderBy('id', 'desc')
                ->get();
        }

        $bestsellers = Product::with(['category', 'fragranceFamily', 'scentNotes'])
            ->active()
            ->bestsellers()
            ->take(8)
            ->get();

        if ($bestsellers->isEmpty()) {
            $bestsellers = $featuredProducts->take(8);
        }

        // New Release Impressions (swapped): Classic formulations from previous featured collection
        $newArrivals = Product::with(['category', 'fragranceFamily', 'scentNotes'])
            ->active()
            ->newArrivals()
            ->orderBy('id', 'asc')
            ->get();

        if ($newArrivals->isEmpty()) {
            $newArrivals = Product::with(['category', 'fragranceFamily', 'scentNotes'])
                ->active()
                ->whereIn('id', [1, 2, 3, 4, 5, 6, 7])
                ->orderBy('id', 'asc')
                ->get();
        }

        $restockedProducts = Product::with(['category', 'fragranceFamily', 'scentNotes'])
            ->active()
            ->latest()
            ->take(8)
            ->get();

        $bundles = Bundle::where('is_active', true)->with('items.product')->take(3)->get();

        $collaborationProduct = Product::where('is_collaboration', true)->first();

        $recentReviews = Review::with('product')
            ->where('is_approved', true)
            ->latest()
            ->take(20)
            ->get();

        $recentBlogs = Blog::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('pages.home', compact(
            'heroSlides',
            'featuredCategories',
            'collections',
            'featuredProducts',
            'bestsellers',
            'newArrivals',
            'restockedProducts',
            'bundles',
            'collaborationProduct',
            'recentReviews',
            'recentBlogs'
        ));
    }
}
