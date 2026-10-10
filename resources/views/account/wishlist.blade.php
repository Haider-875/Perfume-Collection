@extends('layouts.app')

@section('title', 'Preserved Wishlist Vault — Perfumes Collection')

@section('content')
<div class="py-5 min-vh-100" style="background-color: #F7F3EE;"
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
    <div class="container" style="max-width: 1280px;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-4 mb-4" style="border-bottom: 1px solid #E8E0DA;">
            <div>
                <span class="d-inline-block fw-semibold px-3 py-1 rounded-pill mb-2 text-uppercase" style="font-size: 10px; letter-spacing: 0.3em; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                    Private Reserve
                </span>
                <h1 class="font-serif fs-2 fs-md-1 fw-normal mb-0" style="color: #211D1E;">Your Preserved Wishlist</h1>
            </div>
            <a href="{{ route('collections.index') }}" class="fs-7 text-uppercase tracking-wider fw-semibold text-decoration-none" style="color: #541B29;">
                &larr; Discover New Extrait Creations
            </a>
        </div>

        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-12 col-lg-3">
                <nav class="p-2 rounded-3 d-flex flex-column gap-1 fs-7 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <a href="{{ route('account.dashboard') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-decoration-none transition" style="color: #6B605B;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Patron Overview</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-decoration-none transition" style="color: #6B605B;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>Order Dossiers</span>
                    </a>
                    <a href="{{ route('account.addresses') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-decoration-none transition" style="color: #6B605B;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <span>Delivery Addresses</span>
                    </a>
                    <a href="{{ route('account.wishlist') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded fw-semibold text-decoration-none" style="background-color: #FAF7F2; color: #541B29; border-left: 3px solid #541B29;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span>Wishlist Vault</span>
                    </a>
                    <a href="{{ route('account.reviews') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-decoration-none transition" style="color: #6B605B;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        <span>Olfactory Reviews</span>
                    </a>
                </nav>
            </div>

            <!-- Wishlist Products Grid -->
            <div class="col-12 col-lg-9">
                @if($wishlistItems->isNotEmpty())
                    <div class="row g-4">
                        @foreach($wishlistItems as $item)
                            @php $prod = $item->product; @endphp
                            @if($prod)
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="rounded-3 p-3 d-flex flex-column justify-content-between h-100 position-relative transition shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                                        <!-- Remove cross -->
                                        <button @click="removeFromWishlist({{ $prod->id }})" title="Remove from Wishlist"
                                                class="btn btn-sm position-absolute top-0 end-0 m-3 rounded-circle d-flex align-items-center justify-content-center p-0 z-3 shadow-sm"
                                                style="width: 28px; height: 28px; font-size: 1rem; line-height: 1; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E;">
                                            &times;
                                        </button>

                                        <div>
                                            <a href="{{ route('shop.show', $prod->slug) }}" class="d-block ratio ratio-1x1 rounded-3 p-2 mb-3 overflow-hidden text-center" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                                <img src="{{ asset($prod->primary_image_url) }}" alt="{{ $prod->name }}" 
                                                     class="w-100 h-100 object-fit-contain hover-scale transition duration-500">
                                            </a>

                                            <div class="text-uppercase tracking-widest fw-semibold fs-8 mb-1" style="color: #541B29;">
                                                {{ $prod->category->name ?? 'Extrait de Parfum' }}
                                            </div>
                                            <a href="{{ route('shop.show', $prod->slug) }}" class="text-decoration-none">
                                                <h3 class="font-serif fs-6 fw-semibold lh-sm mb-1" style="color: #211D1E !important;">
                                                    {{ $prod->name }}
                                                </h3>
                                            </a>
                                            <div class="fs-8 mt-1" style="color: #786C67;">
                                                {{ $prod->volume_ml }}ml Flacon &bull; {{ $prod->concentration ?? '40% Extrait' }}
                                            </div>
                                        </div>

                                        <div class="pt-3 mt-3 d-flex align-items-center justify-content-between gap-2" style="border-top: 1px solid #E8E0DA;">
                                            <div class="font-mono fs-7 fw-bold" style="color: #541B29 !important;">
                                                Rs. {{ number_format($prod->effective_price, 0) }}
                                            </div>
                                            <button @click="addToBag({{ $prod->id }})" 
                                                    class="btn py-1 px-2.5 text-uppercase fw-semibold fs-8 d-inline-flex align-items-center gap-1 text-white shadow-sm" style="background-color: #541B29; border-radius: 6px;">
                                                <svg class="bi" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                                <span>Add to Bag</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="p-5 rounded-3 text-center fs-7 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #786C67;">
                        <p class="mb-4">Your preserved wishlist vault is currently empty.</p>
                        <a href="{{ route('collections.index') }}" class="btn py-2 px-3 text-uppercase fw-semibold tracking-wider text-decoration-none text-white shadow-sm" style="background-color: #541B29; border-radius: 8px;">
                            Explore Fragrance Vault
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
