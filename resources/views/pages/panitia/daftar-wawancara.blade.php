@extends('layouts.panitia')

@section('title', 'Penilaian')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Antrean Uji Wawancara</h4>
        <p class="text-muted small mb-0">Daftar calon siswa yang berstatus pending dan siap diuji hari ini.</p>
    </div>
    <div class="text-sm-end bg-white px-3 py-2 rounded-3 border border-success-subtle shadow-sm">
        <span class="fs-4 fw-bold text-success">3</span> 
        <span class="text-muted small fw-medium">Siswa Tersisa</span>
    </div>
</div>

<div class="card card-custom bg-white p-4 mb-4 border-0 shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h6 class="fw-bold text-dark mb-0">Waiting List Peserta</h6>
        <input type="text" class="form-control form-control-sm bg-light border-0 small" placeholder="Cari nomor atau nama..." style="border-radius: 8px; width: 220px;">
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
            <thead class="table-light">
                <tr class="text-secondary small text-uppercase" style="font-size: 0.75rem;">
                    <th class="py-3 px-3">No. Daftar</th>
                    <th class="py-3">Nama Lengkap</th>
                    <th class="py-3">NISN</th>
                    <th class="py-3">Program Pilihan</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-3 font-monospace fw-bold text-secondary">PMB-2026-001</td>
                    <td>
                        <span class="fw-bold text-dark">Muhammad Rizki Kasim</span>
                    </td>
                    <td class="text-muted font-monospace">1234567890</td>
                    <td>
                        <span class="badge bg-success-subtle text-success px-2.5 py-1.5 rounded fw-bold text-uppercase" style="font-size: 0.7rem;">
                            Program Khusus
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('panitia.penilaian') }}" class="btn btn-success btn-sm px-3 py-1.5 fw-bold text-white shadow-sm" style="background-color: #008744; border: none; border-radius: 8px;">
                            📋 Mulai Uji
                        </a>
                    </td>
                </tr>
                
                <tr>
                    <td class="px-3 font-monospace fw-bold text-secondary">PMB-2026-002</td>
                    <td>
                        <span class="fw-bold text-dark">Ahmad Kasim</span>
                    </td>
                    <td class="text-muted font-monospace">0987654321</td>
                    <td>
                        <span class="badge bg-primary-subtle text-primary px-2.5 py-1.5 rounded fw-bold text-uppercase" style="font-size: 0.7rem;">
                            Program Unggulan
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('panitia.penilaian') }}" class="btn btn-success btn-sm px-3 py-1.5 fw-bold text-white shadow-sm" style="background-color: #008744; border: none; border-radius: 8px;">
                            📋 Mulai Uji
                        </a>
                    </td>
                </tr>
                
                <tr>
                    <td class="px-3 font-monospace fw-bold text-secondary">PMB-2026-003</td>
                    <td>
                        <span class="fw-bold text-dark">Siti Aminah</span>
                    </td>
                    <td class="text-muted font-monospace">5544332211</td>
                    <td>
                        <span class="badge bg-info-subtle text-info-emphasis px-2.5 py-1.5 rounded fw-bold text-uppercase" style="font-size: 0.7rem;">
                            Program Fullday
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('panitia.penilaian') }}" class="btn btn-success btn-sm px-3 py-1.5 fw-bold text-white shadow-sm" style="background-color: #008744; border: none; border-radius: 8px;">
                            📋 Mulai Uji
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection