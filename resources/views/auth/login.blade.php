<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CMS PMBM</title>
    <!-- Bootstrap 5.3.3 CDN via cdnjs -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
        }
        .bg-pmbm {
            background-color: #008744 !important;
        }
        .text-pmbm {
            color: #008744 !important;
        }
        .btn-pmbm {
            background-color: #008744;
            color: #ffffff;
            border: none;
            transition: all 0.2s ease-in-out;
        }
        .btn-pmbm:hover {
            background-color: #006e36;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 135, 68, 0.2);
        }
        .form-control:focus, .form-select:focus {
            border-color: #008744;
            box-shadow: 0 0 0 0.25rem rgba(0, 135, 68, 0.15);
        }
        .login-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5">
                
                <!-- Logo / Judul Atas Card -->
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center mb-2" style="width: 100px; height: 100px;">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo PMBM" class="img-fluid object-fit-contain" style="max-height: 100%;">
                    </div>
                    <h3 class="fw-extrabold tracking-tight text-dark mb-1">CMS PMBM</h3>
                    <p class="text-muted small">Silakan masuk ke sistem pengelolaan pendaftaran</p>
                </div>

                <!-- Card Login -->
                <div class="card login-card bg-white p-4 p-sm-5">
                    <div id="pmbmLoginForm">
                        
                        <!-- Pilihan Role (UPDATE: Tambah Super Admin) -->
                        <div class="mb-4">
                            <label for="role" class="form-label small fw-semibold text-secondary">Masuk Sebagai</label>
                            <select class="form-select form-select-lg py-2.5 fs-6" id="role" name="role" required>
                                <option value="" disabled selected> Pilih Hak Akses </option>
                                <option value="super_admin">Super Admin</option>
                                <option value="admin_tu">Admin TU</option>
                                <option value="panitia">Panitia Penguji / Wawancara</option>
                            </select>
                        </div>

                        <!-- Input Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold text-secondary">Alamat Email</label>
                            <input type="email" class="form-control form-control-lg py-2.5 fs-6" id="email" placeholder="nama@sekolah.sch.id" required>
                        </div>

                        <!-- Input Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label small fw-semibold text-secondary mb-1">Kata Sandi</label>
                            <input type="password" class="form-control form-control-lg py-2.5 fs-6" id="password" placeholder="••••••••" required>
                        </div>

                        <!-- Tombol Login -->
                        <button type="button" id="btnSubmitLogin" class="btn btn-pmbm btn-lg w-100 py-2.5 fw-bold fs-6 rounded-3">
                            Masuk Ke Sistem
                        </button>
                    </div>
                </div>

                <!-- Footer Text -->
                <div class="text-center mt-4">
                    <p class="text-muted small">&copy; 2026 PMBM Sistem. All Rights Reserved.</p>
                </div>

            </div>
        </div>
    </div>

    <!-- Script JavaScript dengan Logika Super Admin Baru -->
    <script>
        document.getElementById('btnSubmitLogin').addEventListener('click', function() {
            const roleSelected = document.getElementById('role').value;
            
            if (!roleSelected) {
                alert('Silakan pilih hak akses terlebih dahulu!');
                return;
            }
            
            if (roleSelected === 'super_admin') {
                window.location.href = "{{ route('super.dashboard') }}";
            } else if (roleSelected === 'admin_tu') {
                window.location.href = "{{ route('tu.dashboard') }}";
            } else if (roleSelected === 'panitia') {
                window.location.href = "{{ route('panitia.antrean') }}";
            }
        });
    </script>
</body>
</html>