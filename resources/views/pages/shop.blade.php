@extends('layouts.app')

@section('title', 'The Fragrance Vault | Perfumes Collection Pakistan')

@section('content')

<!-- Header Breadcrumb & Title -->
<section class="py-12 md:py-16 bg-gradient-to-b from-[#18050b] via-[#0d0305] to-[#050203] border-b border-[#d6aa62]/20">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex flex-wrap justify-between items-end gap-6">
            <div>
                <span class="text-[11px] uppercase tracking-[0.28em] text-[#d6aa62] font-semibold block mb-2">ARTISANAL CREATIONS</span>
                <h1 class="font-serif text-3xl md:text-5xl text-[#f5efe7] mb-2 font-normal">
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
                <p class="font-serif text-base md:text-lg text-[#b8a9a2] max-w-2xl leading-relaxed">
                    @if($currentCategory)
                        {{ $currentCategory->description }}
                    @else
                        Explore our handcrafted 100% Extrait de Parfums and designer impressions formulated for extraordinary longevity and projection.
                    @endif
                </p>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-xs uppercase tracking-wider text-[#b8a9a2]">
                    Showing <strong class="text-[#d6aa62]">{{ $products->total() }}</strong> Artisan Flacons
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Main Catalog Body -->
<section class="py-12 md:py-16 bg-[#050203]">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left: Luxury Olfactory Filter Sidebar (lg:col-span-3) -->
            <aside class="lg:col-span-3 bg-[#140408] border border-[#d6aa62]/25 rounded-2xl p-6 sticky top-28 shadow-xl space-y-6">
                <div class="flex justify-between items-center pb-4 border-b border-[#d6aa62]/20">
                    <h3 class="text-xs uppercase tracking-[0.2em] text-[#f5efe7] flex items-center gap-2 font-bold">
                        <i class="fas fa-sliders-h text-[#d6aa62]"></i> FILTER SCENTS
                    </h3>
                    <a href="{{ route('shop.index') }}" class="text-[11px] text-[#b8a9a2] hover:text-[#d6aa62] transition uppercase tracking-wider">Reset All</a>
                </div>

                <form action="{{ route('shop.index') }}" method="GET" id="catalogFilterForm" class="space-y-6">
                    <!-- Search Input -->
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider text-[#d6aa62] font-semibold mb-2">Keywords / Impressions</label>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search notes, designer names..." class="w-full bg-[#080204] border border-[#d6aa62]/30 rounded-lg px-3 py-2 text-xs text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:outline-none focus:border-[#d6aa62]">
                    </div>

                    <!-- Collections / Categories -->
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider text-[#d6aa62] font-semibold mb-3">Categories</label>
                        <div class="flex flex-col gap-2">
                            <label class="flex items-center justify-between text-xs cursor-pointer {{ !request('category') ? 'text-[#d6aa62] font-bold' : 'text-[#f5efe7] hover:text-[#d6aa62]' }}">
                                <span class="flex items-center gap-2">
                                    <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()" class="text-[#d6aa62]"> 
                                    All Categories
                                </span>
                            </label>
                            @foreach($categories as $cat)
                                <label class="flex items-center justify-between text-xs cursor-pointer {{ request('category') == $cat->slug ? 'text-[#d6aa62] font-bold' : 'text-[#f5efe7] hover:text-[#d6aa62]' }}">
                                    <span class="flex items-center gap-2">
                                        <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()" class="text-[#d6aa62]"> 
                                        {{ $cat->name }}
                                    </span>
                                    <span class="text-[10px] text-[#b8a9a2]">({{ $cat->active_products_count }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Olfactory Families -->
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider text-[#d6aa62] font-semibold mb-2">Fragrance Family</label>
                        <select name="family" onchange="this.form.submit()" class="w-full bg-[#080204] border border-[#d6aa62]/30 rounded-lg px-3 py-2 text-xs text-[#f5efe7] focus:outline-none focus:border-[#d6aa62]">
                            <option value="" class="bg-[#140408]">All Fragrance Families</option>
                            @foreach($fragranceFamilies as $fam)
                                <option value="{{ $fam->slug }}" {{ request('family') == $fam->slug ? 'selected' : '' }} class="bg-[#140408]">
                                    {{ $fam->name }} ({{ $fam->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Gender / Aura -->
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider text-[#d6aa62] font-semibold mb-2">Gender Persona</label>
                        <div class="grid grid-cols-3 gap-1.5">
                            @foreach(['Unisex', 'Men', 'Women'] as $g)
                                <label class="p-2 border rounded-lg text-center text-xs cursor-pointer transition {{ request('gender') == $g ? 'bg-[#4a0915] border-[#d6aa62] text-[#f0d59d] font-bold' : 'bg-[#18050b] border-[#d6aa62]/25 text-[#f5efe7] hover:border-[#d6aa62]' }}">
                                    <input type="radio" name="gender" value="{{ $g }}" {{ request('gender') == $g ? 'checked' : '' }} class="hidden" onchange="this.form.submit()">
                                    {{ $g }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range (PKR) -->
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider text-[#d6aa62] font-semibold mb-2">Price Range (PKR)</label>
                        <div class="flex gap-2 items-center mb-3">
                            <input type="number" name="min_price" value="{{ request('min_price', 1500) }}" placeholder="Min" class="w-1/2 bg-[#080204] border border-[#d6aa62]/30 rounded-lg p-2 text-xs text-[#f5efe7] focus:outline-none focus:border-[#d6aa62]">
                            <span class="text-[#b8a9a2]">-</span>
                            <input type="number" name="max_price" value="{{ request('max_price', 15000) }}" placeholder="Max" class="w-1/2 bg-[#080204] border border-[#d6aa62]/30 rounded-lg p-2 text-xs text-[#f5efe7] focus:outline-none focus:border-[#d6aa62]">
                        </div>
                        <button type="submit" class="w-full btn-gold py-2 text-[11px] tracking-wider uppercase font-semibold">Apply Price Filter</button>
                    </div>

                    <!-- Key Scent Notes -->
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider text-[#d6aa62] font-semibold mb-2">Signature Note Accord</label>
                        <div class="flex flex-wrap gap-1.5 max-h-40 overflow-y-auto no-scrollbar">
                            @foreach($scentNotes as $note)
                                <a href="{{ request()->fullUrlWithQuery(['note' => $note->slug]) }}" 
                                   class="text-[11px] px-2.5 py-1 rounded-md border transition {{ request('note') == $note->slug ? 'bg-[#4a0915] border-[#d6aa62] text-[#f0d59d] font-bold' : 'bg-[#18050b] border-[#d6aa62]/20 text-[#b8a9a2] hover:border-[#d6aa62] hover:text-[#f5efe7]' }}">
                                    {{ $note->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </form>
            </aside>

            <!-- Right: Products Grid & Top Sort Bar (lg:col-span-9) -->
            <div class="lg:col-span-9 space-y-6">
                <!-- Top Sorting Bar -->
                <div class="bg-[#140408] border border-[#d6aa62]/25 rounded-xl p-4 flex flex-wrap justify-between items-center gap-4 shadow-md">
                    <div class="text-xs text-[#b8a9a2]">
                        Showing <strong class="text-[#f5efe7]">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong> of <strong class="text-[#d6aa62]">{{ $products->total() }}</strong> Flacons
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="text-xs uppercase tracking-wider text-[#d6aa62] font-semibold">Sort By:</label>
                        <select onchange="location = this.value;" class="bg-[#080204] border border-[#d6aa62]/30 rounded-lg px-3 py-1.5 text-xs text-[#f5efe7] focus:outline-none focus:border-[#d6aa62]">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}" {{ request('sort') == 'featured' ? 'selected' : '' }} class="bg-[#140408]">Curated / Featured</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'bestseller']) }}" {{ request('sort') == 'bestseller' ? 'selected' : '' }} class="bg-[#140408]">Bestsellers</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort') == 'newest' ? 'selected' : '' }} class="bg-[#140408]">Newest Releases</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }} class="bg-[#140408]">Price: Low to High</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }} class="bg-[#140408]">Price: High to Low</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}" {{ request('sort') == 'rating' ? 'selected' : '' }} class="bg-[#140408]">Top Rated</option>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="bg-[#140408] border border-[#d6aa62]/25 p-12 text-center rounded-2xl space-y-4">
                        <i class="fas fa-search text-3xl text-[#d6aa62]"></i>
                        <h3 class="font-serif text-2xl text-[#f5efe7]">No Fragrances Matching Your Criteria</h3>
                        <p class="font-serif text-base text-[#b8a9a2] max-w-md mx-auto">
                            We could not find perfumes fitting your specific filter combinations. Try resetting filters or search by impression name.
                        </p>
                        <a href="{{ route('shop.index') }}" class="btn-gold inline-block py-3 px-8 text-xs uppercase tracking-widest">RESET ALL FILTERS</a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

@endsection
