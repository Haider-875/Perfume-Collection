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

        return response()->json([
            'count' => $cart->items->sum('quantity'),
            'subtotal' => $cart->formatted_subtotal,
            'total' => $cart->formatted_total,
            'discount' => 'Rs. ' . number_format($cart->discount_amount, 0),
            'items' => $cart->items->map(function($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->bundle ? $item->bundle->name : $item->product->name,
                    'variant' => $item->variant ? $item->variant->size_label : ($item->bundle ? 'Curated Bundle' : $item->product->volume_ml . 'ml Flacon'),
                    'price' => 'Rs. ' . number_format($item->price, 0),
                    'quantity' => $item->quantity,
                    'total' => $item->formatted_total,
                    'image' => $item->bundle ? $item->bundle->image_url : $item->product->primary_image_url,
                    'url' => $item->bundle ? '/collections/bundles' : route('shop.show', $item->product->slug),
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

        $this->cartService->addItem($cart, $productId, $variantId, $bundleId, $quantity);

        return $this->getDrawer($request);
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
