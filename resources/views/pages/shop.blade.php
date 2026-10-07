@extends('layouts.app')

@section('title', 'The Fragrance Vault | Perfumes Collection Pakistan')

@section('content')

<!-- Header Breadcrumb & Title -->
<section class="py-5 border-bottom border-gold-20" style="background: linear-gradient(to bottom, #18050b, #0d0305, #050203);">
    <div class="container px-3 px-lg-4">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
            <div>
                <span class="text-gold fw-semibold d-block mb-2" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">ARTISANAL CREATIONS</span>
                <h1 class="font-serif text-light-parchment mb-2 fw-normal display-6">
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
                <p class="font-serif text-muted-parchment mb-0 lh-base" style="max-width: 672px; font-size: 1.05rem;">
                    @if($currentCategory)
                        {{ $currentCategory->description }}
                    @else
                        Explore our handcrafted 100% Extrait de Parfums and designer impressions formulated for extraordinary longevity and projection.
                    @endif
                </p>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="text-muted-parchment" style="font-size: 12px; letter-spacing: 0.05em; text-transform: uppercase;">
                    Showing <strong class="text-gold">{{ $products->total() }}</strong> Artisan Flacons
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Main Catalog Body -->
<section class="py-5" style="background-color: #050203;" 
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
             class="mobile-filter-drawer p-3 p-sm-4 d-lg-none"
             style="z-index: 1060;">
            <div class="flex-grow-1 overflow-y-auto pe-1">
                @include('partials.shop-filters', ['formId' => 'mobileCatalogFilterForm', 'isMobileDrawer' => true])
            </div>
        </div>

        <div class="row g-4 align-items-start">
            <!-- Left: Luxury Olfactory Filter Sidebar (lg:col-3, Desktop only) -->
            <aside class="col-12 col-lg-3 d-none d-lg-block">
                <div class="bg-wine-card border border-gold-25 rounded-4 p-4 sticky-top shadow-xl d-flex flex-column gap-4" style="top: 112px; max-height: calc(100vh - 140px); overflow-y: auto;">
                    @include('partials.shop-filters', ['formId' => 'catalogFilterForm', 'isMobileDrawer' => false])
                </div>
            </aside>

            <!-- Right: Products Grid & Top Sort Bar (lg:col-9) -->
            <div class="col-12 col-lg-9 d-flex flex-column gap-4">
                <!-- Top Sorting Bar with Mobile Filter Toggle -->
                <div class="bg-wine-card border border-gold-25 rounded-3 p-3 d-flex flex-wrap justify-content-between align-items-center gap-3 shadow-sm">
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" 
                                @click="mobileFiltersOpen = true"
                                class="d-lg-none d-flex align-items-center gap-2 px-3 py-2 border border-gold-30 text-light-parchment text-xs text-uppercase tracking-widest rounded-3 bg-wine-dark transition"
                                style="min-height: 38px;">
                            <i class="fas fa-sliders-h text-gold"></i>
                            <span>Filters & Notes</span>
                        </button>
                        <div class="text-muted-parchment" style="font-size: 12px;">
                            Showing <strong class="text-light-parchment">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong> of <strong class="text-gold">{{ $products->total() }}</strong> Flacons
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <label class="text-gold fw-semibold mb-0 d-none d-sm-inline" style="font-size: 12px; letter-spacing: 0.05em; text-transform: uppercase;">Sort By:</label>
                        <select onchange="location = this.value;" class="form-select form-control-luxury text-xs py-1 px-3" style="width: auto;">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}" {{ request('sort') == 'featured' ? 'selected' : '' }} class="bg-wine-dark text-light-parchment">Curated / Featured</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'bestseller']) }}" {{ request('sort') == 'bestseller' ? 'selected' : '' }} class="bg-wine-dark text-light-parchment">Bestsellers</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort') == 'newest' ? 'selected' : '' }} class="bg-wine-dark text-light-parchment">Newest Releases</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }} class="bg-wine-dark text-light-parchment">Price: Low to High</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }} class="bg-wine-dark text-light-parchment">Price: High to Low</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}" {{ request('sort') == 'rating' ? 'selected' : '' }} class="bg-wine-dark text-light-parchment">Top Rated</option>
                        </select>
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
                    <div class="bg-wine-card border border-gold-25 p-5 text-center rounded-4 d-flex flex-column align-items-center gap-3">
                        <i class="fas fa-search text-gold" style="font-size: 2rem;"></i>
                        <h3 class="font-serif text-light-parchment fs-4 mb-0">No Fragrances Matching Your Criteria</h3>
                        <p class="font-serif text-muted-parchment mb-0" style="max-width: 440px;">
                            We could not find perfumes fitting your specific filter combinations. Try resetting filters or search by impression name.
                        </p>
                        <a href="{{ route('shop.index') }}" class="btn-gold d-inline-block py-3 px-4 text-xs text-uppercase tracking-widest text-decoration-none">RESET ALL FILTERS</a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

@endsection
