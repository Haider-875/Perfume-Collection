@extends('layouts.app')

@section('title', 'Set New Access Key — Perfumes Collection')

@section('content')
<div class="d-flex align-items-center justify-content-center px-3 py-5" style="min-height: 75vh; background-color: #080304;">
    <div class="w-100 bg-wine-card border border-gold-30 p-4 p-md-5 rounded-3 shadow-2xl position-relative" style="max-width: 448px;">
        <div class="text-center mb-4">
            <span class="text-gold fw-semibold px-3 py-1 bg-wine-accent border border-gold-30 rounded-pill d-inline-block mb-2 text-uppercase" style="font-size: 10px; letter-spacing: 0.3em;">
                Security Concierge
            </span>
            <h1 class="font-serif fs-3 text-gold-soft fw-light mb-1">Set New Password</h1>
            <p class="text-xs text-muted-parchment mb-0">Please enter your new password below.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger bg-wine-accent border border-danger-subtle text-danger-emphasis rounded-3 p-3 mb-4 text-xs d-flex flex-column gap-1">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="d-flex flex-column gap-3 text-xs">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="d-block text-uppercase text-gold mb-1 fw-medium" style="letter-spacing: 0.15em;">Email Address</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus
                       placeholder="patron@domain.com"
                       class="form-control form-control-luxury text-sm py-2 px-3">
            </div>

            <div>
                <label class="d-block text-uppercase text-gold mb-1 fw-medium" style="letter-spacing: 0.15em;">New Password</label>
                <input type="password" name="password" required
                       placeholder="••••••••"
                       class="form-control form-control-luxury text-sm py-2 px-3">
            </div>

            <div>
                <label class="d-block text-uppercase text-gold mb-1 fw-medium" style="letter-spacing: 0.15em;">Confirm New Password</label>
                <input type="password" name="password_confirmation" required
                       placeholder="••••••••"
                       class="form-control form-control-luxury text-sm py-2 px-3">
            </div>

            <button type="submit" class="w-100 btn-gold py-3 text-xs fw-semibold text-uppercase tracking-widest rounded-3 shadow mt-2">
                Update Password Key
            </button>
        </form>
    </div>
</div>
@endsection
