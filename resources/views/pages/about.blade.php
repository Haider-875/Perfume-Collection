@extends('layouts.app')

@section('title', 'Artisanal Heritage & Distillation | Perfumes Collection Haute Parfumerie')

@section('content')

<!-- Hero Header -->
<section style="padding: 80px 0 60px; background: linear-gradient(180deg, #18141C 0%, #0A0A0C 100%); text-align: center; border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <span class="section-pretitle">THE PERFUMES COLLECTION CHRONICLES</span>
        <h1 style="font-size: 3.2rem; margin-bottom: 16px;">The Sacred Art of Haute Parfumerie</h1>
        <div class="section-divider">
            <span class="line"></span>
            <i class="fas fa-crown"></i>
            <span class="line"></span>
        </div>
        <p style="font-family: var(--font-serif); font-size: 1.35rem; color: var(--gold-champagne); max-width: 720px; margin: 0 auto; line-height: 1.7;">
            Where Mughal imperial agarwood traditions converge with Parisian precision distillation.
        </p>
    </div>
</section>

<!-- Storytelling Section 1 -->
<section style="padding: 90px 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
            <div>
                <span class="section-pretitle">OUR GENESIS</span>
                <h2 style="font-size: 2.2rem; margin-bottom: 20px;">Born from Four Centuries of Imperial Scent Culture</h2>
                <p style="font-family: var(--font-serif); font-size: 1.15rem; color: var(--text-sub); line-height: 1.8; margin-bottom: 20px;">
                    In the imperial courts of the Mughal Empire, fragrance was not an accessory—it was a sovereign aura. The royal ateliers of Lahore and Delhi pioneered hydro-distillation of pure Taif roses, saffron stigmas, and ancient wild agarwood from Assam and Koh Kong.
                </p>
                <p style="font-family: var(--font-serif); font-size: 1.15rem; color: var(--text-sub); line-height: 1.8;">
                    Perfumes Collection was established to revive this uncompromised heritage for modern Pakistani connoisseurs, merging hand-macerated oriental absolutes with the sophisticated scent structures of Grasse, France.
                </p>
            </div>
            <div style="background: radial-gradient(circle, rgba(212,175,55,0.15) 0%, rgba(10,10,12,0.8) 70%); border: 1px solid var(--border-gold); border-radius: var(--radius-lg); padding: 40px; text-align: center;">
                <img src="{{ asset('assets/images/perfumes/oud_royale_box.svg') }}" alt="Royal Agarwood Heritage" style="max-height: 380px; width: auto; filter: drop-shadow(0 20px 30px rgba(0,0,0,0.8));">
            </div>
        </div>
    </div>
</section>

<!-- The 4 Pillars of Excellence -->
<section style="padding: 80px 0; background: rgba(14, 14, 18, 0.6); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header">
            <span class="section-pretitle">THE PURITY PLEDGE</span>
            <h2 class="section-title">The Four Pillars of Perfumes Collection</h2>
            <div class="section-divider">
                <span class="line"></span>
                <i class="fas fa-gem"></i>
                <span class="line"></span>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 28px;">
            <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); padding: 30px; border-radius: var(--radius-md);">
                <i class="fas fa-tree text-gold" style="font-size: 2rem; margin-bottom: 16px;"></i>
                <h3 style="font-size: 1.15rem; margin-bottom: 10px; color: var(--gold-champagne);">1. Natural Agarwood</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.6;">
                    We only use sustainably wild-harvested agarwood aged for a minimum of 15 years in antique oak vessels. Zero synthetic petroleum oud mimics.
                </p>
            </div>

            <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); padding: 30px; border-radius: var(--radius-md);">
                <i class="fas fa-flask text-gold" style="font-size: 2rem; margin-bottom: 16px;"></i>
                <h3 style="font-size: 1.15rem; margin-bottom: 10px; color: var(--gold-champagne);">2. 35-40% Extrait</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.6;">
                    While commercial brands bottle at 12-15% (EDT/EDP), all Perfumes Collection spray flacons are compounded at genuine Extrait de Parfum strength.
                </p>
            </div>

            <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); padding: 30px; border-radius: var(--radius-md);">
                <i class="fas fa-hourglass-half text-gold" style="font-size: 2rem; margin-bottom: 16px;"></i>
                <h3 style="font-size: 1.15rem; margin-bottom: 10px; color: var(--gold-champagne);">3. 36-Month Maceration</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.6;">
                    Each formulation rests in temperature-controlled dark chambers for 3 full years before hand-filtering and bottling into crystal vessels.
                </p>
            </div>

            <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); padding: 30px; border-radius: var(--radius-md);">
                <i class="fas fa-certificate text-gold" style="font-size: 2rem; margin-bottom: 16px;"></i>
                <h3 style="font-size: 1.15rem; margin-bottom: 10px; color: var(--gold-champagne);">4. Climate Engineered</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.6;">
                    Olfactory molecular weights calibrated specifically to withstand Pakistan's 40°C summer heat and dry northern winters without fading.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section style="padding: 80px 0; text-align: center;">
    <div class="container">
        <h2 style="font-size: 2.2rem; margin-bottom: 16px;">Experience the Sovereign Aura</h2>
        <p style="font-family: var(--font-serif); font-size: 1.2rem; color: var(--text-sub); margin-bottom: 30px;">
            Order our flagship Extrait de Parfums with complimentary 24h express delivery across Pakistan.
        </p>
        <a href="{{ route('shop.index') }}" class="btn-gold" style="padding: 14px 38px;">
            <i class="fas fa-gem"></i> EXPLORE THE COMPLETE VAULT
        </a>
    </div>
</section>

@endsection
