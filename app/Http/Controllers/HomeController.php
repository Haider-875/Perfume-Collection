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

        $featuredProducts = Product::with(['category', 'fragranceFamily', 'scentNotes'])
            ->active()
            ->where(function($q) {
                $q->where('is_featured', true)->orWhere('is_bestseller', true);
            })
            ->take(8)
            ->get();

        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::with(['category', 'fragranceFamily', 'scentNotes'])
                ->active()
                ->take(8)
                ->get();
        }

        $bestsellers = Product::with(['category', 'fragranceFamily', 'scentNotes'])
            ->active()
            ->bestsellers()
            ->take(8)
            ->get();

        if ($bestsellers->isEmpty()) {
            $bestsellers = $featuredProducts;
        }

        $newArrivals = Product::with(['category', 'fragranceFamily', 'scentNotes'])
            ->active()
            ->newArrivals()
            ->take(8)
            ->get();

        if ($newArrivals->isEmpty()) {
            $newArrivals = Product::with(['category', 'fragranceFamily', 'scentNotes'])->active()->latest()->take(8)->get();
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
