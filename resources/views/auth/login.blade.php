@extends('layouts.app')

@section('title', 'Sign In — Perfumes Collection')

@section('content')
<div class="d-flex align-items-center justify-content-center px-3 py-5" style="min-height: 75vh; background-color: #F7F3EE;">
    <div class="w-100 p-4 p-md-5 rounded-4 shadow-sm position-relative" style="max-width: 448px; background-color: #FFFFFF; border: 1px solid #E8E0DA;">
        <div class="text-center mb-4">
            <span class="fw-semibold px-3 py-1 rounded-pill d-inline-block mb-2 text-uppercase" style="font-size: 11px; letter-spacing: 0.25em; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                Customer Account
            </span>
            <h1 class="font-serif fs-2 fw-normal tracking-tight mb-1" style="color: #211D1E;">Welcome Back</h1>
            <p class="text-sm fw-light mb-0" style="color: #6B605B;">Sign in to track orders, manage addresses & enjoy fast checkout.</p>
        </div>

        @if(session('success'))
            <div class="alert rounded-3 p-3 mb-4 d-flex align-items-center gap-2" style="background-color: #DEF7EC; border: 1px solid #31C48D; color: #0E9F6E;">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

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

        <form action="{{ route('login') }}" method="POST" class="d-flex flex-column gap-3 text-sm">
            @csrf
            <div>
                <label class="d-block text-xs fw-semibold text-uppercase tracking-wider mb-1" style="color: #541B29;">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="yourname@domain.com"
                       class="form-control text-sm py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
            </div>

            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="text-xs fw-semibold text-uppercase tracking-wider mb-0" style="color: #541B29;">Password</label>
                    <a href="{{ route('password.request') }}" class="text-xs fw-medium text-decoration-none" style="color: #541B29;">Forgot password?</a>
                </div>
                <input type="password" name="password" required
                       placeholder="••••••••"
                       class="form-control text-sm py-2 px-3" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #211D1E; border-radius: 8px;">
            </div>

            <div class="d-flex align-items-center gap-2 pt-1">
                <input type="checkbox" id="remember" name="remember" class="form-check-input m-0" style="border-color: #E8E0DA;">
                <label for="remember" class="text-xs cursor-pointer user-select-none mb-0" style="color: #6B605B;">Remember my login</label>
            </div>

            <button type="submit" class="w-100 btn-gold py-3 text-xs fw-bold text-uppercase tracking-widest rounded-3 shadow-sm mt-2" style="border-radius: 8px;">
                Sign In
            </button>
        </form>

        <div class="text-center pt-4 mt-4 text-sm" style="border-top: 1px solid #E8E0DA; color: #6B605B;">
            <span>Don't have an account?</span>
            <a href="{{ route('register') }}" class="fw-semibold ms-1 text-uppercase text-decoration-none" style="font-size: 12px; letter-spacing: 0.05em; color: #541B29;">
                Create Account
            </a>
        </div>
    </div>
</div>
@endsection
