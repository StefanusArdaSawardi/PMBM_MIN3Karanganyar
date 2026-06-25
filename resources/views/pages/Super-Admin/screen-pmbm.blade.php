@extends('layouts.super-admin')

@section('title', 'Screening')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold text-dark mb-1">Manajemen Konten Web Depan (CMS)</h4>
    <p class="text-muted small mb-0">Kelola konten landing page, pengaturan program, countdown gelombang, dan dokumen panduan secara dinamis.</p>
</div>

<div class="row g-4">
    <div class="col-12 col-xl-8">
        
        <div class="card card-custom bg-white p-4 mb-4">
            <h6 class="fw-bold text-dark mb-3">🖥️ Konten Utama Landing Page</h6>
            <hr class="text-muted opacity-25 mb-4">
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Judul landing page berhasil diperbarui!');">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Judul Priode (Main Heading)</label>
                    <input type="text" class="form-control" value="PMBM Admission 2026/2027">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Judul Utama (Main Heading)</label>
                    <input type="text" class="form-control" value="">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Sub-Judul / Deskripsi Singkat</label>
                    <textarea class="form-control" rows="3"></textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-sm text-white px-4 fw-semibold" style="background-color: #008744; border: none;">Update Teks</button>
                </div>
            </form>
        </div>

        <div class="card card-custom bg-white p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0">🎓 Kategori Program Studi / Jalur</h6>
                <button class="btn btn-sm text-white px-3 fw-semibold" style="background-color: #008744; border: none; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#modalTambahProgram">
                    + Tambah Program
                </button>
            </div>
            <hr class="text-muted opacity-25 mb-3">
            
            <div class="table-responsive">
                <table class="table align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="py-2 px-3">Nama Program/Jalur</th>
                            <th class="py-2">Tipe</th>
                            <th class="py-2">Kuota</th>
                            <th class="py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr>
                            <td class="px-3 fw-semibold text-dark">Program Khusus</td>
                            <td class="text-muted">Fokus pada pendalaman hafalan Al-Qur'an (Tahfidz) dengan target mutqin serta penguatan karakter kemandirian siswa.</td>
                            <td>
                                <ul class="mb-0 ps-3 text-muted small">
                                    <li>Target Hafalan 30 Juz</li>
                                    <li>Setoran Tasmi Sekali Duduk</li>
                                    <li>Fasilitas Asrama Eksklusif</li>
                                </ul>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning py-1 px-2 me-1" onclick="alert('Fitur Edit Program')">Edit</button>
                                <button class="btn btn-sm btn-outline-danger py-1 px-2" onclick="confirm('Hapus program ini?')">Hapus</button>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="px-3 fw-semibold text-dark">Program Unggulan</td>
                            <td class="text-muted">Berfokus pada pengembangan kompetensi sains terintegrasi dan teknologi digital masa kini untuk kesiapan kompetisi global.</td>
                            <td>
                                <ul class="mb-0 ps-3 text-muted small">
                                    <li>Kurikulum Berbasis IT</li>
                                    <li>Mentoring Olimpiade Sains</li>
                                    <li>Akses Kelas Praktikum Digital</li>
                                </ul>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning py-1 px-2 me-1" onclick="alert('Fitur Edit Program')">Edit</button>
                                <button class="btn btn-sm btn-outline-danger py-1 px-2" onclick="confirm('Hapus program ini?')">Hapus</button>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="px-3 fw-semibold text-dark">Program Fullday</td>
                            <td class="text-muted">Menekankan pada pembentukan karakter islami sehari-hari, kepemimpinan, serta kemampuan dasar calistung yang matang.</td>
                            <td>
                                <ul class="mb-0 ps-3 text-muted small">
                                    <li>Pembiasaan Ibadah Harian</li>
                                    <li>Kelas Minat Bakat Interaktif</li>
                                    <li>Pendidikan Karakter Leader</li>
                                </ul>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning py-1 px-2 me-1" onclick="alert('Fitur Edit Program')">Edit</button>
                                <button class="btn btn-sm btn-outline-danger py-1 px-2" onclick="confirm('Hapus program ini?')">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

