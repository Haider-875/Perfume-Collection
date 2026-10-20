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
                        if (str_contains($slideImage, '91_gold_banner')) {
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
                        } elseif (str_contains($slideImage, '91_perfume_banner')) {
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
                                    <video autoplay loop muted playsinline webkit-playsinline class="w-100 h-100 object-fit-cover hero-banner-video" preload="auto">
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

    <!-- 5. Exclusive Fragrances Video Showcase (Haute Parfumerie in Motion) -->
    @if(isset($exclusiveFragrances) && $exclusiveFragrances->count() > 0)
        <section class="py-5 border-bottom position-relative overflow-hidden" style="background-color: #F7F3EE !important; border-color: #E8E0DA !important;">
            <div class="container px-3 px-lg-4">
                <!-- Section Header -->
                <div class="text-center mx-auto mb-4 mb-md-5" style="max-width: 46rem;">
                    <span class="d-block mb-2 fw-bold text-uppercase tracking-luxury"
                        style="font-size: 11px; color: #780D24 !important; letter-spacing: 0.25em;">
                        PRIVATE RESERVE IN MOTION
                    </span>
                    <h2 class="font-serif fs-2 fs-md-1 fw-bold text-uppercase tracking-tight" style="color: #1A1416 !important;">
                        Exclusive Fragrances
                    </h2>
                    <div class="mx-auto mt-2 mb-3" style="width: 4rem; height: 2px; background-color: #9E7D3B;"></div>
                    <p class="mt-2 mx-auto lh-base" style="color: #4A3E39 !important; font-size: 0.95rem; font-weight: 400; max-width: 38rem;">
                        Hand-macerated Extrait de Parfum compositions engineered with 35%–40% pure French oil concentration for monumental sillage across Pakistan.
                    </p>
                </div>

                <!-- Exclusive Video Carousel Swiper -->
                <div class="position-relative exclusive-carousel-wrapper">
                    <div class="swiper exclusive-video-swiper rounded-4 shadow-sm" style="background: #FFFFFF; border: 1px solid #E8E0DA;">
                        <div class="swiper-wrapper">
                            @foreach($exclusiveFragrances as $item)
                                <div class="swiper-slide">
                                    <div class="exclusive-slide-card row g-0">
                                        
                                        <!-- Left Column: Cinematic Video Player (Strictly Left Aligned 50% on Desktop) -->
                                        <div class="col-12 col-lg-6 position-relative overflow-hidden exclusive-video-col" style="background: #0D0508;">
                                            <div class="exclusive-video-wrap position-relative w-100 h-100 d-flex align-items-center justify-content-center">
                                                <video autoplay loop muted playsinline webkit-playsinline preload="auto" class="exclusive-showcase-video w-100 h-100 object-fit-cover">
                                                    <source src="{{ asset($item->video) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                                
                                                <!-- Video Gradient Overlay -->
                                                <div class="exclusive-video-vignette position-absolute top-0 start-0 w-100 h-100 pointer-events-none"
                                                     style="background: linear-gradient(180deg, rgba(13,5,8,0.28) 0%, rgba(13,5,8,0) 40%, rgba(13,5,8,0.52) 100%);"></div>

                                                <!-- Top Left Floating Glassmorphism Badge (Clean Typography without Any Icons) -->
                                                <div class="position-absolute top-0 start-0 m-3 m-md-4 z-2 pointer-events-none">
                                                    <span class="exclusive-glass-badge px-3 py-1.5 rounded-pill text-uppercase text-white d-inline-flex align-items-center shadow-sm">
                                                        {{ $item->badge }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column: Product Details & Purchase Actions (Strictly Right Aligned 50% on Desktop) -->
                                        <div class="col-12 col-lg-6 d-flex flex-column justify-content-between exclusive-details-col" style="background: #FFFFFF;">
                                            <div class="exclusive-content-inner">
                                                <!-- Header Category / Eyebrow & Longevity (Responsive Spacing) -->
                                                <div class="exclusive-eyebrow-wrap">
                                                    <span class="font-sans fw-semibold text-uppercase tracking-luxury" style="font-family: 'Poppins', sans-serif; font-size: 10.5px; color: #9E7D3B; letter-spacing: 0.18em;">
                                                        HAUTE PARFUMERIE • 35%-40% EXTRAIT
                                                    </span>
                                                    <span class="exclusive-longevity-badge">
                                                        {{ $item->longevity }}
                                                    </span>
                                                </div>

                                                <!-- Perfume Title (Exact Product Page pdp-title Typography) -->
                                                <h3 class="pdp-title mb-1.5" style="font-family: 'Wasted Vindey', 'Cormorant Garamond', serif !important; font-size: clamp(1.85rem, 2.6vw, 2.45rem) !important; font-weight: 500 !important; line-height: 1.15; color: #110D0E !important;">
                                                    @if($item->slug)
                                                        <a href="{{ route('shop.show', $item->slug) }}" class="text-decoration-none transition-smooth hover-maroon" style="color: #110D0E !important;">
                                                            {{ $item->name }}
                                                        </a>
                                                    @else
                                                        <span style="color: #110D0E !important;">{{ $item->name }}</span>
                                                    @endif
                                                </h3>

                                                <!-- Tagline / Scent Chords (Exact Product Page Italic Luxury Tagline Style) -->
                                                @if(!empty($item->tagline))
                                                    <p class="font-sans fst-italic fw-light mb-2.5 text-start" style="font-size: 0.95rem; color: #541B29; line-height: 1.5;">
                                                        "{{ $item->tagline }}"
                                                    </p>
                                                @endif

                                                <!-- Small Description -->
                                                <p class="font-sans mb-3 lh-base" style="font-family: 'Poppins', sans-serif; color: #4A4240; font-size: 13px; font-weight: 400; line-height: 1.65;">
                                                    {{ $item->description }}
                                                </p>

                                                <!-- Ratings Row -->
                                                <div class="d-flex align-items-center gap-2 mb-3 pb-2.5" style="border-bottom: 1px solid #EFEAE5;">
                                                    <div class="d-inline-flex align-items-center gap-1 text-gold">
                                                        @for($s = 1; $s <= 5; $s++)
                                                            <i class="fas fa-star" style="color: #C9A24B; font-size: 11px;"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="font-sans fw-bold" style="font-size: 12px; color: #1A1416;">
                                                        {{ number_format($item->rating, 1) }}
                                                    </span>
                                                    <span class="font-sans" style="color: #7A6F68; font-size: 11px;">
                                                        &bull; {{ $item->reviews_count }} Verified Patron Reviews
                                                    </span>
                                                </div>

                                                <!-- Price Section (Exact Product Page pdp-price-amount + Gradient Save Badge) -->
                                                <div class="d-flex flex-column gap-1.5 mb-2 pb-0">
                                                    <div class="d-flex align-items-baseline gap-2 flex-wrap">
                                                        <span class="pdp-price-amount price-gradient-luxury"
                                                              style="font-family: 'Poppins', sans-serif !important; font-size: clamp(1.7rem, 2.4vw, 2.15rem) !important; font-weight: 700 !important; background: linear-gradient(135deg, #d49a3d 0%, #c4244b 45%, #780d24 100%) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; background-clip: text !important; display: inline-block; line-height: 1.1;">
                                                            Rs. {{ number_format($item->price) }}
                                                        </span>
                                                        <span class="font-sans fw-medium text-uppercase" style="color: #7A6F68; font-size: 11px;">
                                                            / {{ $item->volume }}
                                                        </span>
                                                    </div>

                                                    @if($item->original_price > $item->price)
                                                        <div class="d-flex align-items-center gap-2.5 pt-1">
                                                            <span class="font-sans text-decoration-line-through" style="color: #615652; font-size: 13px;">
                                                                Rs. {{ number_format($item->original_price) }}
                                                            </span>
                                                            <span class="badge-savings-luxury badge-save-gradient font-sans ms-1"
                                                                  style="background: linear-gradient(135deg, #d49a3d 0%, #c4244b 45%, #780d24 100%) !important; color: #FFFFFF !important; -webkit-text-fill-color: #FFFFFF !important; font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 0.06em; padding: 3.5px 9px; border-radius: 9999px; display: inline-flex; align-items: center; border: 1px solid rgba(255, 255, 255, 0.35); box-shadow: 0 2px 8px rgba(120, 13, 36, 0.32);">
                                                                SAVE RS. {{ number_format($item->savings) }} ({{ $item->discount_percent }}% OFF)
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Action Buttons (Reduced, Clean Spacing from Price Section) -->
                                            <div class="pt-2.5 pt-sm-3 pb-1 mt-2 mt-lg-2.5" style="border-top: 1px solid #EFEAE5;">
                                                <div class="row g-2 g-sm-3">
                                                    <!-- Add to Cart Button (Rich Wine Gradient) -->
                                                    <div class="col-12 col-sm-6">
                                                        <button type="button"
                                                                onclick="addToCartAjax({{ $item->id ?? 1 }}, 1)"
                                                                class="btn-exclusive-cart w-100 py-2.5 py-sm-3 px-3 fw-bold text-uppercase d-flex align-items-center justify-content-center gap-2 rounded-3 shadow-sm transition-smooth"
                                                                style="background: linear-gradient(135deg, #a31838 0%, #780d24 50%, #4a0915 100%) !important; color: #FFFFFF !important; border: none !important; font-size: 11.5px; letter-spacing: 0.1em; min-height: 48px; box-shadow: 0 4px 18px rgba(120, 13, 36, 0.4), 0 2px 6px rgba(0, 0, 0, 0.2) !important;">
                                                            <i class="fas fa-cart-shopping text-white" style="font-size: 12px;"></i>
                                                            <span class="text-white text-nowrap">ADD TO CART</span>
                                                        </button>
                                                    </div>

                                                    <!-- Buy Now Button (Product Page Glassmorphism Style) -->
                                                    <div class="col-12 col-sm-6">
                                                        <button type="button"
                                                                onclick="buyProductNow({{ $item->id ?? 1 }}, 1)"
                                                                class="btn-pill-buynow w-100 shadow-sm"
                                                                style="min-height: 48px;">
                                                            <span>BUY NOW</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Clean, Subtle Pagination Indicator Outside Card (No Intrusive Controls on Screen) -->
                    <div class="swiper-pagination exclusive-pagination position-relative mt-3 pt-1 text-center"></div>
                </div>

                <!-- Bottom Action: Explore Full Collection -->
                <div class="text-center mt-4 mt-lg-5">
                    <a href="{{ route('collections.show', 'all') }}" class="btn-outline-gold px-4 py-3"
                       style="background-color: #FFFFFF !important; color: #541B29 !important; border: 1px solid #E8E0DA !important; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center;">
                        <span>Explore Full Extrait Collection</span>
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
                            style="width: 4rem; height: 4rem; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%) !important; border: 1px solid #EAD8B8 !important;">
                            <i class="fas fa-droplet gradient-gold-icon" style="background: linear-gradient(135deg, #d49a3d 0%, #c4244b 45%, #780d24 100%) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; background-clip: text !important; display: inline-block;"></i>
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
                            style="width: 4rem; height: 4rem; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%) !important; border: 1px solid #EAD8B8 !important;">
                            <i class="fas fa-flask gradient-gold-icon" style="background: linear-gradient(135deg, #d49a3d 0%, #c4244b 45%, #780d24 100%) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; background-clip: text !important; display: inline-block;"></i>
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
                            style="width: 4rem; height: 4rem; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%) !important; border: 1px solid #EAD8B8 !important;">
                            <i class="fas fa-shield-halved gradient-gold-icon" style="background: linear-gradient(135deg, #d49a3d 0%, #c4244b 45%, #780d24 100%) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; background-clip: text !important; display: inline-block;"></i>
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

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Collidez Haute Parfumerie Hero Swiper with Scene-Synchronized Typography
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
                            320: { slidesPerView: 2.05, spaceBetween: 10 },
                            480: { slidesPerView: 2.25, spaceBetween: 12 },
                            576: { slidesPerView: 2.5, spaceBetween: 16 },
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

            // Exclusive Fragrances Video Carousel Swiper (Section 5)
            const exclusiveSwiperEl = document.querySelector('.exclusive-video-swiper');
            if (exclusiveSwiperEl && typeof Swiper !== 'undefined') {
                if (exclusiveSwiperEl.swiper) {
                    exclusiveSwiperEl.swiper.destroy(true, true);
                }
                const exclusiveSwiper = new Swiper('.exclusive-video-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    speed: 850,
                    loop: true,
                    autoHeight: true,
                    grabCursor: true,
                    watchSlidesProgress: true,
                    observer: true,
                    observeParents: true,
                    resistanceRatio: 0.85,
                    touchRatio: 1.1,
                    autoplay: {
                        delay: 6500,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                    pagination: {
                        el: '.exclusive-pagination',
                        clickable: true,
                    },
                    on: {
                        init: function () {
                            const activeSlide = this.slides[this.activeIndex];
                            if (activeSlide) {
                                const v = activeSlide.querySelector('video');
                                if (v) {
                                    v.play().catch(() => {});
                                }
                            }
                        },
                        slideChange: function () {
                            this.slides.forEach((slide, idx) => {
                                const v = slide.querySelector('video');
                                if (v) {
                                    if (idx === this.activeIndex) {
                                        v.currentTime = 0;
                                        v.play().catch(() => {});
                                    } else {
                                        v.pause();
                                    }
                                }
                            });
                        }
                    }
                });
                window.exclusiveSwiperInstance = exclusiveSwiper;
            }

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