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

        $bestsellers = Product::with(['category', 'fragranceFamily', 'scentNotes'])
            ->active()
            ->bestsellers()
            ->take(8)
            ->get();

        $newArrivals = Product::with(['category', 'fragranceFamily', 'scentNotes'])
            ->active()
            ->newArrivals()
            ->take(4)
            ->get();

        $bundles = Bundle::where('is_active', true)->with('items.product')->take(3)->get();

        $collaborationProduct = Product::where('is_collaboration', true)->first();

        $recentReviews = Review::with('product')
            ->where('is_approved', true)
            ->latest()
            ->take(4)
            ->get();

        $recentBlogs = Blog::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('pages.home', compact(
            'heroSlides',
            'featuredCategories',
            'collections',
            'bestsellers',
            'newArrivals',
            'bundles',
            'collaborationProduct',
            'recentReviews',
            'recentBlogs'
        ));
    }
}
