@extends('layouts.app')

@section('title', 'Perfumes Collection | Luxury Extrait de Parfum Impressions Pakistan')
@section('meta_description', 'Discover hand-macerated Extrait de Parfum impressions inspired by iconic global niche fragrance houses. 35%-40% oil concentration, 14+ hours longevity, Cash on Delivery nationwide.')

@section('content')

<!-- 1. Hero Full-Screen Swiper Slider (Big Screen-Covering Luxury Banners) -->
<section class="hero-slider-section relative w-full h-[85vh] lg:h-[92vh] min-h-[620px] max-h-[960px] bg-[#050203] overflow-hidden border-b border-[#d6aa62]/30">
    <div class="swiper hero-master-swiper w-full h-full">
        <div class="swiper-wrapper">
            @forelse($heroSlides as $slide)
                <div class="swiper-slide relative w-full h-full flex items-center overflow-hidden">
                    <!-- Big Background Image Covering Whole Screen -->
                    <img 
                        src="{{ asset($slide->image) }}" 
                        alt="{{ $slide->title }}" 
                        onerror="this.onerror=null; this.src='{{ asset('assets/images/slides/hero_1.jpg') }}';" 
                        class="absolute inset-0 w-full h-full object-cover object-center transform scale-100 transition-transform duration-10000"
                    >

                    <!-- Cinematic Dark Wine & Velvet Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r from-[#050203]/95 via-[#25050a]/75 to-[#050203]/40 z-10"></div>
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_15%,rgba(133,26,49,0.35),transparent_65%)] z-10 pointer-events-none"></div>

                    <!-- Top-Right Stamp Badge: Proudly Made in Pakistan -->
                    <div class="hidden md:flex absolute top-10 right-10 lg:right-16 z-20 items-center justify-center pointer-events-none">
                        <div class="w-24 h-24 rounded-full border-2 border-[#d6aa62]/80 bg-[#160409]/80 backdrop-blur-md p-2 flex flex-col items-center justify-center text-center shadow-2xl">
                            <span class="text-2xl leading-none">🇵🇰</span>
                            <span class="text-[8px] font-bold uppercase tracking-widest text-[#f0d59d] mt-1 leading-tight">PROUDLY MADE<br>IN PAKISTAN</span>
                        </div>
                    </div>

                    <!-- Slide Content Overlay -->
                    <div class="container mx-auto px-4 sm:px-6 lg:px-12 relative z-20 h-full flex items-center">
                        <div class="max-w-2xl lg:max-w-3xl space-y-6 text-left py-12">
                            
                            <!-- Winner / Category Badge -->
                            <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-[#3b0711]/70 border border-[#d6aa62]/60 backdrop-blur-md text-[#f0d59d] text-xs font-semibold tracking-[0.25em] uppercase shadow-lg">
                                <i class="fas fa-award text-[#d6aa62] text-sm"></i>
                                <span>{{ $slide->badge_text ?? 'WINNER FRAGRANCE OF THE YEAR 2026' }}</span>
                            </div>

                            <!-- Main Title (Cormorant Garamond Elegance) -->
                            <h1 class="font-serif text-5xl sm:text-7xl lg:text-8xl font-normal text-[#f5efe7] tracking-tight leading-[1.02] uppercase drop-shadow-2xl">
                                {!! $slide->title !!}
                            </h1>

                            <!-- Subtitle / Tagline -->
                            <p class="font-serif italic text-xl sm:text-2xl text-[#f0d59d]/90 font-light leading-relaxed max-w-xl">
                                {{ $slide->subtitle ?? 'Experience it before everyone else does.' }}
                            </p>

                            <!-- Trust Indicators Row -->
                            <div class="flex flex-wrap items-center gap-5 sm:gap-8 pt-2 text-[#f5efe7]">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#3b0711]/60 border border-[#d6aa62]/40 flex items-center justify-center text-[#d6aa62] text-sm shadow-md backdrop-blur-xs">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs sm:text-sm font-bold uppercase tracking-wider text-[#f5efe7]">14+ HOURS</div>
                                        <div class="text-[9px] text-[#b8a9a2] uppercase tracking-widest font-medium">LONG LASTING</div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#3b0711]/60 border border-[#d6aa62]/40 flex items-center justify-center text-[#d6aa62] text-sm shadow-md backdrop-blur-xs">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs sm:text-sm font-bold uppercase tracking-wider text-[#f5efe7]">50,000+</div>
                                        <div class="text-[9px] text-[#b8a9a2] uppercase tracking-widest font-medium">PATRONS ACROSS PAKISTAN</div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#3b0711]/60 border border-[#d6aa62]/40 flex items-center justify-center text-[#d6aa62] text-sm shadow-md backdrop-blur-xs">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs sm:text-sm font-bold uppercase tracking-wider text-[#ffd987]">★ 4.9 / 5.0</div>
                                        <div class="text-[9px] text-[#b8a9a2] uppercase tracking-widest font-medium">VERIFIED RATINGS</div>
                                    </div>
                                </div>
                            </div>

                            <!-- CTAs -->
                            <div class="flex flex-wrap items-center gap-4 pt-4">
                                <a href="{{ $slide->cta_url ?? route('collections.show', 'all') }}" 
                                   class="inline-flex items-center gap-3 px-8 py-4 rounded-full btn-gold text-xs uppercase tracking-[0.2em] shadow-2xl group">
                                    <span class="w-7 h-7 rounded-full bg-[#050203] text-[#d6aa62] flex items-center justify-center text-xs group-hover:bg-[#25050a] group-hover:text-white transition-colors">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                    <span>{{ $slide->cta_text ?? 'SHOP OUR TOP SELLERS' }}</span>
                                </a>

                                <a href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I am interested in ordering your flagship Extrait collection.') }}" 
                                   target="_blank" 
                                   class="inline-flex items-center gap-2.5 px-7 py-4 rounded-full bg-[#25D366] hover:bg-[#20BA5A] text-white font-bold text-xs uppercase tracking-wider transition-all shadow-xl">
                                    <i class="fab fa-whatsapp text-lg"></i>
                                    <span>1-CLICK ORDER (COD)</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="swiper-slide relative w-full h-full flex items-center justify-center bg-[#050203]">
                    <img src="{{ asset('assets/images/slides/hero_1.jpg') }}" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-[#050203]/80"></div>
                    <div class="relative z-10 text-center text-[#f5efe7] space-y-4">
                        <h1 class="font-serif text-5xl font-medium uppercase gold-gradient-text">Perfumes Collection</h1>
                        <p class="text-lg text-[#f0d59d]">Luxury Extrait de Parfum Impressions</p>
                        <a href="{{ route('collections.show', 'all') }}" class="inline-block px-8 py-3.5 btn-gold rounded-full text-xs">Explore Catalog</a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Carousel Navigation Arrows & Pagination Dots -->
        <div class="swiper-button-prev !text-[#d6aa62] !w-12 !h-12 rounded-full border border-[#d6aa62]/40 !bg-[#160409]/85 hover:!bg-[#25050a] backdrop-blur-md after:!text-base transition-all shadow-xl !left-4 sm:!left-8"></div>
        <div class="swiper-button-next !text-[#d6aa62] !w-12 !h-12 rounded-full border border-[#d6aa62]/40 !bg-[#160409]/85 hover:!bg-[#25050a] backdrop-blur-md after:!text-base transition-all shadow-xl !right-4 sm:!right-8"></div>
        <div class="swiper-pagination !bottom-6 !text-[#d6aa62]"></div>
    </div>
</section>

<!-- 2. Value Proposition Ticker Bar (Royal Wine & Gold Ticker) -->
<section class="bg-gradient-to-r from-[#160409] via-[#3b0711] to-[#160409] text-[#f5efe7] py-3.5 border-b border-[#d6aa62]/30 overflow-hidden shadow-md">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-y-2 gap-x-6 text-[12px] sm:text-[13px] font-semibold uppercase tracking-wider text-center md:text-left">
            <div class="flex items-center space-x-2 mx-auto md:mx-0">
                <span class="text-[#d6aa62]">💎</span>
                <span>Premium Extrait de Parfum</span>
            </div>
            <div class="flex items-center space-x-2 mx-auto md:mx-0">
                <span class="text-[#d6aa62]">🕯️</span>
                <span>Hand Crafted Candles</span>
            </div>
            <div class="flex items-center space-x-2 mx-auto md:mx-0">
                <span class="text-[#d6aa62]">⌛</span>
                <span>Long Lasting for 14+ Hours</span>
            </div>
            <div class="flex items-center space-x-2 mx-auto md:mx-0">
                <span class="text-[#d6aa62]">🚚</span>
                <span>Fast Nationwide Delivery Across Pakistan</span>
            </div>
            <div class="hidden lg:flex items-center space-x-2">
                <span class="text-[#d6aa62]">🌿</span>
                <span>100% Vegan & Cruelty Free</span>
            </div>
            <div class="hidden xl:flex items-center space-x-2">
                <span class="text-[#d6aa62]">🛡️</span>
                <span>Free of Harmful Chemicals</span>
            </div>
        </div>
    </div>
</section>

<!-- 3. Featured Collection with Category Filter Pills -->
<section class="py-16 sm:py-20 bg-[#050203] luxury-wine-bg border-b border-[#d6aa62]/20">
    <div class="container mx-auto px-4 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-8">
            <span class="text-[11px] uppercase tracking-[0.3em] text-[#d6aa62] font-semibold block mb-2">CURATED FORMULATIONS</span>
            <h2 class="font-serif text-4xl sm:text-5xl text-[#f5efe7] font-normal uppercase tracking-tight">
                Featured Collection
            </h2>
        </div>

        <!-- Filter Pills Bar -->
        <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-3.5 mb-12">
            <button type="button" class="px-5 sm:px-6 py-2 rounded-xl bg-gradient-to-r from-[#d6aa62] to-[#c08b3f] text-[#050203] text-xs sm:text-sm font-bold tracking-wider uppercase shadow-md transition-all">
                Featured Products
            </button>
            <a href="{{ route('collections.show', 'all') }}?sort=popular" class="px-5 sm:px-6 py-2 rounded-xl border border-[#d6aa62]/30 bg-[#140408]/60 text-[#b8a9a2] hover:border-[#d6aa62] hover:text-[#f0d59d] text-xs sm:text-sm font-medium tracking-wider uppercase transition-all">
                Restocked
            </a>
            <a href="{{ route('collections.show', 'all') }}?sort=new" class="px-5 sm:px-6 py-2 rounded-xl border border-[#d6aa62]/30 bg-[#140408]/60 text-[#b8a9a2] hover:border-[#d6aa62] hover:text-[#f0d59d] text-xs sm:text-sm font-medium tracking-wider uppercase transition-all">
                New Arrivals
            </a>
            <a href="{{ route('collections.show', 'all') }}?sort=bestseller" class="px-5 sm:px-6 py-2 rounded-xl border border-[#d6aa62]/30 bg-[#140408]/60 text-[#b8a9a2] hover:border-[#d6aa62] hover:text-[#f0d59d] text-xs sm:text-sm font-medium tracking-wider uppercase transition-all">
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
            <div class="swiper-pagination !-bottom-8"></div>
        </div>

        <!-- View Full Collection CTA -->
        <div class="text-center mt-12">
            <a href="{{ route('collections.show', 'all') }}" class="btn-outline-gold px-8 py-3.5 rounded-xl text-xs uppercase tracking-widest inline-flex items-center gap-2">
                <span>View All Featured Fragrances</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

    </div>
</section>

<!-- 4. "Find Your Perfect Match" Section (3-Card Signature Layout) -->
<section class="py-16 sm:py-20 bg-[#080204] border-b border-[#d6aa62]/20">
    <div class="container mx-auto px-4 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-14">
            <span class="text-[11px] uppercase tracking-[0.3em] text-[#d6aa62] font-semibold block mb-2">EXPLORE CATEGORIES</span>
            <h2 class="font-serif text-4xl sm:text-5xl text-[#f5efe7] font-normal uppercase tracking-tight">
                Find Your Perfect Match
            </h2>
            <p class="text-xs sm:text-sm text-[#b8a9a2] mt-3 leading-relaxed max-w-2xl mx-auto font-light">
                Explore our curated Collections — From Special Blends to Privé Collection to Exclusif Collection to Signature Collection to Hand Poured Candles & High Quality Attar Oils. We offer unique handcrafted blends to rare bold scents, timeless classics and luxury attars at unbeatable prices.
            </p>
        </div>

        <!-- 3-Card Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            
            <!-- Card 1: Signature Collection -->
            <a href="{{ route('collections.show', 'all') }}" class="group relative h-96 sm:h-[420px] rounded-3xl overflow-hidden shadow-2xl border border-[#d6aa62]/30 hover:border-[#d6aa62] transition-all duration-500 flex flex-col justify-between p-7 text-white">
                <img src="{{ asset('assets/images/categories/collection_signature.jpg') }}" 
                     alt="Signature Collection" 
                     onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
                     class="absolute inset-0 w-full h-full object-cover object-center transform group-hover:scale-108 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-[#050203]/95 via-[#25050a]/40 to-transparent"></div>

                <!-- Top Card Info -->
                <div class="relative z-10 space-y-1">
                    <h3 class="font-serif text-3xl sm:text-4xl font-medium uppercase tracking-tight leading-tight gold-gradient-text">
                        Signature<br><span class="text-sm tracking-[0.3em] font-normal text-[#f0d59d]">COLLECTION</span>
                    </h3>
                    <p class="text-xs text-[#dfd5cb] font-light pt-2 max-w-xs leading-relaxed">
                        Most loved and iconic designer scents with 14+ hours projection.
                    </p>
                </div>

                <!-- Bottom Discover Pill -->
                <div class="relative z-10 pt-4">
                    <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#160409]/70 hover:bg-[#d6aa62] text-[#f0d59d] hover:text-[#050203] border border-[#d6aa62]/40 backdrop-blur-md text-xs font-semibold uppercase tracking-wider transition-all shadow-md">
                        <i class="fas fa-chevron-right text-[10px]"></i>
                        <span>discover</span>
                    </span>
                </div>
            </a>

            <!-- Card 2: Candle Collection -->
            <a href="{{ route('collections.show', 'all') }}" class="group relative h-96 sm:h-[420px] rounded-3xl overflow-hidden shadow-2xl border border-[#d6aa62]/30 hover:border-[#d6aa62] transition-all duration-500 flex flex-col justify-between p-7 text-white">
                <img src="{{ asset('assets/images/categories/collection_candles.jpg') }}" 
                     alt="Candle Collection" 
                     onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_spice_bomb.jpg') }}';"
                     class="absolute inset-0 w-full h-full object-cover object-center transform group-hover:scale-108 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-[#050203]/95 via-[#25050a]/40 to-transparent"></div>

                <!-- Top Card Info -->
                <div class="relative z-10 space-y-1">
                    <h3 class="font-serif text-3xl sm:text-4xl font-medium uppercase tracking-tight leading-tight gold-gradient-text">
                        Candle<br><span class="text-sm tracking-[0.3em] font-normal text-[#f0d59d]">COLLECTION</span>
                    </h3>
                    <p class="text-xs text-[#dfd5cb] font-light pt-2 max-w-xs leading-relaxed">
                        Hand-poured artisanal soy wax to bring warmth and ambiance to your home.
                    </p>
                </div>

                <!-- Bottom Discover Pill -->
                <div class="relative z-10 pt-4">
                    <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#160409]/70 hover:bg-[#d6aa62] text-[#f0d59d] hover:text-[#050203] border border-[#d6aa62]/40 backdrop-blur-md text-xs font-semibold uppercase tracking-wider transition-all shadow-md">
                        <i class="fas fa-chevron-right text-[10px]"></i>
                        <span>discover</span>
                    </span>
                </div>
            </a>

            <!-- Card 3: Attar Collection -->
            <a href="{{ route('collections.show', 'all') }}" class="group relative h-96 sm:h-[420px] rounded-3xl overflow-hidden shadow-2xl border border-[#d6aa62]/30 hover:border-[#d6aa62] transition-all duration-500 flex flex-col justify-between p-7 text-white">
                <img src="{{ asset('assets/images/categories/collection_attar.jpg') }}" 
                     alt="Attar Collection" 
                     onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_attar.jpg') }}';"
                     class="absolute inset-0 w-full h-full object-cover object-center transform group-hover:scale-108 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-[#050203]/95 via-[#25050a]/40 to-transparent"></div>

                <!-- Top Card Info -->
                <div class="relative z-10 space-y-1">
                    <h3 class="font-serif text-3xl sm:text-4xl font-medium uppercase tracking-tight leading-tight gold-gradient-text">
                        Attar<br><span class="text-sm tracking-[0.3em] font-normal text-[#f0d59d]">COLLECTION</span>
                    </h3>
                    <p class="text-xs text-[#dfd5cb] font-light pt-2 max-w-xs leading-relaxed">
                        Where royal oriental tradition meets unadulterated luxury oils.
                    </p>
                </div>

                <!-- Bottom Discover Pill -->
                <div class="relative z-10 pt-4">
                    <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#160409]/70 hover:bg-[#d6aa62] text-[#f0d59d] hover:text-[#050203] border border-[#d6aa62]/40 backdrop-blur-md text-xs font-semibold uppercase tracking-wider transition-all shadow-md">
                        <i class="fas fa-chevron-right text-[10px]"></i>
                        <span>discover</span>
                    </span>
                </div>
            </a>

        </div>
    </div>
</section>

<!-- 5. Bundles & Discovery Coffrets -->
@if($bundles->count() > 0)
    <section class="py-16 sm:py-20 bg-[#050203] luxury-wine-bg border-b border-[#d6aa62]/20">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-[11px] uppercase tracking-[0.3em] text-[#d6aa62] font-semibold block mb-2">CURATED COFFRETS & SIGNATURE PAIRINGS</span>
                <h2 class="font-serif text-4xl sm:text-5xl text-[#f5efe7] font-normal uppercase tracking-tight">
                    Luxury Fragrance Bundles
                </h2>
                <p class="text-xs md:text-sm text-[#b8a9a2] mt-2 font-light">
                    Presented in custom gold-stamped coffrets. Enjoy up to 30% privileged savings across Pakistan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                @foreach($bundles as $bundle)
                    <x-bundle-card :bundle="$bundle" />
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('bundles.index') }}" class="btn-outline-gold px-8 py-3.5 rounded-xl text-xs uppercase tracking-widest inline-flex items-center gap-2">
                    <i class="fas fa-gift text-[#d6aa62]"></i>
                    <span>VIEW ALL DISCOVERY BUNDLES & GIFT SETS</span>
                </a>
            </div>
        </div>
    </section>
@endif

<!-- 6. New Release Impressions Grid -->
<section class="py-16 sm:py-20 bg-[#080204] border-b border-[#d6aa62]/20">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-[11px] uppercase tracking-[0.3em] text-[#d6aa62] font-semibold block mb-2">FRESHLY MACERATED</span>
            <h2 class="font-serif text-4xl sm:text-5xl text-[#f5efe7] font-normal uppercase tracking-tight">
                New Release Impressions
            </h2>
            <div class="w-16 h-0.5 bg-gradient-to-r from-transparent via-[#d6aa62] to-transparent mx-auto mt-3"></div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($newArrivals as $nProduct)
                <x-product-card :product="$nProduct" />
            @endforeach
        </div>
    </div>
</section>

<!-- 7. Why Choose Perfumes Collection? (Brand Heritage & Quality Guarantee) -->
<section class="py-20 bg-[#050203] luxury-wine-bg border-b border-[#d6aa62]/20">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-[11px] uppercase tracking-[0.3em] text-[#d6aa62] font-semibold block mb-2">THE PERFUMES COLLECTION PROMISE</span>
            <h2 class="font-serif text-4xl sm:text-5xl text-[#f5efe7] font-normal uppercase tracking-tight">
                Why Discerning Fragrance Lovers Choose Us
            </h2>
            <p class="text-sm text-[#b8a9a2] mt-3 leading-relaxed font-light">
                Standard commercial perfumes dilute formulations down to 10%–15% alcohol solutions. Perfumes Collection crafts pure Extrait de Parfum hand-macerated for 90 days specifically designed for Pakistan's climate.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="p-8 rounded-2xl bg-gradient-to-b from-[#18050b] via-[#100306] to-[#070103] border border-[#d6aa62]/25 text-center space-y-4 hover:border-[#d6aa62]/70 hover:shadow-[0_10px_30px_rgba(214,170,98,0.15)] transition-all">
                <div class="w-16 h-16 rounded-2xl bg-[#3b0711] text-[#d6aa62] border border-[#d6aa62]/40 flex items-center justify-center text-2xl mx-auto shadow-md">
                    <i class="fas fa-droplet"></i>
                </div>
                <h3 class="font-serif text-2xl text-[#f5efe7] font-medium uppercase">35% - 40% Extrait Concentration</h3>
                <p class="text-xs sm:text-sm text-[#b8a9a2] leading-relaxed font-light">
                    Nearly double the oil density of department store Eau de Parfum. Delivers monumental 14 to 18 hours longevity on skin and fabric without synthetic alcohol harshness.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="p-8 rounded-2xl bg-gradient-to-b from-[#18050b] via-[#100306] to-[#070103] border border-[#d6aa62]/25 text-center space-y-4 hover:border-[#d6aa62]/70 hover:shadow-[0_10px_30px_rgba(214,170,98,0.15)] transition-all">
                <div class="w-16 h-16 rounded-2xl bg-[#3b0711] text-[#d6aa62] border border-[#d6aa62]/40 flex items-center justify-center text-2xl mx-auto shadow-md">
                    <i class="fas fa-flask"></i>
                </div>
                <h3 class="font-serif text-2xl text-[#f5efe7] font-medium uppercase">Grasse French Fragrance Oils</h3>
                <p class="text-xs sm:text-sm text-[#b8a9a2] leading-relaxed font-light">
                    We formulate exclusively with premium French grade oils and natural agarwood distillations, resulting in a 95%+ olfactory fidelity to the world's most coveted niche fragrances.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="p-8 rounded-2xl bg-gradient-to-b from-[#18050b] via-[#100306] to-[#070103] border border-[#d6aa62]/25 text-center space-y-4 hover:border-[#d6aa62]/70 hover:shadow-[0_10px_30px_rgba(214,170,98,0.15)] transition-all">
                <div class="w-16 h-16 rounded-2xl bg-[#3b0711] text-[#d6aa62] border border-[#d6aa62]/40 flex items-center justify-center text-2xl mx-auto shadow-md">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <h3 class="font-serif text-2xl text-[#f5efe7] font-medium uppercase">Hassle-Free Pakistani Experience</h3>
                <p class="text-xs sm:text-sm text-[#b8a9a2] leading-relaxed font-light">
                    Zero hassle Cash on Delivery nationwide, complimentary 24-48 hour TCS Express Air dispatch, and an unconditional 7-day scent exchange guarantee.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- 8. Testimonials Section -->
@if($recentReviews->count() > 0)
    <section class="py-16 sm:py-20 bg-[#080204] border-b border-[#d6aa62]/20">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-12">
                <span class="text-[11px] uppercase tracking-[0.3em] text-[#d6aa62] font-semibold block mb-2">VERIFIED PATRON REVIEWS</span>
                <h2 class="font-serif text-4xl sm:text-5xl text-[#f5efe7] font-normal uppercase tracking-tight">
                    50,000+ Satisfied Customers
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($recentReviews as $rev)
                    <div class="bg-gradient-to-b from-[#18050b] via-[#100306] to-[#070103] border border-[#d6aa62]/25 rounded-2xl p-6 flex flex-col justify-between shadow-xl hover:border-[#d6aa62]/60 transition">
                        <div class="space-y-3">
                            <div class="flex text-[#d6aa62] text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $rev->rating ? '' : 'text-[#3b0711]' }}"></i>
                                @endfor
                            </div>
                            <h4 class="font-serif text-lg text-[#f0d59d] font-medium">{{ $rev->review_title ?? 'Majestic Longevity' }}</h4>
                            <p class="text-xs text-[#dfd5cb] leading-relaxed italic font-light">
                                "{{ $rev->comment }}"
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-[#d6aa62]/15 flex items-center justify-between text-[11px]">
                            <div>
                                <span class="font-semibold text-[#f5efe7] block">{{ $rev->user_name }}</span>
                                <span class="text-emerald-400 text-[10px]"><i class="fas fa-check-circle"></i> Verified &bull; {{ $rev->user_city ?? 'Pakistan' }}</span>
                            </div>
                            <span class="text-[#8e7c75] text-[10px]">{{ $rev->product->name ?? 'Extrait' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- 9. Fragrance Journal Preview -->
@if($recentBlogs->count() > 0)
    <section class="py-16 sm:py-20 bg-[#050203] luxury-wine-bg">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between mb-10 pb-4 border-b border-[#d6aa62]/20">
                <div>
                    <span class="text-[11px] uppercase tracking-[0.3em] text-[#d6aa62] font-semibold block mb-1">FRAGRANCE JOURNAL</span>
                    <h2 class="font-serif text-3xl md:text-4xl text-[#f5efe7] font-normal uppercase">Olfactory Chronicles & Guides</h2>
                </div>
                <a href="{{ route('blogs.index') }}" class="mt-4 md:mt-0 text-xs uppercase tracking-widest text-[#d6aa62] hover:text-[#f0d59d] font-bold flex items-center space-x-1.5 transition">
                    <span>Read All Articles</span>
                    <i class="fas fa-arrow-right text-[11px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($recentBlogs as $hBlog)
                    <article class="bg-gradient-to-b from-[#18050b] via-[#100306] to-[#070103] border border-[#d6aa62]/25 rounded-2xl overflow-hidden group hover:border-[#d6aa62]/70 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                        <div class="h-48 overflow-hidden bg-[#0c0305]">
                            <img src="{{ asset($hBlog->cover_image ?? 'assets/images/perfumes/prod_oud_royale.jpg') }}" 
                                 alt="{{ $hBlog->title }}" 
                                 onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-[#d6aa62] block mb-1 font-semibold">{{ $hBlog->category_name ?? 'Haute Parfumerie' }}</span>
                                <h3 class="font-serif text-xl text-[#f5efe7] group-hover:text-[#f0d59d] transition-colors leading-snug font-medium">
                                    <a href="{{ route('blogs.show', $hBlog->slug) }}">{{ $hBlog->title }}</a>
                                </h3>
                            </div>
                            <div class="text-[11px] text-[#b8a9a2] pt-3 border-t border-[#d6aa62]/15 flex justify-between items-center">
                                <span>{{ $hBlog->published_at ? \Carbon\Carbon::parse($hBlog->published_at)->format('M d, Y') : 'Recent' }}</span>
                                <span class="text-[#d6aa62] font-semibold">Read Guide &rarr;</span>
                            </div>
                        </div>
                    </article>
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
