@extends('layouts.app')

@section('title', 'Refund & Royal Exchange Policy | Perfumes Collection Pakistan')

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
                EXCHANGE &amp; RETURNS
            </span>

            <!-- Main Heading (Center aligned, responsive typography) -->
            <h1 class="font-serif fw-bold mb-3 text-center" style="color: #211D1E; font-size: clamp(1.4rem, 4vw, 2.25rem); line-height: 1.25; letter-spacing: -0.01em;">
                Royal Exchange &amp; Return Policy
            </h1>

            <p class="mx-auto lh-base fw-light mb-0 text-center" style="max-width: 580px; font-size: clamp(0.88rem, 1.8vw, 0.96rem); color: #6B605B; line-height: 1.7;">
                Our solemn commitment to your fragrance satisfaction. Discover our 7-day privilege exchange and guaranteed express courier transit protection across Pakistan.
            </p>
        </div>

        <!-- Policy Card (Center-Aligned with Generous Margins & Paddings) -->
        <div class="rounded-4 p-4 p-sm-5 shadow-sm text-center mx-auto" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; max-width: 800px;">
            <div class="d-flex flex-column gap-4 gap-md-5">
                
                <!-- Policy 1 -->
                <div class="pb-4 pb-md-5 text-center" style="border-bottom: 1px solid #F0EAE1;">
                    <div class="d-inline-flex align-items-center justify-content-center gap-2 mb-2.5 text-center">
                        <i class="fas fa-rotate fs-6" style="color: #9E7D3B !important;"></i>
                        <h3 class="font-serif mb-0 fw-semibold text-center" style="color: #541B29; font-size: clamp(1.05rem, 2.5vw, 1.2rem);">
                            1. 7-Day Privilege Exchange
                        </h3>
                    </div>
                    <p class="mb-0 fw-light text-center mx-auto" style="max-width: 640px; font-size: clamp(0.88rem, 1.8vw, 0.95rem); color: #514744; line-height: 1.85;">
                        We want you to be captivated by your fragrance. If your flacon remains in its original unopened cellophane wrapping with the tamper-evident seal intact, you may initiate an exchange within 7 calendar days of receipt.
                    </p>
                </div>

                <!-- Policy 2 -->
                <div class="pb-4 pb-md-5 text-center" style="border-bottom: 1px solid #F0EAE1;">
                    <div class="d-inline-flex align-items-center justify-content-center gap-2 mb-2.5 text-center">
                        <i class="fas fa-vial fs-6" style="color: #9E7D3B !important;"></i>
                        <h3 class="font-serif mb-0 fw-semibold text-center" style="color: #541B29; font-size: clamp(1.05rem, 2.5vw, 1.2rem);">
                            2. Complimentary Discovery Tester Policy
                        </h3>
                    </div>
                    <p class="mb-0 fw-light text-center mx-auto" style="max-width: 640px; font-size: clamp(0.88rem, 1.8vw, 0.95rem); color: #514744; line-height: 1.85;">
                        Every 100ml flacon is accompanied by a complimentary 2ml sample vial of the same fragrance. We encourage you to test the sample vial first on your skin. If the fragrance does not resonate with your chemistry, you may return the unopened 100ml presentation box for an immediate full exchange or store credit.
                    </p>
                </div>

                <!-- Policy 3 -->
                <div class="text-center">
                    <div class="d-inline-flex align-items-center justify-content-center gap-2 mb-2.5 text-center">
                        <i class="fas fa-shield-halved fs-6" style="color: #9E7D3B !important;"></i>
                        <h3 class="font-serif mb-0 fw-semibold text-center" style="color: #541B29; font-size: clamp(1.05rem, 2.5vw, 1.2rem);">
                            3. Transit Damage &amp; Guarantee
                        </h3>
                    </div>
                    <p class="mb-0 fw-light text-center mx-auto" style="max-width: 640px; font-size: clamp(0.88rem, 1.8vw, 0.95rem); color: #514744; line-height: 1.85;">
                        In the unlikely event of transit damage or leak during courier handling, please notify us within 24 hours on WhatsApp (<a href="{{ ravaha_whatsapp_url('Transit damage notification') }}" class="text-decoration-none fw-semibold" style="color: #541B29;" target="_blank">+92 336 3685732</a>) with a photograph. A pristine replacement will be dispatched via Express Air with no additional charges.
                    </p>
                </div>

            </div>
        </div>

        <!-- Trust Note at Bottom (Center Aligned with generous top margin) -->
        <div class="text-center mt-4 mt-md-5">
            <span class="d-inline-flex align-items-center justify-content-center gap-2 text-xs fw-medium text-center" style="color: #786C67; font-size: 12px;">
                <i class="fas fa-shield-halved" style="color: #9E7D3B;"></i>
                Insured nationwide dispatch &amp; 100% verified authentic French Extrait formulations
            </span>
        </div>

    </div>
</section>

@endsection
