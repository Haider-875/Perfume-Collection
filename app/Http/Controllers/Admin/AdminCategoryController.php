<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->with(['products:id,name,category_id'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Also fetch all products for the assign perfumes modal
        $allProducts = Product::orderBy('name')
            ->with(['category:id,name', 'collections:id,slug,name'])
            ->get(['id', 'name', 'impression_of', 'sku', 'price', 'thumbnail_image', 'category_id', 'is_active']);

        return view('admin.categories.index', compact('categories', 'allProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'badge_text' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,webp,svg|max:2048',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
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

        $slug = Str::slug($request->name);

        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'badge_text' => $request->badge_text,
            'sort_order' => $request->sort_order ?? 0,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        // Auto-create or sync corresponding Collection record so /collections/{slug} works seamlessly
        $collection = Collection::firstOrCreate(
            ['slug' => $slug],
            [
                'name' => $request->name,
                'description' => $request->description,
                'badge_text' => $request->badge_text,
                'image' => $imagePath,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->has('is_active'),
            ]
        );

        // Assign selected products if any
        $assignedCount = 0;
        if ($request->filled('product_ids') && is_array($request->product_ids)) {
            Product::whereIn('id', $request->product_ids)->update(['category_id' => $category->id]);
            if ($collection) {
                $collection->products()->sync($request->product_ids);
            }
            $assignedCount = count($request->product_ids);
        }

        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');

        ActivityLog::record('category_created', "Created category '{$category->name}' with {$assignedCount} assigned perfumes", $category);

        $msg = "Category '{$category->name}' created successfully.";
        if ($assignedCount > 0) {
            $msg .= " ({$assignedCount} perfume(s) assigned).";
        }

        return redirect()->route('admin.categories.index')->with('success', $msg);
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

        $newSlug = Str::slug($request->name);
        $oldSlug = $category->slug;

        $category->update([
            'name' => $request->name,
            'slug' => $newSlug,
            'description' => $request->description,
            'badge_text' => $request->badge_text,
            'sort_order' => $request->sort_order ?? 0,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        // Keep matching collection in sync
        $collection = Collection::where('slug', $oldSlug)->orWhere('slug', $newSlug)->first();
        if ($collection) {
            $collection->update([
                'name' => $request->name,
                'slug' => $newSlug,
                'description' => $request->description,
                'badge_text' => $request->badge_text,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->has('is_active'),
            ]);
        }

        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');

        ActivityLog::record('category_updated', "Updated category '{$category->name}'", $category);

        return redirect()->route('admin.categories.index')->with('success', "Category '{$category->name}' updated.");
    }

    public function updateProducts(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $selectedIds = $request->input('product_ids', []);
        $selectedIds = is_array($selectedIds) ? array_map('intval', $selectedIds) : [];

        // 1. Assign selected products to this category
        if (!empty($selectedIds)) {
            Product::whereIn('id', $selectedIds)->update(['category_id' => $category->id]);
        }

        // 2. Remove category_id from unselected products that previously belonged to this category
        Product::where('category_id', $category->id)
            ->whereNotIn('id', $selectedIds)
            ->update(['category_id' => null]);

        // 3. If there is a matching Collection (e.g. men, women, unisex, exclusive), sync pivot
        $collection = Collection::where('slug', $category->slug)->first();
        if ($collection) {
            $collection->products()->sync($selectedIds);
        }

        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');

        ActivityLog::record('category_products_updated', "Updated assigned perfumes for category '{$category->name}' (" . count($selectedIds) . " perfumes)", $category);

        return redirect()->route('admin.categories.index')->with('success', "Perfumes updated for '{$category->name}': " . count($selectedIds) . " perfume(s) assigned.");
    }

    public function destroy($id)
    {
        $category = Category::withCount('products')->findOrFail($id);
        $name = $category->name;
        $productsCount = $category->products_count;

        // Disassociate products from this category safely (nullOnDelete)
        if ($productsCount > 0) {
            $category->products()->update(['category_id' => null]);
        }

        // Clean up uploaded image if exists
        if ($category->image && Str::startsWith($category->image, 'uploads/categories/')) {
            $fullPath = public_path($category->image);
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }

        $category->delete();

        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');

        ActivityLog::record('category_deleted', "Deleted category '{$name}'" . ($productsCount > 0 ? " ({$productsCount} associated fragrances unassigned)" : ""));

        $msg = "Category '{$name}' deleted successfully.";
        if ($productsCount > 0) {
            $msg .= " ({$productsCount} associated fragrances unassigned).";
        }

        return redirect()->route('admin.categories.index')->with('success', $msg);
    }
}
