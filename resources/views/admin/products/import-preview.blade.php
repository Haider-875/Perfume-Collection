@extends('admin.layouts.admin')

@section('title', 'Import Preview & Validation')
@section('page_title', 'Perfume Import Preview & Pre-Validation')
@section('page_subtitle', 'Review parsed formulations, multi-size pricing (30ml, 50ml, 60ml, 100ml), and duplicate checks before committing to the database.')

@section('header_actions')
<a href="{{ route('admin.products.import') }}" class="admin-btn-secondary">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Cancel & Upload New File</span>
</a>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- KPI Summary Row -->
    <div class="row g-3 mb-4">
        <!-- Total Products Found -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="admin-card p-3 h-100 border-start border-4 border-primary">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Total Products Found</div>
                        <div class="fs-3 fw-bold text-dark mt-1">{{ $stats['total'] ?? count($rows) }}</div>
                    </div>
                    <div class="rounded-circle bg-primary-subtle p-3 text-primary">
                        <i class="fa-solid fa-file-excel fs-4"></i>
                    </div>
                </div>
                <div class="text-muted small mt-2">Parsed from <strong>{{ $filename }}</strong></div>
            </div>
        </div>

        <!-- Valid / Ready to Import -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="admin-card p-3 h-100 border-start border-4 border-success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Ready to Import</div>
                        <div class="fs-3 fw-bold text-success mt-1">{{ $stats['valid'] ?? 0 }}</div>
                    </div>
                    <div class="rounded-circle bg-success-subtle p-3 text-success">
                        <i class="fa-solid fa-circle-check fs-4"></i>
                    </div>
                </div>
                <div class="text-muted small mt-2">Passed all validation rules</div>
            </div>
        </div>

        <!-- Existing in Database -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="admin-card p-3 h-100 border-start border-4 border-warning">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Existing in Database</div>
                        <div class="fs-3 fw-bold text-warning mt-1">{{ $stats['duplicates'] ?? 0 }}</div>
                    </div>
                    <div class="rounded-circle bg-warning-subtle p-3 text-warning">
                        <i class="fa-solid fa-arrows-rotate fs-4"></i>
                    </div>
                </div>
                <div class="text-muted small mt-2">Matching SKU or perfume name</div>
            </div>
        </div>

        <!-- Rows with Errors -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="admin-card p-3 h-100 border-start border-4 border-danger">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Rows with Errors</div>
                        <div class="fs-3 fw-bold text-danger mt-1">{{ $stats['errors'] ?? 0 }}</div>
                    </div>
                    <div class="rounded-circle bg-danger-subtle p-3 text-danger">
                        <i class="fa-solid fa-triangle-exclamation fs-4"></i>
                    </div>
                </div>
                <div class="text-muted small mt-2">Will be skipped during final import</div>
            </div>
        </div>
    </div>

    <!-- Confirmation & Strategy Form Card -->
    <div class="admin-card p-4 mb-4 bg-light border">
        <form method="POST" action="{{ route('admin.products.import.confirm') }}" id="confirmImportForm">
            @csrf
            <input type="hidden" name="import_token" value="{{ $importToken }}">

            <div class="row align-items-center g-3">
                <div class="col-12 col-md-5">
                    <label class="form-label fw-bold text-dark small text-uppercase mb-1">
                        <i class="fa-solid fa-sliders text-primary me-1"></i> Duplicate Handling Strategy:
                    </label>
                    <select name="duplicate_handling" class="form-select bg-white" id="strategySelect" onchange="updateStrategyNotice(this.value)">
                        <option value="update" {{ ($duplicateHandling ?? 'update') === 'update' ? 'selected' : '' }}>
                            Update Existing Product (Sync prices, stock & details)
                        </option>
                        <option value="skip" {{ ($duplicateHandling ?? 'update') === 'skip' ? 'selected' : '' }}>
                            Skip Duplicate Product (Keep current database record untouched)
                        </option>
                        <option value="create" {{ ($duplicateHandling ?? 'update') === 'create' ? 'selected' : '' }}>
                            Create New Product (Assign fresh SKU and create new entry)
                        </option>
                    </select>
                    <div class="form-text small text-muted" id="strategyHelpText">
                        Currently set to update existing products with newest pricing and inventory.
                    </div>
                </div>

                <div class="col-12 col-md-7 text-md-end pt-2 pt-md-0">
                    <div class="d-flex align-items-center justify-content-md-end gap-2 flex-wrap">
                        <a href="{{ route('admin.products.import') }}" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-xmark me-1"></i> Discard
                        </a>
                        <button type="submit" class="admin-btn-primary px-4 py-2" id="confirmBtn"
                                {{ ($stats['valid'] ?? 0) === 0 ? 'disabled' : '' }}>
                            <i class="fa-solid fa-cloud-arrow-down"></i>
                            <span>Confirm & Commit ({{ $stats['valid'] ?? 0 }}) Products</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Preview Table Card -->
    <div class="admin-card p-4">
        <!-- Table Header & Filter Bar -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3 pb-3 border-bottom">
            <div>
                <h5 class="fw-bold text-dark mb-1">
                    <i class="fa-solid fa-table text-primary me-2"></i>Import Data Preview ({{ count($rows) }} Rows)
                </h5>
                <p class="text-muted small mb-0">Inspect the extracted fields, pricing tiers, and validation feedback.</p>
            </div>

            <!-- Filter Buttons & Search -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-secondary active" onclick="filterTable('all', this)">
                        All ({{ count($rows) }})
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="filterTable('ready', this)">
                        Ready ({{ $stats['valid'] ?? 0 }})
                    </button>
                    <button type="button" class="btn btn-outline-warning" onclick="filterTable('duplicate', this)">
                        Duplicates ({{ $stats['duplicates'] ?? 0 }})
                    </button>
                    @if(($stats['errors'] ?? 0) > 0)
                    <button type="button" class="btn btn-outline-danger" onclick="filterTable('error', this)">
                        Errors ({{ $stats['errors'] ?? 0 }})
                    </button>
                    @endif
                </div>

                <div style="min-width: 220px;">
                    <input type="text" id="tableSearchInput" placeholder="Quick search rows..." 
                           class="form-control form-control-sm" onkeyup="searchTable(this.value)">
                </div>
            </div>
        </div>

        <!-- Table Responsive Container -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0 text-sm" id="previewTable">
                <thead class="table-light text-uppercase small">
                    <tr>
                        <th style="width: 4%;">#</th>
                        <th style="width: 10%;" class="text-center">Status</th>
                        <th style="width: 22%;">Perfume Name & Impression</th>
                        <th style="width: 14%;">SKU</th>
                        <th style="width: 12%;">Category / Gender</th>
                        <th style="width: 20%;">Size Pricing (PKR)</th>
                        <th style="width: 6%;" class="text-center">Stock</th>
                        <th style="width: 12%;">Issues / Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $idx => $row)
                        @php
                            $rowStatus = !$row['is_valid'] ? 'error' : ($row['exists_in_db'] ? 'duplicate' : 'ready');
                        @endphp
                        <tr class="preview-row {{ !$row['is_valid'] ? 'table-danger-subtle' : '' }}" 
                            data-status="{{ $rowStatus }}">
                            <!-- Row Number -->
                            <td class="text-muted fw-bold small text-center">
                                {{ $row['excel_row'] ?? ($idx + 1) }}
                            </td>

                            <!-- Status Badge -->
                            <td class="text-center">
                                @if(!$row['is_valid'])
                                    <span class="badge bg-danger text-white px-2 py-1">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Error
                                    </span>
                                @elseif($row['exists_in_db'])
                                    <span class="badge bg-warning text-dark px-2 py-1">
                                        <i class="fa-solid fa-arrows-rotate me-1"></i> Exists
                                    </span>
                                @else
                                    <span class="badge bg-success text-white px-2 py-1">
                                        <i class="fa-solid fa-check me-1"></i> Ready
                                    </span>
                                @endif
                            </td>

                            <!-- Fragrance Name & Impression -->
                            <td>
                                <div class="fw-bold text-dark">{{ $row['name'] ?: '—' }}</div>
                                @if(!empty($row['impression_of']))
                                    <div class="text-muted small fst-italic">
                                        <i class="fa-solid fa-quote-left text-muted me-1" style="font-size: 10px;"></i>{{ $row['impression_of'] }}
                                    </div>
                                @endif
                            </td>

                            <!-- SKU -->
                            <td>
                                <span class="badge bg-light text-dark border font-monospace small px-2 py-1">
                                    {{ $row['sku'] }}
                                </span>
                                @if($row['is_sku_auto_generated'] ?? false)
                                    <div class="text-info small mt-1" style="font-size: 11px;">
                                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i>Auto-generated
                                    </div>
                                @endif
                            </td>

                            <!-- Category & Gender -->
                            <td>
                                <div class="small fw-semibold text-dark">{{ $row['category_name'] ?? 'Signature Impressions' }}</div>
                                <span class="badge bg-secondary-subtle text-secondary border small mt-1">
                                    {{ $row['gender'] ?? 'Unisex' }}
                                </span>
                            </td>

                            <!-- Size Pricing Pills -->
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @if(!empty($row['prices']))
                                        @foreach($row['prices'] as $size => $price)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle small px-2 py-1">
                                                <strong>{{ $size }}:</strong> Rs. {{ number_format($price) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-danger small fst-italic">No size pricing entered</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Stock -->
                            <td class="text-center">
                                <span class="fw-bold {{ ($row['stock'] ?? 0) <= 5 ? 'text-danger' : 'text-dark' }}">
                                    {{ $row['stock'] ?? 25 }}
                                </span>
                            </td>

                            <!-- Issues / Notes -->
                            <td>
                                @if(!empty($row['errors']))
                                    <div class="text-danger small fw-semibold">
                                        @foreach($row['errors'] as $err)
                                            <div><i class="fa-solid fa-circle-xmark me-1"></i>{{ $err }}</div>
                                        @endforeach
                                    </div>
                                @elseif(!empty($row['warnings']))
                                    <div class="text-warning-emphasis small">
                                        @foreach($row['warnings'] as $warn)
                                            <div><i class="fa-solid fa-circle-info me-1"></i>{{ $warn }}</div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-success small">
                                        <i class="fa-solid fa-circle-check me-1"></i>Valid & ready
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                No rows could be parsed from the upload file.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Bottom Action Bar -->
        <div class="d-flex align-items-center justify-content-between pt-4 mt-3 border-top flex-wrap gap-3">
            <div class="text-muted small">
                Showing <strong>{{ count($rows) }}</strong> rows (<strong>{{ $stats['valid'] ?? 0 }}</strong> valid, <strong>{{ $stats['errors'] ?? 0 }}</strong> errors).
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.products.import') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Upload Different File
                </a>
                <button type="button" class="admin-btn-primary px-4 py-2" onclick="document.getElementById('confirmImportForm').submit();"
                        {{ ($stats['valid'] ?? 0) === 0 ? 'disabled' : '' }}>
                    <i class="fa-solid fa-check-double me-1"></i>
                    <span>Execute Import Now</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function updateStrategyNotice(val) {
    const help = document.getElementById('strategyHelpText');
    if (val === 'update') {
        help.textContent = 'Existing products will be updated with new prices, stock, and impression notes.';
    } else if (val === 'skip') {
        help.textContent = 'Existing products will remain untouched; only new fragrances will be inserted.';
    } else if (val === 'create') {
        help.textContent = 'New products will be created for duplicates with an auto-incremented SKU.';
    }
}

function filterTable(filter, btn) {
    // Update active button state
    document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const rows = document.querySelectorAll('#previewTable tbody tr.preview-row');
    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        if (filter === 'all' || status === filter) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function searchTable(query) {
    const q = query.toLowerCase().trim();
    const rows = document.querySelectorAll('#previewTable tbody tr.preview-row');
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(q) ? '' : 'none';
    });
}
</script>
@endsection
