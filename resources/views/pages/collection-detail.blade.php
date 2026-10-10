@extends('layouts.app')

@section('title', ($collection ? $collection->name : 'All Fragrance Masterpieces') . ' | Perfumes Collection Pakistan')
@section('meta_description', $collection ? $collection->description : 'Explore our private reserve collection of pure Extrait de Parfum impressions crafted for connoisseurs in Pakistan.')

@section('content')

<!-- Collection Hero Banner -->
<section class="py-5 overflow-hidden" style="background: #FAF7F2; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4 text-center">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Collections', 'url' => route('collections.show', 'all')],
            ['label' => $collection ? $collection->name : 'All Impressions']
        ]" />

        <span class="d-inline-block mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase; color: #541B29;">HAUTE PARFUMERIE COLLECTION</span>
        <h1 class="font-serif mb-3 fw-normal display-5 tracking-wide" style="color: #211D1E !important;">
            {{ $collection ? $collection->name : 'All Fragrance Impressions' }}
        </h1>
        <p class="mx-auto lh-base mb-0" style="max-width: 672px; font-size: 0.95rem; color: #6B605B;">
            {{ $collection && $collection->description ? $collection->description : 'Handcrafted French-Oriental compositions macerated with up to 40% natural perfume compounds for unprecedented 14+ hours sillage in Pakistan.' }}
        </p>
    </div>
</section>

