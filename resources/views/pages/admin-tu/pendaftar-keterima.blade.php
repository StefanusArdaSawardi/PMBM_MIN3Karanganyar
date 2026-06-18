@extends('layouts.admin-tu')

@section('title', 'Accepted List')

@section('content')
<!-- HEADER UTAMA & CARD TOTAL MAHASISWA DITERIMA (SESUAI GAMBAR) -->
<div class="row g-4 mb-4 align-items-center">
    <div class="col-12 col-md-7">
        <h4 class="fw-bold text-dark mb-1">Daftar Mahasiswa Diterima</h4>
        <p class="text-muted small mb-0">Kelola data administrasi dan status registrasi ulang mahasiswa baru.</p>
    </div>
    <div class="col-12 col-md-5 text-md-end">
        <!-- Card Hijau Info Total Sesuai image_438a8d.png -->
        <div class="card p-3 text-white border-0 d-inline-flex flex-row align-items-center gap-3 text-start shadow-sm w-100 justify-content-center justify-content-md-start" style="background-color: #008744; border-radius: 12px; max-width: 320px; float: right;">
            <div class="fs-2 opacity-75">🧑‍🤝‍🧑</div>
            <div style="line-height: 1.2;">
                <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Total Mahasiswa Diterima</small>
                <h4 class="fw-bold mb-0">850 <span class="fs-6 fw-normal text-white-50">Mahasiswa</span></h4>
            </div>
        </div>
    </div>
</div>

