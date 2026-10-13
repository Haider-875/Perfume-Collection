@extends('layouts.app')

@section('title', 'The Olfactory Chronicles & Fragrance Journal | Maison d\'Orient Pakistan')
@section('meta_description', 'Delve into the artisanal secrets of Dehn al Oud, French-Oriental maceration, fragrance layering, and longevity tips in Pakistan’s climate.')

@section('content')

<!-- Blog Hero Banner -->
<section class="py-5 text-center position-relative overflow-hidden" style="background-color: #FAF7F2; border-bottom: 1px solid #E8E0DA;">
    <div class="container px-3 px-lg-4 position-relative z-1">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Fragrance Chronicles']
        ]" />

        <span class="d-inline-block mb-2 fw-semibold" style="font-size: 11px; letter-spacing: 0.3em; text-transform: uppercase; color: #541B29;">THE ARTISANAL JOURNAL</span>
        <h1 class="font-serif mb-3 fw-normal display-5 tracking-wide" style="color: #211D1E;">
            Olfactory Chronicles
        </h1>
        <p class="mx-auto lh-base mb-0" style="max-width: 672px; font-size: 0.95rem; color: #514744;">
            Essays on rare Cambodian agarwood distillations, maceration techniques, seasonal wear in Pakistan, and the art of Extrait layering.
        </p>
    </div>
</section>

