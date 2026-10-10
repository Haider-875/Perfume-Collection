@if ($paginator->hasPages())
    <nav class="luxury-pagination-nav d-flex flex-column align-items-center gap-2" aria-label="Pagination Navigation">
        
        <ul class="luxury-pagination list-unstyled m-0 d-inline-flex align-items-center flex-wrap justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="luxury-page-item disabled" aria-disabled="true" aria-label="Previous Page">
                    <span class="luxury-page-link luxury-page-arrow disabled">
                        <i class="fas fa-chevron-left" style="font-size: 10px;"></i>
                        <span class="d-none d-sm-inline ms-1.5">Prev</span>
                    </span>
                </li>
            @else
                <li class="luxury-page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="luxury-page-link luxury-page-arrow" rel="prev" aria-label="Previous Page">
                        <i class="fas fa-chevron-left" style="font-size: 10px;"></i>
                        <span class="d-none d-sm-inline ms-1.5">Prev</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="luxury-page-item disabled" aria-disabled="true">
                        <span class="luxury-page-link luxury-page-dots">&hellip;</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="luxury-page-item active" aria-current="page">
                                <span class="luxury-page-link luxury-page-num active">{{ $page }}</span>
                            </li>
                        @else
                            <li class="luxury-page-item">
                                <a href="{{ $url }}" class="luxury-page-link luxury-page-num">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="luxury-page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="luxury-page-link luxury-page-arrow" rel="next" aria-label="Next Page">
                        <span class="d-none d-sm-inline me-1.5">Next</span>
                        <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                    </a>
                </li>
            @else
                <li class="luxury-page-item disabled" aria-disabled="true" aria-label="Next Page">
                    <span class="luxury-page-link luxury-page-arrow disabled">
                        <span class="d-none d-sm-inline me-1.5">Next</span>
                        <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                    </span>
                </li>
            @endif
        </ul>

        {{-- Intelligent Results Summary --}}
        <div class="luxury-pagination-summary text-muted-parchment text-center font-sans mt-2" style="font-size: 11.5px; letter-spacing: 0.04em;">
            Page <span class="text-gold fw-semibold">{{ $paginator->currentPage() }}</span> of <span class="text-gold fw-semibold">{{ $paginator->lastPage() }}</span>
            <span class="opacity-50 mx-1.5">&bull;</span>
            Showing <span class="text-light-parchment">{{ $paginator->firstItem() ?? 0 }}&ndash;{{ $paginator->lastItem() ?? 0 }}</span> of <span class="text-gold fw-semibold">{{ $paginator->total() }}</span> Creations
        </div>

    </nav>
@endif
