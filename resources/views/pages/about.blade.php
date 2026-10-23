@extends('layouts.app')

@section('title', 'Our Artisanal Craft & Heritage | Perfumes Collection Haute Parfumerie Pakistan')
@section('meta_description', 'Discover how Perfumes Collection crafts 35%-40% pure Extrait de Parfum hand-macerated for 90 days, calibrated specifically to withstand Pakistan’s climate with 8-10 hours longevity.')

@section('content')

<!-- 1. Hero Header Section -->
<section class="py-4 py-md-5 text-center position-relative overflow-hidden" style="background-color: #FAF7F2; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4 position-relative z-1" style="max-width: 860px;">
        
        <!-- Breadcrumbs Component (Simple Home link only to prevent large pill badge) -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')]
        ]" />

        <!-- Subtitle Text (Clean luxury text, no pill badge) -->
        <span class="d-inline-block mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.24em; text-transform: uppercase; color: #541B29;">
            HAUTE PARFUMERIE ATELIER • PAKISTAN
        </span>

        <h1 class="font-serif fw-bold mb-3" style="color: #211D1E; font-size: clamp(1.65rem, 3.5vw, 2.65rem); line-height: 1.25; letter-spacing: -0.01em;">
            The Sacred Alchemy of Extrait de Parfum
        </h1>

        <p class="mx-auto lh-base mb-4 fw-light" style="max-width: 680px; font-size: clamp(0.92rem, 1.8vw, 1.05rem); color: #5C524D; line-height: 1.7;">
            Commercial designer fragrances dilute formulations down to 10%–15% alcohol solutions that disappear in Pakistan’s heat. At Perfumes Collection, we compound authentic <strong>35% to 40% pure oil concentrations</strong>, hand-macerated for 90 days to achieve legendary 8 to 10 hours sillage.
        </p>

        <!-- 4 Quick Trust Badges (Perfect Centering, No Overflow on Mobile) -->
        <div class="row g-2 g-sm-3 pt-2 justify-content-center">
            
            <!-- Badge 1 -->
            <div class="col-6 col-md-3">
                <div class="p-2.5 p-sm-3 rounded-3 text-center shadow-xs h-100 d-flex flex-column align-items-center justify-content-center"
                     style="background: #FFFFFF; border: 1px solid #E8E0DA; min-height: 105px;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mb-1.5 shadow-xs" 
                         style="width: 36px; height: 36px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-droplet gradient-gold-icon" style="font-size: 13px;"></i>
                    </div>
                    <span class="fw-bold font-serif d-block" style="color: #211D1E; font-size: clamp(0.88rem, 3vw, 1.05rem); line-height: 1.2;">35% - 40%</span>
                    <span class="d-block text-muted fw-normal" style="font-size: clamp(9.5px, 2.2vw, 11px); color: #786C67 !important; line-height: 1.25;">Pure Extrait Density</span>
                </div>
            </div>

            <!-- Badge 2 -->
            <div class="col-6 col-md-3">
                <div class="p-2.5 p-sm-3 rounded-3 text-center shadow-xs h-100 d-flex flex-column align-items-center justify-content-center"
                     style="background: #FFFFFF; border: 1px solid #E8E0DA; min-height: 105px;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mb-1.5 shadow-xs" 
                         style="width: 36px; height: 36px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-hourglass-half gradient-gold-icon" style="font-size: 13px;"></i>
                    </div>
                    <span class="fw-bold font-serif d-block" style="color: #211D1E; font-size: clamp(0.88rem, 3vw, 1.05rem); line-height: 1.2;">90 Days</span>
                    <span class="d-block text-muted fw-normal" style="font-size: clamp(9.5px, 2.2vw, 11px); color: #786C67 !important; line-height: 1.25;">Dark Cellar Aged</span>
                </div>
            </div>

            <!-- Badge 3 -->
            <div class="col-6 col-md-3">
                <div class="p-2.5 p-sm-3 rounded-3 text-center shadow-xs h-100 d-flex flex-column align-items-center justify-content-center"
                     style="background: #FFFFFF; border: 1px solid #E8E0DA; min-height: 105px;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mb-1.5 shadow-xs" 
                         style="width: 36px; height: 36px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-shield-halved gradient-gold-icon" style="font-size: 13px;"></i>
                    </div>
                    <span class="fw-bold font-serif d-block" style="color: #211D1E; font-size: clamp(0.88rem, 3vw, 1.05rem); line-height: 1.2;">8-10 Hours</span>
                    <span class="d-block text-muted fw-normal" style="font-size: clamp(9.5px, 2.2vw, 11px); color: #786C67 !important; line-height: 1.25;">Pakistan Heat Tested</span>
                </div>
            </div>

            <!-- Badge 4 -->
            <div class="col-6 col-md-3">
                <div class="p-2.5 p-sm-3 rounded-3 text-center shadow-xs h-100 d-flex flex-column align-items-center justify-content-center"
                     style="background: #FFFFFF; border: 1px solid #E8E0DA; min-height: 105px;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mb-1.5 shadow-xs" 
                         style="width: 36px; height: 36px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-certificate gradient-gold-icon" style="font-size: 13px;"></i>
                    </div>
                    <span class="fw-bold font-serif d-block" style="color: #211D1E; font-size: clamp(0.88rem, 3vw, 1.05rem); line-height: 1.2;">French Grade</span>
                    <span class="d-block text-muted fw-normal" style="font-size: clamp(9.5px, 2.2vw, 11px); color: #786C67 !important; line-height: 1.25;">Imported Grasse Oils</span>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- 2. The Problem & The Solution: Why European Perfumes Fail in Pakistan -->
