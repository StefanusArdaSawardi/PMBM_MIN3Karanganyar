<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Portal - @yield('title', 'PMBM')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #eef5ed; /* Soft mint background */
            min-height: 100vh;
        }
        .sidebar {
            min-width: 260px;
            max-width: 260px;
            background-color: #ffffff;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            border-right: 1px solid rgba(0, 135, 68, 0.05);
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
            text-decoration: none;
        }
        .sidebar .nav-link:hover {
            color: #008744;
            background-color: #f8f9fa;
        }
        .sidebar .nav-link.active {
            background-color: #b2f5b6 !important; /* Hijau neon soft */
            color: #008744 !important;
            font-weight: 600;
            border-left: 4px solid #008744;
        }
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
            border-radius: 16px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.01) !important;
        }
        .badge-status {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="sidebar d-flex flex-column justify-content-between py-4">
        <div>
            <div class="px-4 pb-4 mb-3 d-flex align-items-center gap-2 border-bottom">
                <div class="d-inline-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid object-fit-contain">
                </div>
                <div>
                    <span class="fw-bold fs-6 text-dark d-block" style="line-height: 1.2;">Super Admin</span>
                    <small class="text-danger fw-bold" style="font-size: 0.7rem;">Super Admin Portal</small>
                </div>
            </div>

            <!-- Menu Navigation (Super Admin Fixed Version) -->
            <div class="nav flex-column mt-3">
                <a href="{{ route('super.dashboard') }}" class="nav-link {{ Request::is('super-admin/dashboard*') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('super.screen') }}" class="nav-link {{ Request::is('super-admin/screen-web*') ? 'active' : '' }}">
                    Screening
                </a>
                <a href="{{ route('super.applicant') }}" class="nav-link {{ Request::is('super-admin/applicant-list*') ? 'active' : '' }}">
                    Applicant List
                </a>
                <a href="{{ route('super.account') }}" class="nav-link {{ Request::is('super-admin/account-management*') ? 'active' : '' }}">
                    Account Management
                </a>
                <a href="{{ route('super.accepted') }}" class="nav-link {{ Request::is('super-admin/accepted-list*') ? 'active' : '' }}">
                    Accepted List
                </a>
            </div>
        </div>

        <div class="nav flex-column">
            <a href="{{ route('login') }}" class="nav-link text-danger fw-bold border-0">
                Logout
            </a>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="topbar d-flex align-items-center justify-content-between px-4 sticky-top">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small fw-medium">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Portal</a></li>
                    <li class="breadcrumb-item active text-success fw-bold" aria-current="page">@yield('title', 'Dashboard')</li>
                </ol>
            </nav>
            
            <div class="d-flex align-items-center gap-3">
                <div class="text-end">
                    <span class="fw-bold d-block text-dark small" style="line-height: 1.2;">Super Admin</span>
                    <small class="text-danger fw-semibold" style="font-size: 0.7rem;">Super Administrator</small>
                </div>
                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase" style="width: 38px; height: 38px; font-size: 0.85rem;">
                    SA
                </div>
            </div>
        </div>

        <div class="p-4">
            @yield('content')
        </div>
    </div>

</body>
</html>