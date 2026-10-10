@extends('layouts.app')

@section('title', 'Transferring to ' . $gatewayName . ' — Perfumes Collection')

@section('content')
<div class="d-flex align-items-center justify-content-center px-3 py-5 min-vh-100" style="background-color: #F7F3EE;">
    <div class="w-100 text-center p-4 p-md-5 rounded-4 shadow-sm" style="max-width: 448px; background-color: #FFFFFF; border: 1px solid #E8E0DA;">
        <div class="position-relative mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
            <div class="spinner-border" style="width: 64px; height: 64px; color: #541B29;" role="status"></div>
            <i class="fas fa-lock position-absolute fs-5" style="color: #541B29;"></i>
        </div>

        <h1 class="font-serif fs-4 mb-2" style="color: #211D1E;">Connecting to {{ $gatewayName }}</h1>
        <p class="text-xs text-uppercase tracking-wider mb-4" style="color: #786C67;">Securing 256-Bit Encrypted Payment Channel</p>

        <div class="p-3 rounded text-start mb-4 text-xs font-mono d-flex flex-column gap-1" style="background-color: #FAF7F2; border: 1px solid #E8E0DA;">
            <div class="d-flex justify-content-between">
                <span style="color: #6B605B;">Order Dossier:</span>
                <span class="fw-semibold" style="color: #541B29;">{{ $order->order_number }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span style="color: #6B605B;">Total Amount:</span>
                <span class="fw-bold" style="color: #211D1E;">Rs. {{ number_format($order->total_amount, 0) }}</span>
            </div>
        </div>

        <p class="text-xs mb-4" style="color: #6B605B;">
            You will be seamlessly redirected in a moment. Please do not refresh or close this browser window.
        </p>

        <form id="payment-gateway-form" action="{{ $endpoint }}" method="POST">
            @foreach($fields as $name => $value)
                <input type="hidden" name="{{ $name }}" value="{{ $value }}">
            @endforeach
            <button type="submit" class="w-100 btn py-3 fw-semibold text-xs text-uppercase tracking-widest text-white shadow-sm" style="background-color: #541B29; border-radius: 8px;">
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
