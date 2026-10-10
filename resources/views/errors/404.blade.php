@extends('layouts.app')

@section('title', '404 - Essence Not Found | Maison d\'Orient Haute Parfumerie')

@section('content')

<section class="d-flex align-items-center justify-content-center py-5 text-center" style="min-height: 70vh; background-color: #F7F3EE;">
    <div class="container px-4" style="max-width: 600px;">
        <div class="rounded-circle d-flex align-items-center justify-content-center fs-1 shadow-sm mx-auto mb-4" style="width: 96px; height: 96px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
            <i class="fas fa-gem"></i>
        </div>

        <span class="fs-8 text-uppercase tracking-widest fw-semibold d-block mb-2" style="color: #541B29;">ERROR 404</span>
        <h1 class="font-serif fs-1 mb-3" style="color: #211D1E;">The Essence is Elusive</h1>
        <p class="fs-6 lh-base mb-4 mx-auto" style="max-width: 480px; color: #514744;">
            The private flacon or sanctuary page you are seeking has evaporated into the ether or been moved to our private reserve.
        </p>

        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('home') }}" class="btn py-2.5 px-4 text-xs tracking-wider fw-semibold text-white text-decoration-none shadow-sm" style="background-color: #541B29; border-radius: 8px;">
                RETURN TO SANCTUARY
            </a>
            <a href="{{ route('collections.show', 'all') }}" class="btn py-2.5 px-4 text-xs tracking-wider fw-semibold text-decoration-none shadow-sm" style="background-color: #FFFFFF; border: 1px solid #541B29; color: #541B29; border-radius: 8px;">
                EXPLORE VAULT
            </a>
        </div>
    </div>
</section>

@endsection
