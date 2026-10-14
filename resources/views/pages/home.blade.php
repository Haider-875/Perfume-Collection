@extends('layouts.app')

@section('title', 'Perfumes Collection | Luxury Extrait de Parfum Impressions Pakistan')
@section('meta_description', 'Discover hand-macerated Extrait de Parfum impressions inspired by iconic global niche fragrance houses. 35%-40% oil concentration, 14+ hours longevity, Cash on Delivery nationwide.')

@section('content')

    <!-- 1. Hero Full-Screen Swiper Slider (Collidez Cuisine Haute Parfumerie Style) -->
    <section class="hero-slider-section position-relative w-100 overflow-hidden" style="border-bottom: 1px solid rgba(232, 224, 218, 0.2);">
        <div class="swiper hero-master-swiper w-100 h-100">
            <div class="swiper-wrapper">
                @forelse($heroSlides as $slideIndex => $slide)
                    @php
                        $slideImage = strtolower($slide->image ?? '');
                        if (str_contains($slideImage, '91_perfume_banner')) {
                            $slideDuration = 10000;
                            $scenes = [
                                [
                                    'time' => 0,
                                    'title' => 'Discover Your Signature Scent',
                                    'desc' => 'Explore exceptional fragrances crafted to express individuality with captivating floral chords, rich woods, and warm sensual amber.'
                                ],
                                [
                                    'time' => 2.8,
                                    'title' => '91 Sports',
                                    'desc' => 'Bold, fresh, and magnetic. An exhilarating blend of chilled aquatic notes, zesty bergamot, and warm woody amber.'
                                ]
                            ];
                        } elseif (str_contains($slideImage, '91_gold_banner')) {
                            $slideDuration = 6000;
                            $scenes = [
                                [
                                    'time' => 0,
                                    'title' => '91° Gold Edition',
                                    'desc' => 'Opulent and regal. A masterwork of gilded amber, sparkling bergamot, and aged cedarwood radiating pure royal distinction.'
                                ]
                            ];
                        } elseif (str_contains($slideImage, 'marjaan_perfume_banner')) {
                            $slideDuration = 6000;
                            $scenes = [
                                [
                                    'time' => 0,
                                    'title' => 'Marjaan',
                                    'desc' => 'Mystical, sensual, and unforgettable. An enchanting oriental fusion of rare aged oud, smoky florals, and warm resinous amber.'
                                ]
                            ];
                        } else {
                            $slideDuration = 6000;
                            $scenes = [
                                [
                                    'time' => 0,
                                    'title' => $slide->title ?? 'Discover Your Signature Scent',
                                    'desc' => $slide->subtitle ?? 'Explore captivating fragrances, refined notes, and timeless elegance for an unforgettable presence.'
                                ]
                            ];
                        }
                        $initialTitle = $scenes[0]['title'];
                        $initialDesc = $scenes[0]['desc'];
                    @endphp
                    <div class="swiper-slide position-relative w-100 h-100 overflow-hidden"
                        data-slide-duration="{{ $slideDuration }}"
                        data-scenes='@json($scenes)'>
                        <!-- Zooming Background Media -->
                        <div class="hero__media">
                            <div class="hero__zoom">
                                @if($slide->is_video || Str::endsWith(strtolower($slide->image ?? ''), ['.mp4', '.webm', '.ogg', '.mov']))
                                    <video autoplay loop muted playsinline class="w-100 h-100 object-fit-cover" preload="auto">
                                        <source src="{{ asset($slide->image) }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ asset($slide->image) }}" alt="{{ $initialTitle }}"
                                        onerror="this.onerror=null; this.src='{{ asset('assets/images/slides/hero_1.jpg') }}';"
                                        class="w-100 h-100 object-fit-cover">
                                @endif
                            </div>
                        </div>

                        <!-- Cinematic Vignette Shade Overlay -->
                        <div class="hero__shade" aria-hidden="true"></div>

                        <!-- Collidez Hero Content Overlay -->
                        <div class="hero__content">
                            <!-- Delicate Eyebrow / Kicker -->
                            <p class="hero__kicker">
                                <span>{{ $slide->badge_text ?? 'HAUTE PARFUMERIE • EXTRAIT DE PARFUM' }}</span>
                            </p>

                            <!-- Synced Dynamic Perfume Info Container -->
                            <div class="hero__synced-body" aria-live="polite">
                                <!-- Monumental Typography Title -->
                                <h1 class="hero__title font-hero" data-perfume-title>
                                    {{ $initialTitle }}
                                </h1>

                                <!-- Statement Subtitle -->
                                <p class="hero__statement font-sans" data-perfume-desc>
                                    {{ $initialDesc }}
                                </p>
                            </div>

                            <!-- Stadium Rolling-Text Action Pills -->
                            <div class="hero-btn-group d-flex align-items-center justify-content-center mt-2">
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
                            <p class="hero__kicker">AUTHENTIC LUXURY IMPRESSIONS</p>
                            <div class="hero__synced-body" aria-live="polite">
                                <h1 class="hero__title font-hero" data-perfume-title>PERFUMES COLLECTION</h1>
                                <p class="hero__statement font-sans" data-perfume-desc>Luxury Extrait de Parfum Impressions inspired by global niche fragrance houses.</p>
                            </div>
                            <div class="hero-btn-group d-flex align-items-center justify-content-center mt-2">
                                <a href="{{ route('collections.show', 'all') }}" class="collidez-pill collidez-pill--gold">
                                    <span class="collidez-roll">
                                        <span class="collidez-roll__a">EXPLORE CATALOG</span>
                                        <span class="collidez-roll__b" aria-hidden="true">EXPLORE CATALOG</span>
                                    </span>
                                </a>
                                <a href="{{ route('collections.show', 'all') }}" class="collidez-pill collidez-pill--outline">
                                    <span class="collidez-roll">
                                        <span class="collidez-roll__a">EXPLORE VAULT</span>
                                        <span class="collidez-roll__b" aria-hidden="true">EXPLORE VAULT</span>
                                    </span>
                                </a>
                            </div>
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
                <h2 class="font-serif fs-2 fs-md-1 fw-bold text-uppercase tracking-tight" style="color: #211D1E !important;">
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
            <div class="perfect-match-header text-center mx-auto mb-4 mb-md-5" style="max-width: 48rem;">
                <span class="perfect-match-eyebrow d-block mb-1.5 mb-md-2 fw-bold text-uppercase tracking-luxury text-center"
                    style="color: #780D24 !important;">EXPLORE CATEGORIES</span>
                <h2 class="perfect-match-title font-serif fw-bold text-uppercase tracking-tight text-center" style="color: #1A1416 !important;">
                    Find Your Perfect Match
                </h2>
                <p class="perfect-match-desc mt-2 lh-base mx-auto text-center" style="max-width: 42rem; color: #2C2422 !important; text-align: center !important;">
                    Explore our curated Collections — From Special Blends to Privé Collection to Exclusif Collection to
                    Signature Collection. We offer unique handcrafted blends to rare bold scents and timeless classics at unbeatable prices.
                </p>
            </div>

            <!-- 3-Card Grid -->
            <div class="row g-4">

                <!-- Card 1: Signature Collection -->
                <div class="col-12 col-md-4">
                    <a href="{{ route('collections.show', 'all') }}"
                        class="home-category-card position-relative rounded-4 overflow-hidden shadow-sm d-flex flex-column justify-content-between p-4 text-white text-decoration-none luxury-hover-card"
                        style="border: 1px solid rgba(255, 255, 255, 0.15); min-height: 380px;">
                        <img src="{{ asset('assets/images/categories/collection_signature.jpg') }}"
                            alt="Signature Collection"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-smooth">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(10, 3, 5, 0.88) 0%, rgba(18, 5, 10, 0.52) 48%, rgba(8, 2, 4, 0.92) 100%);"></div>

                        <!-- Top Card Info -->
                        <div class="position-relative z-2 vstack gap-1">
                            <h3 class="font-serif fs-2 fw-medium text-uppercase lh-1 text-white mb-1" style="text-shadow: 0 2px 14px rgba(0, 0, 0, 0.9), 0 1px 3px rgba(0, 0, 0, 0.7); letter-spacing: 0.03em;">
                                Signature<br><span class="fs-6 tracking-widest fw-bold" style="color: #780d24 !important; text-shadow: 0 1px 2px rgba(255, 255, 255, 0.15), 0 2px 10px rgba(0, 0, 0, 0.9);">COLLECTION</span>
                            </h3>
                            <p class="pt-2 lh-base mb-0" style="color: #FFFFFF !important; font-size: 13.5px; font-weight: 400; line-height: 1.5; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.9); max-width: 20rem;">
                                Most loved and iconic designer scents with 14+ hours projection.
                            </p>
                        </div>

                        <!-- Bottom Discover Pill -->
                        <div class="position-relative z-2 pt-3">
                            <span class="discover-glass-pill rounded-pill text-white shadow-sm">
                                <span>discover</span>
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Card 2: Men's Collection -->
                <div class="col-12 col-md-4">
                    <a href="{{ route('collections.show', 'men') }}"
                        class="home-category-card position-relative rounded-4 overflow-hidden shadow-sm d-flex flex-column justify-content-between p-4 text-white text-decoration-none luxury-hover-card"
                        style="border: 1px solid rgba(255, 255, 255, 0.15); min-height: 380px;">
                        <img src="{{ asset('assets/images/perfumes/prod_spice_bomb.jpg') }}" alt="Men's Collection"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_leather_smoke.jpg') }}';"
                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-smooth">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(10, 3, 5, 0.88) 0%, rgba(18, 5, 10, 0.52) 48%, rgba(8, 2, 4, 0.92) 100%);"></div>

                        <!-- Top Card Info -->
                        <div class="position-relative z-2 vstack gap-1">
                            <h3 class="font-serif fs-2 fw-medium text-uppercase lh-1 text-white mb-1" style="text-shadow: 0 2px 14px rgba(0, 0, 0, 0.9), 0 1px 3px rgba(0, 0, 0, 0.7); letter-spacing: 0.03em;">
                                Men's<br><span class="fs-6 tracking-widest fw-bold" style="color: #780d24 !important; text-shadow: 0 1px 2px rgba(255, 255, 255, 0.15), 0 2px 10px rgba(0, 0, 0, 0.9);">COLLECTION</span>
                            </h3>
                            <p class="pt-2 lh-base mb-0" style="color: #FFFFFF !important; font-size: 13.5px; font-weight: 400; line-height: 1.5; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.9); max-width: 20rem;">
                                Bold, magnetic, and commanding masculine fragrance profiles with extraordinary sillage.
                            </p>
                        </div>

                        <!-- Bottom Discover Pill -->
                        <div class="position-relative z-2 pt-3">
                            <span class="discover-glass-pill rounded-pill text-white shadow-sm">
                                <span>discover</span>
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Card 3: Women's Collection -->
                <div class="col-12 col-md-4">
                    <a href="{{ route('collections.show', 'women') }}"
                        class="home-category-card position-relative rounded-4 overflow-hidden shadow-sm d-flex flex-column justify-content-between p-4 text-white text-decoration-none luxury-hover-card"
                        style="border: 1px solid rgba(255, 255, 255, 0.15); min-height: 380px;">
                        <img src="{{ asset('assets/images/perfumes/prod_rose_oud.jpg') }}" alt="Women's Collection"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_eclair_caramel.jpg') }}';"
                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-smooth">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(10, 3, 5, 0.88) 0%, rgba(18, 5, 10, 0.52) 48%, rgba(8, 2, 4, 0.92) 100%);"></div>

                        <!-- Top Card Info -->
                        <div class="position-relative z-2 vstack gap-1">
                            <h3 class="font-serif fs-2 fw-medium text-uppercase lh-1 text-white mb-1" style="text-shadow: 0 2px 14px rgba(0, 0, 0, 0.9), 0 1px 3px rgba(0, 0, 0, 0.7); letter-spacing: 0.03em;">
                                Women's<br><span class="fs-6 tracking-widest fw-bold" style="color: #780d24 !important; text-shadow: 0 1px 2px rgba(255, 255, 255, 0.15), 0 2px 10px rgba(0, 0, 0, 0.9);">COLLECTION</span>
                            </h3>
                            <p class="pt-2 lh-base mb-0" style="color: #FFFFFF !important; font-size: 13.5px; font-weight: 400; line-height: 1.5; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.9); max-width: 20rem;">
                                Graceful florals, seductive gourmands, and luminous feminine scents.
                            </p>
                        </div>

                        <!-- Bottom Discover Pill -->
                        <div class="position-relative z-2 pt-3">
                            <span class="discover-glass-pill rounded-pill text-white shadow-sm">
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
                <div class="text-center mx-auto mb-5" style="max-width: 44rem;">
                    <span class="d-block mb-2 fw-bold text-uppercase tracking-luxury"
                        style="font-size: 11.5px; color: #780D24 !important; letter-spacing: 0.26em;">CURATED COFFRETS & SIGNATURE PAIRINGS</span>
                    <h2 class="font-serif fs-2 fs-md-1 fw-bold text-uppercase tracking-tight" style="color: #1A1416 !important;">
                        Luxury Fragrance Bundles
                    </h2>
                    <p class="mt-2 mx-auto" style="color: #2C2422 !important; font-size: 0.95rem; font-weight: 400; line-height: 1.6;">
                        Presented in custom gold-stamped coffrets. Enjoy up to 30% privileged savings across Pakistan.
                    </p>
                </div>

                <div class="row g-3 g-lg-4">
                    @foreach($bundles as $bundle)
                        <div class="col-12 col-md-4">
                            <x-bundle-card :bundle="$bundle" />
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4 mt-lg-5">
                    <a href="{{ route('bundles.index') }}" class="btn-outline-gold px-4 py-3" style="background-color: #FFFFFF !important; color: #541B29 !important; border: 1px solid #E8E0DA !important; border-radius: 8px; text-decoration: none;">
                        <span>View All Bundles & Gifts</span>
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
                <h2 class="font-serif fs-2 fs-md-1 fw-bold text-uppercase tracking-tight" style="color: #211D1E !important;">
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
                <h2 class="font-serif fs-2 fs-md-1 fw-bold text-uppercase tracking-tight" style="color: #211D1E !important;">
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
                    <h2 class="font-serif fs-2 fs-md-1 fw-bold text-uppercase tracking-tight mb-2" style="color: #211D1E !important;">
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
                                    <div class="testimonial-card-luxury d-flex flex-column justify-content-between h-100 w-100"
                                         style="background: #FFFFFF; border: 1px solid #E8E0DA; border-radius: 14px; padding: 22px 20px;">
                                        
                                        <div>
                                            <!-- Reviewer Name & 5-Star Rating Row -->
                                            <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                                <span class="fw-bold text-truncate" style="font-size: 0.98rem; color: #110D0E !important; letter-spacing: 0.01em;">
                                                    {{ $rev->user_name }}
                                                </span>
                                                <div class="d-flex flex-shrink-0" style="font-size: 11px; color: #d49a3d; gap: 2px;">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $rev->rating ? '' : 'opacity-25' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>

                                            <!-- Perfume Name -->
                                            @if($rev->product)
                                                <div class="fw-semibold text-truncate mb-2.5 font-sans" style="font-size: 0.82rem; color: #8A4B59;">
                                                    {{ $rev->product->name }}
                                                </div>
                                            @endif

                                            <!-- Full review text without truncation -->
                                            <p class="mb-0 font-sans" 
                                               style="color: #4A403A; font-size: 0.88rem; line-height: 1.65;">
                                                {{ $rev->comment }}
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Luxury Navigation Controls on Start (Left) & Last (Right) -->
                    <div class="swiper-button-prev testimonials-prev luxury-swiper-prev d-none d-md-flex" 
                         aria-label="Previous review"></div>
                    <div class="swiper-button-next testimonials-next luxury-swiper-next d-none d-md-flex" 
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
                    <h2 class="font-serif fs-2 fs-md-1 fw-bold text-uppercase mb-2" style="letter-spacing: 0.04em; color: #211D1E !important;">
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
                            
                            // High-quality asset images mapped by index to guarantee unique photos
                            $journalAssetImages = [
                                0 => 'assets/images/blogs/blog_extrait_science.jpg',
                                1 => 'assets/images/blogs/blog_mughal_attar.jpg',
                                2 => 'assets/images/blogs/blog_wedding_wardrobe.jpg',
                            ];
                            $journalFallbackPerfumes = [
                                0 => 'assets/images/perfumes/prod_oud_royale.jpg',
                                1 => 'assets/images/perfumes/prod_rose_oud.jpg',
                                2 => 'assets/images/perfumes/prod_attar.jpg',
                            ];

                            // If image is missing, empty, or .svg vector, use the corresponding rich journal photo
                            $cleanDbImage = trim((string)($hBlog->image ?? ''));
                            if (!empty($cleanDbImage) && !str_ends_with(strtolower($cleanDbImage), '.svg')) {
                                $cardImageSrc = asset($cleanDbImage);
                            } else {
                                $cardImageSrc = asset($journalAssetImages[$loop->index % 3] ?? 'assets/images/blogs/blog_extrait_science.jpg');
                            }
                            $cardFallbackSrc = asset($journalFallbackPerfumes[$loop->index % 3] ?? 'assets/images/perfumes/prod_oud_royale.jpg');
                        @endphp
                        <div class="col-12 col-md-6 col-lg-4">
                            <article class="home-blog-card blog-card position-relative luxury-hover-card rounded-4 overflow-hidden shadow-sm d-flex flex-column h-100 p-3 p-sm-3.5" style="background: #FFFFFF; border: 1px solid #E8E0DA;">
                                <!-- Image Pedestal Wrap -->
                                <div class="blog-card-image-wrap position-relative w-100 rounded-3 overflow-hidden mb-3 mb-sm-3.5" style="aspect-ratio: 16 / 10; min-height: 170px; background-color: #FAF7F2; border: 1px solid #E8E0DA;">
                                    <!-- Badges Row -->
                                    <div class="blog-card-badges-row position-absolute top-0 start-0 end-0 p-2 p-sm-2.5 d-flex align-items-center justify-content-between gap-2 z-2" style="pointer-events: none;">
                                        <span class="blog-card-category-badge rounded-pill fw-bold text-uppercase shadow-sm" 
                                              style="font-size: 9.5px; letter-spacing: 0.08em; background-color: #541B29; color: #FFFFFF; padding: 4.5px 11px; line-height: 1; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap; max-width: calc(100% - 85px); overflow: hidden; text-overflow: ellipsis; border: 1px solid rgba(255,255,255,0.18);"
                                              title="{{ $categoryName }}">
                                            {{ $categoryName }}
                                        </span>
                                        <span class="blog-card-readtime-badge rounded-pill fw-medium shadow-xs" 
                                              style="background-color: rgba(255, 255, 255, 0.94); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); border: 1px solid #E8E0DA; font-size: 9.5px; color: #211D1E !important; padding: 4.5px 10px; line-height: 1; display: inline-flex; align-items: center; justify-content: center; gap: 4px; white-space: nowrap; flex-shrink: 0;">
                                            <i class="far fa-clock" style="font-size: 8.5px; color: #851029;"></i>
                                            <span>{{ $readTime }}</span>
                                        </span>
                                    </div>
                                    <img src="{{ $cardImageSrc }}"
                                         alt="{{ $hBlog->title }}"
                                         loading="lazy"
                                         onerror="this.onerror=null; this.src='{{ $cardFallbackSrc }}';"
                                         class="w-100 h-100 object-fit-cover transition-smooth blog-card-img"
                                         style="object-fit: cover; object-position: center;">
                                </div>

                                <!-- Card Body with Generous Vertical Gaps -->
                                <div class="blog-card-body d-flex flex-column flex-grow-1 justify-content-between px-1">
                                    <div class="blog-card-content d-flex flex-column gap-2.5 gap-md-3 mb-3">
                                        <!-- Meta Row -->
                                        <div class="blog-meta d-flex align-items-center gap-2" style="font-size: 11px; color: #786C67; font-weight: 500;">
                                            <i class="far fa-calendar-alt text-brand" style="font-size: 10.5px; color: #851029;"></i>
                                            <span>{{ $formattedDate }}</span>
                                            <span>&bull;</span>
                                            <span>By {{ Str::limit($author, 22) }}</span>
                                        </div>

                                        <!-- Title -->
                                        <h3 class="blog-card-title font-serif fw-medium lh-sm m-0">
                                            <a href="{{ route('blogs.show', $hBlog->slug) }}" class="text-decoration-none hover-text-gold transition-smooth">
                                                {{ $hBlog->title }}
                                            </a>
                                        </h3>

                                        <!-- Excerpt -->
                                        <p class="blog-card-excerpt text-xs lh-base m-0" style="color: #5C524D; font-size: 0.86rem; line-height: 1.55;">
                                            {{ $hBlog->excerpt ?? Str::limit(strip_tags($hBlog->content), 120) }}
                                        </p>
                                    </div>

                                    <!-- Read Guide Button (Matches New Release Impressions Card Button) -->
                                    <div class="blog-card-action mt-auto pt-2 pt-md-3" style="border-top: 1px solid #E8E0DA;">
                                        <a href="{{ route('blogs.show', $hBlog->slug) }}" 
                                           class="w-100 btn-gold btn-cart-gradient py-2 py-sm-2.5 px-2 px-sm-3 tracking-wider fw-semibold d-flex align-items-center justify-content-center gap-1.5 gap-sm-2 text-white text-decoration-none shadow-sm"
                                           style="min-height: 40px; background-color: #541B29 !important; border-radius: 8px; border: none; touch-action: manipulation;"
                                           title="Read Guide">
                                            <i class="fas fa-book-open text-white" style="font-size: 11px;"></i>
                                            <span class="text-white text-nowrap" style="font-size: 11.5px;">Read Guide</span>
                                            <i class="fas fa-arrow-right-long btn-arrow text-white d-none d-md-inline-block" style="font-size: 11px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>

                <!-- Centered Bottom Action (Matches New Release Impressions CTA) -->
                <div class="text-center mt-4 mt-lg-5">
                    <a href="{{ route('blogs.index') }}" class="btn-outline-gold px-4 py-3" style="background-color: #FFFFFF !important; color: #541B29 !important; border: 1px solid #E8E0DA !important; border-radius: 8px; text-decoration: none;">
                        <span>Explore All Journal Guides</span>
                    </a>
                </div>
            </div>
        </section>
    @endif

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Collidez Haute Parfumerie Hero Swiper with Scene-Synchronized Typography
            const heroSwiper = new Swiper('.hero-master-swiper', {
                loop: true,
                autoplay: {
                    delay: 10000,
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
                grabCursor: true,
                touchRatio: 1.2,
                touchAngle: 45,
                resistanceRatio: 0.85,
                on: {
                    init: function () {
                        updateCollidezHeroMeter(this);
                        initVideoSync();
                        handleSlideActive(this);
                    },
                    slideChange: function () {
                        updateCollidezHeroMeter(this);
                        handleSlideActive(this);
                    }
                }
            });
            window.heroSwiperInstance = heroSwiper;

            function initVideoSync() {
                const slides = document.querySelectorAll('.hero-master-swiper .swiper-slide');
                slides.forEach(slide => {
                    const video = slide.querySelector('video');
                    const rawScenes = slide.getAttribute('data-scenes');
                    if (!video || !rawScenes) return;

                    let scenes = [];
                    try {
                        scenes = JSON.parse(rawScenes);
                    } catch (e) {
                        return;
                    }

                    if (!Array.isArray(scenes) || scenes.length === 0) return;

                    slide._scenes = scenes;
                    slide._currentSceneIndex = 0;

                    video.addEventListener('timeupdate', function () {
                        if (!slide.classList.contains('swiper-slide-active')) return;

                        const currentTime = video.currentTime || 0;
                        let targetIndex = 0;
                        for (let i = 0; i < scenes.length; i++) {
                            if (currentTime >= scenes[i].time) {
                                targetIndex = i;
                            }
                        }

                        if (slide._currentSceneIndex !== targetIndex) {
                            slide._currentSceneIndex = targetIndex;
                            const targetScene = scenes[targetIndex];
                            const syncedBody = slide.querySelector('.hero__synced-body');
                            const titleEl = slide.querySelector('[data-perfume-title]');
                            const descEl = slide.querySelector('[data-perfume-desc]');

                            if (syncedBody && titleEl && descEl) {
                                syncedBody.classList.add('is-changing');
                                setTimeout(() => {
                                    titleEl.textContent = targetScene.title;
                                    descEl.textContent = targetScene.desc;
                                    syncedBody.classList.remove('is-changing');
                                }, 220);
                            }
                        }
                    });
                });
            }

            function handleSlideActive(swiper) {
                try {
                    const activeSlide = swiper.slides ? swiper.slides[swiper.activeIndex] : null;
                    if (!activeSlide) return;

                    const activeVideo = activeSlide.querySelector('video');
                    if (activeVideo) {
                        activeVideo.setAttribute('playsinline', '');
                        activeVideo.setAttribute('webkit-playsinline', '');
                        activeVideo.muted = true;
                        
                        if (activeVideo.currentTime >= (activeVideo.duration - 0.5) || activeVideo.ended) {
                            activeVideo.currentTime = 0;
                        }
                        if (activeVideo.paused) {
                            activeVideo.play().catch(() => {});
                        }
                    }

                    if (activeSlide._scenes && activeSlide._scenes.length > 0) {
                        const targetScene = activeSlide._scenes[0];
                        activeSlide._currentSceneIndex = 0;
                        const titleEl = activeSlide.querySelector('[data-perfume-title]');
                        const descEl = activeSlide.querySelector('[data-perfume-desc]');
                        if (titleEl && descEl) {
                            titleEl.textContent = targetScene.title;
                            descEl.textContent = targetScene.desc;
                        }
                    }

                    const slideDuration = parseInt(activeSlide.getAttribute('data-slide-duration'), 10);
                    if (slideDuration && swiper.params && swiper.params.autoplay) {
                        swiper.params.autoplay.delay = slideDuration;
                    }

                    swiper.slides.forEach((slide, idx) => {
                        if (idx !== swiper.activeIndex) {
                            const vid = slide.querySelector('video');
                            if (vid && !vid.paused) {
                                vid.pause();
                            }
                        }
                    });
                } catch (e) {}
            }

            // Unlock mobile playback on first touch if OS power-saving restricted autoplay
            document.addEventListener('touchstart', function () {
                if (window.heroSwiperInstance) {
                    handleSlideActive(window.heroSwiperInstance);
                }
            }, { once: true, passive: true });

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
                    slidesPerView: 1.15,
                    spaceBetween: 14,
                    speed: 600,
                    loop: false,
                    rewind: true,
                    grabCursor: true,
                    watchSlidesProgress: true,
                    observer: true,
                    observeParents: true,
                    autoplay: {
                        delay: 4500,
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
                        320: { slidesPerView: 1.15, spaceBetween: 12 },
                        480: { slidesPerView: 1.35, spaceBetween: 14 },
                        640: { slidesPerView: 2.0, spaceBetween: 16 },
                        768: { slidesPerView: 2.3, spaceBetween: 18 },
                        1024: { slidesPerView: 3, spaceBetween: 22 },
                        1280: { slidesPerView: 3.3, spaceBetween: 24 }
                    }
                });
            }
        });
    </script>
@endpush