@extends('layouts.app')

@section('title', 'Sign In — Perfumes Collection')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-16 bg-[#050203] luxury-wine-bg">
    <div class="max-w-md w-full bg-gradient-to-b from-[#18050b] via-[#100306] to-[#070103] border border-[#d6aa62]/35 p-8 md:p-10 rounded-2xl shadow-2xl relative">
        <div class="text-center mb-8">
            <span class="text-[11px] uppercase tracking-[0.25em] text-[#f0d59d] font-semibold px-3 py-1 bg-[#3b0711]/70 border border-[#d6aa62]/40 rounded-full inline-block mb-3">
                Customer Account
            </span>
            <h1 class="font-serif text-3xl md:text-4xl text-[#f5efe7] font-normal tracking-tight">Welcome Back</h1>
            <p class="text-sm text-[#b8a9a2] mt-2 font-light">Sign in to track orders, manage addresses & enjoy fast checkout.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 text-sm rounded-lg flex items-center gap-2">
                <i class="fas fa-check-circle text-emerald-400"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-950/60 border border-red-500/40 text-red-300 text-sm rounded-lg space-y-1">
                @foreach($errors->all() as $error)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-circle-exclamation text-red-400 text-xs"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5 text-sm">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[#d6aa62] mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="yourname@domain.com"
                       class="w-full bg-[#0c0305] border border-[#d6aa62]/30 px-4 py-3 text-sm text-[#f5efe7] placeholder-[#8e7c75] focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62]/40 focus:outline-none rounded-lg transition">
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="text-xs font-semibold uppercase tracking-wider text-[#d6aa62]">Password</label>
                    <a href="{{ route('password.request') }}" class="text-xs text-[#f0d59d] hover:text-[#ffd987] font-medium transition">Forgot password?</a>
                </div>
                <input type="password" name="password" required
                       placeholder="••••••••"
                       class="w-full bg-[#0c0305] border border-[#d6aa62]/30 px-4 py-3 text-sm text-[#f5efe7] placeholder-[#8e7c75] focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62]/40 focus:outline-none rounded-lg transition">
            </div>

            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" id="remember" name="remember" class="accent-[#d6aa62] w-4 h-4 rounded bg-[#0c0305] border-[#d6aa62]/30">
                <label for="remember" class="text-xs text-[#b8a9a2] cursor-pointer select-none">Remember my login</label>
            </div>

            <button type="submit" class="w-full btn-gold py-3.5 text-xs font-bold uppercase tracking-widest rounded-lg shadow-xl mt-2">
                Sign In
            </button>
        </form>

        <div class="text-center pt-6 mt-6 border-t border-[#d6aa62]/20 text-sm text-[#b8a9a2]">
            <span>Don't have an account?</span>
            <a href="{{ route('register') }}" class="text-[#f0d59d] font-semibold hover:text-[#ffd987] ml-1 uppercase tracking-wider text-xs">
                Create Account
            </a>
        </div>
    </div>
</div>
@endsection
