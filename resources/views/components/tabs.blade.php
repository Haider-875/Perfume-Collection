@props([
    'tabs' => [] // ['id' => 'Label']
])

<div class="luxury-tabs-wrapper" x-data="{ activeTab: '{{ array_key_first($tabs) }}' }">
    <div class="tabs-header d-flex border-bottom border-gold-30 mb-4 overflow-x-auto">
        @foreach($tabs as $key => $label)
            <button 
                type="button"
                @click="activeTab = '{{ $key }}'"
                :class="activeTab === '{{ $key }}' ? 'border-gold text-gold bg-gold-subtle fw-semibold' : 'border-transparent text-muted-luxury'"
                class="px-4 py-2 text-xs text-uppercase tracking-wider border-0 border-bottom border-2 bg-transparent text-nowrap transition-smooth"
            >
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="tabs-content text-sm text-ivory opacity-75 lh-base">
        {{ $slot }}
    </div>
</div>
