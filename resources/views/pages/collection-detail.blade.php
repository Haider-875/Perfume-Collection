@extends('layouts.app')

@section('title', ($collection ? $collection->name : 'All Fragrance Masterpieces') . ' | Perfumes Collection Pakistan')
@section('meta_description', $collection ? $collection->description : 'Explore our private reserve collection of pure Extrait de Parfum impressions crafted for connoisseurs in Pakistan.')

@section('content')

<!-- Collection Hero Banner -->
<section class="relative py-12 md:py-16 bg-gradient-to-b from-[#18050b] via-[#0d0305] to-[#050203] text-white border-b border-[#d6aa62]/20 overflow-hidden">
    <div class="container mx-auto px-4 lg:px-8 relative z-10 text-center">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Collections', 'url' => route('collections.show', 'all')],
            ['label' => $collection ? $collection->name : 'All Impressions']
        ]" />

        <span class="inline-block text-[11px] uppercase tracking-[0.28em] text-[#d6aa62] mb-2 font-semibold">HAUTE PARFUMERIE COLLECTION</span>
        <h1 class="font-serif text-3xl md:text-5xl lg:text-6xl text-[#f5efe7] mb-3 font-normal tracking-wide">
            {{ $collection ? $collection->name : 'All Fragrance Impressions' }}
        </h1>
        <p class="max-w-2xl mx-auto text-[#b8a9a2] text-sm md:text-base font-light leading-relaxed">
            {{ $collection && $collection->description ? $collection->description : 'Handcrafted French-Oriental compositions macerated with up to 40% natural perfume compounds for unprecedented 14+ hours sillage in Pakistan.' }}
        </p>
    </div>
</section>

