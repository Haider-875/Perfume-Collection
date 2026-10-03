@extends('layouts.app')

@section('title', 'Create Account — Perfumes Collection')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-16 bg-[#050203] luxury-wine-bg">
    <div class="max-w-md w-full bg-gradient-to-b from-[#18050b] via-[#100306] to-[#070103] border border-[#d6aa62]/35 p-8 md:p-10 rounded-2xl shadow-2xl relative">
        <div class="text-center mb-8">
            <span class="text-[11px] uppercase tracking-[0.25em] text-[#f0d59d] font-semibold px-3 py-1 bg-[#3b0711]/70 border border-[#d6aa62]/40 rounded-full inline-block mb-3">
                New Patron
            </span>
            <h1 class="font-serif text-3xl md:text-4xl text-[#f5efe7] font-normal tracking-tight">Create An Account</h1>
            <p class="text-sm text-[#b8a9a2] mt-2 font-light">Join Perfumes Collection to track your orders and enjoy swift checkout.</p>
        </div>

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

        <form action="{{ route('register') }}" method="POST" class="space-y-4 text-sm">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[#d6aa62] mb-1.5">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="e.g. Daniyal Khan"
                       class="w-full bg-[#0c0305] border border-[#d6aa62]/30 px-4 py-2.5 text-sm text-[#f5efe7] placeholder-[#8e7c75] focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62]/40 focus:outline-none rounded-lg transition">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[#d6aa62] mb-1.5">Email Address *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       placeholder="name@domain.com"
                       class="w-full bg-[#0c0305] border border-[#d6aa62]/30 px-4 py-2.5 text-sm text-[#f5efe7] placeholder-[#8e7c75] focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62]/40 focus:outline-none rounded-lg transition">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[#d6aa62] mb-1.5">Phone Number</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" 
                           placeholder="0300 1234567"
                           class="w-full bg-[#0c0305] border border-[#d6aa62]/30 px-4 py-2.5 text-sm text-[#f5efe7] placeholder-[#8e7c75] focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62]/40 focus:outline-none rounded-lg transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[#d6aa62] mb-1.5">City</label>
                    <input type="text" name="city" value="{{ old('city', 'Lahore') }}" 
                           placeholder="Lahore / Karachi"
                           class="w-full bg-[#0c0305] border border-[#d6aa62]/30 px-4 py-2.5 text-sm text-[#f5efe7] placeholder-[#8e7c75] focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62]/40 focus:outline-none rounded-lg transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[#d6aa62] mb-1.5">Password *</label>
                <input type="password" name="password" required
                       placeholder="Minimum 8 characters"
                       class="w-full bg-[#0c0305] border border-[#d6aa62]/30 px-4 py-2.5 text-sm text-[#f5efe7] placeholder-[#8e7c75] focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62]/40 focus:outline-none rounded-lg transition">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[#d6aa62] mb-1.5">Confirm Password *</label>
                <input type="password" name="password_confirmation" required
                       placeholder="Re-enter password"
                       class="w-full bg-[#0c0305] border border-[#d6aa62]/30 px-4 py-2.5 text-sm text-[#f5efe7] placeholder-[#8e7c75] focus:border-[#d6aa62] focus:ring-1 focus:ring-[#d6aa62]/40 focus:outline-none rounded-lg transition">
            </div>

            <button type="submit" class="w-full btn-gold py-3.5 text-xs font-bold uppercase tracking-widest rounded-lg shadow-xl mt-2">
                Create Account
            </button>
        </form>

        <div class="text-center pt-6 mt-6 border-t border-[#d6aa62]/20 text-sm text-[#b8a9a2]">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}" class="text-[#f0d59d] font-semibold hover:text-[#ffd987] ml-1 uppercase tracking-wider text-xs">
                Sign In
            </a>
        </div>
    </div>
</div>
@endsection
