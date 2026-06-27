@extends('layouts.super-admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold text-dark mb-1">Dashboard PMBM (Super Admin)</h4>
    <p class="text-muted small mb-0">Monitoring data penerimaan siswa baru mandiri secara real-time dengan hak akses penuh.</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3 bg-white">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="p-2 bg-light rounded-3 text-primary fs-5">👤</div>
                <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 small fw-bold">↗ +12%</span>
            </div>
            <p class="text-muted small fw-medium mb-1">Total Peserta</p>
            <h4 class="fw-bold text-dark mb-0">1,250</h4>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3 bg-white">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="p-2 bg-light rounded-3 text-success fs-5">📥</div>
                <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 small fw-bold">↗ +8%</span>
            </div>
            <p class="text-muted small fw-medium mb-1">Total Keterima</p>
            <h4 class="fw-bold text-dark mb-0">850</h4>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3 bg-white">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="p-2 bg-light rounded-3 text-danger fs-5">❌</div>
                <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5 py-1 small fw-bold">↘ +3%</span>
            </div>
            <p class="text-muted small fw-medium mb-1">Total Tidak Keterima</p>
            <h4 class="fw-bold text-dark mb-0">400</h4>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3 bg-white">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="p-2 bg-light rounded-3 text-warning fs-5">📈</div>
                <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 small fw-bold">↗ +5%</span>
            </div>
            <p class="text-muted small fw-medium mb-1">Tingkat Kelulusan</p>
            <h4 class="fw-bold text-dark mb-0">68%</h4>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-md-6">
        <div class="card card-custom p-4 bg-white h-100">
            <h6 class="fw-bold text-dark mb-3">Jumlah Pendaftar Per Tahun</h6>
            <div style="position: relative; height:240px; width:100%">
                <canvas id="chartJumlahDaftar"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card card-custom p-4 bg-white h-100">
            <h6 class="fw-bold text-dark mb-3">Jumlah Keterima Per Tahun</h6>
            <div style="position: relative; height:240px; width:100%">
                <canvas id="chartTotalKeterima"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card card-custom bg-white p-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <h6 class="fw-bold text-dark mb-0">Recent Registrations</h6>
        <div class="d-flex gap-2 w-100 w-sm-auto">
            <input type="text" class="form-control form-control-sm" placeholder="Search applicant..." style="max-width: 220px;">
            <button class="btn btn-sm text-white px-3 fw-semibold" style="background-color: #008744; border: none;">Export</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0" style="font-size: 0.9rem;">
            <thead class="table-light">
                <tr class="text-secondary small text-uppercase">
                    <th class="py-3 px-3">Nama</th>
                    <th class="py-3">Program Studi</th>
                    <th class="py-3">Tahun</th>
                    <th class="py-3">Status</th>
                    <th class="py-3">Tanggal Daftar</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftar as $p)
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success-subtle text-success rounded-circle p-2 d-inline-block" style="width: 32px; height:32px; text-align:center;">{{ $p['inisial'] }}</span>
                            <span class="fw-semibold text-dark">{{ $p['nama'] }}</span>
                        </div>
                    </td>
                    <td class="text-muted">{{ $p['prodi'] }}</td>
                    <td>{{ $p['tahun'] }}</td>
                    <td><span class="badge-status {{ $p['badge_class'] }}">{{ $p['status'] }}</span></td>
                    <td class="text-muted">{{ $p['tanggal'] }}</td>
                    <td class="text-center">
                        <button class="btn btn-link btn-sm text-muted p-0">⋮</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada pendaftar terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.font.size = 11;

    // 1. Chart 1: Line Linear Polos Pilihan Lu
    const ctxDaftar = document.getElementById('chartJumlahDaftar').getContext('2d');
    new Chart(ctxDaftar, {
        type: 'line', 
        data: {
            labels: ['2022', '2023', '2024', '2025'],
            datasets: [{
                data: [110, 135, 142, 154],
                borderColor: '#008744',
                borderWidth: 3,
                backgroundColor: '#008744',
                fill: false,
                tension: 0,
                pointBackgroundColor: '#008744',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { 
                y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.05)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Chart 2: Bar Chart
    const ctxKeterima = document.getElementById('chartTotalKeterima').getContext('2d');
    new Chart(ctxKeterima, {
        type: 'bar',
        data: {
            labels: ['2022', '2023', '2024', '2025'],
            datasets: [{
                data: [65, 78, 80, 86],
                backgroundColor: '#198754',
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endsection