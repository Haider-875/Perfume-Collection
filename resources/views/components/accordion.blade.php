@props(['items' => []])

<div class="luxury-accordion-wrapper" x-data="{ activeAccordion: null }">
    @foreach($items as $index => $item)
        <div style="border-bottom: 1px solid var(--border-subtle); padding: 18px 0;">
            <button type="button" 
                    @click="activeAccordion = activeAccordion === {{ $index }} ? null : {{ $index }}"
                    style="width: 100%; background: transparent; border: none; text-align: left; display: flex; justify-content: space-between; align-items: center; cursor: pointer; color: var(--text-ivory); font-family: var(--font-heading); font-size: 1.05rem;">
                <span>{{ $item['title'] }}</span>
                <i class="fas fa-chevron-down text-gold" :style="activeAccordion === {{ $index }} ? 'transform: rotate(180deg); transition: transform 0.3s ease;' : 'transition: transform 0.3s ease;'"></i>
            </button>
            <div x-show="activeAccordion === {{ $index }}" x-collapse style="padding-top: 14px; font-family: var(--font-serif); font-size: 1.05rem; color: var(--text-sub); line-height: 1.7;">
                {!! $item['content'] !!}
            </div>
        </div>
    @endforeach
</div>
