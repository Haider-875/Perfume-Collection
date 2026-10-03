@extends('admin.layouts.admin')

@section('title', 'Edit Chronicle')
@section('page_title', 'Modify Chronicle: ' . $blog->title)
@section('page_subtitle', 'Slug: /blogs/' . $blog->slug)

@section('header_actions')
<div class="flex items-center gap-2">
    <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank" class="px-3 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-gold border border-brand-border/60 flex items-center gap-1.5 transition">
        <i class="fa-solid fa-eye"></i>
        <span>Live Preview</span>
    </a>
    <a href="{{ route('admin.blogs.index') }}" class="px-3 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-text border border-brand-border/60 flex items-center gap-1.5 transition">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Journal List</span>
    </a>
</div>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.blogs.update', $blog->id) }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Chronicle Content
                </h3>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Article Title *</label>
                    <input type="text" name="title" value="{{ old('title', $blog->title) }}" required
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Category / Topic *</label>
                        <input type="text" name="category" value="{{ old('category', $blog->category) }}" required
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Estimated Read Time</label>
                        <input type="text" name="read_time" value="{{ old('read_time', $blog->read_time) }}"
                               class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    </div>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Short Excerpt / Lead Summary *</label>
                    <textarea name="excerpt" rows="2" required
                              class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('excerpt', $blog->excerpt) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Full Editorial Narrative *</label>
                    <textarea name="content" rows="12" required
                              class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">{{ old('content', $blog->content) }}</textarea>
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
                    <input type="text" name="author_name" value="{{ old('author_name', $blog->author_name) }}"
                           class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" {{ $blog->is_published ? 'checked' : '' }} class="rounded bg-brand-black border-brand-border text-brand-gold focus:ring-0">
                        <span class="text-xs text-brand-text font-medium">Published on Journal</span>
                    </label>
                </div>
            </div>

            <!-- Header Cover Image -->
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
                <h3 class="font-serif text-base font-semibold text-brand-text border-b border-brand-border/40 pb-3">
                    Cover Photography
                </h3>
                @if($blog->image)
                    <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="w-full h-32 object-cover rounded-lg border border-brand-border/40 mb-3">
                @endif
                <div>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-xs text-brand-muted file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-gold file:text-brand-black hover:file:bg-brand-goldLight cursor-pointer">
                </div>
            </div>

            <div class="p-4 bg-brand-surface border border-brand-border/60 rounded-xl">
                <button type="submit" class="w-full gold-btn py-3 rounded-lg text-xs font-semibold uppercase tracking-widest shadow-xl flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Update Chronicle</span>
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
