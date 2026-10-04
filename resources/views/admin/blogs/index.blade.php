@extends('admin.layouts.admin')

@section('title', 'Fragrance Journal')
@section('page_title', 'Fragrance Chronicles & Olfactory Journal')
@section('page_subtitle', 'Editorial stories, perfumery heritage guides, and seasonal scent chronicles')

@section('header_actions')
<a href="{{ route('admin.blogs.create') }}" class="admin-btn-primary">
    <i class="fa-solid fa-plus"></i>
    <span>Write New Chronicle</span>
</a>
@endsection

@section('content')
<div class="admin-card">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Chronicle Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th class="text-center">Read Time</th>
                    <th class="text-center">Status</th>
                    <th>Published Date</th>
                    <th class="text-end" style="width: 110px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="admin-thumb-box" 
                                     onclick="window.previewImage('{{ $blog->image_url }}', '{{ addslashes($blog->title) }}')"
                                     title="Click to preview article banner">
                                    <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" 
                                         class="admin-thumb-img-cover"
                                         onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';">
                                </div>
                                <div class="overflow-hidden">
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-dark fw-semibold text-decoration-none d-block text-truncate" style="max-width: 280px;">
                                        {{ $blog->title }}
                                    </a>
                                    <small class="text-muted font-monospace d-block" style="font-size: 0.72rem;">/blogs/{{ $blog->slug }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border fw-normal" style="font-size: 0.75rem;">
                                {{ $blog->category }}
                            </span>
                        </td>
                        <td class="small text-dark">{{ $blog->author_name }}</td>
                        <td class="text-center font-monospace small text-muted">{{ $blog->read_time }}</td>
                        <td class="text-center">
                            @if($blog->is_published)
                                <span class="admin-badge admin-badge-success">Published</span>
                            @else
                                <span class="admin-badge admin-badge-secondary">Draft</span>
                            @endif
                        </td>
                        <td class="small text-muted font-monospace" style="font-size: 0.75rem;">
                            {{ $blog->published_at ? $blog->published_at->format('d M Y') : 'Unpublished' }}
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex align-items-center gap-1.5">
                                <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank" 
                                   class="admin-action-btn admin-action-view" title="Preview Article">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" 
                                   class="admin-action-btn admin-action-edit" title="Edit Article">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.blogs.destroy', $blog->id) }}" onsubmit="return confirm('Delete this chronicle?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-action-btn admin-action-delete" title="Delete Article">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <div class="py-3">
                                <i class="fa-solid fa-newspaper fs-2 text-muted opacity-50 mb-2 d-block"></i>
                                <h6 class="fw-semibold text-dark mb-1">No journal chronicles found</h6>
                                <p class="small text-muted mb-3">Share scent stories, notes breakdowns, and perfumery knowledge.</p>
                                <a href="{{ route('admin.blogs.create') }}" class="admin-btn-primary">
                                    <i class="fa-solid fa-plus"></i> Write First Chronicle
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($blogs->hasPages())
        <div class="admin-pagination-bar">
            {{ $blogs->links() }}
        </div>
    @endif
</div>
@endsection
