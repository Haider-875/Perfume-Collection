@extends('admin.layouts.admin')

@section('title', 'Edit Staff Member')
@section('page_title', 'Edit Staff Member: ' . $user->name)
@section('page_subtitle', 'Adjust role elevation, toggle account status, and calibrate granular permission grants')

@section('header_actions')
<a href="{{ route('admin.users.index') }}" class="admin-btn-secondary">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back to Staff Directory</span>
</a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.users.update', $user->id) }}">
    @csrf
    @method('PUT')

    <div class="row g-4 justify-content-center">
        <div class="col-xl-10">

            <!-- Credentials & Identity -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-id-badge text-primary small"></i>
                        <span>Team Member Profile</span>
                    </h6>
                </div>
                <div class="p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 13px; letter-spacing: 0.04em;">Full Name *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="text-danger small mt-1" style="font-size: 13px;">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 13px; letter-spacing: 0.04em;">Email Address (Login) *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="font-monospace">
                            @error('email') <div class="text-danger small mt-1" style="font-size: 13px;">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 13px; letter-spacing: 0.04em;">Reset Password</label>
                            <input type="password" name="password" placeholder="Leave blank to keep current password">
                            <small class="text-muted d-block mt-1" style="font-size: 13px;">Only enter a new password if resetting credentials.</small>
                            @error('password') <div class="text-danger small mt-1" style="font-size: 13px;">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 13px; letter-spacing: 0.04em;">Direct Phone / WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. 0300-1234567">
                        </div>
                    </div>

                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 13px; letter-spacing: 0.04em;">City / Office Branch</label>
                            <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="e.g. Lahore / Karachi">
                        </div>

                        <div class="col-md-6 pt-md-3">
                            <div class="form-check form-switch p-3 bg-light border rounded">
                                <input class="form-check-input ms-0 me-3" type="checkbox" name="is_active" id="isActiveCheck" value="1" {{ old('is_active', $user->is_active !== false) ? 'checked' : '' }}>
                                <label class="form-check-label cursor-pointer" for="isActiveCheck">
                                    <span class="small fw-semibold text-dark d-block">Account Enabled & Active</span>
                                    <small class="text-muted d-block" style="font-size: 13px;">Uncheck to instantly suspend access to the portal</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role Selection -->
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-primary small"></i>
                        <span>Administrative Role</span>
                    </h6>
                </div>
                <div class="p-4">
                    <div class="row g-3">
                        @foreach($roles as $key => $r)
                            <div class="col-md-6">
                                <label class="p-3 border rounded d-block cursor-pointer h-100 transition {{ old('role', $user->role) === $key ? 'border-primary bg-primary-subtle' : 'bg-light' }}">
                                    <div class="d-flex align-items-start gap-2.5">
                                        <input type="radio" name="role" value="{{ $key }}" {{ old('role', $user->role) === $key ? 'checked' : '' }}
                                               class="form-check-input mt-1 flex-shrink-0">
                                        <div>
                                            <div class="fw-bold small text-dark">{{ $r['label'] }}</div>
                                            <small class="text-muted d-block mt-1" style="font-size: 13px; line-height: 1.35;">{{ $r['description'] }}</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Granular Permissions Matrix -->
            @php
                $userPerms = is_array($user->permissions) ? $user->permissions : (json_decode($user->permissions ?? '[]', true) ?: []);
            @endphp
            <div class="admin-card mb-4">
                <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-key text-primary small"></i>
                            <span>Explicit Granular Permissions</span>
                        </h6>
                        <small class="text-muted" style="font-size: 13px;">Customize individual capabilities (Super Admins inherently possess all permissions).</small>
                    </div>
                </div>
                <div class="p-4">
                    <div class="row g-3">
                        @foreach($availablePermissions as $pKey => $pMeta)
                            <div class="col-md-6">
                                <label class="p-3 bg-light border rounded d-flex align-items-start gap-2.5 cursor-pointer h-100 transition mb-0">
                                    <input type="checkbox" name="permissions[]" value="{{ $pKey }}"
                                           {{ in_array($pKey, old('permissions', $userPerms)) ? 'checked' : '' }}
                                           class="form-check-input mt-1 flex-shrink-0">
                                    <div>
                                        <div class="fw-semibold small text-dark">{{ $pMeta['label'] }}</div>
                                        <small class="text-muted d-block mt-0.5" style="font-size: 13px; line-height: 1.35;">{{ $pMeta['description'] }}</small>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Action Submit Buttons -->
            <div class="d-flex align-items-center justify-content-end gap-2 pb-4">
                <a href="{{ route('admin.users.index') }}" class="admin-btn-secondary px-4">
                    Cancel
                </a>
                <button type="submit" class="admin-btn-primary px-4 py-2 fs-6">
                    <i class="fa-solid fa-check me-1"></i>
                    <span>Save Staff Changes</span>
                </button>
            </div>

        </div>
    </div>
</form>
@endsection
