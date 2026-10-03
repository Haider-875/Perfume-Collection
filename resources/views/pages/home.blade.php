@extends('layouts.app')

@section('title', 'Maison d\'Orient | Haute Parfumerie & Extrait de Parfum Pakistan')
@section('meta_description', 'Hand-macerated Extrait de Parfum and pure Cambodian Dehn al Oud formulated for monumental 16+ hour longevity in Pakistan. 100% authentic luxury.')

@section('content')

<!-- 1. Hero Full-Screen Swiper Slider (Loaded from Database $heroSlides) -->
<section class="hero-slider-section relative w-full h-[85vh] min-h-[580px] max-h-[850px] bg-[#080304] overflow-hidden border-b border-[#C9A24B]/20">
    <div class="swiper hero-master-swiper w-full h-full">
        <div class="swiper-wrapper">
            @forelse($heroSlides as $slide)
                <div class="swiper-slide relative w-full h-full flex items-center bg-[#080304]">
                    <!-- Ambient Glow / Aura -->
                    <div class="absolute inset-0 bg-radial-gradient opacity-30 pointer-events-none"></div>
                    
                    <div class="container mx-auto px-4 lg:px-8 relative z-10 h-full flex items-center">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center w-full py-12">
                            
                            <!-- Left: Staggered Text Reveal -->
                            <div class="lg:col-span-7 space-y-6 text-left">
                                @if($slide->subtitle)
                                    <div class="inline-flex items-center space-x-2 bg-[#4A0E17]/80 border border-[#C9A24B]/40 px-3 py-1 rounded text-[11px] font-semibold tracking-[0.25em] text-[#C9A24B] uppercase">
                                        <i class="fas fa-crown text-[10px]"></i>
                                        <span>{{ $slide->subtitle }}</span>
                                    </div>
                                @endif

                                <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl text-[#F5EFE6] leading-tight font-normal">
                                    {!! $slide->title !!}
                                </h1>

                                @if($slide->description)
                                    <p class="text-sm sm:text-base text-[#F5EFE6]/75 font-light max-w-xl leading-relaxed">
                                        {{ $slide->description }}
                                    </p>
                                @endif

                                <!-- Hero CTAs -->
                                <div class="flex flex-wrap items-center gap-4 pt-2">
                                    <a href="{{ $slide->button_url ?? route('collections.show', 'exclusive') }}" class="btn-gold">
                                        <i class="fas fa-gem mr-2"></i> {{ $slide->button_text ?? 'EXPLORE THE VAULT' }}
                                    </a>

                                    <button type="button" onclick="document.getElementById('scentQuizModal').classList.add('active')" class="btn-outline-gold">
                                        <i class="fas fa-wand-magic-sparkles mr-2 text-[#C9A24B]"></i> SCENT ADVISOR
                                    </button>

                                    <a href="https://wa.me/923001234567?text={{ urlencode('Salam! I am interested in ordering your flagship Extrait collection.') }}" target="_blank" class="btn-whatsapp hidden sm:inline-flex">
                                        <i class="fab fa-whatsapp mr-2"></i> 1-CLICK ORDER
                                    </a>
                                </div>

                                <!-- Trust Indicators -->
                                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-[#C9A24B]/15 text-[11px] text-[#F5EFE6]/70">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-shield-alt text-[#C9A24B] text-base"></i>
                                        <span><strong>38% Extrait</strong><br>Pure Concentration</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-plane-departure text-[#C9A24B] text-base"></i>
                                        <span><strong>24h Express Air</strong><br>Karachi, LHR, ISB</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-hand-holding-dollar text-[#C9A24B] text-base"></i>
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
                                    <div class="absolute -top-2 right-0 bg-[#0E0507]/90 border border-[#C9A24B]/40 px-3 py-2 rounded-lg text-left shadow-2xl backdrop-blur-sm hidden sm:flex items-center space-x-2">
                                        <div class="w-8 h-8 rounded-full bg-[#C9A24B]/20 flex items-center justify-center text-[#C9A24B] text-xs">
                                            <i class="fas fa-hourglass-start"></i>
                                        </div>
                                        <div>
                                            <div class="text-[9px] uppercase tracking-wider text-[#C9A24B]">Longevity Benchmark</div>
                                            <div class="text-xs font-semibold text-[#F5EFE6]">16 - 20 Hours</div>
                                        </div>
                                    </div>

                                    <!-- Floating Benchmark 2 -->
                                    <div class="absolute -bottom-2 left-0 bg-[#0E0507]/90 border border-[#C9A24B]/40 px-3 py-2 rounded-lg text-left shadow-2xl backdrop-blur-sm hidden sm:flex items-center space-x-2">
                                        <div class="w-8 h-8 rounded-full bg-[#C9A24B]/20 flex items-center justify-center text-[#C9A24B] text-xs">
                                            <i class="fas fa-award"></i>
                                        </div>
                                        <div>
                                            <div class="text-[9px] uppercase tracking-wider text-[#C9A24B]">Maceration</div>
                                            <div class="text-xs font-semibold text-[#F5EFE6]">90 Days Artisanal</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback Slide if table empty -->
                <div class="swiper-slide relative w-full h-full flex items-center bg-[#080304]">
                    <div class="container mx-auto px-4 text-center">
                        <h1 class="font-serif text-4xl text-[#F5EFE6]">Imperial Extrait de Parfum</h1>
                        <a href="{{ route('collections.show', 'all') }}" class="btn-gold mt-6 inline-block">EXPLORE VAULT</a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Swiper Navigation Arrows & Pagination Dots -->
        <div class="swiper-button-prev !text-[#C9A24B] !w-10 !h-10 rounded-full border border-[#C9A24B]/40 bg-black/40 backdrop-blur-sm after:!text-sm"></div>
        <div class="swiper-button-next !text-[#C9A24B] !w-10 !h-10 rounded-full border border-[#C9A24B]/40 bg-black/40 backdrop-blur-sm after:!text-sm"></div>
        <div class="swiper-pagination !bottom-4 !text-[#C9A24B]"></div>
    </div>
</section>

<!-- 2. Featured Category Tiles (Men, Women, Unisex, Exclusive) with Hover Zoom -->
<section class="py-16 bg-[#0A0405] border-b border-[#C9A24B]/15">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] font-semibold">CURATED OLFACTORY HOUSES</span>
            <h2 class="font-serif text-3xl md:text-4xl text-[#F5EFE6] mt-2">The Imperial Pillars</h2>
            <div class="w-16 h-0.5 bg-gradient-to-r from-transparent via-[#C9A24B] to-transparent mx-auto mt-3"></div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <!-- Tile 1: Exclusive Reserve -->
            <a href="{{ route('collections.show', 'exclusive') }}" class="group relative h-64 md:h-80 rounded-lg overflow-hidden border border-[#C9A24B]/25 bg-[#120709] flex flex-col justify-end p-6 shadow-2xl hover:border-[#C9A24B] transition-all duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-[#080304] via-[#080304]/60 to-transparent z-10"></div>
                <img src="{{ asset('assets/images/perfumes/oud_royale.svg') }}" alt="Exclusive Reserve" class="absolute inset-0 w-full h-full object-contain p-6 transform group-hover:scale-110 transition-transform duration-700">
                
                <div class="relative z-20 space-y-1">
                    <span class="text-[10px] uppercase tracking-[0.25em] text-[#C9A24B] font-semibold block">EXTRAIT DE PARFUM</span>
                    <h3 class="font-serif text-xl text-[#F5EFE6] group-hover:text-[#C9A24B] transition-colors">Exclusive Reserve</h3>
                    <p class="text-[11px] text-[#F5EFE6]/60">Rare vintage agarwood & amber</p>
                </div>
            </a>

            <!-- Tile 2: Men's Haute Parfumerie -->
            <a href="{{ route('collections.show', 'men') }}" class="group relative h-64 md:h-80 rounded-lg overflow-hidden border border-[#C9A24B]/25 bg-[#120709] flex flex-col justify-end p-6 shadow-2xl hover:border-[#C9A24B] transition-all duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-[#080304] via-[#080304]/60 to-transparent z-10"></div>
                <img src="{{ asset('assets/images/perfumes/leather_flacon.svg') }}" alt="Men's Parfums" class="absolute inset-0 w-full h-full object-contain p-6 transform group-hover:scale-110 transition-transform duration-700">
                
                <div class="relative z-20 space-y-1">
                    <span class="text-[10px] uppercase tracking-[0.25em] text-[#C9A24B] font-semibold block">MAJESTIC PROJECTION</span>
                    <h3 class="font-serif text-xl text-[#F5EFE6] group-hover:text-[#C9A24B] transition-colors">Men's Parfums</h3>
                    <p class="text-[11px] text-[#F5EFE6]/60">Smoky birch, leather & cedar</p>
                </div>
            </a>

            <!-- Tile 3: Women's Imperial Flora -->
            <a href="{{ route('collections.show', 'women') }}" class="group relative h-64 md:h-80 rounded-lg overflow-hidden border border-[#C9A24B]/25 bg-[#120709] flex flex-col justify-end p-6 shadow-2xl hover:border-[#C9A24B] transition-all duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-[#080304] via-[#080304]/60 to-transparent z-10"></div>
                <img src="{{ asset('assets/images/perfumes/rose_flacon.svg') }}" alt="Women's Flora" class="absolute inset-0 w-full h-full object-contain p-6 transform group-hover:scale-110 transition-transform duration-700">
                
                <div class="relative z-20 space-y-1">
                    <span class="text-[10px] uppercase tracking-[0.25em] text-[#C9A24B] font-semibold block">ETHEREAL SILK</span>
                    <h3 class="font-serif text-xl text-[#F5EFE6] group-hover:text-[#C9A24B] transition-colors">Women's Flora</h3>
                    <p class="text-[11px] text-[#F5EFE6]/60">Taif rose, jasmine & white amber</p>
                </div>
            </a>

            <!-- Tile 4: Unisex & Pure Oud -->
            <a href="{{ route('collections.show', 'unisex') }}" class="group relative h-64 md:h-80 rounded-lg overflow-hidden border border-[#C9A24B]/25 bg-[#120709] flex flex-col justify-end p-6 shadow-2xl hover:border-[#C9A24B] transition-all duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-[#080304] via-[#080304]/60 to-transparent z-10"></div>
                <img src="{{ asset('assets/images/perfumes/amber_flacon.svg') }}" alt="Unisex & Pure Oud" class="absolute inset-0 w-full h-full object-contain p-6 transform group-hover:scale-110 transition-transform duration-700">
                
                <div class="relative z-20 space-y-1">
                    <span class="text-[10px] uppercase tracking-[0.25em] text-[#C9A24B] font-semibold block">TRANSCENDENT HARMONY</span>
                    <h3 class="font-serif text-xl text-[#F5EFE6] group-hover:text-[#C9A24B] transition-colors">Unisex & Pure Oud</h3>
                    <p class="text-[11px] text-[#F5EFE6]/60">Sacred resins & ambergris</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- 3. Bestsellers Carousel (Swiper) -->
<section class="py-16 bg-[#080304]">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between mb-10 pb-4 border-b border-[#C9A24B]/20">
            <div>
                <span class="text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] font-semibold">ICONIC FORMULATIONS</span>
                <h2 class="font-serif text-2xl md:text-3xl text-[#F5EFE6] mt-1">The Bestsellers Collection</h2>
            </div>
            <a href="{{ route('collections.show', 'all') }}" class="mt-4 md:mt-0 text-xs uppercase tracking-widest text-[#C9A24B] hover:underline flex items-center space-x-1">
                <span>View Full Vault</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
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

<!-- 4. Bundles Spotlight Section (Inspired by BuyRawaha) -->
@if($bundles->count() > 0)
    <section class="py-16 bg-[#0D0507] border-y border-[#C9A24B]/20">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] font-semibold">CURATED COFFRETS & SIGNATURE PAIRINGS</span>
                <h2 class="font-serif text-3xl md:text-4xl text-[#F5EFE6] mt-2">Imperial Fragrance Bundles</h2>
                <p class="text-xs md:text-sm text-[#F5EFE6]/70 mt-2">
                    Presented in custom gold-stamped velvet coffrets. Enjoy up to 30% privileged savings across Pakistan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($bundles as $bundle)
                    <x-bundle-card :bundle="$bundle" />
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('collections.show', 'bundles') }}" class="btn-outline-gold inline-flex items-center space-x-2">
                    <i class="fas fa-gift text-[#C9A24B]"></i>
                    <span>VIEW ALL DISCOVERY BUNDLES & GIFTING</span>
                </a>
            </div>
        </div>
    </section>
@endif

<!-- 5. New Arrivals Grid -->
<section class="py-16 bg-[#080304]">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] font-semibold">RECENT MASTERPIECE RELEASES</span>
            <h2 class="font-serif text-3xl md:text-4xl text-[#F5EFE6] mt-2">New Extrait Arrivals</h2>
            <div class="w-16 h-0.5 bg-gradient-to-r from-transparent via-[#C9A24B] to-transparent mx-auto mt-3"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @foreach($newArrivals as $nProduct)
                <x-product-card :product="$nProduct" />
            @endforeach
        </div>
    </div>
