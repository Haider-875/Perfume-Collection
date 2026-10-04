@extends('admin.layouts.admin')

@section('title', 'Luxury Bundles')
@section('page_title', 'Luxury Bundles & Coffrets')
@section('page_subtitle', 'Curate exclusive multi-bottle collections, pairing sets, and automatic savings bundles')

@section('header_actions')
<a href="{{ route('admin.bundles.create') }}" class="admin-btn-primary">
    <i class="fa-solid fa-plus"></i>
    <span>Craft New Bundle</span>
</a>
@endsection

@section('content')
<div class="admin-card">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Bundle Coffret</th>
                    <th>Included Fragrances</th>
                    <th class="text-end">Original Price</th>
                    <th class="text-end">Bundle Price</th>
                    <th class="text-end">Patron Savings</th>
                    <th class="text-center">Status</th>
                    <th class="text-end" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bundles as $bundle)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="admin-thumb-box" 
                                     onclick="window.previewImage('{{ $bundle->image_url }}', '{{ addslashes($bundle->name) }}')"
                                     title="Click to preview bundle image">
                                    <img src="{{ $bundle->image_url }}" alt="{{ $bundle->name }}" 
                                         class="admin-thumb-img"
                                         onerror="this.onerror=null; this.src='{{ asset('assets/images/perfumes/prod_discovery_coffret.jpg') }}';">
                                </div>
                                <div class="overflow-hidden">
                                    <div class="fw-semibold text-dark text-truncate" style="max-width: 220px;">{{ $bundle->name }}</div>
                                    <small class="font-monospace text-muted d-block" style="font-size: 0.72rem;">{{ $bundle->sku }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-medium text-dark small">{{ $bundle->items->count() }} Fragrances</div>
                            <small class="text-muted d-block text-truncate" style="max-width: 240px; font-size: 0.72rem;">
                                {{ $bundle->items->map(fn($i) => $i->product->name ?? 'Fragrance')->implode(', ') }}
                            </small>
                        </td>
                        <td class="text-end font-monospace">
                            <span class="text-muted text-decoration-line-through small">{{ $bundle->formatted_original_price }}</span>
                        </td>
                        <td class="text-end font-monospace">
                            <span class="fw-bold text-dark fs-6">{{ $bundle->formatted_bundle_price }}</span>
                        </td>
                        <td class="text-end">
                            <span class="admin-badge admin-badge-success" style="font-size: 0.65rem;">
                                Save {{ $bundle->formatted_savings }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($bundle->is_active)
                                <span class="admin-badge admin-badge-success">Active</span>
                            @else
                                <span class="admin-badge admin-badge-secondary">Disabled</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex align-items-center gap-1.5">
                                <a href="{{ route('admin.bundles.edit', $bundle->id) }}" class="admin-action-btn admin-action-edit" title="Edit Bundle">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.bundles.destroy', $bundle->id) }}" onsubmit="return confirm('Delete this bundle?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-action-btn admin-action-delete" title="Delete Bundle">
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
                                <i class="fa-solid fa-gift fs-2 text-muted opacity-50 mb-2 d-block"></i>
                                <h6 class="fw-semibold text-dark mb-1">No bundles created yet</h6>
                                <p class="small text-muted mb-3">Curate multi-bottle coffrets and automatic gift pairings.</p>
                                <a href="{{ route('admin.bundles.create') }}" class="admin-btn-primary">
                                    <i class="fa-solid fa-plus"></i> Craft First Bundle
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($bundles, 'links') && $bundles->hasPages())
        <div class="admin-pagination-bar">
            {{ $bundles->links() }}
        </div>
    @endif
</div>
@endsection
