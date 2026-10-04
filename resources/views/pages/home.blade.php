@extends('layouts.app')

@section('title', 'Perfumes Collection | Luxury Extrait de Parfum Impressions Pakistan')
@section('meta_description', 'Discover hand-macerated Extrait de Parfum impressions inspired by iconic global niche fragrance houses. 35%-40% oil concentration, 14+ hours longevity, Cash on Delivery nationwide.')

@section('content')

<!-- 1. Hero Full-Screen Swiper Slider (Big Screen-Covering Luxury Banners) -->
<section class="hero-slider-section position-relative w-100 bg-theme-main overflow-hidden border-bottom border-gold-30" style="height: 88vh; min-height: 620px; max-height: 960px;">
    <div class="swiper hero-master-swiper w-100 h-100">
        <div class="swiper-wrapper">
            @forelse($heroSlides as $slide)
                <div class="swiper-slide position-relative w-100 h-100 d-flex align-items-center overflow-hidden">
                    <!-- Big Background Image Covering Whole Screen -->
                    <img 
                        src="{{ asset($slide->image) }}" 
                        alt="{{ $slide->title }}" 
                        onerror="this.onerror=null; this.src='{{ asset('assets/images/slides/hero_1.jpg') }}';" 
                        class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                    >

                    <!-- Cinematic Dark Wine & Velvet Gradient Overlay -->
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-overlay-hero z-1"></div>
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-wine-radial z-1 pointer-events-none"></div>

                    <!-- Top-Right Stamp Badge: Proudly Made in Pakistan -->
                    <div class="d-none d-md-flex position-absolute top-0 end-0 m-4 m-lg-5 z-2 align-items-center justify-content-center pointer-events-none">
                        <div class="rounded-circle border border-2 border-gold-80 bg-wine-dark backdrop-blur-md p-2 d-flex flex-column align-items-center justify-content-center text-center shadow-lg" style="width: 5.5rem; height: 5.5rem;">
                            <span class="fs-4 lh-1">🇵🇰</span>
                            <span class="fw-bold text-uppercase tracking-wider text-gold-soft mt-1 lh-sm" style="font-size: 8px;">PROUDLY MADE<br>IN PAKISTAN</span>
                        </div>
                    </div>

                    <!-- Slide Content Overlay -->
                    <div class="container px-3 px-md-4 px-lg-5 position-relative z-2 h-100 d-flex align-items-center">
                        <div class="py-5 text-start vstack gap-4" style="max-width: 48rem;">
                            
                            <!-- Winner / Category Badge -->
                            <div>
                                <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-wine-accent border border-gold-60 backdrop-blur-md text-gold-soft text-xs fw-semibold tracking-luxury text-uppercase shadow-sm">
                                    <i class="fas fa-award text-gold"></i>
                                    <span>{{ $slide->badge_text ?? 'WINNER FRAGRANCE OF THE YEAR 2026' }}</span>
                                </span>
                            </div>

                            <!-- Main Title (Cormorant Garamond Elegance) -->
                            <h1 class="font-serif text-ivory text-uppercase lh-1 fw-normal mb-0 drop-shadow-lg" style="font-size: clamp(2.5rem, 5.5vw, 4.5rem);">
                                {!! $slide->title !!}
                            </h1>

                            <!-- Subtitle / Tagline -->
                            <p class="font-serif fst-italic fs-5 text-gold-soft opacity-90 fw-light lh-base mb-0" style="max-width: 38rem;">
                                {{ $slide->subtitle ?? 'Experience it before everyone else does.' }}
                            </p>

                            <!-- Trust Indicators Row -->
                            <div class="d-flex flex-wrap align-items-center gap-4 pt-2 text-ivory">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-wine-accent border border-gold-40 d-flex align-items-center justify-content-center text-gold shadow-sm backdrop-blur-xs" style="width: 2.5rem; height: 2.5rem;">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs fw-bold text-uppercase tracking-wider text-ivory">14+ HOURS</div>
                                        <div class="text-muted-luxury text-uppercase tracking-widest fw-medium" style="font-size: 9px;">LONG LASTING</div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-wine-accent border border-gold-40 d-flex align-items-center justify-content-center text-gold shadow-sm backdrop-blur-xs" style="width: 2.5rem; height: 2.5rem;">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs fw-bold text-uppercase tracking-wider text-ivory">50,000+</div>
                                        <div class="text-muted-luxury text-uppercase tracking-widest fw-medium" style="font-size: 9px;">PATRONS ACROSS PAKISTAN</div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-wine-accent border border-gold-40 d-flex align-items-center justify-content-center text-gold shadow-sm backdrop-blur-xs" style="width: 2.5rem; height: 2.5rem;">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs fw-bold text-uppercase tracking-wider text-gold-bright">★ 4.9 / 5.0</div>
                                        <div class="text-muted-luxury text-uppercase tracking-widest fw-medium" style="font-size: 9px;">VERIFIED RATINGS</div>
                                    </div>
                                </div>
                            </div>

                            <!-- CTAs -->
                            <div class="d-flex flex-wrap align-items-center gap-3 pt-2">
                                <a href="{{ $slide->cta_url ?? route('collections.show', 'all') }}" 
                                   class="d-inline-flex align-items-center gap-3 px-4 py-3 rounded-pill btn-gold text-xs text-uppercase tracking-wider shadow-lg text-decoration-none">
                                    <span class="rounded-circle bg-theme-main text-gold d-flex align-items-center justify-center text-xs" style="width: 1.75rem; height: 1.75rem;">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                    <span>{{ $slide->cta_text ?? 'SHOP OUR TOP SELLERS' }}</span>
                                </a>

                                <a href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I am interested in ordering your flagship Extrait collection.') }}" 
                                   target="_blank" 
                                   class="d-inline-flex align-items-center gap-2 px-4 py-3 rounded-pill btn-whatsapp text-white fw-bold text-xs text-uppercase tracking-wider shadow-lg text-decoration-none">
                                    <i class="fab fa-whatsapp fs-5"></i>
                                    <span>1-CLICK ORDER (COD)</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="swiper-slide position-relative w-100 h-100 d-flex align-items-center justify-content-center bg-theme-main">
                    <img src="{{ asset('assets/images/slides/hero_1.jpg') }}" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-theme-main opacity-75"></div>
                    <div class="position-relative z-2 text-center text-ivory vstack gap-3">
                        <h1 class="font-serif fs-1 fw-medium text-uppercase gold-gradient-text">Perfumes Collection</h1>
                        <p class="fs-5 text-gold-soft">Luxury Extrait de Parfum Impressions</p>
                        <a href="{{ route('collections.show', 'all') }}" class="d-inline-block px-4 py-2 btn-gold rounded-pill text-xs text-decoration-none">Explore Catalog</a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Carousel Navigation Arrows & Pagination Dots -->
        <div class="swiper-button-prev luxury-swiper-prev shadow-lg"></div>
        <div class="swiper-button-next luxury-swiper-next shadow-lg"></div>
        <div class="swiper-pagination luxury-swiper-pagination pb-3"></div>
    </div>
