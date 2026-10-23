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
        self::ensureCoreCategoriesExist();

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

    /**
     * Guarantees core categories (Men, Women, Unisex, Exclusive) always exist with proper products & collections
     */
    public static function ensureCoreCategoriesExist()
    {
        $coreCategories = [
            'men' => [
                'name' => 'Men',
                'description' => "Commanding, smoky leather, aromatic woods, and rich spices.",
                'badge_text' => 'Power & Sillage',
                'image' => 'assets/images/categories/collection_signature.jpg',
                'sort_order' => 1,
            ],
            'women' => [
                'name' => 'Women',
                'description' => "Sensual florals, luscious gourmands, and luminous amber extraits.",
                'badge_text' => 'Sensual & Radiant',
                'image' => 'assets/images/categories/collection_signature.jpg',
                'sort_order' => 2,
            ],
            'unisex' => [
                'name' => 'Unisex',
                'description' => "Transcendent compositions balancing ambergris, warm woods, and precious resins.",
                'badge_text' => 'Transcendent',
                'image' => 'assets/images/categories/collection_signature.jpg',
                'sort_order' => 3,
            ],
            'exclusive' => [
                'name' => 'Exclusive',
                'description' => "Hand-macerated private reserve formulations for connoisseurs.",
                'badge_text' => 'Private Reserve',
                'image' => 'assets/images/categories/collection_signature.jpg',
                'sort_order' => 4,
            ],
        ];

        foreach ($coreCategories as $slug => $data) {
            $cat = Category::where('slug', $slug)->first();
            if (!$cat) {
                $cat = Category::create([
                    'name' => $data['name'],
                    'slug' => $slug,
                    'description' => $data['description'],
                    'badge_text' => $data['badge_text'],
                    'image' => $data['image'],
                    'sort_order' => $data['sort_order'],
                    'is_active' => true,
                ]);
            }

            // Ensure matching Collection exists
            $col = Collection::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'badge_text' => $data['badge_text'],
                    'image' => $data['image'],
                    'sort_order' => $data['sort_order'],
                    'is_active' => true,
                ]
            );

            // If category has 0 products but collection has products, sync them
            if ($cat->products()->count() === 0 && $col) {
                $pIds = $col->products()->pluck('products.id')->toArray();
                if (!empty($pIds)) {
                    Product::whereIn('id', $pIds)->whereNull('category_id')->update(['category_id' => $cat->id]);
                }
            }
        }

        // Auto-heal Exclusive Category & Collection on Wasmer / Production
        $exclusiveCat = Category::where('slug', 'exclusive')->first();
        $exclusiveCol = Collection::where('slug', 'exclusive')->first();
        if ($exclusiveCat && $exclusiveCol) {
            $exclusiveNames = [
                'Lattafa Khumrah', 'Eclair', 'Marjaan', '9PM Night Out', 
                'Sentinal', 'Xerjoff Naxos', 'Silk Musk', '91 Sports', 
                '91 Degree', '91 Gold Edition'
            ];
            $targetProductIds = Product::where(function($q) use ($exclusiveNames) {
                foreach ($exclusiveNames as $name) {
                    $q->orWhere('name', 'like', '%' . $name . '%');
                }
            })->pluck('id')->toArray();

            if (!empty($targetProductIds)) {
                Product::whereIn('id', $targetProductIds)->update(['category_id' => $exclusiveCat->id]);
                $exclusiveCol->products()->sync($targetProductIds);
            }
        }

        // Auto-heal database longevity strings (ensure no 14+ or 16+ or 18+ remains in DB on Wasmer)
        Product::where('longevity', 'LIKE', '%14%')
            ->orWhere('longevity', 'LIKE', '%16%')
            ->orWhere('longevity', 'LIKE', '%18%')
            ->orWhere('longevity', 'LIKE', '%12-16%')
            ->update(['longevity' => '8-10 Hours (Long Lasting)']);
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

        $imagePath = 'assets/images/categories/collection_signature.jpg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/categories');
            if (!\Illuminate\Support\Facades\File::isDirectory($destinationPath)) {
                \Illuminate\Support\Facades\File::makeDirectory($destinationPath, 0775, true, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/categories/' . $filename;
            \App\Models\UploadedFile::storeFromPath($imagePath);
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
        if ($collection && $collection->image !== $imagePath) {
            $collection->update(['image' => $imagePath]);
        }

        // Assign selected products if any
        $assignedCount = 0;
        if ($request->filled('product_ids') && is_array($request->product_ids)) {
            Product::whereIn('id', $request->product_ids)->update(['category_id' => $category->id]);
            if ($collection) {
                $collection->products()->sync($request->product_ids);
            }
            $assignedCount = count($request->product_ids);
        }

        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v3');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v2');
        \Illuminate\Support\Facades\Cache::flush();

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
            if (!\Illuminate\Support\Facades\File::isDirectory($destinationPath)) {
                \Illuminate\Support\Facades\File::makeDirectory($destinationPath, 0775, true, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/categories/' . $filename;
            \App\Models\UploadedFile::storeFromPath($imagePath);
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

        // Keep matching collection in sync including image
        $collection = Collection::where('slug', $oldSlug)->orWhere('slug', $newSlug)->first();
        if ($collection) {
            $collection->update([
                'name' => $request->name,
                'slug' => $newSlug,
                'description' => $request->description,
                'badge_text' => $request->badge_text,
                'image' => $imagePath,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->has('is_active'),
            ]);
        }

        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v3');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v2');
        \Illuminate\Support\Facades\Cache::flush();

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

        // 2. Safely reassign unselected products that previously belonged to this category
        $removedProducts = Product::where('category_id', $category->id)
            ->whereNotIn('id', $selectedIds)
            ->get();
        foreach ($removedProducts as $rem) {
            $fallbackSlug = strtolower($rem->gender ?? 'unisex');
            $fallbackCat = Category::where('slug', $fallbackSlug)->first() ?? Category::where('slug', 'unisex')->first();
            $rem->update(['category_id' => $fallbackCat ? $fallbackCat->id : null]);
        }

        // 3. If there is a matching Collection (e.g. men, women, unisex, exclusive), sync pivot
        $collection = Collection::where('slug', $category->slug)->first();
        if ($collection) {
            $collection->products()->sync($selectedIds);
        }

        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v3');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v2');
        \Illuminate\Support\Facades\Cache::flush();

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

        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v3');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v2');
        \Illuminate\Support\Facades\Cache::flush();

        ActivityLog::record('category_deleted', "Deleted category '{$name}'" . ($productsCount > 0 ? " ({$productsCount} associated fragrances unassigned)" : ""));

        $msg = "Category '{$name}' deleted successfully.";
        if ($productsCount > 0) {
            $msg .= " ({$productsCount} associated fragrances unassigned).";
        }

        return redirect()->route('admin.categories.index')->with('success', $msg);
    }
}
