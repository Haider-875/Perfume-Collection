<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login | Perfumes Collection</title>

    <!-- Google Fonts: DM Sans & Jost -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Jost:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS ONLY -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e293b;
            padding: 1.5rem;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            padding: 2.25rem;
            position: relative;
        }

        .brand-title {
            font-family: 'Jost', sans-serif;
            font-weight: 700;
            letter-spacing: 0.12em;
            color: #0f172a;
            font-size: 1.25rem;
            text-transform: uppercase;
            margin-top: 0.75rem;
            margin-bottom: 0.25rem;
        }

        .brand-subtitle {
            font-size: 0.72rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 600;
        }

        .input-group-text {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: #64748b;
        }

        .form-control {
            border-color: #cbd5e1;
            padding: 0.65rem 0.85rem;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.12);
        }

        .btn-admin-submit {
            background-color: #0f172a;
            border-color: #0f172a;
            color: #ffffff;
            padding: 0.7rem 1.25rem;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-admin-submit:hover {
            background-color: #1e293b;
            border-color: #1e293b;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        }

        .credential-helper {
            background-color: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.78rem;
            color: #475569;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Brand Header with Logo -->
        <div class="text-center mb-4">
            <a href="{{ route('home') }}" class="d-inline-block text-decoration-none">
                <img src="{{ asset('assets/images/brand/logo.png') }}" alt="Perfumes Collection" style="height: 65px; width: auto; object-fit: contain;">
                <div class="brand-title">PERFUMES COLLECTION</div>
                <div class="brand-subtitle">Administrative Control Center</div>
            </a>
        </div>

        <!-- Flash & Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show text-xs py-2 px-3 mb-3 d-flex align-items-center gap-2" role="alert">
                <i class="fa-solid fa-circle-check text-success"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto p-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show text-xs py-2 px-3 mb-3 d-flex align-items-center gap-2" role="alert">
                <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto p-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show text-xs py-2 px-3 mb-3 d-flex align-items-center gap-2" role="alert">
                <i class="fa-solid fa-circle-exclamation text-warning"></i>
                <div>{{ session('warning') }}</div>
                <button type="button" class="btn-close ms-auto p-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show text-xs py-2 px-3 mb-3" role="alert">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="fa-solid fa-circle-exclamation text-danger"></i>
                    <strong>Authentication Error</strong>
                </div>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close ms-auto p-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('admin.login.submit') }}" method="POST" id="adminLoginForm">
            @csrf

            <!-- Email Input -->
            <div class="mb-3">
                <label for="adminEmail" class="form-label small fw-semibold text-secondary">Administrator Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" 
                           class="form-control" 
                           id="adminEmail" 
                           name="email" 
                           value="{{ old('email', 'admin@perfumecollection.pk') }}" 
                           placeholder="admin@perfumecollection.pk" 
                           required 
                           autofocus>
                </div>
            </div>

            <!-- Password Input -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="adminPassword" class="form-label small fw-semibold text-secondary mb-0">Password</label>
                </div>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" 
                           class="form-control border-end-0" 
                           id="adminPassword" 
                           name="password" 
                           value="admin123456"
                           placeholder="••••••••" 
                           required>
                    <button class="btn btn-outline-secondary border-start-0 border-start-0 bg-white" 
                            type="button" 
                            id="togglePasswordBtn"
                            title="Show/Hide Password"
                            style="border-color: #cbd5e1;">
                        <i class="fa-solid fa-eye text-muted" id="togglePasswordIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="rememberAdmin" checked>
                    <label class="form-check-label small text-secondary" for="rememberAdmin">
                        Stay signed in
                    </label>
                </div>
                <span class="badge bg-light text-secondary border small py-1 px-2">Role: Admin</span>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-admin-submit w-100 mb-3 d-flex align-items-center justify-content-center gap-2">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>Sign In to Admin Panel</span>
            </button>
        </form>

        <!-- Quick One-Click Credentials Helper -->
        <div class="credential-helper mb-3">
            <div class="d-flex align-items-center justify-content-between mb-1.5">
                <strong class="text-dark small"><i class="fa-solid fa-key text-primary me-1"></i> Admin Credentials:</strong>
                <button type="button" class="btn btn-xs btn-outline-primary py-0 px-2" style="font-size: 0.72rem;" onclick="fillCredentials('admin@perfumecollection.pk', 'admin123456')">
                    Auto-Fill
                </button>
            </div>
            <div class="text-muted d-flex justify-content-between">
                <span>Email: <code class="text-dark">admin@perfumecollection.pk</code></span>
            </div>
            <div class="text-muted d-flex justify-content-between mt-1">
                <span>Pass: <code class="text-dark">admin123456</code></span>
                <span class="text-muted">or <code class="text-dark">admin@ravaha.pk</code></span>
            </div>
        </div>

        <!-- Back to Storefront Link -->
        <div class="text-center pt-2">
            <a href="{{ route('home') }}" class="text-decoration-none text-muted small">
                <i class="fa-solid fa-arrow-left me-1"></i> Return to Perfumes Collection Store
            </a>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Password Visibility Toggle
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('adminPassword');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passwordInput && toggleIcon) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                toggleIcon.classList.toggle('fa-eye', !isPassword);
                toggleIcon.classList.toggle('fa-eye-slash', isPassword);
            });
        }

        // Quick Autofill Helper
        function fillCredentials(email, pass) {
            document.getElementById('adminEmail').value = email;
            document.getElementById('adminPassword').value = pass;
        }
    </script>
</body>
</html>
