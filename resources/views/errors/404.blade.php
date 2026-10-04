@extends('layouts.app')

@section('title', '404 - Essence Not Found | Maison d\'Orient Haute Parfumerie')

@section('content')

<section class="d-flex align-items-center justify-content-center py-5 bg-wine-dark text-center" style="min-height: 70vh;">
    <div class="container max-w-xl px-4">
        <div class="rounded-circle bg-gold-subtle border border-gold-40 d-flex align-items-center justify-content-center text-gold fs-1 shadow-2xl mx-auto mb-4" style="width: 96px; height: 96px;">
            <i class="fas fa-gem"></i>
        </div>

        <span class="fs-8 text-uppercase tracking-widest text-gold fw-semibold d-block mb-2">ERROR 404</span>
        <h1 class="font-serif fs-1 text-light-parchment mb-3">The Essence is Elusive</h1>
        <p class="fs-6 text-light-parchment text-opacity-70 lh-base mb-4 mx-auto" style="max-width: 480px;">
            The private flacon or sanctuary page you are seeking has evaporated into the ether or been moved to our private reserve.
        </p>

        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('home') }}" class="btn btn-gold text-decoration-none">
                RETURN TO SANCTUARY
            </a>
            <a href="{{ route('collections.show', 'all') }}" class="btn btn-outline-gold text-decoration-none">
                EXPLORE VAULT
            </a>
        </div>
    </div>
</section>

@endsection