</section>

<!-- 2. Value Proposition Ticker Bar (Royal Wine & Gold Ticker) -->
<section class="bg-gradient-wine-ticker text-ivory py-3 border-bottom border-gold-30 overflow-hidden shadow-sm">
    <div class="container px-3 px-lg-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 text-xs fw-semibold text-uppercase tracking-wider text-center text-md-start">
            <div class="d-flex align-items-center gap-2 mx-auto mx-md-0">
                <span class="text-gold">💎</span>
                <span>Premium Extrait de Parfum</span>
            </div>
            <div class="d-flex align-items-center gap-2 mx-auto mx-md-0">
                <span class="text-gold">🕯️</span>
                <span>Hand Crafted Candles</span>
            </div>
            <div class="d-flex align-items-center gap-2 mx-auto mx-md-0">
                <span class="text-gold">⌛</span>
                <span>Long Lasting for 14+ Hours</span>
            </div>
            <div class="d-flex align-items-center gap-2 mx-auto mx-md-0">
                <span class="text-gold">🚚</span>
                <span>Fast Nationwide Delivery Across Pakistan</span>
            </div>
            <div class="d-none d-lg-flex align-items-center gap-2">
                <span class="text-gold">🌿</span>
                <span>100% Vegan & Cruelty Free</span>
            </div>
            <div class="d-none d-xl-flex align-items-center gap-2">
                <span class="text-gold">🛡️</span>
                <span>Free of Harmful Chemicals</span>
            </div>
        </div>
    </div>
</section>

