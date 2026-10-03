@extends('layouts.app')

@section('title', 'Search Fragrance Vault: ' . ($q ? e($q) : 'All') . ' | Perfumes Collection Pakistan')

@section('content')

<!-- Search Results Banner -->
<section class="relative py-16 md:py-20 bg-gradient-to-b from-[#18050b] via-[#0d0305] to-[#050203] border-b border-[#d6aa62]/20">
    <div class="container max-w-3xl mx-auto text-center px-4">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Vault Search']
        ]" />

        <span class="inline-block text-[11px] uppercase tracking-[0.28em] text-[#d6aa62] mb-2 font-semibold">OLFACTORY DISCOVERY</span>
        <h1 class="font-serif text-3xl md:text-5xl text-[#f5efe7] mb-6 font-normal">
            Search Results for "{{ $q }}"
        </h1>

        <!-- Search Bar -->
        <form action="{{ route('pages.search') }}" method="GET" class="relative max-w-xl mx-auto">
            <input 
                type="text" 
                name="q" 
                value="{{ $q }}" 
                placeholder="Search notes (Oud, Amber, Taif Rose), designer names..." 
                class="w-full bg-[#080204] border border-[#d6aa62]/35 rounded-xl px-5 py-3 text-sm text-[#f5efe7] placeholder-[#b8a9a2]/50 focus:outline-none focus:border-[#d6aa62] shadow-inner"
            >
            <button type="submit" class="absolute right-2 top-2 btn-gold px-5 py-1.5 rounded-lg text-xs font-semibold uppercase tracking-wider">
                Search
            </button>
        </form>
    </div>
</section>

<!-- Search Results Grid -->
<section class="py-16 bg-[#050203]">
    <div class="container mx-auto px-4 lg:px-8">
        @if($products->count() > 0)
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-[#d6aa62]/20">
                <p class="text-xs text-[#b8a9a2] tracking-wider">
                    Found <span class="text-[#d6aa62] font-semibold">{{ $products->total() }}</span> matching compositions
                </p>
                <a href="{{ route('collections.show', 'all') }}" class="text-xs text-[#d6aa62] hover:text-[#f0d59d] hover:underline uppercase tracking-wider">
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
            <div class="text-center py-20 bg-[#140408] border border-[#d6aa62]/25 rounded-2xl max-w-2xl mx-auto p-8 space-y-4">
                <i class="fas fa-search text-4xl text-[#d6aa62]/50 mb-2"></i>
                <h3 class="font-serif text-2xl text-[#f5efe7]">No Matching Compositions</h3>
                <p class="text-xs text-[#b8a9a2] max-w-md mx-auto">
                    We could not find any perfumes matching "{{ $q }}". Try searching for fragrance notes like "Oud", "Saffron", "Taif Rose", or "Amber".
                </p>
                <div class="pt-2">
                    <a href="{{ route('collections.show', 'all') }}" class="btn-gold py-3 px-8 text-xs uppercase tracking-widest inline-block">
                        EXPLORE ALL PERFUMES
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

@endsection
