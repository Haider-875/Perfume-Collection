@extends('admin.layouts.admin')

@section('title', 'Fragrance Vault')
@section('page_title', 'Fragrance Vault & Catalog')
@section('page_subtitle', 'Manage formulation inventory, pricing variants, olfactory notes, and stock levels')

@section('header_actions')
<div class="d-flex align-items-center gap-2 flex-wrap">
    <a href="{{ route('admin.categories.index') }}" class="admin-btn-secondary" title="Manage Fragrance Categories">
        <i class="fa-solid fa-layer-group text-primary"></i>
        <span>Categories</span>
    </a>
    <a href="{{ route('admin.products.sample-csv') }}" class="admin-btn-secondary" title="Download sample CSV template">
        <i class="fa-solid fa-file-csv text-muted"></i>
        <span class="d-none d-sm-inline">Sample CSV</span>
    </a>
    <a href="{{ route('admin.products.import') }}" class="admin-btn-secondary" title="Bulk import formulations">
        <i class="fa-solid fa-file-import text-muted"></i>
        <span class="d-none d-sm-inline">Import CSV</span>
    </a>
    <a href="{{ route('admin.products.export-csv') }}" class="admin-btn-secondary" title="Export catalog to CSV">
        <i class="fa-solid fa-file-export text-muted"></i>
        <span class="d-none d-sm-inline">Export CSV</span>
    </a>
    <a href="{{ route('admin.products.create') }}" class="admin-btn-primary">
        <i class="fa-solid fa-plus"></i>
        <span>Craft Fragrance</span>
    </a>
</div>
@endsection

@section('content')
<!-- Search & Filter Bar -->
<div class="admin-filter-bar">
    <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
        <!-- Search -->
        <div class="lg:col-span-2 position-relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, SKU, or olfactory notes..."
                   class="ps-4">
        </div>

        <!-- Category Filter -->
        <div>
            <select name="category">
                <option value="">All Collections</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Stock Status Filter -->
        <div>
            <select name="stock_status">
                <option value="">All Stock Levels</option>
                <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>In Stock (&gt; 0)</option>
                <option value="low_stock" {{ request('stock_status') === 'low_stock' ? 'selected' : '' }}>Low Stock (&le; 10)</option>
                <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock (0)</option>
            </select>
        </div>

        <!-- Filter Submit & Reset Buttons -->
        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="admin-btn-primary flex-fill">
                <i class="fa-solid fa-filter small"></i>
                <span>Apply Filter</span>
            </button>
            @if(request()->hasAny(['search', 'category', 'stock_status', 'status']))
                <a href="{{ route('admin.products.index') }}" class="admin-btn-reset" title="Clear Filters">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Bulk Action Form & Products Table -->
<form method="POST" action="{{ route('admin.products.bulk') }}" id="bulkForm">
    @csrf
    
    <!-- Table Container Card -->
    <div class="admin-card">
        
        <!-- Bulk Action Header Bar -->
        <div class="px-4 py-2.5 bg-slate-50 border-bottom border-slate-200 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="small text-muted">
                Total in Vault: <strong class="text-dark">{{ $products->total() }}</strong> formulations
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <select name="action" required style="height: 36px; width: 170px; font-size: 13.5px;" class="py-1">
                    <option value="">Bulk Actions...</option>
                    <option value="activate">Set Active</option>
                    <option value="deactivate">Set Draft / Inactive</option>
                    <option value="delete">Delete Selected</option>
                </select>
                <button type="submit" onclick="return confirm('Apply bulk action to selected items?')" 
                        class="admin-btn-secondary" style="height: 36px; font-size: 13.5px; padding: 0 0.85rem;">
                    Apply
                </button>
            </div>
        </div>

        <!-- Responsive Table Wrapper -->
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 44px;" class="text-center">
                            <input type="checkbox" id="selectAll" class="form-check-input mt-0">
                        </th>
                        <th>Fragrance</th>
                        <th>Collection</th>
                        <th>SKU</th>
                        <th class="text-end">Price (PKR)</th>
                        <th class="text-end">Vault Stock</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" style="width: 90px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" class="product-checkbox form-check-input mt-0">
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="admin-thumb-box" 
                                         onclick="window.previewImage('{{ $product->main_image_url }}', '{{ addslashes($product->name) }}')"
                                         title="Click to expand image">
                                        <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" 
                                             class="admin-thumb-img"
                                             onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_signature.jpg') }}';">
                                    </div>
                                    <div class="overflow-hidden">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-dark fw-semibold text-decoration-none d-block text-truncate" style="max-width: 240px;">
                                            {{ $product->name }}
                                        </a>
                                        <small class="text-muted d-block text-truncate" style="font-size: 13px;">
                                            {{ $product->scent_family ?? 'Eau de Parfum' }} &bull; {{ $product->variants->count() }} sizes
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border fw-normal" style="font-size: 13px;">
                                    {{ $product->category->name ?? 'Unassigned' }}
                                </span>
                            </td>
                            <td class="font-monospace small text-muted">{{ $product->sku }}</td>
                            <td class="text-end">
                                <div class="fw-bold text-dark font-monospace">{{ $product->formatted_price }}</div>
                                @if($product->compare_at_price > $product->price)
                                    <small class="text-muted text-decoration-line-through d-block" style="font-size: 13px;">
                                        Rs. {{ number_format($product->compare_at_price, 0) }}
                                    </small>
                                @endif
                            </td>
                            <td class="text-end font-monospace">
                                <span class="fw-semibold {{ $product->stock <= 5 ? ($product->stock == 0 ? 'text-danger' : 'text-warning') : 'text-success' }}">
                                    {{ $product->stock }}
                                </span>
                                <small class="text-muted" style="font-size: 13px;">pcs</small>
                            </td>
                            <td class="text-center">
                                @if($product->is_active)
                                    <span class="admin-badge admin-badge-success">
                                        <i class="fa-solid fa-circle-check small"></i> Active
                                    </span>
                                @else
                                    <span class="admin-badge admin-badge-secondary">
                                        <i class="fa-solid fa-circle small"></i> Draft
                                    </span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex align-items-center gap-1.5">
                                    <a href="{{ route('shop.show', $product->slug) }}" target="_blank" 
                                       class="admin-action-btn admin-action-view" title="Preview on live store">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="admin-action-btn admin-action-edit" title="Edit formulation">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <div class="py-3">
                                    <i class="fa-solid fa-spray-can-sparkles fs-2 text-muted opacity-50 mb-2 d-block"></i>
                                    <h6 class="fw-semibold text-dark mb-1">No formulations found</h6>
                                    <p class="small text-muted mb-3">No fragrances match your filter criteria.</p>
                                    <a href="{{ route('admin.products.create') }}" class="admin-btn-primary">
                                        <i class="fa-solid fa-plus"></i> Craft First Fragrance
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="admin-pagination-bar">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</form>

@endsection

@push('scripts')
<script>
    document.getElementById('selectAll')?.addEventListener('change', function(e) {
        document.querySelectorAll('.product-checkbox').forEach(cb => {
            cb.checked = e.target.checked;
        });
    });
</script>
@endpush
