@extends('layouts.app')

@section('title', ($collection ? $collection->name : 'All Fragrance Masterpieces') . ' | RAVAHA Parfums Pakistan')
@section('meta_description', $collection ? $collection->description : 'Explore our private reserve collection of pure Extrait de Parfum impressions crafted for connoisseurs in Pakistan.')

@section('content')

<!-- Collection Hero Banner -->
<section class="relative py-12 md:py-16 bg-gray-900 text-white border-b border-amber-600/30 overflow-hidden">
    <div class="container mx-auto px-4 lg:px-8 relative z-10 text-center">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Collections', 'url' => route('collections.show', 'all')],
            ['label' => $collection ? $collection->name : 'All Impressions']
        ]" />

        <span class="inline-block text-[11px] uppercase tracking-[0.25em] text-amber-400 mb-2 font-bold">HAUTE PARFUMERIE COLLECTION</span>
        <h1 class="font-serif text-3xl md:text-5xl lg:text-6xl text-white mb-3 font-normal tracking-wide">
            {{ $collection ? $collection->name : 'All Fragrance Impressions' }}
        </h1>
        <p class="max-w-2xl mx-auto text-gray-300 text-sm md:text-base font-light leading-relaxed">
            {{ $collection && $collection->description ? $collection->description : 'Handcrafted French-Oriental compositions macerated with up to 40% natural perfume compounds for unprecedented 14+ hours sillage in Pakistan.' }}
        </p>
    </div>
</section>

