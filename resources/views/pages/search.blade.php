@extends('layouts.app')

@section('title', 'Search Fragrance Vault: ' . ($q ? e($q) : 'All') . ' | Maison d\'Orient Pakistan')

@section('content')

<!-- Search Results Banner -->
<section class="relative py-16 md:py-20 bg-[#0A0405] border-b border-[#C9A24B]/20">
    <div class="container max-w-3xl mx-auto text-center">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Vault Search']
        ]" />

        <span class="inline-block text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] mb-2 font-medium">OLFACTORY DISCOVERY</span>
        <h1 class="font-serif text-3xl md:text-4xl text-[#F5EFE6] mb-6">
            Search Results for "{{ $q }}"
        </h1>

        <!-- Search Bar -->
        <form action="{{ route('pages.search') }}" method="GET" class="relative max-w-xl mx-auto">
            <input 
                type="text" 
                name="q" 
                value="{{ $q }}" 
                placeholder="Search notes (Oud, Amber, Taif Rose), concentration..." 
                class="w-full bg-[#120709] border border-[#C9A24B]/40 rounded px-5 py-3 text-sm text-[#F5EFE6] focus:outline-none focus:border-[#C9A24B] shadow-inner"
            >
            <button type="submit" class="absolute right-2 top-2 bg-[#C9A24B] text-[#080304] px-4 py-1.5 rounded text-xs font-semibold uppercase tracking-wider hover:bg-[#E6C77A] transition">
                Search
            </button>
        </form>
    </div>
</section>

<!-- Search Results Grid -->
<section class="py-16 bg-[#080304]">
    <div class="container">
        @if($products->count() > 0)
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-[#C9A24B]/15">
                <p class="text-xs text-[#F5EFE6]/60 tracking-wider">
                    Found <span class="text-[#C9A24B] font-semibold">{{ $products->total() }}</span> matching compositions
                </p>
                <a href="{{ route('collections.show', 'all') }}" class="text-xs text-[#C9A24B] hover:underline uppercase tracking-wider">
                    Browse All Masterpieces &rarr;
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-[#0E0507] border border-[#C9A24B]/20 rounded-lg max-w-2xl mx-auto p-8">
                <i class="fas fa-search text-4xl text-[#C9A24B]/40 mb-4"></i>
                <h3 class="font-serif text-2xl text-[#F5EFE6] mb-2">No Matching Compositions</h3>
                <p class="text-xs text-[#F5EFE6]/60 mb-6">
                    We could not find any perfumes matching "{{ $q }}". Try searching for fragrance notes like "Oud", "Saffron", "Vanilla", or "Amber".
                </p>
                <a href="{{ route('collections.show', 'all') }}" class="btn-gold">
                    EXPLORE ALL PERFUMES
                </a>
            </div>
        @endif
    </div>
</section>

@endsection
