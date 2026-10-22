@extends('admin.layouts.admin')

@section('title', 'Categories & Collections')
@section('page_title', 'Categories & Collections')
@section('page_subtitle', 'Curate boutique fragrance classifications and assign perfumes with one click.')

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
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark border px-3 py-2 fw-semibold" style="font-size: 0.8rem;">
                    <i class="fa-solid fa-spray-can text-primary me-1"></i> Total {{ $allProducts->count() }} Perfumes in Store
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">Imagery</th>
                        <th>Category Name</th>
                        <th>Storefront Route</th>
                        <th>Highlight Badge</th>
                        <th class="text-center" style="width: 180px;">Assigned Perfumes</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        @php
                            $assignedProductIds = $category->products->pluck('id')->toArray();
                        @endphp
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
                                <div class="fw-semibold text-dark fs-6">{{ $category->name }}</div>
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
                            <td class="text-center">
                                <button type="button" 
                                        class="btn btn-sm btn-outline-primary rounded-pill d-inline-flex align-items-center gap-1.5 px-3 py-1 fw-semibold shadow-xs" 
                                        onclick='openAssignPerfumesModal({{ $category->id }}, @json($category->name), @json($assignedProductIds))'
                                        title="Click to add or remove perfumes in {{ $category->name }}">
                                    <i class="fa-solid fa-spray-can text-primary"></i>
                                    <span>{{ count($assignedProductIds) }} Perfumes</span>
                                    <i class="fa-solid fa-pen-to-square ms-1" style="font-size: 0.7rem;"></i>
                                </button>
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
                                            onclick='openAssignPerfumesModal({{ $category->id }}, @json($category->name), @json($assignedProductIds))'
                                            class="admin-action-btn" 
                                            style="background: #e0f2fe; color: #0284c7;"
                                            title="Assign Perfumes">
                                        <i class="fa-solid fa-spray-can"></i>
                                    </button>
                                    <button type="button" 
                                            onclick='openEditCategoryModal(@json($category))'
                                            class="admin-action-btn admin-action-edit" 
                                            title="Edit Category Details">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" onsubmit="return confirm('Are you sure you want to delete category \'{{ addslashes($category->name) }}\'?{{ $category->products_count > 0 ? ' (' . $category->products_count . ' associated fragrances will be unassigned)' : '' }}');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-action-btn admin-action-delete" title="Delete Category">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
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

    <!-- Bootstrap 5: Assign Perfumes to Category Modal -->
    <div class="modal fade" id="assignPerfumesModal" tabindex="-1" aria-labelledby="assignPerfumesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header border-bottom py-3 px-4 bg-light">
                    <div>
                        <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" id="assignPerfumesModalLabel">
                            <i class="fa-solid fa-spray-can text-primary"></i>
                            <span>Assign Perfumes to <span id="assignCategoryNameTitle" class="text-primary"></span></span>
                        </h5>
                        <small class="text-muted">Select or deselect perfumes to include in this category storefront.</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form method="POST" id="assignPerfumesForm" action="">
                    @csrf
                    <div class="modal-body p-3 p-sm-4">
                        <!-- Search & Quick Selection Controls -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                            <div class="position-relative flex-grow-1" style="min-width: 220px;">
                                <i class="fa-solid fa-magnifying-glass position-absolute top-50 translate-middle-y ms-3 text-muted" style="font-size: 0.85rem;"></i>
                                <input type="text" id="assignPerfumeSearch" class="form-control ps-5" placeholder="Search perfumes by name, impression, or SKU..." oninput="filterAssignPerfumesList()">
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleSelectAllPerfumes(true)">Select All</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleSelectAllPerfumes(false)">Deselect All</button>
                                <span id="assignSelectedCountBadge" class="badge bg-primary px-3 py-2 fw-semibold">0 Selected</span>
                            </div>
                        </div>

                        <!-- Scrollable Perfumes List -->
                        <div class="border rounded-3 p-2 bg-light" style="max-height: 420px; overflow-y: auto;">
                            <div class="row g-2" id="assignPerfumesListContainer">
                                @foreach($allProducts as $product)
                                    <div class="col-12 col-md-6 assign-perfume-card-item" 
                                         data-product-id="{{ $product->id }}" 
                                         data-product-name="{{ strtolower($product->name) }}" 
                                         data-product-sku="{{ strtolower($product->sku) }}" 
                                         data-product-impression="{{ strtolower($product->impression_of ?? '') }}">
                                        <label class="d-flex align-items-center gap-2.5 p-2 rounded-3 border bg-white cursor-pointer h-100 transition-all perfume-label-box" for="assign_cb_{{ $product->id }}" style="user-select: none;">
                                            <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" id="assign_cb_{{ $product->id }}" class="form-check-input mt-0 assign-perfume-cb" onchange="updateAssignSelectedCount()">
                                            <img src="{{ asset($product->thumbnail_image) }}" alt="{{ $product->name }}" class="rounded-2 object-fit-cover flex-shrink-0" style="width: 44px; height: 44px; border: 1px solid #e2e8f0;" onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';">
                                            <div class="flex-grow-1 min-w-0" style="font-size: 0.82rem;">
                                                <div class="fw-semibold text-dark text-truncate">{{ $product->name }}</div>
                                                @if($product->impression_of)
                                                    <small class="text-muted d-block text-truncate" style="font-size: 0.73rem;">Impression: {{ $product->impression_of }}</small>
                                                @endif
                                                <div class="d-flex align-items-center gap-2 mt-0.5">
                                                    <span class="badge bg-light text-dark font-monospace border" style="font-size: 0.68rem;">{{ $product->sku }}</span>
                                                    <span class="text-primary fw-semibold" style="font-size: 0.75rem;">PKR {{ number_format($product->price) }}</span>
                                                    @if($product->category)
                                                        <span class="badge bg-secondary-subtle text-secondary" style="font-size: 0.65rem;">{{ $product->category->name }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div id="noAssignPerfumesMatchMsg" class="text-center py-4 text-muted d-none">
                                <i class="fa-solid fa-search fs-3 opacity-50 mb-2 d-block"></i>
                                <span>No perfumes match your search.</span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-top py-2.5 px-4 bg-light d-flex justify-content-between align-items-center">
                        <span class="text-muted small" id="assignModalFooterSummary">Choose perfumes to associate with this category.</span>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="admin-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="admin-btn-primary">
                                <i class="fa-solid fa-check"></i>
                                <span>Save Category Perfumes</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5: Add New Category Modal -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
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
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Attars, Summer Refreshers, Oud Collection">
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

                        <!-- Assign Perfumes Section Right in Create Modal -->
                        <div class="pt-2 border-top">
                            <button type="button" class="btn btn-sm btn-outline-secondary w-100 d-flex align-items-center justify-content-between py-2 px-3 text-start mb-2" data-bs-toggle="collapse" data-bs-target="#createAssignPerfumesCollapse" aria-expanded="false">
                                <span class="fw-semibold text-dark small d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-spray-can text-primary"></i>
                                    <span>Assign Perfumes Now (Optional)</span>
                                </span>
                                <span class="badge bg-primary rounded-pill" id="createSelectedBadge">0 Selected</span>
                            </button>
                            <div class="collapse" id="createAssignPerfumesCollapse">
                                <div class="p-2 border rounded-3 bg-light" style="max-height: 250px; overflow-y: auto;">
                                    <input type="text" id="createPerfumeSearch" class="form-control form-control-sm mb-2" placeholder="Filter perfumes by name, impression, SKU..." oninput="filterCreatePerfumesList()">
                                    <div class="row g-2" id="createPerfumesListContainer">
                                        @foreach($allProducts as $product)
                                            <div class="col-12 col-md-6 create-perfume-card-item" 
                                                 data-product-name="{{ strtolower($product->name) }}" 
                                                 data-product-sku="{{ strtolower($product->sku) }}" 
                                                 data-product-impression="{{ strtolower($product->impression_of ?? '') }}">
                                                <label class="d-flex align-items-center gap-2 p-1.5 rounded-2 border bg-white cursor-pointer h-100 small" style="user-select: none;">
                                                    <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" class="form-check-input mt-0 create-perfume-cb" onchange="updateCreateSelectedCount()">
                                                    <img src="{{ asset($product->thumbnail_image) }}" alt="{{ $product->name }}" class="rounded-1 object-fit-cover flex-shrink-0" style="width: 32px; height: 32px;" onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';">
                                                    <div class="flex-grow-1 min-w-0">
                                                        <div class="fw-semibold text-dark text-truncate" style="font-size: 0.78rem;">{{ $product->name }}</div>
                                                        <span class="text-muted font-monospace" style="font-size: 0.68rem;">{{ $product->sku }}</span>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
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
                        <span>Edit Category Details</span>
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
                    <div class="modal-footer border-top py-2.5 px-4 bg-light d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1.5 px-3 py-1.5" id="modalDeleteBtn" onclick="deleteCategoryFromModal()">
                            <i class="fa-solid fa-trash"></i>
                            <span>Delete Category</span>
                        </button>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="admin-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="admin-btn-primary">
                                <i class="fa-solid fa-check"></i>
                                <span>Update Category</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="modalDeleteForm" method="POST" action="" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    let currentEditingCategory = null;

    function openCreateCategoryModal() {
        const modalEl = document.getElementById('createCategoryModal');
        if (window.bootstrap && bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        }
    }

    function openEditCategoryModal(category) {
        currentEditingCategory = category;
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

    function deleteCategoryFromModal() {
        if (!currentEditingCategory) return;
        const count = currentEditingCategory.products_count || 0;
        const warn = count > 0 ? ` (${count} associated fragrances will be unassigned)` : '';
        if (confirm(`Are you sure you want to delete category "${currentEditingCategory.name}"?${warn}`)) {
            const form = document.getElementById('modalDeleteForm');
            form.action = '/admin/categories/' + currentEditingCategory.id;
            form.submit();
        }
    }

    // Assign Perfumes Modal Controller
    function openAssignPerfumesModal(categoryId, categoryName, currentProductIds) {
        document.getElementById('assignPerfumesForm').action = '/admin/categories/' + categoryId + '/products';
        document.getElementById('assignCategoryNameTitle').textContent = categoryName;
        document.getElementById('assignPerfumeSearch').value = '';

        const currentIds = Array.isArray(currentProductIds) ? currentProductIds.map(Number) : [];

        const checkboxes = document.querySelectorAll('.assign-perfume-cb');
        checkboxes.forEach(cb => {
            const pid = parseInt(cb.value);
            const isAssigned = currentIds.includes(pid);
            cb.checked = isAssigned;
            
            const card = cb.closest('.assign-perfume-card-item');
            if (card) {
                card.style.display = 'block';
                const label = card.querySelector('.perfume-label-box');
                if (label) {
                    if (isAssigned) {
                        label.style.borderColor = '#0284c7';
                        label.style.backgroundColor = '#f0f9ff';
                    } else {
                        label.style.borderColor = '#e2e8f0';
                        label.style.backgroundColor = '#ffffff';
                    }
                }
            }
        });

        updateAssignSelectedCount();

        const modalEl = document.getElementById('assignPerfumesModal');
        if (window.bootstrap && bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        }
    }

    function updateAssignSelectedCount() {
        const allCbs = document.querySelectorAll('.assign-perfume-cb');
        let selectedCount = 0;
        allCbs.forEach(cb => {
            const label = cb.closest('.perfume-label-box');
            if (cb.checked) {
                selectedCount++;
                if (label) {
                    label.style.borderColor = '#0284c7';
                    label.style.backgroundColor = '#f0f9ff';
                }
            } else {
                if (label) {
                    label.style.borderColor = '#e2e8f0';
                    label.style.backgroundColor = '#ffffff';
                }
            }
        });

        const badge = document.getElementById('assignSelectedCountBadge');
        if (badge) {
            badge.textContent = `${selectedCount} Selected`;
        }
        const summary = document.getElementById('assignModalFooterSummary');
        if (summary) {
            summary.textContent = `${selectedCount} perfume(s) currently selected for this category.`;
        }
    }

    function toggleSelectAllPerfumes(shouldSelect) {
        const visibleCards = document.querySelectorAll('.assign-perfume-card-item');
        visibleCards.forEach(card => {
            if (card.style.display !== 'none') {
                const cb = card.querySelector('.assign-perfume-cb');
                if (cb) {
                    cb.checked = shouldSelect;
                }
            }
        });
        updateAssignSelectedCount();
    }

    function filterAssignPerfumesList() {
        const query = (document.getElementById('assignPerfumeSearch').value || '').toLowerCase().trim();
        const cards = document.querySelectorAll('.assign-perfume-card-item');
        let matchCount = 0;

        cards.forEach(card => {
            const name = card.getAttribute('data-product-name') || '';
            const sku = card.getAttribute('data-product-sku') || '';
            const impression = card.getAttribute('data-product-impression') || '';

            if (!query || name.includes(query) || sku.includes(query) || impression.includes(query)) {
                card.style.display = 'block';
                matchCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const noMatch = document.getElementById('noAssignPerfumesMatchMsg');
        if (noMatch) {
            noMatch.classList.toggle('d-none', matchCount > 0);
        }
    }

    // Create Modal Perfumes Filter & Counter
    function updateCreateSelectedCount() {
        const selected = document.querySelectorAll('.create-perfume-cb:checked').length;
        const badge = document.getElementById('createSelectedBadge');
        if (badge) {
            badge.textContent = `${selected} Selected`;
        }
    }

    function filterCreatePerfumesList() {
        const query = (document.getElementById('createPerfumeSearch').value || '').toLowerCase().trim();
        const cards = document.querySelectorAll('.create-perfume-card-item');
        cards.forEach(card => {
            const name = card.getAttribute('data-product-name') || '';
            const sku = card.getAttribute('data-product-sku') || '';
            const impression = card.getAttribute('data-product-impression') || '';
            if (!query || name.includes(query) || sku.includes(query) || impression.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endsection
