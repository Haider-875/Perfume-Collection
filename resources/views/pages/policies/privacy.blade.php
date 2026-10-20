@extends('layouts.app')

@section('title', 'Privacy Policy & Data Privilege | Perfumes Collection Pakistan')

@section('content')

<section class="py-5 py-md-6" style="background-color: #F7F3EE;">
    <div class="container px-3 px-sm-4 px-lg-5" style="max-width: 840px;">
        
        <!-- Header (Strictly Center Aligned with Generous Margins & Spacing) -->
        <div class="text-center mx-auto mb-4 mb-md-5" style="max-width: 660px;">
            <!-- Breadcrumbs Component (Simple clean Home link) -->
            <div class="d-flex justify-content-center mb-3">
                <x-breadcrumbs :items="[
                    ['label' => 'Home', 'url' => route('home')]
                ]" />
            </div>

            <!-- Clean Subtitle Text (No badge container, center aligned) -->
            <span class="d-block mb-2 fw-semibold text-center text-uppercase" style="font-size: 11px; letter-spacing: 0.26em; color: #541B29;">
                PRIVACY &amp; DATA PRIVILEGE
            </span>

            <!-- Main Heading (Center aligned, responsive typography) -->
            <h1 class="font-serif fw-bold mb-3 text-center" style="color: #211D1E; font-size: clamp(1.4rem, 4vw, 2.25rem); line-height: 1.25; letter-spacing: -0.01em;">
                Privacy Policy &amp; Data Security
            </h1>

            <p class="mx-auto lh-base fw-light mb-0 text-center" style="max-width: 580px; font-size: clamp(0.88rem, 1.8vw, 0.96rem); color: #6B605B; line-height: 1.7;">
                Our solemn commitment to your personal discretion and data sanctity. Discover how we protect your private information and courier records across Pakistan.
            </p>
        </div>

        <!-- Policy Card (Center-Aligned with Generous Margins & Paddings) -->
        <div class="rounded-4 p-4 p-sm-5 shadow-sm text-center mx-auto" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; max-width: 800px;">
            <div class="d-flex flex-column gap-4 gap-md-5">
                
                <!-- Effective Date Notice -->
                <div class="pb-3 text-center" style="border-bottom: 1px solid #F0EAE1;">
                    <span class="text-xs fw-semibold text-uppercase" style="color: #9E7D3B; font-size: 11px; letter-spacing: 0.16em;">
                        Effective Date &bull; October 2026
                    </span>
                </div>

                <!-- Point 1 -->
                <div class="pb-4 pb-md-5 text-center" style="border-bottom: 1px solid #F0EAE1;">
                    <h3 class="font-serif mb-2.5 fw-semibold text-center" style="color: #541B29; font-size: clamp(1.05rem, 2.5vw, 1.2rem);">
                        1. Commitment to Client Privilege
                    </h3>
                    <p class="mb-0 fw-light text-center mx-auto" style="max-width: 640px; font-size: clamp(0.88rem, 1.8vw, 0.95rem); color: #514744; line-height: 1.85;">
                        At Perfumes Collection, we treat your personal information with royal discretion. We only collect the minimal details necessary to dispatch your luxury perfume orders across Pakistan and deliver personalized olfactory consultations.
                    </p>
                </div>

                <!-- Point 2 -->
                <div class="pb-4 pb-md-5 text-center" style="border-bottom: 1px solid #F0EAE1;">
                    <h3 class="font-serif mb-2.5 fw-semibold text-center" style="color: #541B29; font-size: clamp(1.05rem, 2.5vw, 1.2rem);">
                        2. Information We Collect
                    </h3>
                    <div class="fw-light text-center mx-auto d-flex flex-column gap-3" style="max-width: 640px; font-size: clamp(0.88rem, 1.8vw, 0.95rem); color: #514744; line-height: 1.85;">
                        <p class="mb-0">
                            <strong style="color: #211D1E;">Contact Information:</strong> Name, phone number (for WhatsApp dispatch updates and courier delivery), email address, and physical shipping address in Pakistan.
                        </p>
                        <p class="mb-0">
                            <strong style="color: #211D1E;">Order History:</strong> Compositions ordered, preferred olfactory notes, and bespoke concierge requests.
                        </p>
                        <p class="mb-0">
                            <strong style="color: #211D1E;">Payment Security:</strong> We do not store sensitive credit card or banking credentials on our servers. All digital transactions are securely handled via PCI-DSS compliant gateways.
                        </p>
                    </div>
                </div>

                <!-- Point 3 -->
                <div class="pb-4 pb-md-5 text-center" style="border-bottom: 1px solid #F0EAE1;">
                    <h3 class="font-serif mb-2.5 fw-semibold text-center" style="color: #541B29; font-size: clamp(1.05rem, 2.5vw, 1.2rem);">
                        3. Pakistan Logistics Sharing
                    </h3>
                    <p class="mb-0 fw-light text-center mx-auto" style="max-width: 640px; font-size: clamp(0.88rem, 1.8vw, 0.95rem); color: #514744; line-height: 1.85;">
                        Your address and phone number are shared solely with our verified express courier partners (TCS, Leopards, Swyft) to ensure seamless delivery and Cash on Delivery (COD) collection.
                    </p>
                </div>

                <!-- Point 4 -->
                <div class="text-center">
                    <h3 class="font-serif mb-2.5 fw-semibold text-center" style="color: #541B29; font-size: clamp(1.05rem, 2.5vw, 1.2rem);">
                        4. The Private Circle Newsletter
                    </h3>
                    <p class="mb-0 fw-light text-center mx-auto" style="max-width: 640px; font-size: clamp(0.88rem, 1.8vw, 0.95rem); color: #514744; line-height: 1.85;">
                        If you subscribe to our newsletter, you may unsubscribe at any time using the one-click unsubscribe link provided in every imperial dispatch.
                    </p>
                </div>

            </div>
        </div>

        <!-- Trust Note at Bottom (Center Aligned with generous top margin) -->
        <div class="text-center mt-4 mt-md-5">
            <span class="d-block text-xs fw-medium text-center" style="color: #786C67; font-size: 12px; letter-spacing: 0.04em;">
                Encrypted transactions &bull; 100% confidential personal data handling
            </span>
        </div>

    </div>
</section>

@endsection
