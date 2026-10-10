@extends('layouts.app')

@section('title', $blog->title . ' | Maison d\'Orient Fragrance Chronicles')
@section('meta_description', $blog->meta_description ?? \Illuminate\Support\Str::limit(strip_tags($blog->summary ?? $blog->content), 155))

@section('content')

<!-- Blog Detail Header -->
<article class="py-5" style="background-color: #F7F3EE;">
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
                <span class="d-inline-block fw-semibold px-3 py-1 rounded text-uppercase" style="font-size: 11px; letter-spacing: 0.3em; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                    {{ $blog->category_name ?? 'HAUTE OLFACTION' }}
                </span>
            </div>
            <h1 class="font-serif display-5 lh-sm fw-normal mb-0" style="color: #211D1E;">
                {{ $blog->title }}
            </h1>
            <div class="d-flex align-items-center justify-content-center gap-3 text-xs" style="color: #786C67;">
                <span>By <strong style="color: #541B29;">{{ $blog->author_name ?? 'Master Parfumeur' }}</strong></span>
                <span>&bull;</span>
                <span>{{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('F d, Y') : 'Recent' }}</span>
                <span>&bull;</span>
                <span>{{ $blog->reading_time_min ?? 5 }} Min Read</span>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="blog-detail-featured-media mb-5" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; border-radius: 16px; overflow: hidden;">
            <img 
                src="{{ asset($blog->image) }}" 
                alt="{{ $blog->title }}" 
                class="blog-detail-featured-img w-100 h-100 object-fit-cover"
                onerror="this.onerror=null; this.src='{{ asset('assets/images/blogs/blog_extrait_science.jpg') }}';"
                style="object-fit: cover; object-position: center; max-height: 480px;"
            >
        </div>

        <!-- Article Rich Content -->
        <div class="lh-lg fw-normal d-flex flex-column gap-4" style="font-size: 1.05rem; color: #4A403A;">
            {!! $blog->content !!}
        </div>

        <!-- Author Bio Box -->
        <div class="mt-5 p-4 rounded-3 d-flex flex-column flex-sm-row align-items-center gap-4" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <div class="rounded-circle d-flex align-items-center justify-content-center fs-3 flex-shrink-0" style="width: 64px; height: 64px; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                <i class="fas fa-gem"></i>
            </div>
            <div class="text-center text-sm-start">
                <h4 class="font-serif fs-5 mb-1" style="color: #211D1E;">{{ $blog->author_name ?? 'Maison d\'Orient Master Parfumeur' }}</h4>
                <p class="text-xs lh-base mb-0" style="color: #514744;">
                    Trained in Grasse, France with extensive mastery of Eastern distillation, curating bespoke Extrait de Parfum formulas designed to withstand Pakistan’s tropical summer heat and dry winters.
                </p>
            </div>
        </div>

        <!-- Share Actions -->
        <div class="mt-4 pt-4 d-flex flex-wrap align-items-center justify-content-between gap-3" style="border-top: 1px solid #E8E0DA;">
            <span class="text-xs text-uppercase tracking-widest fw-semibold" style="color: #541B29;">Share this Chronicle:</span>
            <div class="d-flex align-items-center gap-2">
                <a href="https://wa.me/?text={{ urlencode($blog->title . ' ' . url()->current()) }}" target="_blank" class="rounded-circle border d-flex align-items-center justify-content-center text-decoration-none transition" style="width: 36px; height: 36px; background-color: rgba(37, 211, 102, 0.15); border-color: rgba(37, 211, 102, 0.4); color: #25D366;">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="rounded-circle border d-flex align-items-center justify-content-center text-decoration-none transition text-primary" style="width: 36px; height: 36px; background-color: rgba(13, 110, 253, 0.15); border-color: rgba(13, 110, 253, 0.4);">
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
    <section class="py-5" style="background-color: #FAF7F2; border-top: 1px solid #E8E0DA;">
        <div class="container px-3 px-lg-4">
            <div class="text-center mb-4">
                <span class="d-block fw-semibold" style="font-size: 10px; letter-spacing: 0.3em; text-transform: uppercase; color: #541B29;">FURTHER READING</span>
                <h3 class="font-serif fs-3 mt-1 mb-0" style="color: #211D1E;">Related Fragrance Essays</h3>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-3">
                @foreach($relatedBlogs as $rBlog)
                    <div class="col">
                        <div class="rounded-3 p-4 h-100 transition shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                            <span class="d-block text-uppercase tracking-wider mb-2 fw-semibold" style="font-size: 10px; color: #541B29;">{{ $rBlog->category_name ?? 'Fragrance' }}</span>
                            <h4 class="font-serif fs-6 mb-2">
                                <a href="{{ route('blogs.show', $rBlog->slug) }}" class="text-decoration-none transition" style="color: #211D1E !important;">{{ $rBlog->title }}</a>
                            </h4>
                            <p class="text-xs mb-0" style="color: #514744;">
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
