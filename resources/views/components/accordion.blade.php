@props(['title' => null, 'open' => false, 'items' => []])

@if($title)
    <div x-data="{ expanded: {{ $open ? 'true' : 'false' }} }" class="bg-theme-card border border-gold-25 rounded-4 overflow-hidden shadow-sm mb-3">
        <button type="button" 
                @click="expanded = !expanded"
                class="w-100 bg-transparent border-0 text-start p-3 p-md-4 d-flex justify-content-between align-items-center cursor-pointer text-ivory font-serif fs-5 fw-normal">
            <span>{{ $title }}</span>
            <i class="fas fa-chevron-down text-gold text-xs transition-smooth ms-3 flex-shrink-0" :class="{ 'rotate-180': expanded }"></i>
        </button>
        <div x-show="expanded" x-collapse class="px-3 pb-4 px-md-4 pb-md-4 text-sm text-muted-luxury fw-light lh-base border-top border-gold-15 pt-3">
            {{ $slot }}
        </div>
    </div>
@else
    <div class="luxury-accordion-wrapper vstack gap-3" x-data="{ activeAccordion: null }">
        @foreach($items as $index => $item)
            <div class="bg-theme-card border border-gold-25 rounded-4 overflow-hidden shadow-sm">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === {{ $index }} ? null : {{ $index }}"
                        class="w-100 bg-transparent border-0 text-start p-3 p-md-4 d-flex justify-content-between align-items-center cursor-pointer text-ivory font-serif fs-5 fw-normal">
                    <span>{{ $item['title'] }}</span>
                    <i class="fas fa-chevron-down text-gold text-xs transition-smooth ms-3 flex-shrink-0" :class="{ 'rotate-180': activeAccordion === {{ $index }} }"></i>
                </button>
                <div x-show="activeAccordion === {{ $index }}" x-collapse class="px-3 pb-4 px-md-4 pb-md-4 text-sm text-muted-luxury fw-light lh-base border-top border-gold-15 pt-3">
                    {!! $item['content'] !!}
                </div>
            </div>
        @endforeach
    </div>
@endif
