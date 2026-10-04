@extends('admin.layouts.admin')

@section('title', 'Showcase Slides')
@section('page_title', 'Homepage Showcase & Hero Slides')
@section('page_subtitle', 'Manage rotating editorial carousels, flagship promotions, and campaign banners')

@section('header_actions')
<button type="button" @click="openCreateModal = true" class="admin-btn-primary">
    <i class="fa-solid fa-plus"></i>
    <span>Add Showcase Slide</span>
</button>
@endsection

@section('content')
<div x-data="{ openCreateModal: false, editModal: false, activeSlide: {} }">
    <div class="admin-card">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px;" class="text-center">Order</th>
                        <th style="width: 65px;">Banner</th>
                        <th>Headline & Editorial Hook</th>
                        <th>Badge Text</th>
                        <th>Call to Action</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($slides as $slide)
                        <tr>
                            <td class="text-center font-monospace fw-bold text-muted" style="font-size: 0.8rem;">
                                #{{ $slide->sort_order }}
                            </td>
                            <td>
                                <div class="admin-thumb-box" 
                                     onclick="window.previewImage('{{ $slide->image_url }}', '{{ addslashes($slide->title) }}')"
                                     title="Click to preview slide banner">
                                    <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" 
                                         class="admin-thumb-img"
                                         onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';">
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $slide->title }}</div>
                                @if($slide->subtitle)
                                    <small class="text-muted d-block text-truncate" style="max-width: 280px; font-size: 0.75rem;">
                                        {{ $slide->subtitle }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                @if($slide->badge_text)
                                    <span class="admin-badge admin-badge-warning" style="font-size: 0.65rem;">
                                        {{ $slide->badge_text }}
                                    </span>
                                @else
                                    <span class="text-muted small">&mdash;</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold text-primary small d-block">{{ $slide->cta_text }}</span>
                                <small class="text-muted font-monospace" style="font-size: 0.7rem;">{{ $slide->cta_url }}</small>
                            </td>
                            <td class="text-center">
                                @if($slide->is_active)
                                    <span class="admin-badge admin-badge-success">Active</span>
                                @else
                                    <span class="admin-badge admin-badge-secondary">Disabled</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex align-items-center gap-1.5">
                                    <button type="button" 
                                            @click="activeSlide = {{ json_encode($slide) }}; editModal = true" 
                                            class="admin-action-btn admin-action-edit" title="Edit Slide">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.hero-slides.destroy', $slide->id) }}" onsubmit="return confirm('Delete this slide?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-action-btn admin-action-delete" title="Delete Slide">
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
                                    <i class="fa-solid fa-images fs-2 text-muted opacity-50 mb-2 d-block"></i>
                                    <h6 class="fw-semibold text-dark mb-1">No hero showcase slides found</h6>
                                    <p class="small text-muted mb-3">Add editorial banners to rotate on the homepage hero carousel.</p>
                                    <button type="button" @click="openCreateModal = true" class="admin-btn-primary">
                                        <i class="fa-solid fa-plus"></i> Add Showcase Slide
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Slide Modal -->
    <div x-show="openCreateModal" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/80 backdrop-blur-sm" style="display: none;">
        <div class="bg-white border border-slate-200 rounded-xl shadow-2xl p-4 sm:p-5 w-full max-w-lg space-y-3" @click.outside="openCreateModal = false">
            <div class="d-flex align-items-center justify-content-between border-bottom pb-2.5">
                <h6 class="fw-bold text-dark mb-0">Create Showcase Banner</h6>
                <button type="button" @click="openCreateModal = false" class="btn-close small"></button>
            </div>
            <form method="POST" action="{{ route('admin.hero-slides.store') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Headline / Title *</label>
                    <input type="text" name="title" required placeholder="e.g. The Sovereign Oud Extrait">
                </div>
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Subtitle / Poetic Hook</label>
                    <textarea name="subtitle" rows="2" placeholder="Subtext..."></textarea>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Badge Text</label>
                        <input type="text" name="badge_text" placeholder="NEW LAUNCH">
                    </div>
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Sort Order</label>
                        <input type="number" name="sort_order" value="1">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">CTA Button Text</label>
                        <input type="text" name="cta_text" value="DISCOVER COLLECTION">
                    </div>
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">CTA URL</label>
                        <input type="text" name="cta_url" value="/collections">
                    </div>
                </div>
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Slide Imagery (PNG/WEBP)</label>
                    <input type="file" name="image" class="form-control form-control-sm">
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-3">
                    <label class="form-check-label d-flex align-items-center gap-2 cursor-pointer mb-0">
                        <input type="checkbox" name="is_active" value="1" checked class="form-check-input mt-0">
                        <span class="small fw-semibold text-dark">Active in Carousel</span>
                    </label>
                    <div class="d-flex gap-2">
                        <button type="button" @click="openCreateModal = false" class="admin-btn-secondary">Cancel</button>
                        <button type="submit" class="admin-btn-primary">Save Slide</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Slide Modal -->
    <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/80 backdrop-blur-sm" style="display: none;">
        <div class="bg-white border border-slate-200 rounded-xl shadow-2xl p-4 sm:p-5 w-full max-w-lg space-y-3" @click.outside="editModal = false">
            <div class="d-flex align-items-center justify-content-between border-bottom pb-2.5">
                <h6 class="fw-bold text-dark mb-0">Edit Showcase Slide</h6>
                <button type="button" @click="editModal = false" class="btn-close small"></button>
            </div>
            <form method="POST" :action="'/admin/hero-slides/' + activeSlide.id" enctype="multipart/form-data" class="space-y-3">
                @csrf
                @method('PUT')
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Headline *</label>
                    <input type="text" name="title" :value="activeSlide.title" required>
                </div>
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Subtitle</label>
                    <textarea name="subtitle" rows="2" :value="activeSlide.subtitle"></textarea>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Badge Text</label>
                        <input type="text" name="badge_text" :value="activeSlide.badge_text">
                    </div>
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Sort Order</label>
                        <input type="number" name="sort_order" :value="activeSlide.sort_order">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">CTA Button Text</label>
                        <input type="text" name="cta_text" :value="activeSlide.cta_text">
                    </div>
                    <div class="col-6">
                        <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">CTA URL</label>
                        <input type="text" name="cta_url" :value="activeSlide.cta_url">
                    </div>
                </div>
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Update Imagery</label>
                    <input type="file" name="image" class="form-control form-control-sm">
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-3">
                    <label class="form-check-label d-flex align-items-center gap-2 cursor-pointer mb-0">
                        <input type="checkbox" name="is_active" value="1" :checked="activeSlide.is_active" class="form-check-input mt-0">
                        <span class="small fw-semibold text-dark">Active</span>
                    </label>
                    <div class="d-flex gap-2">
                        <button type="button" @click="editModal = false" class="admin-btn-secondary">Cancel</button>
                        <button type="submit" class="admin-btn-primary">Update Slide</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
