@extends('layouts.app')

@section('title', 'Artisanal & Haute Collaborations | Maison d\'Orient Pakistan')
@section('meta_description', 'Discover rare limited-edition collaborations crafted in partnership with master distillers, calligraphers, and connoisseurs.')

@section('content')

<!-- Collaborations Hero Banner -->
<section class="py-5 text-center position-relative overflow-hidden" style="background-color: #FAF7F2; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4 position-relative z-1">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Collaborations & Private Compositions']
        ]" />

        <span class="d-inline-block mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.3em; text-transform: uppercase; color: #541B29;">BESPOKE PARTNERSHIPS</span>
        <h1 class="font-serif mb-3 fw-normal display-5 tracking-wide" style="color: #211D1E;">
            Haute Collaborations
        </h1>
        <p class="mx-auto lh-base mb-0" style="max-width: 672px; font-size: 0.95rem; color: #514744;">
            Where master perfumery meets traditional Pakistani craftsmanship, Islamic calligraphy, and rare vintage agarwood distillations.
        </p>
    </div>
</section>

<!-- Collaborations Showcase Grid -->
<section class="py-5" style="background-color: #F7F3EE;">
    <div class="container px-3 px-lg-4">
        
        <!-- Spotlight Collab Banner -->
        <div class="mb-5 rounded-3 p-4 p-lg-5 position-relative overflow-hidden shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <div class="row g-4 align-items-center">
                <div class="col-12 col-lg-6 d-flex flex-column gap-3">
                    <div>
                        <span class="fw-semibold px-3 py-1 rounded d-inline-block text-uppercase" style="font-size: 10px; letter-spacing: 0.25em; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                            LIMITED VINTAGE RUN &bull; 500 FLACONS WORLDWIDE
                        </span>
                    </div>
                    <h2 class="font-serif fs-2 lh-sm mb-0" style="color: #211D1E;">
                        Perfumes Collection &times; Royal Mughal Calligraphy Atelier
                    </h2>
                    <p class="lh-base mb-0" style="font-size: 0.95rem; color: #514744;">
                        An ode to the imperial gardens of Shalimar and the ancient amber trade. Featuring hand-engraved 24K gold calligraphic inscriptions on crystal flacons, housing a 40-year aged Cambodian Dehn al Oud.
                    </p>
                    <div class="pt-2 d-flex flex-wrap gap-3">
                        <a href="{{ route('shop.show', 'oud-royale-1947') }}" class="btn py-2.5 px-4 text-xs tracking-wider fw-semibold text-white text-decoration-none shadow-sm" style="background-color: #541B29; border-radius: 8px;">
                            DISCOVER COVETED FLACON
                        </a>
                        <a href="{{ route('pages.contact') }}" class="btn py-2.5 px-4 text-xs tracking-wider fw-semibold text-decoration-none shadow-sm" style="background-color: #FFFFFF; border: 1px solid #541B29; color: #541B29; border-radius: 8px;">
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
            <h3 class="font-serif fs-3 mb-1" style="color: #211D1E;">Collaborative Masterpieces</h3>
            <p class="text-xs text-uppercase tracking-widest mb-0 fw-semibold" style="color: #541B29;">Limited Batches & Bespoke Reserves</p>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
            @forelse($collabProducts as $product)
                <div class="col">
                    <x-product-card :product="$product" />
                </div>
            @empty
                <div class="col-12 text-center py-5" style="color: #786C67;">
                    Collaborative releases are announced seasonally to our Private Circle members.
                </div>
            @endforelse
        </div>

    </div>
</section>

@endsection