</section>

<!-- 6. Brand Story & Artisanal Heritage (Parallax & Icons) -->
<section class="py-20 bg-[#0B0406] border-y border-[#C9A24B]/20 relative overflow-hidden">
    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-6 space-y-6">
                <span class="text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] font-semibold">THE ARTISANAL PHILOSOPHY</span>
                <h2 class="font-serif text-3xl md:text-5xl text-[#F5EFE6] leading-tight">
                    Crafting Extrait for the Connoisseurs of Pakistan
                </h2>
                <p class="text-sm md:text-base text-[#F5EFE6]/75 font-light leading-relaxed">
                    Born from a reverence for Mughal royal courts and Parisian Haute Parfumerie, Perfumes Collection blends ancient agarwood distillation techniques with contemporary French formulation.
                </p>
                <p class="text-sm md:text-base text-[#F5EFE6]/75 font-light leading-relaxed">
                    While commercial fragrances fade rapidly under Pakistan’s dry winters and humid monsoon summers, our Extrait formulations are hand-macerated for 90 days at 35%–40% oil concentration, creating a radiant 16+ hour aura.
                </p>

                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div class="p-4 bg-[#120709] border border-[#C9A24B]/20 rounded">
                        <div class="text-[#C9A24B] font-serif text-2xl font-bold">40%</div>
                        <div class="text-xs text-[#F5EFE6]/70 mt-1">Max Oil Concentration</div>
                    </div>
                    <div class="p-4 bg-[#120709] border border-[#C9A24B]/20 rounded">
                        <div class="text-[#C9A24B] font-serif text-2xl font-bold">100%</div>
                        <div class="text-xs text-[#F5EFE6]/70 mt-1">Ethical Agarwood & Taif Rose</div>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ route('pages.about') }}" class="btn-gold inline-flex items-center space-x-2">
                        <span>OUR ARTISANAL HERITAGE</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-6">
                <div class="relative rounded-lg overflow-hidden border border-[#C9A24B]/35 bg-[#14080B] p-6 shadow-2xl">
                    <img src="{{ asset('assets/images/perfumes/oud_royale.svg') }}" alt="Artisanal Heritage Flacon" class="w-72 h-72 mx-auto object-contain animate-float">
                    
                    <div class="mt-6 pt-6 border-t border-[#C9A24B]/20 grid grid-cols-3 gap-4 text-center text-xs">
                        <div>
                            <i class="fas fa-flask text-[#C9A24B] text-lg mb-1"></i>
                            <div class="font-serif text-[#F5EFE6]">Grasse Formulary</div>
                        </div>
                        <div>
                            <i class="fas fa-tree text-[#C9A24B] text-lg mb-1"></i>
                            <div class="font-serif text-[#F5EFE6]">Cambodian Oud</div>
                        </div>
                        <div>
                            <i class="fas fa-award text-[#C9A24B] text-lg mb-1"></i>
                            <div class="font-serif text-[#F5EFE6]">Macerated 90 Days</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 7. Testimonials Slider -->
