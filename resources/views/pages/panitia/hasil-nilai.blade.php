@extends('layouts.panitia')

@section('title', 'Hasil Nilai')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Riwayat Hasil Nilai Wawancara</h4>
        <p class="text-muted small mb-0">Daftar calon siswa yang telah selesai mengikuti uji instrumen wawancara oleh tim penguji.</p>
    </div>
    <div class="bg-white px-3 py-2 rounded-3 border border-success-subtle shadow-sm text-sm-end">
        <span class="text-muted small fw-medium">Selesai Diuji:</span>
        <span class="fs-5 fw-bold text-success ms-1">142</span>
        <span class="text-muted small fw-medium">Siswa</span>
    </div>
</div>

<div class="card card-custom bg-white p-4 mb-4 border-0 shadow-sm">
    
    <div class="row g-2 mb-4 align-items-center">
        <div class="col-12 col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-0 text-muted">🔍</span>
                <input type="text" class="form-control bg-light border-0" placeholder="Cari nama atau nomor daftar..." style="font-size: 0.85rem;">
            </div>
        </div>
        <div class="col-12 col-md-4">
            <select class="form-select form-select-sm bg-light border-0 fw-medium text-dark" style="font-size: 0.85rem;">
                <option>Semua Program Pilihan</option>
                <option>Program Khusus</option>
                <option>Program Unggulan</option>
                <option>Program Fullday</option>
            </select>
        </div>
        <div class="col-12 col-md-4">
            <select class="form-select form-select-sm bg-light border-0 fw-medium text-dark" style="font-size: 0.85rem;">
                <option>Semua Status Kelayakan</option>
                <option>Direkomendasikan</option>
                <option>Dipertimbangkan</option>
                <option>Tidak Direkomendasikan</option>
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
            <thead class="table-light">
                <tr class="text-secondary small text-uppercase" style="font-size: 0.75rem;">
                    <th class="py-3 px-3">No. Daftar</th>
                    <th class="py-3">Nama Lengkap</th>
                    <th class="py-3 text-center">Rata-Rata Nilai</th>
                    <th class="py-3">Program Pilihan</th>
                    <th class="py-3">Status Kelayakan</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-3 font-monospace fw-bold text-secondary">PMB-2026-044</td>
                    <td>
                        <div class="fw-bold text-dark">Rizky Ramadhan</div>
                        <small class="text-muted" style="font-size: 0.75rem;">NISN: 0012948110</small>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success-subtle text-success fs-6 px-2.5 py-1 fw-bold">92.5</span>
                    </td>
                    <td><span class="fw-medium text-secondary">Program Khusus</span></td>
                    <td>
                        <span class="badge-status bg-success-subtle text-success d-inline-flex align-items-center gap-1 fw-bold text-uppercase" style="font-size: 0.65rem;">
                            🟢 Direkomendasikan
                        </span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary py-1 px-2.5" onclick="alert('Buka detail lembar instrumen penilaian')">Detail</button>
                    </td>
                </tr>

                <tr>
                    <td class="px-3 font-monospace fw-bold text-secondary">PMB-2026-045</td>
                    <td>
                        <div class="fw-bold text-dark">Farhan Alkatiri</div>
                        <small class="text-muted" style="font-size: 0.75rem;">NISN: 0023847119</small>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-warning-subtle text-warning-emphasis fs-6 px-2.5 py-1 fw-bold">78.0</span>
                    </td>
                    <td><span class="fw-medium text-secondary">Program Unggulan</span></td>
                    <td>
                        <span class="badge-status bg-warning-subtle text-warning-emphasis d-inline-flex align-items-center gap-1 fw-bold text-uppercase" style="font-size: 0.65rem;">
                            🟡 Dipertimbangkan
                        </span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary py-1 px-2.5" onclick="alert('Buka detail lembar instrumen penilaian')">Detail</button>
                    </td>
                </tr>

                <tr>
                    <td class="px-3 font-monospace fw-bold text-secondary">PMB-2026-046</td>
                    <td>
                        <div class="fw-bold text-dark">Siti Humaira</div>
                        <small class="text-muted" style="font-size: 0.75rem;">NISN: 0011837482</small>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success-subtle text-success fs-6 px-2.5 py-1 fw-bold">88.5</span>
                    </td>
                    <td><span class="fw-medium text-secondary">Program Fullday</span></td>
                    <td>
                        <span class="badge-status bg-success-subtle text-success d-inline-flex align-items-center gap-1 fw-bold text-uppercase" style="font-size: 0.65rem;">
                            🟢 Direkomendasikan
                        </span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary py-1 px-2.5" onclick="alert('Buka detail lembar instrumen penilaian')">Detail</button>
                    </td>
                </tr>

                <tr>
                    <td class="px-3 font-monospace fw-bold text-secondary">PMB-2026-047</td>
                    <td>
                        <div class="fw-bold text-dark">Bagas Saputra</div>
                        <small class="text-muted" style="font-size: 0.75rem;">NISN: 0039485112</small>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-danger-subtle text-danger fs-6 px-2.5 py-1 fw-bold">54.0</span>
                    </td>
                    <td><span class="fw-medium text-secondary">Program Unggulan</span></td>
                    <td>
                        <span class="badge-status bg-danger-subtle text-danger d-inline-flex align-items-center gap-1 fw-bold text-uppercase" style="font-size: 0.65rem;">
                            🔴 Tidak Layak
                        </span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary py-1 px-2.5" onclick="alert('Buka detail lembar instrumen penilaian')">Detail</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 mt-4 pt-3 border-top">
        <p class="text-muted small mb-0">Menampilkan <strong>4</strong> dari <strong>142</strong> riwayat uji</p>
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0 gap-1">
                <li class="page-item disabled"><a class="page-link border-0 rounded-2" href="#">‹</a></li>
                <li class="page-item active"><a class="page-link border-0 rounded-2" style="background-color: #008744;" href="#">1</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-2 text-dark" href="#">2</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-2 text-dark" href="#">3</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-2 text-dark" href="#">›</a></li>
            </ul>
        </nav>
    </div>
</div>
@endsection