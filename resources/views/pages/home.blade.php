@extends('layouts.app')

@section('title', 'Perfumes Collection | Luxury Extrait de Parfum Impressions Pakistan')
@section('meta_description', 'Discover hand-macerated Extrait de Parfum impressions inspired by iconic global niche fragrance houses. 35%-40% oil concentration, 14+ hours longevity, Cash on Delivery nationwide.')

@section('content')

<!-- 1. Hero Full-Screen Swiper Slider (Dynamic from Database $heroSlides) -->
<section class="hero-slider-section relative w-full h-[85vh] min-h-[580px] max-h-[850px] bg-gradient-to-b from-gray-950 via-gray-900 to-black overflow-hidden border-b border-amber-600/20">
    <div class="swiper hero-master-swiper w-full h-full">
        <div class="swiper-wrapper">
            @forelse($heroSlides as $slide)
                <div class="swiper-slide relative w-full h-full flex items-center bg-gray-950">
                    <!-- Ambient Glow / Aura -->
                    <div class="absolute inset-0 bg-radial-gradient opacity-30 pointer-events-none"></div>
                    
                    <div class="container mx-auto px-4 lg:px-8 relative z-10 h-full flex items-center">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center w-full py-12">
                            
                            <!-- Left: Staggered Text Reveal -->
                            <div class="lg:col-span-7 space-y-6 text-left">
                                @if($slide->subtitle)
                                    <div class="inline-flex items-center space-x-2 bg-amber-950/70 border border-amber-500/40 px-3 py-1 rounded text-[11px] font-semibold tracking-[0.25em] text-amber-300 uppercase">
                                        <i class="fas fa-crown text-[10px] text-amber-400"></i>
                                        <span>{{ $slide->subtitle }}</span>
                                    </div>
                                @endif

                                <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl text-white leading-tight font-normal">
                                    {!! $slide->title !!}
                                </h1>

                                @if($slide->description)
                                    <p class="text-sm sm:text-base text-gray-300 font-light max-w-xl leading-relaxed">
                                        {{ $slide->description }}
                                    </p>
                                @endif

                                <!-- Hero CTAs -->
                                <div class="flex flex-wrap items-center gap-4 pt-2">
                                    <a href="{{ $slide->button_url ?? route('collections.show', 'exclusive') }}" class="btn-gold">
                                        <i class="fas fa-gem mr-2"></i> {{ $slide->button_text ?? 'EXPLORE IMPRESSIONS' }}
                                    </a>

                                    <button type="button" onclick="document.getElementById('scentQuizModal').classList.add('active')" class="btn-outline-gold">
                                        <i class="fas fa-wand-magic-sparkles mr-2 text-amber-400"></i> SCENT ADVISOR
                                    </button>

                                    <a href="https://wa.me/{{ $whatsappNum }}?text={{ urlencode('Salam! I am interested in ordering your flagship Extrait collection.') }}" target="_blank" class="btn-whatsapp hidden sm:inline-flex">
                                        <i class="fab fa-whatsapp mr-2"></i> 1-CLICK ORDER
                                    </a>
                                </div>

                                <!-- Trust Indicators -->
                                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-gray-800 text-[11px] text-gray-300">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-shield-alt text-amber-400 text-base"></i>
                                        <span><strong>38% Extrait</strong><br>Pure Concentration</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-plane-departure text-amber-400 text-base"></i>
                                        <span><strong>24h Express Air</strong><br>Karachi, LHR, ISB</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-hand-holding-dollar text-amber-400 text-base"></i>
                                        <span><strong>Cash on Delivery</strong><br>All Pakistan Cities</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Flacon Presentation with Floating Stats -->
                            <div class="lg:col-span-5 relative text-center flex items-center justify-center">
                                <div class="relative w-72 sm:w-80 h-80 sm:h-96 flex items-center justify-center">
                                    <img 
                                        src="{{ asset($slide->image_url ?? 'assets/images/perfumes/oud_royale.svg') }}" 
                                        alt="{{ $slide->title }}" 
                                        class="w-full h-full object-contain filter drop-shadow-2xl animate-float"
                                    >

                                    <!-- Floating Benchmark 1 -->
                                    <div class="absolute -top-2 right-0 bg-gray-900/90 border border-amber-500/40 px-3 py-2 rounded-lg text-left shadow-2xl backdrop-blur-sm hidden sm:flex items-center space-x-2">
                                        <div class="w-8 h-8 rounded-full bg-amber-500/20 flex items-center justify-center text-amber-400 text-xs">
                                            <i class="fas fa-hourglass-start"></i>
                                        </div>
                                        <div>
                                            <div class="text-[9px] uppercase tracking-wider text-amber-300">Longevity Benchmark</div>
                                            <div class="text-xs font-semibold text-white">16 - 20 Hours</div>
                                        </div>
                                    </div>

                                    <!-- Floating Benchmark 2 -->
                                    <div class="absolute -bottom-2 left-0 bg-gray-900/90 border border-amber-500/40 px-3 py-2 rounded-lg text-left shadow-2xl backdrop-blur-sm hidden sm:flex items-center space-x-2">
                                        <div class="w-8 h-8 rounded-full bg-amber-500/20 flex items-center justify-center text-amber-400 text-xs">
                                            <i class="fas fa-award"></i>
                                        </div>
                                        <div>
                                            <div class="text-[9px] uppercase tracking-wider text-amber-300">Maceration</div>
                                            <div class="text-xs font-semibold text-white">90 Days Artisanal</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback Slide if table empty -->
                <div class="swiper-slide relative w-full h-full flex items-center bg-gray-950">
                    <div class="container mx-auto px-4 text-center">
                        <h1 class="font-serif text-4xl text-white">Artisanal Extrait de Parfum</h1>
                        <a href="{{ route('collections.show', 'all') }}" class="btn-gold mt-6 inline-block">EXPLORE CATALOG</a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Swiper Navigation Arrows & Pagination Dots -->
        <div class="swiper-button-prev !text-amber-400 !w-10 !h-10 rounded-full border border-amber-500/40 bg-black/50 backdrop-blur-sm after:!text-sm"></div>
        <div class="swiper-button-next !text-amber-400 !w-10 !h-10 rounded-full border border-amber-500/40 bg-black/50 backdrop-blur-sm after:!text-sm"></div>
        <div class="swiper-pagination !bottom-4 !text-amber-400"></div>
    </div>
