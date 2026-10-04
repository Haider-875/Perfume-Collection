@extends('layouts.app')

@section('title', 'Search Fragrance Vault: ' . ($q ? e($q) : 'All') . ' | Perfumes Collection Pakistan')

@section('content')

<!-- Search Results Banner -->
<section class="py-5 border-bottom border-gold-20 text-center" style="background: linear-gradient(to bottom, #18050b, #0d0305, #050203);">
    <div class="container px-3 px-lg-4" style="max-width: 768px;">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Vault Search']
        ]" />

        <span class="d-inline-block text-gold mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">OLFACTORY DISCOVERY</span>
        <h1 class="font-serif display-5 text-light-parchment mb-4 fw-normal">
            Search Results for "{{ $q }}"
        </h1>

        <!-- Search Bar -->
        <form action="{{ route('pages.search') }}" method="GET" class="position-relative mx-auto" style="max-width: 576px;">
            <input 
                type="text" 
                name="q" 
                value="{{ $q }}" 
                placeholder="Search notes (Oud, Amber, Taif Rose), designer names..." 
                class="form-control form-control-luxury text-sm py-2-5 px-3 rounded-pill pe-5"
            >
            <button type="submit" class="position-absolute end-0 top-50 translate-middle-y me-1 btn-gold px-3 py-1 rounded-pill text-xs fw-semibold text-uppercase tracking-wider">
                Search
            </button>
        </form>
    </div>
</section>

<!-- Search Results Grid -->
<section class="py-5" style="background-color: #050203;">
    <div class="container px-3 px-lg-4">
        @if($products->count() > 0)
            <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-gold-20">
                <p class="text-xs text-muted-parchment tracking-wider mb-0">
                    Found <span class="text-gold fw-semibold">{{ $products->total() }}</span> matching compositions
                </p>
                <a href="{{ route('collections.show', 'all') }}" class="text-xs text-gold text-gold-hover text-decoration-none text-uppercase tracking-wider">
                    Browse All Masterpieces &rarr;
                </a>
            </div>

            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
                @foreach($products as $product)
                    <div class="col">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-5 bg-wine-card border border-gold-25 rounded-4 mx-auto p-4 p-md-5 d-flex flex-column align-items-center gap-3" style="max-width: 672px;">
                <i class="fas fa-search text-gold opacity-50 fs-1 mb-1"></i>
                <h3 class="font-serif fs-4 text-light-parchment mb-0">No Matching Compositions</h3>
                <p class="text-xs text-muted-parchment mx-auto mb-2" style="max-width: 440px;">
                    We could not find any perfumes matching "{{ $q }}". Try searching for fragrance notes like "Oud", "Saffron", "Taif Rose", or "Amber".
                </p>
                <div>
                    <a href="{{ route('collections.show', 'all') }}" class="btn-gold py-3 px-4 text-xs text-uppercase tracking-widest d-inline-block text-decoration-none">
                        EXPLORE ALL PERFUMES
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

@endsection
