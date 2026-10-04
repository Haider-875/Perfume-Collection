@extends('layouts.app')

@section('title', 'Olfactory Reviews & Testimonials — Perfumes Collection')

@section('content')
<div class="py-5 bg-wine-dark text-brand-ivory min-vh-100">
    <div class="container max-w-7xl">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-4 mb-4 border-bottom border-white-10">
            <div>
                <span class="badge-gold-outline mb-2 d-inline-block">
                    Patron Testimonials
                </span>
                <h1 class="font-serif fs-2 fs-md-1 text-gold fw-light mb-0">Your Olfactory Reviews</h1>
            </div>
            <a href="{{ route('account.dashboard') }}" class="fs-7 text-uppercase tracking-wider text-gold hover-gold text-decoration-none">
                &larr; Back to Patron Suite
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-opacity-10 border-success text-success p-3 rounded-1 mb-4 fs-7">
                {{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-12 col-lg-3">
                <nav class="bg-wine-card border border-gold-20 p-2 rounded-1 d-flex flex-column gap-1 fs-7">
                    <a href="{{ route('account.dashboard') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-brand-ivory text-opacity-70 hover-gold text-decoration-none transition">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Patron Overview</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-brand-ivory text-opacity-70 hover-gold text-decoration-none transition">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>Order Dossiers</span>
                    </a>
                    <a href="{{ route('account.addresses') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-brand-ivory text-opacity-70 hover-gold text-decoration-none transition">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <span>Delivery Addresses</span>
                    </a>
                    <a href="{{ route('account.wishlist') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-brand-ivory text-opacity-70 hover-gold text-decoration-none transition">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span>Wishlist Vault</span>
                    </a>
                    <a href="{{ route('account.reviews') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-gold bg-wine-accent fw-semibold border-start border-3 border-gold text-decoration-none">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        <span>Olfactory Reviews</span>
                    </a>
                </nav>
            </div>

            <!-- Reviews Content -->
            <div class="col-12 col-lg-9 d-flex flex-column gap-4">
                <!-- Submit Review Form for unreviewed purchases -->
                @if(isset($unreviewedProducts) && $unreviewedProducts->isNotEmpty())
                    <div class="bg-wine-card border border-gold-30 p-4 p-md-5 rounded-1 shadow-lg d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle bg-gold d-inline-block" style="width: 8px; height: 8px;"></span>
                            <h2 class="font-serif fs-5 fs-md-4 text-gold fw-semibold mb-0">Document an Olfactory Impression</h2>
                        </div>
                        <p class="fs-7 text-brand-ivory text-opacity-60 mb-0">
                            Share your verified experience with longevity, projection, and scent evolution.
                        </p>

                        <form action="{{ route('account.review.store') }}" method="POST" class="d-flex flex-column gap-3 fs-7">
                            @csrf
                            <div>
                                <label class="form-label text-uppercase tracking-wider text-gold text-opacity-90 mb-1 fw-medium fs-8">Select Commissioned Creation *</label>
                                <select name="product_id" required class="form-select form-control-luxury fs-7">
                                    @foreach($unreviewedProducts as $unrev)
                                        <option value="{{ $unrev->id }}">{{ $unrev->name }} ({{ $unrev->volume_ml }}ml Extrait)</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-uppercase tracking-wider text-gold text-opacity-90 mb-1 fw-medium fs-8">Artisanal Rating *</label>
                                    <select name="rating" required class="form-select form-control-luxury fs-7">
                                        <option value="5">★ ★ ★ ★ ★ (5/5 Exceptional Masterpiece)</option>
                                        <option value="4">★ ★ ★ ★ ☆ (4/5 Highly Recommended)</option>
                                        <option value="3">★ ★ ★ ☆ ☆ (3/5 Satisfactory Scent)</option>
                                        <option value="2">★ ★ ☆ ☆ ☆ (2/5 Below Expectations)</option>
                                        <option value="1">★ ☆ ☆ ☆ ☆ (1/5 Unsatisfactory)</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-uppercase tracking-wider text-gold text-opacity-90 mb-1 fw-medium fs-8">Review Headline</label>
                                    <input type="text" name="title" placeholder="e.g. Beast mode projection with hypnotic Cambodian drydown"
                                           class="form-control form-control-luxury fs-7">
                                </div>
                            </div>

                            <div>
                                <label class="form-label text-uppercase tracking-wider text-gold text-opacity-90 mb-1 fw-medium fs-8">Scent Commentary & Experience *</label>
                                <textarea name="comment" required rows="3" placeholder="Describe the opening notes, sillage in Pakistani climate, and compliment factor..."
                                          class="form-control form-control-luxury fs-7"></textarea>
                            </div>

                            <button type="submit" class="btn btn-gold py-2 px-4 fw-semibold text-uppercase tracking-wider fs-7 align-self-start">
                                Publish Review
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Published Reviews List -->
                <div class="bg-wine-card border border-gold-20 p-4 p-md-5 rounded-1 shadow-lg">
                    <h3 class="font-serif fs-5 text-gold fw-light pb-3 mb-4 border-bottom border-white-10">
                        Your Published Olfactory Reviews ({{ $reviews->count() }})
                    </h3>

                    @if($reviews->isNotEmpty())
                        <div class="d-flex flex-column gap-4">
                            @foreach($reviews as $review)
                                <div class="pt-4 border-top border-white-10 fs-7 d-flex flex-column gap-2" @if($loop->first) style="border-top: none !important; padding-top: 0 !important;" @endif>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="font-serif fs-6 fw-semibold text-gold">{{ $review->product->name ?? 'Fragrance' }}</span>
                                            <span class="badge bg-success bg-opacity-20 text-success border border-success border-opacity-50 px-2 py-1 fs-8 ms-2">Verified Buyer</span>
                                        </div>
                                        <div class="text-gold fs-6">
                                            @for($i = 1; $i <= 5; $i++)
                                                {{ $i <= $review->rating ? '★' : '☆' }}
                                            @endfor
                                        </div>
                                    </div>
                                    @if($review->title)
                                        <h4 class="fw-semibold text-brand-ivory fs-7 mb-0">{{ $review->title }}</h4>
                                    @endif
                                    <p class="text-brand-ivory text-opacity-80 lh-base fst-italic mb-0">"{{ $review->comment }}"</p>
                                    <div class="fs-8 text-brand-ivory text-opacity-40 pt-1">
                                        Documented on {{ $review->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 fs-7 text-brand-ivory text-opacity-50">
                            <p class="mb-0">You have not documented any fragrance reviews yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
