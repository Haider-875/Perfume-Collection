@extends('layouts.app')

@section('title', 'Transferring to ' . $gatewayName . ' — Perfumes Collection')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-20">
    <div class="max-w-md w-full text-center bg-[#0d0608]/90 border border-brand-gold/30 p-8 md:p-12 shadow-2xl backdrop-blur-md rounded-sm">
        <div class="relative w-20 h-20 mx-auto mb-6 flex items-center justify-center">
            <div class="absolute inset-0 rounded-full border-2 border-brand-gold/20 animate-ping"></div>
            <div class="w-16 h-16 rounded-full border-2 border-t-brand-gold border-r-brand-gold/50 border-b-transparent border-l-transparent animate-spin"></div>
            <svg class="w-6 h-6 text-brand-gold absolute" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>

        <h1 class="font-serif text-2xl md:text-3xl text-brand-gold mb-2">Connecting to {{ $gatewayName }}</h1>
        <p class="text-xs uppercase tracking-[0.2em] text-brand-ivory/60 mb-6">Securing 256-Bit Encrypted Payment Channel</p>

        <div class="bg-black/40 border border-white/5 p-4 rounded text-left mb-6 text-xs text-brand-ivory/80 space-y-1 font-mono">
            <div class="flex justify-between">
                <span class="text-brand-ivory/40">Order Dossier:</span>
                <span class="text-brand-gold font-semibold">{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-brand-ivory/40">Total Amount:</span>
                <span class="text-brand-ivory font-semibold">Rs. {{ number_format($order->total_amount, 0) }}</span>
            </div>
        </div>

        <p class="text-xs text-brand-ivory/50 mb-6">
            You will be seamlessly redirected in a moment. Please do not refresh or close this browser window.
        </p>

        <form id="payment-gateway-form" action="{{ $endpoint }}" method="POST">
            @foreach($fields as $name => $value)
                <input type="hidden" name="{{ $name }}" value="{{ $value }}">
            @endforeach
            <button type="submit" class="w-full py-3 bg-gradient-to-r from-brand-gold to-brand-gold-light text-black font-semibold text-xs uppercase tracking-[0.2em] hover:brightness-110 transition-all">
                Click here if not redirected automatically
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var form = document.getElementById('payment-gateway-form');
            if (form) form.submit();
        }, 1200);
    });
</script>
@endsection
