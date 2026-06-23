@extends('layouts.panitia')

@section('title', 'Penimbangan Balita')

@section('content')
<div class="row">
    <div class="col-12 mx-auto">
        
        <div class="card card-custom bg-white p-4 p-sm-5 border-0 shadow-sm" style="border-radius: 16px;">
            
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-2">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h4 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">alpan tampan dan pemberani</h4>
                    <span class="badge bg-success-subtle text-success px-2.5 py-1.5 fw-bold" style="font-size: 0.75rem; border-radius: 8px;">Isi Penimbangan Baru</span>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary px-3 py-2 fw-semibold rounded-3" onclick="location.reload();">
                    Tutup Form
                </button>
            </div>
            <p class="text-muted small mb-4">Isi semua data timbang yang relevan untuk balita ini agar catatan pertumbuhan jadi lebih rapi.</p>

            @if(session('success_timbang'))
            <div class="row g-3 mb-4 animate__animated animate__fadeIn">
                <div class="col-12 col-md-6">
                    <div class="p-4 border rounded-4 bg-light-subtle h-100" style="border-color: rgba(0,0,0,0.08) !important;">
                        <h6 class="fw-bold text-dark mb-3">Hasil Penimbangan</h6>
                        <div class="d-flex flex-column gap-2 small">
                            <div><span class="text-muted fw-medium">Usia:</span> <strong class="text-dark">{{ session('data_balita.usia') }} bulan</strong></div>
                            <div><span class="text-muted fw-medium">Berat:</span> <strong class="text-dark">{{ session('data_balita.berat') }} kg</strong></div>
                            <div><span class="text-muted fw-medium">Tinggi:</span> <strong class="text-dark">{{ session('data_balita.tinggi') }} cm</strong></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="p-4 border rounded-4 bg-light-subtle h-100" style="border-color: rgba(0,0,0,0.08) !important;">
                        <h6 class="fw-bold text-dark mb-3">Evaluasi</h6>
                        <div class="d-flex flex-column gap-2 small mb-3">
                            <div><span class="text-muted fw-medium">Berat badan:</span> <strong class="text-danger">{{ session('data_balita.evaluasi_bb') }}</strong></div>
                            <div><span class="text-muted fw-medium">Tinggi badan:</span> <strong class="text-danger">{{ session('data_balita.evaluasi_tb') }}</strong></div>
                            <div><span class="text-muted fw-medium">Stunting:</span> <strong class="text-danger">{{ session('data_balita.evaluasi_stunting') }}</strong></div>
                        </div>
                        <p class="text-muted mb-0" style="font-size: 0.75rem; line-height: 1.4;">
                            Pantau pertumbuhan secara berkala, berikan makanan bergizi, dan periksa status imunisasi.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <form action="#" method="POST" id="formTimbang" onsubmit="event.preventDefault(); triggerMockSubmit();">
                @csrf
                
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-semibold text-secondary mb-1">Tanggal Timbang</label>
                        <input type="date" class="form-control py-2 fs-6 fw-medium" id="tanggal_timbang" name="tanggal_timbang" value="2026-06-20" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-semibold text-secondary mb-1">Berat Badan (kg)</label>
                        <input type="number" step="0.1" class="form-control py-2 fs-6 fw-medium" id="berat_badan" name="berat_badan" placeholder="5.5" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-semibold text-secondary mb-1">Tinggi Badan (cm)</label>
                        <input type="number" step="0.1" class="form-control py-2 fs-6 fw-medium" id="tinggi_badan" name="tinggi_badan" placeholder="Contoh: 68.5" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-semibold text-secondary mb-1">Status Gizi</label>
                        <select class="form-select py-2 fs-6 fw-semibold text-dark" id="status_gizi" name="status_gizi" required>
                            <option value="Normal">Normal</option>
                            <option value="Kurang">Kurang</option>
                            <option value="Lebih">Lebih</option>
                            <option value="Obesitas">Obesitas</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-semibold text-secondary mb-1">Vitamin / Suplemen</label>
                        <input type="text" class="form-control py-2 fs-6" id="vitamin" name="vitamin" placeholder="Contoh: Vitamin A">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-semibold text-secondary mb-1">Vaksin</label>
                        <input type="text" class="form-control py-2 fs-6" id="vaksin" name="vaksin" placeholder="Contoh: Campak">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold text-secondary mb-1">Catatan Tambahan</label>
                    <textarea class="form-control fs-6" id="catatan" name="catatan" rows="3" placeholder="Tambahkan kondisi khusus atau rekomendasi..."></textarea>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-3 mb-5">
                    <button type="submit" class="btn text-white px-4 py-2.5 fw-bold" style="background-color: #0c1a30; border: none; border-radius: 10px;">
                        Simpan Penimbangan
                    </button>
                    <button type="reset" class="btn btn-light border px-3 py-2.5 fw-semibold rounded-3 text-dark" style="font-size: 0.9rem;">
                        Reset Form
                    </button>
                    <small class="text-muted small" style="font-size: 0.8rem;">Field dengan tanggal, berat, dan tinggi wajib diisi.</small>
                </div>
            </form>

            <div class="border-top pt-4">
                <h6 class="fw-bold text-dark mb-3">Riwayat Penimbangan</h6>
                <p class="text-muted small mb-0" id="txtRiwayat">Belum ada catatan untuk balita ini.</p>
            </div>

        </div>
    </div>
