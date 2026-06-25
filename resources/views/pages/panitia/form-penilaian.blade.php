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
                    <p class="text-muted small mb-0">No. Daftar: <span class="font-monospace fw-bold text-success">PMB-2026-001</span> | Program Asal: <span class="badge bg-success-subtle text-success px-2 py-1 rounded">Program Khusus</span></p>
                </div>
                <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 fw-semibold" style="font-size: 0.8rem; border-radius: 8px;">Sesi Wawancara</span>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4 d-none" id="cardEvaluasiOtomatis">
            <div class="col-12 col-md-6">
                <div class="p-4 border bg-white h-100 shadow-sm" style="border-radius: 12px; border-left: 4px solid #008744 !important;">
                    <h6 class="fw-bold text-dark mb-3 small text-uppercase" style="font-size:0.75rem; letter-spacing:0.5px;">Hasil Uji Wawancara</h6>
                    <div class="d-flex flex-column gap-2" style="font-size: 0.85rem;">
                        <div><span class="text-muted">Total Skor Rata-rata:</span> <strong class="text-dark fs-5" id="resRataRata">0</strong></div>
                        <div><span class="text-muted">Kategori Nilai:</span> <strong class="text-success" id="resKategori">Bagus</strong></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="p-4 border bg-white h-100 shadow-sm" style="border-radius: 12px; border-left: 4px solid #ffc107 !important;">
                    <h6 class="fw-bold text-dark mb-3 small text-uppercase" style="font-size:0.75rem; letter-spacing:0.5px;">Evaluasi Kelayakan</h6>
                    <div class="d-flex flex-column gap-2" style="font-size: 0.85rem;">
                        <div><span class="text-muted">Rekomendasi Program:</span> <strong class="text-dark text-uppercase" id="resProgram">Program Unggulan</strong></div>
                        <div><span class="text-muted">Status Kelulusan:</span> <strong class="text-primary" id="resStatus">Layak Dipertimbangkan</strong></div>
                    </div>
                    <p class="text-muted mb-0 mt-2" style="font-size: 0.75rem; line-height: 1.4;">
                        Data kelayakan wawancara dihitung otomatis dari akumulasi instrumen penguji PMBM University.
                    </p>
                </div>
            </div>
        </div>

        <div class="card card-custom bg-white p-4 p-sm-5 mb-5 border-0 shadow-sm">
            <h5 class="fw-bold text-dark mb-1">Instrumen Penilaian Calon Siswa</h5>
            <p class="text-muted small mb-4">Berikan penilaian berbasis angka dengan **Skala 10 s/d 100** pada setiap parameter kriteria di bawah ini.</p>
            <hr class="text-muted opacity-25 mb-4">
            
            <form id="formPenilaian" onsubmit="event.preventDefault(); eksekusiEvaluasiOtomatis();">
                
                <div class="mb-4">
                    <label for="hafalan" class="form-label fw-semibold text-secondary small mb-1">1. Nilai Opsi Hafalan (Skala 10 - 100)</label>
                    <input type="number" class="form-control py-2.5 fs-6" id="hafalan" name="hafalan" min="10" max="100" placeholder="Contoh: 85" required>
                </div>

                <div class="mb-4">
                    <label for="tasmi" class="form-label fw-semibold text-secondary small mb-1">2. Nilai Bacaan Tasmi (Skala 10 - 100)</label>
                    <input type="number" class="form-control py-2.5 fs-6" id="tasmi" name="tasmi" min="10" max="100" placeholder="Contoh: 90" required>
                </div>

                <div class="mb-4">
                    <label for="calistung" class="form-label fw-semibold text-secondary small mb-1">3. Nilai Kemampuan Calistung (Skala 10 - 100)</label>
                    <input type="number" class="form-control py-2.5 fs-6" id="calistung" name="calistung" min="10" max="100" placeholder="Contoh: 75" required>
                </div>

                <div class="mb-4">
                    <label for="kemandirian" class="form-label fw-semibold text-secondary small mb-1">4. Nilai Aspek Kemandirian (Skala 10 - 100)</label>
                    <input type="number" class="form-control py-2.5 fs-6" id="kemandirian" name="kemandirian" min="10" max="100" placeholder="Contoh: 80" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small d-block mb-1">5. Jalur Prestasi</label>
                    <div class="form-check p-3 border bg-light rounded-3 d-inline-flex align-items-center" style="min-width: 240px; cursor: pointer;">
                        <input class="form-check-input ms-0 me-2 mt-0" type="checkbox" id="prestasi" name="jalur_prestasi" value="1" style="cursor: pointer;">
                        <label class="form-check-label fw-bold text-dark small mb-0" for="prestasi" style="cursor: pointer;">🏆 Memiliki Sertifikat Prestasi</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="wawancara_ortu" class="form-label fw-semibold text-secondary small mb-1">6. Hasil Wawancara Orang Tua (Skala 10 - 100)</label>
                    <input type="number" class="form-control py-2.5 fs-6" id="wawancara_ortu" name="wawancara_ortu" min="10" max="100" placeholder="Contoh: 85" required>
                </div>

                <div class="mb-5">
                    <label for="catatan" class="form-label fw-semibold text-secondary small mb-1">7. Catatan Penguji</label>
                    <textarea class="form-control fs-6 bg-light" id="catatan" name="catatan" rows="4" placeholder="Tuliskan catatan khusus atau rekomendasi hasil wawancara di sini..."></textarea>
                </div>

                <div class="d-flex gap-3 border-top pt-4" id="areaTombolAwal">
                    <a href="{{ route('panitia.antrean') }}" class="btn btn-light btn-md w-50 py-2.5 fw-bold rounded-3 border text-center text-decoration-none text-dark">
                        Batal & Kembali
                    </a>
                    <button type="submit" class="btn btn-success btn-md w-50 py-2.5 fw-bold rounded-3 text-white shadow-sm" style="background-color: #008744; border: none;">
                        Simpan Nilai & Selesai
                    </button>
                </div>

                <div class="d-flex gap-3 border-top pt-4 d-none" id="areaTombolSelesai">
                    <button type="button" class="btn btn-secondary btn-md w-100 py-2.5 fw-bold rounded-3 text-white shadow-sm" onclick="window.location.href='{{ route('panitia.antrean') }}'">
                        ✔ Selesai & Kembali ke Antrean
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function eksekusiEvaluasiOtomatis() {
        // 1. Ambil semua komponen nilai skala 10-100
        const n1 = parseFloat(document.getElementById('hafalan').value) || 0;
        const n2 = parseFloat(document.getElementById('tasmi').value) || 0;
        const n3 = parseFloat(document.getElementById('calistung').value) || 0;
        const n4 = parseFloat(document.getElementById('kemandirian').value) || 0;
        const n6 = parseFloat(document.getElementById('wawancara_ortu').value) || 0;

        // 2. Hitung rata-rata skor akhir
        const rataRata = (n1 + n2 + n3 + n4 + n6) / 5;

        // Tampilkan skor rata-rata ke element hasil
        document.getElementById('resRataRata').innerText = rataRata.toFixed(1);

        // 3. Logika penentuan evaluasi otomatis
        const resKategori = document.getElementById('resKategori');
        const resProgram = document.getElementById('resProgram');
        const resStatus = document.getElementById('resStatus');

        if (rataRata >= 85) {
            resKategori.innerText = "Sangat Bagus 🟢";
            resKategori.className = "text-success fs-5 fw-bold";
            resProgram.innerText = "Program Khusus (Tahfidz)";
            resStatus.innerText = "Direkomendasikan Mutqin";
            resStatus.className = "text-success fw-bold";
        } else if (rataRata >= 70 && rataRata < 85) {
            resKategori.innerText = "Bagus 🔵";
            resKategori.className = "text-primary fs-5 fw-bold";
            resProgram.innerText = "Program Unggulan";
            resStatus.innerText = "Layak Dipertimbangkan";
            resStatus.className = "text-primary fw-bold";
        } else {
            resKategori.innerText = "Cukup 🟡";
            resKategori.className = "text-warning-emphasis fs-5 fw-bold";
            resProgram.innerText = "Program Fullday";
            resStatus.innerText = "Perlu Pendampingan Karakter";
            resStatus.className = "text-warning-emphasis fw-bold";
        }

        // 4. Munculkan Card Hasil Evaluasi Atas, Sembunyikan Tombol Awal, Munculkan Tombol Selesai
        document.getElementById('cardEvaluasiOtomatis').classList.remove('d-none');
        document.getElementById('areaTombolAwal').classList.add('d-none');
        document.getElementById('areaTombolSelesai').classList.remove('d-none');

        // Scroll otomatis ke atas biar panitia langsung liat card hasil evaluasinya
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection