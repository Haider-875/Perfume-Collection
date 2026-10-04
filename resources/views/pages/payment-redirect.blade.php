@extends('layouts.app')

@section('title', 'Transferring to ' . $gatewayName . ' — Perfumes Collection')

@section('content')
<div class="d-flex align-items-center justify-content-center px-3 py-5" style="min-height: 70vh;">
    <div class="w-100 text-center bg-wine-card border border-gold-30 p-4 p-md-5 shadow-2xl rounded-3" style="max-width: 448px; backdrop-filter: blur(12px);">
        <div class="position-relative mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
            <div class="spinner-border text-gold" style="width: 64px; height: 64px;" role="status"></div>
            <i class="fas fa-lock position-absolute text-gold fs-5"></i>
        </div>

        <h1 class="font-serif fs-4 text-gold-soft mb-2">Connecting to {{ $gatewayName }}</h1>
        <p class="text-xs text-uppercase tracking-wider text-muted-parchment mb-4">Securing 256-Bit Encrypted Payment Channel</p>

        <div class="p-3 rounded text-start mb-4 text-xs font-mono d-flex flex-column gap-1 bg-wine-dark border border-gold-20">
            <div class="d-flex justify-content-between">
                <span class="text-muted-parchment">Order Dossier:</span>
                <span class="text-gold fw-semibold">{{ $order->order_number }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted-parchment">Total Amount:</span>
                <span class="text-light-parchment fw-semibold">Rs. {{ number_format($order->total_amount, 0) }}</span>
            </div>
        </div>

        <p class="text-xs text-muted-parchment mb-4">
            You will be seamlessly redirected in a moment. Please do not refresh or close this browser window.
        </p>

        <form id="payment-gateway-form" action="{{ $endpoint }}" method="POST">
            @foreach($fields as $name => $value)
                <input type="hidden" name="{{ $name }}" value="{{ $value }}">
            @endforeach
            <button type="submit" class="w-100 btn-gold py-3 fw-semibold text-xs text-uppercase tracking-widest">
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
