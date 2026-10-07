<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ScentNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id') ?? $request->input('category');
        $gender = $request->input('gender');
        $stockStatus = $request->input('stock_status');

        $query = Product::with(['category', 'variants', 'images'])->latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('impression_of', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('tagline', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        if ($stockStatus === 'low' || $stockStatus === 'low_stock') {
            $query->where('stock', '<=', 10)->where('stock', '>', 0);
        } elseif ($stockStatus === 'out' || $stockStatus === 'out_of_stock') {
            $query->where('stock', '<=', 0);
        } elseif ($stockStatus === 'in' || $stockStatus === 'in_stock') {
            $query->where('stock', '>', 10);
        }

        $products = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('sort_order')->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'search', 'categoryId', 'gender', 'stockStatus'));
    }

    public function create()
    {
        $categories = Category::all();
        $collections = Collection::all();
        $scentNotes = ScentNote::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'collections', 'scentNotes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'impression_of' => ['nullable', 'string', 'max:200'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku'],
            'stock' => ['required', 'integer', 'min:0'],
            'volume_ml' => ['nullable', 'integer', 'min:1'],
            'gender' => ['nullable', 'in:Unisex,Men,Women'],
            'concentration' => ['nullable', 'string', 'max:100'],
            'longevity' => ['nullable', 'string', 'max:100'],
            'sillage' => ['nullable', 'string', 'max:100'],
            'season' => ['nullable', 'string', 'max:100'],
            'top_notes' => ['nullable', 'string', 'max:500'],
            'heart_notes' => ['nullable', 'string', 'max:500'],
            'base_notes' => ['nullable', 'string', 'max:500'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:150'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable'],
            'is_featured' => ['nullable'],
            'is_bestseller' => ['nullable'],
            'is_best_seller' => ['nullable'],
            'is_new_arrival' => ['nullable'],
            'primary_image' => ['nullable', 'image', 'max:4096'],
        ]);

        $slug = Str::slug($validated['name']);
        if (Product::where('slug', $slug)->exists()) {
            $slug .= '-' . rand(100, 999);
        }

        $imagePath = 'assets/images/perfumes/oud_royale.svg';
        if ($request->hasFile('primary_image')) {
            $file = $request->file('primary_image');
            $filename = 'prod_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/products');
            if (!File::isDirectory($dest)) File::makeDirectory($dest, 0755, true, true);
            $file->move($dest, $filename);
            $imagePath = 'uploads/products/' . $filename;
        }

        $isBestseller = $request->has('is_bestseller') || $request->has('is_best_seller');

        $product = Product::create([
            'name' => $validated['name'],
            'impression_of' => $request->input('impression_of'),
            'slug' => $slug,
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'compare_at_price' => $request->input('compare_at_price'),
            'sale_price' => $request->input('sale_price') ?? $validated['price'],
            'sku' => strtoupper($validated['sku']),
            'stock' => $validated['stock'],
            'in_stock' => $validated['stock'] > 0,
            'volume_ml' => $request->input('volume_ml', 100),
            'gender' => $request->input('gender', 'Unisex'),
            'concentration' => $validated['concentration'] ?? 'Extrait de Parfum (35% Oil)',
            'longevity' => $request->input('longevity', '14+ Hours Beast Mode'),
            'sillage' => $request->input('sillage', 'Heavy / Room-Filling'),
            'season' => $request->input('season', 'All Seasons / Signature'),
            'top_notes_summary' => $request->input('top_notes'),
            'heart_notes_summary' => $request->input('heart_notes'),
            'base_notes_summary' => $request->input('base_notes'),
            'tagline' => $validated['tagline'] ?? null,
            'description' => $validated['description'] ?? null,
            'thumbnail_image' => $imagePath,
            'meta_title' => $request->input('meta_title') ?? ($validated['name'] . ' | Ravaha Fragrances Pakistan'),
            'meta_description' => $request->input('meta_description'),
            'is_active' => $request->has('is_active'),
            'is_featured' => $request->has('is_featured'),
            'is_bestseller' => $isBestseller,
            'is_new_arrival' => $request->has('is_new_arrival'),
        ]);

        // Attach collections if provided, or auto-sync matching collection from category
        if ($request->has('collections') && is_array($request->collections)) {
            $product->collections()->sync($request->collections);
        } else {
            $selectedCat = Category::find($product->category_id);
            if ($selectedCat) {
                $matchingCol = Collection::where('slug', $selectedCat->slug)->first();
                if ($matchingCol) {
                    $product->collections()->syncWithoutDetaching([$matchingCol->id]);
                }
            }
        }

        // Handle dynamic variant rows if provided
        if ($request->has('variant_size') && is_array($request->variant_size)) {
            foreach ($request->variant_size as $idx => $size) {
                if (empty($size)) continue;
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size_label' => $size,
                    'volume_ml' => (int)filter_var($size, FILTER_SANITIZE_NUMBER_INT) ?: 50,
                    'sku' => $request->variant_sku[$idx] ?? ($product->sku . '-' . $idx),
                    'price' => $request->variant_price[$idx] ?? $product->price,
                    'stock' => $request->variant_stock[$idx] ?? 20,
                    'is_default' => $idx === 0,
                ]);
            }
        } else {
            // Standard sizes: 50ml, 100ml, 10ml Tester
            ProductVariant::create([
                'product_id' => $product->id,
                'size_label' => '50ml Flacon',
                'volume_ml' => 50,
                'price' => $product->price,
                'sku' => $product->sku . '-50ML',
                'stock' => $product->stock,
                'is_default' => true,
            ]);

            ProductVariant::create([
                'product_id' => $product->id,
                'size_label' => '100ml Flacon',
                'volume_ml' => 100,
                'price' => round($product->price * 1.55),
                'sku' => $product->sku . '-100ML',
                'stock' => max(5, round($product->stock * 0.7)),
                'is_default' => false,
            ]);

            ProductVariant::create([
                'product_id' => $product->id,
                'size_label' => '10ml Travel Tester',
                'volume_ml' => 10,
                'price' => max(650, round($product->price * 0.28)),
                'sku' => $product->sku . '-10ML',
                'stock' => 50,
                'is_default' => false,
            ]);
        }

        ActivityLog::record('product_created', "Added fragrance [{$product->name}] (" . ($product->impression_of ? "Impression of {$product->impression_of}" : "Signature") . ") with SKU {$product->sku}", $product);

        return redirect()->route('admin.products.index')->with('success', "Fragrance [{$product->name}] successfully added to catalog.");
    }

    public function edit($id)
    {
        $product = Product::with(['variants', 'images', 'category', 'collections'])->findOrFail($id);
        $categories = Category::all();
        $collections = Collection::all();

        return view('admin.products.edit', compact('product', 'categories', 'collections'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'impression_of' => ['nullable', 'string', 'max:200'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku,' . $product->id],
            'stock' => ['required', 'integer', 'min:0'],
            'volume_ml' => ['nullable', 'integer', 'min:1'],
            'gender' => ['nullable', 'in:Unisex,Men,Women'],
            'concentration' => ['nullable', 'string', 'max:100'],
            'longevity' => ['nullable', 'string', 'max:100'],
            'sillage' => ['nullable', 'string', 'max:100'],
            'season' => ['nullable', 'string', 'max:100'],
            'top_notes' => ['nullable', 'string', 'max:500'],
            'heart_notes' => ['nullable', 'string', 'max:500'],
            'base_notes' => ['nullable', 'string', 'max:500'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:150'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable'],
            'is_featured' => ['nullable'],
            'is_bestseller' => ['nullable'],
            'is_best_seller' => ['nullable'],
            'is_new_arrival' => ['nullable'],
            'primary_image' => ['nullable', 'image', 'max:4096'],
        ]);

        $oldPrice = $product->price;

        if ($request->hasFile('primary_image')) {
            $file = $request->file('primary_image');
            $filename = 'prod_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/products');
            if (!File::isDirectory($dest)) File::makeDirectory($dest, 0755, true, true);
            $file->move($dest, $filename);
            $product->thumbnail_image = 'uploads/products/' . $filename;
        }

        $isBestseller = $request->has('is_bestseller') || $request->has('is_best_seller');

        $product->name = $validated['name'];
        $product->impression_of = $request->input('impression_of');
        $product->category_id = $validated['category_id'];
        $product->price = $validated['price'];
        $product->compare_at_price = $request->input('compare_at_price');
        $product->sale_price = $request->input('sale_price') ?? $validated['price'];
        $product->sku = strtoupper($validated['sku']);
        $product->stock = $validated['stock'];
        $product->in_stock = $validated['stock'] > 0;
        $product->volume_ml = $request->input('volume_ml', $product->volume_ml ?? 100);
        $product->gender = $request->input('gender', $product->gender);
        $product->concentration = $validated['concentration'] ?? $product->concentration;
        $product->longevity = $request->input('longevity', $product->longevity);
        $product->sillage = $request->input('sillage', $product->sillage);
        $product->season = $request->input('season', $product->season);
        $product->top_notes_summary = $request->input('top_notes', $product->top_notes_summary);
        $product->heart_notes_summary = $request->input('heart_notes', $product->heart_notes_summary);
        $product->base_notes_summary = $request->input('base_notes', $product->base_notes_summary);
        $product->tagline = $validated['tagline'] ?? $product->tagline;
        $product->description = $validated['description'] ?? $product->description;
        $product->meta_title = $request->input('meta_title', $product->meta_title);
        $product->meta_description = $request->input('meta_description', $product->meta_description);
        $product->is_active = $request->has('is_active');
        $product->is_featured = $request->has('is_featured');
        $product->is_bestseller = $isBestseller;
        $product->is_new_arrival = $request->has('is_new_arrival');
        $product->save();

        if ($request->has('collections') && is_array($request->collections)) {
            $product->collections()->sync($request->collections);
        } else {
            $selectedCat = Category::find($product->category_id);
            if ($selectedCat) {
                $matchingCol = Collection::where('slug', $selectedCat->slug)->first();
                if ($matchingCol) {
                    $product->collections()->syncWithoutDetaching([$matchingCol->id]);
                }
            }
        }

        // Update variants if provided
        if ($request->has('variant_size') && is_array($request->variant_size)) {
            // Delete old and re-create for clean state
            $product->variants()->delete();
            foreach ($request->variant_size as $idx => $size) {
                if (empty($size)) continue;
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size_label' => $size,
                    'volume_ml' => (int)filter_var($size, FILTER_SANITIZE_NUMBER_INT) ?: 50,
                    'sku' => $request->variant_sku[$idx] ?? ($product->sku . '-' . $idx),
                    'price' => $request->variant_price[$idx] ?? $product->price,
                    'stock' => $request->variant_stock[$idx] ?? 20,
                    'is_default' => $idx === 0,
                ]);
            }
        }

        if ($oldPrice != $product->price) {
            ActivityLog::record('price_change', "Price updated for [{$product->name}] from Rs. {$oldPrice} to Rs. {$product->price}", $product, [
                'old_price' => $oldPrice,
                'new_price' => $product->price
            ]);
        } else {
            ActivityLog::record('product_updated', "Updated product specifications for [{$product->name}]", $product);
        }

        return redirect()->route('admin.products.index')->with('success', "Fragrance [{$product->name}] updated successfully.");
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $name = $product->name;
        $product->delete();

        ActivityLog::record('product_deleted', "Deleted perfume [{$name}] from catalog");

        return back()->with('success', "Fragrance [{$name}] deleted from catalog.");
    }

    public function exportCsv()
    {
        $products = Product::with('category')->get();
        $filename = 'ravaha_perfumes_catalog_' . date('Y_m_d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($products) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Impression Of', 'SKU', 'Category', 'Price (PKR)', 'Compare Price', 'Stock', 'Volume ML', 'Gender', 'Concentration', 'Longevity', 'Sillage', 'Tagline', 'Active']);

            foreach ($products as $p) {
                fputcsv($handle, [
                    $p->id,
                    $p->name,
                    $p->impression_of ?? '',
                    $p->sku,
                    $p->category?->name ?? 'Fragrance',
                    $p->price,
                    $p->compare_at_price ?? '',
                    $p->stock,
                    $p->volume_ml,
                    $p->gender,
                    $p->concentration,
                    $p->longevity,
                    $p->sillage,
                    $p->tagline ?? '',
                    $p->is_active ? 'Yes' : 'No',
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importView()
    {
        return view('admin.products.import');
    }

    public function importProcess(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:8192'],
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $handle = fopen($path, 'r');

        $header = fgetcsv($handle, 2000, ',');
        if (!$header) {
            return back()->with('error', 'The uploaded CSV file is empty or corrupted.');
        }

        $createdCount = 0;
        $updatedCount = 0;
        $errors = [];
        $rowNumber = 1;

        $defaultCategory = Category::firstOrCreate(['name' => 'Signature Impressions'], ['slug' => 'signature-impressions']);

        while (($data = fgetcsv($handle, 2000, ',')) !== false) {
            $rowNumber++;
            if (count($data) < 3) continue;

            $name = trim($data[0] ?? '');
            $impressionOf = trim($data[1] ?? '');
            $sku = trim($data[2] ?? '');
            $price = (float)($data[3] ?? 0);
            $stock = (int)($data[4] ?? 20);
            $categoryName = trim($data[5] ?? 'Signature Impressions');
            $gender = trim($data[6] ?? 'Unisex');

            if (empty($name) || empty($sku) || $price <= 0) {
                $errors[] = "Row {$rowNumber}: Missing Name, SKU, or valid Price.";
                continue;
            }

            $category = Category::where('name', $categoryName)->first() ?? $defaultCategory;

            $existing = Product::where('sku', $sku)->first();
            if ($existing) {
                $existing->name = $name;
                $existing->impression_of = $impressionOf;
                $existing->price = $price;
                $existing->stock = $stock;
                $existing->in_stock = $stock > 0;
                $existing->category_id = $category->id;
                $existing->gender = in_array($gender, ['Men', 'Women', 'Unisex']) ? $gender : 'Unisex';
                $existing->save();
                $updatedCount++;
            } else {
                $slug = Str::slug($name);
                if (Product::where('slug', $slug)->exists()) $slug .= '-' . rand(100, 999);

                Product::create([
                    'name' => $name,
                    'impression_of' => $impressionOf,
                    'slug' => $slug,
                    'sku' => $sku,
                    'price' => $price,
                    'stock' => $stock,
                    'in_stock' => $stock > 0,
                    'category_id' => $category->id,
                    'gender' => in_array($gender, ['Men', 'Women', 'Unisex']) ? $gender : 'Unisex',
                    'volume_ml' => 100,
                    'concentration' => 'Extrait de Parfum (35% Oil)',
                    'longevity' => '14+ Hours Beast Mode',
                    'sillage' => 'Heavy / Room-Filling',
                    'thumbnail_image' => 'assets/images/perfumes/oud_royale.svg',
                    'is_active' => true,
                ]);
                $createdCount++;
            }
        }

        fclose($handle);

        ActivityLog::record('imported', "Imported CSV product catalogue ({$createdCount} created, {$updatedCount} updated)");

        return back()->with('success', "CSV Import Complete: {$createdCount} new creations created, {$updatedCount} updated.")
            ->with('import_errors', $errors);
    }

    public function sampleCsv()
    {
        $filename = 'ravaha_sample_product_template.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Name', 'Impression Of', 'SKU', 'Price', 'Stock', 'Category', 'Gender']);
            fputcsv($handle, ['Santal Desire', 'Santal 33 by Le Labo', 'RVH-SAN-01', '3450', '30', 'Woody & Smoky', 'Unisex']);
            fputcsv($handle, ['Baroque Rouge 540', 'Baccarat Rouge 540 by MFK', 'RVH-BR-02', '3850', '25', 'Amber & Oriental', 'Unisex']);
            fputcsv($handle, ['Gentleman Pride', 'Tuxedo by YSL', 'RVH-TUX-03', '3650', '20', 'Men Impressions', 'Men']);
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $productIds = $request->input('product_ids', []);

        if (empty($productIds)) {
            return back()->with('error', 'No products selected.');
        }

        if ($action === 'activate') {
            Product::whereIn('id', $productIds)->update(['is_active' => true]);
            ActivityLog::record('bulk_activated', "Bulk activated " . count($productIds) . " products");
            return back()->with('success', count($productIds) . " fragrances activated.");
        } elseif ($action === 'deactivate') {
            Product::whereIn('id', $productIds)->update(['is_active' => false]);
            ActivityLog::record('bulk_deactivated', "Bulk deactivated " . count($productIds) . " products");
            return back()->with('success', count($productIds) . " fragrances set to draft.");
        } elseif ($action === 'delete') {
            Product::whereIn('id', $productIds)->delete();
            ActivityLog::record('bulk_deleted', "Bulk deleted " . count($productIds) . " products");
            return back()->with('success', count($productIds) . " fragrances deleted.");
        }

        return back()->with('error', 'Invalid bulk action.');
    }
}
