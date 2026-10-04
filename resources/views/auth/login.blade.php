@extends('layouts.app')

@section('title', 'Sign In — Perfumes Collection')

@section('content')
<div class="d-flex align-items-center justify-content-center px-3 py-5 bg-wine-ticker" style="min-height: 75vh; background-color: #050203;">
    <div class="w-100 bg-gradient-wine-ticker border border-gold-35 p-4 p-md-5 rounded-4 shadow-2xl position-relative" style="max-width: 448px;">
        <div class="text-center mb-4">
            <span class="text-gold fw-semibold px-3 py-1 bg-wine-accent border border-gold-40 rounded-pill d-inline-block mb-2 text-uppercase" style="font-size: 11px; letter-spacing: 0.25em;">
                Customer Account
            </span>
            <h1 class="font-serif fs-2 text-light-parchment fw-normal tracking-tight mb-1">Welcome Back</h1>
            <p class="text-sm text-muted-parchment fw-light mb-0">Sign in to track orders, manage addresses & enjoy fast checkout.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-wine-dark border border-success-subtle text-success-emphasis rounded-3 p-3 mb-4 d-flex align-items-center gap-2">
                <i class="fas fa-check-circle text-success"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

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

        <form action="{{ route('login') }}" method="POST" class="d-flex flex-column gap-3 text-sm">
            @csrf
            <div>
                <label class="d-block text-xs fw-semibold text-uppercase tracking-wider text-gold mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="yourname@domain.com"
                       class="form-control form-control-luxury text-sm py-2 px-3">
            </div>

            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="text-xs fw-semibold text-uppercase tracking-wider text-gold mb-0">Password</label>
                    <a href="{{ route('password.request') }}" class="text-xs text-gold-soft text-gold-hover fw-medium text-decoration-none">Forgot password?</a>
                </div>
                <input type="password" name="password" required
                       placeholder="••••••••"
                       class="form-control form-control-luxury text-sm py-2 px-3">
            </div>

            <div class="d-flex align-items-center gap-2 pt-1">
                <input type="checkbox" id="remember" name="remember" class="form-check-input bg-transparent border-gold-40 m-0">
                <label for="remember" class="text-xs text-muted-parchment cursor-pointer user-select-none mb-0">Remember my login</label>
            </div>

            <button type="submit" class="w-100 btn-gold py-3 text-xs fw-bold text-uppercase tracking-widest rounded-3 shadow mt-2">
                Sign In
            </button>
        </form>

        <div class="text-center pt-4 mt-4 border-top border-gold-20 text-sm text-muted-parchment">
            <span>Don't have an account?</span>
            <a href="{{ route('register') }}" class="text-gold-soft fw-semibold text-gold-hover ms-1 text-uppercase text-decoration-none" style="font-size: 12px; letter-spacing: 0.05em;">
                Create Account
            </a>
        </div>
    </div>
</div>
@endsection
