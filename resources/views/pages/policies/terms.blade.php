@extends('layouts.app')

@section('title', 'Terms of Service | Maison d\'Orient Haute Parfumerie')

@section('content')

<section class="py-16 md:py-24 bg-[#080304]">
    <div class="container max-w-4xl mx-auto">
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Terms of Service']
        ]" />

        <h1 class="font-serif text-3xl md:text-5xl text-[#F5EFE6] mb-8 font-normal">
            Terms of Service
        </h1>

        <div class="prose prose-invert max-w-none text-[#F5EFE6]/80 text-sm md:text-base leading-relaxed space-y-6">
            <h3 class="text-lg text-[#C9A24B] font-serif">1. Authentic Artisanal Formulations</h3>
            <p>All compositions sold by Perfumes Collection are guaranteed 100% authentic Extrait de Parfum and pure Dehn al Oud oils. Due to natural seasonal variations in harvests of Cambodian agarwood, Taif roses, and Mysore sandalwood, subtle olfactory nuances between batches reflect uncompromised botanical authenticity.</p>

            <h3 class="text-lg text-[#C9A24B] font-serif">2. Pricing & Currency</h3>
            <p>All prices listed on our platform are denominated in Pakistani Rupees (PKR) and include applicable domestic sales taxes unless explicitly stated otherwise.</p>

            <h3 class="text-lg text-[#C9A24B] font-serif">3. Order Verification</h3>
            <p>For Cash on Delivery (COD) orders, our concierge team may confirm your dispatch details via automated SMS or WhatsApp before release from our Lahore atelier.</p>
        </div>
    </div>
</section>

@endsection
