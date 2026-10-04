@extends('admin.layouts.admin')

@section('title', 'Edit Chronicle')
@section('page_title', 'Modify Chronicle: ' . $blog->title)
@section('page_subtitle', 'Slug: /blogs/' . $blog->slug)

@section('header_actions')
<div class="d-flex align-items-center gap-2 flex-wrap">
    <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank" class="admin-btn-secondary" title="View live article">
        <i class="fa-solid fa-arrow-up-right-from-square"></i>
        <span>Live Preview</span>
    </a>
    <a href="{{ route('admin.blogs.index') }}" class="admin-btn-secondary">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Journal List</span>
    </a>
</div>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.blogs.update', $blog->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Main Form Column -->
        <div class="col-lg-8">
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-newspaper text-primary small"></i>
                        <span>Chronicle Content</span>
                    </h6>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Article Title *</label>
                        <input type="text" name="title" value="{{ old('title', $blog->title) }}" required>
                        @error('title') <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Category / Topic *</label>
                            <input type="text" name="category" value="{{ old('category', $blog->category) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Estimated Read Time</label>
                            <input type="text" name="read_time" value="{{ old('read_time', $blog->read_time) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Short Excerpt / Lead Summary *</label>
                        <textarea name="excerpt" rows="3" required>{{ old('excerpt', $blog->excerpt) }}</textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Full Editorial Narrative *</label>
                        <textarea name="content" rows="12" required>{{ old('content', $blog->content) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            <!-- Publishing Parameters -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0">Publishing Parameters</h6>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Author Name</label>
                        <input type="text" name="author_name" value="{{ old('author_name', $blog->author_name) }}">
                    </div>

                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="is_published" id="isPublishedCheck" value="1" {{ $blog->is_published ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark cursor-pointer" for="isPublishedCheck">
                            Published on Journal
                        </label>
                    </div>
                </div>
            </div>

            <!-- Cover Photography -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center gap-2">
                    <i class="fa-solid fa-camera text-primary small"></i>
                    <h6 class="fw-bold text-dark mb-0">Cover Photography</h6>
                </div>
                <div class="p-4">
                    @if($blog->image)
                        <div class="mb-3 rounded overflow-hidden border">
                            <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="w-100 object-fit-cover" style="height: 140px;" onclick="window.previewImage('{{ $blog->image_url }}', '{{ $blog->title }}')">
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*" class="form-control form-control-sm">
                    <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Leave empty to keep existing cover photo.</small>
                </div>
            </div>

            <!-- Action Button -->
            <div class="admin-card mb-4 p-3 bg-white">
                <button type="submit" class="admin-btn-primary w-100 py-2.5 fs-6">
                    <i class="fa-solid fa-floppy-disk me-1"></i>
                    <span>Update Chronicle</span>
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
