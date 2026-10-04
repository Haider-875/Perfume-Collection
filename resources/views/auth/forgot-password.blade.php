@extends('layouts.app')

@section('title', 'Recover Access Key — Perfumes Collection')

@section('content')
<div class="d-flex align-items-center justify-content-center px-3 py-5" style="min-height: 75vh; background-color: #080304;">
    <div class="w-100 bg-wine-card border border-gold-30 p-4 p-md-5 rounded-3 shadow-2xl position-relative" style="max-width: 448px;">
        <div class="text-center mb-4">
            <span class="text-gold fw-semibold px-3 py-1 bg-wine-accent border border-gold-30 rounded-pill d-inline-block mb-2 text-uppercase" style="font-size: 10px; letter-spacing: 0.3em;">
                Security Concierge
            </span>
            <h1 class="font-serif fs-3 text-gold-soft fw-light mb-1">Recover Access</h1>
            <p class="text-xs text-muted-parchment mb-0">Enter your registered email and we will dispatch password reset instructions.</p>
        </div>

        @if(session('status'))
            <div class="alert alert-success bg-wine-dark border border-success-subtle text-success-emphasis rounded-3 p-3 mb-4 text-xs">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger bg-wine-accent border border-danger-subtle text-danger-emphasis rounded-3 p-3 mb-4 text-xs d-flex flex-column gap-1">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="d-flex flex-column gap-3 text-xs">
            @csrf
            <div>
                <label class="d-block text-uppercase text-gold mb-1 fw-medium" style="letter-spacing: 0.15em;">Registered Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="patron@domain.com"
                       class="form-control form-control-luxury text-sm py-2 px-3">
            </div>

            <button type="submit" class="w-100 btn-gold py-3 text-xs fw-semibold text-uppercase tracking-widest rounded-3 shadow mt-2">
                Send Recovery Key
            </button>
        </form>

        <div class="text-center pt-4 mt-4 border-top border-gold-20 text-xs text-muted-parchment">
            <a href="{{ route('login') }}" class="text-gold fw-semibold text-gold-hover text-decoration-none text-uppercase tracking-wider">
                &larr; Back to Patron Sign In
            </a>
        </div>
    </div>
</div>
@endsection
