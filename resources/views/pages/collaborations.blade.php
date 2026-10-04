@extends('layouts.app')

@section('title', 'Artisanal & Haute Collaborations | Maison d\'Orient Pakistan')
@section('meta_description', 'Discover rare limited-edition collaborations crafted in partnership with master distillers, calligraphers, and connoisseurs.')

@section('content')

<!-- Collaborations Hero Banner -->
<section class="py-5 border-bottom border-gold-20 text-center position-relative overflow-hidden" style="background-color: #0A0405;">
    <div class="container px-3 px-lg-4 position-relative z-1">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Collaborations & Private Compositions']
        ]" />

        <span class="d-inline-block text-gold mb-2 fw-medium" style="font-size: 11px; letter-spacing: 0.3em; text-transform: uppercase;">BESPOKE PARTNERSHIPS</span>
        <h1 class="font-serif text-light-parchment mb-3 fw-normal display-5 tracking-wide">
            Haute Collaborations
        </h1>
        <p class="mx-auto text-muted-parchment lh-base fw-light mb-0" style="max-width: 672px; font-size: 0.95rem;">
            Where master perfumery meets traditional Pakistani craftsmanship, Islamic calligraphy, and rare vintage agarwood distillations.
        </p>
    </div>
</section>

<!-- Collaborations Showcase Grid -->
<section class="py-5" style="background-color: #080304;">
    <div class="container px-3 px-lg-4">
        
        <!-- Spotlight Collab Banner -->
        <div class="mb-5 bg-wine-card border border-gold-30 rounded-3 p-4 p-lg-5 position-relative overflow-hidden">
            <div class="row g-4 align-items-center">
                <div class="col-12 col-lg-6 d-flex flex-column gap-3">
                    <div>
                        <span class="text-gold fw-semibold border border-gold-30 px-3 py-1 rounded d-inline-block text-uppercase" style="font-size: 10px; letter-spacing: 0.25em;">
                            LIMITED VINTAGE RUN &bull; 500 FLACONS WORLDWIDE
                        </span>
                    </div>
                    <h2 class="font-serif fs-2 text-light-parchment lh-sm mb-0">
                        Perfumes Collection &times; Royal Mughal Calligraphy Atelier
                    </h2>
                    <p class="text-muted-parchment lh-base mb-0" style="font-size: 0.95rem;">
                        An ode to the imperial gardens of Shalimar and the ancient amber trade. Featuring hand-engraved 24K gold calligraphic inscriptions on crystal flacons, housing a 40-year aged Cambodian Dehn al Oud.
                    </p>
                    <div class="pt-2 d-flex flex-wrap gap-3">
                        <a href="{{ route('shop.show', 'oud-royale-1947') }}" class="btn-gold text-decoration-none">
                            DISCOVER COVETED FLACON
                        </a>
                        <a href="{{ route('pages.contact') }}" class="btn-outline-gold text-decoration-none">
                            REQUEST BESPOKE COMMISSION
                        </a>
                    </div>
                </div>

                <div class="col-12 col-lg-6 text-center">
                    <img 
                        src="{{ asset('assets/images/perfumes/oud_royale.svg') }}" 
                        alt="Royal Collaboration" 
                        class="img-fluid drop-shadow"
                        style="max-height: 288px;"
                    >
                </div>
            </div>
        </div>

        <!-- Collaboration Creations -->
        <div class="text-center mb-4">
            <h3 class="font-serif fs-3 text-light-parchment mb-1">Collaborative Masterpieces</h3>
            <p class="text-xs text-gold text-uppercase tracking-widest mb-0">Limited Batches & Bespoke Reserves</p>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
            @forelse($collabProducts as $product)
                <div class="col">
                    <x-product-card :product="$product" />
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted-parchment">
                    Collaborative releases are announced seasonally to our Private Circle members.
                </div>
            @endforelse
        </div>

    </div>
</section>

@endsection
