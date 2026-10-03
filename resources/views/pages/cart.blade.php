@extends('layouts.app')

@section('title', 'Your Fragrance Bag — Perfumes Collection')

@section('content')
<div class="py-12 md:py-20 bg-[#080304] text-brand-ivory min-h-screen"
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
            <span class="text-[10px] uppercase tracking-[0.3em] text-brand-gold px-3 py-1 bg-brand-maroon/20 border border-brand-gold/30 rounded-full inline-block mb-3">
                Curated Selection
            </span>
            <h1 class="font-serif text-3xl md:text-5xl text-brand-gold font-light">Your Fragrance Bag</h1>
        </div>

        @if($cart->items->isNotEmpty())
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                <!-- Cart Items List -->
                <div class="lg:col-span-8 bg-[#0d0608] border border-brand-gold/20 p-6 md:p-8 rounded-sm shadow-xl">
                    <div class="divide-y divide-white/5">
                        @foreach($cart->items as $item)
                            <div class="py-6 first:pt-0 last:pb-0 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-black/80 rounded border border-white/10 p-2 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                        @if($item->product)
                                            <img src="{{ asset($item->product->primary_image_url) }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain">
                                        @elseif($item->bundle)
                                            <img src="{{ asset($item->bundle->image_url) }}" alt="{{ $item->bundle->name }}" class="w-full h-full object-contain">
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-serif text-base text-brand-ivory font-semibold">{{ $item->bundle ? $item->bundle->name : $item->product->name }}</h3>
                                        <p class="text-[11px] text-brand-ivory/50 mt-0.5">{{ $item->variant ? $item->variant->size_label : ($item->bundle ? 'Curated Bundle' : $item->product->volume_ml . 'ml Flacon') }}</p>
                                        <div class="text-brand-gold font-mono mt-1">Rs. {{ number_format($item->price, 0) }}</div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between sm:justify-end gap-6">
                                    <!-- Quantity Stepper -->
                                    <div class="flex items-center border border-white/20 rounded bg-black/40">
                                        <button type="button" @click="updateQty({{ $item->id }}, {{ $item->quantity - 1 }})" 
                                                class="px-3 py-1.5 text-brand-ivory/60 hover:text-white hover:bg-white/5 transition-all text-sm font-mono">&minus;</button>
                                        <span class="px-3 py-1.5 font-mono text-xs font-semibold text-brand-gold">{{ $item->quantity }}</span>
                                        <button type="button" @click="updateQty({{ $item->id }}, {{ $item->quantity + 1 }})" 
                                                class="px-3 py-1.5 text-brand-ivory/60 hover:text-white hover:bg-white/5 transition-all text-sm font-mono">&plus;</button>
                                    </div>

                                    <!-- Total -->
                                    <div class="text-right">
                                        <div class="font-mono text-sm font-semibold text-brand-gold">
                                            Rs. {{ number_format($item->price * $item->quantity, 0) }}
                                        </div>
                                        <button type="button" @click="removeItem({{ $item->id }})" class="text-[10px] text-red-400 hover:text-red-300 underline uppercase tracking-wider mt-1">
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
                    <div class="bg-[#0d0608] border border-brand-gold/30 p-6 md:p-8 rounded-sm shadow-2xl space-y-4">
                        <h3 class="font-serif text-xl text-brand-gold font-light pb-3 border-b border-white/10">Summary</h3>

                        <!-- Promo Code -->
                        <div class="pb-3 border-b border-white/10">
                            @if($cart->coupon_code)
                                <div class="p-2.5 bg-brand-gold/10 border border-brand-gold/40 rounded flex items-center justify-between text-xs">
                                    <div>
                                        <span class="text-brand-gold font-semibold font-mono">{{ $cart->coupon_code }}</span>
                                        <span class="text-brand-ivory/60 ml-1">(-Rs. {{ number_format($cart->discount_amount, 0) }})</span>
                                    </div>
                                    <a href="{{ route('checkout.coupon.remove') }}" class="text-red-400 underline text-[10px] uppercase">Remove</a>
                                </div>
                            @else
                                <div class="space-y-1.5">
                                    <label class="block text-[10px] uppercase tracking-[0.2em] text-brand-gold font-medium">Privilege Code</label>
                                    <div class="flex gap-2">
                                        <input type="text" x-model="couponCode" placeholder="e.g. ROYAL10"
                                               class="w-full bg-black/60 border border-brand-gold/30 px-3 py-1.5 text-xs text-brand-ivory uppercase font-mono rounded focus:border-brand-gold focus:outline-none">
                                        <button type="button" @click="applyCoupon()" :disabled="couponLoading"
                                                class="px-3 py-1.5 bg-brand-gold text-black font-semibold text-xs uppercase rounded hover:brightness-110 disabled:opacity-50">
                                            Apply
                                        </button>
                                    </div>
                                    <p x-show="couponMessage" x-cloak class="text-[11px]" :class="couponSuccess ? 'text-green-400' : 'text-red-400'" x-text="couponMessage"></p>
                                </div>
                            @endif
                        </div>

                        <!-- Totals -->
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between text-brand-ivory/70">
                                <span>Subtotal:</span>
                                <span class="font-mono text-brand-ivory font-semibold">Rs. {{ number_format($cart->subtotal, 0) }}</span>
                            </div>
                            @if($cart->discount_amount > 0)
                                <div class="flex justify-between text-brand-gold">
                                    <span>Privilege Discount:</span>
                                    <span class="font-mono font-semibold">- Rs. {{ number_format($cart->discount_amount, 0) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-brand-ivory/70">
                                <span>Estimated Courier:</span>
                                <span class="font-mono text-brand-ivory">{{ $cart->subtotal >= 4999 ? 'COMPLIMENTARY' : 'Calculated at Checkout' }}</span>
                            </div>
                            <div class="flex justify-between items-baseline pt-3 border-t border-brand-gold/30 text-base font-semibold">
                                <span class="font-serif text-lg text-brand-gold">Bag Total:</span>
                                <span class="font-serif text-2xl text-brand-gold font-mono">
                                    Rs. {{ number_format(max(0, $cart->subtotal - $cart->discount_amount), 0) }}
                                </span>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <div class="pt-2">
                            <a href="{{ route('checkout.index') }}" 
                               class="w-full py-4 bg-gradient-to-r from-brand-gold via-brand-gold-light to-brand-gold text-black font-semibold text-xs uppercase tracking-[0.25em] hover:brightness-110 transition-all rounded-sm shadow-lg flex items-center justify-center gap-2">
                                <span>Proceed to Checkout</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-[#0d0608] border border-brand-gold/20 p-16 rounded-sm text-center text-xs text-brand-ivory/60 shadow-xl max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-brand-gold/10 border border-brand-gold/30 mx-auto mb-4 flex items-center justify-center text-brand-gold">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <h3 class="font-serif text-2xl text-brand-gold font-light mb-2">Your Fragrance Bag is Empty</h3>
                <p class="mb-6">Discover our private reserve collection of pure extraits and royal Cambodian ouds.</p>
                <a href="{{ route('collections.index') }}" class="px-6 py-3 bg-brand-gold text-black font-semibold text-xs uppercase tracking-[0.2em] rounded inline-block hover:brightness-110 transition-all">
                    Explore Fragrance Vault
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
