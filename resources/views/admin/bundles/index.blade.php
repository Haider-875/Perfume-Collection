@extends('admin.layouts.admin')

@section('title', 'Luxury Bundles')
@section('page_title', 'Luxury Bundles & Coffrets')
@section('page_subtitle', 'Curate exclusive multi-bottle collections, pairing sets, and automatic savings bundles')

@section('header_actions')
<a href="{{ route('admin.bundles.create') }}" class="gold-btn px-4 py-2 rounded-lg text-xs flex items-center gap-2 shadow-lg">
    <i class="fa-solid fa-plus"></i>
    <span>Craft New Bundle</span>
</a>
@endsection

@section('content')
<div class="bg-brand-surface border border-brand-border/60 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-brand-muted">
            <thead class="bg-brand-card/70 uppercase tracking-wider text-[10px] text-brand-gold/80 border-b border-brand-border/50">
                <tr>
                    <th class="px-4 py-3">Bundle Coffret</th>
                    <th class="px-4 py-3">Included Fragrances</th>
                    <th class="px-4 py-3">Original Price</th>
                    <th class="px-4 py-3">Bundle Price</th>
                    <th class="px-4 py-3">Patron Savings</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-border/30">
                @forelse($bundles as $bundle)
                    <tr class="hover:bg-brand-card/30 transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $bundle->image_url }}" alt="{{ $bundle->name }}" class="w-10 h-10 object-contain rounded-lg bg-brand-black p-1 border border-brand-border/50">
                                <div>
                                    <div class="text-brand-text font-medium">{{ $bundle->name }}</div>
                                    <div class="text-[10px] font-mono text-brand-muted">{{ $bundle->sku }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-xs text-brand-text">{{ $bundle->items->count() }} Fragrances</div>
                            <div class="text-[10px] text-brand-muted truncate max-w-[200px]">
                                {{ $bundle->items->map(fn($i) => $i->product->name ?? 'Fragrance')->implode(', ') }}
                            </div>
                        </td>
                        <td class="px-4 py-3 font-serif line-through text-brand-muted">{{ $bundle->formatted_original_price }}</td>
                        <td class="px-4 py-3 font-serif font-bold text-brand-gold">{{ $bundle->formatted_bundle_price }}</td>
                        <td class="px-4 py-3">
                            <span class="text-emerald-400 font-semibold bg-emerald-950/40 px-2 py-0.5 rounded border border-emerald-500/30">
                                Save {{ $bundle->formatted_savings }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded text-[10px] uppercase font-semibold
                                {{ $bundle->is_active ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/30' : 'bg-brand-card text-brand-muted' }}">
                                {{ $bundle->is_active ? 'Active' : 'Disabled' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.bundles.edit', $bundle->id) }}" class="w-7 h-7 rounded bg-brand-card hover:bg-brand-border text-brand-gold flex items-center justify-center transition">
                                    <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.bundles.destroy', $bundle->id) }}" onsubmit="return confirm('Delete this bundle?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-7 h-7 rounded bg-brand-card hover:bg-rose-950/50 text-brand-muted hover:text-rose-400 flex items-center justify-center transition">
                                        <i class="fa-solid fa-trash text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-brand-muted">No bundles created yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($bundles, 'links') && $bundles->hasPages())
        <div class="p-4 border-top border-brand-border/30 d-flex justify-content-center">
            {{ $bundles->links() }}
        </div>
    @endif
</div>
@endsection
