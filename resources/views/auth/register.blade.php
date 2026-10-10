@extends('layouts.app')

@section('title', 'Create Account — Perfumes Collection')

@section('content')
<div class="d-flex align-items-center justify-content-center px-3 py-5" style="min-height: 75vh; background-color: #F7F3EE;">
    <div class="w-100 p-4 p-md-5 rounded-4 shadow-sm position-relative" style="max-width: 448px; background-color: #FFFFFF; border: 1px solid #E8E0DA;">
        <div class="text-center mb-4">
            <span class="fw-semibold px-3 py-1 rounded-pill d-inline-block mb-2 text-uppercase" style="font-size: 11px; letter-spacing: 0.25em; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                New Patron
            </span>
            <h1 class="font-serif fs-2 fw-normal tracking-tight mb-1" style="color: #211D1E;">Create An Account</h1>
            <p class="text-sm fw-light mb-0" style="color: #6B605B;">Join Perfumes Collection to track your orders and enjoy swift checkout.</p>
        </div>

        @if($errors->any())
            <div class="alert rounded-3 p-3 mb-4 d-flex flex-column gap-1" style="background-color: #FDF2F2; border: 1px solid #F8B4B4; color: #9B1C1C;">
                @foreach($errors->all() as $error)
                    <div class="d-flex align-items-center gap-2 text-xs">
                        <i class="fas fa-circle-exclamation"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="d-flex flex-column gap-3 text-sm">
            @csrf
            <div>
                <label class="d-block text-xs fw-semibold text-uppercase tracking-wider mb-1" style="color: #541B29;">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="e.g. Daniyal Khan"
                       class="form-control text-sm py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
            </div>

            <div>
                <label class="d-block text-xs fw-semibold text-uppercase tracking-wider mb-1" style="color: #541B29;">Email Address *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       placeholder="name@domain.com"
                       class="form-control text-sm py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
            </div>

            <div class="row g-2">
                <div class="col-12 col-sm-6">
                    <label class="d-block text-xs fw-semibold text-uppercase tracking-wider mb-1" style="color: #541B29;">Phone Number</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" 
                           placeholder="0300 1234567"
                           class="form-control text-sm py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                </div>
                <div class="col-12 col-sm-6">
                    <label class="d-block text-xs fw-semibold text-uppercase tracking-wider mb-1" style="color: #541B29;">City</label>
                    <input type="text" name="city" value="{{ old('city', 'Lahore') }}" 
                           placeholder="Lahore / Karachi"
                           class="form-control text-sm py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
                </div>
            </div>

            <div>
                <label class="d-block text-xs fw-semibold text-uppercase tracking-wider mb-1" style="color: #541B29;">Password *</label>
                <input type="password" name="password" required
                       placeholder="Minimum 8 characters"
                       class="form-control text-sm py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
            </div>

            <div>
                <label class="d-block text-xs fw-semibold text-uppercase tracking-wider mb-1" style="color: #541B29;">Confirm Password *</label>
                <input type="password" name="password_confirmation" required
                       placeholder="Re-enter password"
                       class="form-control text-sm py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
            </div>

            <button type="submit" class="w-100 btn-gold py-3 text-xs font-bold text-uppercase tracking-widest rounded-3 shadow-sm mt-2" style="border-radius: 8px;">
                Create Account
            </button>
        </form>

        <div class="text-center pt-4 mt-4 text-sm" style="border-top: 1px solid #E8E0DA; color: #6B605B;">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}" class="fw-semibold ms-1 text-uppercase text-decoration-none" style="font-size: 12px; letter-spacing: 0.05em; color: #541B29;">
                Sign In
            </a>
        </div>
    </div>
</div>
@endsection