<section class="py-5" style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4">
        
        <!-- High Authority Narrative & Statement -->
        <div class="mx-auto text-center" style="max-width: 840px;">
            <span class="d-inline-block mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.22em; text-transform: uppercase; color: #541B29;">
                THE INDUSTRY REALITY
            </span>
            <h2 class="font-serif fw-bold mb-3" style="color: #211D1E; font-size: clamp(1.4rem, 2.8vw, 2.2rem); line-height: 1.3;">
                Why Designer Fragrances Vanish in Pakistan
            </h2>
            
            <p class="lh-base mb-3 fw-normal" style="font-size: clamp(0.92rem, 1.6vw, 1rem); color: #4A403A; line-height: 1.75;">
                Most international designer houses formulate their perfumes for cold European climates (15°C–20°C). When bottled at Eau de Toilette (10%) or standard Eau de Parfum (14%), over <strong>85% of the bottle is fast-evaporating industrial alcohol</strong>. In Pakistan—where summers reach 42°C in Lahore and Islamabad, and Karachi experiences intense coastal humidity—light alcohol formulations flash-evaporate into thin air within 2 to 3 hours, leaving behind nothing but a fading memory.
            </p>

            <!-- Callout Statement Box with Generous Responsive Padding & Margins for Mobile & Desktop -->
            <div class="rounded-3 shadow-xs text-start my-4 mx-auto" 
                 style="background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border-left: 4px solid #541B29; border-top: 1px solid #EAD8B8; border-right: 1px solid #EAD8B8; border-bottom: 1px solid #EAD8B8; padding: clamp(1.15rem, 3.5vw, 1.65rem); margin-top: 1.5rem !important; margin-bottom: 1.85rem !important;">
                <p class="mb-0 font-serif fst-italic" style="color: #211D1E; font-size: clamp(0.92rem, 2vw, 1.05rem); line-height: 1.7;">
                    We do not create perfumes for Parisian spring breezes. We engineer Extrait de Parfum to rule festive Pakistani wedding nights, air-conditioned corporate boardrooms, and sweltering summer afternoons.
                </p>
            </div>
        </div>

        <!-- Exclusive Perfume Cinema Video Slider (3 Video Slides, Clean & Luxury) -->
        <div class="position-relative mx-auto mt-3" style="max-width: 860px;">
            <div class="swiper about-video-swiper rounded-4 shadow-sm overflow-hidden" 
                 style="background: #0D0608; border: 1px solid #E8E0DA;">
                <div class="swiper-wrapper">
                    
                    <!-- Slide 1: 91° Gold Edition -->
                    <div class="swiper-slide">
                        <div class="position-relative w-100 overflow-hidden" style="aspect-ratio: 16/9; max-height: 480px; background: #0D0608;">
                            <video autoplay muted loop playsinline preload="auto" class="w-100 h-100 object-fit-cover" style="object-fit: cover; display: block;">
                                <source src="{{ asset('assets/videos/91_gold_banner.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                    </div>

                    <!-- Slide 2: Signature Extrait Collection -->
                    <div class="swiper-slide">
                        <div class="position-relative w-100 overflow-hidden" style="aspect-ratio: 16/9; max-height: 480px; background: #0D0608;">
                            <video autoplay muted loop playsinline preload="auto" class="w-100 h-100 object-fit-cover" style="object-fit: cover; display: block;">
                                <source src="{{ asset('assets/videos/91_perfume_banner.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                    </div>

                    <!-- Slide 3: Marjaan Extrait -->
                    <div class="swiper-slide">
                        <div class="position-relative w-100 overflow-hidden" style="aspect-ratio: 16/9; max-height: 480px; background: #0D0608;">
                            <video autoplay muted loop playsinline preload="auto" class="w-100 h-100 object-fit-cover" style="object-fit: cover; display: block;">
                                <source src="{{ asset('assets/videos/marjaan_perfume_banner.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                    </div>

                </div>


                <!-- Pagination Dots -->
                <div class="about-video-pagination position-absolute bottom-0 start-50 translate-middle-x z-3 pb-3 d-flex justify-content-center gap-1.5 pointer-events-none"></div>
            </div>
        </div>

    </div>
