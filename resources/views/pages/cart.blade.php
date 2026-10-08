@extends('layouts.app')

@section('title', 'Your Fragrance Bag — Perfumes Collection')

@section('content')
<div class="py-5 text-light-parchment min-vh-100 border-bottom border-gold-20"
     style="background-color: #050203;"
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
            <span class="text-gold fw-semibold px-3 py-1 bg-wine-dark border border-gold-30 rounded-pill d-inline-block mb-3" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">
                Curated Selections
            </span>
            <h1 class="font-serif display-5 text-light-parchment fw-normal mb-0">Your Fragrance Bag</h1>
        </div>

        @if($cart->items->isNotEmpty())
            <div class="row g-4 g-lg-5">
                <!-- Cart Items List (col-12 col-lg-8) -->
                <div class="col-12 col-lg-8">
                    <div class="bg-wine-card border border-gold-25 p-4 p-md-5 rounded-4 shadow-xl">
                        <div class="d-flex flex-column gap-4">
                            @foreach($cart->items as $item)
                                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 text-xs {{ !$loop->last ? 'pb-4 border-bottom border-gold-20' : '' }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-wine-dark rounded-3 border border-gold-25 p-2 flex-shrink-0 d-flex align-items-center justify-content-center overflow-hidden" style="width: 64px; height: 64px;">
                                            @if($item->product)
                                                <img src="{{ asset($item->product->primary_image_url) }}" alt="{{ $item->product->name }}" class="img-fluid mh-100 object-contain">
                                            @elseif($item->bundle)
                                                <img src="{{ asset($item->bundle->image_url) }}" alt="{{ $item->bundle->name }}" class="img-fluid mh-100 object-contain">
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-serif fs-6 text-light-parchment fw-semibold mb-1">{{ $item->bundle ? $item->bundle->name : $item->product->name }}</h3>
                                            <p class="text-gold fw-semibold mb-1" style="font-size: 11px;">{{ $item->variant ? $item->variant->size_label : ($item->bundle ? 'Curated Bundle' : $item->product->volume_ml . 'ml Flacon') }}</p>
                                            <div class="text-white fw-bold" style="color: #ffffff !important;">Rs. {{ number_format($item->price, 0) }}</div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between justify-content-sm-end gap-4">
                                        <!-- Quantity Stepper -->
                                        <div class="d-flex align-items-center border border-gold-30 rounded-3 bg-wine-dark">
                                            <button type="button" @click="updateQty({{ $item->id }}, {{ $item->quantity - 1 }})" 
                                                    class="btn text-muted-parchment text-light-parchment-hover px-3 py-1 fw-bold fs-6">&minus;</button>
                                            <span class="px-2 fw-bold text-xs text-light-parchment">{{ $item->quantity }}</span>
                                            <button type="button" @click="updateQty({{ $item->id }}, {{ $item->quantity + 1 }})" 
                                                    class="btn text-muted-parchment text-light-parchment-hover px-3 py-1 fw-bold fs-6">&plus;</button>
                                        </div>

                                        <!-- Total -->
                                        <div class="text-end">
                                            <div class="fs-6 fw-bold text-white font-mono" style="color: #ffffff !important;">
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
                    <div class="bg-wine-card border border-gold-25 p-4 p-md-5 rounded-4 shadow-xl d-flex flex-column gap-4">
                        <h3 class="font-serif fs-5 text-light-parchment fw-semibold pb-3 border-bottom border-gold-20 mb-0">Order Summary</h3>

                        <!-- Promo Code -->
                        <div class="pb-3 border-bottom border-gold-20">
                            @if($cart->coupon_code)
                                <div class="p-3 bg-wine-accent border border-gold-30 rounded-3 d-flex align-items-center justify-content-between text-xs">
                                    <div>
                                        <span class="text-gold-soft fw-bold font-mono">{{ $cart->coupon_code }}</span>
                                        <span class="text-muted-parchment ms-1">(-Rs. {{ number_format($cart->discount_amount, 0) }})</span>
                                    </div>
                                    <a href="{{ route('checkout.coupon.remove') }}" class="text-danger text-decoration-underline fw-bold text-uppercase" style="font-size: 10px;">Remove</a>
                                </div>
                            @else
                                <div class="d-flex flex-column gap-2">
                                    <label class="d-block text-gold fw-semibold text-uppercase" style="font-size: 10px; letter-spacing: 0.2em;">Coupon Voucher</label>
                                    <div class="d-flex gap-2">
                                        <input type="text" x-model="couponCode" placeholder="e.g. WELCOME500"
                                               class="form-control form-control-luxury text-xs py-2 px-3 text-uppercase font-mono">
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
                            <div class="d-flex justify-content-between text-muted-parchment">
                                <span>Subtotal:</span>
                                <span class="text-white fw-bold font-mono" style="color: #ffffff !important;">Rs. {{ number_format($cart->subtotal, 0) }}</span>
                            </div>
                            @if($cart->discount_amount > 0)
                                <div class="d-flex justify-content-between text-gold-soft fw-semibold">
                                    <span>Discount Savings:</span>
                                    <span class="font-mono">- Rs. {{ number_format($cart->discount_amount, 0) }}</span>
                                </div>
                            @endif
                            <div class="d-flex justify-content-between text-muted-parchment">
                                <span>Courier Delivery:</span>
                                <span class="text-gold fw-medium">{{ $cart->subtotal >= 3500 ? 'COMPLIMENTARY' : 'Calculated at Checkout' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-baseline pt-3 border-top border-gold-20">
                                <span class="font-serif fs-5 text-light-parchment">Total:</span>
                                <span class="font-serif fs-3 text-white fw-bold font-mono" style="color: #ffffff !important;">
                                    Rs. {{ number_format(max(0, $cart->subtotal - $cart->discount_amount), 0) }}
                                </span>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <div class="pt-2">
                            <a href="{{ route('checkout.index') }}" 
                               class="w-100 btn-gold py-3 text-xs tracking-widest text-uppercase d-block text-center text-decoration-none shadow">
                                PROCEED TO CHECKOUT
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-wine-card border border-gold-25 p-5 rounded-4 text-center text-xs text-muted-parchment shadow-xl mx-auto d-flex flex-column align-items-center gap-3" style="max-width: 520px;">
                <div class="rounded-circle bg-wine-accent border border-gold-40 d-flex align-items-center justify-content-center text-gold fs-3" style="width: 64px; height: 64px;">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h3 class="font-serif fs-3 text-light-parchment fw-normal mb-0">Your Fragrance Bag is Empty</h3>
                <p class="text-muted-parchment mb-0">Discover our handcrafted impression extraits with monumental 14+ hours longevity.</p>
                <div class="pt-2">
                    <a href="{{ route('collections.show', 'all') }}" class="btn-gold py-3 px-4 text-xs text-uppercase tracking-widest d-inline-block text-decoration-none">
                        Explore All Impressions
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
