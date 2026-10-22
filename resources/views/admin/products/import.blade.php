@extends('admin.layouts.admin')

@section('title', 'Bulk Perfume Import')
@section('page_title', 'Bulk Perfume Price List & Catalog Import')
@section('page_subtitle', 'Upload Excel (.xlsx) or CSV price lists with multi-size pricing (30ml, 50ml, 60ml, 100ml), automatic SKU generation, and pre-import validation.')

@section('header_actions')
<a href="{{ route('admin.products.sample-excel') }}" class="admin-btn-secondary" title="Download Excel template (.xlsx)">
    <i class="fa-solid fa-file-excel text-success"></i>
    <span>Sample Excel (.xlsx)</span>
</a>
<a href="{{ route('admin.products.sample-csv') }}" class="admin-btn-secondary" title="Download CSV template (.csv)">
    <i class="fa-solid fa-file-csv text-primary"></i>
    <span>Sample CSV</span>
</a>
<a href="{{ route('admin.products.index') }}" class="admin-btn-secondary">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back to Vault</span>
</a>
@endsection

@section('content')
<div class="container-fluid px-0">

    {{-- Previous Import Summary Banner (if available) --}}
    @if(isset($lastSummary) && is_array($lastSummary))
    <div class="admin-card p-4 mb-4 border-start border-4 border-primary">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
            <div>
                <h5 class="fw-bold text-dark mb-1">
                    <i class="fa-solid fa-circle-check text-success me-2"></i>Last Import Summary
                </h5>
                <p class="text-muted small mb-0">Results of the most recently executed product batch import.</p>
            </div>
            @if(!empty($lastSummary['has_errors']) || ($hasErrorReport ?? false))
            <a href="{{ route('admin.products.import.error-report') }}" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-2">
                <i class="fa-solid fa-file-circle-exclamation"></i>
                <span>Download Error Report (CSV)</span>
            </a>
            @endif
        </div>

        <div class="row g-3">
            <div class="col-6 col-md-2">
                <div class="p-3 bg-light rounded text-center border">
                    <div class="text-muted small text-uppercase fw-semibold">Total Rows</div>
                    <div class="fs-4 fw-bold text-dark mt-1">{{ $lastSummary['total'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="p-3 bg-light rounded text-center border border-success-subtle">
                    <div class="text-success small text-uppercase fw-semibold">Created</div>
                    <div class="fs-4 fw-bold text-success mt-1">{{ $lastSummary['created'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="p-3 bg-light rounded text-center border border-info-subtle">
                    <div class="text-info small text-uppercase fw-semibold">Updated</div>
                    <div class="fs-4 fw-bold text-info mt-1">{{ $lastSummary['updated'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 bg-light rounded text-center border border-secondary-subtle">
                    <div class="text-secondary small text-uppercase fw-semibold">Skipped (Duplicate)</div>
                    <div class="fs-4 fw-bold text-secondary mt-1">{{ $lastSummary['skipped'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 bg-light rounded text-center border border-danger-subtle">
                    <div class="text-danger small text-uppercase fw-semibold">Failed (Errors)</div>
                    <div class="fs-4 fw-bold text-danger mt-1">{{ $lastSummary['failed'] ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row g-4">
        <!-- Left Column: Upload Form & Specification -->
        <div class="col-12 col-lg-8">
            <!-- Upload Box -->
            <div class="admin-card p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-cloud-arrow-up text-primary me-2"></i>Upload Perfume Price List
                    </h5>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                        Excel (.xlsx, .xls) & CSV (.csv)
                    </span>
                </div>
                <p class="text-muted small mb-4">
                    Upload your supplier or brand price list. The system validates required fields, auto-generates missing SKUs, parses multi-size prices (30ml, 50ml, 60ml, 100ml), and presents an interactive preview before anything is written to the database.
                </p>

                <form method="POST" action="{{ route('admin.products.import.preview') }}" enctype="multipart/form-data" id="importForm">
                    @csrf

                    <!-- Drag & Drop File Zone -->
                    <div class="border-2 border-dashed rounded-3 p-4 text-center mb-4 transition" 
                         style="background-color: #fbfcfe; border-color: #cbd5e1; cursor: pointer;"
                         onclick="document.getElementById('fileInput').click();"
                         id="dropZone">
                        <div class="mb-3">
                            <i class="fa-solid fa-file-excel text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Click to select or drag and drop your file here</h6>
                        <p class="text-muted small mb-2">Supports Microsoft Excel (<strong>.xlsx</strong>, <strong>.xls</strong>) and Comma-Separated Values (<strong>.csv</strong>)</p>
                        <span class="badge bg-light text-secondary border px-3 py-1 fw-normal" id="fileNameDisplay">
                            Maximum file size: 10MB
                        </span>
                        <input type="file" name="import_file" id="fileInput" accept=".xlsx,.xls,.csv" required class="d-none"
                               onchange="updateFileName(this)">
                    </div>

                    @error('import_file')
                        <div class="alert alert-danger py-2 small mb-3">
                            <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                        </div>
                    @enderror

                    <!-- Duplicate Handling Options -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small text-uppercase">
                            If a Perfume Already Exists in Database:
                        </label>
                        <div class="row g-2">
                            <div class="col-12 col-md-4">
                                <label class="p-3 border rounded-3 d-block h-100 bg-white" style="cursor: pointer;">
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="duplicate_handling" id="dup_update" value="update" checked>
                                        <label class="form-check-label fw-bold text-dark small" for="dup_update">
                                            1. Update Existing
                                        </label>
                                    </div>
                                    <p class="text-muted small mb-0 ps-4">Sync prices, stock, and details without duplicate records.</p>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="p-3 border rounded-3 d-block h-100 bg-white" style="cursor: pointer;">
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="duplicate_handling" id="dup_skip" value="skip">
                                        <label class="form-check-label fw-bold text-dark small" for="dup_skip">
                                            2. Skip Duplicate
                                        </label>
                                    </div>
                                    <p class="text-muted small mb-0 ps-4">Keep current product intact; only import brand new fragrances.</p>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="p-3 border rounded-3 d-block h-100 bg-white" style="cursor: pointer;">
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="duplicate_handling" id="dup_create" value="create">
                                        <label class="form-check-label fw-bold text-dark small" for="dup_create">
                                            3. Create New
                                        </label>
                                    </div>
                                    <p class="text-muted small mb-0 ps-4">Assigns a unique SKU suffix and saves as a separate product.</p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Actions -->
                    <div class="d-flex align-items-center justify-content-between pt-2">
                        <a href="{{ route('admin.products.sample-excel') }}" class="btn btn-link text-decoration-none text-muted small p-0">
                            <i class="fa-solid fa-download me-1"></i> Need sample file? Download Excel template
                        </a>
                        <button type="submit" class="admin-btn-primary px-4 py-2" id="submitBtn">
                            <i class="fa-solid fa-magnifying-glass-chart"></i>
                            <span>Upload & Preview Products</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Column Specification Table -->
            <div class="admin-card p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-table-columns text-primary me-2"></i>Excel Price List Column Format
                    </h5>
                    <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">10 Columns</span>
                </div>
                <p class="text-muted small mb-3">
                    Your Excel sheet or CSV should include these column headers in row 1. Column names are case-insensitive and tolerate variations:
                </p>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0 text-sm">
                        <thead class="table-light text-uppercase small">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 25%;">Column Name</th>
                                <th style="width: 15%;" class="text-center">Status</th>
                                <th style="width: 30%;">Description</th>
                                <th style="width: 25%;">Sample Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold text-muted">1</td>
                                <td class="fw-semibold text-dark">Name</td>
                                <td class="text-center"><span class="badge bg-danger-subtle text-danger border border-danger-subtle">Required</span></td>
                                <td class="small text-muted">Perfume formulation or product name</td>
                                <td class="font-monospace small">Oud Royale Extrait</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">2</td>
                                <td class="fw-semibold text-dark">Impression Of</td>
                                <td class="text-center"><span class="badge bg-secondary-subtle text-secondary border">Optional</span></td>
                                <td class="small text-muted">Original inspiration perfume / brand</td>
                                <td class="font-monospace small">Imperial Agarwood & Rose</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">3</td>
                                <td class="fw-semibold text-dark">SKU</td>
                                <td class="text-center"><span class="badge bg-info-subtle text-info border border-info-subtle">Auto if empty</span></td>
                                <td class="small text-muted">Unique product code. Auto-generated if left blank</td>
                                <td class="font-monospace small">RVH-OUD-01</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">4</td>
                                <td class="fw-semibold text-dark">Category</td>
                                <td class="text-center"><span class="badge bg-secondary-subtle text-secondary border">Optional</span></td>
                                <td class="small text-muted">Woody, Oriental, Fresh, Floral, etc.</td>
                                <td class="font-monospace small">Woody & Oriental</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">5</td>
                                <td class="fw-semibold text-dark">Gender</td>
                                <td class="text-center"><span class="badge bg-secondary-subtle text-secondary border">Optional</span></td>
                                <td class="small text-muted">Men / Women / Unisex (defaults to Unisex)</td>
                                <td class="font-monospace small">Unisex</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">6</td>
                                <td class="fw-semibold text-dark">30ml Price (PKR)</td>
                                <td class="text-center"><span class="badge bg-success-subtle text-success border border-success-subtle">Size Price</span></td>
                                <td class="small text-muted">Store price for 30ml bottle</td>
                                <td class="font-monospace small text-success fw-bold">1850</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">7</td>
                                <td class="fw-semibold text-dark">50ml Price (PKR)</td>
                                <td class="text-center"><span class="badge bg-success-subtle text-success border border-success-subtle">Size Price</span></td>
                                <td class="small text-muted">Store price for 50ml bottle</td>
                                <td class="font-monospace small text-success fw-bold">2850</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">8</td>
                                <td class="fw-semibold text-dark">60ml Price (PKR)</td>
                                <td class="text-center"><span class="badge bg-success-subtle text-success border border-success-subtle">Size Price</span></td>
                                <td class="small text-muted">Store price for 60ml bottle</td>
                                <td class="font-monospace small text-success fw-bold">3450</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">9</td>
                                <td class="fw-semibold text-dark">100ml Price (PKR)</td>
                                <td class="text-center"><span class="badge bg-success-subtle text-success border border-success-subtle">Size Price</span></td>
                                <td class="small text-muted">Store price for 100ml bottle</td>
                                <td class="font-monospace small text-success fw-bold">4950</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">10</td>
                                <td class="fw-semibold text-dark">Stock</td>
                                <td class="text-center"><span class="badge bg-secondary-subtle text-secondary border">Optional</span></td>
                                <td class="small text-muted">Available inventory quantity (defaults to 25)</td>
                                <td class="font-monospace small">45</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Info Cards & Quick Downloads -->
        <div class="col-12 col-lg-4 space-y-4">
            <!-- Sample Templates Download Card -->
            <div class="admin-card p-4 mb-4">
                <h6 class="fw-bold text-dark mb-2">
                    <i class="fa-solid fa-file-arrow-down text-primary me-2"></i>Sample Price Lists
                </h6>
                <p class="text-muted small mb-3">
                    Download pre-formatted templates populated with sample Perfumes Collection fragrance formulations:
                </p>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.sample-excel') }}" class="btn btn-outline-success d-flex align-items-center justify-content-between p-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-file-excel fs-5"></i>
                            <div class="text-start">
                                <div class="fw-bold small">Excel Template (.xlsx)</div>
                                <div class="text-muted" style="font-size: 11px;">Formatted columns & styling</div>
                            </div>
                        </div>
                        <i class="fa-solid fa-download"></i>
                    </a>
                    <a href="{{ route('admin.products.sample-csv') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-between p-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-file-csv fs-5"></i>
                            <div class="text-start">
                                <div class="fw-bold small">CSV Template (.csv)</div>
                                <div class="text-muted" style="font-size: 11px;">Universal plain text comma-delimited</div>
                            </div>
                        </div>
                        <i class="fa-solid fa-download"></i>
                    </a>
                </div>
            </div>

            <!-- Multi-Size Architecture Guide -->
            <div class="admin-card p-4 mb-4">
                <h6 class="fw-bold text-dark mb-2">
                    <i class="fa-solid fa-bottle-droplet text-primary me-2"></i>Relational Multi-Size Pricing
                </h6>
                <p class="text-muted small mb-2">
                    Our database architecture automatically stores bottle size prices in the relational <code>product_prices</code> table:
                </p>
                <ul class="text-muted small ps-3 mb-3 space-y-1">
                    <li><strong>products:</strong> name, impression, sku, category, gender, stock</li>
                    <li><strong>product_prices:</strong> product_id, size (30ml, 50ml, 60ml, 100ml), price</li>
                    <li><strong>product_variants:</strong> Synchronized for storefront bottle size selector</li>
                </ul>
                <div class="p-2 bg-light rounded border small text-muted">
                    <i class="fa-solid fa-circle-info text-info me-1"></i> At least one bottle size price is required per perfume.
                </div>
            </div>

            <!-- Validation Guarantees -->
            <div class="admin-card p-4">
                <h6 class="fw-bold text-dark mb-2">
                    <i class="fa-solid fa-shield-halved text-success me-2"></i>Validation Guarantees
                </h6>
                <ul class="text-muted small ps-3 mb-0 space-y-2">
                    <li><strong>Zero Risk Preview:</strong> Nothing is committed until you inspect the preview screen and click "Confirm Import".</li>
                    <li><strong>SKU Safeguard:</strong> Duplicate SKUs within the file or catalog are detected and flagged.</li>
                    <li><strong>Atomic Transactions:</strong> Database writes use transactions to prevent partial or corrupted insertions.</li>
                    <li><strong>Error Export:</strong> Any failed or rejected row can be downloaded as an audit CSV.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    const display = document.getElementById('fileNameDisplay');
    if (input.files && input.files[0]) {
        const file = input.files[0];
        display.innerHTML = `<span class="text-success fw-bold"><i class="fa-solid fa-check me-1"></i> ${file.name}</span> (${(file.size / 1024).toFixed(1)} KB)`;
    } else {
        display.textContent = 'Maximum file size: 10MB';
    }
}

// Drag & drop handlers
const dropZone = document.getElementById('dropZone');
['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropZone.style.borderColor = '#0d6efd';
        dropZone.style.backgroundColor = '#eff6ff';
    }, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropZone.style.borderColor = '#cbd5e1';
        dropZone.style.backgroundColor = '#fbfcfe';
    }, false);
});

dropZone.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    const files = dt.files;
    if (files.length) {
        document.getElementById('fileInput').files = files;
        updateFileName(document.getElementById('fileInput'));
    }
});
</script>
@endsection
