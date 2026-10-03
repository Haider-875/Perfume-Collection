@extends('layouts.app')

@section('title', $product->name . ' (' . $product->concentration . ') | Maison d\'Orient Pakistan')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($product->description), 160))

@section('content')

<!-- PDP Breadcrumbs Header -->
<section class="py-6 bg-[#0A0405] border-b border-[#C9A24B]/15">
    <div class="container mx-auto px-4 lg:px-8">
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'The Vault', 'url' => route('collections.show', 'all')],
            ['label' => $product->category->name ?? 'Extrait', 'url' => route('collections.show', $product->category->slug ?? 'all')],
            ['label' => $product->name]
        ]" />
    </div>
</section>

<!-- PDP Master Showcase -->
<section class="py-12 md:py-16 bg-[#080304]">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Left Column: Large Interactive Gallery (lg:col-span-6) -->
            <div class="lg:col-span-6 space-y-4">
                <!-- Main Flacon Display with Hover Zoom -->
                <div class="relative bg-[#110608] border border-[#C9A24B]/35 rounded-xl p-8 text-center shadow-2xl overflow-hidden group">
                    <div class="absolute inset-0 bg-radial-gradient opacity-30 pointer-events-none"></div>
                    
                    @if($product->is_bestseller)
                        <span class="absolute top-4 left-4 bg-[#4A0E17] text-[#F5EFE6] border border-[#C9A24B]/40 px-3 py-1 text-[10px] uppercase tracking-widest font-semibold rounded shadow-md z-10">
                            BESTSELLER EXTRAIT
                        </span>
                    @elseif($product->is_new_arrival)
                        <span class="absolute top-4 left-4 bg-[#0F2A1D] text-emerald-300 border border-emerald-500/40 px-3 py-1 text-[10px] uppercase tracking-widest font-semibold rounded shadow-md z-10">
                            NEW ARRIVAL
                        </span>
                    @endif

                    <div class="relative h-[380px] sm:h-[460px] flex items-center justify-center">
                        <img 
                            id="pdpMasterImage" 
                            src="{{ asset($product->primary_image_url) }}" 
                            alt="{{ $product->name }}" 
                            class="max-h-full max-w-full object-contain filter drop-shadow-2xl transform group-hover:scale-105 transition-transform duration-500"
                        >
                    </div>

                    <div class="text-[11px] text-[#F5EFE6]/40 uppercase tracking-widest mt-4">
                        <i class="fas fa-magnifying-glass-plus text-[#C9A24B] mr-1"></i> Artisanal 24K Gold Embellished Crystal Flacon
                    </div>
                </div>

                <!-- Thumbnail Selector Row -->
                @if($product->images->count() > 1)
                    <div class="flex items-center justify-center space-x-3 overflow-x-auto py-2">
                        @foreach($product->images as $img)
                            <button 
                                type="button" 
                                onclick="document.getElementById('pdpMasterImage').src='{{ asset($img->image_path) }}'; document.querySelectorAll('.pdp-thumb-btn').forEach(b => b.classList.remove('border-[#C9A24B]', 'bg-[#C9A24B]/10')); this.classList.add('border-[#C9A24B]', 'bg-[#C9A24B]/10');"
                                class="pdp-thumb-btn w-16 h-16 rounded border {{ $loop->first ? 'border-[#C9A24B] bg-[#C9A24B]/10' : 'border-[#C9A24B]/20 bg-[#120709]' }} p-1 transition flex items-center justify-center"
                            >
                                <img src="{{ asset($img->image_path) }}" alt="{{ $img->alt_text }}" class="max-h-full max-w-full object-contain">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Column: Sticky Purchase Engine & Olfactory Spec (lg:col-span-6) -->
            <div class="lg:col-span-6 space-y-6 lg:sticky lg:top-28">
                
                <!-- Category, Brand & Concentration Badges -->
                <div class="flex items-center space-x-3">
                    <span class="text-[11px] uppercase tracking-[0.25em] text-[#C9A24B] font-semibold border border-[#C9A24B]/30 px-2.5 py-0.5 rounded">
                        {{ $product->concentration ?? 'EXTRAIT DE PARFUM' }}
                    </span>
                    <span class="text-xs text-[#F5EFE6]/60">
                        {{ $product->fragranceFamily->name ?? 'Royal Oriental' }} &bull; {{ ucfirst($product->gender) }}
                    </span>
                </div>

                <!-- Product Title & Tagline -->
                <div>
                    <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl text-[#F5EFE6] leading-tight font-normal">
                        {{ $product->name }}
                    </h1>
                    @if($product->tagline)
                        <p class="font-serif text-base sm:text-lg text-[#E6C77A] italic mt-1 font-light">
                            "{{ $product->tagline }}"
                        </p>
                    @endif
                </div>

                <!-- Rating & Reviews Summary -->
                <div class="flex items-center space-x-3 text-xs border-y border-[#C9A24B]/15 py-3">
                    <div class="flex text-[#C9A24B]">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round($product->rating_avg) ? '' : 'opacity-30' }}"></i>
                        @endfor
                    </div>
                    <span class="text-[#F5EFE6] font-semibold">{{ number_format($product->rating_avg, 1) }} / 5.0</span>
                    <span class="text-[#F5EFE6]/50">({{ $product->reviews_count }} Verified Patron Reviews)</span>
                </div>

                <!-- Pricing & Savings in PKR -->
                <div class="space-y-1">
                    <div class="flex items-baseline space-x-3">
                        <span class="font-serif text-3xl sm:text-4xl text-[#C9A24B] font-bold">
                            {{ $product->formatted_effective_price }}
                        </span>
                        @if($product->compare_at_price > $product->price)
                            <span class="text-sm text-[#F5EFE6]/40 line-through">
                                {{ $product->formatted_compare_at_price }}
                            </span>
                            <span class="bg-[#4A0E17] text-[#F5EFE6] text-[10px] uppercase tracking-wider px-2 py-0.5 rounded font-semibold border border-[#C9A24B]/30">
                                SAVE {{ $product->discount_percentage }}%
                            </span>
                        @endif
                    </div>
                    <div class="text-[11px] text-[#F5EFE6]/60 flex items-center space-x-1">
                        <i class="fas fa-truck-fast text-[#C9A24B]"></i>
                        <span>Includes complimentary TCS Express Air shipping anywhere in Pakistan</span>
                    </div>
                </div>

                <!-- Flacon Size (ml) Selector -->
                <div class="space-y-2 pt-2">
                    <label class="block text-xs uppercase tracking-widest text-[#C9A24B] font-semibold">
                        Select Flacon Volume: <span id="selectedVolumeLabel" class="text-[#F5EFE6]">{{ $product->volume_ml }}ml Extrait</span>
                    </label>
                    <div class="flex flex-wrap gap-3">
                        @forelse($product->variants as $variant)
                            <button 
                                type="button" 
                                onclick="document.querySelectorAll('.pdp-variant-btn').forEach(b => b.classList.remove('border-[#C9A24B]', 'bg-[#C9A24B]/15', 'text-[#C9A24B]')); this.classList.add('border-[#C9A24B]', 'bg-[#C9A24B]/15', 'text-[#C9A24B]'); document.getElementById('selectedVolumeLabel').innerText = '{{ $variant->name }}';"
                                class="pdp-variant-btn px-4 py-2.5 rounded border {{ $loop->first ? 'border-[#C9A24B] bg-[#C9A24B]/15 text-[#C9A24B]' : 'border-[#C9A24B]/30 bg-[#120709] text-[#F5EFE6]/80' }} text-xs uppercase tracking-wider font-semibold transition hover:border-[#C9A24B]"
                            >
                                {{ $variant->name }} &bull; Rs. {{ number_format($variant->price) }}
                            </button>
                        @empty
                            <button type="button" class="px-5 py-2.5 rounded border border-[#C9A24B] bg-[#C9A24B]/15 text-[#C9A24B] text-xs uppercase tracking-wider font-semibold">
                                {{ $product->volume_ml }}ml Extrait Flacon
                            </button>
                        @endforelse
                    </div>
                </div>

                <!-- Quantity & Add to Cart Engine -->
                <div class="space-y-3 pt-2">
                    <div class="flex items-center space-x-4">
                        <!-- Quantity Counter -->
                        <div class="flex items-center border border-[#C9A24B]/40 bg-[#120709] rounded">
                            <button type="button" onclick="let q = document.getElementById('pdpQty'); if(parseInt(q.value) > 1) q.value = parseInt(q.value) - 1;" class="px-3 py-2 text-[#C9A24B] hover:text-[#E6C77A] text-sm">&minus;</button>
                            <input type="number" id="pdpQty" value="1" min="1" max="10" class="w-12 text-center bg-transparent text-xs text-[#F5EFE6] font-semibold focus:outline-none" readonly>
                            <button type="button" onclick="let q = document.getElementById('pdpQty'); if(parseInt(q.value) < 10) q.value = parseInt(q.value) + 1;" class="px-3 py-2 text-[#C9A24B] hover:text-[#E6C77A] text-sm">&plus;</button>
                        </div>

                        <!-- Add to Cart CTA -->
                        <button 
                            type="button" 
                            class="flex-1 btn-gold py-3 text-xs tracking-widest uppercase quick-add-btn flex items-center justify-center space-x-2"
                            data-product-id="{{ $product->id }}"
                        >
                            <i class="fas fa-shopping-bag"></i>
                            <span>ADD TO PRIVATE VAULT</span>
                        </button>
                    </div>

                    <!-- Direct WhatsApp 1-Click Order -->
                    <a 
                        href="{{ $product->whatsapp_order_url }}" 
                        target="_blank" 
                        class="w-full btn-whatsapp py-3 text-xs tracking-widest uppercase flex items-center justify-center space-x-2 block text-center"
                    >
                        <i class="fab fa-whatsapp text-sm"></i>
                        <span>1-CLICK ORDER ON WHATSAPP (COD)</span>
                    </a>
                </div>

                <!-- Pakistan Express Delivery & Logistics Estimator -->
                <div class="p-4 bg-[#0E0507] border border-[#C9A24B]/25 rounded-lg space-y-2 text-xs">
                    <div class="flex items-center justify-between text-[#C9A24B] font-semibold">
                        <span class="flex items-center space-x-1.5">
                            <i class="fas fa-location-dot"></i>
                            <span>Pakistan Dispatch Calculator:</span>
                        </span>
                        <span class="text-emerald-400"><i class="fas fa-circle-check"></i> In Stock &bull; Lahore Atelier</span>
                    </div>
                    <p class="text-[#F5EFE6]/70 leading-relaxed">
                        Orders placed today arrive in <strong>Lahore, Karachi, Islamabad & Rawalpindi</strong> in 24–48 hours via TCS Express Air. Cash on Delivery accepted with zero fee.
                    </p>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- PDP Olfactory Pyramid & Performance Benchmark Meters -->
