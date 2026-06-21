@extends('layouts.panitia')

@section('title', 'Penilaian')

@section('content')
<div class="row">
    <div class="col-12 col-xl-9 mx-auto">
        
        <div class="card card-custom bg-white p-4 mb-4 border-start border-4 border-success shadow-sm">
            <div class="row align-items-center">
                <div class="col-sm-8">
                    <span class="text-muted small font-monospace fw-bold text-uppercase" style="font-size: 0.75rem;">Sedang Diuji:</span>
                    <h4 class="fw-bold text-dark my-1" style="letter-spacing: -0.5px;">Muhammad Rizki Kasim</h4>
                    <p class="text-muted small mb-0">No. Daftar: <span class="font-monospace fw-bold text-success">PMB-2026-001</span> | Program Pendaftaran: <span class="badge bg-success-subtle text-success px-2 py-1 rounded">Program Khusus</span></p>
                </div>
                <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 fw-semibold" style="font-size: 0.8rem; border-radius: 8px;">Sesi Wawancara</span>
                </div>
            </div>
        </div>

        <div class="card card-custom bg-white p-4 p-sm-5 mb-5 border-0 shadow-sm">
            <h5 class="fw-bold text-dark mb-1">Instrumen Penilaian Calon Siswa</h5>
            <p class="text-muted small mb-4">Berikan penilaian berbasis angka dengan **Skala 1 s/d 10** pada setiap parameter kriteria di bawah ini.</p>
            <hr class="text-muted opacity-25 mb-4">
            
            <form id="formPenilaian" onsubmit="event.preventDefault(); tampilkanPopupRekomendasi();">
                
                <div class="mb-4">
                    <label for="hafalan" class="form-label fw-semibold text-secondary small mb-1">1. Nilai Opsi Hafalan (Skala 1 - 10)</label>
                    <input type="number" class="form-control py-2.5 fs-6" id="hafalan" name="hafalan" min="1" max="10" placeholder="Masukkan nilai angka 1 - 10" required>
                </div>

                <div class="mb-4">
                    <label for="tasmi" class="form-label fw-semibold text-secondary small mb-1">2. Nilai Bacaan Tasmi (Skala 1 - 10)</label>
                    <input type="number" class="form-control py-2.5 fs-6" id="tasmi" name="tasmi" min="1" max="10" placeholder="Masukkan nilai angka 1 - 10" required>
                </div>

                <div class="mb-4">
                    <label for="calistung" class="form-label fw-semibold text-secondary small mb-1">3. Nilai Kemampuan Calistung (Skala 1 - 10)</label>
                    <input type="number" class="form-control py-2.5 fs-6" id="calistung" name="calistung" min="1" max="10" placeholder="Masukkan nilai angka 1 - 10" required>
                </div>

                <div class="mb-4">
                    <label for="kemandirian" class="form-label fw-semibold text-secondary small mb-1">4. Nilai Aspek Kemandirian (Skala 1 - 10)</label>
                    <input type="number" class="form-control py-2.5 fs-6" id="kemandirian" name="kemandirian" min="1" max="10" placeholder="Masukkan nilai angka 1 - 10" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small d-block mb-1">5. Jalur Prestasi</label>
                    <div class="form-check p-3 border bg-light rounded-3 d-inline-flex align-items-center" style="min-width: 240px; cursor: pointer;">
                        <input class="form-check-input ms-0 me-2 mt-0" type="checkbox" id="prestasi" name="jalur_prestasi" value="1" style="cursor: pointer;">
                        <label class="form-check-label fw-bold text-dark small mb-0" for="prestasi" style="cursor: pointer;">🏆 Memiliki Sertifikat Prestasi</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="wawancara_ortu" class="form-label fw-semibold text-secondary small mb-1">6. Hasil Wawancara Orang Tua (Skala 1 - 10)</label>
                    <input type="number" class="form-control py-2.5 fs-6" id="wawancara_ortu" name="wawancara_ortu" min="1" max="10" placeholder="Masukkan rating angka 1 - 10" required>
                </div>

                <div class="mb-5">
                    <label for="catatan" class="form-label fw-semibold text-secondary small mb-1">7. Catatan Penguji</label>
                    <textarea class="form-control fs-6 bg-light" id="catatan" name="catatan" rows="4" placeholder="Tuliskan catatan khusus atau rekomendasi hasil wawancara di sini..."></textarea>
                </div>

                <div class="d-flex gap-3 border-top pt-4">
                    <a href="{{ route('panitia.antrean') }}" class="btn btn-light btn-md w-50 py-2.5 fw-bold rounded-3 border text-center text-decoration-none text-dark">
                        Batal & Kembali
                    </a>
                    <button type="submit" class="btn btn-success btn-md w-50 py-2.5 fw-bold rounded-3 text-white shadow-sm" style="background-color: #008744; border: none;">
                        Simpan Nilai & Selesai
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<div class="modal fade" id="modalRekomendasiManual" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 18px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header border-0 pb-0 justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-0 px-4 pb-4">
                <div class="display-4 mb-2">📋</div>
                <h5 class="fw-bold text-dark mb-1">Rekomendasi Program Studi</h5>
                <p class="text-muted small mb-4">Form nilai instrumen lengkap. Berdasarkan hasil wawancara, tentukan program akhir yang paling cocok untuk siswa ini:</p>
                
                <div class="mb-4 text-start">
                    <label class="form-label small fw-bold text-secondary mb-1">Pilih Program Rekomendasi</label>
                    <select class="form-select py-2.5 fs-6 fw-semibold text-dark" id="selectProgramRekomendasi" style="border-radius: 10px;" required>
                        <option value="" disabled selected>-- Pilih Program Kelayakan --</option>
                        <option value="Program Khusus (Tahfidz)">🟢 Program Khusus (Tahfidz)</option>
                        <option value="Program Unggulan">🔵 Program Unggulan</option>
                        <option value="Program Fullday">🟡 Program Fullday</option>
                    </select>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="button" class="btn btn-light w-50 py-2.5 fw-semibold small" data-bs-dismiss="modal" style="border-radius: 10px;">Kembali ke Form</button>
                    <button type="button" class="btn text-white w-50 py-2.5 fw-bold small" style="background-color: #008744; border-radius: 10px;" onclick="submitFinalPenilaian()">Konfirmasi & Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Munculkan pop-up modal rekomendasi setelah form tervalidasi lengkap HTML5
    function tampilkanPopupRekomendasi() {
        const modalRekomendasi = new bootstrap.Modal(document.getElementById('modalRekomendasiManual'));
        modalRekomendasi.show();
    }

    // 2. Eksekusi simpan final setelah panitia memilih program kelayakan di dalam pop-up
    function submitFinalPenilaian() {
        const programTerpilih = document.getElementById('selectProgramRekomendasi').value;

        if (!programTerpilih) {
            alert('Silakan tentukan program studi rekomendasi terlebih dahulu!');
            return;
        }

        // Sembunyikan pop-up modal
        const modalEl = document.getElementById('modalRekomendasiManual');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        modalInstance.hide();

        // Tampilkan alert sukses akhir dan lempar balik ke daftar antrean
        alert('Nilai wawancara beserta rekomendasi ke "' + programTerpilih + '" berhasil disimpan ke dalam sistem PMBM!');
        window.location.href = "{{ route('panitia.antrean') }}";
    }
</script>
@endsection