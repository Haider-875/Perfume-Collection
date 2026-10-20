@extends('layouts.app')

@section('title', 'Your Fragrance Bag — Perfumes Collection')

@section('content')
<div class="py-5 min-vh-100"
     style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA; color: #211D1E;"
     x-data="{
        subtotal: {{ $cart->subtotal }},
        discount: {{ $cart->discount_amount }},
        couponCode: '{{ $cart->coupon_code }}',
        couponLoading: false,
        couponMessage: '',
        couponSuccess: null,
        updateQty(itemId, quantity) {
            fetch('{{ route('cart.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ item_id: itemId, quantity: quantity })
            })
            .then(res => res.json())
            .then(data => {
                window.dispatchEvent(new CustomEvent('cart-updated', { detail: data }));
                window.location.reload();
            });
        },
        removeItem(itemId) {
            fetch('{{ route('cart.remove') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ item_id: itemId })
            })
            .then(res => res.json())
            .then(data => {
                window.dispatchEvent(new CustomEvent('cart-updated', { detail: data }));
                window.location.reload();
            });
        },
        applyCoupon() {
            if (!this.couponCode) return;
            this.couponLoading = true;
            this.couponMessage = '';
            fetch('{{ route('checkout.coupon.apply') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ coupon_code: this.couponCode })
            })
            .then(res => res.json())
            .then(data => {
                this.couponLoading = false;
                this.couponSuccess = data.success;
                this.couponMessage = data.message;
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(err => {
                this.couponLoading = false;
                this.couponSuccess = false;
                this.couponMessage = 'Failed to apply coupon. Please retry.';
            });
        }
     }">
    <div class="container px-3 px-lg-4" style="max-width: 1120px;">
        <div class="text-center mb-5">
            <span class="fw-semibold px-3 py-1 rounded-pill d-inline-block mb-3" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                Curated Selections
            </span>
            <h1 class="font-serif display-5 fw-normal mb-0" style="color: #211D1E;">Your Fragrance Bag</h1>
        </div>

        @if($cart->items->isNotEmpty())
            <div class="row g-4 g-lg-5">
                <!-- Cart Items List (col-12 col-lg-8) -->
                <div class="col-12 col-lg-8">
                    <div class="p-4 p-md-5 rounded-4 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                        <div class="d-flex flex-column gap-4">
                            @foreach($cart->items as $item)
                                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 text-xs {{ !$loop->last ? 'pb-4' : '' }}" style="{{ !$loop->last ? 'border-bottom: 1px solid #E8E0DA;' : '' }}">
                                    <div class="d-flex align-items-center gap-3 min-w-0" style="min-width: 0; flex: 1 1 auto;">
                                        <div class="rounded-3 p-2 flex-shrink-0 d-flex align-items-center justify-content-center overflow-hidden" style="width: 64px; height: 64px; min-width: 64px; background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                            @if($item->product)
                                                <img src="{{ asset($item->product->primary_image_url) }}" alt="{{ $item->product->name }}" class="img-fluid mh-100 object-contain">
                                            @elseif($item->bundle)
                                                <img src="{{ asset($item->bundle->image_url) }}" alt="{{ $item->bundle->name }}" class="img-fluid mh-100 object-contain">
                                            @endif
                                        </div>
                                        <div class="min-w-0" style="min-width: 0; overflow: hidden;">
                                            <h3 class="font-serif fs-6 fw-semibold mb-1 text-truncate" style="color: #211D1E; max-width: 100%;" title="{{ $item->bundle ? $item->bundle->name : $item->product->name }}">{{ $item->bundle ? $item->bundle->name : $item->product->name }}</h3>
                                            <p class="fw-semibold mb-1 text-truncate" style="font-size: 11px; color: #6B605B; max-width: 100%;">{{ $item->variant ? $item->variant->size_label : ($item->bundle ? 'Curated Bundle' : $item->product->volume_ml . 'ml Flacon') }}</p>
                                            <div class="fw-bold" style="color: #541B29 !important; font-size: 0.95rem;">Rs. {{ number_format($item->price, 0) }}</div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between justify-content-sm-end gap-4">
                                        <!-- Quantity Stepper -->
                                        <div class="d-flex align-items-center rounded-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                            <button type="button" @click="updateQty({{ $item->id }}, {{ $item->quantity - 1 }})" 
                                                    class="btn px-3 py-1 fw-bold fs-6" style="color: #541B29; border: none;">&minus;</button>
                                            <span class="px-2 fw-bold text-xs" style="color: #211D1E;">{{ $item->quantity }}</span>
                                            <button type="button" @click="updateQty({{ $item->id }}, {{ $item->quantity + 1 }})" 
                                                    class="btn px-3 py-1 fw-bold fs-6" style="color: #541B29; border: none;">&plus;</button>
                                        </div>

                                        <!-- Total -->
                                        <div class="text-end">
                                            <div class="fs-6 fw-bold font-mono" style="color: #541B29 !important;">
                                                Rs. {{ number_format($item->price * $item->quantity, 0) }}
                                            </div>
                                            <button type="button" @click="removeItem({{ $item->id }})" class="btn btn-link p-0 text-danger text-decoration-underline text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.05em;">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary & Checkout CTA (col-12 col-lg-4) -->
                <div class="col-12 col-lg-4">
                    <div class="p-4 p-md-5 rounded-4 shadow-sm d-flex flex-column gap-4" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                        <h3 class="font-serif fs-5 fw-semibold pb-3 mb-0" style="color: #211D1E; border-bottom: 1px solid #E8E0DA;">Order Summary</h3>

                        <!-- Promo Code -->
                        <div class="pb-3" style="border-bottom: 1px solid #E8E0DA;">
                            @if($cart->coupon_code)
                                <div class="p-3 rounded-3 d-flex align-items-center justify-content-between text-xs" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                    <div>
                                        <span class="fw-bold font-mono" style="color: #541B29;">{{ $cart->coupon_code }}</span>
                                        <span class="ms-1" style="color: #6B605B;">(-Rs. {{ number_format($cart->discount_amount, 0) }})</span>
                                    </div>
                                    <a href="{{ route('checkout.coupon.remove') }}" class="text-danger text-decoration-underline fw-bold text-uppercase" style="font-size: 10px;">Remove</a>
                                </div>
                            @else
                                <div class="d-flex flex-column gap-2">
                                    <label class="d-block fw-semibold text-uppercase" style="font-size: 10px; letter-spacing: 0.2em; color: #541B29;">Coupon Voucher</label>
                                    <div class="d-flex gap-2">
                                        <input type="text" x-model="couponCode" placeholder=""
                                               class="form-control text-xs py-2 px-3 text-uppercase font-mono" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                                        <button type="button" @click="applyCoupon()" :disabled="couponLoading"
                                                class="btn-gold fw-semibold text-xs text-uppercase px-3 py-2 rounded-3 text-nowrap">
                                            Apply
                                        </button>
                                    </div>
                                    <p x-show="couponMessage" x-cloak class="mb-0" style="font-size: 11px;" :class="couponSuccess ? 'text-success' : 'text-danger'" x-text="couponMessage"></p>
                                </div>
                            @endif
                        </div>

                        @php
                            $freeShippingThreshold = 5000;
                            $shippingCost = $cart->subtotal >= $freeShippingThreshold ? 0 : 399;
                            $remainingForFree = max(0, $freeShippingThreshold - $cart->subtotal);
                            $shippingPercent = min(100, round(($cart->subtotal / $freeShippingThreshold) * 100));
                            $cartTotal = max(0, $cart->subtotal - $cart->discount_amount + $shippingCost);
                        @endphp

                        <!-- Free Delivery Progress Tracker -->
                        <div class="p-3 rounded-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                            <div class="d-flex align-items-center justify-content-between gap-2 mb-1.5" style="font-size: 11.5px;">
                                @if($remainingForFree > 0)
                                    <span style="color: #514744;">
                                        <i class="fas fa-truck-fast text-gold me-1"></i> Add <strong class="fw-bold" style="color: #541B29;">Rs. {{ number_format($remainingForFree, 0) }}</strong> more for <strong>FREE Delivery</strong>!
                                    </span>
                                @else
                                    <span class="text-success fw-bold">
                                        <i class="fas fa-circle-check text-success me-1"></i> You Unlocked <strong>FREE Delivery</strong>!
                                    </span>
                                @endif
                                <span class="fw-bold font-mono" style="font-size: 11px; color: #541B29;">{{ $shippingPercent }}%</span>
                            </div>
                            <div class="progress" style="height: 6px; background-color: #E8E0DA; border-radius: 999px;">
                                <div class="progress-bar progress-bar-luxury-shimmer" role="progressbar" 
                                     style="width: {{ $shippingPercent }}%; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%); border-radius: 999px; transition: width 0.8s var(--ease-luxury);" 
                                     aria-valuenow="{{ $shippingPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <!-- Totals -->
                        <div class="d-flex flex-column gap-2 text-xs">
                            <div class="d-flex justify-content-between" style="color: #6B605B;">
                                <span>Subtotal:</span>
                                <span class="fw-bold font-mono" style="color: #211D1E;">Rs. {{ number_format($cart->subtotal, 0) }}</span>
                            </div>
                            @if($cart->discount_amount > 0)
                                <div class="d-flex justify-content-between fw-semibold" style="color: #541B29;">
                                    <span>Discount Savings:</span>
                                    <span class="font-mono">- Rs. {{ number_format($cart->discount_amount, 0) }}</span>
                                </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center" style="color: #6B605B;">
                                <span>Courier Delivery:</span>
                                @if($shippingCost == 0)
                                    <span class="badge px-2 py-0.5 rounded-pill" style="background-color: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; font-size: 11px; font-weight: 700;">
                                        FREE
                                    </span>
                                @else
                                    <span class="fw-bold font-mono" style="color: #541B29; font-size: 12px;">Rs. 399</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-baseline pt-3" style="border-top: 1px solid #E8E0DA;">
                                <span class="font-serif fs-5" style="color: #211D1E;">Total:</span>
                                <span class="font-serif fs-3 fw-bold font-mono" style="color: #541B29 !important;">
                                    Rs. {{ number_format($cartTotal, 0) }}
                                </span>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <div class="pt-2">
                            <a href="{{ route('checkout.index') }}" 
                               class="w-100 fw-bold text-uppercase tracking-wider d-flex align-items-center justify-content-center text-decoration-none shadow transition" 
                               style="height: 48px; font-size: 12px; background: linear-gradient(135deg, #B83A58 0%, #7A1C33 50%, #4A1220 100%) !important; color: #FFFFFF !important; border: none !important; border-radius: 8px; box-shadow: 0 4px 14px rgba(122, 28, 51, 0.3) !important;">
                                <span>PROCEED TO CHECKOUT</span>
                                <i class="fas fa-arrow-right-long ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="p-5 rounded-4 text-center text-xs shadow-sm mx-auto d-flex flex-column align-items-center gap-3" style="max-width: 520px; background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #6B605B;">
                <div class="rounded-circle d-flex align-items-center justify-content-center fs-3" style="width: 64px; height: 64px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h3 class="font-serif fs-3 fw-normal mb-0" style="color: #211D1E;">Your Fragrance Bag is Empty</h3>
                <p class="mb-0" style="color: #6B605B;">Discover our handcrafted impression extraits with monumental 14+ hours longevity.</p>
                <div class="pt-2">
                    <a href="{{ route('collections.show', 'all') }}" class="btn-gold py-3 px-4 text-xs text-uppercase tracking-widest d-inline-block text-decoration-none" style="border-radius: 8px;">
                        Explore All Impressions
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