</section>

<!-- 3. The 4 Pillars of Our Craft (Artisanal Process) -->
<section class="py-5" style="background-color: #FAF7F2; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4">
        
        <div class="text-center mx-auto mb-4 mb-md-5" style="max-width: 700px;">
            <span class="d-inline-block mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.22em; text-transform: uppercase; color: #541B29;">
                OUR FOUR PILLARS
            </span>
            <h2 class="font-serif fs-2 fs-md-1 fw-bold text-uppercase mb-2" style="letter-spacing: 0.02em; color: #211D1E !important;">
                The Compounding Standards
            </h2>
            <p class="mb-0 fw-light" style="font-size: 0.94rem; color: #6B605B; line-height: 1.65;">
                Every flacon leaving our atelier adheres to stringent Haute Parfumerie codes practiced by historic perfume houses across Grasse and Florence.
            </p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3 g-md-4">
            
            <!-- Pillar 1 -->
            <div class="col">
                <div class="p-4 rounded-4 luxury-hover-card h-100 d-flex flex-column gap-3 shadow-sm transition"
                     style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <div class="rounded-3 d-flex align-items-center justify-content-center shadow-xs"
                         style="width: 48px; height: 48px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-seedling gradient-gold-icon fs-5"></i>
                    </div>
                    <div>
                        <span class="text-uppercase fw-semibold" style="font-size: 10px; letter-spacing: 0.15em; color: #9E7D3B;">PILLAR 01</span>
                        <h3 class="font-serif fs-5 fw-bold mb-1" style="color: #211D1E;">Grasse Grade-A Oils</h3>
                    </div>
                    <p class="text-xs mb-0 fw-light lh-base" style="color: #6B605B; font-size: 0.84rem; line-height: 1.6;">
                        Directly compounded using botanical concentrates from southern France, Italian bergamot, and 15-year aged wild Cambodian Dehn al Oud. Zero synthetic chemical petroleum fillers.
                    </p>
                </div>
            </div>

            <!-- Pillar 2 -->
            <div class="col">
                <div class="p-4 rounded-4 luxury-hover-card h-100 d-flex flex-column gap-3 shadow-sm transition"
                     style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <div class="rounded-3 d-flex align-items-center justify-content-center shadow-xs"
                         style="width: 48px; height: 48px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-droplet gradient-gold-icon fs-5"></i>
                    </div>
                    <div>
                        <span class="text-uppercase fw-semibold" style="font-size: 10px; letter-spacing: 0.15em; color: #9E7D3B;">PILLAR 02</span>
                        <h3 class="font-serif fs-5 fw-bold mb-1" style="color: #211D1E;">35% - 40% Extrait</h3>
                    </div>
                    <p class="text-xs mb-0 fw-light lh-base" style="color: #6B605B; font-size: 0.84rem; line-height: 1.6;">
                        The highest legal cosmetic concentration attainable. Nearly double the oil density of department store Eau de Parfum, guaranteeing monumental sillage and projection.
                    </p>
                </div>
            </div>

            <!-- Pillar 3 -->
            <div class="col">
                <div class="p-4 rounded-4 luxury-hover-card h-100 d-flex flex-column gap-3 shadow-sm transition"
                     style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <div class="rounded-3 d-flex align-items-center justify-content-center shadow-xs"
                         style="width: 48px; height: 48px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-moon gradient-gold-icon fs-5"></i>
                    </div>
                    <div>
                        <span class="text-uppercase fw-semibold" style="font-size: 10px; letter-spacing: 0.15em; color: #9E7D3B;">PILLAR 03</span>
                        <h3 class="font-serif fs-5 fw-bold mb-1" style="color: #211D1E;">90-Day Maceration</h3>
                    </div>
                    <p class="text-xs mb-0 fw-light lh-base" style="color: #6B605B; font-size: 0.84rem; line-height: 1.6;">
                        Unfiltered formulations mature inside dark temperature-stabilized chambers for 90 days. This molecular bonding eliminates any alcohol sharpness on the very first spray.
                    </p>
                </div>
            </div>

            <!-- Pillar 4 -->
            <div class="col">
                <div class="p-4 rounded-4 luxury-hover-card h-100 d-flex flex-column gap-3 shadow-sm transition"
                     style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <div class="rounded-3 d-flex align-items-center justify-content-center shadow-xs"
                         style="width: 48px; height: 48px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-temperature-arrow-up gradient-gold-icon fs-5"></i>
                    </div>
                    <div>
                        <span class="text-uppercase fw-semibold" style="font-size: 10px; letter-spacing: 0.15em; color: #9E7D3B;">PILLAR 04</span>
                        <h3 class="font-serif fs-5 fw-bold mb-1" style="color: #211D1E;">Climate Calibration</h3>
                    </div>
                    <p class="text-xs mb-0 fw-light lh-base" style="color: #6B605B; font-size: 0.84rem; line-height: 1.6;">
                        Heavy fixative molecules (ambergris, dry cedar, natural musk) anchor delicate floral & citrus notes so they endure through humid summer days and chilly winter ceremonies.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 4. Transparency Comparison Grid: Commercial Scents vs Perfumes Collection -->
