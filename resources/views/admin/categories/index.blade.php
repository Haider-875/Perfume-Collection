@extends('admin.layouts.admin')

@section('title', 'Collections & Categories')
@section('page_title', 'Collections & Fragrance Classifications')
@section('page_subtitle', 'Curate boutique collections (Exclusive, Men, Women, Unisex, Discovery Sets)')

@section('header_actions')
<button @click="openCreateModal = true" class="gold-btn px-4 py-2 rounded-lg text-xs flex items-center gap-2 shadow-lg">
    <i class="fa-solid fa-plus"></i>
    <span>New Collection</span>
</button>
@endsection

@section('content')
<div x-data="{ openCreateModal: false, editModal: false, activeCat: {} }">
    
    <!-- Collections Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-5 relative overflow-hidden group hover:border-brand-gold/50 transition">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="w-12 h-12 object-contain rounded-lg bg-brand-black p-1 border border-brand-border/40">
                        <div>
                            <h3 class="font-serif text-base font-semibold text-brand-text">{{ $category->name }}</h3>
                            <div class="text-[11px] font-mono text-brand-gold mt-0.5">/collections/{{ $category->slug }}</div>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold
                        {{ $category->is_active ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/30' : 'bg-brand-card text-brand-muted' }}">
                        {{ $category->is_active ? 'Active' : 'Draft' }}
                    </span>
                </div>

                @if($category->description)
                    <p class="text-xs text-brand-muted mt-3 line-clamp-2">{{ $category->description }}</p>
                @endif

                <div class="mt-4 pt-3 border-t border-brand-border/40 flex items-center justify-between text-xs">
                    <span class="text-brand-muted font-medium">
                        <strong class="text-brand-text">{{ $category->products_count }}</strong> Formulations
                    </span>

                    <div class="flex items-center gap-2">
                        <button @click="activeCat = {{ json_encode($category) }}; editModal = true" 
                                class="w-7 h-7 rounded bg-brand-card hover:bg-brand-border text-brand-gold flex items-center justify-center transition" title="Edit Collection">
                            <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                        </button>
                        @if($category->products_count === 0)
                            <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" onsubmit="return confirm('Delete this empty category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-7 h-7 rounded bg-brand-card hover:bg-rose-950/40 text-brand-muted hover:text-rose-400 flex items-center justify-center transition" title="Delete">
                                    <i class="fa-solid fa-trash text-[10px]"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Create Modal -->
    <div x-show="openCreateModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80" style="display: none;">
        <div class="bg-brand-surface border border-brand-border rounded-xl p-6 w-full max-w-md space-y-4" @click.outside="openCreateModal = false">
            <h3 class="font-serif text-lg font-semibold text-brand-text border-b border-brand-border/40 pb-3">Craft New Fragrance Collection</h3>
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs uppercase text-brand-muted mb-1">Collection Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Exclusive Edition" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-xs text-brand-text">
                </div>
                <div>
                    <label class="block text-xs uppercase text-brand-muted mb-1">Description</label>
                    <textarea name="description" rows="2" placeholder="Poetic summary..." class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-xs text-brand-text"></textarea>
                </div>
                <div>
                    <label class="block text-xs uppercase text-brand-muted mb-1">Badge Text</label>
                    <input type="text" name="badge_text" placeholder="e.g. ULTRA LUXURY" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-xs text-brand-text">
                </div>
                <div>
                    <label class="block text-xs uppercase text-brand-muted mb-1">Collection Imagery</label>
                    <input type="file" name="image" class="w-full text-xs text-brand-muted file:mr-2 file:py-1 file:px-3 file:rounded file:bg-brand-gold file:text-brand-black">
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-brand-border/40">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-xs text-brand-text">Active</span>
                    </label>
                    <div class="flex gap-2">
                        <button type="button" @click="openCreateModal = false" class="px-3 py-1.5 rounded-lg text-xs bg-brand-card text-brand-muted">Cancel</button>
                        <button type="submit" class="gold-btn px-4 py-1.5 rounded-lg text-xs font-semibold">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80" style="display: none;">
        <div class="bg-brand-surface border border-brand-border rounded-xl p-6 w-full max-w-md space-y-4" @click.outside="editModal = false">
            <h3 class="font-serif text-lg font-semibold text-brand-text border-b border-brand-border/40 pb-3">Edit Collection</h3>
            <form method="POST" :action="'/admin/categories/' + activeCat.id" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs uppercase text-brand-muted mb-1">Collection Name *</label>
                    <input type="text" name="name" :value="activeCat.name" required class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-xs text-brand-text">
                </div>
                <div>
                    <label class="block text-xs uppercase text-brand-muted mb-1">Description</label>
                    <textarea name="description" rows="2" :value="activeCat.description" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-xs text-brand-text"></textarea>
                </div>
                <div>
                    <label class="block text-xs uppercase text-brand-muted mb-1">Badge Text</label>
                    <input type="text" name="badge_text" :value="activeCat.badge_text" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-xs text-brand-text">
                </div>
                <div>
                    <label class="block text-xs uppercase text-brand-muted mb-1">Update Imagery</label>
                    <input type="file" name="image" class="w-full text-xs text-brand-muted file:mr-2 file:py-1 file:px-3 file:rounded file:bg-brand-gold file:text-brand-black">
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-brand-border/40">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" :checked="activeCat.is_active" class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-xs text-brand-text">Active</span>
                    </label>
                    <div class="flex gap-2">
                        <button type="button" @click="editModal = false" class="px-3 py-1.5 rounded-lg text-xs bg-brand-card text-brand-muted">Cancel</button>
                        <button type="submit" class="gold-btn px-4 py-1.5 rounded-lg text-xs font-semibold">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
