@props([
    'id' => 'luxuryModal',
    'title' => null,
    'subtitle' => null,
    'maxWidth' => 'max-w-2xl'
])

<div id="{{ $id }}" class="luxury-modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div class="luxury-modal-content relative w-full {{ $maxWidth }} bg-[#0D0507] border border-[#C9A24B]/40 rounded-lg p-6 sm:p-8 shadow-2xl transform scale-95 transition-all duration-300">
        <button type="button" class="modal-close-btn absolute top-4 right-4 text-[#F5EFE6]/60 hover:text-[#C9A24B] text-2xl transition" onclick="document.getElementById('{{ $id }}').classList.remove('active', 'opacity-100', 'pointer-events-auto')">&times;</button>
        
        @if($subtitle)
            <span class="block text-[10px] uppercase tracking-[0.25em] text-[#C9A24B] mb-1 font-semibold">{{ $subtitle }}</span>
        @endif
        
        @if($title)
            <h3 class="font-serif text-2xl text-[#F5EFE6] mb-4">{{ $title }}</h3>
        @endif

        <div class="modal-body text-[#F5EFE6]/80 text-sm">
            {{ $slot }}
        </div>
    </div>
</div>
