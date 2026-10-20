@extends('layouts.app')

@section('title', 'Refund & Royal Exchange Policy | Perfumes Collection Pakistan')

@section('content')

<section class="py-3.5 py-md-5" style="background-color: #F7F3EE;">
    <div class="container px-3 px-lg-4" style="max-width: 896px;">
        <!-- Breadcrumbs Component (Simple Home link only, removing redundant pill badge) -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')]
        ]" />

        <div class="rounded-4 p-3.5 p-sm-4 p-md-5 shadow-sm mt-2 mt-md-3" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <!-- Clean Subtitle Text (No badge container) -->
            <span class="d-inline-block mb-1.5 fw-semibold" style="font-size: 11px; letter-spacing: 0.22em; text-transform: uppercase; color: #541B29;">
                EXCHANGE &amp; RETURNS
            </span>

            <!-- Main Heading (Responsive sizing for mobile & desktop) -->
            <h1 class="font-serif fw-bold mb-3 mb-md-4" style="color: #211D1E; font-size: clamp(1.35rem, 3.8vw, 2.15rem); line-height: 1.25; letter-spacing: -0.01em;">
                Royal Exchange &amp; Return Policy
            </h1>

            <div class="d-flex flex-column gap-3 gap-md-4" style="font-size: clamp(0.88rem, 2vw, 0.95rem); color: #514744; line-height: 1.75;">
                <div>
                    <h3 class="font-serif mb-1.5 fw-semibold" style="color: #541B29; font-size: clamp(1rem, 2.8vw, 1.15rem);">1. 7-Day Privilege Exchange</h3>
                    <p class="mb-0">We want you to be captivated by your fragrance. If your flacon remains in its original unopened cellophane wrapping with the tamper-evident seal intact, you may initiate an exchange within 7 calendar days of receipt.</p>
                </div>

                <div>
                    <h3 class="font-serif mb-1.5 fw-semibold" style="color: #541B29; font-size: clamp(1rem, 2.8vw, 1.15rem);">2. Complimentary Discovery Tester Policy</h3>
                    <p class="mb-0">Every 100ml flacon is accompanied by a complimentary 2ml sample vial of the same fragrance. We encourage you to test the sample vial first on your skin. If the fragrance does not resonate with your chemistry, you may return the unopened 100ml presentation box for an immediate full exchange or store credit.</p>
                </div>

                <div>
                    <h3 class="font-serif mb-1.5 fw-semibold" style="color: #541B29; font-size: clamp(1rem, 2.8vw, 1.15rem);">3. Transit Damage &amp; Guarantee</h3>
                    <p class="mb-0">In the unlikely event of transit damage or leak during courier handling, please notify us within 24 hours on WhatsApp (<a href="{{ ravaha_whatsapp_url('Transit damage notification') }}" class="text-decoration-none fw-semibold" style="color: #541B29;" target="_blank">+92 336 3685732</a>) with a photograph. A pristine replacement will be dispatched via Express Air with no additional charges.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
