@extends('layouts.app')

@section('title', 'Olfactory Reviews & Testimonials — Perfumes Collection')

@section('content')
<div class="py-5 min-vh-100" style="background-color: #F7F3EE;">
    <div class="container" style="max-width: 1280px;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-4 mb-4" style="border-bottom: 1px solid #E8E0DA;">
            <div>
                <span class="d-inline-block fw-semibold px-3 py-1 rounded-pill mb-2 text-uppercase" style="font-size: 10px; letter-spacing: 0.3em; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                    Patron Testimonials
                </span>
                <h1 class="font-serif fs-2 fs-md-1 fw-normal mb-0" style="color: #211D1E;">Your Olfactory Reviews</h1>
            </div>
            <a href="{{ route('account.dashboard') }}" class="fs-7 text-uppercase tracking-wider fw-semibold text-decoration-none" style="color: #541B29;">
                &larr; Back to Patron Suite
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success border border-success-subtle text-success-emphasis p-3 rounded-3 mb-4 fs-7 shadow-sm" style="background-color: #FAF7F2;">
                {{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-12 col-lg-3">
                <nav class="p-2 rounded-3 d-flex flex-column gap-1 fs-7 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <a href="{{ route('account.dashboard') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-decoration-none transition" style="color: #6B605B;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Patron Overview</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-decoration-none transition" style="color: #6B605B;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>Order Dossiers</span>
                    </a>
                    <a href="{{ route('account.addresses') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-decoration-none transition" style="color: #6B605B;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <span>Delivery Addresses</span>
                    </a>
                    <a href="{{ route('account.wishlist') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-decoration-none transition" style="color: #6B605B;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span>Wishlist Vault</span>
                    </a>
                    <a href="{{ route('account.reviews') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded fw-semibold text-decoration-none" style="background-color: #FAF7F2; color: #541B29; border-left: 3px solid #541B29;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        <span>Olfactory Reviews</span>
                    </a>
                </nav>
            </div>

            <!-- Reviews Content -->
            <div class="col-12 col-lg-9 d-flex flex-column gap-4">
                <!-- Submit Review Form for unreviewed purchases -->
                @if(isset($unreviewedProducts) && $unreviewedProducts->isNotEmpty())
                    <div class="p-4 p-md-5 rounded-3 shadow-sm d-flex flex-column gap-3" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background-color: #541B29;"></span>
                            <h2 class="font-serif fs-5 fs-md-4 fw-semibold mb-0" style="color: #211D1E;">Document an Olfactory Impression</h2>
                        </div>
                        <p class="fs-7 mb-0" style="color: #6B605B;">
                            Share your verified experience with longevity, projection, and scent evolution.
                        </p>

                        <form action="{{ route('account.review.store') }}" method="POST" class="d-flex flex-column gap-3 fs-7">
                            @csrf
                            <div>
                                <label class="form-label text-uppercase tracking-wider mb-1 fw-semibold fs-8" style="color: #541B29;">Select Commissioned Creation *</label>
                                <select name="product_id" required class="form-select form-control-luxury fs-7">
                                    @foreach($unreviewedProducts as $unrev)
                                        <option value="{{ $unrev->id }}">{{ $unrev->name }} ({{ $unrev->volume_ml }}ml Extrait)</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-uppercase tracking-wider mb-1 fw-semibold fs-8" style="color: #541B29;">Artisanal Rating *</label>
                                    <select name="rating" required class="form-select form-control-luxury fs-7">
                                        <option value="5">★ ★ ★ ★ ★ (5/5 Exceptional Masterpiece)</option>
                                        <option value="4">★ ★ ★ ★ ☆ (4/5 Highly Recommended)</option>
                                        <option value="3">★ ★ ★ ☆ ☆ (3/5 Satisfactory Scent)</option>
                                        <option value="2">★ ★ ☆ ☆ ☆ (2/5 Below Expectations)</option>
                                        <option value="1">★ ☆ ☆ ☆ ☆ (1/5 Unsatisfactory)</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-uppercase tracking-wider mb-1 fw-semibold fs-8" style="color: #541B29;">Review Headline</label>
                                    <input type="text" name="title" placeholder="e.g. Beast mode projection with hypnotic Cambodian drydown"
                                           class="form-control form-control-luxury fs-7">
                                </div>
                            </div>

                            <div>
                                <label class="form-label text-uppercase tracking-wider mb-1 fw-semibold fs-8" style="color: #541B29;">Scent Commentary & Experience *</label>
                                <textarea name="comment" required rows="3" placeholder="Describe the opening notes, sillage in Pakistani climate, and compliment factor..."
                                          class="form-control form-control-luxury fs-7"></textarea>
                            </div>

                            <button type="submit" class="btn py-2 px-4 fw-semibold text-uppercase tracking-wider fs-7 align-self-start text-white shadow-sm" style="background-color: #541B29; border-radius: 8px;">
                                Publish Review
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Published Reviews List -->
                <div class="p-4 p-md-5 rounded-3 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <h3 class="font-serif fs-5 fw-medium pb-3 mb-4" style="color: #211D1E; border-bottom: 1px solid #E8E0DA;">
                        Your Published Olfactory Reviews ({{ $reviews->count() }})
                    </h3>

                    @if($reviews->isNotEmpty())
                        <div class="d-flex flex-column gap-4">
                            @foreach($reviews as $review)
                                <div class="pt-4 fs-7 d-flex flex-column gap-2" style="{{ !$loop->first ? 'border-top: 1px solid #E8E0DA;' : '' }}">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="font-serif fs-6 fw-bold" style="color: #541B29;">{{ $review->product->name ?? 'Fragrance' }}</span>
                                            <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-2 py-1 fs-8 ms-2">Verified Buyer</span>
                                        </div>
                                        <div class="fs-6" style="color: #D4A017;">
                                            @for($i = 1; $i <= 5; $i++)
                                                {{ $i <= $review->rating ? '★' : '☆' }}
                                            @endfor
                                        </div>
                                    </div>
                                    @if($review->title)
                                        <h4 class="fw-semibold fs-7 mb-0" style="color: #211D1E;">{{ $review->title }}</h4>
                                    @endif
                                    <p class="lh-base fst-italic mb-0" style="color: #514744;">"{{ $review->comment }}"</p>
                                    <div class="fs-8 pt-1" style="color: #786C67;">
                                        Documented on {{ $review->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 fs-7" style="color: #786C67;">
                            <p class="mb-0">You have not documented any fragrance reviews yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
