@props(['links' => [], 'items' => []])

@php
    $breadcrumbList = [];
    if (!empty($items)) {
        foreach ($items as $item) {
            $breadcrumbList[$item['label'] ?? ''] = $item['url'] ?? null;
        }
    } elseif (!empty($links)) {
        $breadcrumbList = $links;
    }
@endphp

<nav aria-label="Breadcrumb" class="py-3 px-4 bg-[#080204]/80 border-b border-[#d6aa62]/20 mb-4 inline-block rounded-lg">
    <ol class="list-none flex flex-wrap items-center gap-2 text-xs text-[#b8a9a2] m-0 p-0">
        <li>
            <a href="{{ route('home') }}" class="text-[#b8a9a2] hover:text-[#d6aa62] transition flex items-center gap-1.5 no-underline">
                <i class="fas fa-home text-[#d6aa62] text-[11px]"></i> <span>Home</span>
            </a>
        </li>

        @foreach($breadcrumbList as $title => $url)
            @if($title && $title !== 'Home')
                <li class="text-[#d6aa62]/50 text-[10px]"><i class="fas fa-chevron-right"></i></li>
                <li>
                    @if($url)
                        <a href="{{ $url }}" class="text-[#f0d59d] hover:text-[#d6aa62] transition no-underline">{{ $title }}</a>
                    @else
                        <span class="text-[#f5efe7] font-semibold">{{ $title }}</span>
                    @endif
                </li>
            @endif
        @endforeach
    </ol>
</nav>
