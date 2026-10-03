@props([
    'tabs' => [] // ['id' => 'Label']
])

<div class="luxury-tabs-wrapper" x-data="{ activeTab: '{{ array_key_first($tabs) }}' }">
    <div class="tabs-header flex border-b border-[#C9A24B]/30 mb-6 overflow-x-auto no-scrollbar">
        @foreach($tabs as $key => $label)
            <button 
                type="button"
                @click="activeTab = '{{ $key }}'"
                :class="activeTab === '{{ $key }}' ? 'border-[#C9A24B] text-[#C9A24B] bg-[#C9A24B]/10 font-semibold' : 'border-transparent text-[#F5EFE6]/60 hover:text-[#F5EFE6] hover:border-stone-600'"
                class="px-6 py-3 text-xs uppercase tracking-[0.2em] border-b-2 transition-all duration-300 whitespace-nowrap"
            >
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="tabs-content text-sm text-[#F5EFE6]/80 leading-relaxed">
        {{ $slot }}
    </div>
</div>
