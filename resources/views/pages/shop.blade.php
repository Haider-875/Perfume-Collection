@extends('layouts.app')

@section('title', 'The Fragrance Vault | Perfumes Collection Pakistan')

@section('content')

<!-- Header Breadcrumb & Title -->
<section class="py-5" style="background: #FAF7F2; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
            <div>
                <span class="fw-semibold d-block mb-2" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase; color: #541B29;">ARTISANAL CREATIONS</span>
                <h1 class="font-serif mb-2 fw-normal display-6" style="color: #211D1E !important;">
                    @if($currentCategory)
                        {{ $currentCategory->name }}
                    @elseif($currentFamily)
                        {{ $currentFamily->name }}
                    @elseif(request('gender'))
                        {{ ucfirst(request('gender')) }} Fragrances
                    @else
                        All Fragrance Impressions
                    @endif
                </h1>
                <p class="font-serif mb-0 lh-base" style="max-width: 672px; font-size: 1.05rem; color: #6B605B;">
                    @if($currentCategory)
                        {{ $currentCategory->description }}
                    @else
                        Explore our handcrafted 100% Extrait de Parfums and designer impressions formulated for extraordinary longevity and projection.
                    @endif
                </p>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span style="font-size: 12px; letter-spacing: 0.05em; text-transform: uppercase; color: #6B605B;">
                    Showing <strong style="color: #541B29;">{{ $products->total() }}</strong> Artisan Flacons
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Main Catalog Body -->
<section class="py-5" style="background-color: #F7F3EE;" 
         x-data="{ mobileFiltersOpen: false }"
         x-init="$watch('mobileFiltersOpen', val => document.body.classList.toggle('overflow-hidden', val))">
    <div class="container px-3 px-lg-4">

        <!-- Mobile Filter Backdrop (d-lg-none) -->
        <div x-show="mobileFiltersOpen"
             x-cloak
             @click="mobileFiltersOpen = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="mobile-offcanvas-backdrop d-lg-none"
             style="z-index: 1055;"></div>

        <!-- Mobile Filter Offcanvas Drawer (d-lg-none) -->
        <div x-show="mobileFiltersOpen"
             x-cloak
             @keydown.escape.window="mobileFiltersOpen = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-x-full" 
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 -translate-x-full"
             class="mobile-filter-drawer p-3 p-sm-4 d-lg-none shadow-lg"
             style="z-index: 1060; background-color: #FFFFFF; color: #211D1E; border-right: 1px solid #E8E0DA;">
            <div class="flex-grow-1 overflow-y-auto pe-1">
                @include('partials.shop-filters', ['formId' => 'mobileCatalogFilterForm', 'isMobileDrawer' => true])
            </div>
        </div>

        <div class="row g-4 align-items-start">
            <!-- Left: Luxury Olfactory Filter Sidebar (lg:col-3, Desktop only) -->
            <aside class="col-12 col-lg-3 d-none d-lg-block">
                <div class="rounded-4 p-4 sticky-top shadow-sm d-flex flex-column gap-4" style="top: 112px; max-height: calc(100vh - 140px); overflow-y: auto; background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    @include('partials.shop-filters', ['formId' => 'catalogFilterForm', 'isMobileDrawer' => false])
                </div>
            </aside>

            <!-- Right: Products Grid & Top Sort Bar (lg:col-9) -->
            <div class="col-12 col-lg-9 d-flex flex-column gap-4">
                <!-- Top Sorting Bar with Mobile Filter Toggle -->
                <div class="collection-controls-bar mb-3">
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <!-- Left: Mobile Filter Button & Desktop Counter -->
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" 
                                    @click="mobileFiltersOpen = true"
                                    class="d-lg-none d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-xs fw-semibold border shadow-sm"
                                    style="background-color: #FFFFFF; border-color: #E8E0DA !important; color: #211D1E;"
                                    aria-label="Open filter and scent notes drawer">
                                <i class="fas fa-filter" style="color: #541B29;"></i>
                                <span>Filters & Notes</span>
                                @php
                                    $activeFilterCountShop = (request('q') ? 1 : 0) 
                                        + (request('family') ? 1 : 0) 
                                        + (request('gender') ? 1 : 0) 
                                        + (request('season') ? 1 : 0) 
                                        + (request('min_price') || request('max_price') ? 1 : 0);
                                @endphp
                                @if($activeFilterCountShop > 0)
                                    <span class="badge rounded-pill fw-bold px-1.5 py-0.5 text-white" style="font-size: 9px; min-width: 16px; background-color: #541B29;">{{ $activeFilterCountShop }}</span>
                                @endif
                            </button>
                            <div class="d-none d-lg-block collection-results-count" style="font-size: 0.85rem; letter-spacing: 0.03em; color: #6B605B;">
                                Showing <strong style="color: #211D1E;">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong> of <strong style="color: #541B29;">{{ $products->total() }}</strong> Flacons
                            </div>
                        </div>

                        <!-- Right: Mobile Counter & Desktop Sort -->
                        <div class="d-flex align-items-center gap-2">
                            <!-- Mobile Right Text -->
                            <div class="text-end d-lg-none collection-results-count" style="font-size: 0.76rem; letter-spacing: 0.02em; white-space: nowrap; color: #6B605B;">
                                <strong style="color: #541B29;">{{ $products->total() }}</strong> Flacons
                            </div>

                            <!-- Desktop Sort -->
                            <div class="d-none d-lg-flex align-items-center gap-2">
                                <label class="fw-semibold mb-0" style="font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; color: #211D1E;">Sort By:</label>
                                <select onchange="location = this.value;" class="form-select shadow-sm text-xs py-1.5 pe-4 ps-2.5 rounded-3" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #211D1E;">
                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'bestseller']) }}" {{ request('sort') == 'bestseller' ? 'selected' : '' }}>Bestsellers</option>
                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Releases</option>
                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top Rated</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="row row-cols-2 row-cols-md-3 g-3 g-md-4">
                        @foreach($products as $product)
                            <div class="col">
                                <x-product-card :product="$product" />
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="p-5 text-center rounded-4 d-flex flex-column align-items-center gap-3 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                        <i class="fas fa-search" style="font-size: 2rem; color: #541B29;"></i>
                        <h3 class="font-serif fs-4 mb-0" style="color: #211D1E !important;">No Fragrances Matching Your Criteria</h3>
                        <p class="font-serif mb-0" style="max-width: 440px; color: #6B605B;">
                            We could not find perfumes fitting your specific filter combinations. Try resetting filters or search by impression name.
                        </p>
                        <a href="{{ route('shop.index') }}" class="d-inline-block py-3 px-4 text-xs text-uppercase tracking-widest text-white text-decoration-none shadow-sm rounded-3" style="background-color: #541B29;">RESET ALL FILTERS</a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

@endsection
