@extends('layouts.app')

@section('title', $product->name . ($product->impression_of ? ' (Our Impression of ' . $product->impression_of . ')' : '') . ' | RAVAHA Parfums Pakistan')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($product->description), 160))

@section('content')

<div x-data="{
    selectedVariantId: {{ $product->variants->first()?->id ?? 'null' }},
    selectedPrice: {{ $product->variants->first()?->price ?? $product->price }},
    selectedComparePrice: {{ $product->variants->first()?->compare_at_price ?? ($product->compare_at_price ?? 0) }},
    selectedLabel: '{{ $product->variants->first()?->size_label ?? ($product->volume_ml . 'ml Flacon') }}',
    quantity: 1,
    get formattedPrice() {
        return 'Rs. ' + new Intl.NumberFormat().format(this.selectedPrice);
    },
    get formattedComparePrice() {
        return this.selectedComparePrice > this.selectedPrice ? 'Rs. ' + new Intl.NumberFormat().format(this.selectedComparePrice) : '';
    },
    get savingsPercent() {
        if (this.selectedComparePrice > this.selectedPrice) {
            return Math.round(((this.selectedComparePrice - this.selectedPrice) / this.selectedComparePrice) * 100);
        }
        return 0;
    },
    get whatsappUrl() {
        const text = encodeURIComponent('Salam! I want to order ' + '{{ addslashes($product->name) }}' + ' (' + this.selectedLabel + ') for ' + this.formattedPrice + ' with Cash on Delivery.');
        return 'https://wa.me/{{ $whatsappNum }}?text=' + text;
    },
    addToCart() {
        addToCartAjax({{ $product->id }}, this.quantity, this.selectedVariantId);
    }
}">

<!-- PDP Breadcrumbs Header -->
<section class="py-4 bg-gray-50 border-b border-gray-200">
    <div class="container mx-auto px-4 lg:px-8">
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'All Impressions', 'url' => route('collections.show', 'all')],
            ['label' => $product->category->name ?? 'Extrait', 'url' => route('collections.show', $product->category->slug ?? 'all')],
            ['label' => $product->name]
        ]" />
    </div>
</section>

