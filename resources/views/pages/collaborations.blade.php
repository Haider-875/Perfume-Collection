@extends('layouts.app')

@section('title', 'Artisanal & Haute Collaborations | Maison d\'Orient Pakistan')
@section('meta_description', 'Discover rare limited-edition collaborations crafted in partnership with master distillers, calligraphers, and connoisseurs.')

@section('content')

<!-- Collaborations Hero Banner -->
<section class="relative py-16 md:py-24 bg-[#0A0405] border-b border-[#C9A24B]/20 overflow-hidden">
    <div class="absolute inset-0 bg-radial-gradient opacity-25 pointer-events-none"></div>
    <div class="container relative z-10 text-center">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Collaborations & Private Compositions']
        ]" />

        <span class="inline-block text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] mb-2 font-medium">BESPOKE PARTNERSHIPS</span>
        <h1 class="font-serif text-3xl md:text-5xl lg:text-6xl text-[#F5EFE6] mb-4 font-normal tracking-wide">
            Haute Collaborations
        </h1>
        <p class="max-w-2xl mx-auto text-[#F5EFE6]/70 text-sm md:text-base font-light leading-relaxed">
            Where master perfumery meets traditional Pakistani craftsmanship, Islamic calligraphy, and rare vintage agarwood distillations.
        </p>
    </div>
</section>

<!-- Collaborations Showcase Grid -->
<section class="py-16 bg-[#080304]">
    <div class="container">
        
        <!-- Spotlight Collab Banner -->
        <div class="mb-16 bg-[#0E0507] border border-[#C9A24B]/35 rounded-lg p-8 lg:p-12 relative overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="space-y-6">
                    <span class="text-[10px] uppercase tracking-[0.3em] text-[#C9A24B] font-semibold border border-[#C9A24B]/30 px-3 py-1 rounded inline-block">
                        LIMITED VINTAGE RUN &bull; 500 FLACONS WORLDWIDE
                    </span>
                    <h2 class="font-serif text-3xl lg:text-4xl text-[#F5EFE6]">
                        Perfumes Collection &times; Royal Mughal Calligraphy Atelier
                    </h2>
                    <p class="text-sm text-[#F5EFE6]/75 leading-relaxed">
                        An ode to the imperial gardens of Shalimar and the ancient amber trade. Featuring hand-engraved 24K gold calligraphic inscriptions on crystal flacons, housing a 40-year aged Cambodian Dehn al Oud.
                    </p>
                    <div class="pt-4 flex flex-wrap gap-4">
                        <a href="{{ route('shop.show', 'oud-royale-1947') }}" class="btn-gold">
                            DISCOVER COVETED FLACON
                        </a>
                        <a href="{{ route('pages.contact') }}" class="btn-outline-gold">
                            REQUEST BESPOKE COMMISSION
                        </a>
                    </div>
                </div>

                <div class="relative text-center">
                    <img 
                        src="{{ asset('assets/images/perfumes/oud_royale.svg') }}" 
                        alt="Royal Collaboration" 
                        class="w-72 h-72 mx-auto object-contain filter drop-shadow-2xl animate-float"
                    >
                </div>
            </div>
        </div>

        <!-- Collaboration Creations -->
        <div class="text-center mb-10">
            <h3 class="font-serif text-2xl md:text-3xl text-[#F5EFE6]">Collaborative Masterpieces</h3>
            <p class="text-xs text-[#C9A24B] tracking-widest uppercase mt-1">Limited Batches & Bespoke Reserves</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @forelse($collabProducts as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="col-span-full text-center py-12 text-[#F5EFE6]/60">
                    Collaborative releases are announced seasonally to our Private Circle members.
                </div>
            @endforelse
        </div>

    </div>
</section>

@endsection