</div>

<script>
    function triggerMockSubmit() {
        const berat = document.getElementById('berat_badan').value || '5.5';
        const tinggi = document.getElementById('tinggi_badan').value || '80';
        const gizi = document.getElementById('status_gizi').value;
        const vit = document.getElementById('vitamin').value || 'Vitamin A';
        const vak = document.getElementById('vaksin').value || 'Campak';

        // Set form value otomatis biar kyk gambar kedua lu
        document.getElementById('berat_badan').value = berat;
        document.getElementById('tinggi_badan').value = tinggi;
        document.getElementById('status_gizi').value = "Kurang"; // Sesuai gambar kedua
        document.getElementById('vitamin').value = vit;
        document.getElementById('vaksin').value = vak;

        // Bikin session injection palsu lewat form reload/dom manipulation agar card evaluasi keluar instan
        // Note: Nanti di controller asli tinggal return back()->with('success_timbang', true)...
        const dummyCard = `
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6">
                <div class="p-4 border rounded-4 bg-light h-100" style="background-color: #f8f9fa; border-radius: 12px;">
                    <h6 class="fw-bold text-dark mb-3 small text-uppercase" style="font-size:0.75rem; letter-spacing:0.5px;">Hasil Penimbangan</h6>
                    <div class="d-flex flex-column gap-2" style="font-size: 0.85rem;">
                        <div><span class="text-muted">Usia:</span> <strong class="text-dark">324 bulan</strong></div>
                        <div><span class="text-muted">Berat:</span> <strong class="text-dark">\${berat} kg</strong></div>
                        <div><span class="text-muted">Tinggi:</span> <strong class="text-dark">\${tinggi} cm</strong></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="p-4 border rounded-4 bg-light h-100" style="background-color: #f8f9fa; border-radius: 12px;">
                    <h6 class="fw-bold text-dark mb-3 small text-uppercase" style="font-size:0.75rem; letter-spacing:0.5px;">Evaluasi</h6>
                    <div class="d-flex flex-column gap-2" style="font-size: 0.85rem;">
                        <div><span class="text-muted">Berat badan:</span> <strong class="text-dark">Berat kurang</strong></div>
                        <div><span class="text-muted">Tinggi badan:</span> <strong class="text-dark">Pendek (stunting)</strong></div>
                        <div><span class="text-muted">Stunting:</span> <strong class="text-dark">Berisiko stunting</strong></div>
                    </div>
                    <p class="text-muted mb-0 mt-3" style="font-size: 0.75rem; line-height: 1.4;">
                        Pantau pertumbuhan secara berkala, berikan makanan bergizi, dan periksa status imunisasi.
                    </p>
                </div>
            </div>
        </div>`;

        // Masukin tepat sebelum form
        const form = document.getElementById('formTimbang');
        
        // Hapus card lama kalau ada double click
        const oldCard = form.previousElementSibling;
        if(oldCard && oldCard.classList.contains('row')) {
            oldCard.remove();
        }
        
        form.insertAdjacentHTML('beforebegin', dummyCard);
        document.getElementById('txtRiwayat').innerText = "Data berhasil disimpan ke database.";
        
        alert('Data penimbangan berhasil disubmit! Card evaluasi otomatis keluar, COOK.');
    }
</script>
@endsection