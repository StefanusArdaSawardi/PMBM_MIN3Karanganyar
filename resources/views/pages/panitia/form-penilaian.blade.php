<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panitia - Input Nilai Wawancara</title>
    <!-- Bootstrap 5.3.3 CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .bg-pmbm {
            background-color: #008744 !important;
        }
        .text-pmbm {
            color: #008744 !important;
        }
        .btn-pmbm {
            background-color: #008744;
            color: #ffffff;
        }
        .btn-pmbm:hover {
            background-color: #006e36;
            color: #ffffff;
        }
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        }
        .form-select:focus, .form-control:focus, .form-check-input:focus {
            border-color: #008744;
            box-shadow: 0 0 0 0.25rem rgba(0, 135, 68, 0.15);
        }
        .form-check-input:checked {
            background-color: #008744;
            border-color: #008744;
        }
    </style>
</head>
<body>

    <!-- Topbar Navbar -->
    <nav class="navbar bg-white border-b border-gray-200 py-3 shadow-sm sticky-top">
        <div class="container">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-pmbm text-white rounded d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px;">
                    P
                </div>
                <span class="fw-bold fs-5 text-dark">PMBM <span class="text-muted fs-6">Panitia Penguji</span></span>
            </div>
            <div>
                <a href="{{ route('panitia.antrean') }}" class="btn btn-light btn-sm fw-medium px-3 rounded-pill border">⬅ Kembali ke Antrean</a>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                
                <!-- Card Info Siswa -->
                <div class="card card-custom bg-white p-4 mb-4 border-start border-4 border-success">
                    <div class="row align-items-center">
                        <div class="col-sm-8">
                            <span class="text-muted small font-monospace fw-bold">SEDANG DIUJI:</span>
                            <h4 class="fw-bold text-dark my-1">Muhammad Rizki Kasim</h4>
                            <p class="text-muted small mb-0">No. Daftar: <span class="font-monospace fw-bold">PMB-2026-001</span> | Program: <span class="badge bg-success-subtle text-success">Khusus Tahfidz</span></p>
                        </div>
                        <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
                            <span class="badge bg-secondary-subtle text-secondary px-3 py-2 fs-6">Sesi Wawancara</span>
                        </div>
                    </div>
                </div>

                <!-- Card Pengisian Instrumen -->
                <div class="card card-custom bg-white p-4 p-sm-5">
                    <h5 class="fw-bold text-dark mb-4">📝 Instrumen Penilaian Calon Siswa</h5>
                    
                    <form action="#" method="POST">
                        <!-- 1. Opsi Hafalan -->
                        <div class="mb-4">
                            <label for="hafalan" class="form-label fw-semibold text-secondary small">1. Opsi Hafalan</label>
                            <select class="form-select form-select-lg py-2 fs-6" id="hafalan" name="hafalan" required>
                                <option value="" disabled selected>-- Pilih Nilai Hafalan --</option>
                                <option value="Baik">🟢 Baik</option>
                                <option value="Cukup Baik">🟡 Cukup Baik</option>
                                <option value="Kurang Baik">🔴 Kurang Baik</option>
                            </select>
                        </div>

                        <!-- 2. Bacaan Tasmi -->
                        <div class="mb-4">
                            <label for="tasmi" class="form-label fw-semibold text-secondary small">2. Bacaan Tasmi</label>
                            <select class="form-select form-select-lg py-2 fs-6" id="tasmi" name="tasmi" required>
                                <option value="" disabled selected>-- Pilih Nilai Tasmi --</option>
                                <option value="Baik">🟢 Baik</option>
                                <option value="Cukup Baik">🟡 Cukup Baik</option>
                                <option value="Kurang Baik">🔴 Kurang Baik</option>
                            </select>
                        </div>

                        <!-- 3. Calistung -->
                        <div class="mb-4">
                            <label for="calistung" class="form-label fw-semibold text-secondary small">3. Kemampuan Calistung</label>
                            <select class="form-select form-select-lg py-2 fs-6" id="calistung" name="calistung" required>
                                <option value="" disabled selected>-- Pilih Nilai Calistung --</option>
                                <option value="Baik">🟢 Baik</option>
                                <option value="Cukup Baik">🟡 Cukup Baik</option>
                                <option value="Kurang Baik">🔴 Kurang Baik</option>
                            </select>
                        </div>

                        <!-- 4. Kemandirian -->
                        <div class="mb-4">
                            <label for="kemandirian" class="form-label fw-semibold text-secondary small">4. Aspek Kemandirian</label>
                            <select class="form-select form-select-lg py-2 fs-6" id="kemandirian" name="kemandirian" required>
                                <option value="" disabled selected>-- Pilih Nilai Kemandirian --</option>
                                <option value="Baik">🟢 Baik</option>
                                <option value="Cukup Baik">🟡 Cukup Baik</option>
                                <option value="Kurang Baik">🔴 Kurang Baik</option>
                            </select>
                        </div>

                        <!-- 5. Jalur Prestasi -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary small d-block">5. Jalur Prestasi</label>
                            <div class="form-check form-check-inline p-3 border rounded-3 bg-light/50 me-2 mb-2" style="min-width: 180px;">
                                <input class="form-check-input ms-0 me-2" type="checkbox" id="prestasi" name="jalur_prestasi" value="1">
                                <label class="form-check-input-label fw-medium text-dark" for="prestasi">🏆 Memiliki Prestasi</label>
                            </div>
                        </div>

                        <!-- 6. Wawancara Ortu -->
                        <div class="mb-4">
                            <label for="wawancara_ortu" class="form-label fw-semibold text-secondary small">6. Hasil Wawancara Orang Tua (Skala 1 - 10)</label>
                            <input type="number" class="form-control form-control-lg py-2 fs-6" id="wawancara_ortu" name="wawancara_ortu" min="1" max="10" placeholder="Masukkan rating angka 1 s/d 10" required>
                        </div>

                        <!-- 7. Catatan -->
                        <div class="mb-5">
                            <label for="catatan" class="form-label fw-semibold text-secondary small">7. Catatan Penguji</label>
                            <textarea class="form-control fs-6" id="catatan" name="catatan" rows="4" placeholder="Tuliskan catatan khusus atau rekomendasi hasil wawancara di sini..."></textarea>
                        </div>

                        <!-- Tombol Submit Form -->
                        <div class="d-flex gap-3">
                            <a href="{{ route('panitia.antrean') }}" class="btn btn-light btn-lg w-50 py-2.5 fw-bold fs-6 rounded-3 border text-center">Batal</a>
                            <button type="submit" class="btn btn-pmbm btn-lg w-50 py-2.5 fw-bold fs-6 rounded-3">Simpan Nilai & Selesai</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>
</html>