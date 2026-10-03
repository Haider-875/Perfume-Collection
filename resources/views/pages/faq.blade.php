@extends('layouts.app')

@section('title', 'Frequently Asked Questions & Fragrance Concierge | Maison d\'Orient Pakistan')
@section('meta_description', 'Answers regarding Extrait longevity in Pakistan, Cash on Delivery, authentic Cambodian Oud sourcing, and TCS express shipping.')

@section('content')

<!-- FAQ Hero Banner -->
<section class="relative py-16 md:py-24 bg-[#0A0405] border-b border-[#C9A24B]/20 overflow-hidden">
    <div class="absolute inset-0 bg-radial-gradient opacity-25 pointer-events-none"></div>
    <div class="container relative z-10 text-center">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Client Care & FAQ']
        ]" />

        <span class="inline-block text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] mb-2 font-medium">CONCIERGE INQUIRIES</span>
        <h1 class="font-serif text-3xl md:text-5xl lg:text-6xl text-[#F5EFE6] mb-4 font-normal tracking-wide">
            Frequently Asked Questions
        </h1>
        <p class="max-w-2xl mx-auto text-[#F5EFE6]/70 text-sm md:text-base font-light leading-relaxed">
            Essential knowledge concerning our Extrait de Parfum formulations, artisanal agarwood oils, dispatch across Pakistan, and royal customer care.
        </p>
    </div>
</section>

<!-- FAQ Accordion Section -->
<section class="py-16 bg-[#080304]">
    <div class="container max-w-4xl mx-auto space-y-6">
        
        <!-- Accordion 1 -->
        <x-accordion title="What makes Extrait de Parfum superior to standard Eau de Parfum (EDP)?" :open="true">
            Extrait de Parfum is the pinnacle of the perfumer's craft, containing 30% to 40% pure concentrated perfume compounds (compared to 12%-18% in standard commercial EDPs). This extraordinarily high concentration ensures that top notes do not immediately evaporate in Pakistan's summer humidity, while the base notes of vintage Cambodian agarwood, ambergris, and musk project for 16 to 24+ hours on fabrics and skin.
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
            In addition to Cash on Delivery (COD), we accept direct bank transfers via 1Link / Raast (Bank Alfalah, Meezan Bank), JazzCash, and EasyPaisa for instantaneous digital settlement.
        </x-accordion>

        <!-- Still have questions banner -->
        <div class="mt-16 p-8 bg-[#0E0507] border border-[#C9A24B]/30 rounded-lg text-center space-y-4">
            <h3 class="font-serif text-2xl text-[#F5EFE6]">Require Bespoke Fragrance Advice?</h3>
            <p class="text-xs md:text-sm text-[#F5EFE6]/70 max-w-lg mx-auto">
                Our Private Concierge advisors are available 7 days a week on WhatsApp to assist with bridal gifting, corporate orders, and personal scent consultations.
            </p>
            <div class="flex justify-center space-x-4 pt-2">
                <a href="https://wa.me/923001234567?text={{ urlencode('Salam! I have a question regarding Maison d\'Orient perfumes.') }}" target="_blank" class="btn-whatsapp">
                    <i class="fab fa-whatsapp mr-2"></i> CHAT WITH CONCIERGE
                </a>
                <a href="{{ route('pages.contact') }}" class="btn-outline-gold">
                    CONTACT FORM
                </a>
            </div>
        </div>

    </div>
</section>

@endsection
