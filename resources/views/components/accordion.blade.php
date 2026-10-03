@props(['title' => null, 'open' => false, 'items' => []])

@if($title)
    <div x-data="{ expanded: {{ $open ? 'true' : 'false' }} }" class="bg-[#140408] border border-[#d6aa62]/25 rounded-2xl overflow-hidden shadow-lg transition">
        <button type="button" 
                @click="expanded = !expanded"
                class="w-full bg-transparent border-none text-left p-5 md:p-6 flex justify-between items-center cursor-pointer text-[#f5efe7] font-serif text-lg md:text-xl font-normal hover:text-[#f0d59d] transition">
            <span>{{ $title }}</span>
            <i class="fas fa-chevron-down text-[#d6aa62] text-sm transition-transform duration-300 ml-4 flex-shrink-0" :class="{ 'rotate-180': expanded }"></i>
        </button>
        <div x-show="expanded" x-collapse class="px-5 pb-6 md:px-6 md:pb-6 text-sm text-[#b8a9a2] font-light leading-relaxed border-t border-[#d6aa62]/15 pt-4">
            {{ $slot }}
        </div>
    </div>
@else
    <div class="luxury-accordion-wrapper space-y-4" x-data="{ activeAccordion: null }">
        @foreach($items as $index => $item)
            <div class="bg-[#140408] border border-[#d6aa62]/25 rounded-2xl overflow-hidden shadow-lg">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === {{ $index }} ? null : {{ $index }}"
                        class="w-full bg-transparent border-none text-left p-5 md:p-6 flex justify-between items-center cursor-pointer text-[#f5efe7] font-serif text-lg md:text-xl font-normal hover:text-[#f0d59d] transition">
                    <span>{{ $item['title'] }}</span>
                    <i class="fas fa-chevron-down text-[#d6aa62] text-sm transition-transform duration-300 ml-4 flex-shrink-0" :class="{ 'rotate-180': activeAccordion === {{ $index }} }"></i>
                </button>
                <div x-show="activeAccordion === {{ $index }}" x-collapse class="px-5 pb-6 md:px-6 md:pb-6 text-sm text-[#b8a9a2] font-light leading-relaxed border-t border-[#d6aa62]/15 pt-4">
                    {!! $item['content'] !!}
                </div>
            </div>
        @endforeach
    </div>
@endif