<!-- Collection Main Content -->
<section class="py-12 md:py-16 bg-[#050203]" x-data="{ mobileFiltersOpen: false }">
    <div class="container mx-auto px-4 lg:px-8">
        
        <!-- Filter Bar & Sort Controls Header -->
        <div class="flex flex-wrap items-center justify-between gap-4 pb-6 mb-8 border-b border-[#d6aa62]/20">
            <!-- Mobile Filter Toggle -->
            <button 
                type="button" 
                @click="mobileFiltersOpen = !mobileFiltersOpen"
                class="lg:hidden flex items-center space-x-2 px-4 py-2 border border-[#d6aa62]/30 text-[#f5efe7] text-xs uppercase tracking-widest rounded-lg bg-[#140408] hover:border-[#d6aa62] transition"
            >
                <i class="fas fa-sliders-h text-[#d6aa62]"></i>
                <span>Filters & Notes</span>
            </button>

            <!-- Results Counter -->
            <div class="text-xs text-[#b8a9a2] tracking-wider">
                Showing <span class="text-[#d6aa62] font-bold">{{ $products->total() }}</span> Extrait Masterpieces
            </div>

            <!-- Sort Form -->
            <form action="{{ url()->current() }}" method="GET" class="flex items-center space-x-3">
                @foreach(request()->except('sort', 'page') as $key => $val)
                    @if(is_array($val))
                        @foreach($val as $v)
                            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endif
                @endforeach
                
                <label for="sortSelect" class="text-xs uppercase tracking-widest text-[#d6aa62] hidden sm:inline font-semibold">Sort By:</label>
                <div class="relative">
                    <select 
                        name="sort" 
                        id="sortSelect" 
                        onchange="this.form.submit()" 
                        class="bg-[#080204] border border-[#d6aa62]/30 text-[#f5efe7] text-xs uppercase tracking-wider py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:border-[#d6aa62] cursor-pointer"
                    >
                        <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }} class="bg-[#140408]">Featured Creations</option>
                        <option value="bestseller" {{ request('sort') == 'bestseller' ? 'selected' : '' }} class="bg-[#140408]">Most Coveted (Bestsellers)</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }} class="bg-[#140408]">Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }} class="bg-[#140408]">Price: High to Low</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }} class="bg-[#140408]">Highest Rated</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }} class="bg-[#140408]">Newest Releases</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Sidebar Filters -->
            <aside 
                :class="mobileFiltersOpen ? 'fixed inset-0 z-50 bg-[#050203] p-6 overflow-y-auto block' : 'hidden lg:block'"
                class="lg:col-span-1 space-y-6 bg-[#140408] border border-[#d6aa62]/25 rounded-2xl p-6 shadow-xl"
            >
                <!-- Mobile Filter Close Button -->
                <div class="flex lg:hidden items-center justify-between pb-4 border-b border-[#d6aa62]/20 mb-6">
                    <h3 class="font-serif text-lg text-[#f5efe7]">Refine Selection</h3>
                    <button type="button" @click="mobileFiltersOpen = false" class="text-2xl text-[#b8a9a2] hover:text-[#d6aa62]">&times;</button>
                </div>

                <form action="{{ url()->current() }}" method="GET" id="collectionFilterForm">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <!-- Quick Search in Collection -->
                    <div class="mb-6">
                        <label class="block text-xs uppercase tracking-widest text-[#d6aa62] font-semibold mb-2">Search Catalog</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                name="q" 
                                value="{{ request('q') }}" 
                                placeholder="Search note or impression..." 
                                class="w-full bg-[#080204] border border-[#d6aa62]/30 rounded-lg px-3 py-2 text-xs text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:outline-none focus:border-[#d6aa62]"
                            >
                            @if(request('q'))
                                <a href="{{ url()->current() }}" class="absolute right-3 top-2 text-[#b8a9a2] hover:text-[#f5efe7] text-xs">&times;</a>
                            @endif
                        </div>
                    </div>

                    <!-- Filter 1: Collections Navigation -->
                    <div class="border-t border-[#d6aa62]/20 pt-5 mb-5">
                        <h4 class="text-xs uppercase tracking-[0.18em] text-[#d6aa62] font-semibold mb-3 flex items-center justify-between">
                            <span>Houses & Categories</span>
                            <i class="fas fa-chevron-down text-[10px] text-[#b8a9a2]"></i>
                        </h4>
                        <ul class="space-y-2 text-xs">
                            <li>
                                <a href="{{ route('collections.show', 'all') }}" class="block py-1 {{ $slug === 'all' ? 'text-[#d6aa62] font-bold' : 'text-[#b8a9a2] hover:text-[#f5efe7]' }}">
                                    All Impressions
                                </a>
                            </li>
                            @foreach($allCollections as $col)
                                <li>
                                    <a href="{{ route('collections.show', $col->slug) }}" class="block py-1 {{ $slug === $col->slug ? 'text-[#d6aa62] font-bold' : 'text-[#b8a9a2] hover:text-[#f5efe7]' }}">
                                        {{ $col->name }}
                                    </a>
                                </li>
                            @endforeach
                            <li>
                                <a href="{{ route('collections.show', 'bundles') }}" class="block py-1 text-[#f0d59d] font-semibold hover:underline flex items-center justify-between">
                                    <span>Curated Bundles</span>
                                    <span class="text-[9px] bg-[#4a0915] text-[#f0d59d] border border-[#d6aa62]/30 px-1.5 py-0.5 rounded font-bold">SAVE 25%</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Filter 2: Fragrance Family -->
                    <div class="border-t border-[#d6aa62]/20 pt-5 mb-5">
                        <h4 class="text-xs uppercase tracking-[0.18em] text-[#d6aa62] font-semibold mb-3">
                            Fragrance Family
                        </h4>
                        <div class="space-y-2 max-h-48 overflow-y-auto pr-2 no-scrollbar">
                            @foreach($fragranceFamilies as $family)
                                <label class="flex items-center justify-between text-xs text-[#b8a9a2] cursor-pointer hover:text-[#f5efe7]">
                                    <span class="flex items-center space-x-2">
                                        <input 
                                             type="radio" 
                                             name="family" 
                                             value="{{ $family->slug }}" 
                                             {{ request('family') == $family->slug ? 'checked' : '' }} 
                                             onchange="this.form.submit()"
                                             class="text-[#d6aa62] focus:ring-0"
                                         >
                                         <span class="{{ request('family') == $family->slug ? 'text-[#d6aa62] font-bold' : '' }}">{{ $family->name }}</span>
                                     </span>
                                     <span class="text-[10px] text-[#b8a9a2]">({{ $family->products_count }})</span>
                                 </label>
                             @endforeach
                         </div>
                     </div>

                    <!-- Filter 3: Scent Notes -->
                    <div class="border-t border-[#d6aa62]/20 pt-5 mb-5">
                        <h4 class="text-xs uppercase tracking-[0.18em] text-[#d6aa62] font-semibold mb-3">
                            Signature Notes
                        </h4>
                        <div class="flex flex-wrap gap-1.5 max-h-40 overflow-y-auto pr-1 no-scrollbar">
                            @foreach($scentNotes as $note)
                                <a 
                                    href="{{ request()->fullUrlWithQuery(['note' => request('note') == $note->slug ? null : $note->slug]) }}" 
                                    class="px-2.5 py-1 text-[11px] rounded border transition {{ request('note') == $note->slug ? 'bg-[#4a0915] text-[#f0d59d] border-[#d6aa62] font-semibold' : 'border-[#d6aa62]/20 bg-[#18050b] text-[#b8a9a2] hover:border-[#d6aa62] hover:text-[#f5efe7]' }}"
                                >
                                    {{ $note->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter 4: Volume / Size (ml) -->
                    <div class="border-t border-[#d6aa62]/20 pt-5 mb-5">
                        <h4 class="text-xs uppercase tracking-[0.18em] text-[#d6aa62] font-semibold mb-3">
                            Flacon Volume
                        </h4>
                        <div class="grid grid-cols-3 gap-2 text-xs">
                            @foreach([10, 50, 100] as $vol)
                                <button 
                                    type="button" 
                                    onclick="window.location.href='{{ request()->fullUrlWithQuery(['volume_ml' => request('volume_ml') == $vol ? null : $vol]) }}'"
                                    class="py-2 text-center rounded-lg border transition {{ request('volume_ml') == $vol ? 'bg-[#4a0915] text-[#f0d59d] border-[#d6aa62] font-semibold' : 'border-[#d6aa62]/25 bg-[#18050b] text-[#b8a9a2] hover:border-[#d6aa62] hover:text-[#f5efe7]' }}"
                                >
                                    {{ $vol }} ml
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter 5: Price Range (PKR) -->
                    <div class="border-t border-[#d6aa62]/20 pt-5 mb-6">
                        <h4 class="text-xs uppercase tracking-[0.18em] text-[#d6aa62] font-semibold mb-3">
                            Price Range (PKR)
                        </h4>
                        <div class="flex items-center space-x-2 mb-3">
                            <input 
                                type="number" 
                                name="min_price" 
                                value="{{ request('min_price') }}" 
                                placeholder="Min Rs." 
                                class="w-1/2 bg-[#080204] border border-[#d6aa62]/30 rounded-lg px-2 py-1.5 text-xs text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:outline-none focus:border-[#d6aa62]"
                            >
                            <span class="text-[#b8a9a2]">-</span>
                            <input 
                                type="number" 
                                name="max_price" 
                                value="{{ request('max_price') }}" 
                                placeholder="Max Rs." 
                                class="w-1/2 bg-[#080204] border border-[#d6aa62]/30 rounded-lg px-2 py-1.5 text-xs text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:outline-none focus:border-[#d6aa62]"
                            >
                        </div>
                        <button type="submit" class="w-full btn-gold py-1.5 text-[10px] tracking-widest uppercase font-semibold">
                            Apply Price
                        </button>
                    </div>

                    <!-- Reset Filters -->
                    @if(request()->hasAny(['family', 'note', 'volume_ml', 'min_price', 'max_price', 'q']))
                        <a href="{{ url()->current() }}" class="block text-center text-xs text-rose-400 hover:text-rose-300 py-2 border border-rose-500/30 rounded uppercase tracking-wider font-semibold">
                            <i class="fas fa-undo mr-1"></i> Clear All Filters
                        </a>
                    @endif
                </form>
            </aside>

            <!-- Products Grid (2 Columns Mobile, 3-4 Columns Desktop) -->
            <main class="lg:col-span-3">
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
                    <div class="text-center py-20 bg-[#140408] border border-[#d6aa62]/25 rounded-2xl p-8 space-y-4">
                        <i class="fas fa-gem text-4xl text-[#d6aa62] mb-2"></i>
                        <h3 class="font-serif text-2xl text-[#f5efe7] mb-2 font-normal">No Fragrance Impressions Found</h3>
                        <p class="text-[#b8a9a2] text-sm max-w-md mx-auto mb-6">
                            No creations matched your refined criteria. Try broadening your notes or price selection.
                        </p>
                        <a href="{{ route('collections.show', 'all') }}" class="btn-gold inline-block py-3 px-8 text-xs uppercase tracking-widest">
                            EXPLORE ALL CREATIONS
                        </a>
                    </div>
                @endif
            </main>

        </div>
    </div>
</section>

@endsection
