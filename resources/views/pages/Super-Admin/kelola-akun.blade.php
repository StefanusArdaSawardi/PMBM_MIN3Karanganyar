@extends('layouts.super-admin')

@section('title', 'Kelola Akun Sistem')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Manajemen Pengguna & Akses Sistem</h4>
        <p class="text-muted small mb-0">Kelola akun operasional Admin TU dan distribusikan kuota antrean wawancara untuk Panitia Penguji.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap w-100 w-md-auto">
        <button class="btn btn-sm btn-outline-success fw-bold d-flex align-items-center gap-1.5 px-3 py-2" style="border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#modalTambahAdminTU">
            💼 + Admin TU
        </button>
        <button class="btn btn-sm text-white fw-bold d-flex align-items-center gap-1.5 px-3 py-2" style="background-color: #008744; border: none; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#modalTambahPanitia">
            🎓 + Panitia Penguji
        </button>
    </div>
</div>

<div class="card card-custom bg-white p-4 mb-4 border-0 shadow-sm" style="border-radius: 12px;">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-3">
        <h6 class="fw-bold text-dark mb-0">💼 Akun Operasional Admin TU</h6>
        <span class="badge bg-success-subtle text-success py-1.5 px-2.5 fw-bold" style="font-size: 0.75rem;">Total: {{ count($admins) }} Staff</span>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0" style="font-size: 0.9rem;">
            <thead class="table-light">
                <tr class="text-secondary small text-uppercase" style="font-size: 0.75rem;">
                    <th class="py-3 px-3">Nama Lengkap Staff</th>
                    <th class="py-3">Username Login</th>
                    <th class="py-3">Hak Akses</th>
                    <th class="py-3">Status</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">{{ $admin['avatar'] }}</div>
                            <div style="line-height: 1.2;">
                                <span class="fw-bold text-dark d-block">{{ $admin['nama'] }}</span>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ $admin['email'] }}</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-dark fw-medium">{{ $admin['username'] }}</td>
                    <td><span class="badge bg-success-subtle text-success px-2.5 py-1 rounded-pill small fw-semibold">Admin TU</span></td>
                    <td><span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 small fw-bold">{{ $admin['status'] }}</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-warning me-1" style="border-radius: 6px;" onclick="alert('Edit Akun Admin TU')">Edit</button>
                        <button class="btn btn-sm btn-outline-danger" style="border-radius: 6px;" onclick="return confirm('Hapus permanen akun Admin TU ini?')">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4 small">Belum ada data akun Admin TU di file JSON.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card card-custom bg-white p-4 mb-4 border-0 shadow-sm" style="border-radius: 12px;">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-3">
        <h6 class="fw-bold text-dark mb-0">🎓 Akun Panitia Penguji & Alokasi Antrean</h6>
        <span class="badge bg-primary-subtle text-primary py-1.5 px-2.5 fw-bold" style="font-size: 0.75rem;">Total: {{ count($panitias) }} Penguji</span>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0" style="font-size: 0.9rem;">
            <thead class="table-light">
                <tr class="text-secondary small text-uppercase" style="font-size: 0.75rem;">
                    <th class="py-3 px-3">Nama Penguji / Panitia</th>
                    <th class="py-3">Username</th>
                    <th class="py-3 text-center">Beban Kerja (Kuota)</th>
                    <th class="py-3">Daftar Antrean Anak Seleksi</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($panitias as $panitia)
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">{{ $panitia['avatar'] }}</div>
                            <div style="line-height: 1.2;">
                                <span class="fw-bold text-dark d-block">{{ $panitia['nama'] }}</span>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ $panitia['email'] }}</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-dark fw-medium">{{ $panitia['username'] }}</td>
                    <td class="text-center">
                        @if($panitia['kuota_terpakai'] == $panitia['kuota_maksimal'])
                            <span class="badge bg-danger-subtle text-danger px-2.5 py-1.5 fw-bold" style="border-radius: 6px;">{{ $panitia['kuota_terpakai'] }} / {{ $panitia['kuota_maksimal'] }} Anak (Penuh)</span>
                        @else
                            <span class="badge bg-success-subtle text-success px-2.5 py-1.5 fw-bold" style="border-radius: 6px;">{{ $panitia['kuota_terpakai'] }} / {{ $panitia['kuota_maksimal'] }} Anak</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($panitia['daftar_anak'] as $anak)
                                <span class="badge bg-light text-dark border small">{{ $anak }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-warning me-1" style="border-radius: 6px;" onclick="alert('Edit Akun Panitia')">Edit</button>
                        <button class="btn btn-sm btn-outline-danger" style="border-radius: 6px;" onclick="return confirm('Hapus penguji? Antrean kembali ke status global.')">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4 small">Belum ada data akun Panitia di file JSON.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambahAdminTU" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header border-0 pb-0 justify-content-between px-4 pt-4">
                <h5 class="modal-title fw-bold text-dark">💼 Daftarkan Staff Admin TU</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Akun Admin TU baru berhasil disimpan!'); window.location.reload();">
                <div class="modal-body px-4 pt-3 pb-4">
                    <div class="mb-3">
                        <!-- <label class="form-label small fw-semibold text-secondary mb-1">Nama Lengkap Staff</label>
                        <input type="text" class="form-control" placeholder="Contoh: Siti Aminah, S.Kom" required>
                    </div> -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary mb-1">Username Login</label>
                        <input type="text" class="form-control" placeholder="Contoh: amina_tu" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary mb-1">Password</label>
                        <input type="password" class="form-control" placeholder="******" required>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-sm btn-light py-2 px-3 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    <button type="submit" class="btn btn-sm text-white py-2 px-4 fw-bold" style="background-color: #198754; border: none; border-radius: 8px;">Simpan Akun Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahPanitia" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header border-0 pb-0 justify-content-between px-4 pt-4">
                <h5 class="modal-title fw-bold text-dark">🎓 Daftarkan Panitia Penguji</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Akun Panitia Penguji berhasil dibuat dengan auto alokasi 5 anak!'); window.location.reload();">
                <div class="modal-body px-4 pt-3 pb-4">
                    <!-- <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary mb-1">Nama Lengkap Penguji</label>
                        <input type="text" class="form-control" placeholder="Contoh: Prof. Supriyadi" required>
                    </div> -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary mb-1">Username Login</label>
                        <input type="text" class="form-control" placeholder="Contoh: supriyadi_penguji" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label small fw-semibold text-secondary mb-1">Password</label>
                            <input type="password" class="form-control" placeholder="******" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label small fw-bold text-success mb-1">Maksimal Anak</label>
                            <input type="number" class="form-control fw-bold text-dark" value="5" readonly>
                        </div>
                    </div>
                    <div class="p-2.5 border rounded-3 bg-light-subtle mb-0 text-muted" style="font-size: 0.72rem; line-height: 1.35;">
                        🚀 <strong>Sistem Auto-Distribute Aktif:</strong> Begitu akun disimpan, sistem akan langsung mengunci dan menarik 5 anak pendaftar pertama dari antrean global ke panel panitia ini.
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-sm btn-light py-2 px-3 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    <button type="submit" class="btn btn-sm text-white py-2 px-4 fw-bold" style="background-color: #008744; border: none; border-radius: 8px;">Generate Akun & Slot</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<style>
    .fw-extrabold { font-weight: 800 !important; }
    .table .badge.bg-light { font-weight: 500 !important; font-size: 0.75rem !important; padding: 5px 8px !important; border-radius: 6px !important; }
</style>