</section>

<!-- 2. Value Proposition Bar (Core Rawaha Feature) -->
<section class="bg-gray-50 border-b border-gray-200 py-6">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left">
            
            <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-3.5">
                <div class="w-11 h-11 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center text-lg flex-shrink-0">
                    <i class="fas fa-fire-flame-curved"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-900">14+ Hours Longevity</h4>
                    <p class="text-[11px] text-gray-500">35%–40% Extrait de Parfum concentration</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-3.5">
                <div class="w-11 h-11 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center text-lg flex-shrink-0">
                    <i class="fas fa-flask"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-900">French Grade Oils</h4>
                    <p class="text-[11px] text-gray-500">Masterfully blended & cold-macerated</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-3.5">
                <div class="w-11 h-11 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center text-lg flex-shrink-0">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-900">Free Express Delivery</h4>
                    <p class="text-[11px] text-gray-500">Nationwide across Pakistan (Rs. 3,500+)</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-3.5">
                <div class="w-11 h-11 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center text-lg flex-shrink-0">
                    <i class="fas fa-hand-holding-dollar"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-900">Cash on Delivery</h4>
                    <p class="text-[11px] text-gray-500">Zero fee with hassle-free exchange</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 3. Featured Category Tiles (Clean Rawaha Style) -->
<section class="py-16 bg-white border-b border-gray-100">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-[11px] uppercase tracking-[0.25em] text-amber-800 font-bold">DISCOVER OUR CRAFT</span>
            <h2 class="font-serif text-3xl md:text-4xl text-gray-900 mt-2 font-normal">Explore by Olfactory House</h2>
            <div class="w-14 h-0.5 bg-amber-600 mx-auto mt-3"></div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <!-- Tile 1: Exclusive Reserve -->
            <a href="{{ route('collections.show', 'exclusive') }}" class="group relative h-64 md:h-80 rounded-xl overflow-hidden border border-gray-200 bg-gray-50 flex flex-col justify-end p-6 shadow-sm hover:shadow-xl hover:border-amber-400 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-10"></div>
                <img src="{{ asset('assets/images/perfumes/oud_royale.svg') }}" alt="Exclusive Reserve" class="absolute inset-0 w-full h-full object-contain p-6 transform group-hover:scale-105 transition-transform duration-500">
                
                <div class="relative z-20 space-y-1">
                    <span class="text-[10px] uppercase tracking-[0.2em] text-amber-300 font-semibold block">35% - 40% CONCENTRATION</span>
                    <h3 class="font-serif text-xl text-white group-hover:text-amber-200 transition-colors">Exclusive Reserve</h3>
                    <p class="text-[11px] text-gray-200">Rare agarwood & amber distillations</p>
                </div>
            </a>

            <!-- Tile 2: Men's Haute Parfumerie -->
            <a href="{{ route('collections.show', 'men') }}" class="group relative h-64 md:h-80 rounded-xl overflow-hidden border border-gray-200 bg-gray-50 flex flex-col justify-end p-6 shadow-sm hover:shadow-xl hover:border-amber-400 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-10"></div>
                <img src="{{ asset('assets/images/perfumes/sultan_cuir.svg') }}" alt="Men's Impressions" class="absolute inset-0 w-full h-full object-contain p-6 transform group-hover:scale-105 transition-transform duration-500">
                
                <div class="relative z-20 space-y-1">
                    <span class="text-[10px] uppercase tracking-[0.2em] text-amber-300 font-semibold block">COMMANDING PROJECTION</span>
                    <h3 class="font-serif text-xl text-white group-hover:text-amber-200 transition-colors">Men's Impressions</h3>
                    <p class="text-[11px] text-gray-200">Smoky leather, wood, and fresh citrus</p>
                </div>
            </a>

            <!-- Tile 3: Women's Imperial Flora -->
            <a href="{{ route('collections.show', 'women') }}" class="group relative h-64 md:h-80 rounded-xl overflow-hidden border border-gray-200 bg-gray-50 flex flex-col justify-end p-6 shadow-sm hover:shadow-xl hover:border-amber-400 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-10"></div>
                <img src="{{ asset('assets/images/perfumes/noor_gulab.svg') }}" alt="Women's Impressions" class="absolute inset-0 w-full h-full object-contain p-6 transform group-hover:scale-105 transition-transform duration-500">
                
                <div class="relative z-20 space-y-1">
                    <span class="text-[10px] uppercase tracking-[0.2em] text-amber-300 font-semibold block">ETHEREAL GRACE</span>
                    <h3 class="font-serif text-xl text-white group-hover:text-amber-200 transition-colors">Women's Impressions</h3>
                    <p class="text-[11px] text-gray-200">Taif rose, jasmine, and sweet vanilla</p>
                </div>
            </a>

            <!-- Tile 4: Unisex & Pure Oud -->
            <a href="{{ route('collections.show', 'unisex') }}" class="group relative h-64 md:h-80 rounded-xl overflow-hidden border border-gray-200 bg-gray-50 flex flex-col justify-end p-6 shadow-sm hover:shadow-xl hover:border-amber-400 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-10"></div>
                <img src="{{ asset('assets/images/perfumes/lahore_nights.svg') }}" alt="Unisex & Pure Oud" class="absolute inset-0 w-full h-full object-contain p-6 transform group-hover:scale-105 transition-transform duration-500">
                
                <div class="relative z-20 space-y-1">
                    <span class="text-[10px] uppercase tracking-[0.2em] text-amber-300 font-semibold block">TRANSCENDENT HARMONY</span>
                    <h3 class="font-serif text-xl text-white group-hover:text-amber-200 transition-colors">Unisex & Pure Oud</h3>
                    <p class="text-[11px] text-gray-200">Precious resins, ambergris, and oud</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- 4. Bestsellers Carousel (Swiper) -->