<section class="py-16 bg-[#0A0405] border-y border-[#C9A24B]/20">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left: Animated Olfactory Pyramid (lg:col-span-6) -->
            <div class="lg:col-span-6 space-y-6">
                <div class="text-left">
                    <span class="text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] font-semibold">HARMONIC ARCHITECTURE</span>
                    <h2 class="font-serif text-2xl md:text-3xl text-[#F5EFE6] mt-1">The Fragrance Notes Pyramid</h2>
                    <p class="text-xs text-[#F5EFE6]/60 mt-1">Evolution of accords on skin over 16+ hours</p>
                </div>

                <!-- Pyramid Tier 1: Top Notes -->
                <div class="p-5 bg-[#120709] border border-[#C9A24B]/30 rounded-lg space-y-2 relative overflow-hidden">
                    <div class="flex items-center justify-between">
                        <span class="text-xs uppercase tracking-widest text-[#E6C77A] font-semibold flex items-center space-x-2">
                            <i class="fas fa-sparkles text-[#C9A24B]"></i>
                            <span>Top Notes (First 15 - 45 Minutes)</span>
                        </span>
                        <span class="text-[10px] text-[#F5EFE6]/40 uppercase">Initial Radiance</span>
                    </div>
                    <p class="text-sm text-[#F5EFE6] font-serif">
                        {{ $product->top_notes_summary ?? 'Fresh Bergamot, Saffron Thread, Wild Cardamom' }}
                    </p>
                </div>

                <!-- Pyramid Tier 2: Heart Notes -->
                <div class="p-5 bg-[#14080B] border border-[#C9A24B]/40 rounded-lg space-y-2 relative overflow-hidden">
                    <div class="flex items-center justify-between">
                        <span class="text-xs uppercase tracking-widest text-[#C9A24B] font-semibold flex items-center space-x-2">
                            <i class="fas fa-heart text-[#C9A24B]"></i>
                            <span>Heart Notes (2 - 6 Hours)</span>
                        </span>
                        <span class="text-[10px] text-[#F5EFE6]/40 uppercase">Sensual Core</span>
                    </div>
                    <p class="text-sm text-[#F5EFE6] font-serif">
                        {{ $product->heart_notes_summary ?? 'Imperial Taif Rose, Smokey Frankincense, Leather Accords' }}
                    </p>
                </div>

                <!-- Pyramid Tier 3: Base Notes -->
                <div class="p-5 bg-[#180A0D] border border-[#C9A24B]/50 rounded-lg space-y-2 relative overflow-hidden">
                    <div class="flex items-center justify-between">
                        <span class="text-xs uppercase tracking-widest text-[#C9A24B] font-semibold flex items-center space-x-2">
                            <i class="fas fa-tree text-[#C9A24B]"></i>
                            <span>Base Notes (6 - 18+ Hours)</span>
                        </span>
                        <span class="text-[10px] text-[#C9A24B] uppercase font-bold">Monumental Longevity</span>
                    </div>
                    <p class="text-sm text-[#F5EFE6] font-serif">
                        {{ $product->base_notes_summary ?? 'Aged Cambodian Dehn al Oud, Warm Ambergris, Royal Sandalwood' }}
                    </p>
                </div>
            </div>

            <!-- Right: Performance Benchmark Meters (lg:col-span-6) -->
            <div class="lg:col-span-6 bg-[#0D0507] border border-[#C9A24B]/30 rounded-xl p-8 space-y-6 shadow-2xl">
                <div>
                    <span class="text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] font-semibold">LABORATORY BENCHMARKS</span>
                    <h3 class="font-serif text-2xl text-[#F5EFE6] mt-1">Extrait Performance Metrics</h3>
                </div>

                <!-- Longevity Meter -->
                <div class="space-y-2">
                    <div class="flex justify-between text-xs">
                        <span class="text-[#F5EFE6]/80 uppercase tracking-wider">Longevity on Skin & Fabric:</span>
                        <span class="text-[#C9A24B] font-semibold">{{ $product->longevity_rating ?? 9 }}/10 (16-18 Hours)</span>
                    </div>
                    <div class="w-full bg-[#1A0C0F] h-2 rounded-full overflow-hidden border border-[#C9A24B]/20">
                        <div class="bg-gradient-to-r from-[#9E782F] via-[#C9A24B] to-[#E6C77A] h-full rounded-full" style="width: {{ ($product->longevity_rating ?? 9) * 10 }}%;"></div>
                    </div>
                </div>

                <!-- Sillage Meter -->
                <div class="space-y-2">
                    <div class="flex justify-between text-xs">
                        <span class="text-[#F5EFE6]/80 uppercase tracking-wider">Sillage & Aura Projection:</span>
                        <span class="text-[#C9A24B] font-semibold">{{ $product->sillage_rating ?? 9 }}/10 (Room-Filling)</span>
                    </div>
                    <div class="w-full bg-[#1A0C0F] h-2 rounded-full overflow-hidden border border-[#C9A24B]/20">
                        <div class="bg-gradient-to-r from-[#9E782F] via-[#C9A24B] to-[#E6C77A] h-full rounded-full" style="width: {{ ($product->sillage_rating ?? 9) * 10 }}%;"></div>
                    </div>
                </div>

                <!-- Maceration Time -->
                <div class="space-y-2">
                    <div class="flex justify-between text-xs">
                        <span class="text-[#F5EFE6]/80 uppercase tracking-wider">Cold-Maceration Period:</span>
                        <span class="text-[#C9A24B] font-semibold">{{ $product->maceration_weeks ?? 12 }} Weeks Artisanal</span>
                    </div>
                    <div class="w-full bg-[#1A0C0F] h-2 rounded-full overflow-hidden border border-[#C9A24B]/20">
                        <div class="bg-gradient-to-r from-[#9E782F] via-[#C9A24B] to-[#E6C77A] h-full rounded-full" style="width: 95%;"></div>
                    </div>
                </div>

                <!-- Oil Concentration Badge -->
                <div class="pt-4 border-t border-[#C9A24B]/15 flex items-center justify-between text-xs text-[#F5EFE6]/70">
                    <div>
                        <span class="text-[10px] uppercase tracking-wider text-[#C9A24B] block font-semibold">Fragrance Concentration</span>
                        <span class="font-serif text-lg text-[#F5EFE6] font-bold">{{ $product->oil_concentration_percent ?? 38 }}% Pure Compounds</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] uppercase tracking-wider text-[#C9A24B] block font-semibold">Climate Optimization</span>
                        <span class="text-xs text-[#F5EFE6]">Pakistani Summers & Winters</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- PDP Tabs: Description, Ritual, Shipping, and Customer Reviews -->
<section class="py-16 bg-[#080304]">
    <div class="container mx-auto px-4 lg:px-8 max-w-5xl" x-data="{ currentTab: 'desc' }">
        
        <!-- Tab Headers -->
        <div class="flex border-b border-[#C9A24B]/30 mb-8 overflow-x-auto no-scrollbar">
            <button 
                type="button" 
                @click="currentTab = 'desc'" 
                :class="currentTab === 'desc' ? 'border-[#C9A24B] text-[#C9A24B] font-semibold bg-[#C9A24B]/10' : 'border-transparent text-[#F5EFE6]/60 hover:text-[#F5EFE6]'"
                class="px-6 py-3 text-xs uppercase tracking-[0.2em] border-b-2 transition-all duration-300 whitespace-nowrap"
            >
                The Composition Story
            </button>

            <button 
                type="button" 
                @click="currentTab = 'usage'" 
                :class="currentTab === 'usage' ? 'border-[#C9A24B] text-[#C9A24B] font-semibold bg-[#C9A24B]/10' : 'border-transparent text-[#F5EFE6]/60 hover:text-[#F5EFE6]'"
                class="px-6 py-3 text-xs uppercase tracking-[0.2em] border-b-2 transition-all duration-300 whitespace-nowrap"
            >
                The Application Ritual
            </button>

            <button 
                type="button" 
                @click="currentTab = 'shipping'" 
                :class="currentTab === 'shipping' ? 'border-[#C9A24B] text-[#C9A24B] font-semibold bg-[#C9A24B]/10' : 'border-transparent text-[#F5EFE6]/60 hover:text-[#F5EFE6]'"
                class="px-6 py-3 text-xs uppercase tracking-[0.2em] border-b-2 transition-all duration-300 whitespace-nowrap"
            >
                TCS Dispatch & Guarantees
            </button>

            <button 
                type="button" 
                @click="currentTab = 'reviews'" 
                :class="currentTab === 'reviews' ? 'border-[#C9A24B] text-[#C9A24B] font-semibold bg-[#C9A24B]/10' : 'border-transparent text-[#F5EFE6]/60 hover:text-[#F5EFE6]'"
                class="px-6 py-3 text-xs uppercase tracking-[0.2em] border-b-2 transition-all duration-300 whitespace-nowrap"
            >
                Patron Reviews ({{ $product->reviews_count }})
            </button>
        </div>

        <!-- Tab 1: Description -->
        <div x-show="currentTab === 'desc'" class="space-y-4 text-sm md:text-base text-[#F5EFE6]/80 leading-relaxed font-light">
            <p>{{ $product->description }}</p>
            <p>Every bottle is individually numbered and hand-filled at our Lahore atelier to preserve top note brightness and botanical resins.</p>
        </div>

        <!-- Tab 2: Application Ritual -->
        <div x-show="currentTab === 'usage'" class="space-y-4 text-sm md:text-base text-[#F5EFE6]/80 leading-relaxed font-light" style="display: none;">
            <h4 class="font-serif text-lg text-[#C9A24B]">Mastering the Sillage of Extrait de Parfum</h4>
            <ul class="list-disc pl-5 space-y-2 text-sm text-[#F5EFE6]/75">
                <li><strong>Pulse Points:</strong> Apply 2 to 3 sprays directly on pulse points — the sides of your neck, behind the ears, and inside wrists.</li>
                <li><strong>Fabric Longevity:</strong> Spray lightly on linen, wool, or cotton garments. Extrait compounds hold onto natural fibers for up to 48 hours.</li>
                <li><strong>Never Rub:</strong> Allow the formulation to naturally settle on skin without friction, ensuring top notes blossom gracefully.</li>
            </ul>
        </div>

        <!-- Tab 3: Shipping & Guarantee -->
        <div x-show="currentTab === 'shipping'" class="space-y-4 text-sm md:text-base text-[#F5EFE6]/80 leading-relaxed font-light" style="display: none;">
            <h4 class="font-serif text-lg text-[#C9A24B]">Pakistan Express Air Logistics</h4>
            <p>We dispatch via TCS Express Air and Leopards with full insurance. Same-day dispatch for orders received before 4:00 PM.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                <div class="p-4 bg-[#120709] border border-[#C9A24B]/20 rounded">
                    <strong class="text-[#F5EFE6] block mb-1">Lahore, Karachi, Islamabad / RWP:</strong>
                    <span class="text-xs text-[#C9A24B]">24 - 48 Hours Delivery</span>
                </div>
                <div class="p-4 bg-[#120709] border border-[#C9A24B]/20 rounded">
                    <strong class="text-[#F5EFE6] block mb-1">All Other Pakistan Cities:</strong>
                    <span class="text-xs text-[#C9A24B]">48 - 72 Hours Delivery</span>
                </div>
            </div>
        </div>

        <!-- Tab 4: Reviews & Review Form -->
        <div x-show="currentTab === 'reviews'" class="space-y-8" style="display: none;">
            <!-- Write Review Form -->
            <div class="bg-[#0E0507] border border-[#C9A24B]/30 rounded-lg p-6">
                <h4 class="font-serif text-xl text-[#F5EFE6] mb-4">Record Your Olfactory Impression</h4>
                <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-[#C9A24B] mb-1">Your Full Name *</label>
                            <input type="text" name="customer_name" required placeholder="e.g. Tariq Mehmood" class="w-full bg-[#14080B] border border-[#C9A24B]/30 rounded px-3 py-2 text-xs text-[#F5EFE6] focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-[#C9A24B] mb-1">Your City in Pakistan *</label>
                            <input type="text" name="customer_city" required placeholder="e.g. Lahore / Karachi" class="w-full bg-[#14080B] border border-[#C9A24B]/30 rounded px-3 py-2 text-xs text-[#F5EFE6] focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-[#C9A24B] mb-1">Rating *</label>
                            <select name="rating" required class="w-full bg-[#14080B] border border-[#C9A24B]/30 rounded px-3 py-2 text-xs text-[#F5EFE6] focus:outline-none">
                                <option value="5">5 Stars - Imperial Masterpiece</option>
                                <option value="4">4 Stars - Highly Refined</option>
                                <option value="3">3 Stars - Pleasant Formulation</option>
                                <option value="2">2 Stars - Average</option>
                                <option value="1">1 Star - Disappointed</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-[#C9A24B] mb-1">Review Title</label>
                        <input type="text" name="title" placeholder="e.g. Monumental sillage at an evening wedding" class="w-full bg-[#14080B] border border-[#C9A24B]/30 rounded px-3 py-2 text-xs text-[#F5EFE6] focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-[#C9A24B] mb-1">Your Review *</label>
                        <textarea name="comment" required rows="3" placeholder="Share your experience regarding projection, longevity, and compliments received..." class="w-full bg-[#14080B] border border-[#C9A24B]/30 rounded px-3 py-2 text-xs text-[#F5EFE6] focus:outline-none"></textarea>
                    </div>
                    <button type="submit" class="btn-gold py-2 px-6 text-xs uppercase tracking-widest">
                        Submit Verified Review
                    </button>
                </form>
            </div>

            <!-- Existing Reviews List -->
            <div class="space-y-4">
                @forelse($product->reviews as $review)
                    <div class="p-5 bg-[#0C0507] border border-[#C9A24B]/20 rounded-lg space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-7 h-7 rounded-full bg-[#C9A24B]/20 flex items-center justify-center text-[#C9A24B] text-xs font-bold">
                                    {{ substr($review->user_name ?? 'P', 0, 1) }}
                                </div>
                                <div>
                                    <span class="font-serif text-sm text-[#F5EFE6] font-semibold">{{ $review->user_name }}</span>
                                    <span class="text-[10px] text-[#C9A24B] ml-2"><i class="fas fa-check-circle"></i> Verified Patron &bull; {{ $review->user_city ?? 'Pakistan' }}</span>
                                </div>
                            </div>
                            <div class="flex text-[#C9A24B] text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? '' : 'opacity-30' }}"></i>
                                @endfor
                            </div>
                        </div>
                        @if($review->review_title)
                            <h5 class="text-xs font-semibold text-[#E6C77A]">{{ $review->review_title }}</h5>
                        @endif
                        <p class="text-xs text-[#F5EFE6]/70 leading-relaxed font-light">
                            "{{ $review->comment }}"
                        </p>
                    </div>
                @empty
                    <p class="text-xs text-[#F5EFE6]/50 italic text-center py-6">Be the first connoisseur to review this masterpiece.</p>
                @endforelse
            </div>
        </div>

    </div>
</section>

<!-- Related Pairings Carousel / You May Also Like -->
@if($relatedProducts->count() > 0)
    <section class="py-16 bg-[#0A0405] border-t border-[#C9A24B]/20">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-10">
                <span class="text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] font-semibold">OLFACTORY HARMONY</span>
                <h3 class="font-serif text-2xl md:text-3xl text-[#F5EFE6] mt-1">You May Also Covet</h3>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                @foreach($relatedProducts as $rel)
                    <x-product-card :product="$rel" />
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- Mobile Sticky Add-to-Cart Bottom Bar -->
<div class="fixed bottom-0 inset-x-0 z-40 bg-[#0A0405]/95 backdrop-blur-md border-t border-[#C9A24B]/40 p-3 lg:hidden flex items-center justify-between shadow-2xl">
    <div>
        <div class="text-xs font-serif text-[#F5EFE6] truncate max-w-[160px]">{{ $product->name }}</div>
        <div class="text-xs font-semibold text-[#C9A24B]">{{ $product->formatted_effective_price }}</div>
    </div>
    <div class="flex items-center space-x-2">
        <a href="{{ $product->whatsapp_order_url }}" target="_blank" class="btn-whatsapp py-2 px-3 text-[11px]">
            <i class="fab fa-whatsapp"></i>
        </a>
        <button 
            type="button" 
            class="btn-gold py-2 px-4 text-[11px] tracking-wider quick-add-btn uppercase"
            data-product-id="{{ $product->id }}"
        >
            ADD TO CART
        </button>
    </div>
</div>

@endsection
