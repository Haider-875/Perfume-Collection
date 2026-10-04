@extends('layouts.app')

@section('title', 'Create Account — Perfumes Collection')

@section('content')
<div class="d-flex align-items-center justify-content-center px-3 py-5 bg-wine-ticker" style="min-height: 75vh; background-color: #050203;">
    <div class="w-100 bg-gradient-wine-ticker border border-gold-35 p-4 p-md-5 rounded-4 shadow-2xl position-relative" style="max-width: 448px;">
        <div class="text-center mb-4">
            <span class="text-gold fw-semibold px-3 py-1 bg-wine-accent border border-gold-40 rounded-pill d-inline-block mb-2 text-uppercase" style="font-size: 11px; letter-spacing: 0.25em;">
                New Patron
            </span>
            <h1 class="font-serif fs-2 text-light-parchment fw-normal tracking-tight mb-1">Create An Account</h1>
            <p class="text-sm text-muted-parchment fw-light mb-0">Join Perfumes Collection to track your orders and enjoy swift checkout.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger bg-wine-accent border border-danger-subtle text-danger-emphasis rounded-3 p-3 mb-4 d-flex flex-column gap-1">
                @foreach($errors->all() as $error)
                    <div class="d-flex align-items-center gap-2 text-xs">
                        <i class="fas fa-circle-exclamation text-danger"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="d-flex flex-column gap-3 text-sm">
            @csrf
            <div>
                <label class="d-block text-xs fw-semibold text-uppercase tracking-wider text-gold mb-1">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="e.g. Daniyal Khan"
                       class="form-control form-control-luxury text-sm py-2 px-3">
            </div>

            <div>
                <label class="d-block text-xs fw-semibold text-uppercase tracking-wider text-gold mb-1">Email Address *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       placeholder="name@domain.com"
                       class="form-control form-control-luxury text-sm py-2 px-3">
            </div>

            <div class="row g-2">
                <div class="col-12 col-sm-6">
                    <label class="d-block text-xs fw-semibold text-uppercase tracking-wider text-gold mb-1">Phone Number</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" 
                           placeholder="0300 1234567"
                           class="form-control form-control-luxury text-sm py-2 px-3">
                </div>
                <div class="col-12 col-sm-6">
                    <label class="d-block text-xs fw-semibold text-uppercase tracking-wider text-gold mb-1">City</label>
                    <input type="text" name="city" value="{{ old('city', 'Lahore') }}" 
                           placeholder="Lahore / Karachi"
                           class="form-control form-control-luxury text-sm py-2 px-3">
                </div>
            </div>

            <div>
                <label class="d-block text-xs fw-semibold text-uppercase tracking-wider text-gold mb-1">Password *</label>
                <input type="password" name="password" required
                       placeholder="Minimum 8 characters"
                       class="form-control form-control-luxury text-sm py-2 px-3">
            </div>

            <div>
                <label class="d-block text-xs fw-semibold text-uppercase tracking-wider text-gold mb-1">Confirm Password *</label>
                <input type="password" name="password_confirmation" required
                       placeholder="Re-enter password"
                       class="form-control form-control-luxury text-sm py-2 px-3">
            </div>

            <button type="submit" class="w-100 btn-gold py-3 text-xs font-bold text-uppercase tracking-widest rounded-3 shadow mt-2">
                Create Account
            </button>
        </form>

        <div class="text-center pt-4 mt-4 border-top border-gold-20 text-sm text-muted-parchment">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}" class="text-gold-soft fw-semibold text-gold-hover ms-1 text-uppercase text-decoration-none" style="font-size: 12px; letter-spacing: 0.05em;">
                Sign In
            </a>
        </div>
    </div>
</div>
@endsection
