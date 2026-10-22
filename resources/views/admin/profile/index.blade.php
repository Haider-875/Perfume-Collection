@extends('admin.layouts.admin')

@section('title', 'My Profile & Security')
@section('page_title', 'Administrator Profile & Security')
@section('page_subtitle', 'Manage your master administrative credentials, update password, and inspect security activity')

@section('content')
<div class="row g-4">
    <!-- Top Metric Overview -->
    <div class="col-12">
        <div class="row g-3">
            <div class="col-sm-6 col-xl-4">
                <div class="admin-card p-3 d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary bg-primary-subtle" style="width: 48px; height: 48px; font-size: 20px;">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">Assigned Role</div>
                        <div class="fs-5 fw-bold text-dark">{{ strtoupper(str_replace('_', ' ', $user->role)) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-4">
                <div class="admin-card p-3 d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-success bg-success-subtle" style="width: 48px; height: 48px; font-size: 20px;">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">Security Status</div>
                        <div class="fs-5 fw-bold text-success d-flex align-items-center gap-2">
                            <span class="rounded-circle d-inline-block bg-success" style="width: 8px; height: 8px;"></span>
                            <span>Active & Verified</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-4">
                <div class="admin-card p-3 d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-warning bg-warning-subtle" style="width: 48px; height: 48px; font-size: 20px;">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">Administrator Since</div>
                        <div class="fs-5 fw-bold text-dark">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Left Column: Forms -->
    <div class="col-lg-7">

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-xs mb-4" role="alert">
                <i class="fa-solid fa-circle-check fs-5 text-success"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-xs mb-4" role="alert">
                <div class="d-flex align-items-center gap-2 fw-bold mb-1">
                    <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                    <span>Please correct the errors below:</span>
                </div>
                <ul class="mb-0 ps-3 small">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Password Change Card -->
        <div class="admin-card mb-4">
            <div class="px-4 py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-key text-primary small"></i>
                    <span>Change Master Password</span>
                </h6>
                <span class="badge bg-light text-muted border font-monospace" style="font-size: 0.7rem;">Session Protection Active</span>
            </div>

            <div class="p-4">
                <form method="POST" action="{{ route('admin.profile.password') }}">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div class="mb-3">
                        <label for="admin_curr_pass" class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">
                            Current Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   name="current_password" 
                                   id="admin_curr_pass" 
                                   required 
                                   class="form-control form-control-sm @error('current_password') is-invalid @enderror" 
                                   placeholder="Verify existing password">
                            <button type="button" 
                                    class="btn btn-outline-secondary btn-sm" 
                                    onclick="toggleAdminPass('admin_curr_pass', this)" 
                                    aria-label="Toggle password visibility">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <small class="text-danger d-block mt-1 font-monospace" style="font-size: 0.75rem;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- New Password -->
                        <div class="col-md-6">
                            <label for="admin_new_pass" class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">
                                New Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       name="password" 
                                       id="admin_new_pass" 
                                       required 
                                       class="form-control form-control-sm @error('password') is-invalid @enderror" 
                                       placeholder="Minimum 8 characters"
                                       oninput="checkPasswordStrength(this.value)">
                                <button type="button" 
                                        class="btn btn-outline-secondary btn-sm" 
                                        onclick="toggleAdminPass('admin_new_pass', this)" 
                                        aria-label="Toggle password visibility">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            </div>
                            <!-- Strength Indicator -->
                            <div class="progress mt-1.5" style="height: 4px; display: none;" id="strengthProgress">
                                <div class="progress-bar" id="strengthBar" style="width: 0%;"></div>
                            </div>
                            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;" id="strengthText">Must contain letters and numbers.</small>
                            @error('password')
                                <small class="text-danger d-block mt-1 font-monospace" style="font-size: 0.75rem;">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6">
                            <label for="admin_conf_pass" class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">
                                Confirm New Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="admin_conf_pass" 
                                       required 
                                       class="form-control form-control-sm" 
                                       placeholder="Repeat new password">
                                <button type="button" 
                                        class="btn btn-outline-secondary btn-sm" 
                                        onclick="toggleAdminPass('admin_conf_pass', this)" 
                                        aria-label="Toggle password visibility">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end pt-2">
                        <button type="submit" class="admin-btn-primary">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Update Master Password</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Administrator Personal Information Card -->
        <div class="admin-card mb-4">
            <div class="px-4 py-3 bg-white border-bottom">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-id-badge text-primary small"></i>
                    <span>Personal Profile Details</span>
                </h6>
            </div>

            <div class="p-4">
                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">
                                Administrator Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-control form-control-sm">
                            @error('name')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">
                                Email Address (Login) <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-control form-control-sm font-monospace">
                            @error('email')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Direct Phone / WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. 0321-1234567" class="form-control form-control-sm">
                            @error('phone')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">Station / City</label>
                            <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="e.g. Lahore, Punjab" class="form-control form-control-sm">
                            @error('city')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end pt-2">
                        <button type="submit" class="admin-btn-secondary">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Save Profile Details</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Right Column: Profile Overview & Security Audit -->
    <div class="col-lg-5">

        <!-- Identity Summary Card -->
        <div class="admin-card mb-4 text-center p-4">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm fw-bold" 
                 style="width: 72px; height: 72px; font-size: 26px; background-color: #1e293b; color: #60a5fa; border: 3px solid rgba(37, 99, 235, 0.2);">
                {{ substr($user->name ?? 'A', 0, 1) }}
            </div>
            <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
            <div class="text-muted small font-monospace mb-2">{{ $user->email }}</div>
            <span class="badge bg-primary px-3 py-1.5 text-uppercase fw-semibold" style="letter-spacing: 0.05em; font-size: 11px;">
                {{ strtoupper(str_replace('_', ' ', $user->role)) }}
            </span>

            <div class="border-top mt-3 pt-3 text-start small">
                <div class="d-flex justify-content-between py-1 text-muted">
                    <span>Account Status:</span>
                    <strong class="text-success"><i class="fa-solid fa-circle-check me-1"></i>Active</strong>
                </div>
                <div class="d-flex justify-content-between py-1 text-muted">
                    <span>Contact Phone:</span>
                    <strong class="text-dark">{{ $user->phone ?? 'Not specified' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 text-muted">
                    <span>Headquarters:</span>
                    <strong class="text-dark">{{ $user->city ?? 'Lahore' }}</strong>
                </div>
            </div>
        </div>

        <!-- Security Best Practices Card -->
        <div class="admin-card mb-4 p-4">
            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                <i class="fa-solid fa-user-lock text-warning"></i>
                <span>Security Recommendations</span>
            </h6>
            <ul class="list-unstyled mb-0 d-flex flex-column gap-2 text-muted" style="font-size: 12.5px;">
                <li class="d-flex align-items-start gap-2">
                    <i class="fa-solid fa-check text-success mt-1"></i>
                    <span>Use a unique password with at least 8 characters including letters and digits.</span>
                </li>
                <li class="d-flex align-items-start gap-2">
                    <i class="fa-solid fa-check text-success mt-1"></i>
                    <span>Administrative sessions automatically re-validate after password updates.</span>
                </li>
                <li class="d-flex align-items-start gap-2">
                    <i class="fa-solid fa-check text-success mt-1"></i>
                    <span>All credential modifications are audited in the tamper-resistant Activity Log.</span>
                </li>
            </ul>
        </div>

        <!-- Recent Personal Activity Logs -->
        <div class="admin-card">
            <div class="px-4 py-3 bg-white border-bottom">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-primary small"></i>
                    <span>Recent Security Actions</span>
                </h6>
            </div>

            <div class="p-0">
                @if($recentLogs && $recentLogs->isNotEmpty())
                    <ul class="list-group list-group-flush small mb-0">
                        @foreach($recentLogs as $log)
                            <li class="list-group-item px-4 py-2.5 d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="fw-semibold text-dark text-truncate" style="max-width: 200px;">{{ $log->description }}</div>
                                    <span class="badge bg-light text-muted border font-monospace" style="font-size: 10px;">{{ $log->action }}</span>
                                </div>
                                <small class="text-muted font-monospace" style="font-size: 11px;">{{ $log->created_at->diffForHumans() }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-4 text-center text-muted small">
                        No recent activity recorded for this administrative session.
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<script>
    function toggleAdminPass(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            if (icon) {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        } else {
            input.type = 'password';
            if (icon) {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    }

    function checkPasswordStrength(val) {
        const prog = document.getElementById('strengthProgress');
        const bar = document.getElementById('strengthBar');
        const txt = document.getElementById('strengthText');
        if (!val || val.length === 0) {
            prog.style.display = 'none';
            txt.innerText = 'Must contain letters and numbers.';
            txt.className = 'text-muted d-block mt-1';
            return;
        }

        prog.style.display = 'block';
        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        if (val.length < 8) {
            bar.style.width = '25%';
            bar.className = 'progress-bar bg-danger';
            txt.innerText = 'Too short (min 8 characters).';
            txt.className = 'text-danger d-block mt-1';
        } else if (score <= 2) {
            bar.style.width = '50%';
            bar.className = 'progress-bar bg-warning';
            txt.innerText = 'Moderate password strength.';
            txt.className = 'text-warning d-block mt-1';
        } else {
            bar.style.width = '100%';
            bar.className = 'progress-bar bg-success';
            txt.innerText = 'Strong password.';
            txt.className = 'text-success d-block mt-1';
        }
    }
</script>
@endsection
