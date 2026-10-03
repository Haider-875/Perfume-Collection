@extends('layouts.app')

@section('title', 'Privacy Policy & Data Privilege | Maison d\'Orient Pakistan')

@section('content')

<section class="py-16 md:py-24 bg-[#080304]">
    <div class="container max-w-4xl mx-auto">
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Privacy Policy']
        ]" />

        <h1 class="font-serif text-3xl md:text-5xl text-[#F5EFE6] mb-8 font-normal">
            Privacy Policy & Data Security
        </h1>

        <div class="prose prose-invert max-w-none text-[#F5EFE6]/80 text-sm md:text-base leading-relaxed space-y-6">
            <p><strong>Effective Date:</strong> October 2026</p>

            <h3 class="text-lg text-[#C9A24B] font-serif">1. Commitment to Client Privilege</h3>
            <p>At Perfumes Collection, we treat your personal information with royal discretion. We only collect the minimal details necessary to dispatch your luxury perfume orders across Pakistan and deliver personalized olfactory consultations.</p>

            <h3 class="text-lg text-[#C9A24B] font-serif">2. Information We Collect</h3>
            <ul class="list-disc pl-5 space-y-2 text-[#F5EFE6]/70 text-sm">
                <li><strong>Contact Information:</strong> Name, phone number (for WhatsApp updates and courier delivery), email address, and physical shipping address in Pakistan.</li>
                <li><strong>Order History:</strong> Compositions ordered, preferred olfactory notes, and bespoke requests.</li>
                <li><strong>Payment Security:</strong> We do not store sensitive credit card or banking credentials on our servers. All digital transactions are handled via PCI-DSS compliant gateways.</li>
            </ul>

            <h3 class="text-lg text-[#C9A24B] font-serif">3. Pakistan Logistics Sharing</h3>
            <p>Your address and phone number are shared solely with our verified express courier partners (TCS, Leopards, Swyft) to ensure seamless delivery and Cash on Delivery (COD) collection.</p>

            <h3 class="text-lg text-[#C9A24B] font-serif">4. The Private Circle Newsletter</h3>
            <p>If you subscribe to our newsletter, you may unsubscribe at any time using the one-click unsubscribe link provided in every imperial dispatch.</p>
        </div>
    </div>
</section>

@endsection
