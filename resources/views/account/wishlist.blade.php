@extends('layouts.app')

@section('title', 'Preserved Wishlist Vault — Perfumes Collection')

@section('content')
<div class="py-10 md:py-16 bg-[#080304] text-brand-ivory min-h-screen"
     x-data="{
        removeFromWishlist(productId) {
            fetch('{{ route('account.wishlist.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(res => res.json())
            .then(data => {
                window.location.reload();
            });
        },
        addToBag(productId) {
            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            })
            .then(res => res.json())
            .then(data => {
                window.dispatchEvent(new CustomEvent('cart-updated', { detail: data }));
                window.dispatchEvent(new CustomEvent('open-cart-drawer'));
            });
        }
     }">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-8 mb-10 border-b border-white/10">
            <div>
                <span class="text-[10px] uppercase tracking-[0.3em] text-brand-gold px-3 py-1 bg-brand-maroon/20 border border-brand-gold/30 rounded-full inline-block mb-2">
                    Private Reserve
                </span>
                <h1 class="font-serif text-3xl md:text-4xl text-brand-gold font-light">Your Preserved Wishlist</h1>
            </div>
            <a href="{{ route('collections.index') }}" class="text-xs uppercase tracking-wider text-brand-gold hover:underline">
                &larr; Discover New Extrait Creations
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-3">
                <nav class="bg-[#0d0608] border border-brand-gold/20 p-3 rounded-sm space-y-1 text-xs">
                    <a href="{{ route('account.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Patron Overview</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>Order Dossiers</span>
                    </a>
                    <a href="{{ route('account.addresses') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <span>Delivery Addresses</span>
                    </a>
                    <a href="{{ route('account.wishlist') }}" class="flex items-center gap-3 px-4 py-3 rounded bg-brand-maroon/30 text-brand-gold font-semibold border-l-2 border-brand-gold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span>Wishlist Vault</span>
                    </a>
                    <a href="{{ route('account.reviews') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        <span>Olfactory Reviews</span>
                    </a>
                </nav>
            </div>

            <!-- Wishlist Products Grid -->
            <div class="lg:col-span-9">
                @if($wishlistItems->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($wishlistItems as $item)
                            @php $prod = $item->product; @endphp
                            @if($prod)
                                <div class="bg-[#0d0608] border border-brand-gold/20 hover:border-brand-gold/50 rounded-sm p-4 flex flex-col justify-between group transition-all duration-300 shadow-xl relative">
                                    <!-- Remove cross -->
                                    <button @click="removeFromWishlist({{ $prod->id }})" title="Remove from Wishlist"
                                            class="absolute top-3 right-3 w-7 h-7 rounded-full bg-black/60 border border-white/20 text-brand-ivory/60 hover:text-red-400 hover:border-red-500/50 flex items-center justify-center text-xs transition-all z-10">
                                        &times;
                                    </button>

                                    <div>
                                        <a href="{{ route('shop.show', $prod->slug) }}" class="block aspect-square bg-black/40 rounded p-4 mb-4 overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset($prod->primary_image_url) }}" alt="{{ $prod->name }}" 
                                                 class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500">
                                        </a>

                                        <div class="text-[10px] uppercase tracking-widest text-brand-gold font-semibold mb-1">
                                            {{ $prod->category->name ?? 'Extrait de Parfum' }}
                                        </div>
                                        <a href="{{ route('shop.show', $prod->slug) }}">
                                            <h3 class="font-serif text-base text-brand-ivory group-hover:text-brand-gold transition-colors font-semibold leading-snug">
                                                {{ $prod->name }}
                                            </h3>
                                        </a>
                                        <div class="text-[11px] text-brand-ivory/50 mt-1">
                                            {{ $prod->volume_ml }}ml Flacon &bull; {{ $prod->concentration ?? '40% Extrait' }}
                                        </div>
                                    </div>

                                    <div class="pt-4 mt-4 border-t border-white/5 flex items-center justify-between gap-2">
                                        <div class="font-mono text-sm font-semibold text-brand-gold">
                                            Rs. {{ number_format($prod->effective_price, 0) }}
                                        </div>
                                        <button @click="addToBag({{ $prod->id }})" 
                                                class="px-3 py-1.5 bg-brand-gold text-black font-semibold text-[10px] uppercase tracking-wider rounded hover:brightness-110 transition-all flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                            <span>Add to Bag</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="bg-[#0d0608] border border-brand-gold/20 p-12 rounded-sm text-center text-xs text-brand-ivory/50 shadow-xl">
                        <p class="mb-4">Your preserved wishlist vault is currently empty.</p>
                        <a href="{{ route('collections.index') }}" class="px-5 py-2.5 bg-brand-gold text-black font-semibold uppercase tracking-wider rounded inline-block">
                            Explore Fragrance Vault
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