<section class="py-5" style="background-color: #F7F3EE; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4" style="max-width: 880px;">
        
        <!-- Section Header -->
        <div class="text-center mx-auto mb-4 mb-md-5" style="max-width: 680px;">
            <span class="d-inline-block mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.22em; text-transform: uppercase; color: #541B29;">
                HONEST TRANSPARENCY
            </span>
            <h2 class="font-serif fw-bold text-uppercase mb-2" style="color: #211D1E !important; font-size: clamp(1.4rem, 2.8vw, 2.15rem); line-height: 1.3;">
                Commercial Designer vs. Perfumes Collection
            </h2>
            <p class="mb-0 fw-light" style="color: #6B605B; font-size: clamp(0.9rem, 1.6vw, 0.98rem); line-height: 1.6;">
                See exactly why Pakistani connoisseurs are choosing our artisanal Extrait de Parfum over diluted department store imports.
            </p>
        </div>

        <div class="d-flex flex-column gap-3 gap-md-4">
            
            <!-- Comparison Card 1: Concentration -->
            <div class="rounded-4 shadow-xs" style="background: #FFFFFF; border: 1px solid #E8E0DA; padding: clamp(1.15rem, 3vw, 1.75rem);">
                <div class="d-flex align-items-center gap-3 mb-3 pb-3" style="border-bottom: 1px solid #F0EAE1;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width: 40px; height: 40px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-droplet gradient-gold-icon" style="font-size: 15px;"></i>
                    </div>
                    <div>
                        <h3 class="font-serif fw-bold mb-0" style="font-size: clamp(1rem, 2.2vw, 1.18rem); color: #211D1E;">
                            Pure Oil Concentration
                        </h3>
                        <span class="d-block text-muted" style="font-size: 11.5px; color: #786C67 !important;">Pure perfume extract density vs alcohol filler</span>
                    </div>
                </div>

                <div class="row g-3 g-md-4">
                    <!-- Commercial Designer Box -->
                    <div class="col-12 col-sm-6">
                        <div class="rounded-3 h-100 d-flex flex-column justify-content-between shadow-xs"
                             style="background: #F9F7F5; border: 1px solid #EAE4DE; padding: clamp(1rem, 2.5vw, 1.35rem);">
                            <div>
                                <span class="d-block text-uppercase fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.08em; color: #8A7D75;">
                                    <i class="fas fa-minus-circle text-muted me-1.5"></i> Commercial Designer
                                </span>
                                <span class="fw-bold d-block mb-2" style="font-size: clamp(1rem, 2vw, 1.15rem); color: #842029;">
                                    10% – 15% (EDT / EDP)
                                </span>
                            </div>
                            <p class="mb-0 text-muted fw-normal" style="font-size: 12px; line-height: 1.5; color: #6E635C !important;">
                                Over 85% fast-evaporating industrial alcohol solution.
                            </p>
                        </div>
                    </div>

                    <!-- Perfumes Collection Box -->
                    <div class="col-12 col-sm-6">
                        <div class="rounded-3 h-100 d-flex flex-column justify-content-between position-relative overflow-hidden shadow-xs"
                             style="background: linear-gradient(135deg, #FFFDFB 0%, #FAF4EB 100%); border: 1.5px solid #D4AF37; box-shadow: 0 4px 15px rgba(212, 175, 55, 0.08); padding: clamp(1rem, 2.5vw, 1.35rem);">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2 gap-2">
                                    <span class="text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.08em; color: #541B29;">
                                        <i class="fas fa-check-circle text-gold me-1.5"></i> Perfumes Collection
                                    </span>
                                    <span class="badge rounded-pill fw-bold px-2.5 py-1 text-white shadow-xs text-nowrap" 
                                          style="background: linear-gradient(135deg, #d49a3d 0%, #c4244b 50%, #780d24 100%) !important; font-size: 9px; letter-spacing: 0.08em; border: 1px solid rgba(255, 255, 255, 0.35);">
                                        OUR STANDARD
                                    </span>
                                </div>
                                <span class="fw-bold d-block mb-2 gradient-gold-icon" style="font-size: clamp(1.05rem, 2.2vw, 1.22rem); background: linear-gradient(135deg, #d49a3d 0%, #c4244b 50%, #780d24 100%) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; background-clip: text !important;">
                                    35% – 40% Pure Extrait
                                </span>
                            </div>
                            <p class="mb-0 fw-medium" style="font-size: 12px; line-height: 1.5; color: #541B29;">
                                High oil density engineered for monumental sillage.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comparison Card 2: Longevity -->
            <div class="rounded-4 shadow-xs" style="background: #FFFFFF; border: 1px solid #E8E0DA; padding: clamp(1.15rem, 3vw, 1.75rem);">
                <div class="d-flex align-items-center gap-3 mb-3 pb-3" style="border-bottom: 1px solid #F0EAE1;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width: 40px; height: 40px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-clock gradient-gold-icon" style="font-size: 15px;"></i>
                    </div>
                    <div>
                        <h3 class="font-serif fw-bold mb-0" style="font-size: clamp(1rem, 2.2vw, 1.18rem); color: #211D1E;">
                            Longevity in Pakistan
                        </h3>
                        <span class="d-block text-muted" style="font-size: 11.5px; color: #786C67 !important;">Hold on skin & fabric in 40°C+ heat and humidity</span>
                    </div>
                </div>

                <div class="row g-3 g-md-4">
                    <!-- Commercial Designer Box -->
                    <div class="col-12 col-sm-6">
                        <div class="rounded-3 h-100 d-flex flex-column justify-content-between shadow-xs"
                             style="background: #F9F7F5; border: 1px solid #EAE4DE; padding: clamp(1rem, 2.5vw, 1.35rem);">
                            <div>
                                <span class="d-block text-uppercase fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.08em; color: #8A7D75;">
                                    <i class="fas fa-minus-circle text-muted me-1.5"></i> Commercial Designer
                                </span>
                                <span class="fw-bold d-block mb-2" style="font-size: clamp(1rem, 2vw, 1.15rem); color: #842029;">
                                    2 to 4 Hours Fading
                                </span>
                            </div>
                            <p class="mb-0 text-muted fw-normal" style="font-size: 12px; line-height: 1.5; color: #6E635C !important;">
                                Flash-evaporates under Pakistani sun and indoor AC vents.
                            </p>
                        </div>
                    </div>

                    <!-- Perfumes Collection Box -->
                    <div class="col-12 col-sm-6">
                        <div class="rounded-3 h-100 d-flex flex-column justify-content-between position-relative overflow-hidden shadow-xs"
                             style="background: linear-gradient(135deg, #FFFDFB 0%, #FAF4EB 100%); border: 1.5px solid #D4AF37; box-shadow: 0 4px 15px rgba(212, 175, 55, 0.08); padding: clamp(1rem, 2.5vw, 1.35rem);">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2 gap-2">
                                    <span class="text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.08em; color: #541B29;">
                                        <i class="fas fa-check-circle text-gold me-1.5"></i> Perfumes Collection
                                    </span>
                                    <span class="badge rounded-pill fw-bold px-2.5 py-1 text-white shadow-xs text-nowrap" 
                                          style="background: linear-gradient(135deg, #d49a3d 0%, #c4244b 50%, #780d24 100%) !important; font-size: 9px; letter-spacing: 0.08em; border: 1px solid rgba(255, 255, 255, 0.35);">
                                        OUR STANDARD
                                    </span>
                                </div>
                                <span class="fw-bold d-block mb-2 gradient-gold-icon" style="font-size: clamp(1.05rem, 2.2vw, 1.22rem); background: linear-gradient(135deg, #d49a3d 0%, #c4244b 50%, #780d24 100%) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; background-clip: text !important;">
                                    8 to 10 Hours Long Lasting
                                </span>
                            </div>
                            <p class="mb-0 fw-medium" style="font-size: 12px; line-height: 1.5; color: #541B29;">
                                Calibrated molecular weights resist tropical summer heat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comparison Card 3: Maceration -->
            <div class="rounded-4 shadow-xs" style="background: #FFFFFF; border: 1px solid #E8E0DA; padding: clamp(1.15rem, 3vw, 1.75rem);">
                <div class="d-flex align-items-center gap-3 mb-3 pb-3" style="border-bottom: 1px solid #F0EAE1;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width: 40px; height: 40px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-hourglass-half gradient-gold-icon" style="font-size: 15px;"></i>
                    </div>
                    <div>
                        <h3 class="font-serif fw-bold mb-0" style="font-size: clamp(1rem, 2.2vw, 1.18rem); color: #211D1E;">
                            Artisanal Maceration
                        </h3>
                        <span class="d-block text-muted" style="font-size: 11.5px; color: #786C67 !important;">Resting period in dark chambers before final bottling</span>
                    </div>
                </div>

                <div class="row g-3 g-md-4">
                    <!-- Commercial Designer Box -->
                    <div class="col-12 col-sm-6">
                        <div class="rounded-3 h-100 d-flex flex-column justify-content-between shadow-xs"
                             style="background: #F9F7F5; border: 1px solid #EAE4DE; padding: clamp(1rem, 2.5vw, 1.35rem);">
                            <div>
                                <span class="d-block text-uppercase fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.08em; color: #8A7D75;">
                                    <i class="fas fa-minus-circle text-muted me-1.5"></i> Commercial Designer
                                </span>
                                <span class="fw-bold d-block mb-2" style="font-size: clamp(1rem, 2vw, 1.15rem); color: #6E635C;">
                                    0 Days (Instant Factory Filling)
                                </span>
                            </div>
                            <p class="mb-0 text-muted fw-normal" style="font-size: 12px; line-height: 1.5; color: #6E635C !important;">
                                Mixed on assembly line and shipped without aging.
                            </p>
                        </div>
                    </div>

                    <!-- Perfumes Collection Box -->
                    <div class="col-12 col-sm-6">
                        <div class="rounded-3 h-100 d-flex flex-column justify-content-between position-relative overflow-hidden shadow-xs"
                             style="background: linear-gradient(135deg, #FFFDFB 0%, #FAF4EB 100%); border: 1.5px solid #D4AF37; box-shadow: 0 4px 15px rgba(212, 175, 55, 0.08); padding: clamp(1rem, 2.5vw, 1.35rem);">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2 gap-2">
                                    <span class="text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.08em; color: #541B29;">
                                        <i class="fas fa-check-circle text-gold me-1.5"></i> Perfumes Collection
                                    </span>
                                    <span class="badge rounded-pill fw-bold px-2.5 py-1 text-white shadow-xs text-nowrap" 
                                          style="background: linear-gradient(135deg, #d49a3d 0%, #c4244b 50%, #780d24 100%) !important; font-size: 9px; letter-spacing: 0.08em; border: 1px solid rgba(255, 255, 255, 0.35);">
                                        OUR STANDARD
                                    </span>
                                </div>
                                <span class="fw-bold d-block mb-2 gradient-gold-icon" style="font-size: clamp(1.05rem, 2.2vw, 1.22rem); background: linear-gradient(135deg, #d49a3d 0%, #c4244b 50%, #780d24 100%) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; background-clip: text !important;">
                                    90 Days Dark Cellar Aged
                                </span>
                            </div>
                            <p class="mb-0 fw-medium" style="font-size: 12px; line-height: 1.5; color: #541B29;">
                                Slow maceration harmonizes raw oils for rich smoothness.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comparison Card 4: Price & Value -->
            <div class="rounded-4 shadow-xs" style="background: #FFFFFF; border: 1px solid #E8E0DA; padding: clamp(1.15rem, 3vw, 1.75rem);">
                <div class="d-flex align-items-center gap-3 mb-3 pb-3" style="border-bottom: 1px solid #F0EAE1;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width: 40px; height: 40px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-tag gradient-gold-icon" style="font-size: 15px;"></i>
                    </div>
                    <div>
                        <h3 class="font-serif fw-bold mb-0" style="font-size: clamp(1rem, 2.2vw, 1.18rem); color: #211D1E;">
                            Investment Value & Pricing
                        </h3>
                        <span class="d-block text-muted" style="font-size: 11.5px; color: #786C67 !important;">Fair luxury delivered directly to Pakistani fragrance lovers</span>
                    </div>
                </div>

                <div class="row g-3 g-md-4">
                    <!-- Commercial Designer Box -->
                    <div class="col-12 col-sm-6">
                        <div class="rounded-3 h-100 d-flex flex-column justify-content-between shadow-xs"
                             style="background: #F9F7F5; border: 1px solid #EAE4DE; padding: clamp(1rem, 2.5vw, 1.35rem);">
                            <div>
                                <span class="d-block text-uppercase fw-semibold mb-2" style="font-size: 11px; letter-spacing: 0.08em; color: #8A7D75;">
                                    <i class="fas fa-minus-circle text-muted me-1.5"></i> Commercial Designer
                                </span>
                                <span class="fw-bold d-block mb-2" style="font-size: clamp(1rem, 2vw, 1.15rem); color: #842029;">
                                    Rs. 45,000 – 85,000+
                                </span>
                            </div>
                            <p class="mb-0 text-muted fw-normal" style="font-size: 12px; line-height: 1.5; color: #6E635C !important;">
                                Inflated markups for international billboards & licensing.
                            </p>
                        </div>
                    </div>

                    <!-- Perfumes Collection Box -->
                    <div class="col-12 col-sm-6">
                        <div class="rounded-3 h-100 d-flex flex-column justify-content-between position-relative overflow-hidden shadow-xs"
                             style="background: linear-gradient(135deg, #FFFDFB 0%, #FAF4EB 100%); border: 1.5px solid #D4AF37; box-shadow: 0 4px 15px rgba(212, 175, 55, 0.08); padding: clamp(1rem, 2.5vw, 1.35rem);">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2 gap-2">
                                    <span class="text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.08em; color: #541B29;">
                                        <i class="fas fa-check-circle text-gold me-1.5"></i> Perfumes Collection
                                    </span>
                                    <span class="badge rounded-pill fw-bold px-2.5 py-1 text-white shadow-xs text-nowrap" 
                                          style="background: linear-gradient(135deg, #d49a3d 0%, #c4244b 50%, #780d24 100%) !important; font-size: 9px; letter-spacing: 0.08em; border: 1px solid rgba(255, 255, 255, 0.35);">
                                        OUR STANDARD
                                    </span>
                                </div>
                                <span class="fw-bold d-block mb-2 gradient-gold-icon" style="font-size: clamp(1.05rem, 2.2vw, 1.22rem); background: linear-gradient(135deg, #d49a3d 0%, #c4244b 50%, #780d24 100%) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; background-clip: text !important;">
                                    Rs. 2,000 – 3,500
                                </span>
                            </div>
                            <p class="mb-0 fw-medium" style="font-size: 12px; line-height: 1.5; color: #541B29;">
                                High-potency French essences direct from our atelier.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- 6. Patron Guarantees & Safe Nationwide Logistics (Fast Delivery, Cash on Delivery, 7-Day Return Policy) -->