<!-- 3. Featured Collection with Category Filter Pills -->
<section class="py-5 bg-theme-main luxury-wine-bg border-bottom border-gold-20">
    <div class="container px-3 px-lg-4">
        
        <!-- Section Header -->
        <div class="text-center mx-auto mb-4" style="max-width: 42rem;">
            <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury" style="font-size: 11px;">CURATED FORMULATIONS</span>
            <h2 class="font-serif fs-2 fs-md-1 text-ivory fw-normal text-uppercase tracking-tight">
                Featured Collection
            </h2>
        </div>

        <!-- Filter Pills Bar -->
        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mb-5">
            <button type="button" class="btn bg-gradient-gold-pill text-theme-main px-4 py-2 rounded-3 text-xs fw-bold tracking-wider text-uppercase shadow-sm border-0">
                Featured Products
            </button>
            <a href="{{ route('collections.show', 'all') }}?sort=popular" class="btn border border-gold-30 bg-theme-card text-muted-luxury hover:text-gold px-4 py-2 rounded-3 text-xs fw-medium tracking-wider text-uppercase transition-smooth">
                Restocked
            </a>
            <a href="{{ route('collections.show', 'all') }}?sort=new" class="btn border border-gold-30 bg-theme-card text-muted-luxury hover:text-gold px-4 py-2 rounded-3 text-xs fw-medium tracking-wider text-uppercase transition-smooth">
                New Arrivals
            </a>
            <a href="{{ route('collections.show', 'all') }}?sort=bestseller" class="btn border border-gold-30 bg-theme-card text-muted-luxury hover:text-gold px-4 py-2 rounded-3 text-xs fw-medium tracking-wider text-uppercase transition-smooth">
                Best Sellers
            </a>
        </div>

        <!-- Featured Products Carousel (Swiper) -->
        <div class="swiper bestsellers-swiper">
            <div class="swiper-wrapper pb-4">
                @foreach($bestsellers as $bProduct)
                    <div class="swiper-slide h-auto">
                        <x-product-card :product="$bProduct" />
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination position-relative mt-3"></div>
        </div>

        <!-- View Full Collection CTA -->
        <div class="text-center mt-5">
            <a href="{{ route('collections.show', 'all') }}" class="btn-outline-gold px-4 py-2_5 rounded-3 text-xs text-uppercase tracking-widest d-inline-flex align-items-center gap-2">
                <span>View All Featured Fragrances</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

    </div>
</section>

