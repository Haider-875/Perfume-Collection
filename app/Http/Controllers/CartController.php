<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    public function index(Request $request)
    {
        $cart = $this->cartService->getCart($request);
        return view('pages.cart', compact('cart'));
    }

    public function getDrawer(Request $request)
    {
        $cart = $this->cartService->getCart($request);
        $cart->load(['items.product', 'items.variant', 'items.bundle']);

        $subtotal = (float) $cart->subtotal;
        $shippingCost = $this->cartService->calculateShipping($cart);
        $threshold = 5000;
        $remainingForFree = max(0, $threshold - $subtotal);
        $shippingPercent = min(100, round(($subtotal / $threshold) * 100));

        return response()->json([
            'count' => $cart->items->sum('quantity'),
            'subtotal' => $cart->formatted_subtotal,
            'subtotal_raw' => $subtotal,
            'total' => 'Rs. ' . number_format(max(0, $subtotal - $cart->discount_amount + $shippingCost), 0),
            'discount' => 'Rs. ' . number_format($cart->discount_amount, 0),
            'shipping_cost' => $shippingCost,
            'shipping_formatted' => $shippingCost == 0 ? 'FREE' : 'Rs. ' . number_format($shippingCost, 0),
            'free_shipping_threshold' => $threshold,
            'remaining_for_free' => $remainingForFree,
            'remaining_formatted' => 'Rs. ' . number_format($remainingForFree, 0),
            'shipping_percent' => $shippingPercent,
            'items' => $cart->items->map(function($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->bundle ? $item->bundle->name : ($item->product?->name ?? 'Fragrance Flacon'),
                    'variant' => $item->variant ? $item->variant->size_label : ($item->bundle ? 'Curated Bundle' : ($item->product ? $item->product->volume_ml . 'ml Flacon' : '50ml Flacon')),
                    'price' => 'Rs. ' . number_format($item->price, 0),
                    'quantity' => $item->quantity,
                    'total' => $item->formatted_total,
                    'image' => $item->bundle ? $item->bundle->image_url : ($item->product?->primary_image_url ?? asset('assets/images/perfumes/prod_signature.jpg')),
                    'url' => $item->bundle ? '/collections/bundles' : ($item->product ? route('shop.show', $item->product->slug) : '/collections/bundles'),
                ];
            }),
        ]);
    }

    public function add(Request $request)
    {
        $cart = $this->cartService->getCart($request);
        $productId = $request->input('product_id');
        $variantId = $request->input('variant_id');
        $bundleId = $request->input('bundle_id');
        $quantity = max(1, (int)$request->input('quantity', 1));

        // Clean string literals and empty inputs from JS requests
        if ($variantId === 'null' || $variantId === '' || $variantId === 0 || $variantId === 'undefined') {
            $variantId = null;
        }
        if ($productId === 'null' || $productId === '' || $productId === 0 || $productId === 'undefined') {
            $productId = null;
        }
        if ($bundleId === 'null' || $bundleId === '' || $bundleId === 0 || $bundleId === 'undefined') {
            $bundleId = null;
        }

        $productId = $productId !== null ? (int)$productId : null;
        $variantId = $variantId !== null ? (int)$variantId : null;
        $bundleId = $bundleId !== null ? (int)$bundleId : null;

        if (!$productId && !$variantId && !$bundleId) {
            if ($request->wantsJson() || $request->ajax() || $request->isJson() || str_contains($request->header('Content-Type', ''), 'application/json')) {
                return response()->json(['error' => 'Product or bundle is required'], 422);
            }
            return redirect()->back()->with('error', 'Please select a valid fragrance or bundle.');
        }

        $this->cartService->addItem($cart, $productId, $variantId, $bundleId, $quantity);

        if ($request->input('redirect') === 'checkout' || $request->boolean('buy_now')) {
            return redirect()->to('/checkout', 303);
        }

        // Return JSON drawer response for AJAX/Fetch requests
        if ($request->wantsJson() || $request->ajax() || $request->isJson() || 
            str_contains($request->header('Content-Type', ''), 'application/json') ||
            str_contains($request->header('Accept', ''), 'application/json')) {
            return $this->getDrawer($request);
        }

        return redirect()->to('/checkout', 303);
    }

    public function update(Request $request)
    {
        $cart = $this->cartService->getCart($request);
        $itemId = (int)$request->input('item_id');
        $quantity = (int)$request->input('quantity');

        $this->cartService->updateItem($cart, $itemId, $quantity);

        return $this->getDrawer($request);
    }

    public function remove(Request $request)
    {
        $cart = $this->cartService->getCart($request);
        $itemId = (int)$request->input('item_id');

        $this->cartService->removeItem($cart, $itemId);

        return $this->getDrawer($request);
    }
}
