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
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 p-2 flex-shrink-0 d-flex align-items-center justify-content-center overflow-hidden" style="width: 64px; height: 64px; background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                            @if($item->product)
                                                <img src="{{ asset($item->product->primary_image_url) }}" alt="{{ $item->product->name }}" class="img-fluid mh-100 object-contain">
                                            @elseif($item->bundle)
                                                <img src="{{ asset($item->bundle->image_url) }}" alt="{{ $item->bundle->name }}" class="img-fluid mh-100 object-contain">
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-serif fs-6 fw-semibold mb-1" style="color: #211D1E;">{{ $item->bundle ? $item->bundle->name : $item->product->name }}</h3>
                                            <p class="fw-semibold mb-1" style="font-size: 11px; color: #6B605B;">{{ $item->variant ? $item->variant->size_label : ($item->bundle ? 'Curated Bundle' : $item->product->volume_ml . 'ml Flacon') }}</p>
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
                                        <input type="text" x-model="couponCode" placeholder="e.g. WELCOME500"
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
                            <div class="d-flex justify-content-between" style="color: #6B605B;">
                                <span>Courier Delivery:</span>
                                <span class="fw-semibold" style="color: #541B29;">{{ $cart->subtotal >= 3500 ? 'COMPLIMENTARY' : 'Calculated at Checkout' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-baseline pt-3" style="border-top: 1px solid #E8E0DA;">
                                <span class="font-serif fs-5" style="color: #211D1E;">Total:</span>
                                <span class="font-serif fs-3 fw-bold font-mono" style="color: #541B29 !important;">
                                    Rs. {{ number_format(max(0, $cart->subtotal - $cart->discount_amount), 0) }}
                                </span>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <div class="pt-2">
                            <a href="{{ route('checkout.index') }}" 
                               class="w-100 btn-gold py-3 text-xs tracking-widest text-uppercase d-block text-center text-decoration-none shadow" style="border-radius: 8px;">
                                PROCEED TO CHECKOUT
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
