@extends('layouts.app')

@section('title', 'Refund & Royal Exchange Policy | Maison d\'Orient Pakistan')

@section('content')

<section class="py-5" style="background-color: #080304;">
    <div class="container px-3 px-lg-4" style="max-width: 896px;">
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Exchange & Returns']
        ]" />

        <h1 class="font-serif display-5 text-light-parchment mb-4 fw-normal">
            Royal Exchange & Return Policy
        </h1>

        <div class="text-light-parchment lh-lg d-flex flex-column gap-4" style="font-size: 0.95rem;">
            <h3 class="fs-5 text-gold font-serif mb-0">1. 7-Day Privilege Exchange</h3>
            <p class="text-muted-parchment mb-0">We want you to be captivated by your fragrance. If your flacon remains in its original unopened cellophane wrapping with the tamper-evident seal intact, you may initiate an exchange within 7 calendar days of receipt.</p>

            <h3 class="fs-5 text-gold font-serif mb-0">2. Complimentary Discovery Tester Policy</h3>
            <p class="text-muted-parchment mb-0">Every 100ml flacon is accompanied by a complimentary 2ml sample vial of the same fragrance. We encourage you to test the sample vial first on your skin. If the fragrance does not resonate with your chemistry, you may return the unopened 100ml presentation box for an immediate full exchange or store credit.</p>

            <h3 class="fs-5 text-gold font-serif mb-0">3. Transit Damage & Guarantee</h3>
            <p class="text-muted-parchment mb-0">In the unlikely event of transit damage or leak during courier handling, please notify us within 24 hours on WhatsApp (<a href="{{ ravaha_whatsapp_url('Transit damage notification') }}" class="text-gold text-decoration-none" target="_blank">+92 336 3685732</a>) with a photograph. A pristine replacement will be dispatched via Express Air with no additional charges.</p>
        </div>
    </div>
</section>

@endsection