<!-- Blog List & Featured Article -->
<section class="py-5" style="background-color: #F7F3EE;">
    <div class="container px-3 px-lg-4">
        
        <!-- Featured Article Spotlight -->
        @if($featuredBlog)
            <div class="mb-5 rounded-3 overflow-hidden shadow-sm transition" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                <div class="row g-0">
                    <div class="col-12 col-lg-7 position-relative overflow-hidden" style="min-height: 288px; background-color: #FAF7F2;">
                        <img 
                            src="{{ asset($featuredBlog->image) }}" 
                            alt="{{ $featuredBlog->title }}" 
                            class="w-100 h-100 object-fit-cover"
                            style="object-fit: cover; object-position: center;"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/blogs/blog_extrait_science.jpg') }}';"
                        >
                        <div class="position-absolute top-0 start-0 m-3 px-3 py-1.5 rounded-pill text-uppercase fw-semibold shadow-sm" style="font-size: 10px; letter-spacing: 0.1em; background-color: #541B29; color: #FFFFFF; display: inline-flex; align-items: center; line-height: 1; border: 1px solid rgba(255,255,255,0.18); white-space: nowrap;">
                            FEATURED CHRONICLE
                        </div>
                    </div>

                    <div class="col-12 col-lg-5 p-4 p-lg-5 d-flex flex-column justify-content-between">
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center gap-2 text-xs" style="color: #786C67;">
                                <span><i class="far fa-calendar-alt me-1"></i> {{ $featuredBlog->published_at ? \Carbon\Carbon::parse($featuredBlog->published_at)->format('F d, Y') : 'Featured' }}</span>
                                <span>&bull;</span>
                                <span><i class="far fa-clock me-1"></i> {{ $featuredBlog->reading_time_min ?? 5 }} MIN READ</span>
                            </div>

                            <h2 class="font-serif fs-3 lh-sm mb-0">
                                <a href="{{ route('blogs.show', $featuredBlog->slug) }}" class="text-decoration-none transition" style="color: #211D1E !important;">
                                    {{ $featuredBlog->title }}
                                </a>
                            </h2>

                            <p class="lh-base mb-0" style="font-size: 0.9rem; color: #514744;">
                                {{ $featuredBlog->summary ?? \Illuminate\Support\Str::limit(strip_tags($featuredBlog->content), 160) }}
                            </p>
                        </div>

                        <div class="pt-4 mt-4 d-flex align-items-center justify-content-between" style="border-top: 1px solid #E8E0DA;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-xs" style="width: 32px; height: 32px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                                    <i class="fas fa-feather-alt"></i>
                                </div>
                                <span class="text-xs" style="color: #786C67;">{{ $featuredBlog->author_name ?? 'Master Parfumeur' }}</span>
                            </div>

                            <a href="{{ route('blogs.show', $featuredBlog->slug) }}" class="text-xs text-uppercase tracking-widest fw-semibold d-flex align-items-center gap-2 text-decoration-none" style="color: #541B29;">
                                <span>Read Chronicle</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Articles Grid -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($blogs as $blog)
                <div class="col">
                    <article class="blog-card luxury-hover-card rounded-3 overflow-hidden d-flex flex-column h-100 transition shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                        <div class="position-relative overflow-hidden" style="height: 224px; background-color: #FAF7F2;">
                            <div class="blog-card-badges-row position-absolute top-0 start-0 end-0 p-2 p-sm-2.5 d-flex align-items-center justify-content-between gap-2 z-2" style="pointer-events: none;">
                                <span class="blog-card-category-badge rounded-pill fw-bold text-uppercase shadow-sm" 
                                      style="font-size: 9.5px; letter-spacing: 0.08em; background-color: #541B29; color: #FFFFFF; padding: 4.5px 11px; line-height: 1; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap; max-width: calc(100% - 85px); overflow: hidden; text-overflow: ellipsis; border: 1px solid rgba(255,255,255,0.18);"
                                      title="{{ $blog->category ?? $blog->category_name ?? 'Olfactory Art' }}">
                                    {{ $blog->category ?? $blog->category_name ?? 'Olfactory Art' }}
                                </span>
                                <span class="blog-card-readtime-badge rounded-pill fw-medium shadow-xs" 
                                      style="background-color: rgba(255, 255, 255, 0.94); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); border: 1px solid #E8E0DA; font-size: 9.5px; color: #211D1E !important; padding: 4.5px 10px; line-height: 1; display: inline-flex; align-items: center; justify-content: center; gap: 4px; white-space: nowrap; flex-shrink: 0;">
                                    <i class="far fa-clock" style="font-size: 8.5px; color: #851029;"></i>
                                    <span>{{ $blog->read_time ?? ($blog->reading_time_min ? $blog->reading_time_min . ' min read' : '5 min read') }}</span>
                                </span>
                            </div>
                            <img 
                                src="{{ asset($blog->image) }}" 
                                alt="{{ $blog->title }}" 
                                class="w-100 h-100 object-fit-cover"
                                style="object-fit: cover; object-position: center;"
                                onerror="this.onerror=null; this.src='{{ asset('assets/images/blogs/blog_extrait_science.jpg') }}';"
                            >
                        </div>

                        <div class="p-3 p-md-4 flex-grow-1 d-flex flex-column justify-content-between">
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex align-items-center gap-2" style="font-size: 11px; color: #786C67;">
                                    <span>{{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('M d, Y') : 'Recent' }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $blog->reading_time_min ?? 4 }} min read</span>
                                </div>

                                <h3 class="blog-card-title font-serif fw-medium lh-sm mb-0">
                                    <a href="{{ route('blogs.show', $blog->slug) }}" class="text-decoration-none transition" style="color: #211D1E !important;">
                                        {{ $blog->title }}
                                    </a>
                                </h3>

                                <p class="blog-card-excerpt text-xs lh-base mb-0" style="color: #514744;">
                                    {{ $blog->summary ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 120) }}
                                </p>
                            </div>

                            <div class="pt-3 mt-3 d-flex align-items-center justify-content-between text-xs" style="border-top: 1px solid #E8E0DA;">
                                <span style="color: #786C67;">{{ $blog->author_name ?? 'Maison d\'Orient' }}</span>
                                <a href="{{ route('blogs.show', $blog->slug) }}" class="text-decoration-none fw-semibold" style="color: #541B29;">
                                    Read Full Article &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {{ $blogs->links() }}
        </div>

    </div>
</section>

@endsection
