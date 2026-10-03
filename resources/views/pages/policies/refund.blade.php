@extends('layouts.app')

@section('title', 'Refund & Royal Exchange Policy | Maison d\'Orient Pakistan')

@section('content')

<section class="py-16 md:py-24 bg-[#080304]">
    <div class="container max-w-4xl mx-auto">
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Exchange & Returns']
        ]" />

        <h1 class="font-serif text-3xl md:text-5xl text-[#F5EFE6] mb-8 font-normal">
            Royal Exchange & Return Policy
        </h1>

        <div class="prose prose-invert max-w-none text-[#F5EFE6]/80 text-sm md:text-base leading-relaxed space-y-6">
            <h3 class="text-lg text-[#C9A24B] font-serif">1. 7-Day Privilege Exchange</h3>
            <p>We want you to be captivated by your fragrance. If your flacon remains in its original unopened cellophane wrapping with the tamper-evident seal intact, you may initiate an exchange within 7 calendar days of receipt.</p>

            <h3 class="text-lg text-[#C9A24B] font-serif">2. Complimentary Discovery Tester Policy</h3>
            <p>Every 100ml flacon is accompanied by a complimentary 2ml sample vial of the same fragrance. We encourage you to test the sample vial first on your skin. If the fragrance does not resonate with your chemistry, you may return the unopened 100ml presentation box for an immediate full exchange or store credit.</p>

            <h3 class="text-lg text-[#C9A24B] font-serif">3. Transit Damage & Guarantee</h3>
            <p>In the unlikely event of transit damage or leak during courier handling, please notify us within 24 hours on WhatsApp (+92 300 1234567) with a photograph. A pristine replacement will be dispatched via Express Air with no additional charges.</p>
        </div>
    </div>
</section>

@endsection