<!-- 4. "Find Your Perfect Match" Section (3-Card Signature Layout) -->
<section class="py-5 bg-theme-dark border-bottom border-gold-20">
    <div class="container px-3 px-lg-4">
        
        <!-- Section Header -->
        <div class="text-center mx-auto mb-5" style="max-width: 48rem;">
            <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury" style="font-size: 11px;">EXPLORE CATEGORIES</span>
            <h2 class="font-serif fs-2 fs-md-1 text-ivory fw-normal text-uppercase tracking-tight">
                Find Your Perfect Match
            </h2>
            <p class="text-xs text-md-sm text-muted-luxury mt-2 lh-base fw-light mx-auto" style="max-width: 40rem;">
                Explore our curated Collections — From Special Blends to Privé Collection to Exclusif Collection to Signature Collection to Hand Poured Candles & High Quality Attar Oils. We offer unique handcrafted blends to rare bold scents, timeless classics and luxury attars at unbeatable prices.
            </p>
        </div>

        <!-- 3-Card Grid -->
        <div class="row g-4">
            
            <!-- Card 1: Signature Collection -->
            <div class="col-12 col-md-4">
                <a href="{{ route('collections.show', 'all') }}" class="position-relative rounded-4 overflow-hidden shadow-lg border border-gold-30 d-flex flex-column justify-content-between p-4 text-white text-decoration-none luxury-hover-card" style="min-height: 420px;">
                    <img src="{{ asset('assets/images/categories/collection_signature.jpg') }}" 
                         alt="Signature Collection" 
                         onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
                         class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-smooth">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-bottom-fade"></div>

                    <!-- Top Card Info -->
                    <div class="position-relative z-2 vstack gap-1">
                        <h3 class="font-serif fs-3 fw-medium text-uppercase lh-1 gold-gradient-text">
                            Signature<br><span class="fs-6 tracking-widest fw-normal text-gold-soft">COLLECTION</span>
                        </h3>
                        <p class="text-xs text-sub fw-light pt-2 lh-base" style="max-width: 20rem;">
                            Most loved and iconic designer scents with 14+ hours projection.
                        </p>
                    </div>

                    <!-- Bottom Discover Pill -->
                    <div class="position-relative z-2 pt-3">
                        <span class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-wine-dark text-gold-soft border border-gold-40 backdrop-blur-md text-xs fw-semibold text-uppercase tracking-wider shadow-sm">
                            <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                            <span>discover</span>
                        </span>
                    </div>
                </a>
            </div>

            <!-- Card 2: Candle Collection -->
            <div class="col-12 col-md-4">
                <a href="{{ route('collections.show', 'all') }}" class="position-relative rounded-4 overflow-hidden shadow-lg border border-gold-30 d-flex flex-column justify-content-between p-4 text-white text-decoration-none luxury-hover-card" style="min-height: 420px;">
                    <img src="{{ asset('assets/images/categories/collection_candles.jpg') }}" 
                         alt="Candle Collection" 
                         onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_spice_bomb.jpg') }}';"
                         class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-smooth">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-bottom-fade"></div>

                    <!-- Top Card Info -->
                    <div class="position-relative z-2 vstack gap-1">
                        <h3 class="font-serif fs-3 fw-medium text-uppercase lh-1 gold-gradient-text">
                            Candle<br><span class="fs-6 tracking-widest fw-normal text-gold-soft">COLLECTION</span>
                        </h3>
                        <p class="text-xs text-sub fw-light pt-2 lh-base" style="max-width: 20rem;">
                            Hand-poured artisanal soy wax to bring warmth and ambiance to your home.
                        </p>
                    </div>

                    <!-- Bottom Discover Pill -->
                    <div class="position-relative z-2 pt-3">
                        <span class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-wine-dark text-gold-soft border border-gold-40 backdrop-blur-md text-xs fw-semibold text-uppercase tracking-wider shadow-sm">
                            <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                            <span>discover</span>
                        </span>
                    </div>
                </a>
            </div>

            <!-- Card 3: Attar Collection -->
            <div class="col-12 col-md-4">
                <a href="{{ route('collections.show', 'all') }}" class="position-relative rounded-4 overflow-hidden shadow-lg border border-gold-30 d-flex flex-column justify-content-between p-4 text-white text-decoration-none luxury-hover-card" style="min-height: 420px;">
                    <img src="{{ asset('assets/images/categories/collection_attar.jpg') }}" 
                         alt="Attar Collection" 
                         onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_attar.jpg') }}';"
                         class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-smooth">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-bottom-fade"></div>

                    <!-- Top Card Info -->
                    <div class="position-relative z-2 vstack gap-1">
                        <h3 class="font-serif fs-3 fw-medium text-uppercase lh-1 gold-gradient-text">
                            Attar<br><span class="fs-6 tracking-widest fw-normal text-gold-soft">COLLECTION</span>
                        </h3>
                        <p class="text-xs text-sub fw-light pt-2 lh-base" style="max-width: 20rem;">
                            Where royal oriental tradition meets unadulterated luxury oils.
                        </p>
                    </div>

                    <!-- Bottom Discover Pill -->
                    <div class="position-relative z-2 pt-3">
                        <span class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-wine-dark text-gold-soft border border-gold-40 backdrop-blur-md text-xs fw-semibold text-uppercase tracking-wider shadow-sm">
                            <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                            <span>discover</span>
                        </span>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>

<!-- 5. Bundles & Discovery Coffrets -->
@if($bundles->count() > 0)
    <section class="py-5 bg-theme-main luxury-wine-bg border-bottom border-gold-20">
        <div class="container px-3 px-lg-4">
            <div class="text-center mx-auto mb-5" style="max-width: 42rem;">
                <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury" style="font-size: 11px;">CURATED COFFRETS & SIGNATURE PAIRINGS</span>
                <h2 class="font-serif fs-2 fs-md-1 text-ivory fw-normal text-uppercase tracking-tight">
                    Luxury Fragrance Bundles
                </h2>
                <p class="text-xs text-md-sm text-muted-luxury mt-2 fw-light">
                    Presented in custom gold-stamped coffrets. Enjoy up to 30% privileged savings across Pakistan.
                </p>
            </div>

            <div class="row g-4">
                @foreach($bundles as $bundle)
                    <div class="col-12 col-md-4">
                        <x-bundle-card :bundle="$bundle" />
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('bundles.index') }}" class="btn-outline-gold px-4 py-2_5 rounded-3 text-xs text-uppercase tracking-widest d-inline-flex align-items-center gap-2">
                    <i class="fas fa-gift text-gold"></i>
                    <span>VIEW ALL DISCOVERY BUNDLES & GIFT SETS</span>
                </a>
            </div>
        </div>
    </section>
@endif

