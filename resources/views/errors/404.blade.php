@extends('layouts.app')

@section('title', '404 - Essence Not Found | Maison d\'Orient Haute Parfumerie')

@section('content')

<section class="min-h-[70vh] flex items-center justify-center py-20 bg-[#080304] text-center">
    <div class="container max-w-xl mx-auto px-4">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-[#C9A24B]/10 border border-[#C9A24B]/40 flex items-center justify-center text-[#C9A24B] text-4xl shadow-2xl">
            <i class="fas fa-gem"></i>
        </div>

        <span class="text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] font-semibold block mb-2">ERROR 404</span>
        <h1 class="font-serif text-4xl md:text-5xl text-[#F5EFE6] mb-4">The Essence is Elusive</h1>
        <p class="text-sm md:text-base text-[#F5EFE6]/70 leading-relaxed mb-8">
            The private flacon or sanctuary page you are seeking has evaporated into the ether or been moved to our private reserve.
        </p>

        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('home') }}" class="btn-gold">
                RETURN TO SANCTUARY
            </a>
            <a href="{{ route('collections.show', 'all') }}" class="btn-outline-gold">
                EXPLORE VAULT
            </a>
        </div>
    </div>
</section>

@endsection
