@extends('admin.layouts.admin')

@section('title', 'Fragrance Journal')
@section('page_title', 'Fragrance Chronicles & Olfactory Journal')
@section('page_subtitle', 'Editorial stories, perfumery heritage guides, and seasonal scent chronicles')

@section('header_actions')
<a href="{{ route('admin.blogs.create') }}" class="gold-btn px-4 py-2 rounded-lg text-xs flex items-center gap-2 shadow-lg">
    <i class="fa-solid fa-plus"></i>
    <span>Write New Chronicle</span>
</a>
@endsection

@section('content')
<div class="bg-brand-surface border border-brand-border/60 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-brand-muted">
            <thead class="bg-brand-card/70 uppercase tracking-wider text-[10px] text-brand-gold/80 border-b border-brand-border/50">
                <tr>
                    <th class="px-4 py-3">Chronicle Title</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Author</th>
                    <th class="px-4 py-3">Read Time</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Published Date</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-border/30">
                @forelse($blogs as $blog)
                    <tr class="hover:bg-brand-card/30 transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="w-10 h-10 object-cover rounded-lg bg-brand-black border border-brand-border/40">
                                <div>
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-brand-text hover:text-brand-gold font-medium block truncate max-w-[280px]">
                                        {{ $blog->title }}
                                    </a>
                                    <span class="text-[10px] text-brand-muted font-mono">/blogs/{{ $blog->slug }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3"><span class="text-brand-gold">{{ $blog->category }}</span></td>
                        <td class="px-4 py-3">{{ $blog->author_name }}</td>
                        <td class="px-4 py-3">{{ $blog->read_time }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded text-[10px] uppercase font-semibold
                                {{ $blog->is_published ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/30' : 'bg-brand-card text-brand-muted' }}">
                                {{ $blog->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-[11px]">{{ $blog->published_at ? $blog->published_at->format('d M Y') : 'Unpublished' }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank" class="w-7 h-7 rounded bg-brand-card hover:bg-brand-border text-brand-muted flex items-center justify-center transition">
                                    <i class="fa-solid fa-eye text-[10px]"></i>
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="w-7 h-7 rounded bg-brand-card hover:bg-brand-border text-brand-gold flex items-center justify-center transition">
                                    <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.blogs.destroy', $blog->id) }}" onsubmit="return confirm('Delete this chronicle?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-7 h-7 rounded bg-brand-card hover:bg-rose-950/40 text-brand-muted hover:text-rose-400 flex items-center justify-center transition">
                                        <i class="fa-solid fa-trash text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-brand-muted">No journal chronicles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($blogs->hasPages())
        <div class="px-5 py-3 border-t border-brand-border/40 bg-brand-card/20">
            {{ $blogs->links() }}
        </div>
    @endif
</div>
@endsection
