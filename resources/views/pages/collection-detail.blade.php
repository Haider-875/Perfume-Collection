@extends('layouts.app')

@section('title', ($collection ? $collection->name : 'All Fragrance Masterpieces') . ' | Maison d\'Orient Haute Parfumerie Pakistan')
@section('meta_description', $collection ? $collection->description : 'Explore our private reserve collection of pure Extrait de Parfum and Dehn al Oud crafted for connoisseurs in Pakistan.')

@section('content')

<!-- Collection Hero Banner -->
<section class="relative py-16 md:py-24 bg-[#0A0405] border-b border-[#C9A24B]/20 overflow-hidden">
    <div class="absolute inset-0 bg-radial-gradient opacity-25 pointer-events-none"></div>
    <div class="container relative z-10 text-center">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Collections', 'url' => route('collections.show', 'all')],
            ['label' => $collection ? $collection->name : 'All Perfumes']
        ]" />

        <span class="inline-block text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] mb-2 font-medium">HAUTE PARFUMERIE COLLECTION</span>
        <h1 class="font-serif text-3xl md:text-5xl lg:text-6xl text-[#F5EFE6] mb-4 font-normal tracking-wide">
            {{ $collection ? $collection->name : 'Private Vault Reserve' }}
        </h1>
        <p class="max-w-2xl mx-auto text-[#F5EFE6]/70 text-sm md:text-base font-light leading-relaxed">
            {{ $collection && $collection->description ? $collection->description : 'Handcrafted French-Oriental compositions macerated with up to 40% natural perfume compounds for unprecedented sillage in Pakistan.' }}
        </p>
    </div>
</section>