<!-- Collection Main Content -->
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
            
            <!-- Mobile Drawer Header -->
            <div class="d-flex align-items-center justify-content-between pb-3 mb-3 flex-shrink-0" style="border-bottom: 1px solid #E8E0DA;">
                <h3 class="font-serif fs-5 mb-0 d-flex align-items-center gap-2" style="color: #211D1E !important;">
                    <i class="fas fa-sliders-h fs-6" style="color: #541B29;"></i>
                    <span>Refine Selection</span>
                </h3>
                <button type="button" @click="mobileFiltersOpen = false"
                    class="border-0 bg-transparent fs-2 p-1 d-flex align-items-center justify-content-center"
                    style="width: 44px; height: 44px; touch-action: manipulation; color: #211D1E;"
                    aria-label="Close filters">&times;</button>
            </div>

            <!-- Mobile Drawer Form Content -->
            <div class="flex-grow-1 overflow-y-auto pe-1">
                @include('partials.collection-filters', ['formId' => 'mobileCollectionFilterForm', 'isMobileDrawer' => true])
            </div>

            <!-- Mobile Drawer Sticky Action Footer -->
            <div class="pt-3 mt-2 flex-shrink-0 d-flex align-items-center gap-2" style="border-top: 1px solid #E8E0DA;">
                <button type="button" @click="mobileFiltersOpen = false" class="flex-grow-1 py-2.5 text-center text-xs text-uppercase tracking-wider fw-semibold rounded-3 text-white border-0 shadow-sm" style="background-color: #541B29;">
                    View {{ $products->total() }} Compositions
                </button>
                @if(request()->hasAny(['family', 'note', 'volume_ml', 'min_price', 'max_price', 'q']))
                    <a href="{{ url()->current() }}" class="py-2 px-3 text-center text-xs text-uppercase tracking-wider rounded-3 text-decoration-none shadow-sm" style="background-color: #FFFFFF; border: 1px solid #541B29; color: #541B29;">
                        Reset
                    </a>
                @endif
            </div>
        </div>

        <!-- Filter Bar & Sort Controls Header -->
        <div class="collection-controls-bar mb-4">
            <div class="d-flex align-items-center justify-content-between gap-2">
                <!-- Left: Mobile Filter Button (Mobile) or Results Counter (Desktop) -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Mobile Filter Toggle Button -->
                    <button 
                        type="button" 
                        @click="mobileFiltersOpen = !mobileFiltersOpen"
                        class="d-lg-none d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-xs fw-semibold border shadow-sm"
                        style="background-color: #FFFFFF; border-color: #E8E0DA !important; color: #211D1E;"
                        aria-label="Toggle Filters"
                    >
                        <i class="fas fa-sliders-h" style="color: #541B29;"></i>
                        <span>Filters</span>
                        @php
                            $activeFilterCount = (request('q') ? 1 : 0) 
                                + (request('family') ? 1 : 0) 
                                + (request('note') ? 1 : 0) 
                                + (request('volume_ml') ? 1 : 0) 
                                + (request('min_price') || request('max_price') ? 1 : 0);
                        @endphp
                        @if($activeFilterCount > 0)
                            <span class="badge rounded-pill fw-bold px-1.5 py-0.5 text-white" style="font-size: 9px; min-width: 16px; background-color: #541B29;">{{ $activeFilterCount }}</span>
                        @endif
                    </button>

                    <!-- Desktop Results Counter -->
                    <div class="d-none d-lg-block collection-results-count" style="font-size: 0.85rem; letter-spacing: 0.03em; color: #6B605B;">
                        Showing <span class="fw-bold" style="color: #541B29;">{{ $products->total() }}</span> Extrait Masterpieces
                    </div>
                </div>

                <!-- Right: Mobile Results Text & Desktop Sort Controls -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Mobile Right Text -->
                    <div class="text-end d-lg-none collection-results-count" style="font-size: 0.76rem; letter-spacing: 0.02em; white-space: nowrap; color: #6B605B;">
                        Showing <span class="fw-bold" style="color: #541B29;">{{ $products->total() }}</span> Compositions
                    </div>

                    <!-- Desktop Sort Form Controls -->
                    <form action="{{ url()->current() }}" method="GET" class="d-none d-lg-flex align-items-center gap-2">
                        @foreach(request()->except('sort', 'page') as $key => $val)
                            @if(is_array($val))
                                @foreach($val as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endif
                        @endforeach
                        
                        <label for="sortSelect" class="text-xs text-uppercase tracking-widest fw-semibold mb-0" style="color: #211D1E;">Sort By:</label>
                        <div class="position-relative">
                            <select 
                                name="sort" 
                                id="sortSelect" 
                                onchange="this.form.submit()" 
                                class="form-select shadow-sm text-xs py-1.5 pe-4 ps-2.5 rounded-3"
                                style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #211D1E;"
                            >
                                <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured Creations</option>
                                <option value="bestseller" {{ request('sort') == 'bestseller' ? 'selected' : '' }}>Most Coveted (Bestsellers)</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Releases</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row g-4">
            
            <!-- Desktop Sidebar Filters (Permanently in grid flow on desktop) -->
            <aside class="col-12 col-lg-3 d-none d-lg-block">
                <div class="rounded-4 p-4 shadow-sm sticky-top" style="top: 100px; max-height: calc(100vh - 120px); overflow-y: auto; background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    @include('partials.collection-filters', ['formId' => 'collectionFilterForm', 'isMobileDrawer' => false])
                </div>
            </aside>

            <!-- Products Grid (2 Columns Mobile, 3 Columns Desktop) -->
            <main class="col-12 col-lg-9">
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
                    <div class="text-center py-5 rounded-4 p-4 d-flex flex-column align-items-center gap-3 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                        <i class="fas fa-gem" style="font-size: 2.5rem; color: #541B29;"></i>
                        <h3 class="font-serif fs-4 mb-1 fw-normal" style="color: #211D1E !important;">No Fragrance Impressions Found</h3>
                        <p class="mb-4" style="font-size: 0.9rem; max-width: 440px; color: #6B605B;">
                            No creations matched your refined criteria. Try broadening your notes or price selection.
                        </p>
                        <a href="{{ route('collections.show', 'all') }}" class="d-inline-block py-3 px-4 text-xs text-uppercase tracking-widest text-white text-decoration-none shadow-sm rounded-3" style="background-color: #541B29;">
                            EXPLORE ALL CREATIONS
                        </a>
                    </div>
                @endif
            </main>

        </div>
    </div>
</section>

@endsection
