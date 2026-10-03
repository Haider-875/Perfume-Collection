@extends('admin.layouts.admin')

@section('title', 'Fragrance Vault')
@section('page_title', 'Fragrance Vault & Catalog')
@section('page_subtitle', 'Manage formulation inventory, pricing variants, olfactory notes, and stock levels')

@section('header_actions')
<div class="flex items-center gap-2">
    <a href="{{ route('admin.products.sample-csv') }}" class="px-3 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-muted hover:text-brand-text border border-brand-border/60 flex items-center gap-1.5 transition">
        <i class="fa-solid fa-file-csv"></i>
        <span>Sample CSV</span>
    </a>
    <a href="{{ route('admin.products.import') }}" class="px-3 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-text border border-brand-border/60 flex items-center gap-1.5 transition">
        <i class="fa-solid fa-file-import"></i>
        <span>Import CSV</span>
    </a>
    <a href="{{ route('admin.products.export-csv') }}" class="px-3 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-text border border-brand-border/60 flex items-center gap-1.5 transition">
        <i class="fa-solid fa-file-export"></i>
        <span>Export CSV</span>
    </a>
    <a href="{{ route('admin.products.create') }}" class="gold-btn px-4 py-2 rounded-lg text-xs flex items-center gap-1.5 shadow-lg">
        <i class="fa-solid fa-plus"></i>
        <span>Craft Fragrance</span>
    </a>
</div>
@endsection

@section('content')
<!-- Search & Filter Bar -->
<div class="bg-brand-surface border border-brand-border/60 rounded-xl p-4">
    <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
        <!-- Search -->
        <div class="lg:col-span-2 relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-brand-muted text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, SKU, or notes..."
                   class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg pl-9 pr-4 py-2 text-xs text-brand-text placeholder-brand-muted/60 focus:outline-none focus:border-brand-gold">
        </div>

        <!-- Category Filter -->
        <div>
            <select name="category" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                <option value="">All Collections</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Stock Status Filter -->
        <div>
            <select name="stock_status" class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3 py-2 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                <option value="">All Stock Levels</option>
                <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>In Stock (&gt; 0)</option>
                <option value="low_stock" {{ request('stock_status') === 'low_stock' ? 'selected' : '' }}>Low Stock (&le; 10)</option>
                <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock (0)</option>
            </select>
        </div>

        <!-- Filter Submit Button -->
        <div class="flex items-center gap-2">
            <button type="submit" class="flex-1 bg-brand-card hover:bg-brand-border text-brand-gold border border-brand-border/60 rounded-lg py-2 text-xs font-medium transition">
                Apply Filter
            </button>
            @if(request()->hasAny(['search', 'category', 'stock_status', 'status']))
                <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-lg bg-brand-black/60 text-brand-muted hover:text-brand-text border border-brand-border/60 text-xs" title="Clear Filters">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Bulk Action Form & Products Table -->
<form method="POST" action="{{ route('admin.products.bulk') }}" id="bulkForm" class="space-y-4">
    @csrf
    
    <!-- Table Container -->
    <div class="bg-brand-surface border border-brand-border/60 rounded-xl overflow-hidden">
        
        <!-- Bulk Action Header Bar -->
        <div class="px-5 py-3 bg-brand-card/40 border-b border-brand-border/40 flex items-center justify-between">
            <div class="flex items-center gap-3 text-xs">
                <span class="text-brand-muted">Total in Vault: <strong class="text-brand-text">{{ $products->total() }}</strong></span>
            </div>
            
            <div class="flex items-center gap-2">
                <select name="action" required class="bg-brand-black/60 border border-brand-border/60 rounded-lg px-2.5 py-1 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                    <option value="">Bulk Actions...</option>
                    <option value="activate">Set Active</option>
                    <option value="deactivate">Set Draft / Inactive</option>
                    <option value="delete">Delete Selected</option>
                </select>
                <button type="submit" onclick="return confirm('Apply bulk action to selected items?')" 
                        class="px-3 py-1 bg-brand-card hover:bg-brand-border text-brand-gold border border-brand-border/60 rounded-lg text-xs font-medium transition">
                    Apply
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-brand-muted">
                <thead class="bg-brand-card/70 uppercase tracking-wider text-[10px] text-brand-gold/80 border-b border-brand-border/50">
                    <tr>
                        <th class="w-10 px-4 py-3 text-center">
                            <input type="checkbox" id="selectAll" class="rounded bg-brand-card border-brand-border text-brand-gold focus:ring-0">
                        </th>
                        <th class="px-4 py-3">Fragrance</th>
                        <th class="px-4 py-3">Collection</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Price (PKR)</th>
                        <th class="px-4 py-3">Vault Stock</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-border/30">
                    @forelse($products as $product)
                        <tr class="hover:bg-brand-card/30 transition">
                            <td class="px-4 py-3 text-center">
                                <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" class="product-checkbox rounded bg-brand-card border-brand-border text-brand-gold focus:ring-0">
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" 
                                         class="w-10 h-10 object-contain rounded-lg bg-brand-black p-1 border border-brand-border/50">
                                    <div>
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-brand-text hover:text-brand-gold font-medium block truncate max-w-[200px]">
                                            {{ $product->name }}
                                        </a>
                                        <div class="text-[10px] text-brand-muted">{{ $product->scent_family ?? 'Eau de Parfum' }} &bull; {{ $product->variants->count() }} sizes</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-brand-gold">{{ $product->category->name ?? 'Unassigned' }}</span>
                            </td>
                            <td class="px-4 py-3 font-mono text-[11px]">{{ $product->sku }}</td>
                            <td class="px-4 py-3">
                                <div class="font-serif font-bold text-brand-text">{{ $product->formatted_price }}</div>
                                @if($product->compare_at_price > $product->price)
                                    <div class="text-[10px] line-through text-brand-muted/70">Rs. {{ number_format($product->compare_at_price, 0) }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-semibold {{ $product->stock <= 5 ? ($product->stock == 0 ? 'text-rose-400' : 'text-amber-400') : 'text-emerald-400' }}">
                                    {{ $product->stock }} bottles
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded text-[10px] uppercase font-semibold
                                    {{ $product->is_active ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/30' : 'bg-brand-card text-brand-muted border border-brand-border/40' }}">
                                    {{ $product->is_active ? 'Active' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('shop.show', $product->slug) }}" target="_blank" title="Preview on store"
                                       class="w-7 h-7 rounded bg-brand-card hover:bg-brand-border text-brand-muted hover:text-brand-text flex items-center justify-center transition">
                                        <i class="fa-solid fa-eye text-[10px]"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" title="Edit formulation"
                                       class="w-7 h-7 rounded bg-brand-card hover:bg-brand-border text-brand-gold hover:text-brand-goldLight flex items-center justify-center transition">
                                        <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center text-brand-muted">
                                <i class="fa-solid fa-spray-can-sparkles text-2xl text-brand-border mb-2 block"></i>
                                No fragrances found matching criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="px-5 py-3 border-t border-brand-border/40 bg-brand-card/20">
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
