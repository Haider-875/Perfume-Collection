@extends('layouts.app')

@section('title', $product->name . ($product->impression_of ? ' (Our Impression of ' . $product->impression_of . ')' : '') . ' | Perfumes Collection Pakistan')
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
<section class="py-3 border-bottom border-gold-20" style="background-color: #050203;">
    <div class="container px-3 px-lg-4">
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'All Impressions', 'url' => route('collections.show', 'all')],
            ['label' => $product->category->name ?? 'Extrait', 'url' => route('collections.show', $product->category->slug ?? 'all')],
            ['label' => $product->name]
        ]" />
    </div>
</section>

<!-- PDP Master Showcase -->
<section class="py-5 border-bottom border-gold-20 text-light-parchment" style="background-color: #080204;">
    <div class="container px-3 px-lg-4">
        <div class="row g-4 g-lg-5 align-items-start">
            
            <!-- Left Column: Large Interactive Gallery (lg:col-6) -->
            <div class="col-12 col-lg-6 d-flex flex-column gap-3">
                <!-- Main Flacon Display with Hover Zoom -->
                <div class="position-relative bg-wine-dark border border-gold-30 rounded-4 p-4 p-sm-5 text-center shadow-2xl overflow-hidden">
                    @if($product->is_bestseller)
                        <span class="position-absolute top-0 start-0 m-3 bg-wine-accent text-gold-soft border border-gold-40 px-3 py-1 rounded shadow z-1 text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.1em;">
                            BESTSELLER
                        </span>
                    @elseif($product->is_new_arrival)
                        <span class="position-absolute top-0 start-0 m-3 text-success-emphasis border border-success-subtle px-3 py-1 rounded shadow z-1 text-uppercase fw-bold" style="background: linear-gradient(to right, #1b3d22, #0d2212); font-size: 10px; letter-spacing: 0.1em;">
                            NEW ARRIVAL
                        </span>
                    @endif

                    <div class="position-relative d-flex align-items-center justify-content-center" style="height: 380px;">
                        <img 
                            id="pdpMasterImage" 
                            src="{{ $product->primary_image_url }}" 
                            alt="{{ $product->name }}" 
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';" 
                            class="img-fluid mh-100 object-contain drop-shadow transition"
                            style="max-height: 360px;"
                        >
                    </div>

                    <div class="text-muted-parchment text-uppercase mt-3" style="font-size: 11px; letter-spacing: 0.05em;">
                        <i class="fas fa-certificate text-gold me-1"></i> 35%–40% Extrait Concentration &bull; High Luxury Glass Flacon
                    </div>
                </div>

                <!-- Thumbnail Selector Row -->
                @if($product->images->count() > 1)
                    <div class="d-flex align-items-center justify-content-center gap-2 overflow-x-auto py-2">
                        @foreach($product->images as $img)
                            <button 
                                type="button" 
                                onclick="document.getElementById('pdpMasterImage').src='{{ asset($img->image_path) }}'; document.querySelectorAll('.pdp-thumb-btn').forEach(b => { b.classList.remove('border-gold'); b.classList.add('border-gold-20'); }); this.classList.remove('border-gold-20'); this.classList.add('border-gold');"
                                class="pdp-thumb-btn rounded-3 border {{ $loop->first ? 'border-gold' : 'border-gold-20' }} bg-wine-card p-1 transition d-flex align-items-center justify-content-center"
                                style="width: 64px; height: 64px;"
                            >
                                <img src="{{ asset($img->image_path) }}" alt="{{ $img->alt_text }}" onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';" class="img-fluid mh-100 object-contain">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Column: Sticky Purchase Engine & Olfactory Spec (lg:col-6) -->
            <div class="col-12 col-lg-6 d-flex flex-column gap-4 sticky-lg-top" style="top: 112px;">
                <!-- Impression Badge (Key Rawaha Feature) -->
                @if($product->impression_of)
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1-5 rounded-pill text-xs fw-semibold text-gold-soft border border-gold-40 shadow-sm align-self-start" style="background-color: rgba(59, 7, 17, 0.7);">
                        <i class="fas fa-crown text-gold text-xs"></i>
                        <span>Our Impression of: <strong class="text-white text-decoration-underline" style="text-decoration-color: #d6aa62 !important;">{{ $product->impression_of }}</strong></span>
                    </div>
                @endif

                <!-- Concentration & Family Badges -->
                <div class="d-flex align-items-center gap-3 text-xs">
                    <span class="text-uppercase tracking-widest text-gold fw-semibold bg-wine-accent border border-gold-30 px-2 py-1 rounded" style="font-size: 11px;">
                        {{ $product->concentration ?? 'EXTRAIT DE PARFUM' }}
                    </span>
                    <span class="text-muted-parchment">
                        {{ $product->fragranceFamily->name ?? 'Royal Oriental' }} &bull; {{ ucfirst($product->gender) }}
                    </span>
                </div>

                <!-- Product Title & Tagline -->
                <div>
                    <h1 class="font-serif text-light-parchment display-5 fw-normal mb-1 lh-sm">
                        {{ $product->name }}
                    </h1>
                    @if($product->tagline)
                        <p class="font-serif text-gold-soft fst-italic mt-1 fw-light" style="font-size: 1.05rem;">
                            "{{ $product->tagline }}"
                        </p>
                    @endif
                </div>

                <!-- Rating & Reviews Summary -->
                <div class="d-flex align-items-center gap-3 text-xs border-top border-bottom border-gold-20 py-3">
                    <div class="d-flex text-gold">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round($product->rating_avg) ? '' : 'opacity-25' }}"></i>
                        @endfor
                    </div>
                    <span class="text-light-parchment fw-bold">{{ number_format($product->rating_avg, 1) }} / 5.0</span>
                    <span class="text-muted-parchment">({{ $product->reviews_count }} Verified Patron Reviews)</span>
                </div>

                <!-- Dynamic Pricing & Savings in PKR -->
                <div class="d-flex flex-column gap-1">
                    <div class="d-flex align-items-baseline gap-3">
                        <span class="font-serif display-6 text-gold-soft fw-bold" x-text="formattedPrice">
                            {{ $product->formatted_effective_price }}
                        </span>
                        <span class="text-sm text-decoration-line-through text-muted-parchment" x-text="formattedComparePrice"></span>
                        <template x-if="savingsPercent > 0">
                            <span class="bg-wine-accent text-gold-soft text-xs text-uppercase tracking-wider px-2 py-0-5 rounded fw-bold border border-gold-40">
                                SAVE <span x-text="savingsPercent"></span>%
                            </span>
                        </template>
                    </div>
                    <div class="text-muted-parchment d-flex align-items-center gap-2 pt-1" style="font-size: 11px;">
                        <i class="fas fa-truck-fast text-gold"></i>
                        <span>Includes Free TCS Express Air shipping across Pakistan (Orders over Rs. 3,500)</span>
                    </div>
                </div>

                <!-- Flacon Size (ml) Selector (Reactive Alpine) -->
                <div class="d-flex flex-column gap-2 pt-1">
                    <label class="d-block text-xs text-uppercase tracking-widest text-gold fw-semibold">
                        Select Flacon Volume: <span class="text-gold-soft" x-text="selectedLabel"></span>
                    </label>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($product->variants as $variant)
                            <button 
                                type="button" 
                                @click="selectedVariantId = {{ $variant->id }}; selectedPrice = {{ $variant->price }}; selectedComparePrice = {{ $variant->compare_at_price ?? 0 }}; selectedLabel = '{{ $variant->size_label }}';"
                                :class="selectedVariantId === {{ $variant->id }} ? 'border-gold bg-wine-accent text-gold-soft shadow' : 'border-gold-20 bg-wine-dark text-muted-parchment'"
                                class="px-3 py-2 rounded-3 border text-xs text-uppercase tracking-wider fw-semibold transition d-flex align-items-center gap-2"
                            >
                                <span>{{ $variant->size_label }}</span>
                                <span class="text-muted-parchment">&bull;</span>
                                <span class="fw-bold text-light-parchment">Rs. {{ number_format($variant->price) }}</span>
                            </button>
                        @empty
                            <button type="button" class="px-4 py-2 rounded-3 border border-gold bg-wine-accent text-gold-soft text-xs text-uppercase tracking-wider fw-semibold">
                                {{ $product->volume_ml }}ml Extrait Flacon
                            </button>
                        @endforelse
                    </div>
                </div>

                <!-- Quantity & Add to Cart Engine -->
                <div class="d-flex flex-column gap-3 pt-2">
                    <div class="d-flex align-items-center gap-3">
                        <!-- Quantity Counter -->
                        <div class="d-flex align-items-center border border-gold-30 bg-wine-dark rounded-3">
                            <button type="button" @click="if(quantity > 1) quantity--" class="btn text-muted-parchment text-gold-hover px-3 py-2 fw-bold text-sm">&minus;</button>
                            <input type="number" x-model="quantity" min="1" max="10" class="border-0 bg-transparent text-center text-light-parchment fw-bold text-xs" style="width: 48px;" readonly>
                            <button type="button" @click="if(quantity < 10) quantity++" class="btn text-muted-parchment text-gold-hover px-3 py-2 fw-bold text-sm">&plus;</button>
                        </div>

                        <!-- Add to Cart CTA -->
                        <button 
                            type="button" 
                            @click="addToCart()"
                            class="flex-grow-1 btn-gold py-3 text-xs tracking-widest text-uppercase d-flex align-items-center justify-content-center gap-2 rounded-3 shadow"
                        >
                            <i class="fas fa-shopping-bag"></i>
                            <span>ADD TO FRAGRANCE BAG</span>
                        </button>
                    </div>

                    <!-- Direct WhatsApp 1-Click Order -->
                    <a 
                        :href="whatsappUrl" 
                        target="_blank" 
                        class="w-100 btn-whatsapp py-3 text-xs tracking-widest text-uppercase d-flex align-items-center justify-content-center gap-2 text-decoration-none rounded-3"
                    >
                        <i class="fab fa-whatsapp fs-6"></i>
                        <span>1-CLICK ORDER ON WHATSAPP (COD)</span>
                    </a>
                </div>

                <!-- Pakistan Express Delivery & Logistics Estimator -->
                <div class="p-3 bg-wine-card border border-gold-25 rounded-3 d-flex flex-column gap-2 text-xs">
                    <div class="d-flex align-items-center justify-content-between text-light-parchment fw-bold">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fas fa-location-dot text-gold"></i>
                            <span>Pakistan Dispatch Time:</span>
                        </span>
                        <span class="text-success"><i class="fas fa-circle-check"></i> In Stock &bull; Lahore Atelier</span>
                    </div>
                    <p class="text-muted-parchment lh-base mb-0">
                        Orders placed today arrive in <strong>Lahore, Karachi, Islamabad & Rawalpindi</strong> in 24–48 hours via TCS Express Air. Cash on Delivery accepted nationwide.
                    </p>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- PDP Olfactory Pyramid & Performance Benchmark Meters -->
