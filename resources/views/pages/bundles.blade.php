@extends('layouts.app')

@section('title', 'Curated Fragrance Bundles & Discovery Sets | Perfumes Collection Pakistan')
@section('meta_description', 'Explore handcrafted luxury perfume bundles, impression pairings, and discovery coffrets with exclusive savings up to 30% across Pakistan.')

@section('content')

<!-- Bundles Hero Banner (BuyRawaha Style) -->
<section class="relative py-10 md:py-14 bg-gray-50 border-b border-gray-200">
    <div class="container mx-auto px-4 lg:px-8 text-center">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Collections', 'url' => route('collections.show', 'all')],
            ['label' => 'Curated Bundles & Sets']
        ]" />

        <span class="inline-block text-[11px] uppercase tracking-[0.2em] text-gray-500 mb-1.5 font-bold">CURATED PAIRINGS & SIGNATURE SETS</span>
        <h1 class="font-['Jost'] text-3xl md:text-4xl lg:text-5xl text-black mb-2 font-bold tracking-tight">
            Curated Fragrance Bundles
        </h1>
        <p class="max-w-2xl mx-auto text-gray-600 text-sm md:text-base leading-relaxed">
            Curated pairings presented in luxury packaging. Enjoy complimentary presentation boxes and savings of up to 30% across Pakistan.
        </p>
    </div>
</section>

