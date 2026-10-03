@extends('layouts.app')

@section('title', 'Curated Fragrance Bundles & Discovery Coffrets | Maison d\'Orient Pakistan')
@section('meta_description', 'Explore handcrafted luxury perfume bundles, royal oud pairing sets, and grand bridal coffrets with exclusive savings up to Rs. 10,000.')

@section('content')

<!-- Bundles Hero Banner -->
<section class="relative py-16 md:py-24 bg-[#0A0405] border-b border-[#C9A24B]/20 overflow-hidden">
    <div class="absolute inset-0 bg-radial-gradient opacity-25 pointer-events-none"></div>
    <div class="container relative z-10 text-center">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Collections', 'url' => route('collections.show', 'all')],
            ['label' => 'Luxury Bundles & Coffrets']
        ]" />

        <span class="inline-block text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] mb-2 font-medium">CURATED PAIRINGS & SIGNATURE SETS</span>
        <h1 class="font-serif text-3xl md:text-5xl lg:text-6xl text-[#F5EFE6] mb-4 font-normal tracking-wide">
            Imperial Fragrance Bundles
        </h1>
        <p class="max-w-2xl mx-auto text-[#F5EFE6]/70 text-sm md:text-base font-light leading-relaxed">
            Master perfumer curated pairings presented in gold-embossed velvet coffrets. Enjoy complimentary luxury gifting boxes and privileged savings of up to 30% across Pakistan.
        </p>
    </div>
</section>

