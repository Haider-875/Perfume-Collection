<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%");
            });
        }

        $blogs = $query->paginate(10)->withQueryString();

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:100',
            'read_time' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,webp,svg|max:2048',
        ]);

        $imagePath = 'assets/images/perfumes/oud_royale.svg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/blogs');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/blogs/' . $filename;
        }

        $blog = Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category' => $request->category,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'author_name' => $request->author_name ?? 'Perfumes Collection Parfumeur',
            'read_time' => $request->read_time ?? '5 min read',
            'image' => $imagePath,
            'is_published' => $request->has('is_published'),
            'published_at' => $request->has('is_published') ? now() : null,
        ]);

        ActivityLog::record('blog_created', "Published fragrance chronicle '{$blog->title}'", $blog);

        return redirect()->route('admin.blogs.index')->with('success', "Chronicle '{$blog->title}' published.");
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:100',
            'read_time' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,webp,svg|max:2048',
        ]);

        $imagePath = $blog->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/blogs');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/blogs/' . $filename;
        }

        $blog->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category' => $request->category,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'author_name' => $request->author_name ?? 'Perfumes Collection Parfumeur',
            'read_time' => $request->read_time ?? '5 min read',
            'image' => $imagePath,
            'is_published' => $request->has('is_published'),
            'published_at' => $request->has('is_published') ? ($blog->published_at ?? now()) : null,
        ]);

        ActivityLog::record('blog_updated', "Updated fragrance chronicle '{$blog->title}'", $blog);

        return redirect()->route('admin.blogs.index')->with('success', "Chronicle '{$blog->title}' updated.");
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $title = $blog->title;
        $blog->delete();

        ActivityLog::record('blog_deleted', "Deleted chronicle '{$title}'");

        return redirect()->route('admin.blogs.index')->with('success', "Chronicle '{$title}' deleted.");
    }
}
