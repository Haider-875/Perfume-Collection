@extends('layouts.app')

@section('title', $blog->title . ' | Maison d\'Orient Fragrance Chronicles')
@section('meta_description', $blog->meta_description ?? \Illuminate\Support\Str::limit(strip_tags($blog->summary ?? $blog->content), 155))

@section('content')

<!-- Blog Detail Header -->
<article class="py-5" style="background-color: #080304;">
    <div class="container px-3 px-lg-4" style="max-width: 896px;">
        
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Fragrance Chronicles', 'url' => route('blogs.index')],
            ['label' => $blog->title]
        ]" />

        <!-- Meta Header -->
        <div class="text-center d-flex flex-column gap-3 mb-4">
            <div>
                <span class="d-inline-block text-gold fw-semibold border border-gold-30 px-3 py-1 rounded text-uppercase" style="font-size: 11px; letter-spacing: 0.3em;">
                    {{ $blog->category_name ?? 'HAUTE OLFACTION' }}
                </span>
            </div>
            <h1 class="font-serif display-5 text-light-parchment lh-sm fw-normal mb-0">
                {{ $blog->title }}
            </h1>
            <div class="d-flex align-items-center justify-content-center gap-3 text-xs text-muted-parchment">
                <span>By <strong class="text-gold">{{ $blog->author_name ?? 'Master Parfumeur' }}</strong></span>
                <span>&bull;</span>
                <span>{{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('F d, Y') : 'Recent' }}</span>
                <span>&bull;</span>
                <span>{{ $blog->reading_time_min ?? 5 }} Min Read</span>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="mb-5 rounded-3 overflow-hidden border border-gold-30 shadow-2xl bg-wine-dark text-center">
            <img 
                src="{{ asset($blog->cover_image ?? 'assets/images/perfumes/blog_oud_guide.svg') }}" 
                alt="{{ $blog->title }}" 
                class="img-fluid w-100 object-cover"
                style="max-height: 500px;"
            >
        </div>

        <!-- Article Rich Content -->
        <div class="text-light-parchment lh-lg fw-light d-flex flex-column gap-4" style="font-size: 1.05rem;">
            {!! $blog->content !!}
        </div>

        <!-- Author Bio Box -->
        <div class="mt-5 p-4 bg-wine-card border border-gold-30 rounded-3 d-flex flex-column flex-sm-row align-items-center gap-4">
            <div class="rounded-circle bg-wine-accent border border-gold-40 d-flex align-items-center justify-content-center text-gold fs-3 flex-shrink-0" style="width: 64px; height: 64px;">
                <i class="fas fa-gem"></i>
            </div>
            <div class="text-center text-sm-start">
                <h4 class="font-serif fs-5 text-light-parchment mb-1">{{ $blog->author_name ?? 'Maison d\'Orient Master Parfumeur' }}</h4>
                <p class="text-xs text-muted-parchment lh-base mb-0">
                    Trained in Grasse, France with extensive mastery of Eastern distillation, curating bespoke Extrait de Parfum formulas designed to withstand Pakistan’s tropical summer heat and dry winters.
                </p>
            </div>
        </div>

        <!-- Share Actions -->
        <div class="mt-4 pt-4 border-top border-gold-20 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <span class="text-xs text-uppercase tracking-widest text-gold fw-semibold">Share this Chronicle:</span>
            <div class="d-flex align-items-center gap-2">
                <a href="https://wa.me/?text={{ urlencode($blog->title . ' ' . url()->current()) }}" target="_blank" class="rounded-circle border d-flex align-items-center justify-content-center text-decoration-none transition" style="width: 36px; height: 36px; background-color: rgba(37, 211, 102, 0.15); border-color: rgba(37, 211, 102, 0.4); color: #25D366;">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="rounded-circle border d-flex align-items-center justify-content-center text-decoration-none transition text-primary" style="width: 36px; height: 36px; background-color: rgba(13, 110, 253, 0.15); border-color: rgba(13, 110, 253, 0.4);">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="rounded-circle border d-flex align-items-center justify-content-center text-decoration-none transition text-info" style="width: 36px; height: 36px; background-color: rgba(13, 202, 240, 0.15); border-color: rgba(13, 202, 240, 0.4);">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>
        </div>

    </div>
</article>

<!-- Related Articles & Featured Flacons -->
@if($relatedBlogs->count() > 0)
    <section class="py-5 border-top border-gold-20" style="background-color: #0B0406;">
        <div class="container px-3 px-lg-4">
            <div class="text-center mb-4">
                <span class="d-block text-gold fw-semibold" style="font-size: 10px; letter-spacing: 0.3em; text-transform: uppercase;">FURTHER READING</span>
                <h3 class="font-serif fs-3 text-light-parchment mt-1 mb-0">Related Fragrance Essays</h3>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-3">
                @foreach($relatedBlogs as $rBlog)
                    <div class="col">
                        <div class="bg-wine-card border border-gold-20 rounded-3 p-4 h-100 transition shadow-sm">
                            <span class="d-block text-gold text-uppercase tracking-wider mb-2" style="font-size: 10px;">{{ $rBlog->category_name ?? 'Fragrance' }}</span>
                            <h4 class="font-serif fs-6 mb-2">
                                <a href="{{ route('blogs.show', $rBlog->slug) }}" class="text-light-parchment text-gold-hover text-decoration-none transition">{{ $rBlog->title }}</a>
                            </h4>
                            <p class="text-xs text-muted-parchment mb-0">
                                {{ $rBlog->summary ?? \Illuminate\Support\Str::limit(strip_tags($rBlog->content), 80) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@endsection
