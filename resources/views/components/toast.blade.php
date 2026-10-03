@props([
    'type' => 'success', // 'success', 'error', 'info', 'warning'
    'message' => ''
])

<div class="luxury-toast flex items-center space-x-3 bg-[#0E0507] border border-[#C9A24B]/60 text-[#F5EFE6] px-4 py-3 rounded shadow-2xl transition-all duration-300 transform translate-y-2 opacity-0 animate-fade-in">
    @if($type === 'success')
        <i class="fas fa-check-circle text-emerald-400"></i>
    @elseif($type === 'error')
        <i class="fas fa-exclamation-circle text-red-400"></i>
    @elseif($type === 'warning')
        <i class="fas fa-exclamation-triangle text-amber-400"></i>
    @else
        <i class="fas fa-info-circle text-[#C9A24B]"></i>
    @endif
    <span class="text-xs tracking-wider">{{ $message ?: $slot }}</span>
</div>