<!-- CARD CONTAINER UTAMA (FILTER & TABEL) -->
<div class="card card-custom bg-white p-4 mb-4 border-0 shadow-sm">
    
    <!-- BARIS ACTION BAR: FILTER & TOMBOL CETAK -->
    <div class="row g-2 mb-4 align-items-center">
        <!-- Kolom Cari Nama -->
        <div class="col-12 col-md-3">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-0 text-muted">🔍</span>
                <input type="text" class="form-control bg-light border-0" placeholder="Cari Nama atau NIK..." style="font-size: 0.85rem;">
            </div>
        </div>
        <!-- Kolom Filter Program -->
        <div class="col-12 col-md-3">
            <select class="form-select form-select-sm bg-light border-0 fw-medium text-dark" style="font-size: 0.85rem;">
                <option>Semua Program</option>
                <option>Program Khusus</option>
                <option>Program Unggulan</option>
                <option>Program Fullday</option>
            </select>
        </div>
        <!-- Kolom Kelompok Tombol Cetak / Ekspor Kanan -->
        <div class="col-12 col-md-6 text-md-end d-flex gap-2 justify-content-start justify-content-md-end flex-wrap">
            <button class="btn btn-sm btn-white border bg-white text-dark fw-semibold d-flex align-items-center gap-1.5 px-3 py-1.5" style="border-radius: 8px;" onclick="alert('Export PDF Berhasil!')">
                📄 Export PDF
            </button>
            <button class="btn btn-sm btn-white border bg-white text-dark fw-semibold d-flex align-items-center gap-1.5 px-3 py-1.5" style="border-radius: 8px;" onclick="alert('Export Excel Berhasil!')">
                📊 Export Excel
            </button>
            <button class="btn btn-sm text-white px-3 py-1.5 fw-semibold d-flex align-items-center gap-1.5" style="background-color: #008744; border: none; border-radius: 8px;" onclick="window.print()">
                🖨️ Print
            </button>
        </div>
    </div>

    <!-- DATA TABEL MAHASISWA DITERIMA -->
    <div class="table-responsive">
        <table class="table align-middle mb-0" style="font-size: 0.9rem;">
            <thead class="table-light">
                <tr class="text-secondary small text-uppercase" style="font-size: 0.75rem;">
                    <th class="py-3 px-3">Nama Mahasiswa</th>
                    <th class="py-3">NIK</th>
                    <th class="py-3">Program Studi</th>
                    <th class="py-3">Tahun</th>
                    <th class="py-3">Tanggal Diterima</th>
                    <th class="py-3">Status Registrasi</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Baris 1: Sudah Registrasi -->
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">AD</div>
                            <span class="fw-bold text-dark">Aditya Darmawan</span>
                        </div>
                    </td>
                    <td class="text-secondary fw-medium">3271041203990005</td>
                    <td><span class="fw-medium text-dark">Program Khusus</span></td>
                    <td class="text-muted">2026</td>
                    <td class="text-muted">12 Mar 2026</td>
                    <td>
                        <span class="badge-status bg-success-subtle text-success d-inline-flex align-items-center gap-1 fw-bold text-uppercase" style="font-size: 0.7rem;">
                            ✔ Sudah Registrasi
                        </span>
                    </td>
                    <td class="text-center"><button class="btn btn-link btn-sm text-muted p-0 fs-5">⋮</button></td>
                </tr>

                <!-- Baris 2: Belum Registrasi -->
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">SN</div>
                            <span class="fw-bold text-dark">Siti Nurhaliza</span>
                        </div>
                    </td>
                    <td class="text-secondary fw-medium">3271052406010001</td>
                    <td><span class="fw-medium text-dark">Program Unggulan</span></td>
                    <td class="text-muted">2026</td>
                    <td class="text-muted">14 Mar 2026</td>
                    <td>
                        <span class="badge-status bg-danger-subtle text-danger d-inline-flex align-items-center gap-1 fw-bold text-uppercase" style="font-size: 0.7rem;">
                            🚫 Belum Registrasi
                        </span>
                    </td>
                    <td class="text-center"><button class="btn btn-link btn-sm text-muted p-0 fs-5">⋮</button></td>
                </tr>

                <!-- Baris 3: Sudah Registrasi -->
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">BP</div>
                            <span class="fw-bold text-dark">Budi Pratama</span>
                        </div>
                    </td>
                    <td class="text-secondary fw-medium">3271091507000002</td>
                    <td><span class="fw-medium text-dark">Program Fullday</span></td>
                    <td class="text-muted">2026</td>
                    <td class="text-muted">15 Mar 2026</td>
                    <td>
                        <span class="badge-status bg-success-subtle text-success d-inline-flex align-items-center gap-1 fw-bold text-uppercase" style="font-size: 0.7rem;">
                            ✔ Sudah Registrasi
                        </span>
                    </td>
                    <td class="text-center"><button class="btn btn-link btn-sm text-muted p-0 fs-5">⋮</button></td>
                </tr>

                <!-- Baris 4: Sudah Registrasi -->
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">RK</div>
                            <span class="fw-bold text-dark">Rina Kusuma</span>
                        </div>
                    </td>
                    <td class="text-secondary fw-medium">3271020211020008</td>
                    <td><span class="fw-medium text-dark">Program Khusus</span></td>
                    <td class="text-muted">2026</td>
                    <td class="text-muted">18 Mar 2026</td>
                    <td>
                        <span class="badge-status bg-success-subtle text-success d-inline-flex align-items-center gap-1 fw-bold text-uppercase" style="font-size: 0.7rem;">
                            ✔ Sudah Registrasi
                        </span>
                    </td>
                    <td class="text-center"><button class="btn btn-link btn-sm text-muted p-0 fs-5">⋮</button></td>
                </tr>

                <!-- Baris 5: Belum Registrasi -->
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">FF</div>
                            <span class="fw-bold text-dark">Farhan Fadilah</span>
                        </div>
                    </td>
                    <td class="text-secondary fw-medium">3271011112010003</td>
                    <td><span class="fw-medium text-dark">Program Fullday</span></td>
                    <td class="text-muted">2026</td>
                    <td class="text-muted">20 Mar 2026</td>
                    <td>
                        <span class="badge-status bg-danger-subtle text-danger d-inline-flex align-items-center gap-1 fw-bold text-uppercase" style="font-size: 0.7rem;">
                            🚫 Belum Registrasi
                        </span>
                    </td>
                    <td class="text-center"><button class="btn btn-link btn-sm text-muted p-0 fs-5">⋮</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- AREA PAGINATION TABEL -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 mt-4 pt-3 border-top">
        <p class="text-muted small mb-0">Menampilkan <strong>5</strong> dari <strong>850</strong> Mahasiswa</p>
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0 gap-1">
                <li class="page-item disabled"><a class="page-link border-0 rounded-2" href="#">‹</a></li>
                <li class="page-item active"><a class="page-link border-0 rounded-2" style="background-color: #008744;" href="#">1</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-2 text-dark" href="#">2</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-2 text-dark" href="#">3</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-2 text-dark" href="#">...</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-2 text-dark" href="#">170</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-2 text-dark" href="#">›</a></li>
            </ul>
        </nav>
    </div>
</div>

<!-- BOX ALERT INFORMASI PENTING DI BAWAH (SESUAI IMAGE_438ARD.PNG) -->
<div class="alert p-3 border-0 d-flex align-items-start gap-2 mb-2" style="background-color: #e8f4ec; border-left: 4px solid #008744 !important; border-radius: 8px;">
    <span class="fs-5" style="color: #008744; line-height: 1;">ℹ️</span>
    <div style="font-size: 0.85rem; color: #1e4620;">
        <strong>Informasi Penting:</strong> Mahasiswa yang belum melakukan registrasi ulang hingga tanggal 30 Juni 2026 akan dianggap mengundurkan diri secara otomatis. Harap berikan notifikasi kepada program studi terkait.
    </div>
</div>
@endsection