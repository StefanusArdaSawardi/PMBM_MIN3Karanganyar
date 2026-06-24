@extends('layouts.panitia')

@section('title', 'Instrumen Penilaian - Penguji PMBM')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/panitia/grading/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/panitia/grading/style.css') }}">
  <style>
    .select-input {
      width: 100%;
      height: 100%;
      padding: 0 40px 0 15px;
      font-family: inherit;
      font-size: 13px;
      font-weight: bold;
      color: #374151;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      background: #ffffff;
      cursor: pointer;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      outline: none;
    }
    .select-input:focus {
      border-color: #298752;
    }
    .rating-field {
      width: 100%;
      height: 100%;
      padding: 10px 15px;
      font-family: inherit;
      font-size: 14px;
      color: #1f2937;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      background: #ffffff;
      outline: none;
    }
    .rating-field:focus {
      border-color: #298752;
    }
    .note-area {
      width: 100%;
      height: 100%;
      padding: 12px 15px;
      font-family: inherit;
      font-size: 13px;
      color: #1f2937;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      background: #ffffff;
      outline: none;
      resize: none;
      line-height: 1.5;
    }
    .note-area:focus {
      border-color: #298752;
    }
    .btn-grade-submit {
      width: 100%;
      height: 100%;
      border: none;
      background: none;
      cursor: pointer;
      position: relative;
      display: block;
      padding: 0;
    }
  </style>
@endsection

