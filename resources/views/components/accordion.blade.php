@props(['title' => null, 'open' => false, 'items' => []])

@if($title)
    <div x-data="{ expanded: {{ $open ? 'true' : 'false' }} }" class="rounded-4 overflow-hidden shadow-sm mb-3" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
        <button type="button" 
                @click="expanded = !expanded"
                class="w-100 bg-transparent border-0 text-start p-3 p-md-4 d-flex justify-content-between align-items-center cursor-pointer font-serif fs-5 fw-normal" style="color: #211D1E;">
            <span>{{ $title }}</span>
            <i class="fas fa-chevron-down text-xs transition-smooth ms-3 flex-shrink-0" :class="{ 'rotate-180': expanded }" style="color: #541B29;"></i>
        </button>
        <div x-show="expanded" x-collapse class="px-3 pb-4 px-md-4 pb-md-4 text-sm fw-light lh-base pt-3" style="color: #4A403A; border-top: 1px solid #E8E0DA;">
            {{ $slot }}
        </div>
    </div>
@else
    <div class="luxury-accordion-wrapper vstack gap-3" x-data="{ activeAccordion: null }">
        @foreach($items as $index => $item)
            <div class="rounded-4 overflow-hidden shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === {{ $index }} ? null : {{ $index }}"
                        class="w-100 bg-transparent border-0 text-start p-3 p-md-4 d-flex justify-content-between align-items-center cursor-pointer font-serif fs-5 fw-normal" style="color: #211D1E;">
                    <span>{{ $item['title'] }}</span>
                    <i class="fas fa-chevron-down text-xs transition-smooth ms-3 flex-shrink-0" :class="{ 'rotate-180': activeAccordion === {{ $index }} }" style="color: #541B29;"></i>
                </button>
                <div x-show="activeAccordion === {{ $index }}" x-collapse class="px-3 pb-4 px-md-4 pb-md-4 text-sm fw-light lh-base pt-3" style="color: #4A403A; border-top: 1px solid #E8E0DA;">
                    {!! $item['content'] !!}
                </div>
            </div>
        @endforeach
    </div>
@endif