<!-- PDP Master Showcase -->
<section class="py-10 md:py-14 bg-white border-b border-gray-200">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
            
            <!-- Left Column: Large Interactive Gallery (lg:col-span-6) -->
            <div class="lg:col-span-6 space-y-4">
                <!-- Main Flacon Display with Hover Zoom -->
                <div class="relative bg-gray-50 border border-gray-200 rounded-2xl p-8 sm:p-10 text-center shadow-sm overflow-hidden group">
                    @if($product->is_bestseller)
                        <span class="absolute top-4 left-4 bg-amber-800 text-white px-3 py-1 text-[10px] uppercase tracking-widest font-bold rounded shadow z-10">
                            BESTSELLER
                        </span>
                    @elseif($product->is_new_arrival)
                        <span class="absolute top-4 left-4 bg-emerald-800 text-white px-3 py-1 text-[10px] uppercase tracking-widest font-bold rounded shadow z-10">
                            NEW ARRIVAL
                        </span>
                    @endif

                    <div class="relative h-[360px] sm:h-[440px] flex items-center justify-center">
                        <img 
                            id="pdpMasterImage" 
                            src="{{ asset($product->primary_image_url) }}" 
                            alt="{{ $product->name }}" 
                            class="max-h-full max-w-full object-contain filter drop-shadow-xl transform group-hover:scale-105 transition-transform duration-500"
                        >
                    </div>

                    <div class="text-[11px] text-gray-500 uppercase tracking-wider mt-4">
                        <i class="fas fa-certificate text-amber-700 mr-1.5"></i> 35%–40% Extrait Concentration &bull; High Luxury Glass Flacon
                    </div>
                </div>

                <!-- Thumbnail Selector Row -->
                @if($product->images->count() > 1)
                    <div class="flex items-center justify-center space-x-3 overflow-x-auto py-2">
                        @foreach($product->images as $img)
                            <button 
                                type="button" 
                                onclick="document.getElementById('pdpMasterImage').src='{{ asset($img->image_path) }}'; document.querySelectorAll('.pdp-thumb-btn').forEach(b => b.classList.remove('border-amber-700', 'ring-2', 'ring-amber-500/30')); this.classList.add('border-amber-700', 'ring-2', 'ring-amber-500/30');"
                                class="pdp-thumb-btn w-16 h-16 rounded-lg border {{ $loop->first ? 'border-amber-700 ring-2 ring-amber-500/30' : 'border-gray-200 bg-gray-50' }} p-1.5 transition flex items-center justify-center"
                            >
                                <img src="{{ asset($img->image_path) }}" alt="{{ $img->alt_text }}" class="max-h-full max-w-full object-contain">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Column: Sticky Purchase Engine & Olfactory Spec (lg:col-span-6) -->
            <div class="lg:col-span-6 space-y-6 lg:sticky lg:top-28">
                
                <!-- Impression Badge (Key Rawaha Feature) -->
                @if($product->impression_of)
                    <div class="inline-flex items-center space-x-2 bg-amber-50 border border-amber-300 px-3.5 py-1.5 rounded-full text-xs font-semibold text-amber-900 shadow-sm">
                        <i class="fas fa-crown text-amber-600 text-xs"></i>
                        <span>Our Impression of: <strong class="underline decoration-amber-400">{{ $product->impression_of }}</strong></span>
                    </div>
                @endif

                <!-- Concentration & Family Badges -->
                <div class="flex items-center space-x-3 text-xs">
                    <span class="uppercase tracking-widest text-amber-800 font-bold bg-amber-100/60 border border-amber-200 px-2.5 py-0.5 rounded">
                        {{ $product->concentration ?? 'EXTRAIT DE PARFUM' }}
                    </span>
                    <span class="text-gray-500">
                        {{ $product->fragranceFamily->name ?? 'Royal Oriental' }} &bull; {{ ucfirst($product->gender) }}
                    </span>
                </div>

                <!-- Product Title & Tagline -->
                <div>
                    <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl text-gray-900 leading-tight font-normal">
                        {{ $product->name }}
                    </h1>
                    @if($product->tagline)
                        <p class="font-serif text-base sm:text-lg text-amber-800 italic mt-1 font-light">
                            "{{ $product->tagline }}"
                        </p>
                    @endif
                </div>

                <!-- Rating & Reviews Summary -->
                <div class="flex items-center space-x-3 text-xs border-y border-gray-100 py-3">
                    <div class="flex text-amber-500">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round($product->rating_avg) ? '' : 'text-gray-200' }}"></i>
                        @endfor
                    </div>
                    <span class="text-gray-900 font-bold">{{ number_format($product->rating_avg, 1) }} / 5.0</span>
                    <span class="text-gray-500">({{ $product->reviews_count }} Verified Patron Reviews)</span>
                </div>

                <!-- Dynamic Pricing & Savings in PKR -->
                <div class="space-y-1">
                    <div class="flex items-baseline space-x-3">
                        <span class="font-serif text-3xl sm:text-4xl text-gray-900 font-bold" x-text="formattedPrice">
                            {{ $product->formatted_effective_price }}
                        </span>
                        <span class="text-sm text-gray-400 line-through" x-text="formattedComparePrice"></span>
                        <template x-if="savingsPercent > 0">
                            <span class="bg-red-50 text-red-700 text-[11px] uppercase tracking-wider px-2 py-0.5 rounded font-bold border border-red-200">
                                SAVE <span x-text="savingsPercent"></span>%
                            </span>
                        </template>
                    </div>
                    <div class="text-[11px] text-gray-500 flex items-center space-x-1.5 pt-1">
                        <i class="fas fa-truck-fast text-amber-700"></i>
                        <span>Includes Free TCS Express Air shipping across Pakistan (Orders over Rs. 3,500)</span>
                    </div>
                </div>

                <!-- Flacon Size (ml) Selector (Reactive Alpine) -->
                <div class="space-y-2 pt-2">
                    <label class="block text-xs uppercase tracking-widest text-gray-700 font-bold">
                        Select Flacon Volume: <span class="text-amber-800" x-text="selectedLabel"></span>
                    </label>
                    <div class="flex flex-wrap gap-2.5">
                        @forelse($product->variants as $variant)
                            <button 
                                type="button" 
                                @click="selectedVariantId = {{ $variant->id }}; selectedPrice = {{ $variant->price }}; selectedComparePrice = {{ $variant->compare_at_price ?? 0 }}; selectedLabel = '{{ $variant->size_label }}';"
                                :class="selectedVariantId === {{ $variant->id }} ? 'border-amber-700 bg-amber-50 text-amber-900 shadow-sm' : 'border-gray-200 bg-white text-gray-700 hover:border-gray-300'"
                                class="px-4 py-2.5 rounded-lg border text-xs uppercase tracking-wider font-semibold transition flex items-center space-x-2"
                            >
                                <span>{{ $variant->size_label }}</span>
                                <span class="text-[11px] text-gray-400">&bull;</span>
                                <span class="font-bold text-gray-900">Rs. {{ number_format($variant->price) }}</span>
                            </button>
                        @empty
                            <button type="button" class="px-5 py-2.5 rounded-lg border border-amber-700 bg-amber-50 text-amber-900 text-xs uppercase tracking-wider font-semibold">
                                {{ $product->volume_ml }}ml Extrait Flacon
                            </button>
                        @endforelse
                    </div>
                </div>

                <!-- Quantity & Add to Cart Engine -->
                <div class="space-y-3 pt-2">
                    <div class="flex items-center space-x-4">
                        <!-- Quantity Counter -->
                        <div class="flex items-center border border-gray-300 bg-gray-50 rounded-lg">
                            <button type="button" @click="if(quantity > 1) quantity--" class="px-3.5 py-2 text-gray-600 hover:text-gray-900 text-sm font-bold">&minus;</button>
                            <input type="number" x-model="quantity" min="1" max="10" class="w-12 text-center bg-transparent text-xs text-gray-900 font-bold focus:outline-none" readonly>
                            <button type="button" @click="if(quantity < 10) quantity++" class="px-3.5 py-2 text-gray-600 hover:text-gray-900 text-sm font-bold">&plus;</button>
                        </div>

                        <!-- Add to Cart CTA -->
                        <button 
                            type="button" 
                            @click="addToCart()"
                            class="flex-1 btn-gold py-3 text-xs tracking-widest uppercase flex items-center justify-center space-x-2"
                        >
                            <i class="fas fa-shopping-bag"></i>
                            <span>ADD TO FRAGRANCE BAG</span>
                        </button>
                    </div>

                    <!-- Direct WhatsApp 1-Click Order -->
                    <a 
                        :href="whatsappUrl" 
                        target="_blank" 
                        class="w-full btn-whatsapp py-3 text-xs tracking-widest uppercase flex items-center justify-center space-x-2 block text-center"
                    >
                        <i class="fab fa-whatsapp text-sm"></i>
                        <span>1-CLICK ORDER ON WHATSAPP (COD)</span>
                    </a>
                </div>

                <!-- Pakistan Express Delivery & Logistics Estimator -->
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl space-y-2 text-xs">
                    <div class="flex items-center justify-between text-gray-900 font-bold">
                        <span class="flex items-center space-x-1.5">
                            <i class="fas fa-location-dot text-amber-700"></i>
                            <span>Pakistan Dispatch Time:</span>
                        </span>
                        <span class="text-emerald-700"><i class="fas fa-circle-check"></i> In Stock &bull; Lahore Atelier</span>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Orders placed today arrive in <strong>Lahore, Karachi, Islamabad & Rawalpindi</strong> in 24–48 hours via TCS Express Air. Cash on Delivery accepted nationwide.
                    </p>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- PDP Olfactory Pyramid & Performance Benchmark Meters -->