<!-- Collection Main Content -->
<section class="py-12 md:py-16 bg-[#080304]" x-data="{ mobileFiltersOpen: false }">
    <div class="container">
        
        <!-- Filter Bar & Sort Controls Header -->
        <div class="flex flex-wrap items-center justify-between gap-4 pb-6 mb-8 border-b border-[#C9A24B]/20">
            <!-- Mobile Filter Toggle -->
            <button 
                type="button" 
                @click="mobileFiltersOpen = !mobileFiltersOpen"
                class="lg:hidden flex items-center space-x-2 px-4 py-2 border border-[#C9A24B]/40 text-[#C9A24B] text-xs uppercase tracking-widest rounded hover:bg-[#C9A24B]/10 transition"
            >
                <i class="fas fa-sliders-h"></i>
                <span>Filters & Notes</span>
            </button>

            <!-- Results Counter -->
            <div class="text-xs text-[#F5EFE6]/60 tracking-wider">
                Showing <span class="text-[#C9A24B] font-semibold">{{ $products->total() }}</span> Extrait Masterpieces
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
                
                <label for="sortSelect" class="text-xs uppercase tracking-widest text-[#F5EFE6]/70 hidden sm:inline">Sort By:</label>
                <div class="relative">
                    <select 
                        name="sort" 
                        id="sortSelect" 
                        onchange="this.form.submit()" 
                        class="bg-[#120709] border border-[#C9A24B]/40 text-[#F5EFE6] text-xs uppercase tracking-wider py-2 pl-3 pr-8 rounded focus:outline-none focus:border-[#C9A24B] cursor-pointer"
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

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Sidebar Filters -->
            <aside 
                :class="mobileFiltersOpen ? 'fixed inset-0 z-50 bg-[#080304] p-6 overflow-y-auto block' : 'hidden lg:block'"
                class="lg:col-span-1 space-y-6"
            >
                <!-- Mobile Filter Close Button -->
                <div class="flex lg:hidden items-center justify-between pb-4 border-b border-[#C9A24B]/30 mb-6">
                    <h3 class="font-serif text-lg text-[#F5EFE6]">Refine Selection</h3>
                    <button type="button" @click="mobileFiltersOpen = false" class="text-2xl text-[#C9A24B]">&times;</button>
                </div>

                <form action="{{ url()->current() }}" method="GET" id="collectionFilterForm">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <!-- Quick Search in Collection -->
                    <div class="mb-6">
                        <label class="block text-xs uppercase tracking-widest text-[#C9A24B] font-semibold mb-2">Search Collection</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                name="q" 
                                value="{{ request('q') }}" 
                                placeholder="Search note or name..." 
                                class="w-full bg-[#120709] border border-[#C9A24B]/30 rounded px-3 py-2 text-xs text-[#F5EFE6] placeholder-stone-600 focus:outline-none focus:border-[#C9A24B]"
                            >
                            @if(request('q'))
                                <a href="{{ url()->current() }}" class="absolute right-3 top-2 text-stone-500 hover:text-stone-300 text-xs">&times;</a>
                            @endif
                        </div>
                    </div>

                    <!-- Filter 1: Collections Navigation -->
                    <div class="border-t border-[#C9A24B]/15 pt-5 mb-5">
                        <h4 class="text-xs uppercase tracking-[0.2em] text-[#C9A24B] font-semibold mb-3 flex items-center justify-between">
                            <span>Houses & Vaults</span>
                            <i class="fas fa-chevron-down text-[10px]"></i>
                        </h4>
                        <ul class="space-y-2 text-xs">
                            <li>
                                <a href="{{ route('collections.show', 'all') }}" class="block py-1 {{ $slug === 'all' ? 'text-[#C9A24B] font-semibold' : 'text-[#F5EFE6]/70 hover:text-[#C9A24B]' }}">
                                    All Masterpieces
                                </a>
                            </li>
                            @foreach($allCollections as $col)
                                <li>
                                    <a href="{{ route('collections.show', $col->slug) }}" class="block py-1 {{ $slug === $col->slug ? 'text-[#C9A24B] font-semibold' : 'text-[#F5EFE6]/70 hover:text-[#C9A24B]' }}">
                                        {{ $col->name }}
                                    </a>
                                </li>
                            @endforeach
                            <li>
                                <a href="{{ route('collections.show', 'bundles') }}" class="block py-1 text-[#C9A24B] hover:underline flex items-center justify-between">
                                    <span>Curated Bundles</span>
                                    <span class="text-[9px] bg-[#4A0E17] text-[#F5EFE6] px-1.5 py-0.5 rounded">SAVE 25%</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Filter 2: Fragrance Family -->
                    <div class="border-t border-[#C9A24B]/15 pt-5 mb-5">
                        <h4 class="text-xs uppercase tracking-[0.2em] text-[#C9A24B] font-semibold mb-3">
                            Fragrance Family
                        </h4>
                        <div class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar pr-2">
                            @foreach($fragranceFamilies as $family)
                                <label class="flex items-center justify-between text-xs text-[#F5EFE6]/80 cursor-pointer hover:text-[#C9A24B]">
                                    <span class="flex items-center space-x-2">
                                        <input 
                                            type="radio" 
                                            name="family" 
                                            value="{{ $family->slug }}" 
                                            {{ request('family') == $family->slug ? 'checked' : '' }} 
                                            onchange="this.form.submit()"
                                            class="text-[#C9A24B] focus:ring-0 bg-[#120709] border-[#C9A24B]/40"
                                        >
                                        <span>{{ $family->name }}</span>
                                    </span>
                                    <span class="text-[10px] text-[#F5EFE6]/40">({{ $family->products_count }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter 3: Scent Notes -->
                    <div class="border-t border-[#C9A24B]/15 pt-5 mb-5">
                        <h4 class="text-xs uppercase tracking-[0.2em] text-[#C9A24B] font-semibold mb-3">
                            Signature Notes
                        </h4>
                        <div class="flex flex-wrap gap-1.5 max-h-40 overflow-y-auto pr-1">
                            @foreach($scentNotes as $note)
                                <a 
                                    href="{{ request()->fullUrlWithQuery(['note' => request('note') == $note->slug ? null : $note->slug]) }}" 
                                    class="px-2.5 py-1 text-[11px] rounded border {{ request('note') == $note->slug ? 'bg-[#C9A24B] text-[#080304] border-[#C9A24B] font-semibold' : 'border-[#C9A24B]/30 text-[#F5EFE6]/70 hover:border-[#C9A24B] hover:text-[#F5EFE6]' }} transition"
                                >
                                    {{ $note->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter 4: Volume / Size (ml) -->
                    <div class="border-t border-[#C9A24B]/15 pt-5 mb-5">
                        <h4 class="text-xs uppercase tracking-[0.2em] text-[#C9A24B] font-semibold mb-3">
                            Flacon Volume
                        </h4>
                        <div class="grid grid-cols-3 gap-2 text-xs">
                            @foreach([12, 50, 100] as $vol)
                                <button 
                                    type="button" 
                                    onclick="window.location.href='{{ request()->fullUrlWithQuery(['volume_ml' => request('volume_ml') == $vol ? null : $vol]) }}'"
                                    class="py-2 text-center rounded border {{ request('volume_ml') == $vol ? 'bg-[#C9A24B] text-[#080304] border-[#C9A24B] font-semibold' : 'border-[#C9A24B]/30 text-[#F5EFE6]/80 hover:border-[#C9A24B]' }} transition"
                                >
                                    {{ $vol }} ml
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter 5: Price Range (PKR) -->
                    <div class="border-t border-[#C9A24B]/15 pt-5 mb-6">
                        <h4 class="text-xs uppercase tracking-[0.2em] text-[#C9A24B] font-semibold mb-3">
                            Price Range (PKR)
                        </h4>
                        <div class="flex items-center space-x-2 mb-3">
                            <input 
                                type="number" 
                                name="min_price" 
                                value="{{ request('min_price') }}" 
                                placeholder="Min Rs." 
                                class="w-1/2 bg-[#120709] border border-[#C9A24B]/30 rounded px-2 py-1.5 text-xs text-[#F5EFE6] placeholder-stone-600 focus:outline-none"
                            >
                            <span class="text-stone-500">-</span>
                            <input 
                                type="number" 
                                name="max_price" 
                                value="{{ request('max_price') }}" 
                                placeholder="Max Rs." 
                                class="w-1/2 bg-[#120709] border border-[#C9A24B]/30 rounded px-2 py-1.5 text-xs text-[#F5EFE6] placeholder-stone-600 focus:outline-none"
                            >
                        </div>
                        <button type="submit" class="w-full btn-outline-gold py-1.5 text-[10px] tracking-widest uppercase">
                            Apply Price
                        </button>
                    </div>

                    <!-- Reset Filters -->
                    @if(request()->hasAny(['family', 'note', 'volume_ml', 'min_price', 'max_price', 'q']))
                        <a href="{{ url()->current() }}" class="block text-center text-xs text-red-400 hover:text-red-300 py-2 border border-red-500/30 rounded uppercase tracking-wider">
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
                    <div class="text-center py-20 bg-[#0E0507] border border-[#C9A24B]/20 rounded-lg p-8">
                        <i class="fas fa-gem text-4xl text-[#C9A24B]/50 mb-4"></i>
                        <h3 class="font-serif text-2xl text-[#F5EFE6] mb-2">No Fragrance Masterpieces Found</h3>
                        <p class="text-[#F5EFE6]/60 text-sm max-w-md mx-auto mb-6">
                            No creations matched your refined criteria. Try broadening your notes or price selection.
                        </p>
                        <a href="{{ route('collections.show', 'all') }}" class="btn-gold">
                            EXPLORE ALL CREATIONS
                        </a>
                    </div>
                @endif
            </main>

        </div>
    </div>
</section>

@endsection