<!-- Collection Main Content -->
<section class="py-12 md:py-16 bg-white" x-data="{ mobileFiltersOpen: false }">
    <div class="container mx-auto px-4 lg:px-8">
        
        <!-- Filter Bar & Sort Controls Header -->
        <div class="flex flex-wrap items-center justify-between gap-4 pb-6 mb-8 border-b border-gray-200">
            <!-- Mobile Filter Toggle -->
            <button 
                type="button" 
                @click="mobileFiltersOpen = !mobileFiltersOpen"
                class="lg:hidden flex items-center space-x-2 px-4 py-2 border border-gray-300 text-gray-800 text-xs uppercase tracking-widest rounded-lg hover:bg-gray-50 transition"
            >
                <i class="fas fa-sliders-h text-amber-700"></i>
                <span>Filters & Notes</span>
            </button>

            <!-- Results Counter -->
            <div class="text-xs text-gray-500 tracking-wider">
                Showing <span class="text-gray-900 font-bold">{{ $products->total() }}</span> Extrait Masterpieces
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
                
                <label for="sortSelect" class="text-xs uppercase tracking-widest text-gray-600 hidden sm:inline font-medium">Sort By:</label>
                <div class="relative">
                    <select 
                        name="sort" 
                        id="sortSelect" 
                        onchange="this.form.submit()" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-xs uppercase tracking-wider py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:border-amber-600 cursor-pointer"
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
                :class="mobileFiltersOpen ? 'fixed inset-0 z-50 bg-white p-6 overflow-y-auto block' : 'hidden lg:block'"
                class="lg:col-span-1 space-y-6"
            >
                <!-- Mobile Filter Close Button -->
                <div class="flex lg:hidden items-center justify-between pb-4 border-b border-gray-200 mb-6">
                    <h3 class="font-serif text-lg text-gray-900">Refine Selection</h3>
                    <button type="button" @click="mobileFiltersOpen = false" class="text-2xl text-gray-600">&times;</button>
                </div>

                <form action="{{ url()->current() }}" method="GET" id="collectionFilterForm">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <!-- Quick Search in Collection -->
                    <div class="mb-6">
                        <label class="block text-xs uppercase tracking-widest text-gray-700 font-bold mb-2">Search Catalog</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                name="q" 
                                value="{{ request('q') }}" 
                                placeholder="Search note or impression..." 
                                class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-xs text-gray-900 placeholder-gray-400 focus:outline-none focus:border-amber-600"
                            >
                            @if(request('q'))
                                <a href="{{ url()->current() }}" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600 text-xs">&times;</a>
                            @endif
                        </div>
                    </div>

                    <!-- Filter 1: Collections Navigation -->
                    <div class="border-t border-gray-200 pt-5 mb-5">
                        <h4 class="text-xs uppercase tracking-[0.18em] text-gray-900 font-bold mb-3 flex items-center justify-between">
                            <span>Houses & Categories</span>
                            <i class="fas fa-chevron-down text-[10px] text-gray-400"></i>
                        </h4>
                        <ul class="space-y-2 text-xs">
                            <li>
                                <a href="{{ route('collections.show', 'all') }}" class="block py-1 {{ $slug === 'all' ? 'text-amber-800 font-bold' : 'text-gray-600 hover:text-amber-800' }}">
                                    All Impressions
                                </a>
                            </li>
                            @foreach($allCollections as $col)
                                <li>
                                    <a href="{{ route('collections.show', $col->slug) }}" class="block py-1 {{ $slug === $col->slug ? 'text-amber-800 font-bold' : 'text-gray-600 hover:text-amber-800' }}">
                                        {{ $col->name }}
                                    </a>
                                </li>
                            @endforeach
                            <li>
                                <a href="{{ route('collections.show', 'bundles') }}" class="block py-1 text-amber-800 font-semibold hover:underline flex items-center justify-between">
                                    <span>Curated Bundles</span>
                                    <span class="text-[9px] bg-amber-100 text-amber-900 px-1.5 py-0.5 rounded font-bold">SAVE 25%</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Filter 2: Fragrance Family -->
                    <div class="border-t border-gray-200 pt-5 mb-5">
                        <h4 class="text-xs uppercase tracking-[0.18em] text-gray-900 font-bold mb-3">
                            Fragrance Family
                        </h4>
                        <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                            @foreach($fragranceFamilies as $family)
                                <label class="flex items-center justify-between text-xs text-gray-700 cursor-pointer hover:text-amber-800">
                                    <span class="flex items-center space-x-2">
                                        <input 
                                            type="radio" 
                                            name="family" 
                                            value="{{ $family->slug }}" 
                                            {{ request('family') == $family->slug ? 'checked' : '' }} 
                                            onchange="this.form.submit()"
                                            class="text-amber-800 focus:ring-0"
                                        >
                                        <span>{{ $family->name }}</span>
                                    </span>
                                    <span class="text-[10px] text-gray-400">({{ $family->products_count }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter 3: Scent Notes -->
                    <div class="border-t border-gray-200 pt-5 mb-5">
                        <h4 class="text-xs uppercase tracking-[0.18em] text-gray-900 font-bold mb-3">
                            Signature Notes
                        </h4>
                        <div class="flex flex-wrap gap-1.5 max-h-40 overflow-y-auto pr-1">
                            @foreach($scentNotes as $note)
                                <a 
                                    href="{{ request()->fullUrlWithQuery(['note' => request('note') == $note->slug ? null : $note->slug]) }}" 
                                    class="px-2.5 py-1 text-[11px] rounded border {{ request('note') == $note->slug ? 'bg-amber-800 text-white border-amber-800 font-semibold' : 'border-gray-300 text-gray-700 hover:border-amber-700 hover:text-amber-800' }} transition"
                                >
                                    {{ $note->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter 4: Volume / Size (ml) -->
                    <div class="border-t border-gray-200 pt-5 mb-5">
                        <h4 class="text-xs uppercase tracking-[0.18em] text-gray-900 font-bold mb-3">
                            Flacon Volume
                        </h4>
                        <div class="grid grid-cols-3 gap-2 text-xs">
                            @foreach([10, 50, 100] as $vol)
                                <button 
                                    type="button" 
                                    onclick="window.location.href='{{ request()->fullUrlWithQuery(['volume_ml' => request('volume_ml') == $vol ? null : $vol]) }}'"
                                    class="py-2 text-center rounded-lg border {{ request('volume_ml') == $vol ? 'bg-amber-800 text-white border-amber-800 font-semibold' : 'border-gray-300 text-gray-700 hover:border-amber-700' }} transition"
                                >
                                    {{ $vol }} ml
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter 5: Price Range (PKR) -->
                    <div class="border-t border-gray-200 pt-5 mb-6">
                        <h4 class="text-xs uppercase tracking-[0.18em] text-gray-900 font-bold mb-3">
                            Price Range (PKR)
                        </h4>
                        <div class="flex items-center space-x-2 mb-3">
                            <input 
                                type="number" 
                                name="min_price" 
                                value="{{ request('min_price') }}" 
                                placeholder="Min Rs." 
                                class="w-1/2 bg-gray-50 border border-gray-300 rounded px-2 py-1.5 text-xs text-gray-900 placeholder-gray-400 focus:outline-none"
                            >
                            <span class="text-gray-400">-</span>
                            <input 
                                type="number" 
                                name="max_price" 
                                value="{{ request('max_price') }}" 
                                placeholder="Max Rs." 
                                class="w-1/2 bg-gray-50 border border-gray-300 rounded px-2 py-1.5 text-xs text-gray-900 placeholder-gray-400 focus:outline-none"
                            >
                        </div>
                        <button type="submit" class="w-full btn-outline-gold py-1.5 text-[10px] tracking-widest uppercase border-gray-400 text-gray-800 hover:bg-gray-100">
                            Apply Price
                        </button>
                    </div>

                    <!-- Reset Filters -->
                    @if(request()->hasAny(['family', 'note', 'volume_ml', 'min_price', 'max_price', 'q']))
                        <a href="{{ url()->current() }}" class="block text-center text-xs text-red-600 hover:text-red-700 py-2 border border-red-300 rounded uppercase tracking-wider font-semibold">
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
                    <div class="text-center py-20 bg-gray-50 border border-gray-200 rounded-xl p-8">
                        <i class="fas fa-gem text-4xl text-amber-600/50 mb-4"></i>
                        <h3 class="font-serif text-2xl text-gray-900 mb-2 font-normal">No Fragrance Impressions Found</h3>
                        <p class="text-gray-500 text-sm max-w-md mx-auto mb-6">
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
