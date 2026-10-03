@extends('layouts.app')

@section('title', 'Recover Access Key — Perfumes Collection')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-16 bg-[#080304]">
    <div class="max-w-md w-full bg-[#0d0608] border border-brand-gold/30 p-8 md:p-10 rounded-sm shadow-2xl relative">
        <div class="text-center mb-8">
            <span class="text-[10px] uppercase tracking-[0.3em] text-brand-gold px-3 py-1 bg-brand-maroon/20 border border-brand-gold/30 rounded-full inline-block mb-3">
                Security Concierge
            </span>
            <h1 class="font-serif text-2xl md:text-3xl text-brand-gold font-light">Recover Access</h1>
            <p class="text-xs text-brand-ivory/60 mt-1">Enter your registered email and we will dispatch password reset instructions.</p>
        </div>

        @if(session('status'))
            <div class="mb-6 p-3 bg-green-950/60 border border-green-500/40 text-green-300 text-xs rounded">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-3 bg-red-950/60 border border-red-500/40 text-red-300 text-xs rounded">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Registered Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="patron@domain.com"
                       class="w-full bg-black/60 border border-brand-gold/30 px-4 py-3 text-sm text-brand-ivory placeholder-brand-ivory/30 focus:border-brand-gold focus:outline-none rounded-sm">
            </div>

            <button type="submit" class="w-full py-4 bg-gradient-to-r from-brand-gold via-brand-gold-light to-brand-gold text-black font-semibold text-xs uppercase tracking-[0.25em] hover:brightness-110 transition-all rounded-sm shadow-lg mt-2">
                Send Recovery Key
            </button>
        </form>

        <div class="text-center pt-6 mt-6 border-t border-white/10 text-xs text-brand-ivory/60">
            <a href="{{ route('login') }}" class="text-brand-gold font-semibold hover:underline uppercase tracking-wider">
                &larr; Back to Patron Sign In
            </a>
        </div>
    </div>
</div>
@endsection
