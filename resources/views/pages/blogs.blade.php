@extends('layouts.app')

@section('title', 'The Olfactory Chronicles & Fragrance Journal | Maison d\'Orient Pakistan')
@section('meta_description', 'Delve into the artisanal secrets of Dehn al Oud, French-Oriental maceration, fragrance layering, and longevity tips in Pakistan’s climate.')

@section('content')

<!-- Blog Hero Banner -->
<section class="py-5 border-bottom border-gold-20 text-center position-relative overflow-hidden" style="background-color: #0A0405;">
    <div class="container px-3 px-lg-4 position-relative z-1">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Fragrance Chronicles']
        ]" />

        <span class="d-inline-block text-gold mb-2 fw-medium" style="font-size: 11px; letter-spacing: 0.3em; text-transform: uppercase;">THE ARTISANAL JOURNAL</span>
        <h1 class="font-serif text-light-parchment mb-3 fw-normal display-5 tracking-wide">
            Olfactory Chronicles
        </h1>
        <p class="mx-auto text-muted-parchment lh-base fw-light mb-0" style="max-width: 672px; font-size: 0.95rem;">
            Essays on rare Cambodian agarwood distillations, maceration techniques, seasonal wear in Pakistan, and the art of Extrait layering.
        </p>
    </div>
</section>

<!-- Blog List & Featured Article -->
<section class="py-5" style="background-color: #080304;">
    <div class="container px-3 px-lg-4">
        
        <!-- Featured Article Spotlight -->
        @if($featuredBlog)
            <div class="mb-5 bg-wine-card border border-gold-30 rounded-3 overflow-hidden shadow-2xl transition">
                <div class="row g-0">
                    <div class="col-12 col-lg-7 position-relative overflow-hidden bg-wine-dark" style="min-height: 288px;">
                        <img 
                            src="{{ asset($featuredBlog->image) }}" 
                            alt="{{ $featuredBlog->title }}" 
                            class="w-100 h-100 object-fit-cover"
                            style="object-fit: cover; object-position: center;"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/blogs/blog_extrait_science.jpg') }}';"
                        >
                        <div class="position-absolute top-0 start-0 m-3 bg-wine-accent text-light-parchment border border-gold-40 px-3 py-1 rounded text-uppercase fw-semibold" style="font-size: 10px; letter-spacing: 0.1em;">
                            FEATURED CHRONICLE
                        </div>
                    </div>

                    <div class="col-12 col-lg-5 p-4 p-lg-5 d-flex flex-column justify-content-between">
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center gap-2 text-xs text-gold">
                                <span><i class="far fa-calendar-alt me-1"></i> {{ $featuredBlog->published_at ? \Carbon\Carbon::parse($featuredBlog->published_at)->format('F d, Y') : 'Featured' }}</span>
                                <span>&bull;</span>
                                <span><i class="far fa-clock me-1"></i> {{ $featuredBlog->reading_time_min ?? 5 }} MIN READ</span>
                            </div>

                            <h2 class="font-serif fs-3 text-light-parchment lh-sm mb-0">
                                <a href="{{ route('blogs.show', $featuredBlog->slug) }}" class="text-light-parchment text-gold-hover text-decoration-none transition">
                                    {{ $featuredBlog->title }}
                                </a>
                            </h2>

                            <p class="text-muted-parchment lh-base mb-0" style="font-size: 0.9rem;">
                                {{ $featuredBlog->summary ?? \Illuminate\Support\Str::limit(strip_tags($featuredBlog->content), 160) }}
                            </p>
                        </div>

                        <div class="pt-4 mt-4 border-top border-gold-15 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-wine-accent border border-gold-40 d-flex align-items-center justify-content-center text-gold text-xs" style="width: 32px; height: 32px;">
                                    <i class="fas fa-feather-alt"></i>
                                </div>
                                <span class="text-xs text-muted-parchment">{{ $featuredBlog->author_name ?? 'Master Parfumeur' }}</span>
                            </div>

                            <a href="{{ route('blogs.show', $featuredBlog->slug) }}" class="text-xs text-uppercase tracking-widest text-gold fw-semibold d-flex align-items-center gap-2 text-decoration-none">
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
                    <article class="bg-wine-card border border-gold-20 rounded-3 overflow-hidden d-flex flex-column h-100 transition shadow-sm">
                        <div class="position-relative overflow-hidden bg-wine-dark" style="height: 224px;">
                            <img 
                                src="{{ asset($blog->image) }}" 
                                alt="{{ $blog->title }}" 
                                class="w-100 h-100 object-fit-cover"
                                style="object-fit: cover; object-position: center;"
                                onerror="this.onerror=null; this.src='{{ asset('assets/images/blogs/blog_extrait_science.jpg') }}';"
                            >
                            <div class="position-absolute top-0 end-0 m-3 px-2 py-1 rounded text-gold border border-gold-30" style="background-color: rgba(0,0,0,0.6); backdrop-filter: blur(4px); font-size: 10px;">
                                {{ $blog->category_name ?? 'Olfactory Art' }}
                            </div>
                        </div>

                        <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex align-items-center gap-2 text-muted-parchment" style="font-size: 11px;">
                                    <span>{{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('M d, Y') : 'Recent' }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $blog->reading_time_min ?? 4 }} min read</span>
                                </div>

                                <h3 class="font-serif fs-5 text-light-parchment lh-sm mb-0">
                                    <a href="{{ route('blogs.show', $blog->slug) }}" class="text-light-parchment text-gold-hover text-decoration-none transition">
                                        {{ $blog->title }}
                                    </a>
                                </h3>

                                <p class="text-xs text-muted-parchment lh-base mb-0">
                                    {{ $blog->summary ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 120) }}
                                </p>
                            </div>

                            <div class="pt-3 mt-3 border-top border-gold-15 d-flex align-items-center justify-content-between text-xs">
                                <span class="text-muted-parchment">{{ $blog->author_name ?? 'Maison d\'Orient' }}</span>
                                <a href="{{ route('blogs.show', $blog->slug) }}" class="text-gold text-decoration-none fw-medium text-gold-hover">
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
