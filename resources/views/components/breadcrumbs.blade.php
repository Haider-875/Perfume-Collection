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

<nav aria-label="Breadcrumb" class="py-2 px-3 bg-theme-dark border-bottom border-gold-20 mb-4 d-inline-block rounded-2">
    <ol class="breadcrumb m-0 d-flex flex-wrap align-items-center gap-2 text-xs text-muted-luxury">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}" class="text-muted-luxury hover:text-gold transition d-flex align-items-center gap-1 text-decoration-none">
                <i class="fas fa-home text-gold" style="font-size: 11px;"></i> <span>Home</span>
            </a>
        </li>

        @foreach($breadcrumbList as $title => $url)
            @if($title && $title !== 'Home')
                <li class="text-gold opacity-50" style="font-size: 10px;"><i class="fas fa-chevron-right"></i></li>
                <li class="breadcrumb-item">
                    @if($url)
                        <a href="{{ $url }}" class="text-gold-soft hover:text-gold transition text-decoration-none">{{ $title }}</a>
                    @else
                        <span class="text-ivory fw-semibold">{{ $title }}</span>
                    @endif
                </li>
            @endif
        @endforeach
    </ol>
</nav>
