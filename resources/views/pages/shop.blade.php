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
<section class="py-5" style="background-color: #050203;">
    <div class="container px-3 px-lg-4">
        <div class="row g-4 align-items-start">
            
            <!-- Left: Luxury Olfactory Filter Sidebar (lg:col-3) -->
            <aside class="col-12 col-lg-3">
                <div class="bg-wine-card border border-gold-25 rounded-4 p-4 sticky-top shadow-xl d-flex flex-column gap-4" style="top: 112px;">
                    <div class="d-flex justify-content-between align-items-center pb-3 border-bottom border-gold-20">
                        <h3 class="text-light-parchment fw-bold d-flex align-items-center gap-2 mb-0" style="font-size: 12px; letter-spacing: 0.2em; text-transform: uppercase;">
                            <i class="fas fa-sliders-h text-gold"></i> FILTER SCENTS
                        </h3>
                        <a href="{{ route('shop.index') }}" class="text-muted-parchment text-gold-hover transition text-decoration-none" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Reset All</a>
                    </div>

                    <form action="{{ route('shop.index') }}" method="GET" id="catalogFilterForm" class="d-flex flex-column gap-4">
                        <!-- Search Input -->
                        <div>
                            <label class="d-block text-gold fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Keywords / Impressions</label>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search notes, designer names..." class="form-control form-control-luxury py-2 px-3 text-xs">
                        </div>

                        <!-- Collections / Categories -->
                        <div>
                            <label class="d-block text-gold fw-semibold mb-3" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Categories</label>
                            <div class="d-flex flex-column gap-2">
                                <label class="d-flex align-items-center justify-content-between cursor-pointer mb-0 {{ !request('category') ? 'text-gold fw-bold' : 'text-light-parchment text-gold-hover' }}" style="font-size: 12px;">
                                    <span class="d-flex align-items-center gap-2">
                                        <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()" class="form-check-input bg-transparent border-gold-40 m-0"> 
                                        All Categories
                                    </span>
                                </label>
                                @foreach($categories as $cat)
                                    <label class="d-flex align-items-center justify-content-between cursor-pointer mb-0 {{ request('category') == $cat->slug ? 'text-gold fw-bold' : 'text-light-parchment text-gold-hover' }}" style="font-size: 12px;">
                                        <span class="d-flex align-items-center gap-2">
                                            <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()" class="form-check-input bg-transparent border-gold-40 m-0"> 
                                            {{ $cat->name }}
                                        </span>
                                        <span class="text-muted-parchment" style="font-size: 10px;">({{ $cat->active_products_count }})</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Olfactory Families -->
                        <div>
                            <label class="d-block text-gold fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Fragrance Family</label>
                            <select name="family" onchange="this.form.submit()" class="form-select form-control-luxury text-xs py-2 px-3">
                                <option value="" class="bg-wine-dark text-light-parchment">All Fragrance Families</option>
                                @foreach($fragranceFamilies as $fam)
                                    <option value="{{ $fam->slug }}" {{ request('family') == $fam->slug ? 'selected' : '' }} class="bg-wine-dark text-light-parchment">
                                        {{ $fam->name }} ({{ $fam->products_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Gender / Aura -->
                        <div>
                            <label class="d-block text-gold fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Gender Persona</label>
                            <div class="row g-1">
                                @foreach(['Unisex', 'Men', 'Women'] as $g)
                                    <div class="col-4">
                                        <label class="p-2 border rounded-3 text-center cursor-pointer transition d-block w-100 mb-0 {{ request('gender') == $g ? 'bg-wine-accent border-gold text-gold-soft fw-bold' : 'bg-wine-dark border-gold-25 text-light-parchment' }}" style="font-size: 12px;">
                                            <input type="radio" name="gender" value="{{ $g }}" {{ request('gender') == $g ? 'checked' : '' }} class="d-none" onchange="this.form.submit()">
                                            {{ $g }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range (PKR) -->
                        <div>
                            <label class="d-block text-gold fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Price Range (PKR)</label>
                            <div class="d-flex gap-2 align-items-center mb-3">
                                <input type="number" name="min_price" value="{{ request('min_price', 1500) }}" placeholder="Min" class="form-control form-control-luxury text-xs py-2 px-2 text-center" style="width: calc(50% - 10px);">
                                <span class="text-muted-parchment">-</span>
                                <input type="number" name="max_price" value="{{ request('max_price', 15000) }}" placeholder="Max" class="form-control form-control-luxury text-xs py-2 px-2 text-center" style="width: calc(50% - 10px);">
                            </div>
                            <button type="submit" class="w-100 btn-gold py-2 text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.05em;">Apply Price Filter</button>
                        </div>

                        <!-- Key Scent Notes -->
                        <div>
                            <label class="d-block text-gold fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase;">Signature Note Accord</label>
                            <div class="d-flex flex-wrap gap-1 overflow-y-auto no-scrollbar" style="max-height: 160px;">
                                @foreach($scentNotes as $note)
                                    <a href="{{ request()->fullUrlWithQuery(['note' => $note->slug]) }}" 
                                       class="px-2 py-1 rounded border transition text-decoration-none {{ request('note') == $note->slug ? 'bg-wine-accent border-gold text-gold-soft fw-bold' : 'bg-wine-dark border-gold-20 text-muted-parchment text-gold-hover' }}"
                                       style="font-size: 11px;">
                                        {{ $note->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Right: Products Grid & Top Sort Bar (lg:col-9) -->
            <div class="col-12 col-lg-9 d-flex flex-column gap-4">
                <!-- Top Sorting Bar -->
                <div class="bg-wine-card border border-gold-25 rounded-3 p-3 d-flex flex-wrap justify-content-between align-items-center gap-3 shadow-sm">
                    <div class="text-muted-parchment" style="font-size: 12px;">
                        Showing <strong class="text-light-parchment">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong> of <strong class="text-gold">{{ $products->total() }}</strong> Flacons
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <label class="text-gold fw-semibold mb-0" style="font-size: 12px; letter-spacing: 0.05em; text-transform: uppercase;">Sort By:</label>
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