<section class="py-16 bg-gray-50 border-b border-gray-200">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between mb-10 pb-4 border-b border-gray-200">
            <div>
                <span class="text-[11px] uppercase tracking-[0.25em] text-amber-800 font-bold">CLIENT FAVORITES</span>
                <h2 class="font-serif text-2xl md:text-3xl text-gray-900 mt-1 font-normal">Bestselling Impressions</h2>
            </div>
            <a href="{{ route('collections.show', 'all') }}" class="mt-4 md:mt-0 text-xs uppercase tracking-widest text-amber-800 hover:text-amber-900 font-semibold flex items-center space-x-1.5 transition">
                <span>View Full Catalog</span>
                <i class="fas fa-arrow-right text-[11px]"></i>
            </a>
        </div>

        <div class="swiper bestsellers-swiper">
            <div class="swiper-wrapper">
                @foreach($bestsellers as $bProduct)
                    <div class="swiper-slide h-auto">
                        <x-product-card :product="$bProduct" />
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination !-bottom-8"></div>
        </div>
    </div>
</section>

<!-- 5. Bundles Spotlight Section (Inspired by BuyRawaha) -->
@if($bundles->count() > 0)
    <section class="py-16 bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-[11px] uppercase tracking-[0.25em] text-amber-800 font-bold">CURATED COFFRETS & SIGNATURE PAIRINGS</span>
                <h2 class="font-serif text-3xl md:text-4xl text-gray-900 mt-2 font-normal">Luxury Fragrance Bundles</h2>
                <p class="text-xs md:text-sm text-gray-600 mt-2">
                    Presented in custom gold-stamped coffrets. Enjoy up to 30% privileged savings across Pakistan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($bundles as $bundle)
                    <x-bundle-card :bundle="$bundle" />
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('collections.show', 'bundles') }}" class="btn-outline-gold inline-flex items-center space-x-2 text-gray-900 border-amber-700 hover:bg-amber-50">
                    <i class="fas fa-gift text-amber-800"></i>
                    <span>VIEW ALL DISCOVERY BUNDLES & GIFT SETS</span>
                </a>
            </div>
        </div>
    </section>