@section('content')
  <div class="desktop-23">
    <!-- Panitia Sidebar/Topbar Included -->
    @include('components.sidebar-panitia', ['activeFolder' => 'grading'])

    <!-- Student Identity Header -->
    <div class="section-student-identity-card">
      <div class="container3">
        <div class="container4">
          <div class="text4">SEDANG DIUJI:</div>
          <div class="heading-1">
            <div class="text5">{{ $student->nama_murid }}</div>
          </div>
          <div class="container5">
            <div class="container6">
              <div class="strong-no-daftar">
                <span>
                  <span class="strong-no-daftar-span">No. Daftar:</span>
                  <span class="strong-no-daftar-span2">PMB-2026-{{ str_pad($student->id_murid, 3, '0', STR_PAD_LEFT) }}</span>
                </span>
              </div>
            </div>
            <div class="overlay-border">
              <div class="text6">{{ $student->pendaftaran->program->nama_program ?? 'Umum' }}</div>
            </div>
          </div>
        </div>
        <div class="background-border">
          <img class="container7" src="{{ asset('assets/panitia/grading/container6.svg') }}" />
          <div class="container">
            <div class="text7">Sesi Wawancara & Ujian</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Scoring Form -->
    <form action="{{ route('panitia.grading', $student->id_murid) }}" method="POST" class="assessment-form-card" style="height: auto; padding-bottom: 25px;">
      @csrf

      <!-- Messages Flash -->
      @if(session('success_grading'))
        <div style="margin: 15px; padding: 12px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; font-family: sans-serif; font-size: 13px; border-radius: 8px;">
          {{ session('success_grading') }}
        </div>
      @endif

      @if($errors->any())
        <div style="margin: 15px; padding: 12px; background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; font-family: sans-serif; font-size: 13px; border-radius: 8px;">
          {{ $errors->first() }}
        </div>
      @endif

      <div class="background-horizontal-border">
        <div class="container8">
          <div class="container">
            <div class="text8">📝</div>
          </div>
          <div class="heading-2">
            <div class="text9">Instrumen Penilaian Calon Siswa</div>
          </div>
        </div>
      </div>

      <div class="container9" style="height: auto;">
        
        <!-- 1. Nilai Hafalan -->
        <div class="_1-opsi-hafalan">
          <div class="label">
            <div class="_1-opsi-hafalan2">1. Nilai Hafalan (1 - 100)</div>
          </div>
          <div class="container6" style="border: none; padding: 0;">
            <input 
              type="number" 
              name="nilai_hafalan" 
              id="nilai_hafalan" 
              required 
              min="1" 
              max="100" 
              class="rating-field" 
              placeholder="Masukkan nilai hafalan (1 - 100)"
              value="{{ $student->hasil->nilai_hafalan ?? '' }}"
            >
          </div>
        </div>

        <!-- 2. Nilai Wawancara -->
        <div class="_2-bacaan-tasmi">
          <div class="label">
            <div class="_2-bacaan-tasmi2">2. Nilai Wawancara (1 - 100)</div>
          </div>
          <div class="container6" style="border: none; padding: 0;">
            <input 
              type="number" 
              name="nilai_wawancara" 
              id="nilai_wawancara" 
              required 
              min="1" 
              max="100" 
              class="rating-field" 
              placeholder="Masukkan nilai wawancara (1 - 100)"
              value="{{ $student->hasil->nilai_wawancara ?? '' }}"
            >
          </div>
        </div>

        <!-- 3. Nilai Calistung -->
        <div class="_3-kemampuan-calistung" style="margin-top: 15px;">
          <div class="label">
            <div class="_3-kemampuan-calistung2">3. Nilai Calistung (1 - 100)</div>
          </div>
          <div class="container6" style="border: none; padding: 0;">
            <input 
              type="number" 
              name="nilai_calistung" 
              id="nilai_calistung" 
              required 
              min="1" 
              max="100" 
              class="rating-field" 
              placeholder="Masukkan nilai calistung (1 - 100)"
              value="{{ $student->hasil->nilai_calistung ?? '' }}"
            >
          </div>
        </div>

        <!-- 4. Nilai Tasmi -->
        <div class="_4-aspek-kemandirian" style="margin-top: 15px;">
          <div class="label">
            <div class="_4-aspek-kemandirian2" style="font-family: inherit; font-size: 13px; font-weight: bold; color: #374151;">4. Nilai Tasmi (1 - 100)</div>
          </div>
          <div class="container6" style="border: none; padding: 0;">
            <input 
              type="number" 
              name="nilai_tasmi" 
              id="nilai_tasmi" 
              required 
              min="1" 
              max="100" 
              class="rating-field" 
              placeholder="Masukkan nilai tasmi (1 - 100)"
              value="{{ $student->hasil->nilai_tasmi ?? '' }}"
            >
          </div>
        </div>

        <!-- 5. Nilai Mandiri -->
        <div class="aspek-kemandirian-input" style="margin-top: 15px; display: flex; flex-direction: column; gap: 8px;">
          <div class="label">
            <div class="_4-aspek-kemandirian2" style="font-family: inherit; font-size: 13px; font-weight: bold; color: #374151;">5. Nilai Mandiri (1 - 100)</div>
          </div>
          <div class="container6" style="border: none; padding: 0;">
            <input 
              type="number" 
              name="nilai_mandiri" 
              id="nilai_mandiri" 
              required 
              min="1" 
              max="100" 
              class="rating-field" 
              placeholder="Masukkan nilai mandiri (1 - 100)"
              value="{{ $student->hasil->nilai_mandiri ?? '' }}"
            >
          </div>
        </div>

        <!-- 6. Jalur Prestasi -->
        <div class="_5-jalur-prestasi" style="display: flex; align-items: center; gap: 10px; margin-top: 15px;">
          <input 
            type="checkbox" 
            id="prestasi_check" 
            style="width: 20px; height: 20px; cursor: pointer; border: 1px solid #d1d5db; border-radius: 4px;"
            {{ $student->id_kejuaraan ? 'checked' : '' }}
            disabled
          >
          <label for="prestasi_check" style="font-weight: bold; color: #374151; font-size: 13px; cursor: pointer;">
            🏆 Calon Murid Memiliki Prestasi Terverifikasi
          </label>
        </div>

        <!-- 7. Hasil Wawancara Orang Tua -->
        <div class="_6-hasil-wawancara-orang-tua" style="margin-top: 15px;">
          <div class="label">
            <div class="_6-hasil-wawancara-orang-tua-skala-1-10">
              6. Rating Dukungan Orang Tua (Skala 1 - 10)
            </div>
          </div>
          <div class="input2" style="border: none; padding: 0; height: 42px; margin-bottom: 5px;">
            <input 
              type="number" 
              name="rating_ortu" 
              min="1" 
              max="10" 
              class="rating-field" 
              placeholder="Rating angka 1 s/d 10" 
              value="{{ $student->hasil->rating_ortu ?? '8' }}"
            />
          </div>
          <div class="container6">
            <div class="_10-sangat-mendukung-1-tidak-mendukung">
              * 10 (Sangat Mendukung), 1 (Tidak Mendukung)
            </div>
          </div>
        </div>

        <!-- 8. Catatan Penguji -->
        <div class="_7-catatan-penguji" style="margin-top: 15px;">
          <div class="label">
            <div class="_7-catatan-penguji2">7. Catatan &amp; Rekomendasi Penguji</div>
          </div>
          <div class="textarea" style="border: none; padding: 0; height: 100px;">
            <textarea name="catatan" class="note-area" placeholder="Tuliskan catatan khusus atau rekomendasi hasil wawancara di sini...">{{ $student->hasil->catatan_manual ?? '' }}</textarea>
          </div>
        </div>
      </div>

      <!-- Action buttons -->
      <div class="action-buttons" style="position: static; margin-top: 30px; display: flex; justify-content: flex-end; gap: 15px; padding: 0 40px;">
        <a href="{{ route('panitia.dashboard') }}" class="button" style="text-decoration: none; display: flex; align-items: center; justify-content: center; background: #f3f4f6; color: #4b5563; font-weight: bold; border-radius: 8px; width: 100px; height: 44px;">
          Batal
        </a>

        <div class="button2" style="width: 240px; height: 44px; padding: 0;">
          <button type="submit" class="btn-grade-submit">
            <div class="button-shadow" style="width: 100%; height: 100%;"></div>
            <div class="container20" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; z-index: 10;">
              <img src="{{ asset('assets/panitia/grading/container34.svg') }}" style="width: 100%; height: 100%;" />
            </div>
            <div style="position: absolute; left: 0; top: 0; width: 100%; height: 100%; background: #298752; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
              <span class="text" style="position: static; color: #ffffff; padding-left: 20px;">Simpan Nilai &amp; Selesai</span>
            </div>
          </button>
        </div>
      </div>
    </form>

    <!-- Footer Component Included -->
    @include('components.footer-panitia', ['isGrading' => true])

    <!-- Progress Tracker -->
    <div class="progress-tracker-placeholder">
      <div class="container21">
        <div class="container22">
          <div class="background2">
            <div class="text14">1</div>
          </div>
          <div class="margin3">
            <div class="text15">Identitas</div>
          </div>
        </div>
        <div class="horizontal-divider"></div>
        <div class="container22">
          <div class="background2" style="background: #0f7643;">
            <div class="text14">2</div>
          </div>
          <div class="margin3">
            <div class="text15" style="color: #0f7643;">Penilaian</div>
          </div>
        </div>
        <div class="horizontal-divider2"></div>
        <div class="container22">
          <div class="border">
            <div class="text16">3</div>
          </div>
          <div class="margin3">
            <div class="text17">Selesai</div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
