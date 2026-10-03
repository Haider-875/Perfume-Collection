@props([
    'id' => 'cartDrawer',
    'title' => 'Your Private Vault',
    'width' => 'max-w-md'
])

<div id="{{ $id }}" class="cart-drawer fixed inset-y-0 right-0 z-50 w-full {{ $width }} bg-[#0B0406] border-l border-[#C9A24B]/30 shadow-2xl flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out">
    <div class="drawer-header p-5 border-b border-[#C9A24B]/20 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <i class="fas fa-shopping-bag text-[#C9A24B]"></i>
            <h3 class="font-serif text-lg tracking-wider text-[#F5EFE6]">{{ $title }}</h3>
        </div>
        <button type="button" class="drawer-close text-[#F5EFE6]/60 hover:text-[#C9A24B] text-xl transition" onclick="document.getElementById('{{ $id }}').classList.remove('open')">&times;</button>
    </div>

    <div class="drawer-body flex-1 overflow-y-auto p-5 space-y-4">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="drawer-footer p-5 border-t border-[#C9A24B]/20 bg-[#080304]">
            {{ $footer }}
        </div>
    @endif
</div>
