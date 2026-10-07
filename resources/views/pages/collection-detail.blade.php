@extends('layouts.app')

@section('title', ($collection ? $collection->name : 'All Fragrance Masterpieces') . ' | Perfumes Collection Pakistan')
@section('meta_description', $collection ? $collection->description : 'Explore our private reserve collection of pure Extrait de Parfum impressions crafted for connoisseurs in Pakistan.')

@section('content')

<!-- Collection Hero Banner -->
<section class="py-5 border-bottom border-gold-20 text-white overflow-hidden" style="background: linear-gradient(to bottom, #18050b, #0d0305, #050203);">
    <div class="container px-3 px-lg-4 text-center">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Collections', 'url' => route('collections.show', 'all')],
            ['label' => $collection ? $collection->name : 'All Impressions']
        ]" />

        <span class="d-inline-block text-gold mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">HAUTE PARFUMERIE COLLECTION</span>
        <h1 class="font-serif text-light-parchment mb-3 fw-normal display-5 tracking-wide">
            {{ $collection ? $collection->name : 'All Fragrance Impressions' }}
        </h1>
        <p class="mx-auto text-muted-parchment lh-base mb-0" style="max-width: 672px; font-size: 0.95rem;">
            {{ $collection && $collection->description ? $collection->description : 'Handcrafted French-Oriental compositions macerated with up to 40% natural perfume compounds for unprecedented 14+ hours sillage in Pakistan.' }}
        </p>
    </div>
</section>

<!-- Collection Main Content -->
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
            
            <!-- Mobile Drawer Header -->
            <div class="d-flex align-items-center justify-content-between pb-3 border-bottom border-gold-20 mb-3 flex-shrink-0">
                <h3 class="font-serif fs-5 text-light-parchment mb-0 d-flex align-items-center gap-2">
                    <i class="fas fa-sliders-h text-gold fs-6"></i>
                    <span>Refine Selection</span>
                </h3>
                <button type="button" @click="mobileFiltersOpen = false"
                    class="border-0 bg-transparent text-ivory fs-2 p-1 d-flex align-items-center justify-content-center"
                    style="width: 44px; height: 44px; touch-action: manipulation;"
                    aria-label="Close filters">&times;</button>
            </div>

            <!-- Mobile Drawer Form Content -->
            <div class="flex-grow-1 overflow-y-auto pe-1">
                @include('partials.collection-filters', ['formId' => 'mobileCollectionFilterForm', 'isMobileDrawer' => true])
            </div>
        </div>

        <!-- Filter Bar & Sort Controls Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 mb-4 border-bottom border-gold-20">
            <!-- Mobile Filter Toggle -->
            <button 
                type="button" 
                @click="mobileFiltersOpen = !mobileFiltersOpen"
                class="d-lg-none d-flex align-items-center gap-2 px-3 py-2 border border-gold-30 text-light-parchment text-xs text-uppercase tracking-widest rounded-3 bg-wine-card transition"
            >
                <i class="fas fa-sliders-h text-gold"></i>
                <span>Filters & Notes</span>
            </button>

            <!-- Results Counter -->
            <div class="text-xs text-muted-parchment tracking-wider">
                Showing <span class="text-gold fw-bold">{{ $products->total() }}</span> Extrait Masterpieces
            </div>

            <!-- Sort Form -->
            <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center gap-2">
                @foreach(request()->except('sort', 'page') as $key => $val)
                    @if(is_array($val))
                        @foreach($val as $v)
                            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endif
                @endforeach
                
                <label for="sortSelect" class="text-xs text-uppercase tracking-widest text-gold d-none d-sm-inline fw-semibold mb-0">Sort By:</label>
                <div class="position-relative">
                    <select 
                        name="sort" 
                        id="sortSelect" 
                        onchange="this.form.submit()" 
                        class="form-select form-control-luxury text-xs py-2 px-3 rounded-3"
                        style="width: auto;"
                    >
                        <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }} class="bg-wine-dark text-light-parchment">Featured Creations</option>
                        <option value="bestseller" {{ request('sort') == 'bestseller' ? 'selected' : '' }} class="bg-wine-dark text-light-parchment">Most Coveted (Bestsellers)</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }} class="bg-wine-dark text-light-parchment">Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }} class="bg-wine-dark text-light-parchment">Price: High to Low</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }} class="bg-wine-dark text-light-parchment">Highest Rated</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }} class="bg-wine-dark text-light-parchment">Newest Releases</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="row g-4">
            
            <!-- Desktop Sidebar Filters (Permanently in grid flow on desktop) -->
            <aside class="col-12 col-lg-3 d-none d-lg-block">
                <div class="bg-wine-card border border-gold-25 rounded-4 p-4 shadow-xl sticky-top" style="top: 100px; max-height: calc(100vh - 120px); overflow-y: auto;">
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
                    <div class="text-center py-5 bg-wine-card border border-gold-25 rounded-4 p-4 d-flex flex-column align-items-center gap-3">
                        <i class="fas fa-gem text-gold" style="font-size: 2.5rem;"></i>
                        <h3 class="font-serif fs-4 text-light-parchment mb-1 fw-normal">No Fragrance Impressions Found</h3>
                        <p class="text-muted-parchment mb-4" style="font-size: 0.9rem; max-width: 440px;">
                            No creations matched your refined criteria. Try broadening your notes or price selection.
                        </p>
                        <a href="{{ route('collections.show', 'all') }}" class="btn-gold d-inline-block py-3 px-4 text-xs text-uppercase tracking-widest text-decoration-none">
                            EXPLORE ALL CREATIONS
                        </a>
                    </div>
                @endif
            </main>

        </div>
    </div>
</section>

@endsection