<section class="py-16 bg-gray-50 border-b border-gray-200">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            
            <!-- Left: Animated Olfactory Pyramid (lg:col-span-6) -->
            <div class="lg:col-span-6 space-y-6">
                <div class="text-left">
                    <span class="text-[11px] uppercase tracking-[0.25em] text-amber-800 font-bold">HARMONIC ARCHITECTURE</span>
                    <h2 class="font-serif text-2xl md:text-3xl text-gray-900 mt-1 font-normal">The Fragrance Notes Pyramid</h2>
                    <p class="text-xs text-gray-500 mt-1">Evolution of accords on skin over 16+ hours</p>
                </div>

                <!-- Pyramid Tier 1: Top Notes -->
                <div class="p-5 bg-white border border-gray-200 rounded-xl space-y-2 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs uppercase tracking-widest text-amber-800 font-bold flex items-center space-x-2">
                            <i class="fas fa-sparkles text-amber-600"></i>
                            <span>Top Notes (First 15 - 45 Minutes)</span>
                        </span>
                        <span class="text-[10px] text-gray-400 uppercase font-semibold">Opening Spark</span>
                    </div>
                    <p class="text-sm text-gray-800 font-serif">
                        {{ $product->fragrance_notes_pyramid['top'] ?? ($product->top_notes_summary ?? 'Fresh Bergamot, Kashmiri Saffron, Pink Pepper') }}
                    </p>
                </div>

                <!-- Pyramid Tier 2: Heart Notes -->
                <div class="p-5 bg-white border border-gray-200 rounded-xl space-y-2 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs uppercase tracking-widest text-amber-800 font-bold flex items-center space-x-2">
                            <i class="fas fa-heart text-amber-600"></i>
                            <span>Heart Notes (2 - 6 Hours)</span>
                        </span>
                        <span class="text-[10px] text-gray-400 uppercase font-semibold">Sensual Heart</span>
                    </div>
                    <p class="text-sm text-gray-800 font-serif">
                        {{ $product->fragrance_notes_pyramid['heart'] ?? ($product->heart_notes_summary ?? 'Imperial Taif Rose, Smokey Frankincense, Leather Accords') }}
                    </p>
                </div>

                <!-- Pyramid Tier 3: Base Notes -->
                <div class="p-5 bg-white border border-gray-200 rounded-xl space-y-2 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs uppercase tracking-widest text-amber-800 font-bold flex items-center space-x-2">
                            <i class="fas fa-tree text-amber-600"></i>
                            <span>Base Notes (6 - 18+ Hours)</span>
                        </span>
                        <span class="text-[10px] text-amber-800 uppercase font-bold">14+ Hours Longevity</span>
                    </div>
                    <p class="text-sm text-gray-800 font-serif">
                        {{ $product->fragrance_notes_pyramid['base'] ?? ($product->base_notes_summary ?? 'Aged Cambodian Dehn al Oud, Warm Ambergris, Royal Sandalwood') }}
                    </p>
                </div>
            </div>

            <!-- Right: Performance Benchmark Meters (lg:col-span-6) -->
            <div class="lg:col-span-6 bg-white border border-gray-200 rounded-2xl p-8 space-y-6 shadow-sm">
                <div>
                    <span class="text-[11px] uppercase tracking-[0.25em] text-amber-800 font-bold">LABORATORY BENCHMARKS</span>
                    <h3 class="font-serif text-2xl text-gray-900 mt-1 font-normal">Extrait Performance Metrics</h3>
                </div>

                <!-- Longevity Meter -->
                <div class="space-y-2">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-gray-700 uppercase tracking-wider">Longevity on Skin & Fabric:</span>
                        <span class="text-amber-800 font-bold">{{ $product->longevity_rating ?? 9 }}/10 (16-18 Hours)</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-amber-600 h-full rounded-full" style="width: {{ ($product->longevity_rating ?? 9) * 10 }}%;"></div>
                    </div>
                </div>

                <!-- Sillage Meter -->
                <div class="space-y-2">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-gray-700 uppercase tracking-wider">Sillage & Aura Projection:</span>
                        <span class="text-amber-800 font-bold">{{ $product->sillage_rating ?? 9 }}/10 (Room-Filling)</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-amber-600 h-full rounded-full" style="width: {{ ($product->sillage_rating ?? 9) * 10 }}%;"></div>
                    </div>
                </div>

                <!-- Maceration Time -->
                <div class="space-y-2">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-gray-700 uppercase tracking-wider">Cold-Maceration Period:</span>
                        <span class="text-amber-800 font-bold">{{ $product->maceration_weeks ?? 12 }} Weeks Artisanal</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-amber-600 h-full rounded-full" style="width: 95%;"></div>
                    </div>
                </div>

                <!-- Oil Concentration Badge -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-600">
                    <div>
                        <span class="text-[10px] uppercase tracking-wider text-amber-800 block font-bold">Fragrance Concentration</span>
                        <span class="font-serif text-lg text-gray-900 font-bold">{{ $product->oil_concentration_percent ?? 38 }}% Pure Compounds</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] uppercase tracking-wider text-amber-800 block font-bold">Climate Optimization</span>
                        <span class="text-xs text-gray-700 font-medium">Pakistani Summers & Winters</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- PDP Tabs: Description, Ritual, Shipping, and Customer Reviews -->
