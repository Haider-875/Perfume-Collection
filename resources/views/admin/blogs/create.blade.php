@extends('admin.layouts.admin')

@section('title', 'Write New Chronicle')
@section('page_title', 'Compose Fragrance Chronicle')
@section('page_subtitle', 'Author editorial content, perfumery heritage stories, and scent composition insights')

@section('header_actions')
<a href="{{ route('admin.blogs.index') }}" class="px-4 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-text border border-brand-border/60 flex items-center gap-2 transition">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back to Journal</span>
</a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Chronicle Content
                </h3>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Article Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. The Sacred Art of Cambodian Agarwood Distillation"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    @error('title') <span class="text-rose-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Category / Topic *</label>
                        <input type="text" name="category" value="{{ old('category', 'Heritage & Ingredients') }}" required
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Estimated Read Time</label>
                        <input type="text" name="read_time" value="{{ old('read_time', '5 min read') }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Short Excerpt / Lead Summary *</label>
                    <textarea name="excerpt" rows="2" required placeholder="A brief poetic teaser displayed on blog cards..."
                              class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('excerpt') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Full Editorial Narrative *</label>
                    <textarea name="content" rows="12" required placeholder="Write the complete article with rich historical anecdotes and composition notes..."
                              class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('content') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Publishing Parameters
                </h3>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1">Author Name</label>
                    <input type="text" name="author_name" value="{{ old('author_name', 'Maison Perfumer') }}"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" checked class="rounded bg-brand-black border-brand-border text-brand-gold focus:ring-0">
                        <span class="text-xs text-brand-text font-medium">Publish Immediately</span>
                    </label>
                </div>
            </div>

            <!-- Header Cover Image -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Editorial Cover Photography
                </h3>
                <div>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-xs text-brand-muted file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-gold file:text-brand-black hover:file:bg-brand-goldLight cursor-pointer">
                </div>
            </div>

            <div class="p-4 bg-brand-surface border border-brand-border/60 rounded-xl">
                <button type="submit" class="w-full gold-btn py-3 rounded-lg text-xs font-semibold uppercase tracking-widest shadow-xl flex items-center justify-center gap-2">
                    <i class="fa-solid fa-feather"></i>
                    <span>Publish Chronicle</span>
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