<!-- 6. New Release Impressions Grid -->
<section class="py-5 bg-theme-dark border-bottom border-gold-20">
    <div class="container px-3 px-lg-4">
        <div class="text-center mx-auto mb-5" style="max-width: 42rem;">
            <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury" style="font-size: 11px;">FRESHLY MACERATED</span>
            <h2 class="font-serif fs-2 fs-md-1 text-ivory fw-normal text-uppercase tracking-tight">
                New Release Impressions
            </h2>
            <div class="bg-gradient-gold-pill mx-auto mt-2" style="width: 4rem; height: 2px;"></div>
        </div>

        <div class="row row-cols-2 row-cols-lg-4 g-3 g-md-4">
            @foreach($newArrivals as $nProduct)
                <div class="col">
                    <x-product-card :product="$nProduct" />
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 7. Why Choose Perfumes Collection? (Brand Heritage & Quality Guarantee) -->
<section class="py-5 bg-theme-main luxury-wine-bg border-bottom border-gold-20">
    <div class="container px-3 px-lg-4">
        <div class="text-center mx-auto mb-5" style="max-width: 48rem;">
            <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury" style="font-size: 11px;">THE PERFUMES COLLECTION PROMISE</span>
            <h2 class="font-serif fs-2 fs-md-1 text-ivory fw-normal text-uppercase tracking-tight">
                Why Discerning Fragrance Lovers Choose Us
            </h2>
            <p class="text-sm text-muted-luxury mt-2 lh-base fw-light">
                Standard commercial perfumes dilute formulations down to 10%–15% alcohol solutions. Perfumes Collection crafts pure Extrait de Parfum hand-macerated for 90 days specifically designed for Pakistan's climate.
            </p>
        </div>

        <div class="row g-4">
            <!-- Feature 1 -->
            <div class="col-12 col-md-4">
                <div class="p-4 p-md-5 rounded-4 bg-gradient-wine-card border border-gold-25 text-center vstack gap-3 luxury-hover-card h-100">
                    <div class="rounded-3 bg-wine-accent text-gold border border-gold-40 d-flex align-items-center justify-content-center fs-3 mx-auto shadow-sm" style="width: 4rem; height: 4rem;">
                        <i class="fas fa-droplet"></i>
                    </div>
                    <h3 class="font-serif fs-4 text-ivory fw-medium text-uppercase mb-0">35% - 40% Extrait Concentration</h3>
                    <p class="text-xs text-sm text-muted-luxury lh-base fw-light mb-0">
                        Nearly double the oil density of department store Eau de Parfum. Delivers monumental 14 to 18 hours longevity on skin and fabric without synthetic alcohol harshness.
                    </p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="col-12 col-md-4">
                <div class="p-4 p-md-5 rounded-4 bg-gradient-wine-card border border-gold-25 text-center vstack gap-3 luxury-hover-card h-100">
                    <div class="rounded-3 bg-wine-accent text-gold border border-gold-40 d-flex align-items-center justify-content-center fs-3 mx-auto shadow-sm" style="width: 4rem; height: 4rem;">
                        <i class="fas fa-flask"></i>
                    </div>
                    <h3 class="font-serif fs-4 text-ivory fw-medium text-uppercase mb-0">Grasse French Fragrance Oils</h3>
                    <p class="text-xs text-sm text-muted-luxury lh-base fw-light mb-0">
                        We formulate exclusively with premium French grade oils and natural agarwood distillations, resulting in a 95%+ olfactory fidelity to the world's most coveted niche fragrances.
                    </p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="col-12 col-md-4">
                <div class="p-4 p-md-5 rounded-4 bg-gradient-wine-card border border-gold-25 text-center vstack gap-3 luxury-hover-card h-100">
                    <div class="rounded-3 bg-wine-accent text-gold border border-gold-40 d-flex align-items-center justify-content-center fs-3 mx-auto shadow-sm" style="width: 4rem; height: 4rem;">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <h3 class="font-serif fs-4 text-ivory fw-medium text-uppercase mb-0">Hassle-Free Pakistani Experience</h3>
                    <p class="text-xs text-sm text-muted-luxury lh-base fw-light mb-0">
                        Zero hassle Cash on Delivery nationwide, complimentary 24-48 hour TCS Express Air dispatch, and an unconditional 7-day scent exchange guarantee.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 8. Testimonials Section -->
