@extends('layouts.app')

@section('title', 'Terms of Service | Maison d\'Orient Haute Parfumerie')

@section('content')

<section class="py-5" style="background-color: #080304;">
    <div class="container px-3 px-lg-4" style="max-width: 896px;">
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Terms of Service']
        ]" />

        <h1 class="font-serif display-5 text-light-parchment mb-4 fw-normal">
            Terms of Service
        </h1>

        <div class="text-light-parchment lh-lg d-flex flex-column gap-4" style="font-size: 0.95rem;">
            <h3 class="fs-5 text-gold font-serif mb-0">1. Authentic Artisanal Formulations</h3>
            <p class="text-muted-parchment mb-0">All compositions sold by Perfumes Collection are guaranteed 100% authentic Extrait de Parfum and pure Dehn al Oud oils. Due to natural seasonal variations in harvests of Cambodian agarwood, Taif roses, and Mysore sandalwood, subtle olfactory nuances between batches reflect uncompromised botanical authenticity.</p>

            <h3 class="fs-5 text-gold font-serif mb-0">2. Pricing & Currency</h3>
            <p class="text-muted-parchment mb-0">All prices listed on our platform are denominated in Pakistani Rupees (PKR) and include applicable domestic sales taxes unless explicitly stated otherwise.</p>

            <h3 class="fs-5 text-gold font-serif mb-0">3. Order Verification</h3>
            <p class="text-muted-parchment mb-0">For Cash on Delivery (COD) orders, our concierge team may confirm your dispatch details via automated SMS or WhatsApp before release from our Lahore atelier.</p>
        </div>
    </div>
</section>

@endsection
