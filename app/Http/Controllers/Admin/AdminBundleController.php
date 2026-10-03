<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBundleController extends Controller
{
    public function index(Request $request)
    {
        $query = Bundle::with(['items.product'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('tagline', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $bundles = $query->paginate(12)->withQueryString();

        return view('admin.bundles.index', compact('bundles'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('admin.bundles.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'required|string',
            'sku' => 'required|string|unique:bundles,sku',
            'original_price' => 'required|numeric|min:0',
            'bundle_price' => 'required|numeric|min:0',
            'badge_text' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,webp,svg|max:2048',
            'products' => 'required|array|min:2',
            'products.*' => 'exists:products,id',
        ]);

        $savings = max(0, $request->original_price - $request->bundle_price);

        $imagePath = 'assets/images/perfumes/discovery_set.svg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/bundles');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/bundles/' . $filename;
        }

        $bundle = Bundle::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sku' => strtoupper($request->sku),
            'tagline' => $request->tagline,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'bundle_price' => $request->bundle_price,
            'savings_amount' => $savings,
            'badge_text' => $request->badge_text ?? 'EXCLUSIVE BUNDLE',
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        foreach ($request->products as $productId) {
            BundleItem::create([
                'bundle_id' => $bundle->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        ActivityLog::record(
            'bundle_created',
            "Created luxury bundle '{$bundle->name}' with {$bundle->items()->count()} items",
            $bundle
        );

        return redirect()->route('admin.bundles.index')->with('success', "Bundle '{$bundle->name}' crafted successfully.");
    }

    public function edit($id)
    {
        $bundle = Bundle::with('items')->findOrFail($id);
        $products = Product::where('is_active', true)->orderBy('name')->get();
        $selectedProductIds = $bundle->items->pluck('product_id')->toArray();

        return view('admin.bundles.edit', compact('bundle', 'products', 'selectedProductIds'));
    }

    public function update(Request $request, $id)
    {
        $bundle = Bundle::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'required|string',
            'sku' => 'required|string|unique:bundles,sku,' . $bundle->id,
            'original_price' => 'required|numeric|min:0',
            'bundle_price' => 'required|numeric|min:0',
            'badge_text' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,webp,svg|max:2048',
            'products' => 'required|array|min:2',
            'products.*' => 'exists:products,id',
        ]);

        $savings = max(0, $request->original_price - $request->bundle_price);

        $imagePath = $bundle->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/bundles');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/bundles/' . $filename;
        }

        $bundle->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sku' => strtoupper($request->sku),
            'tagline' => $request->tagline,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'bundle_price' => $request->bundle_price,
            'savings_amount' => $savings,
            'badge_text' => $request->badge_text,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        // Re-sync bundle items
        $bundle->items()->delete();
        foreach ($request->products as $productId) {
            BundleItem::create([
                'bundle_id' => $bundle->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        ActivityLog::record(
            'bundle_updated',
            "Updated luxury bundle '{$bundle->name}'",
            $bundle
        );

        return redirect()->route('admin.bundles.index')->with('success', "Bundle '{$bundle->name}' updated successfully.");
    }

    public function destroy($id)
    {
        $bundle = Bundle::findOrFail($id);
        $name = $bundle->name;
        $bundle->items()->delete();
        $bundle->delete();

        ActivityLog::record('bundle_deleted', "Deleted bundle '{$name}'");

        return redirect()->route('admin.bundles.index')->with('success', "Bundle '{$name}' deleted.");
    }
}