@if($recentReviews->count() > 0)
    <section class="py-5 bg-theme-dark border-bottom border-gold-20">
        <div class="container px-3 px-lg-4">
            <div class="text-center mx-auto mb-5" style="max-width: 36rem;">
                <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury" style="font-size: 11px;">VERIFIED PATRON REVIEWS</span>
                <h2 class="font-serif fs-2 fs-md-1 text-ivory fw-normal text-uppercase tracking-tight">
                    50,000+ Satisfied Customers
                </h2>
            </div>

            <div class="row g-4">
                @foreach($recentReviews as $rev)
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="bg-gradient-wine-card border border-gold-25 rounded-4 p-4 d-flex flex-column justify-content-between shadow-sm h-100 luxury-hover-card">
                            <div class="vstack gap-2">
                                <div class="d-flex text-gold text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $rev->rating ? '' : 'text-muted-luxury opacity-25' }}"></i>
                                    @endfor
                                </div>
                                <h4 class="font-serif fs-5 text-gold-soft fw-medium mb-0">{{ $rev->review_title ?? 'Majestic Longevity' }}</h4>
                                <p class="text-xs text-sub lh-base fst-italic fw-light mb-0">
                                    "{{ $rev->comment }}"
                                </p>
                            </div>
                            <div class="mt-4 pt-3 border-top border-gold-15 d-flex align-items-center justify-content-between" style="font-size: 11px;">
                                <div>
                                    <span class="fw-semibold text-ivory d-block">{{ $rev->user_name }}</span>
                                    <span class="text-success" style="font-size: 10px;"><i class="fas fa-check-circle"></i> Verified &bull; {{ $rev->user_city ?? 'Pakistan' }}</span>
                                </div>
                                <span class="text-light-luxury" style="font-size: 10px;">{{ $rev->product->name ?? 'Extrait' }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- 9. Fragrance Journal Preview -->
@if($recentBlogs->count() > 0)
    <section class="py-5 bg-theme-main luxury-wine-bg">
        <div class="container px-3 px-lg-4">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4 pb-3 border-bottom border-gold-20">
                <div>
                    <span class="d-block text-gold mb-1 fw-semibold text-uppercase tracking-luxury" style="font-size: 11px;">FRAGRANCE JOURNAL</span>
                    <h2 class="font-serif fs-3 fs-md-2 text-ivory fw-normal text-uppercase mb-0">Olfactory Chronicles & Guides</h2>
                </div>
                <a href="{{ route('blogs.index') }}" class="mt-3 mt-md-0 text-xs text-uppercase tracking-widest text-gold hover:text-gold-soft fw-bold d-flex align-items-center gap-2 text-decoration-none transition-smooth">
                    <span>Read All Articles</span>
                    <i class="fas fa-arrow-right" style="font-size: 11px;"></i>
                </a>
            </div>

            <div class="row g-4">
                @foreach($recentBlogs as $hBlog)
                    <div class="col-12 col-md-4">
                        <article class="bg-gradient-wine-card border border-gold-25 rounded-4 overflow-hidden d-flex flex-column justify-content-between luxury-hover-card h-100">
                            <div class="overflow-hidden bg-theme-secondary" style="height: 12rem;">
                                <img src="{{ asset($hBlog->cover_image ?? 'assets/images/perfumes/prod_oud_royale.jpg') }}" 
                                     alt="{{ $hBlog->title }}" 
                                     onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
                                     class="w-100 h-100 object-fit-cover transition-smooth">
                            </div>
                            <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between vstack gap-3">
                                <div>
                                    <span class="d-block text-gold mb-1 fw-semibold text-uppercase tracking-wider" style="font-size: 10px;">{{ $hBlog->category_name ?? 'Haute Parfumerie' }}</span>
                                    <h3 class="font-serif fs-5 text-ivory fw-medium lh-sm mb-0">
                                        <a href="{{ route('blogs.show', $hBlog->slug) }}" class="text-ivory text-decoration-none">{{ $hBlog->title }}</a>
                                    </h3>
                                </div>
                                <div class="text-muted-luxury pt-3 border-top border-gold-15 d-flex justify-content-between align-items-center" style="font-size: 11px;">
                                    <span>{{ $hBlog->published_at ? \Carbon\Carbon::parse($hBlog->published_at)->format('M d, Y') : 'Recent' }}</span>
                                    <span class="text-gold fw-semibold">Read Guide &rarr;</span>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hero Swiper Slider with Ken Burns Autoplay
        new Swiper('.hero-master-swiper', {
            loop: true,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            speed: 900,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        // Bestsellers Carousel Swiper
        new Swiper('.bestsellers-swiper', {
            slidesPerView: 2,
            spaceBetween: 14,
            loop: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 16 },
                768: { slidesPerView: 3, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 24 }
            }
        });
    });
</script>
@endpush