<!-- Bundles Showcase Grid -->
<section class="py-16 bg-white border-b border-gray-200">
    <div class="container mx-auto px-4 lg:px-8">
        
        <!-- Value Proposition Bar -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-14 p-6 bg-gray-50 border border-gray-200 rounded-xl">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-800 text-xl flex-shrink-0">
                    <i class="fas fa-gift"></i>
                </div>
                <div>
                    <h4 class="font-serif text-base text-gray-900 font-semibold">Velvet Presentation Box</h4>
                    <p class="text-xs text-gray-500">Complimentary luxury unboxing experience</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-800 text-xl flex-shrink-0">
                    <i class="fas fa-percent"></i>
                </div>
                <div>
                    <h4 class="font-serif text-base text-gray-900 font-semibold">Guaranteed Savings</h4>
                    <p class="text-xs text-gray-500">Save up to 30% compared to individual bottles</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-800 text-xl flex-shrink-0">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <div>
                    <h4 class="font-serif text-base text-gray-900 font-semibold">Complimentary Express Air</h4>
                    <p class="text-xs text-gray-500">24-48 Hour insured TCS delivery to all cities</p>
                </div>
            </div>
        </div>

        <!-- Master Bundles List -->
        <div class="space-y-10">
            @forelse($bundles as $bundle)
                <div class="bg-gray-50/70 border border-gray-200 rounded-2xl p-6 lg:p-8 shadow-sm hover:shadow-md hover:border-amber-400 transition-all duration-300">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        
                        <!-- Left: Bundle Image Showcase -->
                        <div class="lg:col-span-4 relative group">
                            <div class="relative overflow-hidden rounded-xl border border-gray-200 bg-white p-4 text-center">
                                <img 
                                    src="{{ asset($bundle->image_url ?? 'assets/images/perfumes/bundle_royale.svg') }}" 
                                    alt="{{ $bundle->name }}" 
                                    class="w-full h-64 object-contain mx-auto transform group-hover:scale-105 transition-transform duration-500"
                                >
                                @if($bundle->savings_amount > 0)
                                    <div class="absolute top-3 left-3 bg-amber-800 text-white px-3 py-1 text-[11px] font-bold tracking-wider uppercase rounded shadow">
                                        SAVE RS. {{ number_format($bundle->savings_amount) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Center: Bundle Details & Included Flacons -->
                        <div class="lg:col-span-5 space-y-4">
                            <div>
                                <span class="text-[10px] uppercase tracking-[0.2em] text-[#C19E66] font-bold">EXCLUSIVE COFFRET SET</span>
                                <h3 class="font-['Jost'] text-2xl lg:text-3xl text-black mt-1 font-semibold">{{ $bundle->name }}</h3>
                                <p class="text-xs lg:text-sm text-gray-600 mt-2 leading-relaxed">
                                    {{ $bundle->description }}
                                </p>
                            </div>

                            <!-- Included Items Preview -->
                            <div class="border-t border-b border-gray-200 py-4 my-4">
                                <h5 class="text-[11px] uppercase tracking-widest text-black font-bold mb-3">
                                    Fragrances Included in Set:
                                </h5>
                                <div class="grid grid-cols-2 gap-3">
                                    @if(isset($bundle->items) && $bundle->items->count() > 0)
                                        @foreach($bundle->items as $bItem)
                                            @php $bProd = $bItem->product; @endphp
                                            @if($bProd)
                                                <div class="flex items-center space-x-2.5 p-2 bg-white border border-gray-200 rounded-lg">
                                                    <img src="{{ asset($bProd->primary_image_url) }}" alt="{{ $bProd->name }}" class="w-10 h-10 object-contain">
                                                    <div class="truncate">
                                                        <div class="text-xs font-semibold text-gray-900 truncate">{{ $bProd->name }}</div>
                                                        <div class="text-[10px] text-gray-500">{{ $bProd->volume_ml ?? 50 }}ml Extrait</div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @elseif(isset($bundle->products) && $bundle->products->count() > 0)
                                        @foreach($bundle->products as $bProd)
                                            <div class="flex items-center space-x-2.5 p-2 bg-white border border-gray-200 rounded-lg">
                                                <img src="{{ asset($bProd->primary_image_url) }}" alt="{{ $bProd->name }}" class="w-10 h-10 object-contain">
                                                <div class="truncate">
                                                    <div class="text-xs font-semibold text-gray-900 truncate">{{ $bProd->name }}</div>
                                                    <div class="text-[10px] text-gray-500">{{ $bProd->volume_ml }}ml Extrait</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right: Pricing & Call to Action -->
                        <div class="lg:col-span-3 bg-white border border-gray-200 rounded-xl p-6 text-center space-y-4 shadow-sm">
                            <div>
                                <span class="text-[10px] uppercase tracking-widest text-gray-500 block mb-1">Bundle Set Price</span>
                                <div class="font-['Jost'] text-3xl text-black font-bold">
                                    Rs. {{ number_format($bundle->price) }}
                                </div>
                                @if($bundle->original_price > $bundle->price)
                                    <div class="text-xs text-gray-400 line-through mt-1">
                                        Rs. {{ number_format($bundle->original_price) }}
                                    </div>
                                    <div class="text-[11px] text-red-600 font-bold mt-1">
                                        You Save: Rs. {{ number_format($bundle->savings_amount) }} ({{ round((($bundle->original_price - $bundle->price)/$bundle->original_price)*100) }}%)
                                    </div>
                                @endif
                            </div>

                            <button 
                                type="button"
                                onclick="addBundleToCart({{ $bundle->id }})"
                                class="w-full btn-gold py-3 text-xs tracking-widest uppercase flex items-center justify-center space-x-2"
                            >
                                <i class="fas fa-shopping-bag"></i>
                                <span>ADD BUNDLE TO BAG</span>
                            </button>

                            <a 
                                href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I would like to order the ' . $bundle->name . ' for Rs. ' . number_format($bundle->price) . ' with Cash on Delivery.') }}" 
                                target="_blank" 
                                class="w-full btn-whatsapp py-2.5 text-xs tracking-wider flex items-center justify-center space-x-2 block"
                            >
                                <i class="fab fa-whatsapp"></i>
                                <span>ORDER ON WHATSAPP</span>
                            </a>

                            <div class="text-[10px] text-gray-500">
                                <i class="fas fa-shield-alt text-amber-700 mr-1"></i> 100% Guaranteed Authentic Extrait
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-gray-50 border border-gray-200 rounded-xl p-8">
                    <p class="text-gray-500">No bundles currently active. Check back shortly for seasonal discovery coffrets.</p>
                </div>
            @endforelse
        </div>

    </div>
</section>

@endsection