<section class="py-5 border-bottom border-gold-20" style="background-color: #080204;">
    <div class="container px-3 px-lg-4">
        <div class="row g-4 g-lg-5 align-items-center">
            
            <!-- Left: Olfactory Pyramid (lg:col-6) -->
            <div class="col-12 col-lg-6 d-flex flex-column gap-3">
                <div class="text-start mb-2">
                    <span class="text-gold fw-semibold" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">HARMONIC ARCHITECTURE</span>
                    <h2 class="font-serif fs-3 text-light-parchment mt-1 fw-normal">The Fragrance Notes Pyramid</h2>
                    <p class="text-xs text-muted-parchment mt-1 mb-0">Evolution of accords on skin over 16+ hours</p>
                </div>

                <!-- Pyramid Tier 1: Top Notes -->
                <div class="p-4 bg-wine-card border border-gold-25 rounded-3 d-flex flex-column gap-2 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-xs text-uppercase tracking-widest text-gold fw-bold d-flex align-items-center gap-2">
                            <i class="fas fa-sparkles text-gold"></i>
                            <span>Top Notes (First 15 - 45 Minutes)</span>
                        </span>
                        <span class="text-muted-parchment text-uppercase fw-semibold" style="font-size: 10px;">Opening Spark</span>
                    </div>
                    <p class="text-light-parchment font-serif mb-0" style="font-size: 0.95rem;">
                        {{ $product->fragrance_notes_pyramid['top'] ?? ($product->top_notes_summary ?? 'Fresh Bergamot, Kashmiri Saffron, Pink Pepper') }}
                    </p>
                </div>

                <!-- Pyramid Tier 2: Heart Notes -->
                <div class="p-4 bg-wine-card border border-gold-25 rounded-3 d-flex flex-column gap-2 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-xs text-uppercase tracking-widest text-gold fw-bold d-flex align-items-center gap-2">
                            <i class="fas fa-heart text-gold"></i>
                            <span>Heart Notes (2 - 6 Hours)</span>
                        </span>
                        <span class="text-muted-parchment text-uppercase fw-semibold" style="font-size: 10px;">Sensual Heart</span>
                    </div>
                    <p class="text-light-parchment font-serif mb-0" style="font-size: 0.95rem;">
                        {{ $product->fragrance_notes_pyramid['heart'] ?? ($product->heart_notes_summary ?? 'Imperial Taif Rose, Smokey Frankincense, Leather Accords') }}
                    </p>
                </div>

                <!-- Pyramid Tier 3: Base Notes -->
                <div class="p-4 bg-wine-card border border-gold-25 rounded-3 d-flex flex-column gap-2 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-xs text-uppercase tracking-widest text-gold fw-bold d-flex align-items-center gap-2">
                            <i class="fas fa-tree text-gold"></i>
                            <span>Base Notes (6 - 18+ Hours)</span>
                        </span>
                        <span class="text-gold text-uppercase fw-bold" style="font-size: 10px;">14+ Hours Longevity</span>
                    </div>
                    <p class="text-light-parchment font-serif mb-0" style="font-size: 0.95rem;">
                        {{ $product->fragrance_notes_pyramid['base'] ?? ($product->base_notes_summary ?? 'Aged Cambodian Dehn al Oud, Warm Ambergris, Royal Sandalwood') }}
                    </p>
                </div>
            </div>

            <!-- Right: Performance Benchmark Meters (lg:col-6) -->
            <div class="col-12 col-lg-6 bg-wine-card border border-gold-25 rounded-4 p-4 p-lg-5 d-flex flex-column gap-4 shadow-sm">
                <div>
                    <span class="text-gold fw-semibold" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">LABORATORY BENCHMARKS</span>
                    <h3 class="font-serif fs-4 text-light-parchment mt-1 fw-normal mb-0">Extrait Performance Metrics</h3>
                </div>

                <!-- Longevity Meter -->
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between text-xs fw-semibold">
                        <span class="text-light-parchment text-uppercase tracking-wider">Longevity on Skin & Fabric:</span>
                        <span class="text-gold fw-bold">{{ $product->longevity_rating ?? 9 }}/10 (16-18 Hours)</span>
                    </div>
                    <div class="w-100 bg-wine-dark rounded-pill overflow-hidden border border-gold-20" style="height: 10px;">
                        <div class="h-100 rounded-pill" style="background: linear-gradient(to right, #d6aa62, #f0d59d); width: {{ ($product->longevity_rating ?? 9) * 10 }}%;"></div>
                    </div>
                </div>

                <!-- Sillage Meter -->
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between text-xs fw-semibold">
                        <span class="text-light-parchment text-uppercase tracking-wider">Sillage & Aura Projection:</span>
                        <span class="text-gold fw-bold">{{ $product->sillage_rating ?? 9 }}/10 (Room-Filling)</span>
                    </div>
                    <div class="w-100 bg-wine-dark rounded-pill overflow-hidden border border-gold-20" style="height: 10px;">
                        <div class="h-100 rounded-pill" style="background: linear-gradient(to right, #d6aa62, #f0d59d); width: {{ ($product->sillage_rating ?? 9) * 10 }}%;"></div>
                    </div>
                </div>

                <!-- Maceration Time -->
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between text-xs fw-semibold">
                        <span class="text-light-parchment text-uppercase tracking-wider">Cold-Maceration Period:</span>
                        <span class="text-gold fw-bold">{{ $product->maceration_weeks ?? 12 }} Weeks Artisanal</span>
                    </div>
                    <div class="w-100 bg-wine-dark rounded-pill overflow-hidden border border-gold-20" style="height: 10px;">
                        <div class="h-100 rounded-pill" style="background: linear-gradient(to right, #d6aa62, #f0d59d); width: 95%;"></div>
                    </div>
                </div>

                <!-- Oil Concentration Badge -->
                <div class="pt-3 border-top border-gold-20 d-flex align-items-center justify-content-between text-xs text-muted-parchment">
                    <div>
                        <span class="d-block text-gold fw-bold text-uppercase tracking-wider" style="font-size: 10px;">Fragrance Concentration</span>
                        <span class="font-serif fs-5 text-light-parchment fw-bold">{{ $product->oil_concentration_percent ?? 38 }}% Pure Compounds</span>
                    </div>
                    <div class="text-end">
                        <span class="d-block text-gold fw-bold text-uppercase tracking-wider" style="font-size: 10px;">Climate Optimization</span>
                        <span class="text-xs text-light-parchment fw-medium">Pakistani Summers & Winters</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- PDP Tabs: Description, Ritual, Shipping, and Customer Reviews -->
<section class="py-5 border-bottom border-gold-20" style="background-color: #050203;">
    <div class="container px-3 px-lg-4" style="max-width: 960px;" x-data="{ currentTab: 'desc' }">
        
        <!-- Tab Headers -->
        <div class="d-flex border-bottom border-gold-25 mb-4 overflow-x-auto no-scrollbar">
            <button 
                type="button" 
                @click="currentTab = 'desc'" 
                :class="currentTab === 'desc' ? 'border-gold text-gold fw-bold' : 'border-transparent text-muted-parchment text-light-parchment-hover'"
                class="btn text-xs text-uppercase tracking-luxury border-bottom border-2 rounded-0 px-4 py-3 text-nowrap"
                style="background: none;"
            >
                The Impression Story
            </button>

            <button 
                type="button" 
                @click="currentTab = 'usage'" 
                :class="currentTab === 'usage' ? 'border-gold text-gold fw-bold' : 'border-transparent text-muted-parchment text-light-parchment-hover'"
                class="btn text-xs text-uppercase tracking-luxury border-bottom border-2 rounded-0 px-4 py-3 text-nowrap"
                style="background: none;"
            >
                Application Ritual
            </button>

            <button 
                type="button" 
                @click="currentTab = 'shipping'" 
                :class="currentTab === 'shipping' ? 'border-gold text-gold fw-bold' : 'border-transparent text-muted-parchment text-light-parchment-hover'"
                class="btn text-xs text-uppercase tracking-luxury border-bottom border-2 rounded-0 px-4 py-3 text-nowrap"
                style="background: none;"
            >
                Shipping & Exchange Policy
            </button>

            <button 
                type="button" 
                @click="currentTab = 'reviews'" 
                :class="currentTab === 'reviews' ? 'border-gold text-gold fw-bold' : 'border-transparent text-muted-parchment text-light-parchment-hover'"
                class="btn text-xs text-uppercase tracking-luxury border-bottom border-2 rounded-0 px-4 py-3 text-nowrap"
                style="background: none;"
            >
                Patron Reviews ({{ $product->reviews_count }})
            </button>
        </div>

        <!-- Tab 1: Description -->
        <div x-show="currentTab === 'desc'" class="d-flex flex-column gap-3 text-light-parchment lh-base fw-light" style="font-size: 1rem;">
            <p class="mb-0">{{ $product->description }}</p>
            <p class="text-muted-parchment mb-0">Formulated with French grade aroma compounds and macerated for 90 days. Every bottle is hand-poured in Lahore, Pakistan to ensure maximum sillage and longevity.</p>
        </div>

        <!-- Tab 2: Application Ritual -->
        <div x-show="currentTab === 'usage'" class="d-flex flex-column gap-3 text-light-parchment lh-base fw-light" style="display: none; font-size: 1rem;">
            <h4 class="font-serif fs-5 text-gold fw-semibold mb-1">Mastering the Sillage of Extrait de Parfum</h4>
            <ul class="d-flex flex-column gap-2 text-muted-parchment ps-3 mb-0" style="font-size: 0.95rem;">
                <li><strong class="text-light-parchment">Pulse Points:</strong> Apply 2 to 3 sprays directly on pulse points — the sides of your neck, behind the ears, and inside wrists.</li>
                <li><strong class="text-light-parchment">Fabric Longevity:</strong> Spray lightly on linen, wool, or cotton garments. Extrait compounds hold onto natural fibers for up to 48 hours.</li>
                <li><strong class="text-light-parchment">Never Rub:</strong> Allow the formulation to naturally settle on skin without friction, ensuring top notes blossom gracefully.</li>
            </ul>
        </div>

        <!-- Tab 3: Shipping & Exchange -->
        <div x-show="currentTab === 'shipping'" class="d-flex flex-column gap-3 text-light-parchment lh-base fw-light" style="display: none; font-size: 1rem;">
            <h4 class="font-serif fs-5 text-gold fw-semibold mb-1">Nationwide Pakistan Delivery Guarantee</h4>
            <p class="text-muted-parchment mb-0">All flacons are encased in impact-resistant cushioned packaging and dispatched through premium courier services (TCS, Leopards, PostEx).</p>
            <ul class="d-flex flex-column gap-2 text-muted-parchment ps-3 mb-0" style="font-size: 0.95rem;">
                <li><strong class="text-light-parchment">Major Hubs:</strong> Lahore, Karachi, Islamabad, Rawalpindi, Faisalabad — 24 to 48 hours.</li>
                <li><strong class="text-light-parchment">Other Cities:</strong> 2 to 4 business days.</li>
                <li><strong class="text-light-parchment">Hassle-Free Exchange:</strong> If you feel the scent does not suit your aura, contact our WhatsApp Concierge within 7 days for an exchange.</li>
            </ul>
        </div>

        <!-- Tab 4: Reviews -->
        <div x-show="currentTab === 'reviews'" class="d-flex flex-column gap-4" style="display: none;">
            <!-- Submit Review Form -->
            <div class="p-4 bg-wine-card border border-gold-25 rounded-4 d-flex flex-column gap-3">
                <h4 class="font-serif fs-5 text-light-parchment fw-semibold mb-0">Share Your Olfactory Impression</h4>
                <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="d-flex flex-column gap-3">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label class="d-block text-xs text-uppercase tracking-wider text-gold mb-1 fw-bold">Your Name *</label>
                            <input type="text" name="customer_name" required placeholder="e.g. Tariq Mehmood" class="form-control form-control-luxury text-xs py-2 px-3">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="d-block text-xs text-uppercase tracking-wider text-gold mb-1 fw-bold">Your City in Pakistan *</label>
                            <input type="text" name="customer_city" required placeholder="e.g. Lahore / Karachi" class="form-control form-control-luxury text-xs py-2 px-3">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="d-block text-xs text-uppercase tracking-wider text-gold mb-1 fw-bold">Rating *</label>
                            <select name="rating" required class="form-select form-control-luxury text-xs py-2 px-3">
                                <option value="5" class="bg-wine-dark text-light-parchment">5 Stars - Imperial Masterpiece</option>
                                <option value="4" class="bg-wine-dark text-light-parchment">4 Stars - Highly Refined</option>
                                <option value="3" class="bg-wine-dark text-light-parchment">3 Stars - Pleasant Formulation</option>
                                <option value="2" class="bg-wine-dark text-light-parchment">2 Stars - Average</option>
                                <option value="1" class="bg-wine-dark text-light-parchment">1 Star - Disappointed</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="d-block text-xs text-uppercase tracking-wider text-gold mb-1 fw-bold">Review Title</label>
                        <input type="text" name="title" placeholder="e.g. Monumental sillage at an evening wedding" class="form-control form-control-luxury text-xs py-2 px-3">
                    </div>
                    <div>
                        <label class="d-block text-xs text-uppercase tracking-wider text-gold mb-1 fw-bold">Your Review *</label>
                        <textarea name="comment" required rows="3" placeholder="Share your experience regarding projection, longevity, and compliments received..." class="form-control form-control-luxury text-xs py-2 px-3"></textarea>
                    </div>
                    <button type="submit" class="btn-gold py-2 px-4 text-xs text-uppercase tracking-widest align-self-start">
                        Submit Verified Review
                    </button>
                </form>
            </div>

            <!-- Existing Reviews List -->
            <div class="d-flex flex-column gap-3">
                @forelse($product->reviews as $review)
                    <div class="p-4 bg-wine-card border border-gold-20 rounded-3 d-flex flex-column gap-2 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-wine-accent border border-gold-40 d-flex align-items-center justify-content-center text-gold text-xs fw-bold" style="width: 32px; height: 32px;">
                                    {{ substr($review->user_name ?? 'P', 0, 1) }}
                                </div>
                                <div>
                                    <span class="font-serif text-light-parchment fw-semibold" style="font-size: 0.95rem;">{{ $review->user_name }}</span>
                                    <span class="text-success ms-2" style="font-size: 10px;"><i class="fas fa-check-circle"></i> Verified &bull; {{ $review->user_city ?? 'Pakistan' }}</span>
                                </div>
                            </div>
                            <div class="d-flex text-gold text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? '' : 'opacity-25' }}"></i>
                                @endfor
                            </div>
                        </div>
                        @if($review->review_title)
                            <h5 class="text-xs fw-semibold text-light-parchment mb-0">{{ $review->review_title }}</h5>
                        @endif
                        <p class="text-xs text-muted-parchment lh-base font-light mb-0">
                            "{{ $review->comment }}"
                        </p>
                    </div>
                @empty
                    <p class="text-xs text-muted-parchment fst-italic text-center py-4 mb-0">Be the first connoisseur to review this masterpiece.</p>
                @endforelse
            </div>
        </div>

    </div>
