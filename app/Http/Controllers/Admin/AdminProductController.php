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
        $categoryId = $request->input('category_id');
        $stockStatus = $request->input('stock_status');

        $query = Product::with(['category', 'variants', 'images'])->latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('scent_family', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($stockStatus === 'low') {
            $query->where('stock', '<=', 10)->where('stock', '>', 0);
        } elseif ($stockStatus === 'out') {
            $query->where('stock', '<=', 0);
        } elseif ($stockStatus === 'in') {
            $query->where('stock', '>', 10);
        }

        $products = $query->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories', 'search', 'categoryId', 'stockStatus'));
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
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku'],
            'stock' => ['required', 'integer', 'min:0'],
            'volume_ml' => ['nullable', 'integer', 'min:1'],
            'concentration' => ['nullable', 'string', 'max:100'],
            'scent_family' => ['nullable', 'string', 'max:100'],
            'longevity' => ['nullable', 'string', 'max:100'],
            'sillage' => ['nullable', 'string', 'max:100'],
            'longevity_rating' => ['nullable', 'integer', 'min:1', 'max:10'],
            'sillage_rating' => ['nullable', 'integer', 'min:1', 'max:10'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'seo_title' => ['nullable', 'string', 'max:150'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable'],
            'is_featured' => ['nullable'],
            'primary_image' => ['nullable', 'image', 'max:4096'],
        ]);

        $slug = Str::slug($validated['name']);
        if (Product::where('slug', $slug)->exists()) {
            $slug .= '-' . rand(100, 999);
        }

        $imagePath = 'assets/images/perfumes/imperial_motia.svg';
        if ($request->hasFile('primary_image')) {
            $file = $request->file('primary_image');
            $filename = 'prod_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/products');
            if (!File::isDirectory($dest)) File::makeDirectory($dest, 0755, true, true);
            $file->move($dest, $filename);
            $imagePath = 'uploads/products/' . $filename;
        }

        $product = Product::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'compare_at_price' => $request->input('compare_at_price') ?? $request->input('sale_price'),
            'sale_price' => $request->input('sale_price') ?? $request->input('compare_at_price'),
            'sku' => strtoupper($validated['sku']),
            'stock' => $validated['stock'],
            'volume_ml' => $request->input('volume_ml', 50),
            'concentration' => $validated['concentration'] ?? '40% Extrait de Parfum',
            'scent_family' => $validated['scent_family'] ?? 'Oriental Woody',
            'longevity' => $request->input('longevity', '10-12+ Hours'),
            'sillage' => $request->input('sillage', 'Enormous / Heavy'),
            'longevity_rating' => $validated['longevity_rating'] ?? 9,
            'sillage_rating' => $validated['sillage_rating'] ?? 9,
            'tagline' => $validated['tagline'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'thumbnail_image' => $imagePath,
            'seo_title' => $validated['seo_title'] ?? $validated['name'] . ' | Perfumes Collection Pakistan',
            'seo_description' => $validated['seo_description'] ?? null,
            'is_active' => $request->has('is_active'),
            'is_featured' => $request->has('is_featured'),
        ]);

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
            ProductVariant::create([
                'product_id' => $product->id,
                'size_label' => $product->volume_ml . 'ml Extrait Flacon',
                'volume_ml' => $product->volume_ml,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'sku' => $product->sku . '-STD',
                'stock' => $product->stock,
                'is_default' => true,
            ]);
        }

        ActivityLog::record('product_created', "Added new luxury perfume [{$product->name}] with SKU {$product->sku}", $product);

        return redirect()->route('admin.products.index')->with('success', "Perfume creation [{$product->name}] added to vault successfully.");
    }

    public function edit($id)
    {
        $product = Product::with(['variants', 'images', 'category'])->findOrFail($id);
        $categories = Category::all();
        $collections = Collection::all();

        return view('admin.products.edit', compact('product', 'categories', 'collections'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku,' . $product->id],
            'stock' => ['required', 'integer', 'min:0'],
            'volume_ml' => ['required', 'integer', 'min:1'],
            'concentration' => ['nullable', 'string', 'max:100'],
            'scent_family' => ['nullable', 'string', 'max:100'],
            'longevity_rating' => ['nullable', 'integer', 'min:1', 'max:10'],
            'sillage_rating' => ['nullable', 'integer', 'min:1', 'max:10'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'primary_image' => ['nullable', 'image', 'max:4096'],
        ]);

        $oldPrice = $product->price;

        if ($request->hasFile('primary_image')) {
            $file = $request->file('primary_image');
            $filename = 'prod_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/products');
            if (!File::isDirectory($dest)) File::makeDirectory($dest, 0755, true, true);
            $file->move($dest, $filename);
            $product->image = 'uploads/products/' . $filename;
        }

        $product->name = $validated['name'];
        $product->category_id = $validated['category_id'];
        $product->price = $validated['price'];
        $product->sale_price = $validated['sale_price'] ?? null;
        $product->sku = $validated['sku'];
        $product->stock = $validated['stock'];
        $product->volume_ml = $validated['volume_ml'];
        $product->concentration = $validated['concentration'] ?? $product->concentration;
        $product->scent_family = $validated['scent_family'] ?? $product->scent_family;
        $product->longevity_rating = $validated['longevity_rating'] ?? $product->longevity_rating;
        $product->sillage_rating = $validated['sillage_rating'] ?? $product->sillage_rating;
        $product->tagline = $validated['tagline'] ?? $product->tagline;
        $product->description = $validated['description'] ?? $product->description;
        $product->is_active = $request->boolean('is_active');
        $product->is_featured = $request->boolean('is_featured');
        $product->save();

        if ($oldPrice != $product->price) {
            ActivityLog::record('price_change', "Modified price for [{$product->name}] from Rs. {$oldPrice} to Rs. {$product->price}", $product, [
                'old_price' => $oldPrice,
                'new_price' => $product->price
            ]);
        } else {
            ActivityLog::record('updated', "Updated product specifications for [{$product->name}]", $product);
        }

        return redirect()->route('admin.products.index')->with('success', "Perfume creation [{$product->name}] updated.");
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $name = $product->name;
        $product->delete();

        ActivityLog::record('deleted', "Deleted perfume [{$name}] from vault");

        return back()->with('success', "Perfume [{$name}] removed from catalogue.");
    }

    public function exportCsv()
    {
        $products = Product::with('category')->get();
        $filename = 'perfumes_collection_catalog_' . date('Y_m_d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($products) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'SKU', 'Category', 'Price (PKR)', 'Sale Price', 'Stock', 'Volume ML', 'Concentration', 'Scent Family', 'Longevity (1-10)', 'Sillage (1-10)', 'Tagline', 'Active']);

            foreach ($products as $p) {
                fputcsv($handle, [
                    $p->id,
                    $p->name,
                    $p->sku,
                    $p->category?->name ?? 'Extrait',
                    $p->price,
                    $p->sale_price ?? '',
                    $p->stock,
                    $p->volume_ml,
                    $p->concentration,
                    $p->scent_family,
                    $p->longevity_rating,
                    $p->sillage_rating,
                    $p->tagline,
                    $p->is_active ? 'Yes' : 'No',
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importView()
    {
        return $this->showImportForm();
    }

    public function showImportForm()
    {
        return view('admin.products.import');
    }

    public function importProcess(Request $request)
    {
        return $this->importCsv($request);
    }

    public function importCsv(Request $request)
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

        $defaultCategory = Category::firstOrCreate(['name' => 'Royal Extraits'], ['slug' => 'royal-extraits']);

        while (($data = fgetcsv($handle, 2000, ',')) !== false) {
            $rowNumber++;
            if (count($data) < 3) continue;

            $name = trim($data[0] ?? '');
            $sku = trim($data[1] ?? '');
            $price = (float)($data[2] ?? 0);
            $stock = (int)($data[3] ?? 20);
            $categoryName = trim($data[4] ?? 'Royal Extraits');
            $volume = (int)($data[5] ?? 50);
            $family = trim($data[6] ?? 'Oriental Woody');
            $tagline = trim($data[7] ?? '');

            if (empty($name) || empty($sku) || $price <= 0) {
                $errors[] = "Row {$rowNumber}: Missing Name, SKU, or valid Price.";
                continue;
            }

            $category = Category::where('name', $categoryName)->first() ?? $defaultCategory;

            $existing = Product::where('sku', $sku)->first();
            if ($existing) {
                $existing->name = $name;
                $existing->price = $price;
                $existing->stock = $stock;
                $existing->category_id = $category->id;
                $existing->volume_ml = $volume;
                $existing->scent_family = $family;
                if ($tagline) $existing->tagline = $tagline;
                $existing->save();
                $updatedCount++;
            } else {
                $slug = Str::slug($name);
                if (Product::where('slug', $slug)->exists()) $slug .= '-' . rand(100, 999);

                Product::create([
                    'name' => $name,
                    'slug' => $slug,
                    'sku' => $sku,
                    'price' => $price,
                    'stock' => $stock,
                    'category_id' => $category->id,
                    'volume_ml' => $volume,
                    'scent_family' => $family,
                    'tagline' => $tagline ?: "Hand-macerated pure extrait concentration.",
                    'concentration' => '40% Extrait de Parfum',
                    'longevity_rating' => 9,
                    'sillage_rating' => 9,
                    'image' => 'assets/images/perfumes/imperial_motia.svg',
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
        return $this->downloadSampleCsv();
    }

    public function downloadSampleCsv()
    {
        $filename = 'perfumes_collection_sample_template.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Name', 'SKU', 'Price', 'Stock', 'Category', 'Volume_ML', 'Scent_Family', 'Tagline']);
            fputcsv($handle, ['Royal Cambodian Oud Extrait', 'PC-OUD-01', '24500', '25', 'Royal Extraits', '50', 'Oriental Woody', 'Hydro-distilled 15-year aged Koh Kong Agarwood']);
            fputcsv($handle, ['Taif Rose & Ambergris 1888', 'PC-ROSE-02', '18900', '30', 'French Floral', '50', 'Floral Amber', 'First dawn Taif rose absolute with marine ambergris']);
            fputcsv($handle, ['Mughal Cardamom Noir', 'PC-CARD-03', '14500', '40', 'Warm Spicy', '50', 'Spicy Leather', 'Smoked black cardamom with saffron and tonka bean']);
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
