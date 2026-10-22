<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\PerfumePriceListSampleExport;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductPrice;
use App\Models\ProductVariant;
use App\Models\ScentNote;
use App\Services\PerfumeProductImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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

        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v3');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v2');
        \Illuminate\Support\Facades\Cache::flush();

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
            'hover_image' => ['nullable', 'image', 'max:4096'],
            'gallery_images.*' => ['nullable', 'image', 'max:4096'],
        ]);

        $oldPrice = $product->price;

        if ($request->hasFile('primary_image')) {
            $file = $request->file('primary_image');
            $filename = 'prod_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/products');
            if (!File::isDirectory($dest)) File::makeDirectory($dest, 0755, true, true);
            $file->move($dest, $filename);
            $oldThumb = $product->thumbnail_image;
            $product->thumbnail_image = 'uploads/products/' . $filename;
            $this->safelyDeleteImageFile($oldThumb);
        }

        if ($request->hasFile('hover_image')) {
            $file = $request->file('hover_image');
            $filename = 'hover_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/products');
            if (!File::isDirectory($dest)) File::makeDirectory($dest, 0755, true, true);
            $file->move($dest, $filename);
            $oldHover = $product->hover_image;
            $product->hover_image = 'uploads/products/' . $filename;
            $this->safelyDeleteImageFile($oldHover);
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

        // Upload additional gallery images if provided
        if ($request->hasFile('gallery_images')) {
            $dest = public_path('uploads/products');
            if (!File::isDirectory($dest)) File::makeDirectory($dest, 0755, true, true);
            foreach ($request->file('gallery_images') as $file) {
                if ($file && $file->isValid()) {
                    $filename = 'gallery_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                    $file->move($dest, $filename);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'uploads/products/' . $filename,
                        'alt_text' => $product->name,
                        'sort_order' => $product->images()->count() + 1,
                        'is_primary' => false,
                    ]);
                }
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

        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v3');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v2');
        \Illuminate\Support\Facades\Cache::flush();

        return redirect()->route('admin.products.index')->with('success', "Fragrance [{$product->name}] updated successfully.");
    }

    /**
     * Remove an extra gallery image from a product and safely delete the file if unused
     */
    public function destroyGalleryImage($productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = ProductImage::where('product_id', $product->id)->where('id', $imageId)->firstOrFail();

        $path = $image->image_path;
        $image->delete();

        $this->safelyDeleteImageFile($path);

        ActivityLog::record('image_deleted', "Removed gallery image for product [{$product->name}]", $product);

        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v3');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v2');
        \Illuminate\Support\Facades\Cache::flush();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Gallery image removed successfully.']);
        }

        return back()->with('success', 'Gallery image removed successfully.');
    }

    /**
     * Remove a primary (thumbnail) or hover image from a product and safely clean up file
     */
    public function removeSpecialImage($productId, Request $request)
    {
        $product = Product::findOrFail($productId);
        $type = $request->input('type');

        if ($type === 'primary') {
            $path = $product->thumbnail_image;
            $product->thumbnail_image = null;
            $product->save();
            $this->safelyDeleteImageFile($path);
            ActivityLog::record('image_deleted', "Removed primary image for product [{$product->name}]", $product);
            $msg = 'Primary image removed successfully.';
        } elseif ($type === 'hover') {
            $path = $product->hover_image;
            $product->hover_image = null;
            $product->save();
            $this->safelyDeleteImageFile($path);
            ActivityLog::record('image_deleted', "Removed hover image for product [{$product->name}]", $product);
            $msg = 'Hover image removed successfully.';
        } else {
            return back()->with('error', 'Invalid image type requested for removal.');
        }

        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v3');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v2');
        \Illuminate\Support\Facades\Cache::flush();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }

        return back()->with('success', $msg);
    }

    /**
     * Accidental Data Loss Prevention: Safely delete an uploaded image file ONLY if not used elsewhere
     */
    protected function safelyDeleteImageFile(?string $path): void
    {
        if (!$path) return;

        // Never delete system/theme default assets
        if (!str_starts_with($path, 'uploads/')) {
            return;
        }

        // Verify no other product or gallery item references this file
        $inProductsThumb = Product::where('thumbnail_image', $path)->exists();
        $inProductsHover = Product::where('hover_image', $path)->exists();
        $inGallery = ProductImage::where('image_path', $path)->exists();

        if (!$inProductsThumb && !$inProductsHover && !$inGallery) {
            $fullPath = public_path($path);
            if (File::exists($fullPath) && is_file($fullPath)) {
                File::delete($fullPath);
            }
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $name = $product->name;
        $product->delete();

        ActivityLog::record('product_deleted', "Deleted perfume [{$name}] from catalog");

        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v3');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v1');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data_v2');
        \Illuminate\Support\Facades\Cache::flush();

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
        $lastSummary = session('last_import_summary');
        $hasErrorReport = session()->has('import_error_report');

        return view('admin.products.import', compact('lastSummary', 'hasErrorReport'));
    }

    public function importPreview(Request $request, PerfumeProductImportService $importService)
    {
        $request->validate([
            'import_file' => ['required', 'file', 'mimes:xlsx,xls,csv,txt', 'max:10240'],
            'duplicate_handling' => ['nullable', 'in:update,skip,create'],
        ], [
            'import_file.required' => 'Please select an Excel (.xlsx, .xls) or CSV file to upload.',
            'import_file.mimes' => 'The upload file must be an Excel spreadsheet (.xlsx, .xls) or a CSV file (.csv).',
            'import_file.max' => 'The file size must not exceed 10MB.',
        ]);

        $duplicateHandling = $request->input('duplicate_handling', 'update');
        $file = $request->file('import_file');

        $result = $importService->parseAndValidate($file, $duplicateHandling);

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        $token = Str::random(32);
        $previewData = [
            'filename' => $result['filename'],
            'rows' => $result['rows'],
            'stats' => $result['stats'],
            'duplicate_handling' => $duplicateHandling,
        ];

        session(['import_preview_' . $token => $previewData]);
        \Illuminate\Support\Facades\Cache::put('import_preview_' . $token, $previewData, now()->addHours(2));

        return view('admin.products.import-preview', [
            'importToken' => $token,
            'filename' => $result['filename'],
            'stats' => $result['stats'],
            'rows' => $result['rows'],
            'duplicateHandling' => $duplicateHandling,
        ]);
    }

    public function importConfirm(Request $request, PerfumeProductImportService $importService)
    {
        $request->validate([
            'import_token' => ['required', 'string'],
            'duplicate_handling' => ['required', 'in:update,skip,create'],
        ]);

        $token = $request->input('import_token');
        $sessionKey = 'import_preview_' . $token;
        $sessionData = session($sessionKey) ?? \Illuminate\Support\Facades\Cache::get($sessionKey);

        if (!$sessionData || empty($sessionData['rows'])) {
            return redirect()->route('admin.products.import')
                ->with('error', 'Import session has expired or is invalid. Please re-upload your Excel/CSV file.');
        }

        $duplicateHandling = $request->input('duplicate_handling', $sessionData['duplicate_handling'] ?? 'update');
        $importResult = $importService->executeImport($sessionData['rows'], $duplicateHandling);

        if (!$importResult['success']) {
            return redirect()->route('admin.products.import')
                ->with('error', $importResult['message'] ?? 'Database import failed.');
        }

        if (!empty($importResult['failed_rows'])) {
            session(['import_error_report' => $importResult['failed_rows']]);
        } else {
            session()->forget('import_error_report');
        }

        session([
            'last_import_summary' => [
                'total' => count($sessionData['rows']),
                'created' => $importResult['created_count'],
                'updated' => $importResult['updated_count'],
                'skipped' => $importResult['skipped_count'],
                'failed' => $importResult['failed_count'],
                'has_errors' => !empty($importResult['failed_rows']),
            ]
        ]);

        session()->forget($sessionKey);

        $msg = "Excel Import Complete: {$importResult['created_count']} creations added, {$importResult['updated_count']} updated, {$importResult['skipped_count']} skipped.";
        if ($importResult['failed_count'] > 0) {
            $msg .= " ({$importResult['failed_count']} failed — error report is ready for download).";
        }

        return redirect()->route('admin.products.import')->with('success', $msg);
    }

    public function sampleExcel()
    {
        $filename = 'ravaha_perfume_pricelist_template.xlsx';
        return Excel::download(new PerfumePriceListSampleExport, $filename);
    }

    public function sampleCsv()
    {
        $filename = 'ravaha_perfume_pricelist_template.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Name',
                'Impression Of',
                'SKU',
                'Category',
                'Gender',
                '30ml Price (PKR)',
                '50ml Price (PKR)',
                '60ml Price (PKR)',
                '100ml Price (PKR)',
                'Stock'
            ]);
            fputcsv($handle, ['Oud Royale Extrait', 'Imperial Agarwood & Rose', 'RVH-OUD-01', 'Woody & Oriental', 'Unisex', '1850', '2850', '3450', '4950', '45']);
            fputcsv($handle, ['Baroque Rouge 540', 'Baccarat Rouge 540 by MFK', 'RVH-BR-02', 'Amber & Warm', 'Unisex', '1950', '2950', '3650', '5200', '35']);
            fputcsv($handle, ['Santal Desire', 'Santal 33 by Le Labo', 'RVH-SAN-03', 'Woody & Smoky', 'Unisex', '1750', '2750', '3350', '4800', '40']);
            fputcsv($handle, ['Smoked Birch & Leather', 'Tuscan Leather by Tom Ford', 'RVH-LTHR-04', 'Smoky & Leathery', 'Men', '1850', '2850', '3450', '4950', '30']);
            fputcsv($handle, ['Taif Velvet Rose', 'Velvet Rose & Oud by Jo Malone', 'RVH-ROSE-05', 'Floral & Oriental', 'Women', '1650', '2550', '3150', '4500', '25']);
            fputcsv($handle, ['Murree Mist', 'Silver Mountain Water by Creed', 'RVH-MIST-06', 'Fresh & Citrus', 'Unisex', '1500', '2400', '2950', '4200', '50']);
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadErrorReport()
    {
        $failedRows = session('import_error_report', []);

        if (empty($failedRows)) {
            return back()->with('error', 'No recent import error report found.');
        }

        $filename = 'ravaha_import_errors_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($failedRows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Row Number', 'Perfume Name', 'SKU', 'Failure Reason']);
            foreach ($failedRows as $item) {
                fputcsv($handle, [
                    $item['row'] ?? '',
                    $item['name'] ?? '',
                    $item['sku'] ?? '',
                    $item['reason'] ?? '',
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importProcess(Request $request, PerfumeProductImportService $importService)
    {
        $file = $request->file('import_file') ?? $request->file('csv_file');

        if (!$file) {
            return back()->with('error', 'Please select an Excel or CSV file to import.');
        }

        $duplicateHandling = $request->input('duplicate_handling', 'update');
        $parsed = $importService->parseAndValidate($file, $duplicateHandling);

        if (!$parsed['success']) {
            return back()->with('error', $parsed['message']);
        }

        $importResult = $importService->executeImport($parsed['rows'], $duplicateHandling);

        if (!empty($importResult['failed_rows'])) {
            session(['import_error_report' => $importResult['failed_rows']]);
        }

        session([
            'last_import_summary' => [
                'total' => count($parsed['rows']),
                'created' => $importResult['created_count'],
                'updated' => $importResult['updated_count'],
                'skipped' => $importResult['skipped_count'],
                'failed' => $importResult['failed_count'],
                'has_errors' => !empty($importResult['failed_rows']),
            ]
        ]);

        return back()->with('success', "Import Complete: {$importResult['created_count']} created, {$importResult['updated_count']} updated, {$importResult['skipped_count']} skipped.");
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

    public function quickStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $oldStock = $product->stock;
        $product->stock = (int) $request->stock;
        $product->in_stock = ($product->stock > 0);
        $product->save();

        ActivityLog::record('stock_updated', "Quick restocked '{$product->name}' from {$oldStock} to {$product->stock} bottles", $product);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Stock for '{$product->name}' updated to {$product->stock} bottles.",
                'stock' => $product->stock,
                'in_stock' => $product->in_stock,
            ]);
        }

        return back()->with('success', "Stock for '{$product->name}' updated to {$product->stock} bottles successfully.");
    }

    /**
     * Scan uploaded product images and find unused/orphaned files
     */
    public function unusedImagesIndex()
    {
        $dir = public_path('uploads/products');
        $allFiles = [];
        $unusedFiles = [];
        $totalBytes = 0;
        $unusedBytes = 0;

        if (File::isDirectory($dir)) {
            $files = File::files($dir);

            $usedThumbnails = Product::whereNotNull('thumbnail_image')->pluck('thumbnail_image')->toArray();
            $usedHovers = Product::whereNotNull('hover_image')->pluck('hover_image')->toArray();
            $usedGallery = ProductImage::whereNotNull('image_path')->pluck('image_path')->toArray();

            $normalize = function ($path) {
                return ltrim(str_replace(['\\', '//'], '/', $path), '/');
            };

            $usedSet = array_flip(array_map($normalize, array_merge($usedThumbnails, $usedHovers, $usedGallery)));

            foreach ($files as $file) {
                $filename = $file->getFilename();
                $relPath = 'uploads/products/' . $filename;
                $size = $file->getSize();
                $totalBytes += $size;

                $fileData = [
                    'filename' => $filename,
                    'path' => $relPath,
                    'url' => asset($relPath),
                    'size' => $size,
                    'size_formatted' => round($size / 1024, 1) . ' KB',
                    'updated_at' => date('Y-m-d H:i', $file->getMTime()),
                ];

                $allFiles[] = $fileData;

                if (!isset($usedSet[$relPath])) {
                    $unusedFiles[] = $fileData;
                    $unusedBytes += $size;
                }
            }
        }

        return view('admin.products.unused-images', [
            'allFilesCount' => count($allFiles),
            'unusedFiles' => $unusedFiles,
            'unusedCount' => count($unusedFiles),
            'totalBytesFormatted' => round($totalBytes / (1024 * 1024), 2) . ' MB',
            'unusedBytesFormatted' => round($unusedBytes / (1024 * 1024), 2) . ' MB',
        ]);
    }

    /**
     * Purge specific unused image or all unused images
     */
    public function purgeUnusedImages(Request $request)
    {
        $targetFile = $request->input('filename');

        $dir = public_path('uploads/products');
        if (!File::isDirectory($dir)) {
            return back()->with('info', 'No uploaded product images directory found.');
        }

        $usedThumbnails = Product::whereNotNull('thumbnail_image')->pluck('thumbnail_image')->toArray();
        $usedHovers = Product::whereNotNull('hover_image')->pluck('hover_image')->toArray();
        $usedGallery = ProductImage::whereNotNull('image_path')->pluck('image_path')->toArray();

        $normalize = function ($path) {
            return ltrim(str_replace(['\\', '//'], '/', $path), '/');
        };

        $usedSet = array_flip(array_map($normalize, array_merge($usedThumbnails, $usedHovers, $usedGallery)));

        $deletedCount = 0;
        $freedBytes = 0;

        $files = File::files($dir);
        foreach ($files as $file) {
            $filename = $file->getFilename();
            $relPath = 'uploads/products/' . $filename;

            if ($targetFile && $filename !== $targetFile) {
                continue;
            }

            if (!isset($usedSet[$relPath])) {
                $freedBytes += $file->getSize();
                File::delete($file->getRealPath());
                $deletedCount++;
            }
        }

        $freedFormatted = round($freedBytes / 1024, 1) . ' KB';
        if ($freedBytes > 1024 * 1024) {
            $freedFormatted = round($freedBytes / (1024 * 1024), 2) . ' MB';
        }

        ActivityLog::record('images_purged', "Purged {$deletedCount} unused uploaded product images (Freed {$freedFormatted})");

        return back()->with('success', "Cleaned {$deletedCount} unused image(s) from storage. Freed {$freedFormatted}.");
    }
}
