@extends('layouts.app')

@section('title', 'Haute Parfumerie & Longevity Guide | Maison d\'Orient Pakistan')

@section('content')

<!-- Header -->
<section style="padding: 70px 0 50px; background: linear-gradient(180deg, #18151D 0%, #0A0A0C 100%); text-align: center; border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <span class="section-pretitle">THE CONNOISSEUR COMPASS</span>
        <h1 style="font-size: 3rem; margin-bottom: 14px;">The Olfactory & Longevity Guide</h1>
        <div class="section-divider">
            <span class="line"></span>
            <i class="fas fa-gem"></i>
            <span class="line"></span>
        </div>
        <p style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--gold-champagne); max-width: 680px; margin: 0 auto; line-height: 1.6;">
            A master guide to perfume concentrations, sillage physics, and maximizing fragrance endurance in Pakistan.
        </p>
    </div>
</section>

<!-- Content Body -->
<section style="padding: 80px 0;">
    <div class="container" style="max-width: 960px;">
        
        <!-- Concentration Comparison Table -->
        <div style="background: var(--bg-card); border: 1px solid var(--border-gold); border-radius: var(--radius-md); padding: 40px; margin-bottom: 50px;">
            <h2 style="font-size: 1.8rem; margin-bottom: 12px;">Concentrations Decoded</h2>
            <p style="font-family: var(--font-serif); font-size: 1.1rem; color: var(--text-sub); margin-bottom: 24px;">
                Understanding the difference between commercial fragrances and pure niche compounding:
            </p>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border-gold); color: var(--gold-champagne); font-family: var(--font-heading);">
                            <th style="padding: 12px 16px;">Format</th>
                            <th style="padding: 12px 16px;">Pure Oil %</th>
                            <th style="padding: 12px 16px;">Longevity (Pakistan)</th>
                            <th style="padding: 12px 16px;">Character</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid var(--border-subtle);">
                            <td style="padding: 16px; color: var(--text-muted);">Eau de Toilette (EDT)</td>
                            <td style="padding: 16px; color: var(--text-muted);">5% - 10%</td>
                            <td style="padding: 16px; color: var(--text-muted);">2 - 4 Hours</td>
                            <td style="padding: 16px; color: var(--text-muted);">Weak projection in high heat</td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--border-subtle);">
                            <td style="padding: 16px; color: var(--text-muted);">Eau de Parfum (EDP)</td>
                            <td style="padding: 16px; color: var(--text-muted);">12% - 18%</td>
                            <td style="padding: 16px; color: var(--text-muted);">5 - 7 Hours</td>
                            <td style="padding: 16px; color: var(--text-muted);">Standard commercial benchmark</td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--border-gold); background: rgba(212,175,55,0.08);">
                            <td style="padding: 16px; color: var(--gold-bright); font-weight: 700;">
                                <i class="fas fa-crown text-gold"></i> Perfumes Collection Extrait
                            </td>
                            <td style="padding: 16px; color: var(--gold-bright); font-weight: 700;">35% - 40%</td>
                            <td style="padding: 16px; color: var(--gold-bright); font-weight: 700;">14 - 18+ Hours</td>
                            <td style="padding: 16px; color: var(--gold-bright); font-weight: 700;">Monumental beast-mode sillage</td>
                        </tr>
                        <tr style="background: rgba(212,175,55,0.04);">
                            <td style="padding: 16px; color: var(--gold-champagne); font-weight: 700;">
                                <i class="fas fa-gem text-gold"></i> Pure Attar (Dehn al Oud)
                            </td>
                            <td style="padding: 16px; color: var(--gold-champagne); font-weight: 700;">100% Pure Oil</td>
                            <td style="padding: 16px; color: var(--gold-champagne); font-weight: 700;">24+ Hours</td>
                            <td style="padding: 16px; color: var(--gold-champagne); font-weight: 700;">Alcohol-free sovereign aura</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 5 Rules for Extreme Performance in Pakistan -->
        <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 40px;">
            <h2 style="font-size: 1.8rem; margin-bottom: 24px;">The 5 Rituals for All-Day Sillage in Pakistan</h2>

            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div style="display: flex; gap: 20px;">
                    <div style="font-family: var(--font-heading); font-size: 1.5rem; color: var(--gold-primary); font-weight: 700;">01</div>
                    <div>
                        <h4 style="font-size: 1.1rem; color: var(--text-ivory); margin-bottom: 6px;">Target Warm Pulse Centers & Clothing Fibers</h4>
                        <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6;">
                            Spray on the base of the neck, behind ears, and importantly on cotton/linen/wool fabrics. Natural agarwood molecules cling to fabric weaves for up to 48 hours.
                        </p>
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div style="font-family: var(--font-heading); font-size: 1.5rem; color: var(--gold-primary); font-weight: 700;">02</div>
                    <div>
                        <h4 style="font-size: 1.1rem; color: var(--text-ivory); margin-bottom: 6px;">Never Rub Your Wrists Together</h4>
                        <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6;">
                            Friction generates friction-heat that prematurely destroys delicate top notes (Kashmiri Saffron, Bergamot) and crushes the natural olfactory progression.
                        </p>
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div style="font-family: var(--font-heading); font-size: 1.5rem; color: var(--gold-primary); font-weight: 700;">03</div>
                    <div>
                        <h4 style="font-size: 1.1rem; color: var(--text-ivory); margin-bottom: 6px;">Hydrate Skin Prior to Spraying</h4>
                        <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6;">
                            Perfume oils bind to lipid layers. Applying an unscented moisturizer or a dab of pure jojoba oil creates a magnetic primer that locks in sillage.
                        </p>
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div style="font-family: var(--font-heading); font-size: 1.5rem; color: var(--gold-primary); font-weight: 700;">04</div>
                    <div>
                        <h4 style="font-size: 1.1rem; color: var(--text-ivory); margin-bottom: 6px;">Storage in Dark, Cool Ambient Temperature</h4>
                        <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6;">
                            Avoid storing your heavy glass flacons in hot bathrooms or direct Pakistani sun. Keep in their velvet coffrets to preserve natural maceration integrity.
                        </p>
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 40px;">
                <a href="{{ route('shop.index') }}" class="btn-gold">
                    <i class="fas fa-gem"></i> DISCOVER OUR 40% EXTRAITS
                </a>
            </div>
        </div>

    </div>
</section>

@endsection
