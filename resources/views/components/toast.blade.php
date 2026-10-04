@props([
    'type' => 'success', // 'success', 'error', 'info', 'warning'
    'message' => ''
])

<div class="luxury-toast d-flex align-items-center gap-2 bg-theme-card border border-gold-60 text-ivory px-3 py-2 rounded shadow-lg">
    @if($type === 'success')
        <i class="fas fa-check-circle text-success"></i>
    @elseif($type === 'error')
        <i class="fas fa-exclamation-circle text-danger"></i>
    @elseif($type === 'warning')
        <i class="fas fa-exclamation-triangle text-warning"></i>
    @else
        <i class="fas fa-info-circle text-gold"></i>
    @endif
    <span class="text-xs tracking-wider">{{ $message ?: $slot }}</span>
</div>
