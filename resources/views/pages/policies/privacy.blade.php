@extends('layouts.app')

@section('title', 'Privacy Policy & Data Privilege | Maison d\'Orient Pakistan')

@section('content')

<section class="py-5" style="background-color: #080304;">
    <div class="container px-3 px-lg-4" style="max-width: 896px;">
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Privacy Policy']
        ]" />

        <h1 class="font-serif display-5 text-light-parchment mb-4 fw-normal">
            Privacy Policy & Data Security
        </h1>

        <div class="text-light-parchment lh-lg d-flex flex-column gap-4" style="font-size: 0.95rem;">
            <p class="mb-0"><strong>Effective Date:</strong> October 2026</p>

            <h3 class="fs-5 text-gold font-serif mb-0">1. Commitment to Client Privilege</h3>
            <p class="text-muted-parchment mb-0">At Perfumes Collection, we treat your personal information with royal discretion. We only collect the minimal details necessary to dispatch your luxury perfume orders across Pakistan and deliver personalized olfactory consultations.</p>

            <h3 class="fs-5 text-gold font-serif mb-0">2. Information We Collect</h3>
            <ul class="text-muted-parchment ps-3 mb-0 d-flex flex-column gap-2">
                <li><strong class="text-light-parchment">Contact Information:</strong> Name, phone number (for WhatsApp updates and courier delivery), email address, and physical shipping address in Pakistan.</li>
                <li><strong class="text-light-parchment">Order History:</strong> Compositions ordered, preferred olfactory notes, and bespoke requests.</li>
                <li><strong class="text-light-parchment">Payment Security:</strong> We do not store sensitive credit card or banking credentials on our servers. All digital transactions are handled via PCI-DSS compliant gateways.</li>
            </ul>

            <h3 class="fs-5 text-gold font-serif mb-0">3. Pakistan Logistics Sharing</h3>
            <p class="text-muted-parchment mb-0">Your address and phone number are shared solely with our verified express courier partners (TCS, Leopards, Swyft) to ensure seamless delivery and Cash on Delivery (COD) collection.</p>

            <h3 class="fs-5 text-gold font-serif mb-0">4. The Private Circle Newsletter</h3>
            <p class="text-muted-parchment mb-0">If you subscribe to our newsletter, you may unsubscribe at any time using the one-click unsubscribe link provided in every imperial dispatch.</p>
        </div>
    </div>
</section>

@endsection