<div class="card card-custom bg-white p-4 mb-4">
            <h6 class="fw-bold text-dark mb-1">📜 Manajemen Syarat & Ketentuan</h6>
            <p class="text-muted small mb-3">Sesuaikan isi dokumen pendaftaran yang wajib dipenuhi oleh calon siswa di halaman depan.</p>
            <hr class="text-muted opacity-25 mb-4">
            
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Seluruh kriteria persyaratan berhasil disimpan!');">
                
                <div class="mb-4 p-3 rounded-3 bg-light-subtle border">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-danger px-2.5 py-1.5 fw-bold text-uppercase" style="font-size: 0.7rem; border-radius: 6px;">Wajib</span>
                        <label class="form-label fw-bold text-dark mb-0 small">Persyaratan Wajib Umum</label>
                    </div>
                    <textarea class="form-control bg-white small" rows="3" placeholder="Gunakan baris baru untuk memisahkan kriteria...">1. Umur minimal 6 Tahun per Juli 2026&#10;2. Memiliki Email aktif</textarea>
                    <div class="form-text text-muted" style="font-size: 0.75rem;">Akan tampil di tabel kriteria wajib utama siswa.</div>
                </div>

                <div class="mb-4 p-3 rounded-3 bg-light-subtle border">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-primary px-2.5 py-1.5 fw-bold text-uppercase" style="font-size: 0.7rem; border-radius: 6px;">Berkas</span>
                        <label class="form-label fw-bold text-dark mb-0 small">Syarat Berkas Dokumen & Format File</label>
                    </div>
                    <textarea class="form-control bg-white small" rows="5" placeholder="Contoh format penulisan:&#10;Pas Foto Berwarna (JPG, PNG)&#10;Kartu Keluarga Asli (PDF)">Pas Foto Berwarna (JPG, PNG, JPEG)&#10;Kartu Keluarga Asli (PDF)&#10;Akta Kelahiran Asli (PDF)&#10;Kartu Identitas Anak / KIA (PDF)&#10;NISN Dari TK asal (PDF)</textarea>
                    <div class="form-text text-muted" style="font-size: 0.75rem;">Tuliskan nama dokumen diikuti format file di dalam kurung agar terpecah otomatis.</div>
                </div>

                <div class="mb-4 p-3 rounded-3 bg-light-subtle border">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-secondary px-2.5 py-1.5 fw-bold text-uppercase" style="font-size: 0.7rem; border-radius: 6px;">Opsional</span>
                        <label class="form-label fw-bold text-dark mb-0 small">Persyaratan Tambahan (Opsional)</label>
                    </div>
                    <textarea class="form-control bg-white small" rows="3" placeholder="Tulis berkas pendukung opsional jika ada...">1. Sertifikat Prestasi Akademik / Non-Akademik (PDF)&#10;2. Kartu Indonesia Pintar / KIP jika ada (PDF)</textarea>
                    <div class="form-text text-muted" style="font-size: 0.75rem;">Berkas tambahan yang tidak menggagalkan status kelulusan berkas utama.</div>
                </div>

                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-sm text-white px-4 py-2 fw-semibold" style="background-color: #008744; border: none; border-radius: 8px;">
                        Simpan Semua Syarat
                    </button>
                </div>
            </form>
        </div>

    </div>

    <div class="col-12 col-xl-4">
        
        <div class="card card-custom bg-white p-4 mb-4">
            <h6 class="fw-bold text-dark mb-3">⏳ Countdown Penutupan Gelombang</h6>
            <hr class="text-muted opacity-25 mb-3">
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Timer countdown berhasil diatur!');">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Pilih Tanggal & Waktu Target</label>
                    <input type="datetime-local" class="form-control" value="2026-07-30T23:59">
                </div>
                <div class="bg-light p-2 rounded-3 mb-3 text-center">
                    <small class="text-muted d-block small">Preview teks di web depan:</small>
                    <span class="fw-bold text-success" style="font-size: 0.85rem;">Sisa Waktu: 42 Hari 05 Jam lagi!</span>
                </div>
                <button type="submit" class="btn btn-sm text-white w-100 fw-semibold" style="background-color: #008744; border: none;">Atur Ulang Countdown</button>
            </form>
        </div>

        <div class="card card-custom bg-white p-4 mb-4">
            <h6 class="fw-bold text-dark mb-3">📁 Panduan & Booklet Digital</h6>
            <hr class="text-muted opacity-25 mb-3">
            <form action="#" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); alert('File booklet berhasil diupload!');">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Upload File Booklet Terbaru</label>
                    <input type="file" class="form-control" accept=".pdf">
                    <div class="form-text small" style="font-size: 0.75rem;">Format wajib: .PDF (Maksimal ukuran 5MB)</div>
                </div>
                <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fs-4">📄</span>
                        <div style="line-height: 1.1;">
                            <small class="fw-bold d-block text-dark" style="font-size: 0.8rem;">booklet_pmbm_2026.pdf</small>
                            <small class="text-muted" style="font-size: 0.7rem;">Ukuran: 3.4 MB</small>
                        </div>
                    </div>
                    <span class="badge bg-success">Aktif</span>
                </div>
                <button type="submit" class="btn btn-sm text-white w-100 fw-semibold mt-3" style="background-color: #008744; border: none;">Upload & Ganti Booklet</button>
            </form>
        </div>

    </div>
</div>

<div class="modal fade" id="modalTambahProgram" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Tambah Konten Program Web Profil</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Konten program baru berhasil disimpan ke landing page!');">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Kategori Program</label>
                        <input type="text" class="form-control" placeholder="" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nama Program</label>
                        <input type="text" class="form-control" placeholder="" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Fokus Program (Deskripsi Singkat)</label>
                        <textarea class="form-control" rows="3" placeholder="" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Poin-Poin Program (Gunakan baris baru untuk setiap poin)</label>
                        <textarea class="form-control" rows="4" placeholder="Contoh:&#10;- Bebas Biaya Gedung&#10;- Kurikulum Internasional&#10;- Sertifikasi Oracle" required></textarea>
                        <div class="form-text small" style="font-size: 0.75rem;">Setiap baris baru otomatis menjadi satu poin list di halaman depan.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm text-white" style="background-color: #008744; border: none;">Simpan ke Web</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection