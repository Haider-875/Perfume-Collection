@extends('admin.layouts.admin')

@section('title', 'Categories & Collections')
@section('page_title', 'Categories & Collections')
@section('page_subtitle', 'Curate boutique fragrance classifications (Extrait, Men, Women, Unisex, Discovery Sets)')

@section('header_actions')
<button type="button" class="admin-btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal" onclick="openCreateCategoryModal()">
    <i class="fa-solid fa-plus"></i>
    <span>Add New Category</span>
</button>
@endsection

@section('content')
<div>
    <!-- Table Container Card with Prominent Action Header -->
    <div class="admin-card">
        <div class="p-3 p-sm-4 border-bottom bg-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-layer-group text-primary"></i>
                    <span>Fragrance Categories & Collections</span>
                </h5>
                <small class="text-muted">Total {{ $categories->count() }} categories configured in your boutique</small>
            </div>
            <button type="button" class="admin-btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal" onclick="openCreateCategoryModal()">
                <i class="fa-solid fa-plus"></i>
                <span>Add New Category</span>
            </button>
        </div>

        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">Imagery</th>
                        <th>Category Name</th>
                        <th>Storefront Route</th>
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
                                    <small class="text-muted d-block text-truncate" style="max-width: 320px; font-size: 0.78rem;">
                                        {{ $category->description }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('collections.show', $category->slug) }}" target="_blank" 
                                   class="font-monospace text-primary text-decoration-none small d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
                                    <span>/collections/{{ $category->slug }}</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.7rem;"></i>
                                </a>
                            </td>
                            <td>
                                @if($category->badge_text)
                                    <span class="admin-badge admin-badge-warning" style="font-size: 0.72rem;">
                                        <i class="fa-solid fa-tag"></i> {{ $category->badge_text }}
                                    </span>
                                @else
                                    <span class="text-muted small">&mdash;</span>
                                @endif
                            </td>
                            <td class="text-end font-monospace">
                                <span class="fw-bold text-dark fs-6">{{ $category->products_count }}</span>
                                <small class="text-muted" style="font-size: 0.75rem;">items</small>
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
                                            onclick='openEditCategoryModal(@json($category))'
                                            class="admin-action-btn admin-action-edit" 
                                            title="Edit Category">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    @if($category->products_count === 0)
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" onsubmit="return confirm('Delete this category?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-action-btn admin-action-delete" title="Delete Category">
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
                                <div class="py-4">
                                    <i class="fa-solid fa-layer-group fs-1 text-muted opacity-50 mb-3 d-block"></i>
                                    <h5 class="fw-semibold text-dark mb-1">No Categories Found</h5>
                                    <p class="small text-muted mb-3">Begin by curating your first fragrance category.</p>
                                    <button type="button" class="admin-btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>Add New Category</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap 5: Add New Category Modal -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header border-bottom py-3 px-4 bg-light">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" id="createCategoryModalLabel">
                        <i class="fa-solid fa-plus text-primary"></i>
                        <span>Add New Category</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 d-flex flex-column gap-3">
                        <div>
                            <label class="form-label text-uppercase text-muted small fw-bold mb-1">Category Name *</label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Attars, Men's Collection, Private Reserve">
                        </div>

                        <div>
                            <label class="form-label text-uppercase text-muted small fw-bold mb-1">Description</label>
                            <textarea name="description" rows="2" class="form-control" placeholder="Brief fragrance character summary..."></textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label text-uppercase text-muted small fw-bold mb-1">Badge Text</label>
                                <input type="text" name="badge_text" class="form-control" placeholder="e.g. ULTRA LUXURY, 25% OFF">
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label text-uppercase text-muted small fw-bold mb-1">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="0" placeholder="0">
                            </div>
                        </div>

                        <div>
                            <label class="form-label text-uppercase text-muted small fw-bold mb-1">Category Image</label>
                            <input type="file" name="image" accept="image/*" class="form-control">
                            <small class="text-muted" style="font-size: 11px;">Recommended: JPG, PNG, WEBP square or banner image (max 2MB)</small>
                        </div>

                        <div class="pt-2 border-top">
                            <label class="form-check d-flex align-items-center gap-2 cursor-pointer mb-0">
                                <input type="checkbox" name="is_active" value="1" checked class="form-check-input mt-0">
                                <span class="small fw-semibold text-dark">Active & Visible on Storefront</span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer border-top py-2.5 px-4 bg-light d-flex justify-content-end gap-2">
                        <button type="button" class="admin-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="admin-btn-primary">
                            <i class="fa-solid fa-check"></i>
                            <span>Save Category</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5: Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header border-bottom py-3 px-4 bg-light">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" id="editCategoryModalLabel">
                        <i class="fa-solid fa-pen-to-square text-primary"></i>
                        <span>Edit Category</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="editCategoryForm" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4 d-flex flex-column gap-3">
                        <div>
                            <label class="form-label text-uppercase text-muted small fw-bold mb-1">Category Name *</label>
                            <input type="text" name="name" id="editCategoryName" class="form-control" required>
                        </div>

                        <div>
                            <label class="form-label text-uppercase text-muted small fw-bold mb-1">Description</label>
                            <textarea name="description" id="editCategoryDescription" rows="2" class="form-control"></textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label text-uppercase text-muted small fw-bold mb-1">Badge Text</label>
                                <input type="text" name="badge_text" id="editCategoryBadge" class="form-control">
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label text-uppercase text-muted small fw-bold mb-1">Sort Order</label>
                                <input type="number" name="sort_order" id="editCategorySortOrder" class="form-control" value="0">
                            </div>
                        </div>

                        <div>
                            <label class="form-label text-uppercase text-muted small fw-bold mb-1">Update Image (optional)</label>
                            <input type="file" name="image" accept="image/*" class="form-control">
                            <small class="text-muted" style="font-size: 11px;">Leave empty to keep the existing image.</small>
                        </div>

                        <div class="pt-2 border-top">
                            <label class="form-check d-flex align-items-center gap-2 cursor-pointer mb-0">
                                <input type="checkbox" name="is_active" value="1" id="editCategoryActive" class="form-check-input mt-0">
                                <span class="small fw-semibold text-dark">Active & Visible on Storefront</span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer border-top py-2.5 px-4 bg-light d-flex justify-content-end gap-2">
                        <button type="button" class="admin-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="admin-btn-primary">
                            <i class="fa-solid fa-check"></i>
                            <span>Update Category</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openCreateCategoryModal() {
        const modalEl = document.getElementById('createCategoryModal');
        if (window.bootstrap && bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        }
    }

    function openEditCategoryModal(category) {
        document.getElementById('editCategoryForm').action = '/admin/categories/' + category.id;
        document.getElementById('editCategoryName').value = category.name || '';
        document.getElementById('editCategoryDescription').value = category.description || '';
        document.getElementById('editCategoryBadge').value = category.badge_text || '';
        document.getElementById('editCategorySortOrder').value = category.sort_order || 0;
        document.getElementById('editCategoryActive').checked = !!category.is_active;

        const modalEl = document.getElementById('editCategoryModal');
        if (window.bootstrap && bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        }
    }
</script>
@endsection
