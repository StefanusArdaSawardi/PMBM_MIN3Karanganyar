@extends('layouts.super-admin')

@section('title', 'Account Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Kelola Akun Pengguna</h4>
        <p class="text-muted small mb-0">Manajemen hak akses, role pengguna, dan konfigurasi status akun sistem PMBM.</p>
    </div>
    <div class="d-flex gap-2 w-100 w-md-auto justify-content-md-end">
        <button class="btn btn-sm text-white px-4 py-2.5 fw-semibold d-flex align-items-center gap-2 rounded-3" style="background-color: #008744; border: none;" data-bs-toggle="modal" data-bs-target="#modalTambahAkun">
            ➕ Tambah Pengguna Baru
        </button>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
        <div class="card card-custom p-3 bg-white border-0 shadow-sm">
            <label class="form-label text-secondary small fw-bold text-uppercase mb-1" style="font-size: 0.75rem;">Filter Hak Akses / Role</label>
            <select class="form-select border-0 bg-light fw-medium text-dark small" style="border-radius: 8px;">
                <option>Semua Role</option>
                <option>Admin TU</option>
                <option>Panitia Penguji</option>
            </select>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card card-custom p-3 bg-white border-0 shadow-sm">
            <label class="form-label text-secondary small fw-bold text-uppercase mb-1" style="font-size: 0.75rem;">Filter Status Akun</label>
            <select class="form-select border-0 bg-light fw-medium text-dark small" style="border-radius: 8px;">
                <option>Semua Status</option>
                <option>Active</option>
                <option>Suspended / Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="card card-custom bg-white p-4 mb-4 border-0 shadow-sm">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <h6 class="fw-bold text-dark mb-0">Daftar Pengguna Sistem</h6>
        <div class="d-flex gap-2 w-100 w-sm-auto justify-content-sm-end">
            <input type="text" class="form-control form-control-sm bg-light border-0 small" placeholder="Cari nama atau email..." style="border-radius: 8px; width: 200px;">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0" style="font-size: 0.9rem;">
            <thead class="table-light">
                <tr class="text-secondary small text-uppercase" style="font-size: 0.75rem;">
                    <th class="py-3 px-3">Identitas Pengguna</th>
                    <th class="py-3">Username</th>
                    <th class="py-3">Role / Hak Akses</th>
                    <th class="py-3">Status</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row 1: Muhamad Rizki -->
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">MR</div>
                            <div style="line-height: 1.2;">
                                <span class="fw-bold text-dark d-block">Muhamad Rizki</span>
                                <small class="text-muted" style="font-size: 0.75rem;">rizki@pmbm.ac.id</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-dark fw-medium">rizki_admin</td>
                    <td><span class="badge bg-primary-subtle text-primary px-2.5 py-1 rounded-pill small fw-semibold">Admin TU</span></td>
                    <td><span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 small fw-bold">Active</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-warning py-1 px-2 me-1" style="border-radius: 6px;" onclick="alert('Fitur Edit Akun')">Edit</button>
                        <button class="btn btn-sm btn-outline-danger py-1 px-2 me-1" style="border-radius: 6px;" onclick="confirm('Nonaktifkan akun ini?')">Suspend</button>
                        <!-- BARU: Tombol Hapus Akun -->
                        <button class="btn btn-sm btn-outline-danger py-1 px-2" style="border-radius: 6px; background-color: rgba(220, 53, 69, 0.05);" onclick="return confirm('Apakah Anda yakin ingin menghapus permanen akun Muhamad Rizki dari sistem?')">Hapus</button>
                    </td>
                </tr>

                <!-- Row 2: Hendra Pratama -->
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-warning-subtle text-warning-emphasis rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">HP</div>
                            <div style="line-height: 1.2;">
                                <span class="fw-bold text-dark d-block">Hendra Pratama</span>
                                <small class="text-muted" style="font-size: 0.75rem;">hendra.p@pmbm.ac.id</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-dark fw-medium">hendra_penguji</td>
                    <td><span class="badge bg-info-subtle text-info-emphasis px-2.5 py-1 rounded-pill small fw-semibold">Panitia Penguji</span></td>
                    <td><span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 small fw-bold">Active</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-warning py-1 px-2 me-1" style="border-radius: 6px;" onclick="alert('Fitur Edit Akun')">Edit</button>
                        <button class="btn btn-sm btn-outline-danger py-1 px-2 me-1" style="border-radius: 6px;" onclick="confirm('Nonaktifkan akun ini?')">Suspend</button>
                        <!-- BARU: Tombol Hapus Akun -->
                        <button class="btn btn-sm btn-outline-danger py-1 px-2" style="border-radius: 6px; background-color: rgba(220, 53, 69, 0.05);" onclick="return confirm('Apakah Anda yakin ingin menghapus permanen akun Hendra Pratama dari sistem?')">Hapus</button>
                    </td>
                </tr>

                <!-- Row 3: Eka Cipta -->
                <tr>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-secondary-subtle text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">EC</div>
                            <div style="line-height: 1.2;">
                                <span class="fw-bold text-dark d-block">Eka Cipta</span>
                                <small class="text-muted" style="font-size: 0.75rem;">eka.c@pmbm.ac.id</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-dark fw-medium">eka_cipta</td>
                    <td><span class="badge bg-info-subtle text-info-emphasis px-2.5 py-1 rounded-pill small fw-semibold">Panitia Penguji</span></td>
                    <td><span class="badge bg-danger-subtle text-danger rounded-pill px-2.5 py-1 small fw-bold">Suspended</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-warning py-1 px-2 me-1" style="border-radius: 6px;" onclick="alert('Fitur Edit Akun')">Edit</button>
                        <button class="btn btn-sm btn-outline-success py-1 px-2 me-1" style="border-radius: 6px;" onclick="alert('Akun diaktifkan kembali!')">Activate</button>
                        <!-- BARU: Tombol Hapus Akun -->
                        <button class="btn btn-sm btn-outline-danger py-1 px-2" style="border-radius: 6px; background-color: rgba(220, 53, 69, 0.05);" onclick="return confirm('Apakah Anda yakin ingin menghapus permanen akun Eka Cipta dari sistem?')">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambahAkun" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Tambah Pengguna Sistem Baru</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Akun pengguna baru berhasil dibuat!');">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="Contoh: Ahmad Sofyan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Email Resmi</label>
                        <input type="email" class="form-control" placeholder="Contoh: sofyan@pmbm.ac.id" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Username</label>
                        <input type="text" class="form-control" placeholder="Contoh: sofyan_tu" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Password Awal</label>
                        <input type="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Pilih Hak Akses / Role</label>
                        <select class="form-select">
                            <option value="admin_tu">Admin TU</option>
                            <option value="panitia">Panitia Penguji</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm text-white" style="background-color: #008744; border: none;">Buat Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection