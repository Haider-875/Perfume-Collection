@extends('layouts.app')

@section('title', $product->name . ($product->impression_of ? ' (Our Impression of ' . $product->impression_of . ')' : '') . ' | Perfumes Collection Pakistan')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($product->story ?? $product->description), 160))

@section('content')

<div class="pb-5 pb-lg-0" x-data="{
    selectedVariantId: {{ $product->variants->first()?->id ?? 'null' }},
    selectedPrice: {{ $product->variants->first()?->price ?? $product->price }},
    selectedComparePrice: {{ $product->variants->first()?->compare_at_price ?? ($product->compare_at_price ?? round($product->price * 1.35, -1)) }},
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
    },
    buyNow() {
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ product_id: {{ $product->id }}, quantity: this.quantity, variant_id: this.selectedVariantId })
        })
        .then(res => res.json())
        .then(() => {
            window.location.href = '{{ route('checkout.index') }}';
        })
        .catch(() => {
            window.location.href = '{{ route('checkout.index') }}';
        });
    }
}">

    <!-- Master Product Showcase Section (Haute Parfumerie Layout with Room to Breathe) -->
    <section class="py-5 py-lg-6 border-bottom border-gold-20 text-light-parchment pdp-section">
        <div class="container px-3 px-lg-4" style="max-width: 1160px;">
            <div class="row gx-lg-5 gy-5 align-items-start justify-content-center">
                
                <!-- Left Column: Master Flacon Showcase & Trust Pillars (col-12 col-lg-5) -->
                <div class="col-12 col-md-6 col-lg-5 d-flex flex-column gap-3">
                    
                    <!-- Main Flacon Pedestal Stage (Scaled to Balanced Luxury Size) -->
                    <div class="pdp-flacon-stage w-100">
                        
                        <!-- Badges Header -->
                        <div class="position-absolute top-0 start-0 m-3 z-2 d-flex flex-column gap-1.5 font-sans">
                            @if($product->is_bestseller)
                                <span class="bg-wine-accent text-gold-soft border border-gold-40 px-2.5 py-1 rounded-pill shadow-sm text-uppercase fw-semibold" style="font-size: 9.5px; letter-spacing: 0.1em;">
                                    ★ BESTSELLER
                                </span>
                            @elseif($product->is_new_arrival)
                                <span class="bg-success text-white border border-success px-2.5 py-1 rounded-pill shadow-sm text-uppercase fw-semibold" style="font-size: 9.5px; letter-spacing: 0.1em;">
                                    NEW ARRIVAL
                                </span>
                            @endif

                            <template x-if="savingsPercent > 0">
                                <span class="bg-gradient-discount-badge text-white px-2.5 py-0.5 rounded-pill shadow-sm border border-gold-30 fw-bold" style="font-size: 9.5px; width: fit-content;">
                                    UP TO <span x-text="savingsPercent"></span>% OFF
                                </span>
                            </template>
                        </div>

                        <!-- 38% Extrait Badge on Right -->
                        <div class="position-absolute top-0 end-0 m-3 z-2 font-sans">
                            <span class="badge-extrait shadow-sm">
                                38% EXTRAIT
                            </span>
                        </div>

                        <!-- Product Bottle (Crisp, Perfectly Proportioned) -->
                        <div class="position-relative d-flex align-items-center justify-content-center my-2" style="min-height: 290px; width: 100%;">
                            <img 
                                id="pdpMasterImage" 
                                src="{{ $product->primary_image_url }}" 
                                alt="{{ $product->name }}" 
                                onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';" 
                                class="pdp-flacon-img"
                            >
                        </div>

                        <div class="text-gold-soft opacity-85 text-uppercase mt-2 font-sans" style="font-size: 10.5px; letter-spacing: 0.12em;">
                            <i class="fas fa-certificate text-gold me-1"></i> Formulated with Pure French Oils
                        </div>
                    </div>

                    <!-- Thumbnail Gallery Selector -->
                    @if($product->images->count() > 1)
                        <div class="d-flex align-items-center justify-content-center gap-2 overflow-x-auto py-1">
                            @foreach($product->images as $img)
                                <button 
                                    type="button" 
                                    onclick="document.getElementById('pdpMasterImage').src='{{ asset($img->image_path) }}'; document.querySelectorAll('.pdp-thumb-item').forEach(b => { b.classList.remove('active'); }); this.classList.add('active');"
                                    class="pdp-thumb-item {{ $loop->first ? 'active' : '' }}"
                                >
                                    <img src="{{ asset($img->image_path) }}" alt="{{ $img->alt_text }}" onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';" class="img-fluid mh-100 object-contain">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <!-- 4-Pillar Trust Highlights (Desktop only under gallery) -->
                    <div class="pdp-trust-grid font-sans d-none d-md-grid">
                        <div class="pdp-trust-card">
                            <i class="fas fa-droplet text-gold fs-5"></i>
                            <div>
                                <div class="fw-semibold text-ivory" style="font-size: 11px;">38% Extrait de Parfum</div>
                                <div class="text-muted-luxury" style="font-size: 9.5px;">Double French oil strength</div>
                            </div>
                        </div>
                        <div class="pdp-trust-card">
                            <i class="fas fa-hourglass-half text-gold fs-5"></i>
                            <div>
                                <div class="fw-semibold text-ivory" style="font-size: 11px;">14+ Hours Beast Mode</div>
                                <div class="text-muted-luxury" style="font-size: 9.5px;">Artisanal macerated sillage</div>
                            </div>
                        </div>
                        <div class="pdp-trust-card">
                            <i class="fas fa-truck-fast text-gold fs-5"></i>
                            <div>
                                <div class="fw-semibold text-ivory" style="font-size: 11px;">Fast Courier Service</div>
                                <div class="text-muted-luxury" style="font-size: 9.5px;">24–48h delivery Pakistan</div>
                            </div>
                        </div>
                        <div class="pdp-trust-card">
                            <i class="fas fa-rotate text-gold fs-5"></i>
                            <div>
                                <div class="fw-semibold text-ivory" style="font-size: 11px;">7-Day Scent Exchange</div>
                                <div class="text-muted-luxury" style="font-size: 9.5px;">100% satisfaction guarantee</div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Product Purchasing Engine (Spacious, Unboxed, Perfectly Aligned) -->
                <div class="col-12 col-md-6 col-lg-6 d-flex flex-column gap-4" style="max-width: 530px;">

                    <!-- Product Heading (Wasted Vindey Luxury Serif) & Subheading (Poppins Regular) -->
                    <div class="d-flex flex-column gap-1.5 text-start">
                        <h1 class="pdp-title gold-gradient-text text-start mb-0">
                            {{ $product->name }}
                        </h1>
                        @if($product->tagline)
                            <p class="font-sans text-gold-soft fst-italic fw-light mb-0 text-start" style="font-size: 0.95rem; opacity: 0.9;">
                                "{{ $product->tagline }}"
                            </p>
                        @endif
                    </div>

                    <!-- Star Rating & Review Count (Poppins Regular / Clean Unboxed Row) -->
                    <div class="d-flex flex-wrap align-items-center gap-2 gap-sm-3 text-xs border-top border-bottom border-gold-20 py-2.5 py-sm-3 my-1 font-sans">
                        <div class="d-inline-flex align-items-center text-gold text-nowrap" style="font-size: 11px; gap: 2px;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= round($product->rating_avg ?: 5) ? '' : 'opacity-25' }}"></i>
                            @endfor
                        </div>
                        <span class="text-ivory fw-semibold text-nowrap" style="white-space: nowrap;">{{ number_format($product->rating_avg ?: 4.9, 1) }} / 5.0</span>
                        <span class="text-muted-luxury text-nowrap" style="white-space: nowrap;">({{ $product->reviews_count ?: 48 }} Verified Patron Reviews)</span>
                    </div>

                    <!-- Pricing & Savings (Completely Unboxed, Clean & Elegant) -->
                    <div class="d-flex flex-column gap-1.5 font-sans text-start my-1">
                        <div class="d-flex align-items-center gap-3">
                            <span class="pdp-price-amount" style="color: #ffffff !important;" x-text="formattedPrice">
                                {{ $product->formatted_effective_price }}
                            </span>
                            <span class="text-sm text-decoration-line-through text-muted-luxury" x-text="formattedComparePrice"></span>
                            <template x-if="savingsPercent > 0">
                                <span class="badge-savings-luxury" style="font-size: 10px;">
                                     SAVE <span x-text="savingsPercent"></span>%
                                </span>
                            </template>
                        </div>
                        <div class="text-muted-luxury d-flex align-items-center gap-2 pt-1" style="font-size: 11.5px;">
                            <i class="fas fa-truck-fast text-gold"></i>
                            <span>Complimentary TCS Express Air Delivery on Orders Above Rs. 3,500</span>
                        </div>
                    </div>

                    <!-- Flacon Size Variant Selector (Clean 10ml, 50ml, 100ml with Soft Rounded Corners & Spacious Gap) -->
                    <div class="d-flex flex-column gap-2.5 font-sans text-start my-1">
                        <label class="d-block text-xs text-uppercase tracking-wider text-white fw-medium mb-1" style="color: #ffffff !important;">
                            SELECT BOTTLE SIZE
                        </label>
                        <div class="d-flex flex-wrap gap-2 gap-sm-3">
                            @forelse($product->variants as $variant)
                                @php
                                    $shortSize = preg_match('/^\d+\s*ml/i', $variant->size_label, $m) ? $m[0] : (explode(' ', $variant->size_label)[0] ?? $variant->size_label);
                                @endphp
                                <button 
                                    type="button" 
                                    @click="selectedVariantId = {{ $variant->id }}; selectedPrice = {{ $variant->price }}; selectedComparePrice = {{ $variant->compare_at_price ?? 0 }}; selectedLabel = '{{ $variant->size_label }}';"
                                    :class="selectedVariantId === {{ $variant->id }} ? 'active' : ''"
                                    class="pdp-size-btn"
                                >
                                    <span>{{ $shortSize }}</span>
                                </button>
                            @empty
                                <button type="button" class="pdp-size-btn active">
                                    <span>{{ $product->volume_ml }}ml</span>
                                </button>
                            @endforelse
                        </div>
                    </div>

                    <!-- Quantity Stepper & Primary Actions (User Reference Stadium Pill Buttons with Sliding Arrow) -->
                    <div class="d-flex flex-column gap-3 my-1">
                        
                        <!-- Row 1: Quantity Stepper + Add To Bag Stadium Pill Button -->
                        <div class="d-flex align-items-center gap-2 gap-sm-3">
                            
                            <!-- Custom Luxury Quantity Stepper -->
                            <div class="pdp-qty-stepper-box">
                                <button type="button" @click="if(quantity > 1) quantity--" class="pdp-qty-btn-luxury" aria-label="Decrease quantity">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="pdp-qty-display-luxury" x-text="quantity">1</span>
                                <button type="button" @click="if(quantity < 10) quantity++" class="pdp-qty-btn-luxury" aria-label="Increase quantity">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>

                            <!-- Primary Add To Bag Button (Stadium Pill with Sliding Arrow) -->
                            <button 
                                type="button" 
                                @click="addToCart()"
                                class="flex-grow-1 btn-pill-gold"
                                style="min-height: 48px;"
                            >
                                <span class="text-nowrap">ADD TO BAG</span>
                                <i class="fas fa-arrow-right-long btn-arrow"></i>
                            </button>
                        </div>

                        <!-- Row 2: BUY NOW (Direct Checkout Button with Black Background & Maroon Hover) -->
                        <button 
                            type="button" 
                            @click="buyNow()" 
                            class="w-100 btn-pill-buynow"
                            style="min-height: 48px; background-color: #000000; color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.25); border-radius: 9999px; font-family: 'Montserrat', sans-serif; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; font-size: 13px; display: flex; align-items: center; justify-content: center; gap: 10px; cursor: pointer; transition: all 0.3s ease; text-decoration: none;"
                            onmouseover="this.style.backgroundColor='#5A121C'; this.style.borderColor='#8C1D2D';"
                            onmouseout="this.style.backgroundColor='#000000'; this.style.borderColor='rgba(255, 255, 255, 0.25)';"
                        >
                            <span>BUY NOW</span>
                            <i class="fas fa-arrow-right-long btn-arrow"></i>
                        </button>
                    </div>

                    <!-- Packaging Guarantee & Dispatch Note (Unboxed, Clean & Elegant) -->
                    <div class="d-flex flex-column gap-2 pt-3 mt-1 text-xs font-sans text-start border-top border-gold-20">
                        <div class="d-flex align-items-center justify-content-between text-ivory">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-box-open text-gold"></i>
                                <span>Carefully packaged to preserve fragrance oils</span>
                            </span>
                            <span class="text-success fw-medium" style="font-size: 11px;"><i class="fas fa-circle-check"></i> In Stock &bull; Lahore Atelier</span>
                        </div>
                        <p class="text-muted-luxury lh-base mb-0" style="font-size: 11.5px;">
                            Orders placed before 4:00 PM are dispatched same-day via <strong>TCS Express Air</strong>. Delivery in 24–48 hours nationwide.
                        </p>
                    </div>

                    <!-- 4-Pillar Trust Highlights (Mobile only: positioned under Packaging & Dispatch Note) -->
                    <div class="pdp-trust-grid font-sans d-grid d-md-none mt-2">
                        <div class="pdp-trust-card">
                            <i class="fas fa-droplet text-gold fs-5"></i>
                            <div>
                                <div class="fw-semibold text-ivory" style="font-size: 11px;">38% Extrait de Parfum</div>
                                <div class="text-muted-luxury" style="font-size: 9.5px;">Double French oil strength</div>
                            </div>
                        </div>
                        <div class="pdp-trust-card">
                            <i class="fas fa-hourglass-half text-gold fs-5"></i>
                            <div>
                                <div class="fw-semibold text-ivory" style="font-size: 11px;">14+ Hours Beast Mode</div>
                                <div class="text-muted-luxury" style="font-size: 9.5px;">Artisanal macerated sillage</div>
                            </div>
                        </div>
                        <div class="pdp-trust-card">
                            <i class="fas fa-truck-fast text-gold fs-5"></i>
                            <div>
                                <div class="fw-semibold text-ivory" style="font-size: 11px;">Fast Courier Service</div>
                                <div class="text-muted-luxury" style="font-size: 9.5px;">24–48h delivery Pakistan</div>
                            </div>
                        </div>
                        <div class="pdp-trust-card">
                            <i class="fas fa-rotate text-gold fs-5"></i>
                            <div>
                                <div class="fw-semibold text-ivory" style="font-size: 11px;">7-Day Scent Exchange</div>
                                <div class="text-muted-luxury" style="font-size: 9.5px;">100% satisfaction guarantee</div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </section>

    <!-- 3. Fragrance Profile Accord Matrix (Headings: Wasted Vindey | Text: Poppins Regular) -->
    <section class="py-5 py-lg-6 border-bottom border-gold-20" style="background-color: #050203;">
        <div class="container px-3 px-lg-4">
            
            <div class="text-center mx-auto mb-4 mb-md-5" style="max-width: 42rem;">
                <span class="d-block text-gold mb-1 font-sans fw-medium text-uppercase" style="font-size: 11px; letter-spacing: 0.2em;">OLFACTORY CLASSIFICATION</span>
                <h2 class="font-hero text-ivory fw-normal text-uppercase gold-gradient-text" style="font-size: clamp(1.8rem, 2.6vw, 2.3rem);">
                    Fragrance Profile & Accords
                </h2>
            </div>

            <!-- 4-Card Classification Grid (Full-width rows on mobile, 4-columns on desktop) -->
            <div class="row g-3 g-md-4">
                
                <!-- Gender -->
                <div class="col-12 col-md-3">
                    <div class="pdp-accord-card h-100">
                        <span class="text-gold font-sans fw-medium text-uppercase" style="font-size: 10px; letter-spacing: 0.14em;">Gender Persona</span>
                        <div class="pdp-accord-title">{{ ucfirst($product->gender ?? 'Men / Unisex') }}</div>
                        <span class="text-muted-luxury font-sans" style="font-size: 11px;">Tailored Formulation</span>
                    </div>
                </div>

                <!-- Season -->
                <div class="col-12 col-md-3">
                    <div class="pdp-accord-card h-100">
                        <span class="text-gold font-sans fw-medium text-uppercase" style="font-size: 10px; letter-spacing: 0.14em;">Optimal Season</span>
                        <div class="pdp-accord-title">All Seasons</div>
                        <span class="text-muted-luxury font-sans" style="font-size: 11px;">Spring, Summer & Winter</span>
                    </div>
                </div>

                <!-- Occasion -->
                <div class="col-12 col-md-3">
                    <div class="pdp-accord-card h-100">
                        <span class="text-gold font-sans fw-medium text-uppercase" style="font-size: 10px; letter-spacing: 0.14em;">Occasion of Wear</span>
                        <div class="pdp-accord-title">Casual &amp; Formal</div>
                        <span class="text-muted-luxury font-sans" style="font-size: 11px;">Day to Imperial Evening</span>
                    </div>
                </div>

                <!-- Fragrance Profile -->
                <div class="col-12 col-md-3">
                    <div class="pdp-accord-card h-100">
                        <span class="text-gold font-sans fw-medium text-uppercase" style="font-size: 10px; letter-spacing: 0.14em;">Fragrance Family</span>
                        <div class="pdp-accord-title text-gold-soft text-truncate">{{ $product->fragranceFamily->name ?? 'Fresh & Woody' }}</div>
                        <span class="text-muted-luxury font-sans text-truncate" style="font-size: 11px;">Citrus, Fresh Spicy, Amber</span>
                    </div>
                </div>

            </div>


        </div>
    </section>

    <!-- 4. Olfactory Pyramid & Performance Benchmark (Headings: Wasted Vindey | Text: Poppins Regular) -->
    <section class="py-5 py-lg-6 border-bottom border-gold-20" style="background-color: #080204;">
        <div class="container px-3 px-lg-4">
            <div class="row g-4 g-lg-5 align-items-center">
                
                <!-- Left Column: The 3-Tier Olfactory Notes Pyramid (col-12 col-lg-6) -->
                <div class="col-12 col-lg-6 d-flex flex-column gap-3 gap-md-4">
                    <div class="text-start mb-1">
                        <span class="text-gold font-sans fw-medium" style="font-size: 11px; letter-spacing: 0.22em; text-transform: uppercase;">HARMONIC ACCORD ARCHITECTURE</span>
                        <h3 class="font-hero text-ivory mt-1 fw-normal gold-gradient-text" style="font-size: clamp(1.6rem, 2.4vw, 2.1rem);">The Fragrance Notes Pyramid</h3>
                        <p class="text-xs text-muted-luxury mt-1 mb-0 font-sans">Evolution of accords on skin over 16+ hours</p>
                    </div>

                    <!-- Top Notes Tier -->
                    <div class="pdp-pyramid-tier d-flex flex-column gap-2 shadow-sm">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 font-sans">
                            <span class="text-xs text-uppercase tracking-widest text-gold fw-semibold d-flex align-items-center gap-2">
                                <i class="fas fa-sparkles text-gold"></i>
                                <span>Top Notes (First 15 - 45 Mins)</span>
                            </span>
                            <span class="text-muted-luxury text-uppercase fw-medium" style="font-size: 10px;">Opening Spark</span>
                        </div>
                        <p class="text-ivory font-sans mb-0 lh-base" style="font-size: 0.92rem;">
                            {{ $product->fragrance_notes_pyramid['top'] ?? ($product->top_notes_summary ?? 'Bergamot, Fresh Citrus, Lemon, Green Mandarin') }}
                        </p>
                    </div>

                    <!-- Middle / Heart Notes Tier -->
                    <div class="pdp-pyramid-tier d-flex flex-column gap-2 shadow-sm">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 font-sans">
                            <span class="text-xs text-uppercase tracking-widest text-gold fw-semibold d-flex align-items-center gap-2">
                                <i class="fas fa-heart text-gold"></i>
                                <span>Middle Notes (2 - 6 Hours)</span>
                            </span>
                            <span class="text-muted-luxury text-uppercase fw-medium" style="font-size: 10px;">Sensual Heart</span>
                        </div>
                        <p class="text-ivory font-sans mb-0 lh-base" style="font-size: 0.92rem;">
                            {{ $product->fragrance_notes_pyramid['heart'] ?? ($product->heart_notes_summary ?? 'Jasmine, Geranium, Fresh Ginger, Rose Accords') }}
                        </p>
                    </div>

                    <!-- Base Notes Tier -->
                    <div class="pdp-pyramid-tier d-flex flex-column gap-2 shadow-sm">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 font-sans">
                            <span class="text-xs text-uppercase tracking-widest text-gold fw-semibold d-flex align-items-center gap-2">
                                <i class="fas fa-tree text-gold"></i>
                                <span>Base Notes (6 - 18+ Hours)</span>
                            </span>
                            <span class="text-gold text-uppercase fw-semibold" style="font-size: 10px;">14+ Hours Longevity</span>
                        </div>
                        <p class="text-ivory font-sans mb-0 lh-base" style="font-size: 0.92rem;">
                            {{ $product->fragrance_notes_pyramid['base'] ?? ($product->base_notes_summary ?? 'Musk, Oakmoss, Warm Amber, Sandalwood') }}
                        </p>
                    </div>
                </div>

                <!-- Right Column: Performance Benchmark Meters (Desktop only, hidden on mobile) -->
                <div class="col-12 col-lg-6 d-none d-lg-flex flex-column bg-wine-card border border-gold-25 rounded-4 p-3.5 p-sm-4 p-lg-5 gap-3.5 gap-md-4 shadow-sm">
                    <div>
                        <span class="text-gold font-sans fw-medium" style="font-size: 11px; letter-spacing: 0.22em; text-transform: uppercase;">LABORATORY BENCHMARKS</span>
                        <h3 class="font-hero text-ivory mt-1 fw-normal mb-0 gold-gradient-text" style="font-size: clamp(1.6rem, 2.4vw, 2.1rem);">Extrait Performance Metrics</h3>
                    </div>

                    <!-- Longevity Meter -->
                    <div class="d-flex flex-column gap-2 font-sans">
                        <div class="d-flex justify-content-between text-xs fw-medium">
                            <span class="text-ivory text-uppercase tracking-wider">Longevity on Skin & Fabric:</span>
                            <span class="text-gold fw-semibold">{{ $product->longevity_rating ?? 9.5 }}/10 (16-18 Hours)</span>
                        </div>
                        <div class="w-100 bg-wine-dark rounded-pill overflow-hidden border border-gold-20" style="height: 8px;">
                            <div class="h-100 rounded-pill" style="background: linear-gradient(to right, #dfb770, #f0d59d); width: 95%;"></div>
                        </div>
                    </div>

                    <!-- Sillage Meter -->
                    <div class="d-flex flex-column gap-2 font-sans">
                        <div class="d-flex justify-content-between text-xs fw-medium">
                            <span class="text-ivory text-uppercase tracking-wider">Sillage & Aura Projection:</span>
                            <span class="text-gold fw-semibold">{{ $product->sillage_rating ?? 9 }}/10 (Room-Filling)</span>
                        </div>
                        <div class="w-100 bg-wine-dark rounded-pill overflow-hidden border border-gold-20" style="height: 8px;">
                            <div class="h-100 rounded-pill" style="background: linear-gradient(to right, #dfb770, #f0d59d); width: 90%;"></div>
                        </div>
                    </div>

                    <!-- Maceration Time -->
                    <div class="d-flex flex-column gap-2 font-sans">
                        <div class="d-flex justify-content-between text-xs fw-medium">
                            <span class="text-ivory text-uppercase tracking-wider">Cold-Maceration Period:</span>
                            <span class="text-gold fw-semibold">12 Weeks Artisanal Aging</span>
                        </div>
                        <div class="w-100 bg-wine-dark rounded-pill overflow-hidden border border-gold-20" style="height: 8px;">
                            <div class="h-100 rounded-pill" style="background: linear-gradient(to right, #dfb770, #f0d59d); width: 95%;"></div>
                        </div>
                    </div>

                    <!-- Oil Concentration Badge -->
                    <div class="pt-3 border-top border-gold-20 d-flex flex-wrap align-items-center justify-content-between gap-2 text-xs text-muted-luxury font-sans">
                        <div>
                            <span class="d-block text-gold fw-medium text-uppercase tracking-wider" style="font-size: 10px;">Fragrance Concentration</span>
                            <span class="font-hero fs-5 text-ivory fw-normal">38% Pure French Oils</span>
                        </div>
                        <div class="text-start text-sm-end">
                            <span class="d-block text-gold fw-medium text-uppercase tracking-wider" style="font-size: 10px;">Climate Optimization</span>
                            <span class="text-xs text-ivory fw-medium">Engineered for Pakistan Climate</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 5. PDP Detailed Tabs (Description, Ritual, Shipping, Customer Reviews) -->
    <section class="py-5 py-lg-6 border-bottom border-gold-20" style="background-color: #050203;">
        <div class="container px-3 px-lg-4" style="max-width: 960px;" x-data="{ currentTab: 'desc' }">
            
            <!-- Tab Headers (Responsive Horizontal Touch Slider on Mobile, Centered on Desktop) -->
            <div class="pdp-tabs-container mb-4 mb-lg-5 font-sans no-scrollbar">
                <button 
                    type="button" 
                    @click="currentTab = 'desc'" 
                    :class="currentTab === 'desc' ? 'pdp-tab-active' : ''"
                    class="pdp-tab-btn"
                >
                    The Impression Story
                </button>

                <button 
                    type="button" 
                    @click="currentTab = 'usage'" 
                    :class="currentTab === 'usage' ? 'pdp-tab-active' : ''"
                    class="pdp-tab-btn"
                >
                    Application Ritual
                </button>

                <button 
                    type="button" 
                    @click="currentTab = 'shipping'" 
                    :class="currentTab === 'shipping' ? 'pdp-tab-active' : ''"
                    class="pdp-tab-btn"
                >
                    Shipping & Exchange Policy
                </button>

                <button 
                    type="button" 
                    @click="currentTab = 'reviews'" 
                    :class="currentTab === 'reviews' ? 'pdp-tab-active' : ''"
                    class="pdp-tab-btn"
                >
                    Patron Reviews ({{ $product->reviews_count ?: 48 }})
                </button>
            </div>

            <!-- Tab 1: Description -->
            <div x-show="currentTab === 'desc'" class="d-flex flex-column gap-3 text-ivory lh-lg font-sans" style="font-size: 0.95rem; font-weight: 400;">
                <p class="mb-0">
                    {{ $product->story ?? $product->description }}
                </p>
                <p class="text-muted-luxury mb-0">
                    Handcrafted in small batches with imported French fragrance oils and natural botanical distillations. Macerated for 90 days in temperature-controlled dark cellars to reach peak projection and richness.
                </p>
            </div>

            <!-- Tab 2: Application Ritual -->
            <div x-show="currentTab === 'usage'" class="d-flex flex-column gap-3 text-ivory lh-lg font-sans" style="display: none; font-size: 0.95rem; font-weight: 400;">
                <h4 class="font-hero fs-5 text-gold-soft fw-normal mb-1">Mastering the Sillage of Extrait de Parfum</h4>
                <ul class="d-flex flex-column gap-2 text-muted-luxury ps-3 mb-0">
                    <li><strong class="text-ivory">Pulse Points:</strong> Apply 2 to 3 sprays directly on pulse points — the sides of your neck, behind the ears, and inside wrists.</li>
                    <li><strong class="text-ivory">Fabric Longevity:</strong> Spray lightly on linen, wool, or cotton garments. Extrait compounds hold onto natural fibers for up to 48 hours.</li>
                    <li><strong class="text-ivory">Never Rub:</strong> Allow the formulation to naturally settle on skin without friction, ensuring top notes blossom gracefully.</li>
                </ul>
            </div>

            <!-- Tab 3: Shipping & Exchange -->
            <div x-show="currentTab === 'shipping'" class="d-flex flex-column gap-3 text-ivory lh-lg font-sans" style="display: none; font-size: 0.95rem; font-weight: 400;">
                <h4 class="font-hero fs-5 text-gold-soft fw-normal mb-1">Nationwide Pakistan Delivery Guarantee</h4>
                <p class="text-muted-luxury mb-0">All flacons are encased in impact-resistant cushioned packaging and dispatched through premium courier services (TCS Express Air, Leopards).</p>
                <ul class="d-flex flex-column gap-2 text-muted-luxury ps-3 mb-0">
                    <li><strong class="text-ivory">Major Hubs:</strong> Lahore, Karachi, Islamabad, Rawalpindi — 24 to 48 hours.</li>
                    <li><strong class="text-ivory">Other Cities:</strong> 2 to 4 business days.</li>
                    <li><strong class="text-ivory">Hassle-Free Exchange:</strong> If you feel the scent does not suit your aura, contact our WhatsApp Concierge within 7 days for an unconditional exchange.</li>
                </ul>
            </div>

            <!-- Tab 4: Reviews -->
            <div x-show="currentTab === 'reviews'" class="d-flex flex-column gap-4" style="display: none;">
                
                <!-- Submit Review Form -->
                <div class="p-4 p-md-5 bg-wine-card border border-gold-25 rounded-4 d-flex flex-column gap-3.5">
                    <h4 class="font-hero fs-4 text-ivory fw-normal mb-0 gold-gradient-text">Share Your Olfactory Impression</h4>
                    <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="d-flex flex-column gap-3 font-sans">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label class="d-block text-xs text-uppercase tracking-wider text-gold mb-1 fw-medium">Your Name *</label>
                                <input type="text" name="customer_name" required placeholder="e.g. Tariq Mehmood" class="form-control form-control-luxury text-xs py-2 px-3">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="d-block text-xs text-uppercase tracking-wider text-gold mb-1 fw-medium">Your City in Pakistan *</label>
                                <input type="text" name="customer_city" required placeholder="e.g. Lahore / Karachi" class="form-control form-control-luxury text-xs py-2 px-3">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="d-block text-xs text-uppercase tracking-wider text-gold mb-1 fw-medium">Rating *</label>
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
                            <label class="d-block text-xs text-uppercase tracking-wider text-gold mb-1 fw-medium">Review Title</label>
                            <input type="text" name="title" placeholder="e.g. Monumental sillage at an evening wedding" class="form-control form-control-luxury text-xs py-2 px-3">
                        </div>
                        <div>
                            <label class="d-block text-xs text-uppercase tracking-wider text-gold mb-1 fw-medium">Your Review *</label>
                            <textarea name="comment" required rows="3" placeholder="Share your experience regarding projection, longevity, and compliments received..." class="form-control form-control-luxury text-xs py-2 px-3"></textarea>
                        </div>
                        <button type="submit" class="btn-pill-gold align-self-start" style="padding: 11px 26px;">
                            <span>Submit Verified Review</span>
                            <i class="fas fa-arrow-right-long btn-arrow"></i>
                        </button>
                    </form>
                </div>

                <!-- Existing Reviews List -->
                <div class="d-flex flex-column gap-3 font-sans">
                    @forelse($product->reviews as $review)
                        <div class="p-4 bg-wine-card border border-gold-20 rounded-4 d-flex flex-column gap-2 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-wine-accent border border-gold-40 d-flex align-items-center justify-content-center text-gold text-xs fw-bold" style="width: 32px; height: 32px;">
                                        {{ substr($review->user_name ?? 'P', 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="text-ivory fw-semibold" style="font-size: 0.95rem;">{{ $review->user_name }}</span>
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
                                <h5 class="text-xs fw-semibold text-gold-soft mb-0">{{ $review->review_title }}</h5>
                            @endif
                            <p class="text-xs text-muted-luxury lh-base font-light mb-0">
                                "{{ $review->comment }}"
                            </p>
                        </div>
                    @empty
                        <p class="text-xs text-muted-luxury fst-italic text-center py-4 mb-0">Be the first connoisseur to review this masterpiece.</p>
                    @endforelse
                </div>

            </div>

        </div>
    </section>

    <!-- 6. Related Pairings Carousel / You May Also Like -->
    @if($relatedProducts->count() > 0)
        <section class="py-5 py-lg-6 border-bottom border-gold-20" style="background-color: #080204;">
            <div class="container px-3 px-lg-4">
                <div class="text-center mx-auto mb-5" style="max-width: 560px;">
                    <span class="text-gold font-sans fw-medium" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">OLFACTORY HARMONY</span>
                    <h3 class="font-hero text-ivory mt-1 fw-normal mb-0 gold-gradient-text" style="font-size: clamp(1.8rem, 2.6vw, 2.3rem);">You May Also Like</h3>
                </div>

                <div class="position-relative">
                    <div class="swiper related-products-swiper">
                        <div class="swiper-wrapper pb-4">
                            @foreach($relatedProducts as $rel)
                                <div class="swiper-slide h-auto">
                                    <x-product-card :product="$rel" />
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination related-swiper-pagination position-relative mt-3"></div>
                    </div>

                    <!-- Luxury Desktop Navigation Controls -->
                    <div class="swiper-button-prev related-prev luxury-swiper-prev d-none d-lg-flex"></div>
                    <div class="swiper-button-next related-next luxury-swiper-next d-none d-lg-flex"></div>
                </div>
            </div>
        </section>
    @endif

    <!-- 7. Mobile Sticky Add-to-Cart Bottom Bar -->
    <div class="pdp-sticky-bottom-bar d-lg-none">
        <div class="pdp-sticky-inner">
            <!-- Left Info: Title & Price -->
            <div class="pdp-sticky-info">
                <div class="pdp-sticky-name">{{ $product->name }}</div>
                <div class="pdp-sticky-price" x-text="formattedPrice">{{ $product->formatted_effective_price }}</div>
            </div>

            <!-- Right Buttons: BUY NOW + ADD TO BAG -->
            <div class="pdp-sticky-actions">
                <button 
                    type="button" 
                    @click="buyNow()" 
                    class="pdp-sticky-btn-buy"
                    aria-label="Buy Now Instantly"
                >
                    <span>BUY NOW</span>
                </button>
                <button 
                    type="button" 
                    @click="addToCart()"
                    class="pdp-sticky-btn-bag"
                    aria-label="Add to Bag"
                >
                    <span>ADD TO BAG</span>
                </button>
            </div>
        </div>
    </div>



</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (document.querySelector('.related-products-swiper') && !document.querySelector('.related-products-swiper').swiper && typeof Swiper !== 'undefined') {
            new Swiper('.related-products-swiper', {
                slidesPerView: 1.35,
                spaceBetween: 14,
                speed: 800,
                loop: false,
                grabCursor: true,
                resistance: true,
                resistanceRatio: 0.75,
                touchRatio: 1.15,
                touchAngle: 45,
                threshold: 4,
                watchSlidesProgress: true,
                lazyPreloadPrevNext: 2,
                pagination: {
                    el: '.related-swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
                navigation: {
                    nextEl: '.related-next',
                    prevEl: '.related-prev',
                },
                breakpoints: {
                    480: { slidesPerView: 1.8, spaceBetween: 16 },
                    576: { slidesPerView: 2.2, spaceBetween: 18 },
                    768: { slidesPerView: 3, spaceBetween: 20 },
                    1024: { slidesPerView: 4, spaceBetween: 24 }
                }
            });
        }
    });
</script>
@endpush

@endsection