<!-- Bundles Showcase Grid -->
<section class="py-16 bg-[#080304]">
    <div class="container">
        
        <!-- Value Proposition Bar -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16 p-6 bg-[#0E0507] border border-[#C9A24B]/25 rounded-lg">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-[#C9A24B]/10 border border-[#C9A24B]/40 flex items-center justify-center text-[#C9A24B] text-xl">
                    <i class="fas fa-gift"></i>
                </div>
                <div>
                    <h4 class="font-serif text-base text-[#F5EFE6]">Velvet Presentation Box</h4>
                    <p class="text-xs text-[#F5EFE6]/60">Complimentary luxury unboxing experience</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-[#C9A24B]/10 border border-[#C9A24B]/40 flex items-center justify-center text-[#C9A24B] text-xl">
                    <i class="fas fa-percent"></i>
                </div>
                <div>
                    <h4 class="font-serif text-base text-[#F5EFE6]">Guaranteed Savings</h4>
                    <p class="text-xs text-[#F5EFE6]/60">Save up to Rs. 10,000 compared to individual bottles</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-[#C9A24B]/10 border border-[#C9A24B]/40 flex items-center justify-center text-[#C9A24B] text-xl">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <div>
                    <h4 class="font-serif text-base text-[#F5EFE6]">Complimentary Express Air</h4>
                    <p class="text-xs text-[#F5EFE6]/60">24-48 Hour insured TCS delivery to all cities</p>
                </div>
            </div>
        </div>

        <!-- Master Bundles List -->
        <div class="space-y-12">
            @forelse($bundles as $bundle)
                <div class="bg-[#0C0507] border border-[#C9A24B]/30 rounded-lg p-6 lg:p-8 shadow-2xl hover:border-[#C9A24B]/60 transition-all duration-300">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        
                        <!-- Left: Bundle Image Showcase -->
                        <div class="lg:col-span-4 relative group">
                            <div class="relative overflow-hidden rounded border border-[#C9A24B]/20 bg-[#120709] p-4 text-center">
                                <img 
                                    src="{{ asset($bundle->image_url ?? 'assets/images/perfumes/bundle_royale.svg') }}" 
                                    alt="{{ $bundle->name }}" 
                                    class="w-full h-64 object-contain mx-auto transform group-hover:scale-105 transition-transform duration-500"
                                >
                                @if($bundle->savings_amount > 0)
                                    <div class="absolute top-3 left-3 bg-[#4A0E17] text-[#F5EFE6] border border-[#C9A24B]/40 px-3 py-1 text-[11px] font-semibold tracking-wider uppercase rounded shadow">
                                        SAVE RS. {{ number_format($bundle->savings_amount) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Center: Bundle Details & Included Flacons -->
                        <div class="lg:col-span-5 space-y-4">
                            <div>
                                <span class="text-[10px] uppercase tracking-[0.25em] text-[#C9A24B] font-semibold">EXCLUSIVE DUO / TRIO SET</span>
                                <h3 class="font-serif text-2xl lg:text-3xl text-[#F5EFE6] mt-1">{{ $bundle->name }}</h3>
                                <p class="text-xs lg:text-sm text-[#F5EFE6]/70 mt-2 leading-relaxed">
                                    {{ $bundle->description }}
                                </p>
                            </div>

                            <!-- Included Items Preview -->
                            <div class="border-t border-b border-[#C9A24B]/15 py-4 my-4">
                                <h5 class="text-[11px] uppercase tracking-widest text-[#C9A24B] font-medium mb-3">
                                    <i class="fas fa-layer-group mr-1"></i> Included in this Imperial Coffret:
                                </h5>
                                
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach($bundle->items as $item)
                                        <div class="flex items-center space-x-3 bg-[#14080B] p-2.5 rounded border border-[#C9A24B]/15">
                                            @if($item->product && $item->product->primaryImage)
                                                <img src="{{ asset($item->product->primaryImage->image_path) }}" alt="{{ $item->product->name }}" class="w-10 h-10 object-contain rounded bg-[#080304] p-0.5">
                                            @endif
                                            <div class="min-w-0">
                                                <p class="text-xs text-[#F5EFE6] font-serif truncate">{{ $item->product->name ?? 'Perfume Flacon' }}</p>
                                                <p class="text-[10px] text-[#C9A24B]">{{ $item->variant_label ?? '100ml Extrait' }} &bull; Qty: {{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Right: Pricing & Call to Action -->
                        <div class="lg:col-span-3 bg-[#110609] border border-[#C9A24B]/30 rounded-lg p-6 text-center space-y-4">
                            <div>
                                <span class="text-[10px] uppercase tracking-widest text-[#F5EFE6]/50 block mb-1">Bundle Privilege Price</span>
                                <div class="font-serif text-3xl text-[#C9A24B] font-bold">
                                    Rs. {{ number_format($bundle->price) }}
                                </div>
                                @if($bundle->original_price > $bundle->price)
                                    <div class="text-xs text-[#F5EFE6]/40 line-through mt-1">
                                        Rs. {{ number_format($bundle->original_price) }}
                                    </div>
                                    <div class="text-[11px] text-emerald-400 font-medium mt-1">
                                        You Save: Rs. {{ number_format($bundle->savings_amount) }} ({{ round((($bundle->original_price - $bundle->price)/$bundle->original_price)*100) }}%)
                                    </div>
                                @endif
                            </div>

                            <button 
                                type="button"
                                class="w-full btn-gold py-3 text-xs tracking-widest uppercase quick-add-btn flex items-center justify-center space-x-2"
                                data-product-id="{{ $bundle->id }}"
                                data-is-bundle="true"
                            >
                                <i class="fas fa-shopping-bag"></i>
                                <span>ADD BUNDLE TO CART</span>
                            </button>

                            <a 
                                href="https://wa.me/923001234567?text={{ urlencode('Salam! I would like to order the ' . $bundle->name . ' for Rs. ' . number_format($bundle->price)) }}" 
                                target="_blank" 
                                class="w-full btn-whatsapp py-2.5 text-xs tracking-wider flex items-center justify-center space-x-2 block"
                            >
                                <i class="fab fa-whatsapp"></i>
                                <span>ORDER ON WHATSAPP</span>
                            </a>

                            <div class="text-[10px] text-[#F5EFE6]/50">
                                <i class="fas fa-shield-alt text-[#C9A24B] mr-1"></i> 100% Guaranteed Authentic Extrait
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-[#0C0507] border border-[#C9A24B]/20 rounded-lg p-8">
                    <p class="text-[#F5EFE6]/70">No bundles currently active. Check back shortly for seasonal discovery coffrets.</p>
                </div>
            @endforelse
        </div>

    </div>
</section>

@endsection
