@props([
    'id' => 'luxuryModal',
    'title' => null,
    'subtitle' => null,
    'maxWidth' => 'max-w-2xl'
])

<div id="{{ $id }}" class="luxury-modal-overlay position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center p-3 opacity-0"
    style="z-index: 1050; pointer-events: none; background: rgba(0,0,0,0.85); backdrop-filter: blur(8px);">
    <div class="luxury-modal-content position-relative w-100 bg-theme-dark border border-gold-40 rounded p-4 p-sm-5 shadow-lg"
        style="max-width: 42rem;">
        <button type="button" class="modal-close-btn position-absolute top-0 end-0 m-3 border-0 bg-transparent text-ivory opacity-75 fs-3" onclick="document.getElementById('{{ $id }}').classList.remove('active', 'opacity-100')">&times;</button>
        
        @if($subtitle)
            <span class="d-block text-gold mb-1 fw-semibold text-uppercase tracking-luxury" style="font-size: 10px;">{{ $subtitle }}</span>
        @endif
        
        @if($title)
            <h3 class="font-serif fs-4 text-ivory mb-3">{{ $title }}</h3>
        @endif

        <div class="modal-body text-ivory opacity-75 text-sm p-0">
            {{ $slot }}
        </div>
    </div>
</div>
