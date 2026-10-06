@extends('layouts.app')

@section('title', 'Frequently Asked Questions & Fragrance Concierge | Perfumes Collection Pakistan')
@section('meta_description', 'Answers regarding Extrait longevity in Pakistan, Cash on Delivery, authentic Cambodian Oud sourcing, and TCS express shipping.')

@section('content')

<!-- FAQ Hero Banner -->
<section class="py-5 text-center border-bottom border-gold-20 position-relative overflow-hidden" style="background: linear-gradient(to bottom, #18050b, #0d0305, #050203);">
    <div class="container px-3 px-lg-4 position-relative z-1">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Client Care & FAQ']
        ]" />

        <span class="d-inline-block text-gold mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.28em; text-transform: uppercase;">CONCIERGE INQUIRIES</span>
        <h1 class="font-serif text-light-parchment mb-3 fw-normal display-5 tracking-wide">
            Frequently Asked Questions
        </h1>
        <p class="mx-auto text-muted-parchment lh-base fw-light mb-0" style="max-width: 672px; font-size: 0.95rem;">
            Essential knowledge concerning our Extrait de Parfum formulations, artisanal agarwood oils, dispatch across Pakistan, and royal customer care.
        </p>
    </div>
</section>

<!-- FAQ Accordion Section -->
<section class="py-5" style="background-color: #050203;">
    <div class="container px-3 px-lg-4 d-flex flex-column gap-3" style="max-width: 896px;">
        
        <!-- Accordion 1 -->
        <x-accordion title="What makes Extrait de Parfum superior to standard Eau de Parfum (EDP)?" :open="true">
            Extrait de Parfum is the pinnacle of the perfumer's craft, containing 35% to 40% pure concentrated perfume compounds (compared to 12%-18% in standard commercial EDPs). This extraordinarily high concentration ensures that top notes do not immediately evaporate in Pakistan's summer humidity, while the base notes of vintage Cambodian agarwood, ambergris, and musk project for 16 to 24+ hours on fabrics and skin.
        </x-accordion>

        <!-- Accordion 2 -->
        <x-accordion title="How does Cash on Delivery (COD) and delivery across Pakistan work?">
            We offer insured Cash on Delivery (COD) to over 300+ cities and towns across Pakistan via TCS Express Air and Leopards Courier. Orders placed before 4:00 PM are dispatched same-day. Delivery to Lahore, Karachi, and Islamabad / Rawalpindi arrives in 24 to 48 hours. Other cities typically take 48 to 72 hours.
        </x-accordion>

        <!-- Accordion 3 -->
        <x-accordion title="Are your Dehn al Oud oils and Attars 100% natural and unadulterated?">
            Yes. Every drop of Dehn al Oud in our Royal Vault is ethically harvested from mature Aquilaria trees in Cambodia, Assam, and Trat, and traditionally steam-distilled in copper alembics. Our attars contain zero synthetic fillers, DEP, or mineral oils, ensuring ceremonial purity suitable for spiritual moments and Jumuah prayers.
        </x-accordion>

        <!-- Accordion 4 -->
        <x-accordion title="Can I test or sample fragrances before purchasing a full 100ml flacon?">
            Certainly. We offer our signature Discovery Coffrets featuring 5x 5ml luxury Extrait atomizers in a velvet presentation box. Furthermore, with every full-size 100ml bottle order, you receive two complimentary 2ml discovery vials to explore upcoming releases.
        </x-accordion>

        <!-- Accordion 5 -->
        <x-accordion title="How should I store my luxury perfume flacons in Pakistan's climate?">
            Keep your flacons in a cool, dry place away from direct sunlight and sudden temperature shifts. Due to our high concentration of natural botanicals and resins, storing your perfume inside its velvet coffret box at room temperature (below 26&deg;C) preserves the delicate top notes for decades.
        </x-accordion>

        <!-- Accordion 6 -->
        <x-accordion title="What payment methods do you accept online?">
            In addition to Cash on Delivery (COD), we accept direct bank transfers via 1Link / Raast (Bank Alfalah, Meezan Bank), JazzCash, EasyPaisa, and Debit / Credit cards for instantaneous digital settlement.
        </x-accordion>

        <!-- Still have questions banner -->
        <div class="mt-5 p-4 p-md-5 bg-wine-card border border-gold-30 rounded-4 text-center d-flex flex-column align-items-center gap-3 shadow-xl">
            <h3 class="font-serif fs-3 text-light-parchment mb-0">Require Bespoke Fragrance Advice?</h3>
            <p class="text-xs text-muted-parchment mx-auto mb-0" style="max-width: 512px;">
                Our Private Concierge advisors are available 7 days a week on WhatsApp to assist with bridal gifting, corporate orders, and personal scent consultations.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-3 pt-2">
                <a href="https://wa.me/923363685732?text={{ urlencode('Salam! I have a question regarding Perfumes Collection.') }}" target="_blank" class="btn-whatsapp py-3 px-4 text-xs text-uppercase tracking-wider text-decoration-none rounded-3">
                    <i class="fab fa-whatsapp me-2"></i> CHAT WITH CONCIERGE (+92 336 3685732)
                </a>
                <a href="{{ route('pages.contact') }}" class="btn-outline-gold py-3 px-4 text-xs text-uppercase tracking-wider text-decoration-none rounded-3">
                    CONTACT FORM
                </a>
            </div>
        </div>

    </div>
</section>

@endsection
