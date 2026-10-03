@extends('admin.layouts.admin')

@section('title', 'Import Products CSV')
@section('page_title', 'Bulk Fragrance Import via CSV')
@section('page_subtitle', 'Upload formulations in bulk with automatic SKU synchronization, notes, and category assignment')

@section('header_actions')
<div class="flex items-center gap-2">
    <a href="{{ route('admin.products.sample-csv') }}" class="gold-btn px-4 py-2 rounded-lg text-xs flex items-center gap-2 shadow-lg">
        <i class="fa-solid fa-download"></i>
        <span>Download Sample CSV</span>
    </a>
    <a href="{{ route('admin.products.index') }}" class="px-4 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-text border border-brand-border/60 flex items-center gap-2 transition">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Back to Vault</span>
    </a>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Upload Card -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6">
            <h3 class="font-serif text-base font-semibold text-brand-text mb-2">Upload Inventory CSV File</h3>
            <p class="text-xs text-brand-muted mb-6">Files are parsed row-by-row in memory-safe chunks optimized for Hostinger shared hosting environments.</p>

            <form method="POST" action="{{ route('admin.products.import.process') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div class="border-2 border-dashed border-brand-border/80 hover:border-brand-gold/60 rounded-xl p-8 text-center transition bg-brand-black/40">
                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-brand-gold mb-3 block"></i>
                    <label class="block text-sm font-medium text-brand-text mb-1 cursor-pointer">
                        <span>Select .CSV or .TXT formulation sheet</span>
                        <input type="file" name="csv_file" required accept=".csv,.txt" class="hidden" id="csvFileInput"
                               onchange="document.getElementById('fileNameDisplay').textContent = this.files[0] ? this.files[0].name : '';">
                    </label>
                    <p class="text-[11px] text-brand-muted" id="fileNameDisplay">Maximum upload size: 5MB</p>
                </div>

                @error('csv_file')
                    <div class="text-rose-400 text-xs">{{ $message }}</div>
                @enderror

                <div class="pt-2">
                    <button type="submit" class="w-full gold-btn py-3 rounded-lg text-xs font-semibold uppercase tracking-widest flex items-center justify-center gap-2">
                        <i class="fa-solid fa-file-import"></i>
                        <span>Commence Batch Import</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Column Reference Table -->
        <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6">
            <h3 class="font-serif text-base font-semibold text-brand-text mb-4">Supported CSV Schema Columns</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-brand-muted">
                    <thead class="bg-brand-card uppercase tracking-wider text-[10px] text-brand-gold">
                        <tr>
                            <th class="px-3 py-2">Column Name</th>
                            <th class="px-3 py-2">Required</th>
                            <th class="px-3 py-2">Example Value</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-border/30">
                        <tr><td class="px-3 py-2 font-mono text-brand-text">name</td><td class="px-3 py-2 text-emerald-400">Yes</td><td class="px-3 py-2">Oud Royale Extrait</td></tr>
                        <tr><td class="px-3 py-2 font-mono text-brand-text">sku</td><td class="px-3 py-2 text-emerald-400">Yes</td><td class="px-3 py-2">PC-OUD-ROYALE</td></tr>
                        <tr><td class="px-3 py-2 font-mono text-brand-text">price</td><td class="px-3 py-2 text-emerald-400">Yes</td><td class="px-3 py-2">12500</td></tr>
                        <tr><td class="px-3 py-2 font-mono text-brand-text">compare_at_price</td><td class="px-3 py-2 text-brand-muted">No</td><td class="px-3 py-2">15000</td></tr>
                        <tr><td class="px-3 py-2 font-mono text-brand-text">stock</td><td class="px-3 py-2 text-emerald-400">Yes</td><td class="px-3 py-2">45</td></tr>
                        <tr><td class="px-3 py-2 font-mono text-brand-text">category</td><td class="px-3 py-2 text-brand-muted">No</td><td class="px-3 py-2">Exclusive Edition</td></tr>
                        <tr><td class="px-3 py-2 font-mono text-brand-text">scent_family</td><td class="px-3 py-2 text-brand-muted">No</td><td class="px-3 py-2">Oriental Woody</td></tr>
                        <tr><td class="px-3 py-2 font-mono text-brand-text">gender</td><td class="px-3 py-2 text-brand-muted">No</td><td class="px-3 py-2">Unisex</td></tr>
                        <tr><td class="px-3 py-2 font-mono text-brand-text">top_notes</td><td class="px-3 py-2 text-brand-muted">No</td><td class="px-3 py-2">Saffron, Bergamot</td></tr>
                        <tr><td class="px-3 py-2 font-mono text-brand-text">heart_notes</td><td class="px-3 py-2 text-brand-muted">No</td><td class="px-3 py-2">Taif Rose, Cardamom</td></tr>
                        <tr><td class="px-3 py-2 font-mono text-brand-text">base_notes</td><td class="px-3 py-2 text-brand-muted">No</td><td class="px-3 py-2">Cambodian Oud, Amber</td></tr>
                        <tr><td class="px-3 py-2 font-mono text-brand-text">description</td><td class="px-3 py-2 text-brand-muted">No</td><td class="px-3 py-2">An opulent composition...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Hostinger Shared Hosting Optimization Guide -->
    <div class="space-y-6">
        <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-3">
            <h3 class="font-serif text-base font-semibold text-brand-gold flex items-center gap-2">
                <i class="fa-solid fa-server text-xs"></i>
                <span>Shared Hosting Guard</span>
            </h3>
            <p class="text-xs text-brand-muted leading-relaxed">
                Imports utilize low-memory streaming loops (`fgetcsv`) with atomic transactions. If a SKU already exists, its pricing and stock will be automatically synchronized without duplicating records.
            </p>
        </div>
    </div>
</div>
@endsection
