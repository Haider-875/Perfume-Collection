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

    $parentLinks = [];
    $activeItem = null;

    foreach ($breadcrumbList as $title => $url) {
        if (!empty($url) || $title === 'Home') {
            $parentLinks[$title] = $url ?: route('home');
        } else {
            $activeItem = $title;
        }
    }

@endphp

<nav aria-label="Breadcrumb" class="luxury-breadcrumbs-wrapper mx-auto mb-3 text-center d-inline-flex flex-column align-items-center">
    <!-- Parent Navigation Links (Distinct, Refined Pill Badge) -->
    @if(!empty($parentLinks))
        <div class="breadcrumb-parents-pill d-inline-flex align-items-center justify-content-center gap-2.5 px-4 py-2 rounded-pill shadow-xs mb-1.5"
             style="background-color: #FFFFFF; border: 1px solid #E8E0DA; gap: 9px; padding: 7px 18px;">
            @php $pIdx = 0; @endphp
            @foreach($parentLinks as $pTitle => $pUrl)
                @if($pIdx > 0)
                    <i class="fas fa-chevron-right" style="font-size: 8px; color: #9E7D3B; opacity: 0.85; margin: 0 2px;"></i>
                @endif
                <a href="{{ $pUrl }}" class="transition-smooth d-inline-flex align-items-center text-decoration-none"
                   style="color: #6B605B; font-size: 11px; font-weight: 500; font-family: 'Poppins', sans-serif; gap: 8px;">
                    @if($pTitle === 'Home')
                        <i class="fas fa-home" style="font-size: 11.5px; color: #541B29; margin-right: 2px;"></i>
                    @endif
                    <span>{{ $pTitle }}</span>
                </a>
                @php $pIdx++; @endphp
            @endforeach
        </div>
    @endif

    <!-- Current Location / Highlighted Active Title (Strictly Center Aligned) -->
    @if($activeItem)
        <div class="breadcrumb-active-wrap text-center w-100">
            <span class="breadcrumb-active-badge d-inline-flex align-items-center justify-content-center text-center px-4 py-2 rounded-pill shadow-xs"
                  style="background-color: #FAF4EB; border: 1px solid #EAD8B8; color: #541B29; font-size: 12px; font-weight: 600; font-family: 'Poppins', sans-serif; letter-spacing: 0.02em; padding: 7px 18px;">
                {{ $activeItem }}
            </span>
        </div>
    @endif
</nav>
