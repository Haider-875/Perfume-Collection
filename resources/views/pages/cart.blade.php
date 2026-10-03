@extends('layouts.app')

@section('title', 'Your Fragrance Bag — RAVAHA Parfums')

@section('content')
<div class="py-12 md:py-16 bg-white text-gray-900 min-h-screen border-b border-gray-200"
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
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="text-center mb-10">
            <span class="text-[11px] uppercase tracking-[0.25em] text-amber-800 font-bold px-3 py-1 bg-amber-50 border border-amber-200 rounded-full inline-block mb-3">
                Curated Selections
            </span>
            <h1 class="font-serif text-3xl md:text-5xl text-gray-900 font-normal">Your Fragrance Bag</h1>
        </div>

        @if($cart->items->isNotEmpty())
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                <!-- Cart Items List -->
                <div class="lg:col-span-8 bg-gray-50 border border-gray-200 p-6 md:p-8 rounded-xl shadow-sm">
                    <div class="divide-y divide-gray-200">
                        @foreach($cart->items as $item)
                            <div class="py-6 first:pt-0 last:pb-0 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-white rounded-lg border border-gray-200 p-2 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                        @if($item->product)
                                            <img src="{{ asset($item->product->primary_image_url) }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain">
                                        @elseif($item->bundle)
                                            <img src="{{ asset($item->bundle->image_url) }}" alt="{{ $item->bundle->name }}" class="w-full h-full object-contain">
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-serif text-base text-gray-900 font-semibold">{{ $item->bundle ? $item->bundle->name : $item->product->name }}</h3>
                                        <p class="text-[11px] text-amber-800 font-semibold mt-0.5">{{ $item->variant ? $item->variant->size_label : ($item->bundle ? 'Curated Bundle' : $item->product->volume_ml . 'ml Flacon') }}</p>
                                        <div class="text-gray-900 font-bold mt-1">Rs. {{ number_format($item->price, 0) }}</div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between sm:justify-end gap-6">
                                    <!-- Quantity Stepper -->
                                    <div class="flex items-center border border-gray-300 rounded-lg bg-white">
                                        <button type="button" @click="updateQty({{ $item->id }}, {{ $item->quantity - 1 }})" 
                                                class="px-3 py-1.5 text-gray-600 hover:text-gray-900 text-sm font-bold">&minus;</button>
                                        <span class="px-3 py-1.5 font-bold text-xs text-gray-900">{{ $item->quantity }}</span>
                                        <button type="button" @click="updateQty({{ $item->id }}, {{ $item->quantity + 1 }})" 
                                                class="px-3 py-1.5 text-gray-600 hover:text-gray-900 text-sm font-bold">&plus;</button>
                                    </div>

                                    <!-- Total -->
                                    <div class="text-right">
                                        <div class="text-sm font-bold text-gray-900">
                                            Rs. {{ number_format($item->price * $item->quantity, 0) }}
                                        </div>
                                        <button type="button" @click="removeItem({{ $item->id }})" class="text-[11px] text-red-600 hover:text-red-700 underline uppercase tracking-wider mt-1 font-semibold">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary & Checkout CTA -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-gray-50 border border-gray-200 p-6 md:p-8 rounded-xl shadow-sm space-y-4">
                        <h3 class="font-serif text-xl text-gray-900 font-semibold pb-3 border-b border-gray-200">Order Summary</h3>

                        <!-- Promo Code -->
                        <div class="pb-3 border-b border-gray-200">
                            @if($cart->coupon_code)
                                <div class="p-2.5 bg-amber-50 border border-amber-200 rounded-lg flex items-center justify-between text-xs">
                                    <div>
                                        <span class="text-amber-900 font-bold">{{ $cart->coupon_code }}</span>
                                        <span class="text-gray-600 ml-1">(-Rs. {{ number_format($cart->discount_amount, 0) }})</span>
                                    </div>
                                    <a href="{{ route('checkout.coupon.remove') }}" class="text-red-600 underline text-[10px] uppercase font-bold">Remove</a>
                                </div>
                            @else
                                <div class="space-y-1.5">
                                    <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-700 font-bold">Coupon Voucher</label>
                                    <div class="flex gap-2">
                                        <input type="text" x-model="couponCode" placeholder="e.g. WELCOME500"
                                               class="w-full bg-white border border-gray-300 px-3 py-1.5 text-xs text-gray-900 uppercase font-mono rounded-lg focus:border-amber-600 focus:outline-none">
                                        <button type="button" @click="applyCoupon()" :disabled="couponLoading"
                                                class="px-4 py-1.5 bg-amber-700 text-white font-semibold text-xs uppercase rounded-lg hover:bg-amber-800 disabled:opacity-50">
                                            Apply
                                        </button>
                                    </div>
                                    <p x-show="couponMessage" x-cloak class="text-[11px]" :class="couponSuccess ? 'text-green-600' : 'text-red-600'" x-text="couponMessage"></p>
                                </div>
                            @endif
                        </div>

                        <!-- Totals -->
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal:</span>
                                <span class="text-gray-900 font-bold">Rs. {{ number_format($cart->subtotal, 0) }}</span>
                            </div>
                            @if($cart->discount_amount > 0)
                                <div class="flex justify-between text-amber-800 font-semibold">
                                    <span>Discount Savings:</span>
                                    <span>- Rs. {{ number_format($cart->discount_amount, 0) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-gray-600">
                                <span>Courier Delivery:</span>
                                <span class="text-gray-900 font-medium">{{ $cart->subtotal >= 3500 ? 'COMPLIMENTARY' : 'Calculated at Checkout' }}</span>
                            </div>
                            <div class="flex justify-between items-baseline pt-3 border-t border-gray-200 text-base font-semibold">
                                <span class="font-serif text-lg text-gray-900">Total:</span>
                                <span class="font-serif text-2xl text-gray-900 font-bold">
                                    Rs. {{ number_format(max(0, $cart->subtotal - $cart->discount_amount), 0) }}
                                </span>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <div class="pt-2">
                            <a href="{{ route('checkout.index') }}" 
                               class="w-full btn-gold py-3.5 text-xs tracking-widest uppercase block text-center shadow-md">
                                PROCEED TO CHECKOUT
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gray-50 border border-gray-200 p-16 rounded-2xl text-center text-xs text-gray-600 shadow-sm max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-amber-100 mx-auto mb-4 flex items-center justify-center text-amber-800 text-2xl">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h3 class="font-serif text-2xl text-gray-900 font-normal mb-2">Your Fragrance Bag is Empty</h3>
                <p class="mb-6 text-gray-500">Discover our handcrafted impression extraits with monumental 14+ hours longevity.</p>
                <a href="{{ route('collections.show', 'all') }}" class="btn-gold py-3 px-8 text-xs uppercase tracking-widest inline-block">
                    Explore All Impressions
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
