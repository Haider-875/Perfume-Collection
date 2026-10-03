@extends('layouts.app')

@section('title', 'Artisanal Heritage & Distillation | Perfumes Collection Haute Parfumerie')

@section('content')

<!-- Hero Header -->
<section class="py-16 md:py-24 bg-gradient-to-b from-[#18050b] via-[#0d0305] to-[#050203] text-center border-b border-[#d6aa62]/20">
    <div class="container mx-auto px-4 max-w-4xl">
        <span class="text-[11px] uppercase tracking-[0.28em] text-[#d6aa62] font-semibold block mb-3">THE PERFUMES COLLECTION CHRONICLES</span>
        <h1 class="font-serif text-3xl md:text-5xl lg:text-6xl text-[#f5efe7] mb-4 font-normal">The Sacred Art of Haute Parfumerie</h1>
        <div class="w-24 h-0.5 bg-gradient-to-r from-transparent via-[#d6aa62] to-transparent mx-auto mb-6"></div>
        <p class="font-serif text-lg md:text-xl text-[#b8a9a2] max-w-2xl mx-auto leading-relaxed">
            Where Mughal imperial agarwood traditions converge with Parisian precision distillation.
        </p>
    </div>
</section>

<!-- Storytelling Section 1 -->
<section class="py-16 md:py-24 bg-[#050203]">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="space-y-6">
                <span class="text-[11px] uppercase tracking-[0.28em] text-[#d6aa62] font-semibold block">OUR GENESIS</span>
                <h2 class="font-serif text-2xl md:text-4xl text-[#f5efe7] font-normal leading-tight">Born from Four Centuries of Imperial Scent Culture</h2>
                <p class="font-serif text-base md:text-lg text-[#b8a9a2] leading-relaxed">
                    In the imperial courts of the Mughal Empire, fragrance was not an accessory—it was a sovereign aura. The royal ateliers of Lahore and Delhi pioneered hydro-distillation of pure Taif roses, saffron stigmas, and ancient wild agarwood from Assam and Koh Kong.
                </p>
                <p class="font-serif text-base md:text-lg text-[#b8a9a2] leading-relaxed">
                    Perfumes Collection was established to revive this uncompromised heritage for modern Pakistani connoisseurs, merging hand-macerated oriental absolutes with the sophisticated scent structures of Grasse, France.
                </p>
            </div>
            <div class="bg-gradient-to-br from-[#18050b] to-[#080204] border border-[#d6aa62]/30 rounded-2xl p-6 lg:p-8 text-center shadow-2xl relative overflow-hidden">
                <div class="absolute -inset-10 bg-radial-gradient from-[#d6aa62]/10 to-transparent blur-2xl pointer-events-none"></div>
                <img src="{{ asset('assets/images/perfumes/prod_oud_royale.jpg') }}" alt="Royal Agarwood Heritage" class="max-h-96 w-auto mx-auto rounded-xl shadow-2xl object-cover relative z-10">
            </div>
        </div>
    </div>
</section>

<!-- The 4 Pillars of Excellence -->
<section class="py-16 md:py-24 bg-[#080204] border-t border-b border-[#d6aa62]/20">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
            <span class="text-[11px] uppercase tracking-[0.28em] text-[#d6aa62] font-semibold block">THE PURITY PLEDGE</span>
            <h2 class="font-serif text-2xl md:text-4xl text-[#f5efe7] font-normal">The Four Pillars of Perfumes Collection</h2>
            <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-[#d6aa62] to-transparent mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-[#140408] border border-[#d6aa62]/25 p-8 rounded-2xl space-y-3 shadow-lg hover:border-[#d6aa62]/60 transition">
                <i class="fas fa-tree text-[#d6aa62] text-2xl"></i>
                <h3 class="font-serif text-lg text-[#f0d59d] font-semibold">1. Natural Agarwood</h3>
                <p class="text-xs text-[#b8a9a2] leading-relaxed">
                    We only use sustainably wild-harvested agarwood aged for a minimum of 15 years in antique oak vessels. Zero synthetic petroleum oud mimics.
                </p>
            </div>

            <div class="bg-[#140408] border border-[#d6aa62]/25 p-8 rounded-2xl space-y-3 shadow-lg hover:border-[#d6aa62]/60 transition">
                <i class="fas fa-flask text-[#d6aa62] text-2xl"></i>
                <h3 class="font-serif text-lg text-[#f0d59d] font-semibold">2. 35-40% Extrait</h3>
                <p class="text-xs text-[#b8a9a2] leading-relaxed">
                    While commercial brands bottle at 12-15% (EDT/EDP), all Perfumes Collection spray flacons are compounded at genuine Extrait de Parfum strength.
                </p>
            </div>

            <div class="bg-[#140408] border border-[#d6aa62]/25 p-8 rounded-2xl space-y-3 shadow-lg hover:border-[#d6aa62]/60 transition">
                <i class="fas fa-hourglass-half text-[#d6aa62] text-2xl"></i>
                <h3 class="font-serif text-lg text-[#f0d59d] font-semibold">3. 36-Month Maceration</h3>
                <p class="text-xs text-[#b8a9a2] leading-relaxed">
                    Each formulation rests in temperature-controlled dark chambers for 3 full years before hand-filtering and bottling into crystal vessels.
                </p>
            </div>

            <div class="bg-[#140408] border border-[#d6aa62]/25 p-8 rounded-2xl space-y-3 shadow-lg hover:border-[#d6aa62]/60 transition">
                <i class="fas fa-certificate text-[#d6aa62] text-2xl"></i>
                <h3 class="font-serif text-lg text-[#f0d59d] font-semibold">4. Climate Engineered</h3>
                <p class="text-xs text-[#b8a9a2] leading-relaxed">
                    Olfactory molecular weights calibrated specifically to withstand Pakistan's 40°C summer heat and dry northern winters without fading.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 md:py-24 bg-[#050203] text-center">
    <div class="container mx-auto px-4 max-w-2xl space-y-6">
        <h2 class="font-serif text-2xl md:text-4xl text-[#f5efe7] font-normal">Experience the Sovereign Aura</h2>
        <p class="font-serif text-base md:text-lg text-[#b8a9a2] leading-relaxed">
            Order our flagship Extrait de Parfums with complimentary 24h express delivery across Pakistan.
        </p>
        <div class="pt-2">
            <a href="{{ route('shop.index') }}" class="btn-gold py-4 px-10 text-xs uppercase tracking-widest inline-flex items-center gap-2">
                <i class="fas fa-gem"></i> EXPLORE THE COMPLETE VAULT
            </a>
        </div>
    </div>
</section>

@endsection
