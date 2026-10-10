@extends('layouts.app')

@section('title', 'Search Fragrance Vault: ' . ($q ? e($q) : 'All') . ' | Perfumes Collection Pakistan')

@section('content')

<!-- Search Results Banner -->
<section class="py-5 text-center" style="background: #FAF7F2; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4" style="max-width: 768px;">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Vault Search']
        ]" />

        <span class="d-inline-block mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase; color: #541B29;">OLFACTORY DISCOVERY</span>
        <h1 class="font-serif display-5 mb-4 fw-normal" style="color: #211D1E !important;">
            Search Results for "{{ $q }}"
        </h1>

        <!-- Search Bar -->
        <form action="{{ route('pages.search') }}" method="GET" class="position-relative mx-auto" style="max-width: 576px;">
            <input 
                type="text" 
                name="q" 
                value="{{ $q }}" 
                placeholder="Search notes (Oud, Amber, Taif Rose), designer names..." 
                class="form-control text-sm py-2-5 px-3 rounded-3 pe-5 shadow-xs"
                style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #211D1E;"
            >
            <button type="submit" class="position-absolute end-0 top-50 translate-middle-y me-1 px-3 py-1 rounded-2 text-xs fw-semibold text-uppercase tracking-wider text-white border-0 shadow-xs" style="background-color: #541B29;">
                Search
            </button>
        </form>
    </div>
</section>

<!-- Search Results Grid -->
<section class="py-5" style="background-color: #F7F3EE;">
    <div class="container px-3 px-lg-4">
        @if($products->count() > 0)
            <div class="d-flex align-items-center justify-content-between mb-4 pb-3" style="border-bottom: 1px solid #E8E0DA;">
                <p class="text-xs tracking-wider mb-0" style="color: #6B605B;">
                    Found <span class="fw-semibold" style="color: #541B29;">{{ $products->total() }}</span> matching compositions
                </p>
                <a href="{{ route('collections.show', 'all') }}" class="text-xs text-decoration-none text-uppercase tracking-wider fw-semibold" style="color: #541B29;">
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
            <div class="text-center py-5 rounded-4 mx-auto p-4 p-md-5 d-flex flex-column align-items-center gap-3 shadow-sm" style="max-width: 672px; background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                <i class="fas fa-search fs-1 mb-1" style="color: #541B29; opacity: 0.7;"></i>
                <h3 class="font-serif fs-4 mb-0" style="color: #211D1E !important;">No Matching Compositions</h3>
                <p class="text-xs mx-auto mb-2" style="max-width: 440px; color: #6B605B;">
                    We could not find any perfumes matching "{{ $q }}". Try searching for fragrance notes like "Oud", "Saffron", "Taif Rose", or "Amber".
                </p>
                <div>
                    <a href="{{ route('collections.show', 'all') }}" class="py-3 px-4 text-xs text-uppercase tracking-widest d-inline-block text-decoration-none text-white shadow-sm rounded-3" style="background-color: #541B29;">
                        EXPLORE ALL PERFUMES
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

@endsection