<section class="py-5" style="background-color: #FAF7F2; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4">
        
        <div class="text-center mx-auto mb-4 mb-md-5" style="max-width: 680px;">
            <span class="d-inline-block mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.22em; text-transform: uppercase; color: #541B29;">
                OUR PROMISE TO YOU
            </span>
            <h2 class="font-serif fs-2 fs-md-1 fw-bold text-uppercase mb-2" style="color: #211D1E !important;">
                The Pakistani Patron Privilege
            </h2>
            <p class="text-xs text-sm mb-0 fw-light" style="color: #6B605B;">
                Ordering fine perfumery online in Pakistan requires absolute trust. Here is our solemn commitment.
            </p>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-3 g-md-4">
            
            <!-- Guarantee 1: Fast Delivery -->
            <div class="col">
                <div class="p-4 rounded-4 luxury-hover-card text-center h-100 vstack gap-2.5 shadow-sm"
                     style="background: #FFFFFF; border: 1px solid #E8E0DA;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-xs"
                         style="width: 52px; height: 52px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-truck-fast gradient-gold-icon fs-5"></i>
                    </div>
                    <h3 class="font-serif fs-5 fw-bold mb-0" style="color: #211D1E;">Fast Delivery</h3>
                    <p class="text-xs mb-0 fw-light" style="color: #6B605B; font-size: 0.84rem; line-height: 1.6;">
                        Dispatched in sealed tamper-proof packaging nationwide directly to your doorstep anywhere across Pakistan.
                    </p>
                </div>
            </div>

            <!-- Guarantee 2: Cash on Delivery (COD tag removed) -->
            <div class="col">
                <div class="p-4 rounded-4 luxury-hover-card text-center h-100 vstack gap-2.5 shadow-sm"
                     style="background: #FFFFFF; border: 1px solid #E8E0DA;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-xs"
                         style="width: 52px; height: 52px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-hand-holding-dollar gradient-gold-icon fs-5"></i>
                    </div>
                    <h3 class="font-serif fs-5 fw-bold mb-0" style="color: #211D1E;">Cash on Delivery</h3>
                    <p class="text-xs mb-0 fw-light" style="color: #6B605B; font-size: 0.84rem; line-height: 1.6;">
                        Complete peace of mind. Pay cash when the courier hands your luxury parcel over. Direct bank transfer & JazzCash options also available.
                    </p>
                </div>
            </div>

            <!-- Guarantee 3: 7-Day Return Policy (Return Policy, not exchange) -->
            <div class="col">
                <div class="p-4 rounded-4 luxury-hover-card text-center h-100 vstack gap-2.5 shadow-sm"
                     style="background: #FFFFFF; border: 1px solid #E8E0DA;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-xs"
                         style="width: 52px; height: 52px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
                        <i class="fas fa-arrow-rotate-left gradient-gold-icon fs-5"></i>
                    </div>
                    <h3 class="font-serif fs-5 fw-bold mb-0" style="color: #211D1E;">7-Day Return Policy</h3>
                    <p class="text-xs mb-0 fw-light" style="color: #6B605B; font-size: 0.84rem; line-height: 1.6;">
                        Complete satisfaction guaranteed. If you are not completely delighted with your fragrance on your skin, enjoy an unconditional 7-day return policy.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- 7. Grand Call to Action (Gradient Buttons, No Icons except WhatsApp, Generous Mobile Gap) -->
