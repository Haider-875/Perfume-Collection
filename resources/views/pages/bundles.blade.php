@extends('layouts.app')

@section('title', 'Curated Fragrance Bundles & Discovery Sets | Perfumes Collection Pakistan')
@section('meta_description', 'Explore handcrafted luxury perfume bundles, impression pairings, and discovery coffrets with exclusive savings up to 30% across Pakistan.')

@section('content')

<!-- Bundles Hero Banner -->
<section class="relative py-12 md:py-16 bg-[#050203] luxury-wine-bg border-b border-[#d6aa62]/30">
    <div class="container mx-auto px-4 lg:px-8 text-center">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Collections', 'url' => route('collections.show', 'all')],
            ['label' => 'Curated Bundles & Sets']
        ]" />

        <span class="inline-block text-[11px] uppercase tracking-[0.3em] text-[#d6aa62] mb-1.5 font-semibold">CURATED PAIRINGS & SIGNATURE SETS</span>
        <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl text-[#f5efe7] mb-2 font-normal tracking-tight">
            Curated Fragrance Bundles
        </h1>
        <p class="max-w-2xl mx-auto text-[#b8a9a2] text-sm md:text-base leading-relaxed font-light">
            Curated pairings presented in luxury packaging. Enjoy complimentary presentation boxes and savings of up to 30% across Pakistan.
        </p>
    </div>
</section>

<!-- Bundles Showcase Grid -->
<section class="py-16 bg-[#080204] border-b border-[#d6aa62]/20">
    <div class="container mx-auto px-4 lg:px-8">
        
        <!-- Value Proposition Bar -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-14 p-6 bg-gradient-to-b from-[#18050b] via-[#100306] to-[#070103] border border-[#d6aa62]/25 rounded-2xl shadow-xl">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-[#3b0711] border border-[#d6aa62]/40 flex items-center justify-center text-[#d6aa62] text-xl flex-shrink-0 shadow-md">
                    <i class="fas fa-gift"></i>
                </div>
                <div>
                    <h4 class="font-serif text-base text-[#f5efe7] font-medium">Velvet Presentation Box</h4>
                    <p class="text-xs text-[#b8a9a2]">Complimentary luxury unboxing experience</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-[#3b0711] border border-[#d6aa62]/40 flex items-center justify-center text-[#d6aa62] text-xl flex-shrink-0 shadow-md">
                    <i class="fas fa-percent"></i>
                </div>
                <div>
                    <h4 class="font-serif text-base text-[#f5efe7] font-medium">Guaranteed Savings</h4>
                    <p class="text-xs text-[#b8a9a2]">Save up to 30% compared to individual bottles</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-[#3b0711] border border-[#d6aa62]/40 flex items-center justify-center text-[#d6aa62] text-xl flex-shrink-0 shadow-md">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <div>
                    <h4 class="font-serif text-base text-[#f5efe7] font-medium">Complimentary Express Air</h4>
                    <p class="text-xs text-[#b8a9a2]">24-48 Hour insured TCS delivery to all cities</p>
                </div>
            </div>
        </div>

        <!-- Master Bundles List -->
        <div class="space-y-10">
            @forelse($bundles as $bundle)
                <div class="bg-gradient-to-b from-[#18050b] via-[#100306] to-[#070103] border border-[#d6aa62]/30 rounded-2xl p-6 lg:p-8 shadow-2xl hover:border-[#d6aa62] transition-all duration-300">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        
                        <!-- Left: Bundle Image Showcase -->
                        <div class="lg:col-span-4 relative group">
                            <div class="relative overflow-hidden rounded-xl border border-[#d6aa62]/20 bg-[#0c0305] p-4 text-center">
                                <img 
                                    src="{{ $bundle->image_url }}" 
                                    alt="{{ $bundle->name }}" 
                                    onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_discovery_coffret.jpg') }}';" 
                                    class="w-full h-64 object-contain mx-auto transform group-hover:scale-105 transition-transform duration-500"
                                >
                                @if($bundle->savings_amount > 0)
                                    <div class="absolute top-3 left-3 bg-gradient-to-r from-[#851a31] to-[#4a0915] text-[#fff7ed] px-3 py-1 text-[11px] font-bold tracking-wider uppercase rounded shadow-md border border-[#d6aa62]/30">
                                        SAVE RS. {{ number_format($bundle->savings_amount) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Center: Bundle Details & Included Flacons -->
                        <div class="lg:col-span-5 space-y-4">
                            <div>
                                <span class="text-[10px] uppercase tracking-[0.3em] text-[#d6aa62] font-semibold">EXCLUSIVE COFFRET SET</span>
                                <h3 class="font-serif text-3xl lg:text-4xl text-[#f5efe7] mt-1 font-normal">{{ $bundle->name }}</h3>
                                <p class="text-xs lg:text-sm text-[#b8a9a2] mt-2 leading-relaxed font-light">
                                    {{ $bundle->description }}
                                </p>
                            </div>

                            <!-- Included Items Preview -->
                            <div class="border-t border-b border-[#d6aa62]/20 py-4 my-4">
                                <h5 class="text-[11px] uppercase tracking-widest text-[#d6aa62] font-semibold mb-3">
                                    Fragrances Included in Set:
                                </h5>
                                <div class="grid grid-cols-2 gap-3">
                                    @if(isset($bundle->items) && $bundle->items->count() > 0)
                                        @foreach($bundle->items as $bItem)
                                            @php $bProd = $bItem->product; @endphp
                                            @if($bProd)
                                                <div class="flex items-center space-x-2.5 p-2 bg-[#160409]/70 border border-[#d6aa62]/20 rounded-lg">
                                                    <img src="{{ $bProd->primary_image_url }}" alt="{{ $bProd->name }}" onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';" class="w-10 h-10 object-contain">
                                                    <div class="truncate">
                                                        <div class="text-xs font-semibold text-[#f5efe7] truncate">{{ $bProd->name }}</div>
                                                        <div class="text-[10px] text-[#8e7c75]">{{ $bProd->volume_ml ?? 50 }}ml Extrait</div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @elseif(isset($bundle->products) && $bundle->products->count() > 0)
                                        @foreach($bundle->products as $bProd)
                                            <div class="flex items-center space-x-2.5 p-2 bg-[#160409]/70 border border-[#d6aa62]/20 rounded-lg">
                                                <img src="{{ $bProd->primary_image_url }}" alt="{{ $bProd->name }}" onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';" class="w-10 h-10 object-contain">
                                                <div class="truncate">
                                                    <div class="text-xs font-semibold text-[#f5efe7] truncate">{{ $bProd->name }}</div>
                                                    <div class="text-[10px] text-[#8e7c75]">{{ $bProd->volume_ml }}ml Extrait</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right: Pricing & Call to Action -->
                        <div class="lg:col-span-3 bg-[#120408] border border-[#d6aa62]/30 rounded-xl p-6 text-center space-y-4 shadow-xl">
                            <div>
                                <span class="text-[10px] uppercase tracking-widest text-[#8e7c75] block mb-1">Bundle Set Price</span>
                                <div class="font-serif text-3xl text-[#f0d59d] font-bold">
                                    Rs. {{ number_format($bundle->price) }}
                                </div>
                                @if($bundle->original_price > $bundle->price)
                                    <div class="text-xs text-[#8e7c75] line-through mt-1">
                                        Rs. {{ number_format($bundle->original_price) }}
                                    </div>
                                    <div class="text-[11px] text-[#ffd987] font-semibold mt-1">
                                        You Save: Rs. {{ number_format($bundle->savings_amount) }} ({{ round((($bundle->original_price - $bundle->price)/$bundle->original_price)*100) }}%)
                                    </div>
                                @endif
                            </div>

                            <button 
                                type="button"
                                onclick="addBundleToCart({{ $bundle->id }})"
                                class="w-full btn-gold py-3 text-xs tracking-widest uppercase flex items-center justify-center space-x-2 rounded-xl"
                            >
                                <i class="fas fa-shopping-bag"></i>
                                <span>ADD BUNDLE TO BAG</span>
                            </button>

                            <a 
                                href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I would like to order the ' . $bundle->name . ' for Rs. ' . number_format($bundle->price) . ' with Cash on Delivery.') }}" 
                                target="_blank" 
                                class="w-full btn-whatsapp py-2.5 text-xs tracking-wider flex items-center justify-center space-x-2 block rounded-xl"
                            >
                                <i class="fab fa-whatsapp"></i>
                                <span>ORDER ON WHATSAPP</span>
                            </a>

                            <div class="text-[10px] text-[#8e7c75]">
                                <i class="fas fa-shield-alt text-[#d6aa62] mr-1"></i> 100% Guaranteed Authentic Extrait
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-[#120408] border border-[#d6aa62]/20 rounded-xl p-8">
                    <p class="text-[#b8a9a2]">No bundles currently active. Check back shortly for seasonal discovery coffrets.</p>
                </div>
            @endforelse
        </div>

    </div>
</section>

@endsection
