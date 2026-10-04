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
<section class="py-5" style="background-color: #050203;" x-data="{ mobileFiltersOpen: false }">
    <div class="container px-3 px-lg-4">
        
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
            
            <!-- Sidebar Filters -->
            <aside 
                :class="mobileFiltersOpen ? 'd-block position-fixed top-0 start-0 w-100 h-100 z-50 p-4 overflow-y-auto' : 'd-none d-lg-block'"
                class="col-12 col-lg-3"
                style="z-index: 1050;"
            >
                <div class="bg-wine-card border border-gold-25 rounded-4 p-4 shadow-xl">
                    <!-- Mobile Filter Close Button -->
                    <div class="d-flex d-lg-none align-items-center justify-content-between pb-3 border-bottom border-gold-20 mb-4">
                        <h3 class="font-serif fs-5 text-light-parchment mb-0">Refine Selection</h3>
                        <button type="button" @click="mobileFiltersOpen = false" class="btn text-muted-parchment text-gold-hover fs-4 p-0">&times;</button>
                    </div>

                    <form action="{{ url()->current() }}" method="GET" id="collectionFilterForm">
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        <!-- Quick Search in Collection -->
                        <div class="mb-4">
                            <label class="d-block text-xs text-uppercase tracking-widest text-gold fw-semibold mb-2">Search Catalog</label>
                            <div class="position-relative">
                                <input 
                                    type="text" 
                                    name="q" 
                                    value="{{ request('q') }}" 
                                    placeholder="Search note or impression..." 
                                    class="form-control form-control-luxury text-xs py-2 px-3"
                                >
                                @if(request('q'))
                                    <a href="{{ url()->current() }}" class="position-absolute end-0 top-50 translate-middle-y me-3 text-muted-parchment text-light-parchment-hover text-xs text-decoration-none">&times;</a>
                                @endif
                            </div>
                        </div>

                        <!-- Filter 1: Collections Navigation -->
                        <div class="border-top border-gold-20 pt-4 mb-4">
                            <h4 class="text-xs text-uppercase tracking-widest text-gold fw-semibold mb-3 d-flex align-items-center justify-content-between">
                                <span>Houses & Categories</span>
                                <i class="fas fa-chevron-down text-muted-parchment" style="font-size: 10px;"></i>
                            </h4>
                            <ul class="list-unstyled mb-0 d-flex flex-column gap-2 text-xs">
                                <li>
                                    <a href="{{ route('collections.show', 'all') }}" class="d-block py-1 text-decoration-none {{ $slug === 'all' ? 'text-gold fw-bold' : 'text-muted-parchment text-light-parchment-hover' }}">
                                        All Impressions
                                    </a>
                                </li>
                                @foreach($allCollections as $col)
                                    <li>
                                        <a href="{{ route('collections.show', $col->slug) }}" class="d-block py-1 text-decoration-none {{ $slug === $col->slug ? 'text-gold fw-bold' : 'text-muted-parchment text-light-parchment-hover' }}">
                                            {{ $col->name }}
                                        </a>
                                    </li>
                                @endforeach
                                <li>
                                    <a href="{{ route('collections.show', 'bundles') }}" class="d-block py-1 text-gold-soft fw-semibold text-decoration-none d-flex align-items-center justify-content-between">
                                        <span>Curated Bundles</span>
                                        <span class="bg-wine-accent text-gold-soft border border-gold-30 px-2 py-0-5 rounded fw-bold" style="font-size: 9px;">SAVE 25%</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Filter 2: Fragrance Family -->
                        <div class="border-top border-gold-20 pt-4 mb-4">
                            <h4 class="text-xs text-uppercase tracking-widest text-gold fw-semibold mb-3">
                                Fragrance Family
                            </h4>
                            <div class="d-flex flex-column gap-2 overflow-y-auto pe-2 no-scrollbar" style="max-height: 192px;">
                                @foreach($fragranceFamilies as $family)
                                    <label class="d-flex align-items-center justify-content-between text-xs text-muted-parchment cursor-pointer text-light-parchment-hover mb-0">
                                        <span class="d-flex align-items-center gap-2">
                                            <input 
                                                 type="radio" 
                                                 name="family" 
                                                 value="{{ $family->slug }}" 
                                                 {{ request('family') == $family->slug ? 'checked' : '' }} 
                                                 onchange="this.form.submit()"
                                                 class="form-check-input bg-transparent border-gold-40 m-0"
                                             >
                                             <span class="{{ request('family') == $family->slug ? 'text-gold fw-bold' : '' }}">{{ $family->name }}</span>
                                         </span>
                                         <span class="text-muted-parchment" style="font-size: 10px;">({{ $family->products_count }})</span>
                                     </label>
                                 @endforeach
                             </div>
                         </div>

                        <!-- Filter 3: Scent Notes -->
                        <div class="border-top border-gold-20 pt-4 mb-4">
                            <h4 class="text-xs text-uppercase tracking-widest text-gold fw-semibold mb-3">
                                Signature Notes
                            </h4>
                            <div class="d-flex flex-wrap gap-1 overflow-y-auto pe-1 no-scrollbar" style="max-height: 160px;">
                                @foreach($scentNotes as $note)
                                    <a 
                                        href="{{ request()->fullUrlWithQuery(['note' => request('note') == $note->slug ? null : $note->slug]) }}" 
                                        class="px-2 py-1 rounded border transition text-decoration-none {{ request('note') == $note->slug ? 'bg-wine-accent text-gold-soft border-gold fw-semibold' : 'border-gold-20 bg-wine-dark text-muted-parchment text-gold-hover' }}"
                                        style="font-size: 11px;"
                                    >
                                        {{ $note->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Filter 4: Volume / Size (ml) -->
                        <div class="border-top border-gold-20 pt-4 mb-4">
                            <h4 class="text-xs text-uppercase tracking-widest text-gold fw-semibold mb-3">
                                Flacon Volume
                            </h4>
                            <div class="row g-2 text-xs">
                                @foreach([10, 50, 100] as $vol)
                                    <div class="col-4">
                                        <button 
                                            type="button" 
                                            onclick="window.location.href='{{ request()->fullUrlWithQuery(['volume_ml' => request('volume_ml') == $vol ? null : $vol]) }}'"
                                            class="w-100 py-2 text-center rounded-3 border transition {{ request('volume_ml') == $vol ? 'bg-wine-accent text-gold-soft border-gold fw-semibold' : 'border-gold-25 bg-wine-dark text-muted-parchment text-light-parchment-hover' }}"
                                        >
                                            {{ $vol }} ml
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Filter 5: Price Range (PKR) -->
                        <div class="border-top border-gold-20 pt-4 mb-4">
                            <h4 class="text-xs text-uppercase tracking-widest text-gold fw-semibold mb-3">
                                Price Range (PKR)
                            </h4>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <input 
                                    type="number" 
                                    name="min_price" 
                                    value="{{ request('min_price') }}" 
                                    placeholder="Min Rs." 
                                    class="form-control form-control-luxury text-xs py-2 px-2 text-center"
                                    style="width: calc(50% - 10px);"
                                >
                                <span class="text-muted-parchment">-</span>
                                <input 
                                    type="number" 
                                    name="max_price" 
                                    value="{{ request('max_price') }}" 
                                    placeholder="Max Rs." 
                                    class="form-control form-control-luxury text-xs py-2 px-2 text-center"
                                    style="width: calc(50% - 10px);"
                                >
                            </div>
                            <button type="submit" class="w-100 btn-gold py-2 text-uppercase fw-semibold" style="font-size: 10px; letter-spacing: 0.1em;">
                                Apply Price
                            </button>
                        </div>

                        <!-- Reset Filters -->
                        @if(request()->hasAny(['family', 'note', 'volume_ml', 'min_price', 'max_price', 'q']))
                            <a href="{{ url()->current() }}" class="d-block text-center text-xs text-danger py-2 border border-danger-subtle rounded text-uppercase tracking-wider fw-semibold text-decoration-none">
                                <i class="fas fa-undo me-1"></i> Clear All Filters
                            </a>
                        @endif
                    </form>
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
