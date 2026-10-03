@extends('layouts.app')

@section('title', 'Olfactory Reviews & Testimonials — Perfumes Collection')

@section('content')
<div class="py-10 md:py-16 bg-[#080304] text-brand-ivory min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-8 mb-10 border-b border-white/10">
            <div>
                <span class="text-[10px] uppercase tracking-[0.3em] text-brand-gold px-3 py-1 bg-brand-maroon/20 border border-brand-gold/30 rounded-full inline-block mb-2">
                    Patron Testimonials
                </span>
                <h1 class="font-serif text-3xl md:text-4xl text-brand-gold font-light">Your Olfactory Reviews</h1>
            </div>
            <a href="{{ route('account.dashboard') }}" class="text-xs uppercase tracking-wider text-brand-gold hover:underline">
                &larr; Back to Patron Suite
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-950/60 border border-green-500/40 text-green-300 text-xs rounded-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-3">
                <nav class="bg-[#0d0608] border border-brand-gold/20 p-3 rounded-sm space-y-1 text-xs">
                    <a href="{{ route('account.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Patron Overview</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>Order Dossiers</span>
                    </a>
                    <a href="{{ route('account.addresses') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <span>Delivery Addresses</span>
                    </a>
                    <a href="{{ route('account.wishlist') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span>Wishlist Vault</span>
                    </a>
                    <a href="{{ route('account.reviews') }}" class="flex items-center gap-3 px-4 py-3 rounded bg-brand-maroon/30 text-brand-gold font-semibold border-l-2 border-brand-gold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        <span>Olfactory Reviews</span>
                    </a>
                </nav>
            </div>

            <!-- Reviews Content -->
            <div class="lg:col-span-9 space-y-8">
                <!-- Submit Review Form for unreviewed purchases -->
                @if(isset($unreviewedProducts) && $unreviewedProducts->isNotEmpty())
                    <div class="bg-[#0d0608] border border-brand-gold/30 p-6 md:p-8 rounded-sm shadow-xl space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-brand-gold"></span>
                            <h2 class="font-serif text-lg md:text-xl text-brand-gold font-semibold">Document an Olfactory Impression</h2>
                        </div>
                        <p class="text-xs text-brand-ivory/60">
                            Share your verified experience with longevity, projection, and scent evolution.
                        </p>

                        <form action="{{ route('account.review.store') }}" method="POST" class="space-y-4 text-xs">
                            @csrf
                            <div>
                                <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Select Commissioned Creation *</label>
                                <select name="product_id" required class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2 text-brand-ivory rounded focus:border-brand-gold focus:outline-none">
                                    @foreach($unreviewedProducts as $unrev)
                                        <option value="{{ $unrev->id }}">{{ $unrev->name }} ({{ $unrev->volume_ml }}ml Extrait)</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Artisanal Rating *</label>
                                    <select name="rating" required class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2 text-brand-ivory rounded focus:border-brand-gold focus:outline-none">
                                        <option value="5">★ ★ ★ ★ ★ (5/5 Exceptional Masterpiece)</option>
                                        <option value="4">★ ★ ★ ★ ☆ (4/5 Highly Recommended)</option>
                                        <option value="3">★ ★ ★ ☆ ☆ (3/5 Satisfactory Scent)</option>
                                        <option value="2">★ ★ ☆ ☆ ☆ (2/5 Below Expectations)</option>
                                        <option value="1">★ ☆ ☆ ☆ ☆ (1/5 Unsatisfactory)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Review Headline</label>
                                    <input type="text" name="title" placeholder="e.g. Beast mode projection with hypnotic Cambodian drydown"
                                           class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2 text-brand-ivory rounded focus:border-brand-gold focus:outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Scent Commentary & Experience *</label>
                                <textarea name="comment" required rows="3" placeholder="Describe the opening notes, sillage in Pakistani climate, and compliment factor..."
                                          class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2 text-brand-ivory rounded focus:border-brand-gold focus:outline-none"></textarea>
                            </div>

                            <button type="submit" class="py-3 px-6 bg-brand-gold text-black font-semibold uppercase tracking-[0.2em] text-[11px] rounded hover:brightness-110 transition-all">
                                Publish Review
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Published Reviews List -->
                <div class="bg-[#0d0608] border border-brand-gold/20 p-6 md:p-8 rounded-sm shadow-xl">
                    <h3 class="font-serif text-xl text-brand-gold font-light pb-4 mb-6 border-b border-white/10">
                        Your Published Olfactory Reviews ({{ $reviews->count() }})
                    </h3>

                    @if($reviews->isNotEmpty())
                        <div class="divide-y divide-white/5 space-y-6">
                            @foreach($reviews as $review)
                                <div class="pt-6 first:pt-0 text-xs space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-serif text-sm font-semibold text-brand-gold">{{ $review->product->name ?? 'Fragrance' }}</span>
                                            <span class="text-[10px] text-green-400 bg-green-950/60 border border-green-800 px-2 py-0.5 rounded ml-2">Verified Buyer</span>
                                        </div>
                                        <div class="text-brand-gold text-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                {{ $i <= $review->rating ? '★' : '☆' }}
                                            @endfor
                                        </div>
                                    </div>
                                    @if($review->title)
                                        <h4 class="font-semibold text-brand-ivory">{{ $review->title }}</h4>
                                    @endif
                                    <p class="text-brand-ivory/80 leading-relaxed italic">"{{ $review->comment }}"</p>
                                    <div class="text-[10px] text-brand-ivory/40 pt-1">
                                        Documented on {{ $review->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10 text-xs text-brand-ivory/50">
                            <p>You have not documented any fragrance reviews yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
