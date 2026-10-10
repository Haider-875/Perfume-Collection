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

<nav aria-label="Breadcrumb" class="py-1.5 px-3 mb-4 d-inline-block rounded-pill shadow-xs" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
    <ol class="breadcrumb m-0 d-flex flex-wrap align-items-center gap-2 text-xs" style="color: #6B605B;">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}" class="transition d-flex align-items-center gap-1 text-decoration-none" style="color: #6B605B;">
                <i class="fas fa-home" style="font-size: 11px; color: #541B29;"></i> <span>Home</span>
            </a>
        </li>

        @foreach($breadcrumbList as $title => $url)
            @if($title && $title !== 'Home')
                <li style="font-size: 9px; color: #A89F99;"><i class="fas fa-chevron-right"></i></li>
                <li class="breadcrumb-item">
                    @if($url)
                        <a href="{{ $url }}" class="transition text-decoration-none" style="color: #6B605B;">{{ $title }}</a>
                    @else
                        <span class="fw-semibold" style="color: #211D1E;">{{ $title }}</span>
                    @endif
                </li>
            @endif
        @endforeach
    </ol>
</nav>