@endif

<!-- 6. New Arrivals Grid -->
<section class="py-16 bg-gray-50 border-b border-gray-200">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-[11px] uppercase tracking-[0.25em] text-amber-800 font-bold">FRESHLY MACERATED</span>
            <h2 class="font-serif text-3xl md:text-4xl text-gray-900 mt-2 font-normal">New Release Impressions</h2>
            <div class="w-14 h-0.5 bg-amber-600 mx-auto mt-3"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @foreach($newArrivals as $nProduct)
                <x-product-card :product="$nProduct" />
            @endforeach
        </div>
    </div>
</section>

<!-- 7. Why Choose RAVAHA Impressions? (Rawaha Style Comparison) -->
<section class="py-20 bg-white border-b border-gray-200">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-[11px] uppercase tracking-[0.25em] text-amber-800 font-bold">THE RAVAHA DIFFERENCE</span>
            <h2 class="font-serif text-3xl md:text-4xl text-gray-900 mt-2 font-normal">
                Why Discerning Connoisseurs Choose Our Impressions
            </h2>
            <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                Standard commercial perfumes dilute formulations down to 10%–15% alcohol solutions. RAVAHA crafts pure Extrait de Parfum hand-macerated for 90 days specifically designed for Pakistan's climate.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="p-8 rounded-xl border border-gray-200 bg-gray-50/60 shadow-sm text-center space-y-4 hover:border-amber-400 transition">
                <div class="w-14 h-14 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center text-2xl mx-auto">
                    <i class="fas fa-droplet"></i>
                </div>
                <h3 class="font-serif text-xl text-gray-900 font-semibold">35% - 40% Extrait Concentration</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Nearly double the oil density of department store Eau de Parfum. Delivers monumental 14 to 18 hours longevity on skin and fabric without synthetic alcohol harshness.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="p-8 rounded-xl border border-gray-200 bg-gray-50/60 shadow-sm text-center space-y-4 hover:border-amber-400 transition">
                <div class="w-14 h-14 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center text-2xl mx-auto">
                    <i class="fas fa-wand-magic-sparkles"></i>
                </div>
                <h3 class="font-serif text-xl text-gray-900 font-semibold">Grasse French Fragrance Oils</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    We formulate exclusively with premium French grade oils and natural agarwood distillations, resulting in a 95%+ olfactory fidelity to the world's most coveted niche fragrances.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="p-8 rounded-xl border border-gray-200 bg-gray-50/60 shadow-sm text-center space-y-4 hover:border-amber-400 transition">
                <div class="w-14 h-14 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center text-2xl mx-auto">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <h3 class="font-serif text-xl text-gray-900 font-semibold">Hassle-Free Pakistani Experience</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Zero hassle Cash on Delivery nationwide, complimentary 24-48 hour TCS Express Air dispatch, and an unconditional 7-day scent exchange policy.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- 8. Testimonials Section -->
