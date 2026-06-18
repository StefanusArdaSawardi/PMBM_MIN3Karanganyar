<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panitia - Daftar Wawancara PMBM</title>
    <!-- Bootstrap 5.3.3 CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
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
        }
        .btn-pmbm:hover {
            background-color: #006e36;
            color: #ffffff;
        }
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        }
    </style>
</head>
<body>

    <!-- Topbar Panitia -->
    <nav class="navbar bg-white border-b border-gray-200 py-3 shadow-sm sticky-top">
        <div class="container">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-pmbm text-white rounded d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px;">
                    P
                </div>
                <span class="fw-bold fs-5 text-dark">PMBM <span class="text-muted fs-6">Panitia Penguji</span></span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-2 rounded-pill fw-semibold">Mode: Wawancara</span>
                <a href="{{ route('login') }}" class="btn btn-outline-danger btn-sm fw-medium px-3 rounded-pill">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Tabel Daftar Konten -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">Antrean Uji Wawancara</h4>
                        <p class="text-muted small mb-0">Daftar calon siswa yang berstatus pending dan siap diuji hari ini.</p>
                    </div>
                    <div class="text-end">
                        <span class="fs-4 fw-bold text-pmbm">3</span> <span class="text-muted small">Siswa Tersisa</span>
                    </div>
                </div>

                <div class="card card-custom bg-white p-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-3 py-3 small text-uppercase fw-semibold text-secondary">No. Daftar</th>
                                    <th class="py-3 small text-uppercase fw-semibold text-secondary">Nama Lengkap</th>
                                    <th class="py-3 small text-uppercase fw-semibold text-secondary">NISN</th>
                                    <th class="py-3 small text-uppercase fw-semibold text-secondary">Program Pilihan</th>
                                    <th class="py-3 small text-uppercase fw-semibold text-secondary text-end px-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-3 font-monospace fw-bold text-secondary">PMB-2026-001</td>
                                    <td><div class="fw-bold text-dark">Muhammad Rizki</div></td>
                                    <td class="text-muted">1234567890</td>
                                    <td><span class="badge bg-success-subtle text-success px-2.5 py-1.5 rounded">Khusus Tahfidz</span></td>
                                    <td class="text-end px-3">
                                        <a href="{{ route('panitia.penilaian') }}" class="btn btn-pmbm btn-sm px-3 py-1.5 rounded-3 fw-semibold">📋 Mulai Uji</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-3 font-monospace fw-bold text-secondary">PMB-2026-002</td>
                                    <td><div class="fw-bold text-dark">Ahmad Kasim</div></td>
                                    <td class="text-muted">0987654321</td>
                                    <td><span class="badge bg-primary-subtle text-primary px-2.5 py-1.5 rounded">Unggulan Sains</span></td>
                                    <td class="text-end px-3">
                                        <a href="{{ route('panitia.penilaian') }}" class="btn btn-pmbm btn-sm px-3 py-1.5 rounded-3 fw-semibold">📋 Mulai Uji</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-3 font-monospace fw-bold text-secondary">PMB-2026-003</td>
                                    <td><div class="fw-bold text-dark">Siti Aminah</div></td>
                                    <td class="text-muted">5544332211</td>
                                    <td><span class="badge bg-info-subtle text-info px-2.5 py-1.5 rounded">Full-day Karakter</span></td>
                                    <td class="text-end px-3">
                                        <a href="{{ route('panitia.penilaian') }}" class="btn btn-pmbm btn-sm px-3 py-1.5 rounded-3 fw-semibold">📋 Mulai Uji</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>