<section class="py-5 text-center position-relative overflow-hidden" style="background-color: #F7F3EE;">
    <div class="container px-3 px-lg-4 d-flex flex-column align-items-center gap-3" style="max-width: 720px;">
        
        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-xs mb-1"
             style="width: 58px; height: 58px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%); border: 1px solid #EAD8B8;">
            <i class="fas fa-gem gradient-gold-icon fs-4"></i>
        </div>

        <h2 class="font-serif fw-bold mb-1" style="color: #211D1E; font-size: clamp(1.5rem, 3.2vw, 2.3rem); line-height: 1.25;">
            Step Into the World of Sovereign Extrait
        </h2>
        
        <p class="lh-base mb-3 fw-light" style="font-size: clamp(0.9rem, 1.8vw, 1rem); color: #6B605B; max-width: 600px; line-height: 1.7;">
            Experience monumental projection, pure French grade essences, and guaranteed 8-10 hour hold. Discover our iconic individual flacons or curate your custom coffret.
        </p>

        <!-- Gradient Action Buttons Row (Generous gap on mobile, no icons except WhatsApp) -->
        <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-center gap-3 gap-md-4 w-100 my-2" style="max-width: 640px;">
            
            <!-- Primary Gradient Button: Explore All (No Icons) -->
            <a href="{{ route('collections.show', 'all') }}" 
               class="w-100 w-sm-auto px-4 py-3 rounded-3 text-white text-decoration-none fw-semibold shadow-md d-inline-flex align-items-center justify-content-center transition text-center"
               style="background: linear-gradient(135deg, #d49a3d 0%, #c4244b 45%, #780d24 100%) !important; font-size: 12px; letter-spacing: 0.1em; min-height: 48px; border: 1px solid rgba(255,255,255,0.25);">
                <span>EXPLORE ALL</span>
            </a>

            <!-- Secondary Gradient Button: Discovery Bundles (No Icons) -->
            <a href="{{ route('bundles.index') }}" 
               class="w-100 w-sm-auto px-4 py-3 rounded-3 text-decoration-none fw-semibold shadow-xs d-inline-flex align-items-center justify-content-center transition text-center"
               style="background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%) !important; border: 1px solid #EAD8B8 !important; color: #541B29 !important; font-size: 12px; letter-spacing: 0.08em; min-height: 48px;">
                <span>DISCOVERY BUNDLES (SAVE 25%)</span>
            </a>

            <!-- WhatsApp Direct Advice Button (Retains WhatsApp Icon only) -->
            <a href="https://wa.me/{{ $whatsappNum ?? '923363685732' }}?text={{ urlencode('Salam! I would like perfume recommendations from Perfumes Collection.') }}" 
               target="_blank" rel="noopener noreferrer"
               class="w-100 w-sm-auto px-4 py-3 rounded-3 text-decoration-none fw-semibold shadow-xs d-inline-flex align-items-center justify-content-center gap-2 transition text-center"
               style="background: #FFFFFF; border: 1px solid rgba(37, 211, 102, 0.45); color: #1E7E34; font-size: 12px; letter-spacing: 0.06em; min-height: 48px;">
                <i class="fab fa-whatsapp" style="font-size: 16px; color: #25D366;"></i>
                <span>WHATSAPP ADVISOR</span>
            </a>

        </div>

    </div>
