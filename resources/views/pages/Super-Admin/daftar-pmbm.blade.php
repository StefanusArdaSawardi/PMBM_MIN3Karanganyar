@extends('layouts.super-admin')

@section('title', 'Applicant List')

@section('content')
<!-- HEADER UTAMA (Hanya Judul & Tombol Tambah Peserta) -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Daftar PMBM</h4>
        <p class="text-muted small mb-0">Manage and monitor university applicants for the current academic year.</p>
    </div>
</div>

<!-- BARIS FILTER DROPDOWN -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="card card-custom p-3 bg-white">
            <label class="form-label text-secondary small fw-bold text-uppercase mb-1" style="font-size: 0.75rem;">Tahun Pendaftaran</label>
            <select class="form-select border-0 bg-light fw-medium text-dark small" style="border-radius: 8px;">
                <option>2025 / 2026</option>
                <option>2024 / 2025</option>
            </select>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card card-custom p-3 bg-white">
            <label class="form-label text-secondary small fw-bold text-uppercase mb-1" style="font-size: 0.75rem;">Program Studi / Jalur</label>
            <select class="form-select border-0 bg-light fw-medium text-dark small" style="border-radius: 8px;">
                <option>Semua Program Studi</option>
                <option>Program Khusus</option>
                <option>Program Unggulan</option>
                <option>Program Fullday</option>
            </select>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card card-custom p-3 bg-white">
            <label class="form-label text-secondary small fw-bold text-uppercase mb-1" style="font-size: 0.75rem;">Status</label>
            <select class="form-select border-0 bg-light fw-medium text-dark small" style="border-radius: 8px;">
                <option>Semua Status</option>
                <option>Verified</option>
                <option>Pending</option>
                <option>Rejected</option>
            </select>
        </div>
    </div>
</div>