@if($recentReviews->count() > 0)
    <section class="py-16 bg-gray-50 border-b border-gray-200">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-10">
                <span class="text-[11px] uppercase tracking-[0.25em] text-amber-800 font-bold">VERIFIED PATRON REVIEWS</span>
                <h2 class="font-serif text-3xl text-gray-900 mt-1 font-normal">What Connoisseurs Say</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($recentReviews as $rev)
                    <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition">
                        <div class="space-y-3">
                            <div class="flex text-amber-500 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $rev->rating ? '' : 'text-gray-200' }}"></i>
                                @endfor
                            </div>
                            <h4 class="font-serif text-base text-gray-900 font-semibold">{{ $rev->review_title ?? 'Majestic Longevity' }}</h4>
                            <p class="text-xs text-gray-600 leading-relaxed italic">
                                "{{ $rev->comment }}"
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between text-[11px]">
                            <div>
                                <span class="font-semibold text-gray-900 block">{{ $rev->user_name }}</span>
                                <span class="text-emerald-700 text-[10px]"><i class="fas fa-check-circle"></i> Verified &bull; {{ $rev->user_city ?? 'Pakistan' }}</span>
                            </div>
                            <span class="text-gray-400 text-[10px]">{{ $rev->product->name ?? 'Extrait' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- 9. Fragrance Journal Preview -->
@if($recentBlogs->count() > 0)
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between mb-10 pb-4 border-b border-gray-200">
                <div>
                    <span class="text-[11px] uppercase tracking-[0.25em] text-amber-800 font-bold">FRAGRANCE JOURNAL</span>
                    <h2 class="font-serif text-2xl md:text-3xl text-gray-900 mt-1 font-normal">Olfactory Chronicles & Guides</h2>
                </div>
                <a href="{{ route('blogs.index') }}" class="mt-4 md:mt-0 text-xs uppercase tracking-widest text-amber-800 hover:text-amber-900 font-semibold flex items-center space-x-1.5 transition">
                    <span>Read All Articles</span>
                    <i class="fas fa-arrow-right text-[11px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($recentBlogs as $hBlog)
                    <article class="bg-gray-50 border border-gray-200 rounded-xl overflow-hidden group hover:border-amber-400 hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                        <div class="h-48 overflow-hidden bg-gray-100">
                            <img src="{{ asset($hBlog->cover_image ?? 'assets/images/perfumes/blog_oud_guide.svg') }}" alt="{{ $hBlog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-amber-800 block mb-1 font-semibold">{{ $hBlog->category_name ?? 'Haute Parfumerie' }}</span>
                                <h3 class="font-serif text-lg text-gray-900 group-hover:text-amber-800 transition-colors leading-snug font-medium">
                                    <a href="{{ route('blogs.show', $hBlog->slug) }}">{{ $hBlog->title }}</a>
                                </h3>
                            </div>
                            <div class="text-[11px] text-gray-500 pt-3 border-t border-gray-200 flex justify-between items-center">
                                <span>{{ $hBlog->published_at ? \Carbon\Carbon::parse($hBlog->published_at)->format('M d, Y') : 'Recent' }}</span>
                                <span class="text-amber-800 font-medium">Read Guide &rarr;</span>
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
                delay: 5500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            speed: 1000,
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
            spaceBetween: 16,
            loop: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 20 },
                768: { slidesPerView: 3, spaceBetween: 24 },
                1024: { slidesPerView: 4, spaceBetween: 24 }
            }
        });
    });
</script>
@endpush