@if($recentReviews->count() > 0)
    <section class="py-16 bg-[#080304]">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-10">
                <span class="text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] font-semibold">PATRON EXPERIENCES</span>
                <h2 class="font-serif text-3xl text-[#F5EFE6] mt-1">Words from Connoisseurs</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($recentReviews as $rev)
                    <div class="bg-[#0D0507] border border-[#C9A24B]/25 rounded-lg p-6 flex flex-col justify-between shadow-xl">
                        <div class="space-y-3">
                            <div class="flex text-[#C9A24B] text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $rev->rating ? '' : 'opacity-30' }}"></i>
                                @endfor
                            </div>
                            <h4 class="font-serif text-base text-[#F5EFE6] font-semibold">{{ $rev->review_title ?? 'Majestic Longevity' }}</h4>
                            <p class="text-xs text-[#F5EFE6]/70 leading-relaxed italic">
                                "{{ $rev->comment }}"
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-[#C9A24B]/15 flex items-center justify-between text-[11px]">
                            <div>
                                <span class="font-semibold text-[#F5EFE6] block">{{ $rev->user_name }}</span>
                                <span class="text-[#C9A24B] text-[10px]">{{ $rev->user_city ?? 'Pakistan' }} &bull; Verified Patron</span>
                            </div>
                            <span class="text-[#F5EFE6]/40 text-[10px]">{{ $rev->product->name ?? 'Extrait' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- 8. Fragrance Journal Preview -->
@if($recentBlogs->count() > 0)
    <section class="py-16 bg-[#0A0405] border-t border-[#C9A24B]/20">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between mb-10 pb-4 border-b border-[#C9A24B]/20">
                <div>
                    <span class="text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] font-semibold">THE ARTISANAL JOURNAL</span>
                    <h2 class="font-serif text-2xl md:text-3xl text-[#F5EFE6] mt-1">Olfactory Chronicles</h2>
                </div>
                <a href="{{ route('blogs.index') }}" class="mt-4 md:mt-0 text-xs uppercase tracking-widest text-[#C9A24B] hover:underline flex items-center space-x-1">
                    <span>Read All Chronicles</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($recentBlogs as $hBlog)
                    <article class="bg-[#0C0507] border border-[#C9A24B]/20 rounded-lg overflow-hidden group hover:border-[#C9A24B]/60 transition-all duration-300 flex flex-col justify-between">
                        <div class="h-48 overflow-hidden bg-[#14080B]">
                            <img src="{{ asset($hBlog->cover_image ?? 'assets/images/perfumes/blog_oud_guide.svg') }}" alt="{{ $hBlog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-[#C9A24B] block mb-1">{{ $hBlog->category_name ?? 'Haute Parfumerie' }}</span>
                                <h3 class="font-serif text-lg text-[#F5EFE6] group-hover:text-[#C9A24B] transition-colors leading-snug">
                                    <a href="{{ route('blogs.show', $hBlog->slug) }}">{{ $hBlog->title }}</a>
                                </h3>
                            </div>
                            <div class="text-[11px] text-[#F5EFE6]/50 pt-3 border-t border-[#C9A24B]/10 flex justify-between items-center">
                                <span>{{ $hBlog->published_at ? \Carbon\Carbon::parse($hBlog->published_at)->format('M d, Y') : 'Recent' }}</span>
                                <span class="text-[#C9A24B]">Read &rarr;</span>
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
