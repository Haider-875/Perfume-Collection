@props([
    'id' => 'cartDrawer',
    'title' => 'Your Private Vault',
    'width' => 'max-w-md'
])

<div id="{{ $id }}" class="cart-drawer position-fixed top-0 end-0 h-100 bg-theme-dark border-start border-gold-30 shadow-lg d-flex flex-column" style="z-index: 1060; width: 100%; max-width: 440px;">
    <div class="drawer-header p-4 border-bottom border-gold-20 bg-theme-secondary d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-shopping-bag text-gold"></i>
            <h3 class="font-serif fs-5 tracking-wider text-ivory mb-0">{{ $title }}</h3>
        </div>
        <button type="button" class="drawer-close border-0 bg-transparent text-muted-luxury fs-3 p-0" onclick="document.getElementById('{{ $id }}').classList.remove('open', 'active')">&times;</button>
    </div>

    <div class="drawer-body flex-grow-1 overflow-y-auto p-4 vstack gap-3">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="drawer-footer p-4 border-top border-gold-20 bg-wine-dark">
            {{ $footer }}
        </div>
    @endif
</div>
