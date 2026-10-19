@if ($paginator->hasPages())
    @if(request()->is('admin*'))
        <nav class="admin-pagination-wrapper w-100 d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3" aria-label="Admin Pagination Navigation">
            <div class="admin-pagination-info small text-muted order-2 order-sm-1 text-center text-sm-start">
                Showing <strong class="text-dark">{{ $paginator->firstItem() ?? 0 }}</strong> to <strong class="text-dark">{{ $paginator->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $paginator->total() }}</strong> entries
            </div>

            <ul class="admin-pagination-list list-unstyled m-0 d-inline-flex align-items-center flex-wrap justify-content-center order-1 order-sm-2" style="gap: 6px;">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="admin-page-item disabled" aria-disabled="true" aria-label="Previous Page">
                        <span class="admin-page-link disabled" title="Previous Page">
                            <i class="fa-solid fa-chevron-left" style="font-size: 11px;"></i>
                            <span class="d-none d-md-inline ms-1.5">Prev</span>
                        </span>
                    </li>
                @else
                    <li class="admin-page-item">
                        <a href="{{ $paginator->previousPageUrl() }}" class="admin-page-link" rel="prev" aria-label="Previous Page" title="Previous Page">
                            <i class="fa-solid fa-chevron-left" style="font-size: 11px;"></i>
                            <span class="d-none d-md-inline ms-1.5">Prev</span>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="admin-page-item disabled" aria-disabled="true">
                            <span class="admin-page-link admin-page-dots">&hellip;</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="admin-page-item active" aria-current="page">
                                    <span class="admin-page-link active">{{ $page }}</span>
                                </li>
                            @else
                                <li class="admin-page-item">
                                    <a href="{{ $url }}" class="admin-page-link">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="admin-page-item">
                        <a href="{{ $paginator->nextPageUrl() }}" class="admin-page-link" rel="next" aria-label="Next Page" title="Next Page">
                            <span class="d-none d-md-inline me-1.5">Next</span>
                            <i class="fa-solid fa-chevron-right" style="font-size: 11px;"></i>
                        </a>
                    </li>
                @else
                    <li class="admin-page-item disabled" aria-disabled="true" aria-label="Next Page">
                        <span class="admin-page-link disabled" title="Next Page">
                            <span class="d-none d-md-inline me-1.5">Next</span>
                            <i class="fa-solid fa-chevron-right" style="font-size: 11px;"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    @else
        <nav class="luxury-pagination-nav d-flex flex-column align-items-center gap-2" aria-label="Pagination Navigation">
            <ul class="luxury-pagination list-unstyled m-0 d-inline-flex align-items-center flex-wrap justify-content-center">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="luxury-page-item disabled" aria-disabled="true" aria-label="Previous Page">
                        <span class="luxury-page-link luxury-page-arrow disabled">
                            <i class="fas fa-chevron-left"></i>
                            <span class="d-none d-sm-inline ms-1.5">Prev</span>
                        </span>
                    </li>
                @else
                    <li class="luxury-page-item">
                        <a href="{{ $paginator->previousPageUrl() }}" class="luxury-page-link luxury-page-arrow" rel="prev" aria-label="Previous Page">
                            <i class="fas fa-chevron-left"></i>
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
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="luxury-page-item disabled" aria-disabled="true" aria-label="Next Page">
                        <span class="luxury-page-link luxury-page-arrow disabled">
                            <span class="d-none d-sm-inline me-1.5">Next</span>
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>

            {{-- Intelligent Results Summary --}}
            <div class="luxury-pagination-summary text-center font-sans">
                Page <span class="fw-semibold" style="color: #541B29;">{{ $paginator->currentPage() }}</span> of <span class="fw-semibold" style="color: #541B29;">{{ $paginator->lastPage() }}</span>
                <span class="opacity-50 mx-1.5">&bull;</span>
                Showing <span class="fw-semibold" style="color: #211D1E;">{{ $paginator->firstItem() ?? 0 }}&ndash;{{ $paginator->lastItem() ?? 0 }}</span> of <span class="fw-semibold" style="color: #541B29;">{{ $paginator->total() }}</span> Creations
            </div>
        </nav>
    @endif
@endif
    