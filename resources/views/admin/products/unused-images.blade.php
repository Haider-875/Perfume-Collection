@extends('admin.layouts.admin')

@section('title', 'Product Images & Storage Cleanup')

@section('header_title', 'Vault Image Maintenance')
@section('header_subtitle', 'Detect and remove orphaned or unlinked product images safely')

@section('header_actions')
    <a href="{{ route('admin.products.index') }}" class="admin-btn-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i>
        <span>Back to Products</span>
    </a>
@endsection

@section('content')
    <!-- Metric Overview Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="admin-card p-3 d-flex align-items-center gap-3">
                <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 20px;">
                    <i class="fa-solid fa-photo-film"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">Total Uploads</div>
                    <div class="fs-4 fw-bold text-dark">{{ $allFilesCount }} <span class="small text-muted fw-normal" style="font-size: 0.8rem;">files</span></div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="admin-card p-3 d-flex align-items-center gap-3">
                <div class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 20px;">
                    <i class="fa-solid fa-link"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">Active in Vault</div>
                    <div class="fs-4 fw-bold text-dark">{{ max(0, $allFilesCount - $unusedCount) }} <span class="small text-muted fw-normal" style="font-size: 0.8rem;">linked</span></div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="admin-card p-3 d-flex align-items-center gap-3">
                <div class="rounded-3 {{ $unusedCount > 0 ? 'bg-danger-subtle text-danger' : 'bg-light text-muted' }} d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 20px;">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">Unused / Orphaned</div>
                    <div class="fs-4 fw-bold {{ $unusedCount > 0 ? 'text-danger' : 'text-dark' }}">{{ $unusedCount }} <span class="small text-muted fw-normal" style="font-size: 0.8rem;">files</span></div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="admin-card p-3 d-flex align-items-center gap-3">
                <div class="rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 20px;">
                    <i class="fa-solid fa-hard-drive"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">Reclaimable Space</div>
                    <div class="fs-4 fw-bold text-dark">{{ $unusedBytesFormatted }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="admin-card mb-4">
        <div class="px-4 py-3 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-broom text-primary small"></i>
                    <span>Unused & Detached Image Files</span>
                </h6>
                <small class="text-muted">These files exist in <code>public/uploads/products/</code> but are not attached to any product or gallery.</small>
            </div>

            @if($unusedCount > 0)
                <form method="POST" action="{{ route('admin.products.unused-images.purge') }}" onsubmit="return confirm('Permanently delete all {{ $unusedCount }} unused image files from disk? This cannot be undone.');">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Purge All Unused ({{ $unusedCount }})</span>
                    </button>
                </form>
            @endif
        </div>

        @if($unusedCount > 0)
            <div class="p-3 bg-danger-subtle border-bottom border-danger-subtle text-danger d-flex align-items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span class="small fw-semibold">Accidental Data Loss Protection: Only unreferenced files are eligible for purging. Core theme assets in <code>public/assets/</code> are completely protected.</span>
            </div>

            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Preview</th>
                            <th>Filename & Storage Path</th>
                            <th>File Size</th>
                            <th>Last Modified</th>
                            <th class="text-end" style="width: 140px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unusedFiles as $file)
                            <tr>
                                <td>
                                    <div class="admin-thumb-box" style="width: 54px; height: 54px; cursor: pointer;" onclick="window.previewImage('{{ $file['url'] }}', '{{ $file['filename'] }}')">
                                        <img src="{{ $file['url'] }}" alt="{{ $file['filename'] }}" class="admin-thumb-img rounded">
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark font-monospace small">{{ $file['filename'] }}</div>
                                    <div class="text-muted small" style="font-size: 0.72rem;">{{ $file['path'] }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace">{{ $file['size_formatted'] }}</span>
                                </td>
                                <td class="small text-muted font-monospace">
                                    {{ $file['updated_at'] }}
                                </td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.products.unused-images.purge') }}" onsubmit="return confirm('Delete this image permanently from disk?');" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="filename" value="{{ $file['filename'] }}">
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-2.5 py-1" style="font-size: 0.75rem;" title="Delete this file">
                                            <i class="fa-solid fa-trash-can me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-5 text-center">
                <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px; font-size: 28px;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Storage Vault is Clean!</h5>
                <p class="text-muted small mb-3" style="max-width: 480px; margin: 0 auto;">
                    No orphaned or unused product image files were found in your uploads folder. Every stored image is actively mapped to a product or gallery showcase.
                </p>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary px-3 py-2">
                    <i class="fa-solid fa-arrow-left me-1"></i> Return to Product Vault
                </a>
            </div>
        @endif
    </div>
@endsection
