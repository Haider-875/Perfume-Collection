@extends('admin.layouts.admin')

@section('title', 'Collections & Categories')
@section('page_title', 'Collections & Fragrance Classifications')
@section('page_subtitle', 'Curate boutique collections (Exclusive, Men, Women, Unisex, Discovery Sets)')

@section('header_actions')
<button type="button" @click="openCreateModal = true" class="admin-btn-primary">
    <i class="fa-solid fa-plus"></i>
    <span>New Collection</span>
</button>
@endsection

@section('content')
<div x-data="{ openCreateModal: false, editModal: false, activeCat: {} }">
    
    <!-- Table Container Card -->
    <div class="admin-card">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">Imagery</th>
                        <th>Collection Name</th>
                        <th>Boutique Route</th>
                        <th>Highlight Badge</th>
                        <th class="text-end">Formulations</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <div class="admin-thumb-box" 
                                     onclick="window.previewImage('{{ asset($category->image) }}', '{{ addslashes($category->name) }}')"
                                     title="Click to preview image">
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" 
                                         class="admin-thumb-img"
                                         onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';">
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $category->name }}</div>
                                @if($category->description)
                                    <small class="text-muted d-block text-truncate" style="max-width: 300px; font-size: 0.75rem;">
                                        {{ $category->description }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('collections.show', $category->slug) }}" target="_blank" 
                                   class="font-monospace text-primary text-decoration-none small" style="font-size: 0.75rem;">
                                    /collections/{{ $category->slug }}
                                    <i class="fa-solid fa-arrow-up-right-from-square ms-1" style="font-size: 0.65rem;"></i>
                                </a>
                            </td>
                            <td>
                                @if($category->badge_text)
                                    <span class="admin-badge admin-badge-warning" style="font-size: 0.65rem;">
                                        <i class="fa-solid fa-tag"></i> {{ $category->badge_text }}
                                    </span>
                                @else
                                    <span class="text-muted small">&mdash;</span>
                                @endif
                            </td>
                            <td class="text-end font-monospace">
                                <span class="fw-bold text-dark fs-6">{{ $category->products_count }}</span>
                                <small class="text-muted" style="font-size: 0.7rem;">items</small>
                            </td>
                            <td class="text-center">
                                @if($category->is_active)
                                    <span class="admin-badge admin-badge-success">Active</span>
                                @else
                                    <span class="admin-badge admin-badge-secondary">Draft</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex align-items-center gap-1.5">
                                    <button type="button" 
                                            @click="activeCat = {{ json_encode($category) }}; editModal = true" 
                                            class="admin-action-btn admin-action-edit" title="Edit Collection">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    @if($category->products_count === 0)
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" onsubmit="return confirm('Delete this empty category?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-action-btn admin-action-delete" title="Delete Collection">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="py-3">
                                    <i class="fa-solid fa-layer-group fs-2 text-muted opacity-50 mb-2 d-block"></i>
                                    <h6 class="fw-semibold text-dark mb-1">No collections found</h6>
                                    <p class="small text-muted mb-3">Begin by curating your first fragrance collection.</p>
                                    <button type="button" @click="openCreateModal = true" class="admin-btn-primary">
                                        <i class="fa-solid fa-plus"></i> New Collection
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Modal -->
    <div x-show="openCreateModal" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/80 backdrop-blur-sm" style="display: none;">
        <div class="bg-white border border-slate-200 rounded-xl shadow-2xl p-4 sm:p-5 w-full max-w-md space-y-3" @click.outside="openCreateModal = false">
            <div class="d-flex align-items-center justify-content-between border-bottom pb-2.5">
                <h6 class="fw-bold text-dark mb-0">Craft New Fragrance Collection</h6>
                <button type="button" @click="openCreateModal = false" class="btn-close small"></button>
            </div>
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Collection Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Exclusive Edition">
                </div>
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Description</label>
                    <textarea name="description" rows="2" placeholder="Poetic summary..."></textarea>
                </div>
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Badge Text</label>
                    <input type="text" name="badge_text" placeholder="e.g. ULTRA LUXURY">
                </div>
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Collection Imagery</label>
                    <input type="file" name="image" class="form-control form-control-sm">
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-3">
                    <label class="form-check-label d-flex align-items-center gap-2 cursor-pointer mb-0">
                        <input type="checkbox" name="is_active" value="1" checked class="form-check-input mt-0">
                        <span class="small fw-semibold text-dark">Active on Store</span>
                    </label>
                    <div class="d-flex gap-2">
                        <button type="button" @click="openCreateModal = false" class="admin-btn-secondary">Cancel</button>
                        <button type="submit" class="admin-btn-primary">Save Collection</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/80 backdrop-blur-sm" style="display: none;">
        <div class="bg-white border border-slate-200 rounded-xl shadow-2xl p-4 sm:p-5 w-full max-w-md space-y-3" @click.outside="editModal = false">
            <div class="d-flex align-items-center justify-content-between border-bottom pb-2.5">
                <h6 class="fw-bold text-dark mb-0">Edit Collection</h6>
                <button type="button" @click="editModal = false" class="btn-close small"></button>
            </div>
            <form method="POST" :action="'/admin/categories/' + activeCat.id" enctype="multipart/form-data" class="space-y-3">
                @csrf
                @method('PUT')
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Collection Name *</label>
                    <input type="text" name="name" :value="activeCat.name" required>
                </div>
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Description</label>
                    <textarea name="description" rows="2" :value="activeCat.description"></textarea>
                </div>
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Badge Text</label>
                    <input type="text" name="badge_text" :value="activeCat.badge_text">
                </div>
                <div>
                    <label class="form-label small text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Update Imagery</label>
                    <input type="file" name="image" class="form-control form-control-sm">
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-3">
                    <label class="form-check-label d-flex align-items-center gap-2 cursor-pointer mb-0">
                        <input type="checkbox" name="is_active" value="1" :checked="activeCat.is_active" class="form-check-input mt-0">
                        <span class="small fw-semibold text-dark">Active on Store</span>
                    </label>
                    <div class="d-flex gap-2">
                        <button type="button" @click="editModal = false" class="admin-btn-secondary">Cancel</button>
                        <button type="submit" class="admin-btn-primary">Update Collection</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