<section class="py-16 bg-white border-b border-gray-200">
    <div class="container mx-auto px-4 lg:px-8 max-w-5xl" x-data="{ currentTab: 'desc' }">
        
        <!-- Tab Headers -->
        <div class="flex border-b border-gray-200 mb-8 overflow-x-auto no-scrollbar">
            <button 
                type="button" 
                @click="currentTab = 'desc'" 
                :class="currentTab === 'desc' ? 'border-amber-700 text-amber-900 font-bold bg-amber-50/50' : 'border-transparent text-gray-500 hover:text-gray-900'"
                class="px-6 py-3 text-xs uppercase tracking-[0.18em] border-b-2 transition-all duration-200 whitespace-nowrap"
            >
                The Impression Story
            </button>

            <button 
                type="button" 
                @click="currentTab = 'usage'" 
                :class="currentTab === 'usage' ? 'border-amber-700 text-amber-900 font-bold bg-amber-50/50' : 'border-transparent text-gray-500 hover:text-gray-900'"
                class="px-6 py-3 text-xs uppercase tracking-[0.18em] border-b-2 transition-all duration-200 whitespace-nowrap"
            >
                Application Ritual
            </button>

            <button 
                type="button" 
                @click="currentTab = 'shipping'" 
                :class="currentTab === 'shipping' ? 'border-amber-700 text-amber-900 font-bold bg-amber-50/50' : 'border-transparent text-gray-500 hover:text-gray-900'"
                class="px-6 py-3 text-xs uppercase tracking-[0.18em] border-b-2 transition-all duration-200 whitespace-nowrap"
            >
                Shipping & Exchange Policy
            </button>

            <button 
                type="button" 
                @click="currentTab = 'reviews'" 
                :class="currentTab === 'reviews' ? 'border-amber-700 text-amber-900 font-bold bg-amber-50/50' : 'border-transparent text-gray-500 hover:text-gray-900'"
                class="px-6 py-3 text-xs uppercase tracking-[0.18em] border-b-2 transition-all duration-200 whitespace-nowrap"
            >
                Patron Reviews ({{ $product->reviews_count }})
            </button>
        </div>

        <!-- Tab 1: Description -->
        <div x-show="currentTab === 'desc'" class="space-y-4 text-sm md:text-base text-gray-700 leading-relaxed font-light">
            <p>{{ $product->description }}</p>
            <p>Formulated with French grade aroma compounds and macerated for 90 days. Every bottle is hand-poured in Lahore, Pakistan to ensure maximum sillage and longevity.</p>
        </div>

        <!-- Tab 2: Application Ritual -->
        <div x-show="currentTab === 'usage'" class="space-y-4 text-sm md:text-base text-gray-700 leading-relaxed font-light" style="display: none;">
            <h4 class="font-serif text-lg text-gray-900 font-semibold">Mastering the Sillage of Extrait de Parfum</h4>
            <ul class="list-disc pl-5 space-y-2 text-sm text-gray-600">
                <li><strong>Pulse Points:</strong> Apply 2 to 3 sprays directly on pulse points — the sides of your neck, behind the ears, and inside wrists.</li>
                <li><strong>Fabric Longevity:</strong> Spray lightly on linen, wool, or cotton garments. Extrait compounds hold onto natural fibers for up to 48 hours.</li>
                <li><strong>Never Rub:</strong> Allow the formulation to naturally settle on skin without friction, ensuring top notes blossom gracefully.</li>
            </ul>
        </div>

        <!-- Tab 3: Shipping & Exchange -->
        <div x-show="currentTab === 'shipping'" class="space-y-4 text-sm md:text-base text-gray-700 leading-relaxed font-light" style="display: none;">
            <h4 class="font-serif text-lg text-gray-900 font-semibold">Nationwide Pakistan Delivery Guarantee</h4>
            <p>All flacons are encased in impact-resistant cushioned packaging and dispatched through premium courier services (TCS, Leopards, PostEx).</p>
            <ul class="list-disc pl-5 space-y-2 text-sm text-gray-600">
                <li><strong>Major Hubs:</strong> Lahore, Karachi, Islamabad, Rawalpindi, Faisalabad — 24 to 48 hours.</li>
                <li><strong>Other Cities:</strong> 2 to 4 business days.</li>
                <li><strong>Hassle-Free Exchange:</strong> If you feel the scent does not suit your aura, contact our WhatsApp Concierge within 7 days for an exchange.</li>
            </ul>
        </div>

        <!-- Tab 4: Reviews -->
        <div x-show="currentTab === 'reviews'" class="space-y-8" style="display: none;">
            <!-- Submit Review Form -->
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-xl space-y-4">
                <h4 class="font-serif text-lg text-gray-900 font-semibold">Share Your Olfactory Impression</h4>
                <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-gray-700 mb-1 font-bold">Your Name *</label>
                            <input type="text" name="customer_name" required placeholder="e.g. Tariq Mehmood" class="w-full bg-white border border-gray-300 rounded px-3 py-2 text-xs text-gray-900 focus:outline-none focus:border-amber-600">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-gray-700 mb-1 font-bold">Your City in Pakistan *</label>
                            <input type="text" name="customer_city" required placeholder="e.g. Lahore / Karachi" class="w-full bg-white border border-gray-300 rounded px-3 py-2 text-xs text-gray-900 focus:outline-none focus:border-amber-600">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-gray-700 mb-1 font-bold">Rating *</label>
                            <select name="rating" required class="w-full bg-white border border-gray-300 rounded px-3 py-2 text-xs text-gray-900 focus:outline-none focus:border-amber-600">
                                <option value="5">5 Stars - Imperial Masterpiece</option>
                                <option value="4">4 Stars - Highly Refined</option>
                                <option value="3">3 Stars - Pleasant Formulation</option>
                                <option value="2">2 Stars - Average</option>
                                <option value="1">1 Star - Disappointed</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-gray-700 mb-1 font-bold">Review Title</label>
                        <input type="text" name="title" placeholder="e.g. Monumental sillage at an evening wedding" class="w-full bg-white border border-gray-300 rounded px-3 py-2 text-xs text-gray-900 focus:outline-none focus:border-amber-600">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-gray-700 mb-1 font-bold">Your Review *</label>
                        <textarea name="comment" required rows="3" placeholder="Share your experience regarding projection, longevity, and compliments received..." class="w-full bg-white border border-gray-300 rounded px-3 py-2 text-xs text-gray-900 focus:outline-none focus:border-amber-600"></textarea>
                    </div>
                    <button type="submit" class="btn-gold py-2.5 px-6 text-xs uppercase tracking-widest">
                        Submit Verified Review
                    </button>
                </form>
            </div>

            <!-- Existing Reviews List -->
            <div class="space-y-4">
                @forelse($product->reviews as $review)
                    <div class="p-5 bg-white border border-gray-200 rounded-xl space-y-2 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-900 text-xs font-bold">
                                    {{ substr($review->user_name ?? 'P', 0, 1) }}
                                </div>
                                <div>
                                    <span class="font-serif text-sm text-gray-900 font-semibold">{{ $review->user_name }}</span>
                                    <span class="text-[10px] text-emerald-700 ml-2"><i class="fas fa-check-circle"></i> Verified &bull; {{ $review->user_city ?? 'Pakistan' }}</span>
                                </div>
                            </div>
                            <div class="flex text-amber-500 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-gray-200' }}"></i>
                                @endfor
                            </div>
                        </div>
                        @if($review->review_title)
                            <h5 class="text-xs font-semibold text-gray-900">{{ $review->review_title }}</h5>
                        @endif
                        <p class="text-xs text-gray-600 leading-relaxed font-light">
                            "{{ $review->comment }}"
                        </p>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 italic text-center py-6">Be the first connoisseur to review this masterpiece.</p>
                @endforelse
            </div>
        </div>

    </div>
</section>

<!-- Related Pairings Carousel / You May Also Like -->
@if($relatedProducts->count() > 0)
    <section class="py-16 bg-gray-50 border-b border-gray-200">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-10">
                <span class="text-[11px] uppercase tracking-[0.25em] text-amber-800 font-bold">OLFACTORY HARMONY</span>
                <h3 class="font-serif text-2xl md:text-3xl text-gray-900 mt-1 font-normal">You May Also Covet</h3>
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
<div class="fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t border-gray-200 p-3 lg:hidden flex items-center justify-between shadow-2xl">
    <div>
        <div class="text-xs font-serif text-gray-900 truncate max-w-[150px] font-semibold">{{ $product->name }}</div>
        <div class="text-xs font-bold text-gray-900" x-text="formattedPrice"></div>
    </div>
    <div class="flex items-center space-x-2">
        <a :href="whatsappUrl" target="_blank" class="btn-whatsapp py-2 px-3 text-[11px]">
            <i class="fab fa-whatsapp"></i>
        </a>
        <button 
            type="button" 
            @click="addToCart()"
            class="btn-gold py-2 px-4 text-[11px] tracking-wider uppercase font-bold"
        >
            ADD TO BAG
        </button>
    </div>
</div>

</div>

@endsection
