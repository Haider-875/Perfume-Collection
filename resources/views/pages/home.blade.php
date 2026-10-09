@extends('layouts.app')

@section('title', 'Perfumes Collection | Luxury Extrait de Parfum Impressions Pakistan')
@section('meta_description', 'Discover hand-macerated Extrait de Parfum impressions inspired by iconic global niche fragrance houses. 35%-40% oil concentration, 14+ hours longevity, Cash on Delivery nationwide.')

@section('content')

    <!-- 1. Hero Full-Screen Swiper Slider (Collidez Cuisine Haute Parfumerie Style) -->
    <section class="hero-slider-section position-relative w-100 bg-theme-main overflow-hidden border-bottom border-gold-30">
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
                                ✦ &nbsp;{{ $slide->badge_text ?? 'HAUTE PARFUMERIE • EXTRAIT DE PARFUM' }}
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

    <!-- 3. Featured Collection with Responsive Filter Buttons & Dynamic Tabs -->
    <section class="py-5 bg-theme-main luxury-wine-bg border-bottom border-gold-20" x-data="{ activeTab: 'featured' }">
        <div class="container px-3 px-lg-4">

            <!-- Section Header (Centered) -->
            <div class="text-center mx-auto mb-4" style="max-width: 42rem;">
                <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury"
                    style="font-size: 11px;">CURATED FORMULATIONS</span>
                <h2 class="font-serif fs-2 fs-md-1 text-ivory fw-normal text-uppercase tracking-tight">
                    Featured Collection
                </h2>
            </div>

            <!-- Filter Pills Bar (Mobile Responsive & 340px Screen Ready) -->
            <div class="featured-filter-bar-wrapper mb-4">
                <div class="featured-filter-bar d-flex align-items-center gap-2 overflow-x-auto pb-2 no-scrollbar flex-nowrap flex-md-wrap justify-content-start justify-content-md-center">
                    <button type="button" 
                            @click="activeTab = 'featured'; $nextTick(() => { window.dispatchEvent(new Event('resize')); })"
                            class="featured-filter-btn"
                            :class="{ 'active': activeTab === 'featured' }">
                        <i class="fas fa-sparkles text-gold" style="font-size: 10px;" x-show="activeTab === 'featured'"></i>
                        <span>Featured Products</span>
                    </button>
                    <button type="button" 
                            @click="activeTab = 'restocked'; $nextTick(() => { window.dispatchEvent(new Event('resize')); })"
                            class="featured-filter-btn"
                            :class="{ 'active': activeTab === 'restocked' }">
                        <i class="fas fa-rotate-left text-gold" style="font-size: 10px;" x-show="activeTab === 'restocked'"></i>
                        <span>Restocked</span>
                    </button>
                    <button type="button" 
                            @click="activeTab = 'new'; $nextTick(() => { window.dispatchEvent(new Event('resize')); })"
                            class="featured-filter-btn"
                            :class="{ 'active': activeTab === 'new' }">
                        <i class="fas fa-star text-gold" style="font-size: 10px;" x-show="activeTab === 'new'"></i>
                        <span>New Arrivals</span>
                    </button>
                    <button type="button" 
                            @click="activeTab = 'bestsellers'; $nextTick(() => { window.dispatchEvent(new Event('resize')); })"
                            class="featured-filter-btn"
                            :class="{ 'active': activeTab === 'bestsellers' }">
                        <i class="fas fa-crown text-gold" style="font-size: 10px;" x-show="activeTab === 'bestsellers'"></i>
                        <span>Best Sellers</span>
                    </button>
                </div>
            </div>

            <!-- Tab 1: Featured Products Carousel -->
            <div x-show="activeTab === 'featured'" x-cloak class="position-relative tab-pane-fade">
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
                <div class="swiper-button-prev featured-prev luxury-swiper-prev d-none d-lg-flex"></div>
                <div class="swiper-button-next featured-next luxury-swiper-next d-none d-lg-flex"></div>
            </div>

            <!-- Tab 2: Restocked Carousel -->
            <div x-show="activeTab === 'restocked'" x-cloak class="position-relative tab-pane-fade">
                <div class="swiper restocked-swiper">
                    <div class="swiper-wrapper pb-4">
                        @foreach($restockedProducts as $rProduct)
                            <div class="swiper-slide h-auto">
                                <x-product-card :product="$rProduct" />
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination restocked-pagination position-relative mt-3"></div>
                </div>
                <div class="swiper-button-prev restocked-prev luxury-swiper-prev d-none d-lg-flex"></div>
                <div class="swiper-button-next restocked-next luxury-swiper-next d-none d-lg-flex"></div>
            </div>

            <!-- Tab 3: New Arrivals Carousel -->
            <div x-show="activeTab === 'new'" x-cloak class="position-relative tab-pane-fade">
                <div class="swiper newarrivals-tab-swiper">
                    <div class="swiper-wrapper pb-4">
                        @foreach($newArrivals as $nProduct)
                            <div class="swiper-slide h-auto">
                                <x-product-card :product="$nProduct" />
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination newarrivals-tab-pagination position-relative mt-3"></div>
                </div>
                <div class="swiper-button-prev newarrivals-tab-prev luxury-swiper-prev d-none d-lg-flex"></div>
                <div class="swiper-button-next newarrivals-tab-next luxury-swiper-next d-none d-lg-flex"></div>
            </div>

            <!-- Tab 4: Best Sellers Carousel -->
            <div x-show="activeTab === 'bestsellers'" x-cloak class="position-relative tab-pane-fade">
                <div class="swiper bestsellers-swiper">
                    <div class="swiper-wrapper pb-4">
                        @foreach($bestsellers as $bProduct)
                            <div class="swiper-slide h-auto">
                                <x-product-card :product="$bProduct" />
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination bestsellers-pagination position-relative mt-3"></div>
                </div>
                <div class="swiper-button-prev bestsellers-prev luxury-swiper-prev d-none d-lg-flex"></div>
                <div class="swiper-button-next bestsellers-next luxury-swiper-next d-none d-lg-flex"></div>
            </div>

            <!-- View Full Collection CTA -->
            <div class="text-center mt-4 mt-lg-5">
                <a href="{{ route('collections.show', 'all') }}" class="btn-outline-gold px-4 py-3">
                    <span>View Featured Fragrances</span>
                </a>
            </div>

        </div>
    </section>

    <!-- 4. "Find Your Perfect Match" Section (3-Card Signature Layout) -->
    <section class="py-5 bg-theme-dark border-bottom border-gold-20">
        <div class="container px-3 px-lg-4">

            <!-- Section Header -->
            <div class="text-center mx-auto mb-5" style="max-width: 48rem;">
                <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury"
                    style="font-size: 11px;">EXPLORE CATEGORIES</span>
                <h2 class="font-serif fs-2 fs-md-1 text-ivory fw-normal text-uppercase tracking-tight">
                    Find Your Perfect Match
                </h2>
                <p class="text-xs text-md-sm text-muted-luxury mt-2 lh-base fw-light mx-auto" style="max-width: 40rem;">
                    Explore our curated Collections — From Special Blends to Privé Collection to Exclusif Collection to
                    Signature Collection. We offer unique handcrafted blends to rare bold scents and timeless classics at unbeatable prices.
                </p>
            </div>

            <!-- 3-Card Grid -->
            <div class="row g-4">

                <!-- Card 1: Signature Collection -->
                <div class="col-12 col-md-4">
                    <a href="{{ route('collections.show', 'all') }}"
                        class="position-relative rounded-4 overflow-hidden shadow-lg border border-gold-30 d-flex flex-column justify-content-between p-4 text-white text-decoration-none luxury-hover-card"
                        style="min-height: 420px;">
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
                            <span
                                class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-wine-dark text-gold-soft border border-gold-40 backdrop-blur-md text-xs fw-semibold text-uppercase tracking-wider shadow-sm">
                                <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                                <span>discover</span>
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Card 2: Men's Collection -->
                <div class="col-12 col-md-4">
                    <a href="{{ route('collections.show', 'men') }}"
                        class="position-relative rounded-4 overflow-hidden shadow-lg border border-gold-30 d-flex flex-column justify-content-between p-4 text-white text-decoration-none luxury-hover-card"
                        style="min-height: 420px;">
                        <img src="{{ asset('assets/images/perfumes/prod_spice_bomb.jpg') }}" alt="Men's Collection"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_leather_smoke.jpg') }}';"
                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-smooth">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-bottom-fade"></div>

                        <!-- Top Card Info -->
                        <div class="position-relative z-2 vstack gap-1">
                            <h3 class="font-serif fs-3 fw-medium text-uppercase lh-1 gold-gradient-text">
                                Men's<br><span class="fs-6 tracking-widest fw-normal text-gold-soft">COLLECTION</span>
                            </h3>
                            <p class="text-xs text-sub fw-light pt-2 lh-base" style="max-width: 20rem;">
                                Bold, magnetic, and commanding masculine fragrance profiles with extraordinary sillage.
                            </p>
                        </div>

                        <!-- Bottom Discover Pill -->
                        <div class="position-relative z-2 pt-3">
                            <span
                                class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-wine-dark text-gold-soft border border-gold-40 backdrop-blur-md text-xs fw-semibold text-uppercase tracking-wider shadow-sm">
                                <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                                <span>discover</span>
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Card 3: Women's Collection -->
                <div class="col-12 col-md-4">
                    <a href="{{ route('collections.show', 'women') }}"
                        class="position-relative rounded-4 overflow-hidden shadow-lg border border-gold-30 d-flex flex-column justify-content-between p-4 text-white text-decoration-none luxury-hover-card"
                        style="min-height: 420px;">
                        <img src="{{ asset('assets/images/perfumes/prod_rose_oud.jpg') }}" alt="Women's Collection"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_eclair_caramel.jpg') }}';"
                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-smooth">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-bottom-fade"></div>

                        <!-- Top Card Info -->
                        <div class="position-relative z-2 vstack gap-1">
                            <h3 class="font-serif fs-3 fw-medium text-uppercase lh-1 gold-gradient-text">
                                Women's<br><span class="fs-6 tracking-widest fw-normal text-gold-soft">COLLECTION</span>
                            </h3>
                            <p class="text-xs text-sub fw-light pt-2 lh-base" style="max-width: 20rem;">
                                Graceful florals, seductive gourmands, and luminous feminine scents.
                            </p>
                        </div>

                        <!-- Bottom Discover Pill -->
                        <div class="position-relative z-2 pt-3">
                            <span
                                class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-wine-dark text-gold-soft border border-gold-40 backdrop-blur-md text-xs fw-semibold text-uppercase tracking-wider shadow-sm">
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
                    <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury"
                        style="font-size: 11px;">CURATED COFFRETS & SIGNATURE PAIRINGS</span>
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
                    <a href="{{ route('bundles.index') }}" class="btn-outline-gold px-4 py-3">
                        <!-- <i class="fas fa-gift text-gold"></i> -->
                        <span>VIEW ALL DISCOVERY BUNDLES & GIFT SETS</span>
                        <!-- <i class="fas fa-arrow-right-long btn-arrow"></i> -->
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- 6. New Release Impressions Carousel (Swiper) -->
    <section class="py-5 bg-theme-dark border-bottom border-gold-20">
        <div class="container px-3 px-lg-4">
            <div class="text-center mx-auto mb-4" style="max-width: 42rem;">
                <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury"
                    style="font-size: 11px;">FRESHLY MACERATED</span>
                <h2 class="font-serif fs-2 fs-md-1 text-ivory fw-normal text-uppercase tracking-tight">
                    New Release Impressions
                </h2>
                <div class="bg-gradient-gold-pill mx-auto mt-2" style="width: 4rem; height: 2px;"></div>
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
                <a href="{{ route('collections.show', 'all') }}?sort=new" class="btn-outline-gold px-4 py-3">
                    <span>Explore All New Arrivals</span>
                </a>
            </div>
        </div>
    </section>

    <!-- 7. Why Choose Perfumes Collection? (Brand Heritage & Quality Guarantee) -->
    <section class="py-5 bg-theme-main luxury-wine-bg border-bottom border-gold-20">
        <div class="container px-3 px-lg-4">
            <div class="text-center mx-auto mb-5" style="max-width: 48rem;">
                <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury" style="font-size: 11px;">THE
                    PERFUMES COLLECTION PROMISE</span>
                <h2 class="font-serif fs-2 fs-md-1 text-ivory fw-normal text-uppercase tracking-tight">
                    Why Discerning Fragrance Lovers Choose Us
                </h2>
                <p class="text-sm text-muted-luxury mt-2 lh-base fw-light">
                    Standard commercial perfumes dilute formulations down to 10%–15% alcohol solutions. Perfumes Collection
                    crafts pure Extrait de Parfum hand-macerated for 90 days specifically designed for Pakistan's climate.
                </p>
            </div>

            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-12 col-md-4">
                    <div
                        class="p-4 p-md-5 rounded-4 bg-gradient-wine-card border border-gold-25 text-center vstack gap-3 luxury-hover-card h-100">
                        <div class="rounded-3 bg-wine-accent text-gold border border-gold-40 d-flex align-items-center justify-content-center fs-3 mx-auto shadow-sm"
                            style="width: 4rem; height: 4rem;">
                            <i class="fas fa-droplet"></i>
                        </div>
                        <h3 class="font-serif fs-4 text-ivory fw-medium text-uppercase mb-0">35% - 40% Extrait Concentration
                        </h3>
                        <p class="text-xs text-sm text-muted-luxury lh-base fw-light mb-0">
                            Nearly double the oil density of department store Eau de Parfum. Delivers monumental 14 to 18
                            hours longevity on skin and fabric without synthetic alcohol harshness.
                        </p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-12 col-md-4">
                    <div
                        class="p-4 p-md-5 rounded-4 bg-gradient-wine-card border border-gold-25 text-center vstack gap-3 luxury-hover-card h-100">
                        <div class="rounded-3 bg-wine-accent text-gold border border-gold-40 d-flex align-items-center justify-content-center fs-3 mx-auto shadow-sm"
                            style="width: 4rem; height: 4rem;">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h3 class="font-serif fs-4 text-ivory fw-medium text-uppercase mb-0">Grasse French Fragrance Oils
                        </h3>
                        <p class="text-xs text-sm text-muted-luxury lh-base fw-light mb-0">
                            We formulate exclusively with premium French grade oils and natural agarwood distillations,
                            resulting in a 95%+ olfactory fidelity to the world's most coveted niche fragrances.
                        </p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-12 col-md-4">
                    <div
                        class="p-4 p-md-5 rounded-4 bg-gradient-wine-card border border-gold-25 text-center vstack gap-3 luxury-hover-card h-100">
                        <div class="rounded-3 bg-wine-accent text-gold border border-gold-40 d-flex align-items-center justify-content-center fs-3 mx-auto shadow-sm"
                            style="width: 4rem; height: 4rem;">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <h3 class="font-serif fs-4 text-ivory fw-medium text-uppercase mb-0">Hassle-Free Pakistani
                            Experience</h3>
                        <p class="text-xs text-sm text-muted-luxury lh-base fw-light mb-0">
                            Zero hassle Cash on Delivery nationwide, complimentary 24-48 hour TCS Express Air dispatch, and
                            an unconditional 7-day scent exchange guarantee.
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
                    <span class="d-block text-gold mb-2 fw-semibold text-uppercase tracking-luxury"
                        style="font-size: 11px;">VERIFIED PATRON REVIEWS</span>
                    <h2 class="font-serif fs-2 fs-md-1 text-ivory fw-normal text-uppercase tracking-tight">
                        1800+ Happy Customers
                    </h2>
                    <p class="text-xs text-muted-luxury mt-2 fw-light">
                        Authentic impressions from discerning fragrance patrons across Pakistan.
                    </p>
                </div>

                <div class="row g-4">
                    @foreach($recentReviews->take(3) as $rev)
                        <div class="col-12 col-md-4">
                            <div
                                class="bg-gradient-wine-card border border-gold-25 rounded-4 p-4 d-flex flex-column justify-content-between shadow-sm h-100 luxury-hover-card">
                                <div class="vstack gap-3">
                                    <!-- Customer Avatar & Info Header -->
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('assets/images/avatars/avatar_' . (($loop->index % 3) + 1) . '.svg') }}"
                                            alt="{{ $rev->user_name }}"
                                            class="rounded-circle object-fit-cover shadow-sm flex-shrink-0"
                                            style="width: 46px; height: 46px; border: 1.5px solid var(--gold);">
                                        <div class="overflow-hidden">
                                            <span class="fw-semibold text-ivory d-block text-truncate"
                                                style="font-size: 0.9rem;">{{ $rev->user_name }}</span>
                                            <span class="text-success d-flex align-items-center gap-1" style="font-size: 10px;">
                                                <i class="fas fa-check-circle"></i> Verified &bull;
                                                {{ $rev->user_city ?? 'Pakistan' }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Rating Stars -->
                                    <div class="d-flex text-gold text-xs">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $rev->rating ? '' : 'text-muted-luxury opacity-25' }}"></i>
                                        @endfor
                                    </div>

                                    <!-- Review Title & Comment -->
                                    <div>
                                        <h4 class="font-serif fs-5 text-gold-soft fw-medium mb-1">
                                            {{ $rev->title ?? 'Remarkable Longevity' }}</h4>
                                        <p class="text-xs text-sub lh-base fst-italic fw-light mb-0">
                                            "{{ $rev->comment }}"
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 border-top border-gold-15 d-flex align-items-center justify-content-between"
                                    style="font-size: 11px;">
                                    <span class="text-gold fw-medium">Verified Purchase</span>
                                    <span class="text-light-luxury"
                                        style="font-size: 10px;">{{ $rev->product->name ?? 'Extrait de Parfum' }}</span>
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
        @php
            $blogDistinctImages = [
                'assets/images/perfumes/prod_oud_royale.jpg',
                'assets/images/perfumes/prod_rose_oud.jpg',
                'assets/images/perfumes/prod_discovery_coffret.jpg'
            ];
        @endphp
        <section class="py-5 bg-theme-main luxury-wine-bg">
            <div class="container px-3 px-lg-4">
                <div
                    class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4 pb-3 border-bottom border-gold-20">
                    <div>
                        <span class="d-block text-gold mb-1 fw-semibold text-uppercase tracking-luxury"
                            style="font-size: 11px;">FRAGRANCE JOURNAL</span>
                        <h2 class="font-serif fs-3 fs-md-2 text-ivory fw-normal text-uppercase mb-0">Olfactory Chronicles &
                            Guides</h2>
                    </div>
                    <a href="{{ route('blogs.index') }}"
                        class="mt-3 mt-md-0 text-xs text-uppercase tracking-widest text-gold hover:text-gold-soft fw-bold d-flex align-items-center gap-2 text-decoration-none transition-smooth">
                        <span>Read All Articles</span>
                        <i class="fas fa-arrow-right" style="font-size: 11px;"></i>
                    </a>
                </div>

                <div class="row g-4">
                    @foreach($recentBlogs as $hBlog)
                        <div class="col-12 col-md-4">
                            <article
                                class="bg-gradient-wine-card border border-gold-25 rounded-4 overflow-hidden d-flex flex-column justify-content-between luxury-hover-card h-100">
                                <div class="overflow-hidden bg-theme-secondary" style="height: 12rem;">
                                    <img src="{{ !empty($hBlog->image) && file_exists(public_path($hBlog->image)) ? asset($hBlog->image) : asset($blogDistinctImages[$loop->index % 3]) }}"
                                        alt="{{ $hBlog->title }}"
                                        onerror="this.onerror=null; this.src='{{ asset($blogDistinctImages[$loop->index % 3]) }}';"
                                        class="w-100 h-100 object-fit-cover transition-smooth">
                                </div>
                                <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between vstack gap-3">
                                    <div>
                                        <span class="d-block text-gold mb-1 fw-semibold text-uppercase tracking-wider"
                                            style="font-size: 10px;">{{ $hBlog->category_name ?? 'Haute Parfumerie' }}</span>
                                        <h3 class="font-serif fs-5 text-ivory fw-medium lh-sm mb-0">
                                            <a href="{{ route('blogs.show', $hBlog->slug) }}"
                                                class="text-ivory text-decoration-none">{{ $hBlog->title }}</a>
                                        </h3>
                                    </div>
                                    <div class="text-muted-luxury pt-3 border-top border-gold-15 d-flex justify-content-between align-items-center"
                                        style="font-size: 11px;">
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
                        grabCursor: true,
                        resistance: true,
                        resistanceRatio: 0.75,
                        touchRatio: 1.15,
                        touchAngle: 45,
                        threshold: 4,
                        watchSlidesProgress: true,
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
        });
    </script>
@endpush