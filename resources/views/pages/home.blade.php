@extends('layouts.app')

@section('title', 'Perfumes Collection | Luxury Extrait de Parfum Impressions Pakistan')
@section('meta_description', 'Discover hand-macerated Extrait de Parfum impressions inspired by iconic global niche fragrance houses. 35%-40% oil concentration, 14+ hours longevity, Cash on Delivery nationwide.')

@section('content')

    <!-- 1. Hero Full-Screen Swiper Slider (Collidez Cuisine Haute Parfumerie Style) -->
    <section class="hero-slider-section position-relative w-100 overflow-hidden" style="border-bottom: 1px solid #E8E0DA;">
        <div class="swiper hero-master-swiper w-100 h-100">
            <div class="swiper-wrapper">
                @forelse($heroSlides as $slideIndex => $slide)
                    <div class="swiper-slide position-relative w-100 h-100 overflow-hidden">
                        <!-- Zooming Background Media -->
                        <div class="hero__media">
                            <div class="hero__zoom">
                                <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}"
                                    onerror="this.onerror=null; this.src='{{ asset('assets/images/slides/hero_1.jpg') }}';"
                                    class="w-100 h-100 object-fit-cover">
                            </div>
                        </div>

                        <!-- Cinematic Vignette Shade Overlay -->
                        <div class="hero__shade" aria-hidden="true"></div>

                        <!-- Collidez Hero Content Overlay -->
                        <div class="hero__content">
                            <!-- Delicate Eyebrow / Kicker -->
                            <p class="hero__kicker">
                                <span>✦</span>
                                <span>{{ $slide->badge_text ?? 'HAUTE PARFUMERIE • EXTRAIT DE PARFUM' }}</span>
                            </p>

                            <!-- Monumental Typography Title -->
                            <h1 class="hero__title font-hero">
                                {!! $slide->title !!}
                            </h1>

                            <!-- Statement Subtitle -->
                            <p class="hero__statement font-sans">
                                {{ $slide->subtitle ?? 'Hand-crafted with 40% Extrait de Parfum concentration for beast-mode longevity across Pakistan.' }}
                            </p>

                            <!-- Stadium Rolling-Text Action Pills -->
                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-3 mt-2">
                                <a href="{{ $slide->cta_url ?? route('collections.show', 'all') }}"
                                    class="collidez-pill collidez-pill--gold">
                                    <span class="collidez-roll">
                                        <span class="collidez-roll__a">{{ $slide->cta_text ?? 'DISCOVER COLLECTION' }}</span>
                                        <span class="collidez-roll__b"
                                            aria-hidden="true">{{ $slide->cta_text ?? 'DISCOVER COLLECTION' }}</span>
                                    </span>
                                </a>
                                @if(!empty($slide->secondary_cta_url))
                                    <a href="{{ $slide->secondary_cta_url }}" class="collidez-pill collidez-pill--outline">
                                        <span class="collidez-roll">
                                            <span
                                                class="collidez-roll__a">{{ $slide->secondary_cta_text ?? 'EXPLORE VAULT' }}</span>
                                            <span class="collidez-roll__b"
                                                aria-hidden="true">{{ $slide->secondary_cta_text ?? 'EXPLORE VAULT' }}</span>
                                        </span>
                                    </a>
                                @else
                                    <a href="{{ route('collections.show', 'all') }}" class="collidez-pill collidez-pill--outline">
                                        <span class="collidez-roll">
                                            <span class="collidez-roll__a">EXPLORE VAULT</span>
                                            <span class="collidez-roll__b" aria-hidden="true">EXPLORE VAULT</span>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide position-relative w-100 h-100 overflow-hidden">
                        <div class="hero__media">
                            <div class="hero__zoom">
                                <img src="{{ asset('assets/images/slides/hero_1.jpg') }}" class="w-100 h-100 object-fit-cover">
                            </div>
                        </div>
                        <div class="hero__shade" aria-hidden="true"></div>
                        <div class="hero__content">
                            <p class="hero__kicker">✦ &nbsp;AUTHENTIC LUXURY IMPRESSIONS</p>
                            <h1 class="hero__title font-hero">PERFUMES COLLECTION</h1>
                            <p class="hero__statement font-sans">Luxury Extrait de Parfum Impressions inspired by global niche
                                fragrance houses.</p>
                            <a href="{{ route('collections.show', 'all') }}" class="collidez-pill collidez-pill--gold">
                                <span class="collidez-roll">
                                    <span class="collidez-roll__a">EXPLORE CATALOG</span>
                                    <span class="collidez-roll__b" aria-hidden="true">EXPLORE CATALOG</span>
                                </span>
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Collidez Minimalist Circular Arrow Controls -->
            <button type="button" class="collidez-hero-arrow collidez-hero-arrow--prev hero-prev-btn"
                aria-label="Previous Slide">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 12h15M13 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="1.6"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>
            <button type="button" class="collidez-hero-arrow collidez-hero-arrow--next hero-next-btn"
                aria-label="Next Slide">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 12h15M13 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="1.6"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>

            <!-- Collidez Bottom Scroll Cue Indicator -->
            <div class="hero__foot d-none d-sm-flex" aria-hidden="true">
                <span>SCROLL</span>
                <span class="hero__line"></span>
            </div>

            <!-- Collidez Slide Counter & Timeline Meter -->
            <div class="hero__meter d-none d-md-flex" aria-hidden="true">
                <div class="hero__counter">
                    <span class="hero__counter-current">01</span>
                    <i>/</i>
                    <span class="hero__counter-total">{{ sprintf('%02d', max(1, count($heroSlides))) }}</span>
                </div>
                <div class="hero__progress-bar">
                    <span class="hero__progress-bar-fill"></span>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Value Proposition Ticker Bar (Substantial Royal Wine & Gold Marquee Ticker) -->
    <section class="luxury-marquee-section">
        <div class="w-100 overflow-hidden">
            <marquee behavior="scroll" direction="left" scrollamount="6" onmouseover="this.stop();"
                onmouseout="this.start();">
                <span class="luxury-marquee-item">
                    <i class="fas fa-crown"></i>
                    <span>Premium Extrait de Parfum</span>
                </span>
                <span class="luxury-marquee-sep">✦</span>
                <span class="luxury-marquee-item">
                    <i class="fas fa-gem"></i>
                    <span>Private Reserve Formulations</span>
                </span>
                <span class="luxury-marquee-sep">✦</span>
                <span class="luxury-marquee-item">
                    <i class="fas fa-hourglass-half"></i>
                    <span>Long Lasting for 14+ Hours</span>
                </span>
                <span class="luxury-marquee-sep">✦</span>
                <span class="luxury-marquee-item">
                    <i class="fas fa-truck-fast"></i>
                    <span>Fast Nationwide Delivery Across Pakistan</span>
                </span>
                <span class="luxury-marquee-sep">✦</span>
                <span class="luxury-marquee-item">
                    <i class="fas fa-leaf"></i>
                    <span>100% Vegan & Cruelty Free</span>
                </span>
                <span class="luxury-marquee-sep">✦</span>
                <span class="luxury-marquee-item">
                    <i class="fas fa-shield-halved"></i>
                    <span>Free of Harmful Chemicals</span>
                </span>
                <span class="luxury-marquee-sep">✦</span>
                <!-- Seamless loop repeat -->
                <span class="luxury-marquee-item">
                    <i class="fas fa-crown"></i>
                    <span>Premium Extrait de Parfum</span>
                </span>
                <span class="luxury-marquee-sep">✦</span>
                <span class="luxury-marquee-item">
                    <i class="fas fa-gem"></i>
                    <span>Private Reserve Formulations</span>
                </span>
                <span class="luxury-marquee-sep">✦</span>
                <span class="luxury-marquee-item">
                    <i class="fas fa-hourglass-half"></i>
                    <span>Long Lasting for 14+ Hours</span>
                </span>
                <span class="luxury-marquee-sep">✦</span>
                <span class="luxury-marquee-item">
                    <i class="fas fa-truck-fast"></i>
                    <span>Fast Nationwide Delivery Across Pakistan</span>
                </span>
                <span class="luxury-marquee-sep">✦</span>
                <span class="luxury-marquee-item">
                    <i class="fas fa-leaf"></i>
                    <span>100% Vegan & Cruelty Free</span>
                </span>
                <span class="luxury-marquee-sep">✦</span>
                <span class="luxury-marquee-item">
                    <i class="fas fa-shield-halved"></i>
                    <span>Free of Harmful Chemicals</span>
                </span>
            </marquee>
        </div>
    </section>

    <!-- 3. Featured Collection -->
    <section class="py-5 border-bottom" style="background-color: #F7F3EE !important; border-color: #E8E0DA !important;">
        <div class="container px-3 px-lg-4">

            <!-- Section Header (Centered) -->
            <div class="text-center mx-auto mb-4" style="max-width: 42rem;">
                <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury"
                    style="font-size: 11px;">CURATED FORMULATIONS</span>
                <h2 class="font-serif fs-2 fs-md-1 fw-normal text-uppercase tracking-tight" style="color: #211D1E !important;">
                    Featured Collection
                </h2>
            </div>

            <!-- Featured Products Carousel (Swiper) -->
            <div class="position-relative">
                <div class="swiper featured-swiper">
                    <div class="swiper-wrapper pb-4">
                        @foreach($featuredProducts as $fProduct)
                            <div class="swiper-slide h-auto">
                                <x-product-card :product="$fProduct" />
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination featured-pagination position-relative mt-3"></div>
                </div>
                <!-- Desktop Luxury Navigation Controls -->
                <div class="swiper-button-prev featured-prev luxury-swiper-prev d-none d-lg-flex"></div>
                <div class="swiper-button-next featured-next luxury-swiper-next d-none d-lg-flex"></div>
            </div>

            <!-- View Full Collection CTA -->
            <div class="text-center mt-4 mt-lg-5">
                <a href="{{ route('collections.show', 'all') }}" class="btn-outline-gold px-4 py-3" style="background-color: #FFFFFF !important; color: #541B29 !important; border: 1px solid #E8E0DA !important; border-radius: 8px; text-decoration: none;">
                    <span>View Featured Fragrances</span>
                </a>
            </div>

        </div>
    </section>

    <!-- 4. "Find Your Perfect Match" Section (3-Card Signature Layout) -->
    <section class="py-5 border-bottom" style="background-color: #FFFFFF !important; border-color: #E8E0DA !important;">
        <div class="container px-3 px-lg-4">

            <!-- Section Header -->
            <div class="text-center mx-auto mb-5" style="max-width: 48rem;">
                <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury"
                    style="font-size: 11px;">EXPLORE CATEGORIES</span>
                <h2 class="font-serif fs-2 fs-md-1 fw-normal text-uppercase tracking-tight" style="color: #211D1E !important;">
                    Find Your Perfect Match
                </h2>
                <p class="text-xs text-md-sm mt-2 lh-base fw-light mx-auto" style="max-width: 40rem; color: #6B605B;">
                    Explore our curated Collections — From Special Blends to Privé Collection to Exclusif Collection to
                    Signature Collection. We offer unique handcrafted blends to rare bold scents and timeless classics at unbeatable prices.
                </p>
            </div>

            <!-- 3-Card Grid -->
            <div class="row g-4">

                <!-- Card 1: Signature Collection -->
                <div class="col-12 col-md-4">
                    <a href="{{ route('collections.show', 'all') }}"
                        class="position-relative rounded-4 overflow-hidden shadow-sm d-flex flex-column justify-content-between p-4 text-white text-decoration-none luxury-hover-card"
                        style="min-height: 420px; border: 1px solid #E8E0DA;">
                        <img src="{{ asset('assets/images/categories/collection_signature.jpg') }}"
                            alt="Signature Collection"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-smooth">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(33, 29, 30, 0.2) 0%, rgba(33, 29, 30, 0.75) 100%);"></div>

                        <!-- Top Card Info -->
                        <div class="position-relative z-2 vstack gap-1">
                            <h3 class="font-serif fs-3 fw-medium text-uppercase lh-1 text-white">
                                Signature<br><span class="fs-6 tracking-widest fw-normal text-white-50">COLLECTION</span>
                            </h3>
                            <p class="text-xs text-white-75 fw-light pt-2 lh-base" style="max-width: 20rem;">
                                Most loved and iconic designer scents with 14+ hours projection.
                            </p>
                        </div>

                        <!-- Bottom Discover Pill -->
                        <div class="position-relative z-2 pt-3">
                            <span
                                class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3 text-white text-xs fw-semibold text-uppercase tracking-wider shadow-sm"
                                style="background-color: #541B29 !important;">
                                <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                                <span>discover</span>
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Card 2: Men's Collection -->
                <div class="col-12 col-md-4">
                    <a href="{{ route('collections.show', 'men') }}"
                        class="position-relative rounded-4 overflow-hidden shadow-sm d-flex flex-column justify-content-between p-4 text-white text-decoration-none luxury-hover-card"
                        style="min-height: 420px; border: 1px solid #E8E0DA;">
                        <img src="{{ asset('assets/images/perfumes/prod_spice_bomb.jpg') }}" alt="Men's Collection"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_leather_smoke.jpg') }}';"
                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-smooth">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(33, 29, 30, 0.2) 0%, rgba(33, 29, 30, 0.75) 100%);"></div>

                        <!-- Top Card Info -->
                        <div class="position-relative z-2 vstack gap-1">
                            <h3 class="font-serif fs-3 fw-medium text-uppercase lh-1 text-white">
                                Men's<br><span class="fs-6 tracking-widest fw-normal text-white-50">COLLECTION</span>
                            </h3>
                            <p class="text-xs text-white-75 fw-light pt-2 lh-base" style="max-width: 20rem;">
                                Bold, magnetic, and commanding masculine fragrance profiles with extraordinary sillage.
                            </p>
                        </div>

                        <!-- Bottom Discover Pill -->
                        <div class="position-relative z-2 pt-3">
                            <span
                                class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3 text-white text-xs fw-semibold text-uppercase tracking-wider shadow-sm"
                                style="background-color: #541B29 !important;">
                                <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                                <span>discover</span>
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Card 3: Women's Collection -->
                <div class="col-12 col-md-4">
                    <a href="{{ route('collections.show', 'women') }}"
                        class="position-relative rounded-4 overflow-hidden shadow-sm d-flex flex-column justify-content-between p-4 text-white text-decoration-none luxury-hover-card"
                        style="min-height: 420px; border: 1px solid #E8E0DA;">
                        <img src="{{ asset('assets/images/perfumes/prod_rose_oud.jpg') }}" alt="Women's Collection"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_eclair_caramel.jpg') }}';"
                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-smooth">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(33, 29, 30, 0.2) 0%, rgba(33, 29, 30, 0.75) 100%);"></div>

                        <!-- Top Card Info -->
                        <div class="position-relative z-2 vstack gap-1">
                            <h3 class="font-serif fs-3 fw-medium text-uppercase lh-1 text-white">
                                Women's<br><span class="fs-6 tracking-widest fw-normal text-white-50">COLLECTION</span>
                            </h3>
                            <p class="text-xs text-white-75 fw-light pt-2 lh-base" style="max-width: 20rem;">
                                Graceful florals, seductive gourmands, and luminous feminine scents.
                            </p>
                        </div>

                        <!-- Bottom Discover Pill -->
                        <div class="position-relative z-2 pt-3">
                            <span
                                class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3 text-white text-xs fw-semibold text-uppercase tracking-wider shadow-sm"
                                style="background-color: #541B29 !important;">
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
        <section class="py-5 border-bottom" style="background-color: #F7F3EE !important; border-color: #E8E0DA !important;">
            <div class="container px-3 px-lg-4">
                <div class="text-center mx-auto mb-5" style="max-width: 42rem;">
                    <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury"
                        style="font-size: 11px;">CURATED COFFRETS & SIGNATURE PAIRINGS</span>
                    <h2 class="font-serif fs-2 fs-md-1 fw-normal text-uppercase tracking-tight" style="color: #211D1E !important;">
                        Luxury Fragrance Bundles
                    </h2>
                    <p class="text-xs text-md-sm mt-2 fw-light" style="color: #6B605B;">
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
                    <a href="{{ route('bundles.index') }}" class="btn-outline-gold px-4 py-3" style="background-color: #FFFFFF !important; color: #541B29 !important; border: 1px solid #E8E0DA !important; border-radius: 8px; text-decoration: none;">
                        <span>VIEW ALL DISCOVERY BUNDLES & GIFT SETS</span>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- 6. New Release Impressions Carousel (Swiper) -->
    <section class="py-5 border-bottom" style="background-color: #FFFFFF !important; border-color: #E8E0DA !important;">
        <div class="container px-3 px-lg-4">
            <div class="text-center mx-auto mb-4" style="max-width: 42rem;">
                <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury"
                    style="font-size: 11px;">FRESHLY MACERATED</span>
                <h2 class="font-serif fs-2 fs-md-1 fw-normal text-uppercase tracking-tight" style="color: #211D1E !important;">
                    New Release Impressions
                </h2>
                <div class="mx-auto mt-2" style="width: 4rem; height: 2px; background-color: #9E7D3B;"></div>
            </div>

            <!-- New Releases Carousel (Swiper) -->
            <div class="position-relative">
                <div class="swiper newarrivals-swiper">
                    <div class="swiper-wrapper pb-4">
                        @foreach($newArrivals as $nProduct)
                            <div class="swiper-slide h-auto">
                                <x-product-card :product="$nProduct" />
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination newarrivals-swiper-pagination position-relative mt-3"></div>
                </div>
                <!-- Desktop Luxury Navigation Controls -->
                <div class="swiper-button-prev newarrivals-prev luxury-swiper-prev d-none d-lg-flex"></div>
                <div class="swiper-button-next newarrivals-next luxury-swiper-next d-none d-lg-flex"></div>
            </div>

            <!-- View All New Releases CTA -->
            <div class="text-center mt-4 mt-lg-5">
                <a href="{{ route('collections.show', 'all') }}?sort=new" class="btn-outline-gold px-4 py-3" style="background-color: #FFFFFF !important; color: #541B29 !important; border: 1px solid #E8E0DA !important; border-radius: 8px; text-decoration: none;">
                    <span>Explore All New Arrivals</span>
                </a>
            </div>
        </div>
    </section>

    <!-- 7. Why Choose Perfumes Collection? (Brand Heritage & Quality Guarantee) -->
    <section class="py-5 border-bottom" style="background-color: #F7F3EE !important; border-color: #E8E0DA !important;">
        <div class="container px-3 px-lg-4">
            <div class="text-center mx-auto mb-5" style="max-width: 48rem;">
                <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury" style="font-size: 11px;">THE
                    PERFUMES COLLECTION PROMISE</span>
                <h2 class="font-serif fs-2 fs-md-1 fw-normal text-uppercase tracking-tight" style="color: #211D1E !important;">
                    Why Discerning Fragrance Lovers Choose Us
                </h2>
                <p class="text-sm mt-2 lh-base fw-light" style="color: #6B605B;">
                    Standard commercial perfumes dilute formulations down to 10%–15% alcohol solutions. Perfumes Collection
                    crafts pure Extrait de Parfum hand-macerated for 90 days specifically designed for Pakistan's climate.
                </p>
            </div>

            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-12 col-md-4">
                    <div
                        class="p-4 p-md-5 rounded-4 text-center vstack gap-3 luxury-hover-card h-100" style="background-color: #FFFFFF !important; border: 1px solid #E8E0DA !important; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                        <div class="rounded-3 d-flex align-items-center justify-content-center fs-3 mx-auto shadow-sm"
                            style="width: 4rem; height: 4rem; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                            <i class="fas fa-droplet"></i>
                        </div>
                        <h3 class="font-serif fs-4 fw-medium text-uppercase mb-0" style="color: #211D1E !important;">35% - 40% Extrait Concentration
                        </h3>
                        <p class="text-xs text-sm lh-base fw-light mb-0" style="color: #6B605B;">
                            Nearly double the oil density of department store Eau de Parfum. Delivers monumental 14 to 18
                            hours longevity on skin and fabric without synthetic alcohol harshness.
                        </p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-12 col-md-4">
                    <div
                        class="p-4 p-md-5 rounded-4 text-center vstack gap-3 luxury-hover-card h-100" style="background-color: #FFFFFF !important; border: 1px solid #E8E0DA !important; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                        <div class="rounded-3 d-flex align-items-center justify-content-center fs-3 mx-auto shadow-sm"
                            style="width: 4rem; height: 4rem; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h3 class="font-serif fs-4 fw-medium text-uppercase mb-0" style="color: #211D1E !important;">Grasse French Fragrance Oils
                        </h3>
                        <p class="text-xs text-sm lh-base fw-light mb-0" style="color: #6B605B;">
                            We formulate exclusively with premium French grade oils and natural agarwood distillations,
                            resulting in a 95%+ olfactory fidelity to the world's most coveted niche fragrances.
                        </p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-12 col-md-4">
                    <div
                        class="p-4 p-md-5 rounded-4 text-center vstack gap-3 luxury-hover-card h-100" style="background-color: #FFFFFF !important; border: 1px solid #E8E0DA !important; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                        <div class="rounded-3 d-flex align-items-center justify-content-center fs-3 mx-auto shadow-sm"
                            style="width: 4rem; height: 4rem; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <h3 class="font-serif fs-4 fw-medium text-uppercase mb-0" style="color: #211D1E !important;">Hassle-Free Pakistani Experience</h3>
                        <p class="text-xs text-sm lh-base fw-light mb-0" style="color: #6B605B;">
                            Zero hassle Cash on Delivery nationwide, complimentary 24-48 hour TCS Express Air dispatch, and
                            an unconditional 7-day scent exchange guarantee.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. Testimonials Section (Haute Parfumerie Patron Reviews) -->
    @if($recentReviews->count() > 0)
        <section class="py-5 position-relative overflow-hidden" style="background-color: #FAF7F2; border-bottom: 1px solid #E8E0DA;">
            <div class="container px-3 px-lg-4 position-relative" style="z-index: 1;">
                <!-- Centered Header with Trust Signals -->
                <div class="text-center mx-auto mb-4 pb-2" style="max-width: 44rem;">
                    <div class="d-inline-flex align-items-center justify-content-center gap-2 mb-2 fw-semibold text-uppercase tracking-luxury"
                         style="font-size: 11px; letter-spacing: 2px; color: #541B29;">
                        <span>VERIFIED PATRON IMPRESSIONS</span>
                    </div>
                    <h2 class="font-serif fs-2 fs-md-1 fw-normal text-uppercase tracking-tight mb-2" style="color: #211D1E !important;">
                        Voices of Our Connoisseurs
                    </h2>
                    <div class="d-flex align-items-center justify-content-center flex-wrap gap-2 text-xs" style="color: #6B605B;">
                        <span class="d-inline-flex align-items-center" style="color: #9E7D3B;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="fw-semibold ms-1.5" style="font-size: 12px; color: #211D1E;">4.98 / 5.0</span>
                        </span>
                        <span style="color: #E8E0DA;">&bull;</span>
                        <span style="color: #6B605B;">Based on 1,850+ Verified Deliveries Across Pakistan</span>
                    </div>
                </div>

                <!-- Testimonials Swiper Carousel with Start & Last Card Navigation -->
                <div class="position-relative px-3 px-sm-4 px-md-4 px-lg-5">
                    <div class="swiper testimonials-swiper pt-3 pb-4" style="padding-top: 16px !important; margin-top: -12px;">
                        <div class="swiper-wrapper">
                            @foreach($recentReviews as $rev)
                                <div class="swiper-slide h-auto">
                                    <div class="rounded-4 p-3 p-sm-4 d-flex flex-column justify-content-between shadow-sm h-100 luxury-hover-card"
                                         style="background: #FFFFFF; border: 1px solid #E8E0DA;">
                                        
                                        <div class="vstack gap-2">
                                            <!-- Reviewer Header (Name, City & Rating Stars) -->
                                            <div class="d-flex align-items-center justify-content-between gap-2">
                                                <div>
                                                    <span class="fw-semibold d-block" style="font-size: 0.95rem; letter-spacing: 0.2px; color: #211D1E !important;">
                                                        {{ $rev->user_name }}
                                                    </span>
                                                    <span class="d-block" style="font-size: 11px; color: #6B605B;">
                                                        {{ $rev->user_city ?? 'Pakistan' }}
                                                    </span>
                                                </div>
                                                <div class="d-flex flex-shrink-0" style="font-size: 11px; color: #9E7D3B;">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $rev->rating ? '' : 'opacity-25' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>

                                            <!-- Review Title & Comment (No Quotes, 1.5 lines clamp) -->
                                            <div class="pt-1">
                                                <h4 class="font-serif fw-medium mb-1 text-truncate" style="font-size: 0.92rem; line-height: 1.35; color: #541B29 !important;">
                                                    {{ $rev->title ?? 'Remarkable Longevity' }}
                                                </h4>
                                                <p class="text-xs fw-light mb-0" 
                                                   style="color: #4A403A; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.45;">
                                                    {{ $rev->comment }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Bottom Product Tag (No Arrow Icon) -->
                                        <div class="mt-3 pt-2.5 d-flex align-items-center justify-content-between gap-2"
                                             style="font-size: 11px; border-top: 1px solid #E8E0DA;">
                                            @if($rev->product)
                                                <a href="{{ route('shop.products.show', $rev->product->slug) }}" 
                                                   class="d-flex align-items-center gap-2 text-decoration-none hover-text-gold transition-smooth overflow-hidden"
                                                   title="View {{ $rev->product->name }}"
                                                   style="color: #6B605B;">
                                                    <img src="{{ $rev->product->primary_image_url }}" 
                                                         alt="{{ $rev->product->name }}" 
                                                         class="rounded-2 object-fit-cover flex-shrink-0"
                                                         style="width: 26px; height: 26px; border: 1px solid #E8E0DA;"
                                                         onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';">
                                                    <span class="text-truncate fw-medium" style="font-size: 11px; color: #211D1E !important;">
                                                        {{ $rev->product->name }}
                                                    </span>
                                                </a>
                                            @else
                                                <span style="font-size: 11px; color: #6B605B;">Extrait de Parfum</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Luxury Navigation Controls on Start (Left) & Last (Right) -->
                    <div class="swiper-button-prev testimonials-prev luxury-swiper-prev d-flex" 
                         aria-label="Previous review"></div>
                    <div class="swiper-button-next testimonials-next luxury-swiper-next d-flex" 
                         aria-label="Next review"></div>

                    <!-- Pagination Dots -->
                    <div class="swiper-pagination testimonials-pagination position-relative mt-2 text-center"></div>
                </div>
            </div>
        </section>
    @endif

    <!-- 9. Fragrance Journal Preview -->
    @if($recentBlogs->count() > 0)
        <section class="py-5" style="background-color: #F7F3EE;">
            <div class="container px-3 px-lg-4">
                <!-- Centered Section Header -->
                <div class="text-center mx-auto mb-5 pb-1" style="max-width: 680px;">
                   <div class="d-inline-flex align-items-center justify-content-center gap-2 mb-2">
                        <span class="fw-semibold text-uppercase tracking-luxury" style="font-size: 11px; letter-spacing: 0.22em; color: #541B29;">FRAGRANCE JOURNAL</span>
                    </div>
                    <h2 class="font-serif fs-2 fs-md-1 fw-normal text-uppercase mb-2" style="letter-spacing: 0.04em; color: #211D1E !important;">
                        Olfactory Chronicles & Guides
                    </h2>
                    <p class="mb-0 font-sans" style="font-size: 0.92rem; line-height: 1.6; color: #6B605B;">
                        Master perfumery secrets, royal attar heritage of Lahore, and artisanal wear guides curated by our master noses.
                    </p>
                </div>

                <!-- 3 Royal Blog Cards -->
                <div class="row g-4 justify-content-center">
                    @foreach($recentBlogs as $hBlog)
                        @php
                            $categoryName = $hBlog->category ?? $hBlog->category_name ?? 'Haute Parfumerie';
                            $readTime = $hBlog->read_time ?? '5 Min Read';
                            $formattedDate = $hBlog->published_at ? \Carbon\Carbon::parse($hBlog->published_at)->format('M d, Y') : 'Recent Edition';
                            $author = $hBlog->author_name ?? 'Master Nose';
                        @endphp
                        <div class="col-12 col-md-6 col-lg-4">
                            <article class="position-relative luxury-hover-card rounded-4 overflow-hidden shadow-sm d-flex flex-column justify-content-between p-3 p-sm-3 h-100" style="background: #FFFFFF; border: 1px solid #E8E0DA;">
                                <!-- Image Pedestal Wrap -->
                                <div class="position-relative w-100 rounded-3 overflow-hidden mb-3" style="aspect-ratio: 16 / 10; min-height: 200px; background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                    <!-- Badges Row -->
                                    <div class="position-absolute top-0 start-0 m-2.5 z-2">
                                        <span class="fw-bold text-uppercase px-2 py-0-5 rounded-pill shadow-sm" style="font-size: 9.5px; letter-spacing: 0.12em; background-color: #541B29; color: #FFFFFF;">
                                            {{ $categoryName }}
                                        </span>
                                    </div>
                                    <div class="position-absolute top-0 end-0 m-2.5 z-2">
                                        <span class="px-2 py-0-5 rounded-pill" style="background-color: rgba(255,255,255,0.92); border: 1px solid #E8E0DA; font-size: 9.5px; color: #211D1E !important;">
                                            {{ $readTime }}
                                        </span>
                                    </div>
                                    <img src="{{ asset($hBlog->image) }}"
                                         alt="{{ $hBlog->title }}"
                                         loading="lazy"
                                         onerror="this.onerror=null; this.src='{{ asset('assets/images/blogs/blog_extrait_science.jpg') }}';"
                                         class="w-100 h-100 object-fit-cover transition-smooth"
                                         style="object-fit: cover; object-position: center;">
                                </div>

                                <!-- Content (Matching Product Card Body Layout) -->
                                <div class="d-flex flex-column flex-grow-1 justify-content-between px-1">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-2" style="font-size: 11px; color: #786C67;">
                                            <span>{{ $formattedDate }}</span>
                                            <span>&bull;</span>
                                            <span>By {{ Str::limit($author, 22) }}</span>
                                        </div>
                                        <h3 class="font-serif fs-5 fw-medium lh-sm mb-2" style="min-height: 2.8rem; color: #211D1E !important;">
                                            <a href="{{ route('blogs.show', $hBlog->slug) }}" class="text-decoration-none hover-text-gold transition-smooth" style="color: #211D1E !important;">
                                                {{ $hBlog->title }}
                                            </a>
                                        </h3>
                                        <p class="text-xs lh-base mb-3" style="color: #514744; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.4rem;">
                                            {{ $hBlog->excerpt ?? Str::limit(strip_tags($hBlog->content), 120) }}
                                        </p>
                                    </div>

                                    <!-- Read Guide Button -->
                                    <div class="mt-auto pt-2.5" style="border-top: 1px solid #E8E0DA;">
                                        <a href="{{ route('blogs.show', $hBlog->slug) }}" 
                                           class="w-100 py-2.5 px-3 text-xs tracking-wider fw-semibold d-flex align-items-center justify-content-center text-white text-decoration-none shadow-sm"
                                           style="min-height: 42px; background-color: #541B29; border: 1px solid #541B29; border-radius: 8px;">
                                            <span class="text-white">Read Guide</span>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>

                <!-- Centered Bottom Action -->
                <div class="text-center mt-5 pt-2">
                    <a href="{{ route('blogs.index') }}" class="btn py-2.5 px-4 text-xs tracking-wider fw-semibold text-decoration-none shadow-sm" style="background-color: #FFFFFF; border: 1px solid #541B29; color: #541B29; border-radius: 8px;">
                        Explore All Journal Guides
                    </a>
                </div>
            </div>
        </section>
    @endif

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Collidez Haute Parfumerie Hero Swiper
            const heroSwiper = new Swiper('.hero-master-swiper', {
                loop: true,
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                speed: 1000,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                navigation: {
                    nextEl: '.hero-next-btn',
                    prevEl: '.hero-prev-btn',
                },
                on: {
                    init: function () {
                        updateCollidezHeroMeter(this);
                    },
                    slideChange: function () {
                        updateCollidezHeroMeter(this);
                    }
                }
            });

            function updateCollidezHeroMeter(swiper) {
                const currentEl = document.querySelector('.hero__counter-current');
                const totalEl = document.querySelector('.hero__counter-total');
                const fillEl = document.querySelector('.hero__progress-bar-fill');
                if (!currentEl || !fillEl) return;

                const nonDupSlides = document.querySelectorAll('.hero-master-swiper .swiper-slide:not(.swiper-slide-duplicate)');
                const totalCount = nonDupSlides.length || 1;
                const activeIndex = (swiper.realIndex ?? 0) + 1;

                currentEl.textContent = String(activeIndex).padStart(2, '0');
                if (totalEl) {
                    totalEl.textContent = String(totalCount).padStart(2, '0');
                }
                fillEl.style.transform = `scaleX(${activeIndex / totalCount})`;
            }

            // Swiper Configuration Factory (340px+ Responsive)
            const createCarouselSwiper = (selector, paginationEl, nextEl, prevEl) => {
                const el = document.querySelector(selector);
                if (el && !el.swiper) {
                    return new Swiper(selector, {
                        slidesPerView: 1.15,
                        spaceBetween: 12,
                        speed: 700,
                        loop: false,
                        rewind: true,
                        autoplay: {
                            delay: 3500,
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
                            el: paginationEl,
                            clickable: true,
                            dynamicBullets: true,
                        },
                        navigation: {
                            nextEl: nextEl,
                            prevEl: prevEl,
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
                }
            };

            // Initialize all Featured Collection Tab Swipers
            createCarouselSwiper('.featured-swiper', '.featured-pagination', '.featured-next', '.featured-prev');
            createCarouselSwiper('.restocked-swiper', '.restocked-pagination', '.restocked-next', '.restocked-prev');
            createCarouselSwiper('.newarrivals-tab-swiper', '.newarrivals-tab-pagination', '.newarrivals-tab-next', '.newarrivals-tab-prev');
            createCarouselSwiper('.bestsellers-swiper', '.bestsellers-pagination', '.bestsellers-next', '.bestsellers-prev');

            // New Release Impressions Swiper (Section 6)
            createCarouselSwiper('.newarrivals-swiper', '.newarrivals-swiper-pagination', '.newarrivals-next', '.newarrivals-prev');

            // Testimonials Swiper (Section 8 - Haute Parfumerie Patron Reviews)
            const testimonialsEl = document.querySelector('.testimonials-swiper');
            if (testimonialsEl && typeof Swiper !== 'undefined') {
                if (testimonialsEl.swiper) {
                    testimonialsEl.swiper.destroy(true, true);
                }
                new Swiper('.testimonials-swiper', {
                    slidesPerView: 1.05,
                    spaceBetween: 16,
                    speed: 400,
                    loop: true,
                    grabCursor: true,
                    preventInteractionOnTransition: false,
                    touchMoveStopPropagation: false,
                    resistance: true,
                    resistanceRatio: 0.85,
                    touchRatio: 1.25,
                    touchAngle: 45,
                    threshold: 4,
                    watchSlidesProgress: true,
                    observer: true,
                    observeParents: true,
                    autoplay: {
                        delay: 4200,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                    pagination: {
                        el: '.testimonials-pagination',
                        clickable: true,
                        dynamicBullets: true,
                    },
                    navigation: {
                        nextEl: '.testimonials-next',
                        prevEl: '.testimonials-prev',
                    },
                    breakpoints: {
                        340: { slidesPerView: 1.05, spaceBetween: 14 },
                        480: { slidesPerView: 1.25, spaceBetween: 16 },
                        640: { slidesPerView: 1.8, spaceBetween: 18 },
                        768: { slidesPerView: 2.2, spaceBetween: 20 },
                        1024: { slidesPerView: 3, spaceBetween: 24 },
                        1280: { slidesPerView: 3.2, spaceBetween: 24 }
                    }
                });
            }
        });
    </script>
@endpush