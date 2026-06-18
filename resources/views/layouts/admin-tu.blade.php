<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PMBM - @yield('title')</title>
    <!-- Bootstrap 5.3.3 CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #eef5ed; /* Mengikuti warna bg soft mint di gambar */
            min-height: 100vh;
        }
        /* Sidebar Styling */
        .sidebar {
            min-width: 260px;
            max-width: 260px;
            background-color: #ffffff;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }
        .sidebar .nav-link {
            color: #6c757d;
            font-weight: 500;
            padding: 12px 24px;
            margin: 4px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }
        .sidebar .nav-link:hover {
            color: #008744;
            background-color: #f8f9fa;
        }
        .sidebar .nav-link.active {
            background-color: #b2f5b6 !important; /* Warna hijau neon soft aktif sesuai gambar */
            color: #008744 !important;
            font-weight: 600;
            border-left: 4px solid #008744;
        }
        /* Content Area Adjustments */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
        }
        .topbar {
            background-color: #ffffff;
            height: 70px;
            border-bottom: 1px solid #e9ecef;
        }
        .card-custom {
            border: 1px solid rgba(0, 135, 68, 0.1) !important;
            border-radius: 16px !important; /* Rounded melengkung sesuai gambar */
            box-shadow: 0 4px 12px rgba(0,0,0,0.01) !important;
        }
        .avatar-box {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: #dee2e6;
            object-fit: cover;
        }
        .badge-status {
            font-weight: 600;
            font-size: 0.75rem;
            padding: 6px 14px;
            border-radius: 50px;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR UTAMA -->
    <div class="sidebar d-flex flex-column justify-content-between py-4">
        <div>
            <!-- Header Logo Instansi -->
            <div class="px-4 pb-4 mb-3 d-flex align-items-center gap-2 border-bottom">
                <div class="d-inline-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid object-fit-contain">
                </div>
                <div>
                    <span class="fw-bold fs-6 text-dark d-block" style="line-height: 1.2;">Admin</span>
                    <small class="text-muted" style="font-size: 0.75rem;">Admin Portal</small>
                </div>
            </div>

            <!-- Menu Navigation (Sesuai List Bahasa Inggris di Gambar) -->
            <div class="nav flex-column mt-3">
                <a href="{{ route('tu.dashboard') }}" class="nav-link {{ Request::is('admin-tu/dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('tu.screen') }}" class="nav-link {{ Request::is('admin-tu/screen-web') ? 'active' : '' }}">
                    Screening
                </a>
                <a href="{{ route('tu.applicant') }}" class="nav-link {{ Request::is('admin-tu/applicant-list') ? 'active' : '' }}">
                    Applicant List
                </a>
                <a href="{{ route('tu.account') }}" class="nav-link {{ Request::is('admin-tu/account-management') ? 'active' : '' }}">
                    Account Management
                </a>
                <a href="{{ route('tu.accepted') }}" class="nav-link {{ Request::is('admin-tu/accepted-list') ? 'active' : '' }}">
                    Accepted List
                </a>
            </div>
        </div>

        <!-- Tombol Logout Bottom -->
        <div class="nav flex-column">
            <a href="{{ route('login') }}" class="nav-link text-danger fw-bold">
                Logout
            </a>
        </div>
    </div>

    <!-- MAIN WRAPPER (Kanan) -->
    <div class="main-wrapper">
        <!-- Topbar Sesuai Elemen Gambar -->
        <div class="topbar d-flex align-items-center justify-content-between px-4 sticky-top">
            <!-- Breadcrumbs Kiri -->
            <nav aria-label="breadcrumb" class="mb-0">
                <ol class="breadcrumb mb-0 small fw-medium">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Pages</a></li>
                    <li class="breadcrumb-item active text-success fw-bold" aria-current="page">Dashboard</li>
                </ol>
            </nav>
            
            <!-- User Profile Kanan -->
            <div class="d-flex align-items-center gap-3">
                <div class="text-end">
                    <span class="fw-bold d-block text-dark small" style="line-height: 1.2;">Admin Utama</span>
                    <small class="text-muted" style="font-size: 0.7rem;">Registrar Office</small>
                </div>
                <!-- Slicing dummy bulat profil placeholder -->
                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase" style="width: 38px; height: 38px; font-size: 0.85rem;">
                    AU
                </div>
            </div>
        </div>

        <!-- Bagian Isi Konten Per-Halaman -->
        <div class="p-4">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>