<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Product;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(6);

        $featuredBlog = Blog::where('is_published', true)->first();

        return view('pages.blogs', compact('blogs', 'featuredBlog'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $relatedBlogs = Blog::where('id', '!=', $blog->id)
            ->where('is_published', true)
            ->take(3)
            ->get();

        $featuredFlacons = Product::active()->featured()->take(3)->get();

        return view('pages.blog-detail', compact('blog', 'relatedBlogs', 'featuredFlacons'));
    }
}
