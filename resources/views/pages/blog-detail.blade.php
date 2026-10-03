@extends('layouts.app')

@section('title', $blog->title . ' | Maison d\'Orient Fragrance Chronicles')
@section('meta_description', $blog->meta_description ?? \Illuminate\Support\Str::limit(strip_tags($blog->summary ?? $blog->content), 155))

@section('content')

<!-- Blog Detail Header -->
<article class="py-16 md:py-24 bg-[#080304]">
    <div class="container max-w-4xl mx-auto">
        
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Fragrance Chronicles', 'url' => route('blogs.index')],
            ['label' => $blog->title]
        ]" />

        <!-- Meta Header -->
        <div class="text-center space-y-4 mb-8">
            <span class="inline-block text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] font-semibold border border-[#C9A24B]/30 px-3 py-1 rounded">
                {{ $blog->category_name ?? 'HAUTE OLFACTION' }}
            </span>
            <h1 class="font-serif text-3xl md:text-5xl text-[#F5EFE6] leading-tight font-normal">
                {{ $blog->title }}
            </h1>
            <div class="flex items-center justify-center space-x-4 text-xs text-[#F5EFE6]/60">
                <span>By <strong class="text-[#C9A24B]">{{ $blog->author_name ?? 'Master Parfumeur' }}</strong></span>
                <span>&bull;</span>
                <span>{{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('F d, Y') : 'Recent' }}</span>
                <span>&bull;</span>
                <span>{{ $blog->reading_time_min ?? 5 }} Min Read</span>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="mb-12 rounded-lg overflow-hidden border border-[#C9A24B]/30 shadow-2xl bg-[#120709]">
            <img 
                src="{{ asset($blog->cover_image ?? 'assets/images/perfumes/blog_oud_guide.svg') }}" 
                alt="{{ $blog->title }}" 
                class="w-full max-h-[500px] object-cover"
            >
        </div>

        <!-- Article Rich Content -->
        <div class="prose prose-invert max-w-none text-[#F5EFE6]/85 text-base md:text-lg leading-relaxed space-y-6 font-light">
            {!! $blog->content !!}
        </div>

        <!-- Author Bio Box -->
        <div class="mt-16 p-8 bg-[#0E0507] border border-[#C9A24B]/30 rounded-lg flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
            <div class="w-16 h-16 rounded-full bg-[#C9A24B]/15 border border-[#C9A24B]/50 flex items-center justify-center text-[#C9A24B] text-2xl flex-shrink-0">
                <i class="fas fa-gem"></i>
            </div>
            <div class="text-center sm:text-left">
                <h4 class="font-serif text-lg text-[#F5EFE6]">{{ $blog->author_name ?? 'Maison d\'Orient Master Parfumeur' }}</h4>
                <p class="text-xs text-[#F5EFE6]/65 mt-1 leading-relaxed">
                    Trained in Grasse, France with extensive mastery of Eastern distillation, curating bespoke Extrait de Parfum formulas designed to withstand Pakistan’s tropical summer heat and dry winters.
                </p>
            </div>
        </div>

        <!-- Share Actions -->
        <div class="mt-8 pt-6 border-t border-[#C9A24B]/20 flex flex-wrap items-center justify-between gap-4">
            <span class="text-xs uppercase tracking-widest text-[#C9A24B]">Share this Chronicle:</span>
            <div class="flex items-center space-x-3">
                <a href="https://wa.me/?text={{ urlencode($blog->title . ' ' . url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-[#25D366]/20 border border-[#25D366]/40 flex items-center justify-center text-[#25D366] hover:bg-[#25D366] hover:text-white transition">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-blue-600/20 border border-blue-600/40 flex items-center justify-center text-blue-400 hover:bg-blue-600 hover:text-white transition">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-sky-500/20 border border-sky-500/40 flex items-center justify-center text-sky-400 hover:bg-sky-500 hover:text-white transition">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>
        </div>

    </div>
</article>

<!-- Related Articles & Featured Flacons -->
@if($relatedBlogs->count() > 0)
    <section class="py-16 bg-[#0B0406] border-t border-[#C9A24B]/20">
        <div class="container">
            <div class="text-center mb-12">
                <span class="text-[10px] uppercase tracking-[0.3em] text-[#C9A24B] font-semibold">FURTHER READING</span>
                <h3 class="font-serif text-2xl md:text-3xl text-[#F5EFE6] mt-1">Related Fragrance Essays</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedBlogs as $rBlog)
                    <div class="bg-[#080304] border border-[#C9A24B]/20 rounded-lg p-5 group hover:border-[#C9A24B]/50 transition">
                        <span class="text-[10px] text-[#C9A24B] uppercase tracking-wider block mb-2">{{ $rBlog->category_name ?? 'Fragrance' }}</span>
                        <h4 class="font-serif text-base text-[#F5EFE6] group-hover:text-[#C9A24B] transition-colors mb-2">
                            <a href="{{ route('blogs.show', $rBlog->slug) }}">{{ $rBlog->title }}</a>
                        </h4>
                        <p class="text-xs text-[#F5EFE6]/60 line-clamp-2">
                            {{ $rBlog->summary ?? \Illuminate\Support\Str::limit(strip_tags($rBlog->content), 80) }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@endsection