</section>

<!-- Related Pairings Carousel / You May Also Like -->
@if($relatedProducts->count() > 0)
    <section class="py-5 border-bottom border-gold-20" style="background-color: #080204;">
        <div class="container px-3 px-lg-4">
            <div class="text-center mx-auto mb-4" style="max-width: 560px;">
                <span class="text-gold fw-semibold" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">OLFACTORY HARMONY</span>
                <h3 class="font-serif fs-3 text-light-parchment mt-1 fw-normal mb-0">You May Also Covet</h3>
            </div>

            <div class="row row-cols-2 row-cols-md-4 g-3 g-md-4">
                @foreach($relatedProducts as $rel)
                    <div class="col">
                        <x-product-card :product="$rel" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- Mobile Sticky Add-to-Cart Bottom Bar -->
<div class="position-fixed bottom-0 start-0 end-0 p-3 d-lg-none d-flex align-items-center justify-content-between shadow-2xl border-top border-gold-30" style="z-index: 1040; background-color: rgba(8, 2, 4, 0.95); backdrop-filter: blur(12px);">
    <div>
        <div class="text-xs font-serif text-light-parchment text-truncate fw-semibold" style="max-width: 150px;">{{ $product->name }}</div>
        <div class="text-xs fw-bold text-gold" x-text="formattedPrice"></div>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a :href="whatsappUrl" target="_blank" class="btn-whatsapp py-2 px-3 text-decoration-none" style="font-size: 11px;">
            <i class="fab fa-whatsapp"></i>
        </a>
        <button 
            type="button" 
            @click="addToCart()"
            class="btn-gold py-2 px-3 text-uppercase tracking-wider fw-bold"
            style="font-size: 11px;"
        >
            ADD TO BAG
        </button>
    </div>
</div>

</div>

@endsection