</section>

@endsection

@push('scripts')
<style>
    .about-video-pagination .swiper-pagination-bullet {
        width: 8px;
        height: 8px;
        background: rgba(255, 255, 255, 0.6) !important;
        opacity: 0.75;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 4px;
        pointer-events: auto;
    }
    .about-video-pagination .swiper-pagination-bullet-active {
        width: 26px;
        background: linear-gradient(135deg, #d49a3d 0%, #c4244b 100%) !important;
        opacity: 1;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const aboutVideoSwiperEl = document.querySelector('.about-video-swiper');
        if (aboutVideoSwiperEl && typeof Swiper !== 'undefined') {
            const aboutVideoSwiper = new Swiper('.about-video-swiper', {
                slidesPerView: 1,
                spaceBetween: 0,
                speed: 750,
                loop: true,
                grabCursor: true,
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                pagination: {
                    el: '.about-video-pagination',
                    clickable: true,
                },

                on: {
                    init: function () {
                        const currentVideo = this.slides[this.activeIndex]?.querySelector('video');
                        if (currentVideo) {
                            currentVideo.play().catch(() => {});
                        }
                    },
                    slideChange: function () {
                        this.slides.forEach((slide, idx) => {
                            const v = slide.querySelector('video');
                            if (v) {
                                if (idx === this.activeIndex) {
                                    v.currentTime = 0;
                                    v.play().catch(() => {});
                                }
                            }
                        });
                    }
                }
            });
        }
    });
</script>
@endpush

