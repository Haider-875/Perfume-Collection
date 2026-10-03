<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'badge_text' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,webp,svg|max:2048',
        ]);

        $imagePath = 'assets/images/perfumes/oud_royale.svg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/categories');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/categories/' . $filename;
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'badge_text' => $request->badge_text,
            'sort_order' => $request->sort_order ?? 0,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('category_created', "Created collection category '{$category->name}'", $category);

        return redirect()->route('admin.categories.index')->with('success', "Category '{$category->name}' added.");
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'badge_text' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,webp,svg|max:2048',
        ]);

        $imagePath = $category->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/categories');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/categories/' . $filename;
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'badge_text' => $request->badge_text,
            'sort_order' => $request->sort_order ?? 0,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('category_updated', "Updated category '{$category->name}'", $category);

        return redirect()->route('admin.categories.index')->with('success', "Category '{$category->name}' updated.");
    }

    public function destroy($id)
    {
        $category = Category::withCount('products')->findOrFail($id);

        if ($category->products_count > 0) {
            return redirect()->route('admin.categories.index')->with('error', "Cannot delete '{$category->name}' because it contains {$category->products_count} active fragrances.");
        }

        $name = $category->name;
        $category->delete();

        ActivityLog::record('category_deleted', "Deleted category '{$name}'");

        return redirect()->route('admin.categories.index')->with('success', "Category '{$name}' deleted.");
    }
}
