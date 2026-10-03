@extends('admin.layouts.admin')

@section('title', 'Showcase Slides')
@section('page_title', 'Homepage Showcase & Hero Slides')
@section('page_subtitle', 'Manage rotating editorial carousels, flagship promotions, and campaign banners')

@section('header_actions')
<button @click="openCreateModal = true" class="gold-btn px-4 py-2 rounded-lg text-xs flex items-center gap-2 shadow-lg">
    <i class="fa-solid fa-plus"></i>
    <span>Add Showcase Slide</span>
</button>
@endsection

@section('content')
<div x-data="{ openCreateModal: false, editModal: false, activeSlide: {} }">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($slides as $slide)
            <div class="bg-brand-surface border border-brand-border/60 rounded-xl overflow-hidden group hover:border-brand-gold/50 transition flex flex-col">
                <div class="h-44 bg-brand-black relative overflow-hidden flex items-center justify-center p-3 border-b border-brand-border/40">
                    <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="max-h-full object-contain">
                    <span class="absolute top-3 left-3 bg-brand-black/80 px-2 py-0.5 rounded text-[10px] text-brand-gold font-mono border border-brand-gold/30">
                        Order #{{ $slide->sort_order }}
                    </span>
                    <span class="absolute top-3 right-3 px-2 py-0.5 rounded text-[10px] uppercase font-bold
                        {{ $slide->is_active ? 'bg-emerald-950/80 text-emerald-400 border border-emerald-500/30' : 'bg-brand-card text-brand-muted' }}">
                        {{ $slide->is_active ? 'Active' : 'Disabled' }}
                    </span>
                </div>

                <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                    <div>
                        @if($slide->badge_text)
                            <span class="text-[9px] uppercase tracking-widest text-brand-gold font-semibold block mb-1">{{ $slide->badge_text }}</span>
                        @endif
                        <h3 class="font-serif text-base font-semibold text-brand-text">{{ $slide->title }}</h3>
                        <p class="text-xs text-brand-muted mt-1 line-clamp-2">{{ $slide->subtitle }}</p>
                    </div>

                    <div class="pt-3 border-t border-brand-border/40 flex items-center justify-between text-xs">
                        <span class="text-brand-gold font-medium truncate max-w-[140px]">{{ $slide->cta_text }}</span>
                        <div class="flex items-center gap-2">
                            <button @click="activeSlide = {{ json_encode($slide) }}; editModal = true" 
                                    class="w-7 h-7 rounded bg-brand-card hover:bg-brand-border text-brand-gold flex items-center justify-center transition">
                                <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.hero-slides.destroy', $slide->id) }}" onsubmit="return confirm('Delete this slide?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-7 h-7 rounded bg-brand-card hover:bg-rose-950/40 text-brand-muted hover:text-rose-400 flex items-center justify-center transition">
                                    <i class="fa-solid fa-trash text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-brand-muted bg-brand-surface rounded-xl border border-brand-border/60">
                No hero showcase slides found.
            </div>
        @endforelse
    </div>

    <!-- Create Slide Modal -->
    <div x-show="openCreateModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80" style="display: none;">
        <div class="bg-brand-surface border border-brand-border rounded-xl p-6 w-full max-w-lg space-y-4" @click.outside="openCreateModal = false">
            <h3 class="font-serif text-lg font-semibold text-brand-text border-b border-brand-border/40 pb-3">Create Showcase Banner</h3>
            <form method="POST" action="{{ route('admin.hero-slides.store') }}" enctype="multipart/form-data" class="space-y-3 text-xs">
                @csrf
                <div>
                    <label class="block uppercase text-brand-muted mb-1">Headline / Title *</label>
                    <input type="text" name="title" required placeholder="e.g. The Sovereign Oud Extrait" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                </div>
                <div>
                    <label class="block uppercase text-brand-muted mb-1">Subtitle / Poetic Hook</label>
                    <textarea name="subtitle" rows="2" placeholder="Subtext..." class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">Badge Text</label>
                        <input type="text" name="badge_text" placeholder="NEW LAUNCH" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">Sort Order</label>
                        <input type="number" name="sort_order" value="1" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">CTA Button Text</label>
                        <input type="text" name="cta_text" value="DISCOVER COLLECTION" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">CTA URL</label>
                        <input type="text" name="cta_url" value="/collections" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                </div>
                <div>
                    <label class="block uppercase text-brand-muted mb-1">Slide Imagery (PNG/WEBP)</label>
                    <input type="file" name="image" class="w-full text-brand-muted file:mr-2 file:py-1 file:px-3 file:rounded file:bg-brand-gold file:text-brand-black">
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-brand-border/40">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-brand-text">Active in Carousel</span>
                    </label>
                    <div class="flex gap-2">
                        <button type="button" @click="openCreateModal = false" class="px-3 py-1.5 rounded-lg bg-brand-card text-brand-muted">Cancel</button>
                        <button type="submit" class="gold-btn px-4 py-1.5 rounded-lg font-semibold">Save Slide</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Slide Modal -->
    <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80" style="display: none;">
        <div class="bg-brand-surface border border-brand-border rounded-xl p-6 w-full max-w-lg space-y-4" @click.outside="editModal = false">
            <h3 class="font-serif text-lg font-semibold text-brand-text border-b border-brand-border/40 pb-3">Edit Showcase Slide</h3>
            <form method="POST" :action="'/admin/hero-slides/' + activeSlide.id" enctype="multipart/form-data" class="space-y-3 text-xs">
                @csrf
                @method('PUT')
                <div>
                    <label class="block uppercase text-brand-muted mb-1">Headline *</label>
                    <input type="text" name="title" :value="activeSlide.title" required class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                </div>
                <div>
                    <label class="block uppercase text-brand-muted mb-1">Subtitle</label>
                    <textarea name="subtitle" rows="2" :value="activeSlide.subtitle" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">Badge Text</label>
                        <input type="text" name="badge_text" :value="activeSlide.badge_text" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">Sort Order</label>
                        <input type="number" name="sort_order" :value="activeSlide.sort_order" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">CTA Button Text</label>
                        <input type="text" name="cta_text" :value="activeSlide.cta_text" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                    <div>
                        <label class="block uppercase text-brand-muted mb-1">CTA URL</label>
                        <input type="text" name="cta_url" :value="activeSlide.cta_url" class="w-full bg-brand-black/60 border border-brand-border rounded-lg px-3 py-2 text-brand-text">
                    </div>
                </div>
                <div>
                    <label class="block uppercase text-brand-muted mb-1">Update Imagery</label>
                    <input type="file" name="image" class="w-full text-brand-muted file:mr-2 file:py-1 file:px-3 file:rounded file:bg-brand-gold file:text-brand-black">
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-brand-border/40">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" :checked="activeSlide.is_active" class="rounded bg-brand-black border-brand-border text-brand-gold">
                        <span class="text-brand-text">Active</span>
                    </label>
                    <div class="flex gap-2">
                        <button type="button" @click="editModal = false" class="px-3 py-1.5 rounded-lg bg-brand-card text-brand-muted">Cancel</button>
                        <button type="submit" class="gold-btn px-4 py-1.5 rounded-lg font-semibold">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
