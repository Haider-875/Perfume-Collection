@extends('layouts.app')

@section('title', 'The Olfactory Chronicles & Fragrance Journal | Maison d\'Orient Pakistan')
@section('meta_description', 'Delve into the artisanal secrets of Dehn al Oud, French-Oriental maceration, fragrance layering, and longevity tips in Pakistan’s climate.')

@section('content')

<!-- Blog Hero Banner -->
<section class="relative py-16 md:py-24 bg-[#0A0405] border-b border-[#C9A24B]/20 overflow-hidden">
    <div class="absolute inset-0 bg-radial-gradient opacity-25 pointer-events-none"></div>
    <div class="container relative z-10 text-center">
        <!-- Breadcrumbs Component -->
        <x-breadcrumbs :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Fragrance Chronicles']
        ]" />

        <span class="inline-block text-[11px] uppercase tracking-[0.3em] text-[#C9A24B] mb-2 font-medium">THE ARTISANAL JOURNAL</span>
        <h1 class="font-serif text-3xl md:text-5xl lg:text-6xl text-[#F5EFE6] mb-4 font-normal tracking-wide">
            Olfactory Chronicles
        </h1>
        <p class="max-w-2xl mx-auto text-[#F5EFE6]/70 text-sm md:text-base font-light leading-relaxed">
            Essays on rare Cambodian agarwood distillations, maceration techniques, seasonal wear in Pakistan, and the art of Extrait layering.
        </p>
    </div>
</section>

<!-- Blog List & Featured Article -->
<section class="py-16 bg-[#080304]">
    <div class="container">
        
        <!-- Featured Article Spotlight -->
        @if($featuredBlog)
            <div class="mb-16 bg-[#0D0507] border border-[#C9A24B]/35 rounded-lg overflow-hidden shadow-2xl group hover:border-[#C9A24B]/70 transition-all duration-300">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">
                    <div class="lg:col-span-7 relative h-72 lg:h-auto overflow-hidden bg-[#14080B]">
                        <img 
                            src="{{ asset($featuredBlog->cover_image ?? 'assets/images/perfumes/blog_oud_guide.svg') }}" 
                            alt="{{ $featuredBlog->title }}" 
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700"
                        >
                        <div class="absolute top-4 left-4 bg-[#4A0E17] text-[#F5EFE6] border border-[#C9A24B]/40 px-3 py-1 text-[10px] font-semibold uppercase tracking-widest rounded">
                            FEATURED CHRONICLE
                        </div>
                    </div>

                    <div class="lg:col-span-5 p-8 lg:p-12 flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3 text-xs text-[#C9A24B]">
                                <span><i class="far fa-calendar-alt mr-1"></i> {{ $featuredBlog->published_at ? \Carbon\Carbon::parse($featuredBlog->published_at)->format('F d, Y') : 'Featured' }}</span>
                                <span>&bull;</span>
                                <span><i class="far fa-clock mr-1"></i> {{ $featuredBlog->reading_time_min ?? 5 }} MIN READ</span>
                            </div>

                            <h2 class="font-serif text-2xl lg:text-3xl text-[#F5EFE6] leading-snug group-hover:text-[#C9A24B] transition-colors">
                                <a href="{{ route('blogs.show', $featuredBlog->slug) }}">
                                    {{ $featuredBlog->title }}
                                </a>
                            </h2>

                            <p class="text-sm text-[#F5EFE6]/70 line-clamp-3 leading-relaxed">
                                {{ $featuredBlog->summary ?? \Illuminate\Support\Str::limit(strip_tags($featuredBlog->content), 160) }}
                            </p>
                        </div>

                        <div class="pt-6 mt-6 border-t border-[#C9A24B]/15 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-[#C9A24B]/20 border border-[#C9A24B]/40 flex items-center justify-center text-[#C9A24B] text-xs">
                                    <i class="fas fa-feather-alt"></i>
                                </div>
                                <span class="text-xs text-[#F5EFE6]/80">{{ $featuredBlog->author_name ?? 'Master Parfumeur' }}</span>
                            </div>

                            <a href="{{ route('blogs.show', $featuredBlog->slug) }}" class="text-xs uppercase tracking-widest text-[#C9A24B] font-semibold flex items-center space-x-2 group-hover:translate-x-1 transition-transform">
                                <span>Read Chronicle</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($blogs as $blog)
                <article class="bg-[#0C0507] border border-[#C9A24B]/20 rounded-lg overflow-hidden flex flex-col group hover:border-[#C9A24B]/50 transition-all duration-300">
                    <div class="relative h-56 overflow-hidden bg-[#120709]">
                        <img 
                            src="{{ asset($blog->cover_image ?? 'assets/images/perfumes/blog_oud_guide.svg') }}" 
                            alt="{{ $blog->title }}" 
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                        >
                        <div class="absolute top-3 right-3 bg-black/60 backdrop-blur-sm px-2.5 py-1 text-[10px] text-[#C9A24B] border border-[#C9A24B]/30 rounded">
                            {{ $blog->category_name ?? 'Olfactory Art' }}
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center space-x-2 text-[11px] text-[#F5EFE6]/50">
                                <span>{{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('M d, Y') : 'Recent' }}</span>
                                <span>&bull;</span>
                                <span>{{ $blog->reading_time_min ?? 4 }} min read</span>
                            </div>

                            <h3 class="font-serif text-lg text-[#F5EFE6] leading-snug group-hover:text-[#C9A24B] transition-colors">
                                <a href="{{ route('blogs.show', $blog->slug) }}">
                                    {{ $blog->title }}
                                </a>
                            </h3>

                            <p class="text-xs text-[#F5EFE6]/60 line-clamp-3 leading-relaxed">
                                {{ $blog->summary ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 120) }}
                            </p>
                        </div>

                        <div class="pt-4 mt-4 border-t border-[#C9A24B]/10 flex items-center justify-between text-xs">
                            <span class="text-[#F5EFE6]/50">{{ $blog->author_name ?? 'Maison d\'Orient' }}</span>
                            <a href="{{ route('blogs.show', $blog->slug) }}" class="text-[#C9A24B] hover:underline font-medium">
                                Read Full Article &rarr;
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $blogs->links() }}
        </div>

    </div>
</section>

@endsection
