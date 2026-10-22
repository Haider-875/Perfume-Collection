@extends('layouts.app')

@section('title', 'Security & Password — Perfumes Collection')

@section('content')
<div class="py-5 min-vh-100" style="background-color: #F7F3EE;">
    <div class="container px-3 px-lg-4" style="max-width: 1280px;">
        <!-- Account Header -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-4 mb-5" style="border-bottom: 1px solid #E8E0DA;">
            <div>
                <span class="d-inline-block fw-semibold px-3 py-1 rounded-pill mb-2 text-uppercase" style="font-size: 10px; letter-spacing: 0.3em; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                    Private Patron Suite
                </span>
                <h1 class="font-serif fs-2 fw-normal mb-1" style="color: #211D1E;">Account Security & Settings</h1>
                <p class="text-xs mb-0" style="color: #6B605B;">{{ $user->email }} &bull; Patron Since {{ $user->created_at->format('M Y') }}</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('account.dashboard') }}" class="btn py-2 px-3 text-xs text-uppercase tracking-wider rounded-3 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #541B29;">
                    &larr; Return to Dashboard
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn py-2 px-3 text-xs text-uppercase tracking-wider rounded-3 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #541B29; color: #541B29;">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-12 col-lg-3">
                <nav class="p-2 rounded-3 d-flex flex-column gap-1 text-xs shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <a href="{{ route('account.dashboard') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-decoration-none transition" style="color: #6B605B;">
                        <i class="fas fa-user-circle"></i>
                        <span>Patron Overview</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-decoration-none transition" style="color: #6B605B;">
                        <i class="fas fa-box-archive"></i>
                        <span>Order Dossiers</span>
                    </a>
                    <a href="{{ route('account.addresses') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-decoration-none transition" style="color: #6B605B;">
                        <i class="fas fa-location-dot"></i>
                        <span>Delivery Addresses</span>
                    </a>
                    <a href="{{ route('account.wishlist') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-decoration-none transition" style="color: #6B605B;">
                        <i class="fas fa-heart"></i>
                        <span>Wishlist Vault</span>
                    </a>
                    <a href="{{ route('account.reviews') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 text-decoration-none transition" style="color: #6B605B;">
                        <i class="fas fa-star"></i>
                        <span>Olfactory Reviews</span>
                    </a>
                    <a href="{{ route('account.settings') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 fw-semibold text-decoration-none" style="background-color: #FAF7F2; color: #541B29; border-left: 3px solid #541B29;">
                        <i class="fas fa-lock"></i>
                        <span>Security & Password</span>
                    </a>
                </nav>
            </div>

            <!-- Main Content Area -->
            <div class="col-12 col-lg-9 d-flex flex-column gap-4">

                <!-- Flash Notifications -->
                @if(session('success'))
                    <div class="p-3 rounded-3 d-flex align-items-center gap-3 text-xs" style="background-color: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46;">
                        <i class="fas fa-circle-check fs-5"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-3 rounded-3 text-xs" style="background-color: #FEF2F2; border: 1px solid #FECACA; color: #991B1B;">
                        <div class="d-flex align-items-center gap-2 fw-bold mb-1">
                            <i class="fas fa-triangle-exclamation"></i>
                            <span>Please correct the errors below:</span>
                        </div>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Password Change Card -->
                <div class="p-4 p-md-5 rounded-3 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-4" style="border-bottom: 1px solid #E8E0DA;">
                        <div>
                            <span class="d-inline-block text-uppercase fw-semibold mb-1" style="font-size: 10px; letter-spacing: 0.2em; color: #541B29;">Vault Credentials</span>
                            <h2 class="font-serif fs-4 fw-normal mb-0" style="color: #211D1E;">Change Account Password</h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: #FAF7F2; color: #541B29; border: 1px solid #E8E0DA;">
                            <i class="fas fa-key"></i>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('account.password.update') }}" class="d-flex flex-column gap-4">
                        @csrf
                        @method('PUT')

                        <!-- Current Password -->
                        <div>
                            <label for="patron_current_password" class="form-label text-xs fw-semibold text-uppercase tracking-wider" style="color: #4A3E39;">
                                Current Password <span class="text-danger">*</span>
                            </label>
                            <div class="position-relative">
                                <input type="password" 
                                       name="current_password" 
                                       id="patron_current_password" 
                                       required 
                                       class="form-control text-sm pe-5 py-2.5 rounded-3 @error('current_password') is-invalid @enderror" 
                                       style="border-color: #D3C5BC; background-color: #FAF7F2;" 
                                       placeholder="Enter your current password">
                                <button type="button" 
                                        class="btn position-absolute top-50 end-0 translate-middle-y border-0 text-muted px-3 py-0" 
                                        style="font-size: 14px;" 
                                        onclick="togglePasswordVisibility('patron_current_password', this)" 
                                        aria-label="Toggle password visibility">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <small class="text-danger d-block mt-1 text-xs">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <!-- New Password -->
                            <div class="col-12 col-md-6">
                                <label for="patron_new_password" class="form-label text-xs fw-semibold text-uppercase tracking-wider" style="color: #4A3E39;">
                                    New Password <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <input type="password" 
                                           name="password" 
                                           id="patron_new_password" 
                                           required 
                                           class="form-control text-sm pe-5 py-2.5 rounded-3 @error('password') is-invalid @enderror" 
                                           style="border-color: #D3C5BC; background-color: #FAF7F2;" 
                                           placeholder="At least 8 characters">
                                    <button type="button" 
                                            class="btn position-absolute top-50 end-0 translate-middle-y border-0 text-muted px-3 py-0" 
                                            style="font-size: 14px;" 
                                            onclick="togglePasswordVisibility('patron_new_password', this)" 
                                            aria-label="Toggle password visibility">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <small class="d-block mt-1 text-xs" style="color: #786C67;">Minimum 8 characters with letters and numbers.</small>
                                @error('password')
                                    <small class="text-danger d-block mt-1 text-xs">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Confirm New Password -->
                            <div class="col-12 col-md-6">
                                <label for="patron_password_confirmation" class="form-label text-xs fw-semibold text-uppercase tracking-wider" style="color: #4A3E39;">
                                    Confirm New Password <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <input type="password" 
                                           name="password_confirmation" 
                                           id="patron_password_confirmation" 
                                           required 
                                           class="form-control text-sm pe-5 py-2.5 rounded-3" 
                                           style="border-color: #D3C5BC; background-color: #FAF7F2;" 
                                           placeholder="Repeat new password">
                                    <button type="button" 
                                            class="btn position-absolute top-50 end-0 translate-middle-y border-0 text-muted px-3 py-0" 
                                            style="font-size: 14px;" 
                                            onclick="togglePasswordVisibility('patron_password_confirmation', this)" 
                                            aria-label="Toggle password visibility">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 d-flex justify-content-end">
                            <button type="submit" class="btn py-2.5 px-4 text-xs text-uppercase tracking-widest text-white rounded-3 shadow-sm d-inline-flex align-items-center gap-2" style="background-color: #541B29;">
                                <i class="fas fa-shield-halved"></i>
                                <span>Update Vault Password</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Personal Profile Details Card -->
                <div class="p-4 p-md-5 rounded-3 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-4" style="border-bottom: 1px solid #E8E0DA;">
                        <div>
                            <span class="d-inline-block text-uppercase fw-semibold mb-1" style="font-size: 10px; letter-spacing: 0.2em; color: #541B29;">Patron Profile</span>
                            <h2 class="font-serif fs-4 fw-normal mb-0" style="color: #211D1E;">Personal Information</h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: #FAF7F2; color: #541B29; border: 1px solid #E8E0DA;">
                            <i class="fas fa-id-card"></i>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('account.profile.update') }}" class="d-flex flex-column gap-3">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="name" class="form-label text-xs fw-semibold text-uppercase tracking-wider" style="color: #4A3E39;">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="form-control text-sm py-2.5 rounded-3" style="border-color: #D3C5BC; background-color: #FAF7F2;">
                                @error('name')
                                    <small class="text-danger d-block mt-1 text-xs">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-uppercase tracking-wider" style="color: #4A3E39;">
                                    Primary Email
                                </label>
                                <input type="email" value="{{ $user->email }}" disabled class="form-control text-sm py-2.5 rounded-3 bg-light text-muted" style="border-color: #E8E0DA;">
                                <small class="text-muted d-block mt-1 text-xs">Email is tied to your patron order history.</small>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="phone" class="form-label text-xs fw-semibold text-uppercase tracking-wider" style="color: #4A3E39;">
                                    Phone Number
                                </label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. 0300-1234567" class="form-control text-sm py-2.5 rounded-3" style="border-color: #D3C5BC; background-color: #FAF7F2;">
                                @error('phone')
                                    <small class="text-danger d-block mt-1 text-xs">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="city" class="form-label text-xs fw-semibold text-uppercase tracking-wider" style="color: #4A3E39;">
                                    City / Province
                                </label>
                                <input type="text" name="city" id="city" value="{{ old('city', $user->city) }}" placeholder="e.g. Lahore, Punjab" class="form-control text-sm py-2.5 rounded-3" style="border-color: #D3C5BC; background-color: #FAF7F2;">
                                @error('city')
                                    <small class="text-danger d-block mt-1 text-xs">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-2 d-flex justify-content-end">
                            <button type="submit" class="btn py-2.5 px-4 text-xs text-uppercase tracking-widest rounded-3 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #541B29; color: #541B29;">
                                Save Personal Details
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId, btn) {
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
</script>
@endsection
