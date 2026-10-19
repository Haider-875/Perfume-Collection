@extends('layouts.app')

@section('title', $blog->title . ' | Maison d\'Orient Fragrance Chronicles')
@section('meta_description', $blog->meta_description ?? \Illuminate\Support\Str::limit(strip_tags($blog->summary ?? $blog->content), 155))

@section('content')

<!-- Blog Detail Header -->
<article class="py-4 py-md-5" style="background-color: #F7F3EE;">
    <div class="container px-3 px-lg-4" style="max-width: 860px;">
        
        <!-- Breadcrumbs Component (Only parent navigation to keep title clean) -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Fragrance Chronicles', 'url' => route('blogs.index')]
        ]" />

        <!-- Meta Header -->
        <div class="text-center d-flex flex-column gap-2.5 gap-md-3 mb-4 mx-auto" style="max-width: 760px;">
            <div>
                <span class="d-inline-block fw-semibold px-2.5 py-0.5 rounded text-uppercase tracking-wider" style="font-size: 10px; letter-spacing: 0.2em; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                    {{ $blog->category_name ?? 'HAUTE OLFACTION' }}
                </span>
            </div>
            <h1 class="font-serif fw-bold mb-0" style="color: #211D1E; font-size: clamp(1.35rem, 2.8vw, 1.95rem); line-height: 1.35; letter-spacing: -0.01em;">
                {{ $blog->title }}
            </h1>
            <div class="d-flex align-items-center justify-content-center flex-wrap gap-2 gap-sm-3 text-xs" style="color: #786C67; font-size: 12px;">
                <span>By <strong style="color: #541B29;">{{ $blog->author_name ?? 'Master Parfumeur' }}</strong></span>
                <span>&bull;</span>
                <span>{{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('F d, Y') : 'Recent' }}</span>
                <span>&bull;</span>
                <span>{{ $blog->reading_time_min ?? 5 }} Min Read</span>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="blog-detail-featured-media mb-4 mb-md-5 shadow-xs" style="background-color: #FAF7F2; border: 1px solid #E8E0DA; border-radius: 14px; overflow: hidden;">
            <img 
                src="{{ asset($blog->image) }}" 
                alt="{{ $blog->title }}" 
                class="blog-detail-featured-img w-100 h-100 object-fit-cover"
                onerror="this.onerror=null; this.src='{{ asset('assets/images/blogs/blog_extrait_science.jpg') }}';"
                style="object-fit: cover; object-position: center; max-height: 440px;"
            >
        </div>

        <!-- Article Rich Content -->
        <div class="lh-lg fw-normal d-flex flex-column gap-3.5 gap-md-4" style="font-size: clamp(0.92rem, 1.6vw, 1rem); line-height: 1.75; color: #4A403A;">
            {!! $blog->content !!}
        </div>

        <!-- Author Bio Box -->
        <div class="mt-4 mt-md-5 p-3 p-sm-4 rounded-3 d-flex flex-column flex-sm-row align-items-center gap-3 gap-sm-3.5 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                 style="width: 52px; height: 52px; background: linear-gradient(135deg, #FAF4EB 0%, #F5EBEF 100%) !important; border: 1px solid #EAD8B8 !important;">
                <i class="fas fa-gem gradient-gold-icon" style="font-size: 1.25rem; background: linear-gradient(135deg, #d49a3d 0%, #c4244b 45%, #780d24 100%) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; background-clip: text !important; display: inline-block;"></i>
            </div>
            <div class="text-center text-sm-start flex-grow-1">
                <h4 class="font-serif fw-semibold mb-1" style="color: #211D1E; font-size: clamp(0.95rem, 2vw, 1.1rem);">
                    {{ $blog->author_name ?? 'Master Parfumeur M. Al-Farabi' }}
                </h4>
                <p class="mb-0 fw-light" style="color: #6B605B; font-size: clamp(0.78rem, 1.6vw, 0.85rem); line-height: 1.55;">
                    Trained in Grasse, France with extensive mastery of Eastern distillation, curating bespoke Extrait de Parfum formulas designed to withstand Pakistan’s tropical summer heat and dry winters.
                </p>
            </div>
        </div>

        <!-- Share Actions (Instagram, Facebook, WhatsApp only) -->
        <div class="mt-4 pt-3 pt-md-4 d-flex flex-wrap align-items-center justify-content-between gap-3" style="border-top: 1px solid #E8E0DA;">
            <span class="text-xs text-uppercase tracking-wider fw-semibold" style="color: #541B29; font-size: 11px;">Share this Chronicle:</span>
            <div class="d-flex align-items-center gap-2">
                <!-- Instagram -->
                <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="rounded-circle border d-flex align-items-center justify-content-center text-decoration-none transition" title="Instagram" style="width: 36px; height: 36px; background-color: rgba(225, 48, 108, 0.1); border-color: rgba(225, 48, 108, 0.35); color: #E1306C;">
                    <i class="fab fa-instagram" style="font-size: 15px;"></i>
                </a>
                <!-- Facebook -->
                <a href="https://facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="rounded-circle border d-flex align-items-center justify-content-center text-decoration-none transition" title="Facebook" style="width: 36px; height: 36px; background-color: rgba(24, 119, 242, 0.1); border-color: rgba(24, 119, 242, 0.35); color: #1877F2;">
                    <i class="fab fa-facebook-f" style="font-size: 14px;"></i>
                </a>
                <!-- WhatsApp -->
                <a href="https://wa.me/?text={{ urlencode($blog->title . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="rounded-circle border d-flex align-items-center justify-content-center text-decoration-none transition" title="WhatsApp" style="width: 36px; height: 36px; background-color: rgba(37, 211, 102, 0.12); border-color: rgba(37, 211, 102, 0.4); color: #25D366;">
                    <i class="fab fa-whatsapp" style="font-size: 16px;"></i>
                </a>
            </div>
        </div>

    </div>
</article>

@endsection
