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
            init() {
                window.pdpSelectedVariantId = this.selectedVariantId;
                window.pdpQuantity = this.quantity;
            },
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
            addToCart(btn) {
                const targetBtn = btn || (this && this.$el) || null;
                if (typeof addToCartAjax === 'function') {
                    addToCartAjax({{ $product->id }}, this.quantity, this.selectedVariantId, targetBtn);
                }
            },
            buyNow() {
                const variantId = this.selectedVariantId || (window.pdpSelectedVariantId || {{ $product->variants->first()?->id ?? 'null' }});
                const qty = this.quantity || 1;
                fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ product_id: {{ $product->id }}, quantity: qty, variant_id: variantId })
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
        <section class="py-5 py-lg-6 pdp-section" style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA;">
            <div class="container-fluid px-3 px-sm-4 px-md-5 px-xl-5 px-xxl-6">
                <div class="row gx-4 gx-lg-5 gy-5 align-items-start justify-content-between">

                    <!-- Left Column: Master Flacon Showcase & Trust Pillars (col-12 col-lg-6) -->
                    <div class="col-12 col-lg-6 d-flex flex-column gap-3">

                        <!-- Main Flacon Pedestal Stage (Scaled to Balanced Luxury Size) -->
                        <div class="pdp-flacon-stage w-100">

                            <!-- Badges Header -->
                            <div class="position-absolute top-0 start-0 m-3 z-2 d-flex flex-column gap-2 font-sans" style="gap: 8px;">
                                @if($product->is_bestseller)
                                    <span
                                        class="pdp-image-badge bg-wine-accent text-gold-soft border border-gold-40 px-2.5 py-1 rounded-pill shadow-sm text-uppercase fw-semibold d-inline-flex align-items-center justify-content-center text-center"
                                        style="font-size: 9.5px; letter-spacing: 0.1em; line-height: 1.2;">
                                        ★ BESTSELLER
                                    </span>
                                @elseif($product->is_new_arrival)
                                    <span
                                        class="pdp-image-badge bg-success text-white border border-success px-2.5 py-1 rounded-pill shadow-sm text-uppercase fw-semibold d-inline-flex align-items-center justify-content-center text-center"
                                        style="font-size: 9.5px; letter-spacing: 0.1em; line-height: 1.2;">
                                        NEW ARRIVAL
                                    </span>
                                @endif

                                <template x-if="savingsPercent > 0">
                                    <span
                                        class="pdp-image-badge bg-gradient-discount-badge text-white px-2.5 py-1 rounded-pill shadow-sm border border-gold-30 fw-bold d-inline-flex align-items-center justify-content-center text-center"
                                        style="font-size: 9.5px; width: fit-content; line-height: 1.2;">
                                        UP TO <span x-text="savingsPercent" class="mx-1"></span>% OFF
                                    </span>
                                </template>
                            </div>

                            <!-- 38% Extrait Badge on Right -->
                            <div class="position-absolute top-0 end-0 m-3 z-2 font-sans">
                                <span class="pdp-image-badge badge-extrait shadow-sm d-inline-flex align-items-center justify-content-center text-center"
                                    style="font-size: 9.5px; letter-spacing: 0.08em; line-height: 1.2;">
                                    38% EXTRAIT
                                </span>
                            </div>

                            <!-- Product Bottle with Smooth Coordinate Zoom on Hover & Touch -->
                            <div id="pdpZoomContainer" class="pdp-zoom-container position-relative d-flex align-items-center justify-content-center my-2 overflow-hidden rounded-3"
                                style="min-height: 290px; width: 100%;">
                                <img id="pdpMasterImage" src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"
                                    onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
                                    class="pdp-flacon-img">
                                <div class="pdp-zoom-hint position-absolute bottom-0 end-0 m-2 px-2.5 py-1 rounded-pill d-flex align-items-center gap-1 shadow-sm">
                                    <i class="fas fa-search-plus" style="font-size: 9.5px;"></i>
                                    <span style="font-size: 9px; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase;">ZOOM</span>
                                </div>
                            </div>

                            <div class="text-uppercase mt-2 font-sans fw-medium"
                                style="font-size: 10.5px; letter-spacing: 0.12em; color: #541B29;">
                                <i class="fas fa-certificate me-1" style="color: #9E7D3B;"></i> Formulated with Pure French
                                Oils
                            </div>
                        </div>

                        <!-- Thumbnail Gallery Selector -->
                        @if($product->images->count() > 1)
                            <div class="d-flex align-items-center justify-content-center gap-2 overflow-x-auto py-1">
                                @foreach($product->images as $img)
                                    <button type="button"
                                        onclick="if (window.switchPdpImage) { window.switchPdpImage('{{ $img->url }}', this); } else { document.getElementById('pdpMasterImage').src='{{ $img->url }}'; }"
                                        class="pdp-thumb-item {{ $loop->first ? 'active' : '' }}">
                                        <img src="{{ $img->url }}" alt="{{ $img->alt_text }}"
                                            onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
                                            class="img-fluid mh-100 object-contain">
                                    </button>
                                @endforeach
                            </div>
                        @endif


                        <!-- 4-Pillar Trust Highlights (Desktop only under gallery) -->
                        <div class="pdp-trust-grid font-sans d-none d-md-grid">
                            <div class="pdp-trust-card">
                                <i class="fas fa-droplet fs-5 pdp-icon-gradient"></i>
                                <div>
                                    <div class="fw-semibold" style="font-size: 11px; color: #110D0E !important;">38% Extrait
                                        de Parfum</div>
                                    <div style="font-size: 9.5px; color: #4A4240;">Double French oil strength</div>
                                </div>
                            </div>
                            <div class="pdp-trust-card">
                                <i class="fas fa-hourglass-half fs-5 pdp-icon-gradient"></i>
                                <div>
                                    <div class="fw-semibold" style="font-size: 11px; color: #110D0E !important;">14+ Hours
                                        Beast Mode</div>
                                    <div style="font-size: 9.5px; color: #4A4240;">Artisanal macerated sillage</div>
                                </div>
                            </div>
                            <div class="pdp-trust-card">
                                <i class="fas fa-truck-fast fs-5 pdp-icon-gradient"></i>
                                <div>
                                    <div class="fw-semibold" style="font-size: 11px; color: #110D0E !important;">Fast
                                        Courier Service</div>
                                    <div style="font-size: 9.5px; color: #4A4240;">24–48h delivery Pakistan</div>
                                </div>
                            </div>
                            <div class="pdp-trust-card">
                                <i class="fas fa-rotate fs-5 pdp-icon-gradient"></i>
                                <div>
                                    <div class="fw-semibold" style="font-size: 11px; color: #110D0E !important;">7-Day Scent
                                        Exchange</div>
                                    <div style="font-size: 9.5px; color: #4A4240;">100% satisfaction guarantee</div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Product Purchasing Engine (Spacious, Unboxed, Full Width Aligned) -->
                    <div class="col-12 col-lg-6 d-flex flex-column gap-4">

                        <!-- Product Heading & Subheading -->
                        <div class="d-flex flex-column gap-1.5 text-start">
                            <h1 class="pdp-title text-start mb-0" style="color: #110D0E !important;">
                                {{ $product->name }}
                            </h1>
                            @if($product->tagline)
                                <p class="font-sans fst-italic fw-light mb-0 text-start"
                                    style="font-size: 0.95rem; color: #541B29;">
                                    "{{ $product->tagline }}"
                                </p>
                            @endif
                        </div>

                        <!-- Star Rating & Review Count (Clean Unboxed Row) -->
                        {{-- <div
                            class="d-flex flex-wrap align-items-center gap-2 gap-sm-3 text-xs py-2.5 py-sm-3 my-1 font-sans"
                            style="border-top: 1px solid #E8E0DA; border-bottom: 1px solid #E8E0DA;">
                            <div class="d-inline-flex align-items-center text-nowrap"
                                style="font-size: 11px; gap: 2px; color: #9E7D3B;">
                                @for($i = 1; $i <= 5; $i++) <i
                                    class="fas fa-star {{ $i <= round($product->rating_avg ?: 5) ? '' : 'opacity-25' }}">
                                    </i>
                            </div>
                            <span class="fw-semibold text-nowrap" style="white-space: nowrap; color: #110D0E !important;">{{
                                number_format($product->rating_avg ?: 4.9, 1) }} / 5.0</span>
                            <span class="text-nowrap" style="white-space: nowrap; color: #4A4240;">({{
                                $product->reviews_count ?: 48 }} Verified Patron Reviews)</span>
                        </div> --}}

                        <div class="d-flex flex-wrap align-items-center gap-2 gap-sm-3 text-xs py-2 py-sm-3 my-1 font-sans"
                            style="border-top: 1px solid #E8E0DA; border-bottom: 1px solid #E8E0DA;">

                            <div class="d-inline-flex align-items-center text-nowrap"
                                style="font-size: 11px; gap: 2px; color: #9E7D3B;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= round($product->rating_avg ?: 5) ? '' : 'opacity-25' }}"></i>
                                @endfor
                            </div>

                            <span class="fw-semibold text-nowrap" style="white-space: nowrap; color: #110D0E !important;">
                                {{ number_format($product->rating_avg ?: 4.9, 1) }} / 5.0
                            </span>

                            <span class="text-nowrap" style="white-space: nowrap; color: #4A4240;">
                                ({{ $product->reviews_count ?: 48 }} Verified Patron Reviews)
                            </span>
                        </div>

                        <!-- Pricing & Savings (Completely Unboxed, Clean & Elegant) -->
                        <div class="d-flex flex-column gap-1.5 font-sans text-start my-1">
                            <div class="d-flex align-items-center gap-3">
                                <span class="pdp-price-amount price-gradient-luxury" x-text="formattedPrice">
                                    {{ $product->formatted_effective_price }}
                                </span>
                                <span class="text-sm text-decoration-line-through" style="color: #615652;"
                                    x-text="formattedComparePrice"></span>
                                <template x-if="savingsPercent > 0">
                                    <span class="badge-savings-luxury badge-save-gradient" style="font-size: 10px;">
                                        SAVE <span x-text="savingsPercent"></span>%
                                    </span>
                                </template>
                            </div>
                        </div>

                        <!-- Flacon Size Variant Selector -->
                        <div class="d-flex flex-column gap-2.5 font-sans text-start my-1">
                            <label class="d-block text-uppercase fw-semibold mb-1"
                                style="font-size: 10px; letter-spacing: 0.12em; color: #541B29 !important;">
                                SELECT BOTTLE SIZE
                            </label>
                            <div class="d-flex flex-wrap pdp-size-container gap-2 gap-sm-2.5" style="gap: 8px;">
                                @forelse($product->variants as $variant)
                                    @php
                                        $shortSize = preg_match('/^\d+\s*ml/i', $variant->size_label, $m) ? $m[0] : (explode(' ', $variant->size_label)[0] ?? $variant->size_label);
                                    @endphp
                                    <button type="button"
                                        @click="selectedVariantId = {{ $variant->id }}; selectedPrice = {{ $variant->price }}; selectedComparePrice = {{ $variant->compare_at_price ?? 0 }}; selectedLabel = '{{ $variant->size_label }}'; window.pdpSelectedVariantId = {{ $variant->id }};"
                                        onclick="window.pdpSelectedVariantId = {{ $variant->id }};"
                                        :class="selectedVariantId === {{ $variant->id }} ? 'active' : ''"
                                        class="pdp-size-btn shadow-xs">
                                        <span>{{ $shortSize }}</span>
                                    </button>
                                @empty
                                    <button type="button" class="pdp-size-btn active shadow-xs">
                                        <span>{{ $product->volume_ml }}ml</span>
                                    </button>
                                @endforelse
                            </div>
                        </div>

                        <!-- Quantity Stepper & Primary Actions -->
                        <div class="d-flex flex-column gap-3 my-1">

                            <!-- Row 1: Quantity Stepper + Add To Bag Stadium Pill Button -->
                            <div class="d-flex flex-wrap align-items-center gap-2 gap-sm-3 pdp-action-row">

                                <!-- Custom Luxury Quantity Stepper -->
                                <div class="pdp-qty-stepper-box shadow-xs">
                                    <button type="button" @click="if(quantity > 1) { quantity--; window.pdpQuantity = quantity; }" class="pdp-qty-btn-luxury"
                                        aria-label="Decrease quantity">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="pdp-qty-display-luxury" x-text="quantity">1</span>
                                    <button type="button" @click="if(quantity < 10) { quantity++; window.pdpQuantity = quantity; }" class="pdp-qty-btn-luxury"
                                        aria-label="Increase quantity">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <!-- Primary Add To Bag Button -->
                                <button type="button" 
                                    id="pdpMainAddToCartBtn"
                                    @click="addToCart($event.currentTarget)" 
                                    class="btn-pill-gold shadow-sm flex-grow-1 d-inline-flex align-items-center justify-content-center gap-2"
                                    style="min-height: 44px; touch-action: manipulation; -webkit-tap-highlight-color: transparent; cursor: pointer; background: linear-gradient(135deg, #a31838 0%, #780d24 50%, #4a0915 100%) !important; border: none !important; outline: none !important; color: #FFFFFF !important; box-shadow: 0 4px 14px rgba(120, 13, 36, 0.4), 0 2px 4px rgba(0, 0, 0, 0.25) !important;">
                                    <i class="fas fa-cart-shopping text-white" style="font-size: 12px;" aria-hidden="true"></i>
                                    <span class="text-nowrap text-white" style="font-size: 12px; font-weight: 600;">ADD TO BAG</span>
                                </button>
                                <button type="button" @click="buyNow()" class="btn-pill-buynow shadow-sm flex-grow-1" style="min-height: 44px; font-size: 12px; touch-action: manipulation; cursor: pointer;">
                                    <span>BUY NOW</span>
                                </button>
                            </div>

                            <!-- Row 2: BUY NOW (Direct Checkout Button) -->

                        </div>

                        <!-- Packaging Guarantee & Dispatch Note (Unboxed, Clean & Elegant) -->
                        <div class="d-flex flex-column gap-2 pt-3 mt-1 text-xs font-sans text-start"
                            style="border-top: 1px solid #E8E0DA;">
                            <div class="d-flex align-items-center justify-content-between" style="color: #110D0E;">
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fas fa-box-open pdp-icon-gradient"></i>
                                    <span>Carefully packaged to preserve fragrance oils</span>
                                </span>
                                <span class="text-success fw-medium" style="font-size: 11px;"><i
                                        class="fas fa-circle-check"></i> In Stock &bull; Lahore Atelier</span>
                            </div>
                            <p class="lh-base mb-0" style="font-size: 11.5px; color: #4A4240;">
                                Orders placed before 4:00 PM are dispatched same-day via <strong>TCS Express Air</strong>.
                                Delivery in 24–48 hours nationwide.
                            </p>
                        </div>

                        <!-- 4-Pillar Trust Highlights (Mobile only: positioned under Packaging & Dispatch Note) -->
                        <div class="pdp-trust-grid font-sans d-grid d-md-none mt-2">
                            <div class="pdp-trust-card">
                                <i class="fas fa-droplet fs-5 pdp-icon-gradient"></i>
                                <div>
                                    <div class="fw-semibold" style="font-size: 11px; color: #110D0E !important;">38% Extrait
                                        de Parfum</div>
                                    <div style="font-size: 9.5px; color: #4A4240;">Double French oil strength</div>
                                </div>
                            </div>
                            <div class="pdp-trust-card">
                                <i class="fas fa-hourglass-half fs-5 pdp-icon-gradient"></i>
                                <div>
                                    <div class="fw-semibold" style="font-size: 11px; color: #110D0E !important;">14+ Hours
                                        Beast Mode</div>
                                    <div style="font-size: 9.5px; color: #4A4240;">Artisanal macerated sillage</div>
                                </div>
                            </div>
                            <div class="pdp-trust-card">
                                <i class="fas fa-truck-fast fs-5 pdp-icon-gradient"></i>
                                <div>
                                    <div class="fw-semibold" style="font-size: 11px; color: #110D0E !important;">Fast
                                        Courier Service</div>
                                    <div style="font-size: 9.5px; color: #4A4240;">24–48h delivery Pakistan</div>
                                </div>
                            </div>
                            <div class="pdp-trust-card">
                                <i class="fas fa-rotate fs-5 pdp-icon-gradient"></i>
                                <div>
                                    <div class="fw-semibold" style="font-size: 11px; color: #110D0E !important;">7-Day Scent
                                        Exchange</div>
                                    <div style="font-size: 9.5px; color: #4A4240;">100% satisfaction guarantee</div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        <!-- 3. Fragrance Profile Accord Matrix (Headings: Wasted Vindey | Text: Poppins Regular) -->
        <section class="py-5 py-lg-6" style="background-color: #FAF7F2; border-bottom: 1px solid #E8E0DA;">
            <div class="container px-3 px-lg-4">

                <div class="text-center mx-auto mb-4 mb-md-5" style="max-width: 42rem;">
                    <span class="d-block mb-1 font-sans fw-semibold text-uppercase"
                        style="font-size: 11px; letter-spacing: 0.2em; color: #541B29;">OLFACTORY CLASSIFICATION</span>
                    <h2 class="font-hero fw-normal text-uppercase"
                        style="font-size: clamp(1.8rem, 2.6vw, 2.3rem); color: #110D0E !important;">
                        Fragrance Profile & Accords
                    </h2>
                </div>

                <!-- 4-Card Classification Grid -->
                <div class="row g-3 g-md-4">

                    <!-- Gender -->
                    <div class="col-12 col-md-3">
                        <div class="pdp-accord-card h-100 shadow-xs">
                            <span class="font-sans fw-semibold text-uppercase"
                                style="font-size: 10px; letter-spacing: 0.14em; color: #541B29;">Gender Persona</span>
                            <div class="pdp-accord-title">{{ ucfirst($product->gender ?? 'Men / Unisex') }}</div>
                            <span class="font-sans" style="font-size: 11px; color: #4A4240;">Tailored Formulation</span>
                        </div>
                    </div>

                    <!-- Season -->
                    <div class="col-12 col-md-3">
                        <div class="pdp-accord-card h-100 shadow-xs">
                            <span class="font-sans fw-semibold text-uppercase"
                                style="font-size: 10px; letter-spacing: 0.14em; color: #541B29;">Optimal Season</span>
                            <div class="pdp-accord-title">All Seasons</div>
                            <span class="font-sans" style="font-size: 11px; color: #4A4240;">Spring, Summer & Winter</span>
                        </div>
                    </div>

                    <!-- Occasion -->
                    <div class="col-12 col-md-3">
                        <div class="pdp-accord-card h-100 shadow-xs">
                            <span class="font-sans fw-semibold text-uppercase"
                                style="font-size: 10px; letter-spacing: 0.14em; color: #541B29;">Occasion of Wear</span>
                            <div class="pdp-accord-title">Casual &amp; Formal</div>
                            <span class="font-sans" style="font-size: 11px; color: #4A4240;">Day to Imperial Evening</span>
                        </div>
                    </div>

                    <!-- Fragrance Profile -->
                    <div class="col-12 col-md-3">
                        <div class="pdp-accord-card h-100 shadow-xs">
                            <span class="font-sans fw-semibold text-uppercase"
                                style="font-size: 10px; letter-spacing: 0.14em; color: #541B29;">Fragrance Family</span>
                            <div class="pdp-accord-title text-truncate" style="color: #541B29 !important;">
                                {{ $product->fragranceFamily->name ?? 'Fresh & Woody' }}
                            </div>
                            <span class="font-sans text-truncate" style="font-size: 11px; color: #4A4240;">Citrus, Fresh
                                Spicy, Amber</span>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 4. Olfactory Pyramid & Performance Benchmark -->
        <section class="py-5 py-lg-6" style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA;">
            <div class="container px-3 px-lg-4">
                <div class="row g-4 g-lg-5 align-items-center">

                    <!-- Left Column: The 3-Tier Olfactory Notes Pyramid -->
                    <div class="col-12 col-lg-6 d-flex flex-column gap-3 gap-md-4">
                        <div class="text-start mb-1">
                            <span class="font-sans fw-semibold"
                                style="font-size: 11px; letter-spacing: 0.22em; text-transform: uppercase; color: #541B29;">HARMONIC
                                ACCORD ARCHITECTURE</span>
                            <h3 class="font-hero mt-1 fw-normal mb-0"
                                style="font-size: clamp(1.6rem, 2.4vw, 2.1rem); color: #110D0E !important;">The Fragrance
                                Notes Pyramid</h3>
                            <p class="text-xs mt-1 mb-0 font-sans" style="color: #4A4240;">Evolution of accords on skin over
                                16+ hours</p>
                        </div>

                        <!-- Top Notes Tier -->
                        <div class="pdp-pyramid-tier d-flex flex-column gap-2 shadow-xs">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 font-sans">
                                <span
                                    class="text-xs text-uppercase tracking-widest fw-semibold d-flex align-items-center gap-2"
                                    style="color: #541B29;">
                                    <i class="fas fa-wind pdp-note-icon-gradient" aria-hidden="true"></i>
                                    <span>Top Notes (First 15 - 45 Mins)</span>
                                </span>
                                <span class="text-uppercase fw-medium" style="font-size: 10px; color: #4A4240;">Opening
                                    Spark</span>
                            </div>
                            <p class="font-sans mb-0 lh-base" style="font-size: 0.92rem; color: #241D1B;">
                                {{ $product->fragrance_notes_pyramid['top'] ?? ($product->top_notes_summary ?? 'Bergamot, Fresh Citrus, Lemon, Green Mandarin') }}
                            </p>
                        </div>

                        <!-- Middle / Heart Notes Tier -->
                        <div class="pdp-pyramid-tier d-flex flex-column gap-2 shadow-xs">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 font-sans">
                                <span
                                    class="text-xs text-uppercase tracking-widest fw-semibold d-flex align-items-center gap-2"
                                    style="color: #541B29;">
                                    <i class="fas fa-heart pdp-note-icon-gradient" aria-hidden="true"></i>
                                    <span>Middle Notes (2 - 6 Hours)</span>
                                </span>
                                <span class="text-uppercase fw-medium" style="font-size: 10px; color: #4A4240;">Sensual
                                    Heart</span>
                            </div>
                            <p class="font-sans mb-0 lh-base" style="font-size: 0.92rem; color: #241D1B;">
                                {{ $product->fragrance_notes_pyramid['heart'] ?? ($product->heart_notes_summary ?? 'Jasmine, Geranium, Fresh Ginger, Rose Accords') }}
                            </p>
                        </div>

                        <!-- Base Notes Tier -->
                        <div class="pdp-pyramid-tier d-flex flex-column gap-2 shadow-xs">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 font-sans">
                                <span
                                    class="text-xs text-uppercase tracking-widest fw-semibold d-flex align-items-center gap-2"
                                    style="color: #541B29;">
                                    <i class="fas fa-gem pdp-note-icon-gradient" aria-hidden="true"></i>
                                    <span>Base Notes (6 - 18+ Hours)</span>
                                </span>
                                <span class="text-uppercase fw-semibold" style="font-size: 10px; color: #541B29;">14+ Hours
                                    Longevity</span>
                            </div>
                            <p class="font-sans mb-0 lh-base" style="font-size: 0.92rem; color: #241D1B;">
                                {{ $product->fragrance_notes_pyramid['base'] ?? ($product->base_notes_summary ?? 'Musk, Oakmoss, Warm Amber, Sandalwood') }}
                            </p>
                        </div>
                    </div>

                    <!-- Right Column: Performance Benchmark Meters (Desktop only) -->
                    <div class="col-12 col-lg-6 d-none d-lg-flex flex-column rounded-4 p-3.5 p-sm-4 p-lg-5 gap-3.5 gap-md-4 shadow-sm"
                        style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                        <div>
                            <span class="font-sans fw-semibold"
                                style="font-size: 11px; letter-spacing: 0.22em; text-transform: uppercase; color: #541B29;">LABORATORY
                                BENCHMARKS</span>
                            <h3 class="font-hero mt-1 fw-normal mb-0"
                                style="font-size: clamp(1.6rem, 2.4vw, 2.1rem); color: #110D0E !important;">Extrait
                                Performance Metrics</h3>
                        </div>

                        <!-- Longevity Meter -->
                        <div class="d-flex flex-column gap-2 font-sans">
                            <div class="d-flex justify-content-between text-xs fw-medium">
                                <span class="text-uppercase tracking-wider" style="color: #110D0E;">Longevity on Skin &
                                    Fabric:</span>
                                <span class="fw-semibold" style="color: #541B29;">{{ $product->longevity_rating ?? 9.5 }}/10
                                    (16-18 Hours)</span>
                            </div>
                            <div class="w-100 rounded-pill overflow-hidden"
                                style="height: 8px; background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                <div class="h-100 rounded-pill" style="background: linear-gradient(90deg, #a31838 0%, #780d24 100%); width: 95%;"></div>
                            </div>
                        </div>

                        <!-- Sillage Meter -->
                        <div class="d-flex flex-column gap-2 font-sans">
                            <div class="d-flex justify-content-between text-xs fw-medium">
                                <span class="text-uppercase tracking-wider" style="color: #211D1E;">Sillage & Aura
                                    Projection:</span>
                                <span class="fw-semibold" style="color: #541B29;">{{ $product->sillage_rating ?? 9 }}/10
                                    (Room-Filling)</span>
                            </div>
                            <div class="w-100 rounded-pill overflow-hidden"
                                style="height: 8px; background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                <div class="h-100 rounded-pill" style="background: linear-gradient(90deg, #a31838 0%, #780d24 100%); width: 90%;"></div>
                            </div>
                        </div>

                        <!-- Maceration Time -->
                        <div class="d-flex flex-column gap-2 font-sans">
                            <div class="d-flex justify-content-between text-xs fw-medium">
                                <span class="text-uppercase tracking-wider" style="color: #211D1E;">Cold-Maceration
                                    Period:</span>
                                <span class="fw-semibold" style="color: #541B29;">12 Weeks Artisanal Aging</span>
                            </div>
                            <div class="w-100 rounded-pill overflow-hidden"
                                style="height: 8px; background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                <div class="h-100 rounded-pill" style="background: linear-gradient(90deg, #a31838 0%, #780d24 100%); width: 95%;"></div>
                            </div>
                        </div>

                        <!-- Oil Concentration Badge -->
                        <div class="pt-3 d-flex flex-wrap align-items-center justify-content-between gap-2 text-xs font-sans"
                            style="border-top: 1px solid #E8E0DA;">
                            <div>
                                <span class="d-block fw-semibold text-uppercase tracking-wider"
                                    style="font-size: 10px; color: #541B29;">Fragrance Concentration</span>
                                <span class="font-hero fs-5 fw-normal" style="color: #211D1E;">38% Pure French Oils</span>
                            </div>
                            <div class="text-start text-sm-end">
                                <span class="d-block fw-semibold text-uppercase tracking-wider"
                                    style="font-size: 10px; color: #541B29;">Climate Optimization</span>
                                <span class="text-xs fw-medium" style="color: #211D1E;">Engineered for Pakistan
                                    Climate</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 5. PDP The Impression Story (Single Clean Button, Uncluttered Layout) -->
        <section class="py-4 py-lg-5" style="background-color: #FAF7F2; border-bottom: 1px solid #E8E0DA;"
            x-data="{ reviewsOpen: false }">
            <div class="container px-3 px-lg-4" style="max-width: 960px;">

                <!-- Retained Single Button: The Impression Story -->
                <div class="text-center mb-3 mb-lg-4 font-sans">
                    <button type="button" class="pdp-tab-btn pdp-tab-active btn-impression-story" style="cursor: default;">
                        <i class="fas fa-feather-pointed me-1.5" aria-hidden="true"></i>
                        <span>The Impression Story</span>
                    </button>
                </div>

                <!-- The Impression Story Narrative -->
                <div class="d-flex flex-column gap-3 lh-lg font-sans text-center mx-auto"
                    style="max-width: 820px; font-size: 0.95rem; font-weight: 400; color: #4A403A;">
                    <p class="mb-0">
                        {{ $product->story ?? $product->description }}
                    </p>
                    <p class="mb-0" style="font-size: 0.9rem; color: #7A6F68;">
                        Handcrafted in small batches with imported French fragrance oils and natural botanical
                        distillations. Macerated for 90 days in temperature-controlled dark cellars to reach peak projection
                        and richness.
                    </p>
                </div>

                <!-- Subtle Patron Reviews Access (Preserves 100% review viewing & submission functionality) -->
                <div class="text-center mt-4 pt-2">
                    <button type="button" @click="reviewsOpen = !reviewsOpen"
                        class="bg-transparent border-0 font-sans d-inline-flex align-items-center gap-2 p-0"
                        style="font-size: 12px; letter-spacing: 0.05em; text-decoration: underline; text-underline-offset: 4px; cursor: pointer; color: #541B29;"
                        aria-label="Toggle Patron Reviews">
                        <i class="fas fa-star" style="font-size: 10px; color: #9E7D3B;"></i>
                        <span
                            x-text="reviewsOpen ? 'Close Patron Reviews' : 'Read & Write Patron Reviews ({{ $product->reviews_count ?: 48 }})'">Read
                            & Write Patron Reviews ({{ $product->reviews_count ?: 48 }})</span>
                        <i class="fas fa-chevron-down transition" :style="reviewsOpen ? 'transform: rotate(180deg);' : ''"
                            style="font-size: 9px;"></i>
                    </button>
                </div>

                <!-- Collapsible Reviews Section -->
                <div x-show="reviewsOpen" x-cloak class="mt-5 pt-4" style="border-top: 1px solid #E8E0DA;">
                    <div class="d-flex flex-column gap-4">
                        <!-- Submit Review Form -->
                        <div class="p-4 p-md-5 rounded-4 d-flex flex-column gap-3.5 shadow-sm"
                            style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                            <h4 class="font-hero fs-4 fw-normal mb-0" style="color: #211D1E;">Share Your Olfactory
                                Impression</h4>
                            <form action="{{ route('reviews.store', $product->id) }}" method="POST"
                                class="d-flex flex-column gap-3 font-sans">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12 col-md-4">
                                        <label class="d-block text-xs text-uppercase tracking-wider mb-1 fw-medium"
                                            style="color: #541B29;">Your Name *</label>
                                        <input type="text" name="customer_name" required placeholder="e.g. Tariq Mehmood"
                                            class="form-control"
                                            style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px; font-size: 0.85rem; padding: 10px 14px;">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="d-block text-xs text-uppercase tracking-wider mb-1 fw-medium"
                                            style="color: #541B29;">Your City in Pakistan *</label>
                                        <input type="text" name="customer_city" required placeholder="e.g. Lahore / Karachi"
                                            class="form-control"
                                            style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px; font-size: 0.85rem; padding: 10px 14px;">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="d-block text-xs text-uppercase tracking-wider mb-1 fw-medium"
                                            style="color: #541B29;">Rating *</label>
                                        <select name="rating" required class="form-select"
                                            style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px; font-size: 0.85rem; padding: 10px 14px;">
                                            <option value="5">5 Stars - Imperial Masterpiece</option>
                                            <option value="4">4 Stars - Highly Refined</option>
                                            <option value="3">3 Stars - Pleasant Formulation</option>
                                            <option value="2">2 Stars - Average</option>
                                            <option value="1">1 Star - Disappointed</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="d-block text-xs text-uppercase tracking-wider mb-1 fw-medium"
                                        style="color: #541B29;">Review Title</label>
                                    <input type="text" name="title"
                                        placeholder="e.g. Monumental sillage at an evening wedding" class="form-control"
                                        style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px; font-size: 0.85rem; padding: 10px 14px;">
                                </div>
                                <div>
                                    <label class="d-block text-xs text-uppercase tracking-wider mb-1 fw-medium"
                                        style="color: #541B29;">Your Review *</label>
                                    <textarea name="comment" required rows="3"
                                        placeholder="Share your experience regarding projection, longevity, and compliments received..."
                                        class="form-control"
                                        style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px; font-size: 0.85rem; padding: 10px 14px;"></textarea>
                                </div>
                                <button type="submit" class="align-self-start border-0 fw-semibold"
                                    style="background: linear-gradient(135deg, #a31838 0%, #780d24 50%, #4a0915 100%) !important; color: #FFFFFF; border-radius: 8px; padding: 12px 28px; font-size: 0.85rem; letter-spacing: 0.05em; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; border: none !important; outline: none !important; box-shadow: 0 4px 16px rgba(120, 13, 36, 0.35);">
                                    <span>Submit Verified Review</span>
                                    <i class="fas fa-arrow-right-long"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Existing Reviews List -->
                        <div class="d-flex flex-column gap-3 font-sans">
                            @forelse($product->reviews as $review)
                                <div class="rounded-3 d-flex flex-column shadow-sm"
                                    style="background-color: #FFFFFF; border: 1px solid #E8E0DA; border-radius: 14px; padding: 22px 20px;">
                                    <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                        <span class="fw-bold text-truncate"
                                            style="font-size: 0.98rem; color: #110D0E;">{{ $review->user_name }}</span>
                                        <div class="d-flex flex-shrink-0" style="font-size: 11px; color: #d49a3d; gap: 2px;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? '' : 'opacity-25' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="fw-semibold text-truncate mb-2.5 font-sans" style="font-size: 0.82rem; color: #8A4B59;">
                                        {{ $product->name }}
                                    </div>
                                    <p class="mb-0 font-sans" 
                                       style="color: #4A403A; font-size: 0.88rem; line-height: 1.65;">
                                        {{ $review->comment }}
                                    </p>
                                </div>
                            @empty
                                <p class="text-xs fst-italic text-center py-4 mb-0" style="color: #7A6F68;">Be the first
                                    connoisseur to review this masterpiece.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 6. Related Pairings Carousel / You May Also Like -->
        @if($relatedProducts->count() > 0)
            <section class="py-5 py-lg-6" style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA;">
                <div class="container px-3 px-lg-4">
                    <div class="text-center mx-auto mb-5" style="max-width: 560px;">
                        <span class="font-sans fw-semibold"
                            style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase; color: #541B29;">OLFACTORY
                            HARMONY</span>
                        <h3 class="font-hero mt-1 fw-normal mb-0"
                            style="font-size: clamp(1.8rem, 2.6vw, 2.3rem); color: #211D1E;">You May Also Like</h3>
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
                    <div class="pdp-sticky-price price-gradient-luxury" x-text="formattedPrice">{{ $product->formatted_effective_price }}</div>
                </div>

                <!-- Right Buttons: BUY NOW + ADD TO BAG -->
                <div class="pdp-sticky-actions">
                    <button type="button" @click="buyNow()" class="pdp-sticky-btn-buy" style="touch-action: manipulation; -webkit-tap-highlight-color: transparent; cursor: pointer;" aria-label="Buy Now Instantly">
                        <span>BUY NOW</span>
                    </button>
                    <button type="button" 
                        id="pdpStickyAddToCartBtn"
                        @click="addToCart($event.currentTarget)" 
                        class="pdp-sticky-btn-bag d-inline-flex align-items-center justify-content-center gap-1.5" 
                        style="touch-action: manipulation; -webkit-tap-highlight-color: transparent; cursor: pointer; min-height: 40px;"
                        aria-label="Add to Bag">
                        <i class="fas fa-cart-shopping text-white" style="font-size: 11.5px;" aria-hidden="true"></i>
                        <span>ADD TO BAG</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Global Thumbnail Image Switcher
            window.switchPdpImage = function(src, btn) {
                const master = document.getElementById('pdpMasterImage');
                const container = document.getElementById('pdpZoomContainer');
                if (master) {
                    master.style.transform = 'scale(1)';
                    master.style.transformOrigin = 'center center';
                    master.src = src;
                }
                if (container) {
                    container.classList.remove('is-zoomed');
                }
                document.querySelectorAll('.pdp-thumb-item').forEach(b => b.classList.remove('active'));
                if (btn) btn.classList.add('active');
            };

            // Smooth Precision Coordinate Zoom on Hover & Touch
            (function initPdpImageZoom() {
                const container = document.getElementById('pdpZoomContainer');
                const image = document.getElementById('pdpMasterImage');
                if (!container || !image) return;

                const ZOOM_SCALE = 2.25;
                let isZoomed = false;
                let rafId = null;

                function applyZoom(clientX, clientY) {
                    const rect = container.getBoundingClientRect();
                    if (!rect.width || !rect.height) return;

                    // Relative percentages inside container (0% to 100%)
                    const x = Math.max(0, Math.min(100, ((clientX - rect.left) / rect.width) * 100));
                    const y = Math.max(0, Math.min(100, ((clientY - rect.top) / rect.height) * 100));

                    if (rafId) cancelAnimationFrame(rafId);
                    rafId = requestAnimationFrame(() => {
                        image.style.transformOrigin = `${x.toFixed(2)}% ${y.toFixed(2)}%`;
                        image.style.transform = `scale(${ZOOM_SCALE})`;
                        container.classList.add('is-zoomed');
                        isZoomed = true;
                    });
                }

                function clearZoom() {
                    if (rafId) cancelAnimationFrame(rafId);
                    image.style.transform = 'scale(1)';
                    container.classList.remove('is-zoomed');
                    isZoomed = false;

                    setTimeout(() => {
                        if (!isZoomed) {
                            image.style.transformOrigin = 'center center';
                        }
                    }, 350);
                }

                // Desktop Mouse Events
                container.addEventListener('mouseenter', function (e) {
                    applyZoom(e.clientX, e.clientY);
                });

                container.addEventListener('mousemove', function (e) {
                    applyZoom(e.clientX, e.clientY);
                });

                container.addEventListener('mouseleave', function () {
                    clearZoom();
                });

                // Mobile / Touchscreen Events ("hath s hover kare / touch & pan")
                container.addEventListener('touchstart', function (e) {
                    if (e.touches && e.touches.length === 1) {
                        applyZoom(e.touches[0].clientX, e.touches[0].clientY);
                    }
                }, { passive: true });

                container.addEventListener('touchmove', function (e) {
                    if (e.touches && e.touches.length === 1) {
                        if (e.cancelable) {
                            e.preventDefault();
                        }
                        applyZoom(e.touches[0].clientX, e.touches[0].clientY);
                    }
                }, { passive: false });

                container.addEventListener('touchend', function () {
                    clearZoom();
                });

                container.addEventListener('touchcancel', function () {
                    clearZoom();
                });
            })();

            const relatedEl = document.querySelector('.related-products-swiper');
            if (relatedEl && typeof Swiper !== 'undefined') {
                if (relatedEl.swiper) {
                    relatedEl.swiper.destroy(true, true);
                }
                const relatedSwiper = new Swiper('.related-products-swiper', {
                    slidesPerView: 1.15,
                    spaceBetween: 12,
                    speed: 700,
                    loop: false,
                    rewind: true,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                    grabCursor: true,
                    resistance: true,
                    resistanceRatio: 0.75,
                    touchRatio: 1.15,
                    touchAngle: 45,
                    threshold: 4,
                    watchSlidesProgress: true,
                    watchOverflow: true,
                    centerInsufficientSlides: true,
                    observer: true,
                    observeParents: true,
                    observeSlideChildren: true,
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
                        340: { slidesPerView: 1.15, spaceBetween: 12 },
                        400: { slidesPerView: 1.35, spaceBetween: 14 },
                        480: { slidesPerView: 1.8, spaceBetween: 16 },
                        576: { slidesPerView: 2.2, spaceBetween: 18 },
                        768: { slidesPerView: 3, spaceBetween: 20 },
                        1024: { slidesPerView: 4, spaceBetween: 24 }
                    }
                });

                // Guarantee autoplay is actively running
                if (relatedSwiper && relatedSwiper.autoplay) {
                    relatedSwiper.autoplay.start();
                }
            }
        });
    </script>
@endpush