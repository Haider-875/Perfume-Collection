<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Bundle;
use App\Models\Setting;
use Illuminate\Http\Request;

class CartService
{
    public function getCart(Request $request): Cart
    {
        $sessionId = $request->session()->getId();
        $userId = auth()->id();

        if ($userId) {
            $userCart = Cart::firstOrCreate(['user_id' => $userId]);

            // Merge guest cart if one exists with this session
            $guestCart = Cart::where('session_id', $sessionId)->whereNull('user_id')->first();
            if ($guestCart && $guestCart->id !== $userCart->id) {
                $this->mergeCarts($guestCart, $userCart);
            }

            $userCart->load(['items.product', 'items.variant', 'items.bundle']);
            $this->revalidateCartTotals($userCart);
            return $userCart;
        }

        $guestCart = Cart::firstOrCreate(['session_id' => $sessionId]);
        $guestCart->load(['items.product', 'items.variant', 'items.bundle']);
        $this->revalidateCartTotals($guestCart);
        return $guestCart;
    }

    public function mergeGuestCartOnLogin(string $sessionId, int $userId): void
    {
        $guestCart = Cart::where('session_id', $sessionId)->whereNull('user_id')->first();
        if ($guestCart) {
            $userCart = Cart::firstOrCreate(['user_id' => $userId]);
            $this->mergeCarts($guestCart, $userCart);
        }
    }

    protected function mergeCarts(Cart $source, Cart $destination): void
    {
        foreach ($source->items as $item) {
            $existing = CartItem::where('cart_id', $destination->id)
                ->where('product_id', $item->product_id)
                ->where('product_variant_id', $item->product_variant_id)
                ->where('bundle_id', $item->bundle_id)
                ->first();

            if ($existing) {
                $existing->quantity += $item->quantity;
                $existing->save();
            } else {
                $item->cart_id = $destination->id;
                $item->save();
            }
        }

        if ($source->coupon_code && !$destination->coupon_code) {
            $destination->coupon_code = $source->coupon_code;
            $destination->discount_amount = $source->discount_amount;
            $destination->save();
        }

        $source->delete();
    }

    public function addItem(Cart $cart, ?int $productId, ?int $variantId = null, ?int $bundleId = null, int $quantity = 1): CartItem
    {
        $price = 0;
        if ($bundleId) {
            $bundle = Bundle::findOrFail($bundleId);
            $price = $bundle->bundle_price;
        } elseif ($variantId) {
            $variant = ProductVariant::findOrFail($variantId);
            $price = $variant->effective_price;
            $productId = $variant->product_id;
        } elseif ($productId) {
            $product = Product::findOrFail($productId);
            $price = $product->effective_price;
        }

        $existing = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->where('product_variant_id', $variantId)
            ->where('bundle_id', $bundleId)
            ->first();

        if ($existing) {
            $existing->quantity += $quantity;
            $existing->price = $price;
            $existing->save();
            $item = $existing;
        } else {
            $item = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'product_variant_id' => $variantId,
                'bundle_id' => $bundleId,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }

        $this->revalidateCartTotals($cart);
        return $item;
    }

    public function updateItem(Cart $cart, int $itemId, int $quantity): ?CartItem
    {
        $item = CartItem::where('cart_id', $cart->id)->where('id', $itemId)->first();
        if ($item) {
            if ($quantity <= 0) {
                $item->delete();
                $item = null;
            } else {
                $item->quantity = $quantity;
                $item->save();
            }
        }

        $this->revalidateCartTotals($cart);
        return $item;
    }

    public function removeItem(Cart $cart, int $itemId): bool
    {
        $deleted = CartItem::where('cart_id', $cart->id)->where('id', $itemId)->delete();
        $this->revalidateCartTotals($cart);
        return (bool) $deleted;
    }

    public function clearCart(Cart $cart): void
    {
        $cart->items()->delete();
        $cart->coupon_code = null;
        $cart->discount_amount = 0;
        $cart->save();
    }

    public function applyCoupon(Cart $cart, string $code): array
    {
        $code = strtoupper(trim($code));
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return ['success' => false, 'message' => 'The coupon code entered is invalid.'];
        }

        if (!$coupon->is_active) {
            return ['success' => false, 'message' => 'This promo code is currently inactive.'];
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return ['success' => false, 'message' => 'This promo code has expired.'];
        }

        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return ['success' => false, 'message' => 'This promo code usage limit has been reached.'];
        }

        $subtotal = $cart->subtotal;
        if ($subtotal < $coupon->min_spend) {
            return [
                'success' => false, 
                'message' => 'Minimum order amount of Rs. ' . number_format($coupon->min_spend, 0) . ' required to redeem this code.'
            ];
        }

        $discount = $coupon->calculateDiscount($subtotal);
        $cart->coupon_code = $coupon->code;
        $cart->discount_amount = $discount;
        $cart->save();

        return [
            'success' => true,
            'message' => 'Coupon ' . $coupon->code . ' applied successfully!',
            'discount' => $discount,
            'formatted_discount' => 'Rs. ' . number_format($discount, 0)
        ];
    }

    public function removeCoupon(Cart $cart): void
    {
        $cart->coupon_code = null;
        $cart->discount_amount = 0;
        $cart->save();
    }

    public function calculateShipping(Cart $cart, ?string $city = null): float
    {
        $subtotal = $cart->subtotal;
        $threshold = (float) Setting::get('free_shipping_threshold', 4999);
        $defaultCost = (float) Setting::get('default_shipping_cost', 250);

        if ($subtotal >= $threshold || $subtotal == 0) {
            return 0.00;
        }

        return $defaultCost;
    }

    public function revalidateCartTotals(Cart $cart): void
    {
        if ($cart->coupon_code) {
            $coupon = Coupon::where('code', $cart->coupon_code)->first();
            if ($coupon && $coupon->isValid($cart->subtotal)) {
                $cart->discount_amount = $coupon->calculateDiscount($cart->subtotal);
            } else {
                $cart->coupon_code = null;
                $cart->discount_amount = 0;
            }
            $cart->save();
        }
    }
}