<!-- TABEL UTAMA APPLICANT LIST (REVISI: TOMBOL EXPORT MASUK KE CARD SINI) -->
<div class="card card-custom bg-white p-4 mb-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <h6 class="fw-bold text-dark mb-0">Recent Applicants</h6>
        <!-- Tombol Export nangkring rapi di dalam card kanan atas tabel -->
        <div class="d-flex gap-2 w-100 w-sm-auto justify-content-sm-end">
            <button class="btn btn-sm btn-light border bg-white text-dark fw-semibold small d-flex align-items-center gap-1.5 px-3 py-1.5" style="border-radius: 8px;" onclick="alert('Export PDF Berhasil!')">
                📄 Import PDF
            </button>
            <button class="btn btn-sm btn-light border bg-white text-dark fw-semibold small d-flex align-items-center gap-1.5 px-3 py-1.5" style="border-radius: 8px;" onclick="alert('Export Excel Berhasil!')">
                📊 Import Excel
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0" style="font-size: 0.9rem;">
            <thead class="table-light">
                <tr class="text-secondary small text-uppercase" style="font-size: 0.75rem;">
                    <th class="py-3 px-3">Nama Lengkap</th>
                    <th class="py-3">NIK</th>
                    <th class="py-3">Email & HP</th>
                    <th class="py-3">Program Studi</th>
                    <th class="py-3">Tahun</th>
                    <th class="py-3">Status</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row 1: Ahmad Dani -->
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">AD</div>
                            <div style="line-height: 1.2;">
                                <span class="fw-bold text-dark d-block">Ahmad Dani</span>
                                <small class="text-muted" style="font-size: 0.75rem;">ID: 2026001</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-dark fw-medium">3275012304950001</td>
                    <td style="line-height: 1.3;">
                        <span class="text-dark d-block">ahmad.d@email.com</span>
                        <small class="text-muted">+62 812-3456-7890</small>
                    </td>
                    <td><span class="fw-semibold text-secondary">Program Khusus</span></td>
                    <td class="text-dark">2026</td>
                    <td><span class="badge-status bg-success-subtle text-success">Verified</span></td>
                    <td class="text-center"><button class="btn btn-link btn-sm text-muted p-0 fs-5">⋮</button></td>
                </tr>
                
                <!-- Row 2: Siti Pertiwi -->
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-warning-subtle text-warning-emphasis rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">SP</div>
                            <div style="line-height: 1.2;">
                                <span class="fw-bold text-dark d-block">Siti Pertiwi</span>
                                <small class="text-muted" style="font-size: 0.75rem;">ID: 2026002</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-dark fw-medium">3275081211990005</td>
                    <td style="line-height: 1.3;">
                        <span class="text-dark d-block">siti.p@email.com</span>
                        <small class="text-muted">+62 856-9988-1122</small>
                    </td>
                    <td><span class="fw-semibold text-secondary">Program Unggulan</span></td>
                    <td class="text-dark">2026</td>
                    <td><span class="badge-status bg-warning-subtle text-warning-emphasis">Pending</span></td>
                    <td class="text-center"><button class="btn btn-link btn-sm text-muted p-0 fs-5">⋮</button></td>
                </tr>

                <!-- Row 3: Budi Nugraha -->
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">BN</div>
                            <div style="line-height: 1.2;">
                                <span class="fw-bold text-dark d-block">Budi Nugraha</span>
                                <small class="text-muted" style="font-size: 0.75rem;">ID: 2026003</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-dark fw-medium">3271040502010009</td>
                    <td style="line-height: 1.3;">
                        <span class="text-dark d-block">budi.n@email.com</span>
                        <small class="text-muted">+62 813-1122-3344</small>
                    </td>
                    <td><span class="fw-semibold text-secondary">Program Fullday</span></td>
                    <td class="text-dark">2026</td>
                    <td><span class="badge-status bg-danger-subtle text-danger">Rejected</span></td>
                    <td class="text-center"><button class="btn btn-link btn-sm text-muted p-0 fs-5">⋮</button></td>
                </tr>

                <!-- REVISI DATA BARU 4: Agus Hidayat -->
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">AH</div>
                            <div style="line-height: 1.2;">
                                <span class="fw-bold text-dark d-block">Agus Hidayat</span>
                                <small class="text-muted" style="font-size: 0.75rem;">ID: 2026004</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-dark fw-medium">3271092807000002</td>
                    <td style="line-height: 1.3;">
                        <span class="text-dark d-block">agus.h@email.com</span>
                        <small class="text-muted">+62 821-4455-6677</small>
                    </td>
                    <td><span class="fw-semibold text-secondary">Program Khusus</span></td>
                    <td class="text-dark">2026</td>
                    <td><span class="badge-status bg-success-subtle text-success">Verified</span></td>
                    <td class="text-center"><button class="btn btn-link btn-sm text-muted p-0 fs-5">⋮</button></td>
                </tr>

                <!-- REVISI DATA BARU 5: Dina Amalia -->
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-warning-subtle text-warning-emphasis rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">DA</div>
                            <div style="line-height: 1.2;">
                                <span class="fw-bold text-dark d-block">Dina Amalia</span>
                                <small class="text-muted" style="font-size: 0.75rem;">ID: 2026005</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-dark fw-medium">3275034410010003</td>
                    <td style="line-height: 1.3;">
                        <span class="text-dark d-block">dina.a@email.com</span>
                        <small class="text-muted">+62 878-9900-1122</small>
                    </td>
                    <td><span class="fw-semibold text-secondary">Program Fullday</span></td>
                    <td class="text-dark">2026</td>
                    <td><span class="badge-status bg-warning-subtle text-warning-emphasis">Pending</span></td>
                    <td class="text-center"><button class="btn btn-link btn-sm text-muted p-0 fs-5">⋮</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- PAGINATION AREA -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 mt-4 pt-3 border-top">
        <p class="text-muted small mb-0">Showing <strong>1</strong> to <strong>5</strong> of <strong>156</strong> results</p>
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0 gap-1">
                <li class="page-item disabled"><a class="page-link border-0 rounded-2" href="#">‹</a></li>
                <li class="page-item active"><a class="page-link border-0 rounded-2" style="background-color: #008744;" href="#">1</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-2 text-dark" href="#">2</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-2 text-dark" href="#">3</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-2 text-dark" href="#">...</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-2 text-dark" href="#">12</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-2 text-dark" href="#">›</a></li>
            </ul>
        </nav>
    </div>
</div>

<!-- RINGKASAN MINI STATISTIK BAWAH -->
<div class="row g-4">
    <div class="col-12 col-md-4">
        <div class="card card-custom p-4 bg-white">
            <p class="text-success small fw-bold text-uppercase mb-1" style="font-size: 0.75rem; tracking-spacing: 0.5px;">Total Registrations</p>
            <h3 class="fw-bold text-dark mb-1">1,248 <span class="fs-6 fw-semibold text-success ms-1">↗ 12%</span></h3>
            <small class="text-muted">New applications this month</small>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card card-custom p-4 bg-white">
            <p class="text-success small fw-bold text-uppercase mb-1" style="font-size: 0.75rem; tracking-spacing: 0.5px;">Verification Rate</p>
            <h3 class="fw-bold text-dark mb-1">85.4% <span class="fs-6 fw-semibold text-success ms-1">↗ 3%</span></h3>
            <small class="text-muted">Avg. processing time: 2 days</small>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card card-custom p-4 bg-white">
            <p class="text-success small fw-bold text-uppercase mb-1" style="font-size: 0.75rem; tracking-spacing: 0.5px;">Capacity Status</p>
            <h3 class="fw-bold text-dark mb-1">64% <span class="fs-6 fw-normal text-muted">Filled</span></h3>
            <small class="text-muted">800 of 1,250 seats allocated</small>
        </div>
    </div>
</div>
@endsection