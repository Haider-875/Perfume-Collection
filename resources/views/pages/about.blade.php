@extends('layouts.app')

@section('title', 'Artisanal Heritage & Distillation | Perfumes Collection Haute Parfumerie')

@section('content')

<!-- Hero Header -->
<section class="py-5 text-center border-bottom border-gold-20" style="background: linear-gradient(to bottom, #18050b, #0d0305, #050203);">
    <div class="container px-3 px-lg-4" style="max-width: 800px;">
        <span class="text-gold fw-semibold d-block mb-3" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">THE PERFUMES COLLECTION CHRONICLES</span>
        <h1 class="font-serif text-light-parchment mb-3 fw-normal display-5">The Sacred Art of Haute Parfumerie</h1>
        <div class="mx-auto mb-4" style="width: 96px; height: 2px; background: linear-gradient(to right, transparent, #d6aa62, transparent);"></div>
        <p class="font-serif text-muted-parchment mx-auto lh-base mb-0" style="font-size: 1.15rem; max-width: 672px;">
            Where Mughal imperial agarwood traditions converge with Parisian precision distillation.
        </p>
    </div>
</section>

<!-- Storytelling Section 1 -->
<section class="py-5" style="background-color: #050203;">
    <div class="container px-3 px-lg-4">
        <div class="row g-5 align-items-center">
            <div class="col-12 col-lg-6 d-flex flex-column gap-3">
                <span class="text-gold fw-semibold d-block" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">OUR GENESIS</span>
                <h2 class="font-serif text-light-parchment fw-normal display-6 lh-sm mb-0">Born from Four Centuries of Imperial Scent Culture</h2>
                <p class="font-serif text-muted-parchment lh-base mb-0" style="font-size: 1.05rem;">
                    In the imperial courts of the Mughal Empire, fragrance was not an accessory—it was a sovereign aura. The royal ateliers of Lahore and Delhi pioneered hydro-distillation of pure Taif roses, saffron stigmas, and ancient wild agarwood from Assam and Koh Kong.
                </p>
                <p class="font-serif text-muted-parchment lh-base mb-0" style="font-size: 1.05rem;">
                    Perfumes Collection was established to revive this uncompromised heritage for modern Pakistani connoisseurs, merging hand-macerated oriental absolutes with the sophisticated scent structures of Grasse, France.
                </p>
            </div>
            <div class="col-12 col-lg-6">
                <div class="bg-gradient-wine-ticker border border-gold-30 rounded-4 p-4 p-lg-5 text-center shadow-2xl position-relative overflow-hidden">
                    <img src="{{ asset('assets/images/perfumes/prod_oud_royale.jpg') }}" alt="Royal Agarwood Heritage" class="img-fluid rounded-3 shadow-2xl object-cover position-relative z-1" style="max-height: 384px;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- The 4 Pillars of Excellence -->
<section class="py-5 border-top border-bottom border-gold-20" style="background-color: #080204;">
    <div class="container px-3 px-lg-4">
        <div class="text-center mx-auto mb-5 d-flex flex-column gap-2" style="max-width: 672px;">
            <span class="text-gold fw-semibold d-block" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">THE PURITY PLEDGE</span>
            <h2 class="font-serif text-light-parchment fw-normal display-6 mb-0">The Four Pillars of Perfumes Collection</h2>
            <div class="mx-auto mt-2" style="width: 80px; height: 2px; background: linear-gradient(to right, transparent, #d6aa62, transparent);"></div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
            <div class="col">
                <div class="bg-wine-card border border-gold-25 p-4 rounded-4 d-flex flex-column gap-2 shadow h-100">
                    <i class="fas fa-tree text-gold fs-4"></i>
                    <h3 class="font-serif fs-5 text-gold-soft fw-semibold mb-1">1. Natural Agarwood</h3>
                    <p class="text-xs text-muted-parchment lh-base mb-0">
                        We only use sustainably wild-harvested agarwood aged for a minimum of 15 years in antique oak vessels. Zero synthetic petroleum oud mimics.
                    </p>
                </div>
            </div>

            <div class="col">
                <div class="bg-wine-card border border-gold-25 p-4 rounded-4 d-flex flex-column gap-2 shadow h-100">
                    <i class="fas fa-flask text-gold fs-4"></i>
                    <h3 class="font-serif fs-5 text-gold-soft fw-semibold mb-1">2. 35-40% Extrait</h3>
                    <p class="text-xs text-muted-parchment lh-base mb-0">
                        While commercial brands bottle at 12-15% (EDT/EDP), all Perfumes Collection spray flacons are compounded at genuine Extrait de Parfum strength.
                    </p>
                </div>
            </div>

            <div class="col">
                <div class="bg-wine-card border border-gold-25 p-4 rounded-4 d-flex flex-column gap-2 shadow h-100">
                    <i class="fas fa-hourglass-half text-gold fs-4"></i>
                    <h3 class="font-serif fs-5 text-gold-soft fw-semibold mb-1">3. 36-Month Maceration</h3>
                    <p class="text-xs text-muted-parchment lh-base mb-0">
                        Each formulation rests in temperature-controlled dark chambers for 3 full years before hand-filtering and bottling into crystal vessels.
                    </p>
                </div>
            </div>

            <div class="col">
                <div class="bg-wine-card border border-gold-25 p-4 rounded-4 d-flex flex-column gap-2 shadow h-100">
                    <i class="fas fa-certificate text-gold fs-4"></i>
                    <h3 class="font-serif fs-5 text-gold-soft fw-semibold mb-1">4. Climate Engineered</h3>
                    <p class="text-xs text-muted-parchment lh-base mb-0">
                        Olfactory molecular weights calibrated specifically to withstand Pakistan's 40°C summer heat and dry northern winters without fading.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 text-center" style="background-color: #050203;">
    <div class="container px-3 px-lg-4 d-flex flex-column align-items-center gap-3" style="max-width: 672px;">
        <h2 class="font-serif text-light-parchment fw-normal display-6 mb-0">Experience the Sovereign Aura</h2>
        <p class="font-serif text-muted-parchment lh-base mb-0" style="font-size: 1.05rem;">
            Order our flagship Extrait de Parfums with complimentary 24h express delivery across Pakistan.
        </p>
        <div class="pt-2">
            <a href="{{ route('shop.index') }}" class="btn-gold py-3 px-5 text-xs text-uppercase tracking-widest d-inline-flex align-items-center gap-2 text-decoration-none">
                <i class="fas fa-gem"></i> EXPLORE THE COMPLETE VAULT
            </a>
        </div>
    </div>
</section>

@endsection
