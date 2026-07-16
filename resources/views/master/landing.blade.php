@extends('layouts.admin')

@section('title', 'Kelola Konten Landing - CMS PMBM')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/admin/landing-manage/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/landing-manage/style.css') }}">
  <style>
    /* Styling form fields over Figma absolute styles */
    .input-field {
      width: 100%;
      height: 100%;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      padding: 10px 15px;
      font-family: inherit;
      font-size: 13px;
      outline: none;
      background: #ffffff;
    }
    .input-field:focus {
      border-color: #298752;
    }
    .textarea-field {
      width: 100%;
      height: 100%;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      padding: 12px 15px;
      font-family: inherit;
      font-size: 12px;
      outline: none;
      background: #ffffff;
      resize: none;
      line-height: 1.5;
    }
    .textarea-field:focus {
      border-color: #298752;
    }
    .btn-submit {
      width: 100%;
      height: 100%;
      background: #298752;
      color: #ffffff;
      font-weight: bold;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      cursor: pointer;
      font-size: 13px;
    }
    .btn-submit:hover {
      background: #064e3b;
    }
    .program-row {
      display: flex;
      border-bottom: 1px solid #e5e7eb;
      padding: 10px 0;
    }

    /* Program Table Styles */
    .program-table-container {
      max-height: 250px;
      overflow-y: auto;
      width: 100% !important;
      align-self: stretch !important;
      border: 1px solid #becabe;
      border-radius: 8px;
      margin-top: 15px;
      background-color: #ffffff;
    }
    .program-table {
      width: 100% !important;
      border-collapse: collapse !important;
      font-family: inherit;
      font-size: 13px !important;
      text-align: left;
    }
    .program-table th {
      background-color: #f0fdf4 !important;
      color: #064e3b !important;
      font-weight: bold !important;
      font-size: 11px !important;
      text-transform: uppercase !important;
      padding: 12px 16px !important;
      border-bottom: 2px solid #becabe !important;
      position: sticky;
      top: 0;
      z-index: 10;
    }
    .program-table td {
      padding: 12px 16px !important;
      border-bottom: 1px solid #e5e7eb !important;
      color: #374151 !important;
      vertical-align: middle !important;
      background-color: #ffffff !important;
    }
    .program-table tr:hover td {
      background-color: #f9fafb !important;
    }

    /* Terms and Conditions Sizing & Alignment */
    .section-terms-conditions {
      align-items: stretch !important;
    }
    .section-terms-conditions form {
      width: 100% !important;
      align-self: stretch !important;
    }
    .section-terms-conditions .textarea2 {
      width: 100% !important;
      align-self: stretch !important;
      border: none !important;
      padding: 0 !important;
      background: none !important;
      height: 180px !important;
      overflow: visible !important;
    }
    .section-terms-conditions .textarea-field {
      width: 100% !important;
      height: 100% !important;
      border: 1px solid #becabe !important;
      border-radius: 8px !important;
      padding: 12px 16px !important;
      font-size: 13px !important;
      font-family: inherit !important;
      resize: none !important;
      background: #ffffff !important;
      outline: none !important;
      box-sizing: border-box !important;
    }
    .section-terms-conditions .textarea-field:focus {
      border-color: #298752 !important;
      box-shadow: 0 0 0 2px rgba(41, 135, 82, 0.1) !important;
    }

    /* Custom scrollbar styling for premium look */
    .program-table-container::-webkit-scrollbar,
    .section-terms-conditions .textarea-field::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    .program-table-container::-webkit-scrollbar-track,
    .section-terms-conditions .textarea-field::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 4px;
    }
    .program-table-container::-webkit-scrollbar-thumb,
    .section-terms-conditions .textarea-field::-webkit-scrollbar-thumb {
      background: #c5d2c4;
      border-radius: 4px;
    }
    .program-table-container::-webkit-scrollbar-thumb:hover,
    .section-terms-conditions .textarea-field::-webkit-scrollbar-thumb:hover {
      background: #a3b8a2;
    }

    /* Modal styles aligned with user management index style */
    .modal {
      display: none;
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 10000;
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: #ffffff;
      padding: 30px;
      border-radius: 15px;
      width: 450px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      font-family: inherit;
    }
    .form-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
      margin-bottom: 15px;
    }
    .form-group label {
      font-size: 11px;
      font-weight: bold;
      color: #4b5563;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .form-group input, .form-group select, .form-group textarea {
      padding: 10px 12px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      font-size: 13px;
      outline: none;
      font-family: inherit;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
      border-color: #298752;
    }
  </style>
@endsection

@section('content')
  @php
    $weights = $dssConfig['weights'] ?? [
        'hafalan' => 30,
        'wawancara' => 20,
        'calistung' => 20,
        'tasmi' => 15,
        'mandiri' => 15
    ];
    $predikats = $dssConfig['predikats'] ?? [];
    $sangatCakap = collect($predikats)->firstWhere('label', 'Sangat Cakap') ?? ['min' => 85, 'max' => 100];
    $cakap = collect($predikats)->firstWhere('label', 'Cakap') ?? ['min' => 70, 'max' => 84];
    $cukupCakap = collect($predikats)->firstWhere('label', 'Cukup Cakap') ?? ['min' => 60, 'max' => 69];
    $butuhPerhatian = collect($predikats)->firstWhere('label', 'Butuh Perhatian') ?? ['min' => 1, 'max' => 59];
  @endphp
  <div class="desktop-15" style="overflow-y: auto; height: auto; min-height: 100vh; padding-bottom: 60px;">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'landing-manage'])

    <!-- Main Content Wrapper -->
    <div style="position: absolute; left: 340px; top: 138px; right: 40px; display: flex; flex-direction: column; gap: 24px; z-index: 10;">
      
      <!-- Messages Flash -->
      @if(session('success'))
        <div style="padding: 10px 15px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; font-family: sans-serif; font-size: 12px; border-radius: 6px; z-index: 100; width: 100%;">
          {{ session('success') }}
        </div>
      @endif
      
      <!-- Tabs Navigation -->
      <div style="display: flex; gap: 10px; border-bottom: 2px solid #becabe; padding-bottom: 8px; margin-bottom: 20px; flex-wrap: wrap;">
        <button type="button" onclick="switchTab('tab-landing')" id="btn-tab-landing" class="tab-btn active" style="font-family: inherit; font-size: 13px; font-weight: 700; color: #008744; padding: 10px 18px; border-radius: 8px; cursor: pointer; transition: all 0.2s; border: 1px solid #becabe; background-color: #eef5ed; outline: none;">📝 Konten Landing</button>
        <button type="button" onclick="switchTab('tab-programs')" id="btn-tab-programs" class="tab-btn" style="font-family: inherit; font-size: 13px; font-weight: 700; color: #475569; padding: 10px 18px; border-radius: 8px; cursor: pointer; transition: all 0.2s; border: 1px solid transparent; background: none; outline: none;">🏫 Jalur Pendaftaran</button>
        <button type="button" onclick="switchTab('tab-dss')" id="btn-tab-dss" class="tab-btn" style="font-family: inherit; font-size: 13px; font-weight: 700; color: #475569; padding: 10px 18px; border-radius: 8px; cursor: pointer; transition: all 0.2s; border: 1px solid transparent; background: none; outline: none;">⚙️ Konfigurasi DSS</button>
        <button type="button" onclick="switchTab('tab-faq')" id="btn-tab-faq" class="tab-btn" style="font-family: inherit; font-size: 13px; font-weight: 700; color: #475569; padding: 10px 18px; border-radius: 8px; cursor: pointer; transition: all 0.2s; border: 1px solid transparent; background: none; outline: none;">💬 Kelola FAQ</button>
        <button type="button" onclick="switchTab('tab-contacts')" id="btn-tab-contacts" class="tab-btn" style="font-family: inherit; font-size: 13px; font-weight: 700; color: #475569; padding: 10px 18px; border-radius: 8px; cursor: pointer; transition: all 0.2s; border: 1px solid transparent; background: none; outline: none;">📞 Kontak &amp; Medsos</button>
      </div>

      <!-- TAB 1: KONTEN LANDING -->
      <div id="tab-landing" class="tab-pane active" style="display: flex; flex-direction: column; gap: 24px;">
        <div style="display: flex; flex-direction: row; gap: 24px; width: 100%; align-items: stretch; flex-wrap: wrap;">
          <!-- Section 1: Landing Page Content -->
          <div class="section-1-landing-page-content" style="flex: 2; position: relative; top: auto; left: auto; right: auto; width: auto; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); margin: 0; min-width: 320px;">
            <div class="margin">
              <div class="container">
                <img class="overlay" src="{{ asset('assets/admin/landing-manage/overlay0.svg') }}" />
                <div class="heading-3">
                  <div class="text" style="position: static;">
                    Konten Utama Landing Page
                  </div>
                </div>
              </div>
            </div>
            
            <form action="{{ route('tata_usaha.content.update_text') }}" method="POST" class="container2">
              @csrf
              <div class="container3">
                <div class="label">
                  <div class="judul-utama-main-heading">Judul Utama (Main Heading)</div>
                </div>
                <div class="input" style="border: none; padding: 0;">
                  <input type="text" name="main_heading" class="input-field" value="{{ $content['main_heading'] ?? 'Penerimaan Peserta Didik Baru 2026/2027' }}" required>
                </div>
              </div>
              
              <div class="container5">
                <div class="label">
                  <div class="sub-judul-deskripsi-singkat">Sub-Judul / Deskripsi Singkat</div>
                </div>
                <div class="textarea" style="border: none; padding: 0;">
                  <textarea name="sub_heading" class="textarea-field" required>{{ $content['sub_heading'] ?? 'Bergabunglah dengan MIN 3 Karanganyar, lembaga pendidikan Islam yang unggul dalam akademik dan berkarakter Qur\'ani. Kami menyediakan lingkungan belajar yang kondusif dan inovatif.' }}</textarea>
                </div>
              </div>
              
              <div class="container7" style="border: none; padding: 0;">
                <button type="submit" class="btn-submit" style="border: none;">
                  <img src="{{ asset('assets/admin/landing-manage/container7.svg') }}" alt="Save" />
                  <span>Update Teks</span>
                </button>
              </div>
            </form>
          </div>

          <!-- Section 2: Countdown Gelombang -->
          <div class="section-2-countdown-gelombang" style="flex: 1; position: relative; top: auto; left: auto; right: auto; width: auto; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); margin: 0; min-width: 250px;">
            <div class="container">
              <img class="overlay2" src="{{ asset('assets/admin/landing-manage/overlay1.svg') }}" />
              <div class="heading-32">
                <div class="text" style="position: static;">Countdown Penutupan</div>
              </div>
            </div>
            
            <form action="{{ route('tata_usaha.settings.update') }}" method="POST" class="background-border" style="height: auto; padding-bottom: 20px;">
              @csrf
              <div class="label">
                <div class="pilih-tanggal-waktu-target">Pilih Tanggal &amp; Waktu Target</div>
              </div>
              <div class="input2" style="border: none; padding: 0; margin-bottom: 15px; height: 42px;">
                <input type="datetime-local" name="countdown_target" class="input-field" value="{{ isset($settings['countdown_target']) ? date('Y-m-d\TH:i', strtotime($settings['countdown_target'])) : '2026-07-30T11:59' }}" required>
              </div>
              
              <button type="submit" class="btn-submit" style="height: 40px; border: none; background: #064e3b; margin-top: 10px;">
                <img src="{{ asset('assets/admin/landing-manage/container13.svg') }}" alt="Save" />
                <span>Atur Ulang Countdown</span>
              </button>
            </form>
          </div>
        </div>

        <!-- Section 4: Digital Booklet & Terms -->
        <div class="section-4-digital-booklet-terms" style="display: flex; flex-direction: row; gap: 24px; width: 100%; align-items: stretch; height: auto; flex-wrap: wrap;">
          <!-- Booklet Upload -->
          <div class="section-booklet-upload" style="flex: 1; position: relative; top: auto; left: auto; right: auto; width: auto; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); background: #ffffff; border-radius: 12px; border: 1px solid #becabe; padding: 24px; margin: 0; min-width: 280px;">
            <div class="container">
              <img class="overlay4" src="{{ asset('assets/admin/landing-manage/overlay3.svg') }}" />
              <div class="heading-32">
                <div class="text" style="position: static;">Panduan &amp; Booklet</div>
              </div>
            </div>
            
            <form action="{{ route('tata_usaha.content.upload_booklet') }}" method="POST" enctype="multipart/form-data" class="margin2" style="height: auto; margin-top: 15px;">
              @csrf
              <div class="container3" style="height: auto; gap: 10px;">
                <div class="label">
                  <div class="upload-file-booklet-terbaru">Upload File Booklet Terbaru</div>
                </div>
                <div class="container17" style="height: 100px; border: 2px dashed #cccccc; border-radius: 8px; position: relative;">
                  <input type="file" name="booklet_file" style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer;" required>
                  <div class="label2" style="position: absolute; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; pointer-events: none;">
                    <img class="margin3" src="{{ asset('assets/admin/landing-manage/margin2.svg') }}" style="margin-bottom: 5px;" />
                    <div class="text17" style="position: static; font-size: 11px;">Klik untuk upload berkas baru</div>
                    <div class="text18" style="position: static; font-size: 10px; color: #9ca3af; margin-top: 2px;">PDF max 5MB</div>
                  </div>
                </div>
              </div>
              
              <div class="background-border2" style="margin-top: 15px;">
                <div class="container14">
                  <img class="container20" src="{{ asset('assets/admin/landing-manage/container24.svg') }}" />
                  <div class="container19">
                    <div class="container21">
                      <div class="text19" style="position: static;">booklet_pmbm_2026.pdf</div>
                    </div>
                    <div class="container22">
                      <div class="text18" style="position: static;">3.4 MB</div>
                    </div>
                  </div>
                </div>
                <div class="overlay5">
                  <div class="text20" style="position: static;">AKTIF</div>
                </div>
              </div>

              <button type="submit" class="btn-submit" style="height: 40px; margin-top: 15px; border: none;">
                <span>Upload &amp; Ganti Booklet</span>
              </button>
            </form>
          </div>

          <!-- Terms textarea -->
          <div class="section-terms-conditions" style="flex: 1; position: relative; top: auto; left: auto; right: auto; width: auto; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); background: #ffffff; border-radius: 12px; border: 1px solid #becabe; padding: 24px; margin: 0; display: flex; flex-direction: column; min-width: 280px;">
            <div class="container">
              <img class="background7" src="{{ asset('assets/admin/landing-manage/background9.svg') }}" />
              <div class="heading-32">
                <div class="text" style="position: static;">Syarat Pendaftaran</div>
              </div>
            </div>
            
            <form action="{{ route('tata_usaha.content.update_terms') }}" method="POST" style="margin-top: 15px; width: 100%; display: flex; flex-direction: column; gap: 15px; align-self: stretch;">
              @csrf
              <div class="textarea2">
                <textarea name="terms_content" class="textarea-field" required style="height: 140px;">{{ $content['terms_content'] ?? "1. Fotocopy Akte Kelahiran (2 Lembar)\n2. Fotocopy Kartu Keluarga (2 Lembar)\n3. Pas Foto Berwarna 3x4 (4 Lembar)\n4. Surat Keterangan Sehat\n5. Berusia minimal 6 tahun per 1 Juli 2026" }}</textarea>
              </div>
              
              <button type="submit" class="btn-submit" style="height: 40px; border: none; background: #064e3b; width: 100%;">
                <span class="text21" style="position: static; color: #ffffff;">Simpan Draft</span>
              </button>
            </form>
          </div>
        </div>

        <div style="display: flex; flex-direction: row; gap: 24px; width: 100%; align-items: stretch; height: auto; flex-wrap: wrap;">
          <!-- Background customization form -->
          <div style="flex: 1; background: #ffffff; border-radius: 12px; border: 1px solid #becabe; padding: 24px; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; min-width: 280px;">
            <div style="display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #f0fdf4; padding-bottom: 12px; margin-bottom: 15px;">
              <div style="font-weight: bold; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 16px; color: #064e3b;">Background Dashboard</div>
            </div>
            
            <form action="{{ route('tata_usaha.content.update_background') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px; flex: 1; justify-content: space-between;">
              @csrf
              <div>
                <label style="font-size: 11px; font-weight: bold; color: #4b5563; text-transform: uppercase;">Upload Gambar Latar Baru</label>
                <div style="height: 100px; border: 2px dashed #cccccc; border-radius: 8px; position: relative; margin-top: 5px;">
                  <input type="file" name="background_image" accept="image/*" style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer;" required>
                  <div style="position: absolute; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; pointer-events: none;">
                    <span style="font-size: 12px; font-weight: bold; color: #374151;">Klik untuk pilih file gambar</span>
                    <span style="font-size: 10px; color: #9ca3af; margin-top: 4px;">JPG, PNG, WebP (Max 5MB)</span>
                  </div>
                </div>
              </div>

              <!-- Current Background Preview -->
              <div>
                <div style="font-size: 11px; font-weight: bold; color: #4b5563; text-transform: uppercase; margin-bottom: 5px;">Latar Belakang Saat Ini:</div>
                @if(file_exists(public_path('uploads/background/dashboard_bg.jpg')))
                  <img src="{{ asset('uploads/background/dashboard_bg.jpg') }}?t={{ time() }}" style="width: 100%; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #becabe;" alt="Dashboard BG Preview">
                @else
                  <div style="width: 100%; height: 100px; border-radius: 8px; background: linear-gradient(135deg, #e8f5e9 0%, #a5d6a7 100%); display: flex; align-items: center; justify-content: center; font-size: 11px; color: #064e3b; font-weight: bold; border: 1px dashed #a5d6a7;">
                    Gradien Default Aktif
                  </div>
                @endif
              </div>

              <button type="submit" class="btn-submit" style="height: 40px; border: none; font-weight: bold; background: #064e3b; margin-top: 10px;">
                Update Background
              </button>
            </form>
          </div>
        </div>

        <!-- Section 6: Kelola Rundown Kegiatan PMBM -->
        <div style="background: #ffffff; border-radius: 12px; border: 1px solid #becabe; padding: 24px; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; gap: 20px;">
          <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #f0fdf4; padding-bottom: 12px;">
            <div style="font-weight: bold; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 16px; color: #064e3b;">Kelola Rundown Kegiatan PMBM</div>
          </div>

          <div style="display: flex; flex-direction: row; gap: 24px; align-items: flex-start; width: 100%; flex-wrap: wrap;">
            <!-- Form Tambah Rundown -->
            <form action="{{ route('tata_usaha.rundown.store') }}" method="POST" style="flex: 1; display: flex; flex-direction: column; gap: 15px; background: #f9fafb; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; min-width: 280px;">
              @csrf
              <div style="font-weight: bold; font-size: 13px; color: #374151; margin-bottom: 5px; text-transform: uppercase;">Tambah Item Rundown</div>

              <div class="form-group" style="margin-bottom: 0;">
                <label style="font-size: 11px; font-weight: bold; color: #4b5563;">Nama Kegiatan / Tahapan</label>
                <input type="text" name="kegiatan" required placeholder="Contoh: Sosialisasi & Pendaftaran Online Gel. 1" style="width: 100%;">
              </div>

              <div class="form-group" style="margin-bottom: 0;">
                <label style="font-size: 11px; font-weight: bold; color: #4b5563;">Tanggal / Waktu Pelaksanaan</label>
                <input type="text" name="tanggal" required placeholder="Contoh: 1 Mei - 30 Juni 2026" style="width: 100%;">
              </div>

              <div class="form-group" style="margin-bottom: 0;">
                <label style="font-size: 11px; font-weight: bold; color: #4b5563;">Keterangan / Lokasi</label>
                <textarea name="keterangan" required placeholder="Keterangan singkat kegiatan..." style="height: 60px; resize: none; width: 100%;"></textarea>
              </div>

              <button type="submit" class="btn-submit" style="height: 40px; border: none; font-weight: bold; background: #298752; color: white; border-radius: 6px; cursor: pointer;">
                Tambah Rundown
              </button>
            </form>

            <!-- Tabel Daftar Rundown -->
            <div style="flex: 1.5; display: flex; flex-direction: column; width: 100%; min-width: 280px;">
              <div style="font-weight: bold; font-size: 13px; color: #374151; margin-bottom: 10px; text-transform: uppercase;">Daftar Rundown Aktif</div>
              <div style="border: 1px solid #becabe; border-radius: 8px; overflow: hidden; background: #ffffff; max-height: 310px; overflow-y: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
                  <thead>
                    <tr style="background: #f0fdf4; border-bottom: 2px solid #becabe; color: #064e3b; font-weight: bold;">
                      <th style="padding: 10px 15px; width: 30%;">Waktu</th>
                      <th style="padding: 10px 15px; width: 30%;">Kegiatan</th>
                      <th style="padding: 10px 15px; width: 30%;">Keterangan</th>
                      <th style="padding: 10px 15px; width: 10%; text-align: center;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(empty($content['rundown']))
                      <tr>
                        <td colspan="4" style="padding: 20px; text-align: center; color: #9ca3af;">Belum ada item rundown kegiatan.</td>
                      </tr>
                    @else
                      @foreach($content['rundown'] as $index => $item)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                          <td style="padding: 10px 15px; font-weight: bold; color: #298752;">{{ $item['tanggal'] }}</td>
                          <td style="padding: 10px 15px; font-weight: bold;">{{ $item['kegiatan'] }}</td>
                          <td style="padding: 10px 15px; color: #4b5563;">{{ $item['keterangan'] }}</td>
                          <td style="padding: 10px 15px; text-align: center;">
                            <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                              <button type="button" onclick="openEditRundownModal('{{ $index }}', '{{ addslashes($item['kegiatan']) }}', '{{ addslashes($item['tanggal']) }}', '{{ addslashes($item['keterangan']) }}')" style="color: #298752; font-weight: bold; cursor: pointer; background: none; border: none; font-size: 13px;">Edit</button>
                              <form action="{{ route('tata_usaha.rundown.delete', $index) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rundown ini?')" style="margin: 0; padding: 0;">
                                @csrf
                                <button type="submit" style="color: #ef4444; font-weight: bold; cursor: pointer; background: none; border: none; font-size: 13px;">Hapus</button>
                              </form>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 2: JALUR PENDAFTARAN -->
      <div id="tab-programs" class="tab-pane" style="display: none; flex-direction: column; gap: 24px;">
        <!-- Section 3: Kategori Program -->
        <div class="section-3-study-program-categories" style="position: relative; top: auto; left: auto; right: auto; width: 100%; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); margin: 0; padding-bottom: 20px; height: auto; min-height: auto;">
          <div class="container13">
            <div class="container14">
              <img class="overlay3" src="{{ asset('assets/admin/landing-manage/overlay2.svg') }}" />
              <div class="heading-33">
                <div class="text" style="position: static;">Kategori Program Studi / Jalur</div>
              </div>
            </div>
            <div class="button3" style="cursor: pointer;" onclick="openCreateProgramModal()">
              <img class="container15" src="{{ asset('assets/admin/landing-manage/container16.svg') }}" />
            </div>
          </div>
          
          <div class="program-table-container">
            <table class="program-table">
              <thead>
                <tr>
                  <th style="width: 25%;">Nama Program</th>
                  <th style="width: 45%;">Deskripsi / Persyaratan</th>
                  <th style="width: 15%;">Kuota</th>
                  <th style="width: 15%; text-align: center;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($programs as $program)
                  <tr>
                    <td style="font-weight: bold; color: #121c2a;">{{ $program->nama_program }}</td>
                    <td>{{ $program->persyaratan ?? 'Fokus pendalaman kurikulum.' }}</td>
                    <td style="font-weight: bold; color: #298752;">{{ $program->kuota_program }} Siswa</td>
                    <td>
                      @php
                        $pWeights = $program->dss_weights ?? [
                            'hafalan' => 30,
                            'wawancara' => 20,
                            'calistung' => 20,
                            'tasmi' => 15,
                            'mandiri' => 15
                        ];
                      @endphp
                      <div style="display: flex; gap: 12px; justify-content: center; align-items: center;">
                        <button type="button" onclick="openEditProgramModal('{{ $program->id_program }}', '{{ addslashes($program->nama_program) }}', '{{ addslashes($program->persyaratan) }}', '{{ $program->kuota_program }}', '{{ $program->image ? asset($program->image) : '' }}', {{ $pWeights['hafalan'] }}, {{ $pWeights['wawancara'] }}, {{ $pWeights['calistung'] }}, {{ $pWeights['tasmi'] }}, {{ $pWeights['mandiri'] }})" style="color: #298752; font-weight: bold; cursor: pointer; background: none; border: none; font-family: inherit; font-size: 13px;">Edit</button>
                        <button type="button" onclick="confirmDeleteProgram('{{ $program->id_program }}', '{{ addslashes($program->nama_program) }}')" style="color: #ef4444; font-weight: bold; cursor: pointer; background: none; border: none; font-family: inherit; font-size: 13px;">Hapus</button>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- TAB 3: KONFIGURASI DSS -->
      <div id="tab-dss" class="tab-pane" style="display: none; flex-direction: column; gap: 24px;">
        <!-- Section: Konfigurasi Parameter DSS Seleksi PMBM -->
        <div style="background: #ffffff; border-radius: 12px; border: 1px solid #becabe; padding: 24px; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; gap: 20px;">
          <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #f0fdf4; padding-bottom: 12px;">
            <div style="font-weight: bold; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 16px; color: #064e3b; display: flex; align-items: center; gap: 8px;">
              <span>⚙️</span> Konfigurasi Parameter DSS Seleksi PMBM (Sistem Cerdas)
            </div>
          </div>

          <form action="{{ route('tata_usaha.dss.update') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
            @csrf
            <div style="display: flex; flex-direction: row; gap: 24px; width: 100%; align-items: stretch; justify-content: center; flex-wrap: wrap;">
              <!-- Column: Predikat Batas Angka -->
              <div style="width: 100%; max-width: 500px; background: #f9fafb; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; display: flex; flex-direction: column; gap: 12px;">
                <div style="font-weight: bold; font-size: 13px; color: #374151; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">Predikat Batas Angka DSS (Global)</div>
                
                <!-- Sangat Cakap -->
                <div>
                  <label style="font-size: 11px; font-weight: 700; color: #047857; text-transform: uppercase;">Sangat Cakap</label>
                  <div style="display: flex; gap: 8px; align-items: center; margin-top: 4px;">
                    <input type="number" name="pred_sangat_cakap_min" class="input-field" style="width: 100%;" value="{{ old('pred_sangat_cakap_min', $sangatCakap['min']) }}" required placeholder="Min">
                    <span style="font-size: 12px; color: #9ca3af;">s.d</span>
                    <input type="number" name="pred_sangat_cakap_max" class="input-field" style="width: 100%;" value="{{ old('pred_sangat_cakap_max', $sangatCakap['max']) }}" required placeholder="Max">
                  </div>
                </div>

                <!-- Cakap -->
                <div>
                  <label style="font-size: 11px; font-weight: 700; color: #2563eb; text-transform: uppercase;">Cakap</label>
                  <div style="display: flex; gap: 8px; align-items: center; margin-top: 4px;">
                    <input type="number" name="pred_cakap_min" class="input-field" style="width: 100%;" value="{{ old('pred_cakap_min', $cakap['min']) }}" required placeholder="Min">
                    <span style="font-size: 12px; color: #9ca3af;">s.d</span>
                    <input type="number" name="pred_cakap_max" class="input-field" style="width: 100%;" value="{{ old('pred_cakap_max', $cakap['max']) }}" required placeholder="Max">
                  </div>
                </div>

                <!-- Cukup Cakap -->
                <div>
                  <label style="font-size: 11px; font-weight: 700; color: #d97706; text-transform: uppercase;">Cukup Cakap</label>
                  <div style="display: flex; gap: 8px; align-items: center; margin-top: 4px;">
                    <input type="number" name="pred_cukup_cakap_min" class="input-field" style="width: 100%;" value="{{ old('pred_cukup_cakap_min', $cukupCakap['min']) }}" required placeholder="Min">
                    <span style="font-size: 12px; color: #9ca3af;">s.d</span>
                    <input type="number" name="pred_cukup_cakap_max" class="input-field" style="width: 100%;" value="{{ old('pred_cukup_cakap_max', $cukupCakap['max']) }}" required placeholder="Max">
                  </div>
                </div>

                <!-- Butuh Perhatian -->
                <div>
                  <label style="font-size: 11px; font-weight: 700; color: #b91c1c; text-transform: uppercase;">Butuh Perhatian</label>
                  <div style="display: flex; gap: 8px; align-items: center; margin-top: 4px;">
                    <input type="number" name="pred_perhatian_min" class="input-field" style="width: 100%;" value="{{ old('pred_perhatian_min', $butuhPerhatian['min']) }}" required placeholder="Min">
                    <span style="font-size: 12px; color: #9ca3af;">s.d</span>
                    <input type="number" name="pred_perhatian_max" class="input-field" style="width: 100%;" value="{{ old('pred_perhatian_max', $butuhPerhatian['max']) }}" required placeholder="Max">
                  </div>
                </div>
              </div>
            </div>

            <div style="display: flex; justify-content: flex-end;">
              <button type="submit" class="btn-submit" style="width: 280px; height: 44px; border: none; font-weight: bold; background: #064e3b;">
                Simpan Setelan &amp; Jalankan DSS
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- TAB 4: KELOLA FAQ CHATBOX -->
      <div id="tab-faq" class="tab-pane" style="display: none; flex-direction: column; gap: 24px;">
        <div style="background: #ffffff; border-radius: 12px; border: 1px solid #becabe; padding: 24px; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; gap: 20px;">
          <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #f0fdf4; padding-bottom: 12px; flex-wrap: wrap; gap: 10px;">
            <div style="font-weight: bold; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 16px; color: #064e3b; display: flex; align-items: center; gap: 8px;">
              <span>💬</span> Kelola FAQ Chatbot Calon Wali Murid
            </div>
            <button type="button" class="btn-submit" onclick="openCreateFaqModal()" style="width: auto; height: 36px; padding: 0 16px; background: #298752; color: #ffffff; border: none; font-size: 12px; border-radius: 6px; cursor: pointer;">
              + Tambah FAQ Baru
            </button>
          </div>

          <div class="program-table-container" style="max-height: 400px; overflow-y: auto;">
            <table class="program-table">
              <thead>
                <tr>
                  <th style="width: 30%;">Pertanyaan</th>
                  <th style="width: 55%;">Jawaban</th>
                  <th style="width: 15%; text-align: center;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($faqs as $faq)
                  <tr>
                    <td style="font-weight: bold; color: #121c2a; vertical-align: top;">{{ $faq->question }}</td>
                    <td style="color: #4b5563; line-height: 1.5; vertical-align: top;">{{ $faq->answer }}</td>
                    <td style="text-align: center; vertical-align: top;">
                      <div style="display: flex; gap: 12px; justify-content: center; align-items: center;">
                        <button type="button" onclick="openEditFaqModal('{{ $faq->id }}', '{{ addslashes($faq->question) }}', '{{ addslashes($faq->answer) }}')" style="color: #298752; font-weight: bold; cursor: pointer; background: none; border: none; font-family: inherit; font-size: 13px;">Edit</button>
                        <form action="{{ route('tata_usaha.faqs.delete', $faq->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')" style="margin: 0; padding: 0;">
                          @csrf
                          <button type="submit" style="color: #ef4444; font-weight: bold; cursor: pointer; background: none; border: none; font-family: inherit; font-size: 13px;">Hapus</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" style="text-align: center; color: #9ca3af; padding: 20px;">Belum ada FAQ. Silakan tambah FAQ baru.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- TAB 5: KELOLA KONTAK & MEDSOS -->
      <div id="tab-contacts" class="tab-pane" style="display: none; flex-direction: column; gap: 24px;">
        <div style="background: #ffffff; border-radius: 12px; border: 1px solid #becabe; padding: 24px; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; gap: 20px;">
          <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #f0fdf4; padding-bottom: 12px; flex-wrap: wrap; gap: 10px;">
            <div style="font-weight: bold; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 16px; color: #064e3b; display: flex; align-items: center; gap: 8px;">
              <span>📞</span> Kelola Kontak &amp; Media Sosial Sekolah
            </div>
            <button type="button" class="btn-submit" onclick="openCreateContactModal()" style="width: auto; height: 36px; padding: 0 16px; background: #298752; color: #ffffff; border: none; font-size: 12px; border-radius: 6px; cursor: pointer;">
              + Tambah Kontak Baru
            </button>
          </div>

          <div class="program-table-container" style="max-height: 400px; overflow-y: auto;">
            <table class="program-table">
              <thead>
                <tr>
                  <th style="width: 20%;">Platform / Media</th>
                  <th style="width: 25%;">Nilai / Kontak</th>
                  <th style="width: 30%;">Tautan Link</th>
                  <th style="width: 13%;">Ikon (Icon)</th>
                  <th style="width: 12%; text-align: center;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($contacts as $con)
                  <tr>
                    <td style="font-weight: bold; color: #121c2a;">{{ $con->platform_name }}</td>
                    <td style="color: #374151; font-weight: 600;">{{ $con->value }}</td>
                    <td style="color: #4b5563; word-break: break-all;"><a href="{{ $con->link }}" target="_blank" style="color: #298752; text-decoration: underline;">{{ $con->link }}</a></td>
                    <td style="color: #6b7280; font-family: monospace;">{{ $con->icon ?? '-' }}</td>
                    <td>
                      <div style="display: flex; gap: 12px; justify-content: center; align-items: center;">
                        <button type="button" onclick="openEditContactModal('{{ $con->id }}', '{{ addslashes($con->platform_name) }}', '{{ addslashes($con->value) }}', '{{ addslashes($con->link) }}', '{{ $con->icon }}')" style="color: #298752; font-weight: bold; cursor: pointer; background: none; border: none; font-family: inherit; font-size: 13px;">Edit</button>
                        <form action="{{ route('tata_usaha.contacts.delete', $con->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kontak ini?')" style="margin: 0; padding: 0;">
                          @csrf
                          <button type="submit" style="color: #ef4444; font-weight: bold; cursor: pointer; background: none; border: none; font-family: inherit; font-size: 13px;">Hapus</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" style="text-align: center; color: #9ca3af; padding: 20px;">Belum ada kontak. Silakan tambah kontak baru.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Tambah Program Modal Form -->
  <div class="modal" id="createProgramModal">
    <div class="modal-content">
      <h3 style="font-weight: bold; color: #064e3b; margin-bottom: 20px; font-size: 16px;">Tambah Program Baru</h3>
      
      <form action="{{ route('tata_usaha.programs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
          <label for="nama_program">Nama Program</label>
          <input type="text" name="nama_program" id="nama_program" required placeholder="Contoh: Program Unggulan / Sains">
        </div>
        
        <div class="form-group">
          <label for="persyaratan">Deskripsi / Persyaratan</label>
          <textarea name="persyaratan" id="persyaratan" required placeholder="Deskripsi program..." style="height: 80px; resize: none;"></textarea>
        </div>
        
        <div class="form-group">
          <label for="kuota_program">Kuota (Siswa)</label>
          <input type="number" name="kuota_program" id="kuota_program" required placeholder="Contoh: 50" min="0">
        </div>
        
        <div class="form-group">
          <label for="image">Foto / Image Program</label>
          <input type="file" name="image" id="image" accept="image/*" style="padding: 6px 12px;">
        </div>

        <div style="border-top: 1px solid #e5e7eb; padding-top: 15px; margin-top: 15px;">
          <h4 style="font-size: 11px; font-weight: bold; color: #064e3b; margin-bottom: 10px; text-transform: uppercase;">Bobot Kriteria Penilaian DSS (%)</h4>
          <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
            <div class="form-group" style="margin-bottom: 0;">
              <label for="weight_hafalan" style="font-size: 10px;">Hafalan</label>
              <input type="number" name="weight_hafalan" id="weight_hafalan" min="0" max="100" value="30" required>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
              <label for="weight_wawancara" style="font-size: 10px;">Wawancara</label>
              <input type="number" name="weight_wawancara" id="weight_wawancara" min="0" max="100" value="20" required>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
              <label for="weight_calistung" style="font-size: 10px;">Calistung</label>
              <input type="number" name="weight_calistung" id="weight_calistung" min="0" max="100" value="20" required>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
              <label for="weight_tasmi" style="font-size: 10px;">Tasmi</label>
              <input type="number" name="weight_tasmi" id="weight_tasmi" min="0" max="100" value="15" required>
            </div>
            <div class="form-group" style="margin-bottom: 0; grid-column: span 2;">
              <label for="weight_mandiri" style="font-size: 10px;">Mandiri</label>
              <input type="number" name="weight_mandiri" id="weight_mandiri" min="0" max="100" value="15" required>
            </div>
          </div>
          <small style="font-size: 10px; color: #6b7280; display: block; margin-top: 8px;">* Jumlah total kelima bobot kriteria wajib sama dengan 100%.</small>
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
          <button type="button" style="background: #f3f4f6; color: #4b5563; padding: 10px 15px; border-radius: 6px; cursor: pointer; border: 1px solid #d1d5db;" onclick="closeCreateProgramModal()">Batal</button>
          <button type="submit" style="background: #298752; color: #ffffff; padding: 10px 15px; border-radius: 6px; cursor: pointer;">Simpan Program</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Program Modal Form -->
  <div class="modal" id="editProgramModal">
    <div class="modal-content">
      <h3 id="editProgramTitle" style="font-weight: bold; color: #064e3b; margin-bottom: 20px; font-size: 16px;">Ubah Program Pendidikan</h3>
      
      <form id="editProgramForm" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
          <label for="edit_nama_program">Nama Program</label>
          <input type="text" name="nama_program" id="edit_nama_program" required placeholder="Nama Program">
        </div>
        
        <div class="form-group">
          <label for="edit_persyaratan">Deskripsi / Persyaratan</label>
          <textarea name="persyaratan" id="edit_persyaratan" required placeholder="Deskripsi program..." style="height: 80px; resize: none;"></textarea>
        </div>
        
        <div class="form-group">
          <label for="edit_kuota_program">Kuota (Siswa)</label>
          <input type="number" name="kuota_program" id="edit_kuota_program" required placeholder="Kuota" min="0">
        </div>
        
        <div class="form-group">
          <label for="edit_image">Foto / Image Program</label>
          <input type="file" name="image" id="edit_image" accept="image/*" style="padding: 6px 12px;">
          <div id="editProgramImageContainer" style="display: none; margin-top: 10px;">
            <span style="font-size: 11px; color: #6b7280; display: block; margin-bottom: 4px;">Foto Saat Ini:</span>
            <img id="editProgramImagePreview" src="" style="width: 100%; height: 100px; object-fit: cover; border-radius: 6px; border: 1px solid #becabe;">
          </div>
        </div>

        <div style="border-top: 1px solid #e5e7eb; padding-top: 15px; margin-top: 15px;">
          <h4 style="font-size: 11px; font-weight: bold; color: #064e3b; margin-bottom: 10px; text-transform: uppercase;">Bobot Kriteria Penilaian DSS (%)</h4>
          <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
            <div class="form-group" style="margin-bottom: 0;">
              <label for="edit_weight_hafalan" style="font-size: 10px;">Hafalan</label>
              <input type="number" name="weight_hafalan" id="edit_weight_hafalan" min="0" max="100" required>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
              <label for="edit_weight_wawancara" style="font-size: 10px;">Wawancara</label>
              <input type="number" name="weight_wawancara" id="edit_weight_wawancara" min="0" max="100" required>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
              <label for="edit_weight_calistung" style="font-size: 10px;">Calistung</label>
              <input type="number" name="weight_calistung" id="edit_weight_calistung" min="0" max="100" required>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
              <label for="edit_weight_tasmi" style="font-size: 10px;">Tasmi</label>
              <input type="number" name="weight_tasmi" id="edit_weight_tasmi" min="0" max="100" required>
            </div>
            <div class="form-group" style="margin-bottom: 0; grid-column: span 2;">
              <label for="edit_weight_mandiri" style="font-size: 10px;">Mandiri</label>
              <input type="number" name="weight_mandiri" id="edit_weight_mandiri" min="0" max="100" required>
            </div>
          </div>
          <small style="font-size: 10px; color: #6b7280; display: block; margin-top: 8px;">* Jumlah total kelima bobot kriteria wajib sama dengan 100%.</small>
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
          <button type="button" style="background: #f3f4f6; color: #4b5563; padding: 10px 15px; border-radius: 6px; cursor: pointer; border: 1px solid #d1d5db;" onclick="closeEditProgramModal()">Batal</button>
          <button type="submit" style="background: #298752; color: #ffffff; padding: 10px 15px; border-radius: 6px; cursor: pointer;">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Form Hapus Program Tersembunyi -->
  <form id="deleteProgramForm" method="POST" style="display: none;">
    @csrf
  </form>

  <!-- Edit Rundown Modal Form -->
  <div class="modal" id="editRundownModal">
    <div class="modal-content">
      <h3 style="font-weight: bold; color: #064e3b; margin-bottom: 20px; font-size: 16px;">Ubah Item Rundown</h3>
      
      <form id="editRundownForm" method="POST">
        @csrf
        
        <div class="form-group">
          <label for="edit_kegiatan">Nama Kegiatan / Tahapan</label>
          <input type="text" name="kegiatan" id="edit_kegiatan" required placeholder="Contoh: Sosialisasi & Pendaftaran Online Gel. 1">
        </div>
        
        <div class="form-group">
          <label for="edit_tanggal">Tanggal / Waktu Pelaksanaan</label>
          <input type="text" name="tanggal" id="edit_tanggal" required placeholder="Contoh: 1 Mei - 30 Juni 2026">
        </div>
        
        <div class="form-group">
          <label for="edit_keterangan">Keterangan / Lokasi</label>
          <textarea name="keterangan" id="edit_keterangan" required placeholder="Keterangan singkat kegiatan..." style="height: 80px; resize: none;"></textarea>
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
          <button type="button" style="background: #f3f4f6; color: #4b5563; padding: 10px 15px; border-radius: 6px; cursor: pointer; border: 1px solid #d1d5db;" onclick="closeEditRundownModal()">Batal</button>
          <button type="submit" style="background: #298752; color: #ffffff; padding: 10px 15px; border-radius: 6px; cursor: pointer;">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Tambah FAQ Modal Form -->
  <div class="modal" id="createFaqModal">
    <div class="modal-content">
      <h3 style="font-weight: bold; color: #064e3b; margin-bottom: 20px; font-size: 16px;">Tambah FAQ Baru</h3>
      
      <form action="{{ route('tata_usaha.faqs.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
          <label for="faq_question">Pertanyaan (Question)</label>
          <input type="text" name="question" id="faq_question" required placeholder="Contoh: Bagaimana cara daftar ulang?">
        </div>
        
        <div class="form-group">
          <label for="faq_answer">Jawaban (Answer)</label>
          <textarea name="answer" id="faq_answer" required placeholder="Tulis jawaban di sini..." style="height: 120px; resize: none;"></textarea>
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
          <button type="button" style="background: #f3f4f6; color: #4b5563; padding: 10px 15px; border-radius: 6px; cursor: pointer; border: 1px solid #d1d5db;" onclick="closeCreateFaqModal()">Batal</button>
          <button type="submit" style="background: #298752; color: #ffffff; padding: 10px 15px; border-radius: 6px; cursor: pointer;">Simpan FAQ</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit FAQ Modal Form -->
  <div class="modal" id="editFaqModal">
    <div class="modal-content">
      <h3 style="font-weight: bold; color: #064e3b; margin-bottom: 20px; font-size: 16px;">Ubah FAQ</h3>
      
      <form id="editFaqForm" method="POST">
        @csrf
        
        <div class="form-group">
          <label for="edit_faq_question">Pertanyaan (Question)</label>
          <input type="text" name="question" id="edit_faq_question" required placeholder="Pertanyaan">
        </div>
        
        <div class="form-group">
          <label for="edit_faq_answer">Jawaban (Answer)</label>
          <textarea name="answer" id="edit_faq_answer" required placeholder="Tulis jawaban..." style="height: 120px; resize: none;"></textarea>
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
          <button type="button" style="background: #f3f4f6; color: #4b5563; padding: 10px 15px; border-radius: 6px; cursor: pointer; border: 1px solid #d1d5db;" onclick="closeEditFaqModal()">Batal</button>
          <button type="submit" style="background: #298752; color: #ffffff; padding: 10px 15px; border-radius: 6px; cursor: pointer;">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Tambah Kontak Modal Form -->
  <div class="modal" id="createContactModal">
    <div class="modal-content">
      <h3 style="font-weight: bold; color: #064e3b; margin-bottom: 20px; font-size: 16px;">Tambah Kontak / Medsos Baru</h3>
      
      <form action="{{ route('tata_usaha.contacts.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
          <label for="contact_platform_name">Platform / Media</label>
          <input type="text" name="platform_name" id="contact_platform_name" required placeholder="Contoh: WhatsApp, Instagram, Telepon">
        </div>
        
        <div class="form-group">
          <label for="contact_value">Nilai / Kontak (Display Value)</label>
          <input type="text" name="value" id="contact_value" required placeholder="Contoh: @min3kra atau 0812...">
        </div>

        <div class="form-group">
          <label for="contact_link">Tautan URL Link</label>
          <input type="text" name="link" id="contact_link" required placeholder="Contoh: https://wa.me/628...">
        </div>

        <div class="form-group">
          <label for="contact_icon">Nama Ikon (Bootstrap Icon Name)</label>
          <input type="text" name="icon" id="contact_icon" placeholder="Contoh: whatsapp, instagram, phone, envelope">
          <small style="font-size: 10px; color: #6b7280;">Masukkan nama class Bootstrap icon (misal: 'whatsapp' untuk bi-whatsapp).</small>
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
          <button type="button" style="background: #f3f4f6; color: #4b5563; padding: 10px 15px; border-radius: 6px; cursor: pointer; border: 1px solid #d1d5db;" onclick="closeCreateContactModal()">Batal</button>
          <button type="submit" style="background: #298752; color: #ffffff; padding: 10px 15px; border-radius: 6px; cursor: pointer;">Simpan Kontak</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Kontak Modal Form -->
  <div class="modal" id="editContactModal">
    <div class="modal-content">
      <h3 style="font-weight: bold; color: #064e3b; margin-bottom: 20px; font-size: 16px;">Ubah Kontak / Medsos</h3>
      
      <form id="editContactForm" method="POST">
        @csrf
        
        <div class="form-group">
          <label for="edit_contact_platform_name">Platform / Media</label>
          <input type="text" name="platform_name" id="edit_contact_platform_name" required placeholder="Platform/Media">
        </div>
        
        <div class="form-group">
          <label for="edit_contact_value">Nilai / Kontak (Display Value)</label>
          <input type="text" name="value" id="edit_contact_value" required placeholder="Kontak">
        </div>

        <div class="form-group">
          <label for="edit_contact_link">Tautan URL Link</label>
          <input type="text" name="link" id="edit_contact_link" required placeholder="URL Link">
        </div>

        <div class="form-group">
          <label for="edit_contact_icon">Nama Ikon (Bootstrap Icon Name)</label>
          <input type="text" name="icon" id="edit_contact_icon" placeholder="Bootstrap Icon Name">
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
          <button type="button" style="background: #f3f4f6; color: #4b5563; padding: 10px 15px; border-radius: 6px; cursor: pointer; border: 1px solid #d1d5db;" onclick="closeEditContactModal()">Batal</button>
          <button type="submit" style="background: #298752; color: #ffffff; padding: 10px 15px; border-radius: 6px; cursor: pointer;">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    function openCreateProgramModal() {
      document.getElementById('createProgramModal').style.display = 'flex';
    }
    function closeCreateProgramModal() {
      document.getElementById('createProgramModal').style.display = 'none';
    }
    function openEditProgramModal(id, name, persyaratan, kuota, imageUrl, wHafalan, wWawancara, wCalistung, wTasmi, wMandiri) {
      document.getElementById('editProgramTitle').innerText = 'Ubah Program: ' + name;
      document.getElementById('edit_nama_program').value = name;
      document.getElementById('edit_persyaratan').value = persyaratan;
      document.getElementById('edit_kuota_program').value = kuota;
      document.getElementById('edit_image').value = '';
      
      document.getElementById('edit_weight_hafalan').value = wHafalan || 30;
      document.getElementById('edit_weight_wawancara').value = wWawancara || 20;
      document.getElementById('edit_weight_calistung').value = wCalistung || 20;
      document.getElementById('edit_weight_tasmi').value = wTasmi || 15;
      document.getElementById('edit_weight_mandiri').value = wMandiri || 15;
      
      if (imageUrl) {
        document.getElementById('editProgramImagePreview').src = imageUrl;
        document.getElementById('editProgramImageContainer').style.display = 'block';
      } else {
        document.getElementById('editProgramImageContainer').style.display = 'none';
      }
      
      let updateRoute = "{{ route('tata_usaha.programs.update', ':id') }}";
      updateRoute = updateRoute.replace(':id', id);
      document.getElementById('editProgramForm').action = updateRoute;
      
      document.getElementById('editProgramModal').style.display = 'flex';
    }
    function closeEditProgramModal() {
      document.getElementById('editProgramModal').style.display = 'none';
    }
    function confirmDeleteProgram(id, name) {
      if (confirm("Apakah Anda yakin ingin menghapus program '" + name + "'? Tindakan ini tidak dapat dibatalkan.")) {
        let deleteRoute = "{{ route('tata_usaha.programs.delete', ':id') }}";
        deleteRoute = deleteRoute.replace(':id', id);
        let form = document.getElementById('deleteProgramForm');
        form.action = deleteRoute;
        form.submit();
      }
    }
    
    function openEditRundownModal(index, kegiatan, tanggal, keterangan) {
      document.getElementById('edit_kegiatan').value = kegiatan;
      document.getElementById('edit_tanggal').value = tanggal;
      document.getElementById('edit_keterangan').value = keterangan;
      
      let updateRoute = "{{ route('tata_usaha.rundown.update', ':index') }}";
      updateRoute = updateRoute.replace(':index', index);
      document.getElementById('editRundownForm').action = updateRoute;
      
      document.getElementById('editRundownModal').style.display = 'flex';
    }
    
    function closeEditRundownModal() {
      document.getElementById('editRundownModal').style.display = 'none';
    }

    // FAQ Modals
    function openCreateFaqModal() {
      document.getElementById('createFaqModal').style.display = 'flex';
    }
    function closeCreateFaqModal() {
      document.getElementById('createFaqModal').style.display = 'none';
    }
    function openEditFaqModal(id, question, answer) {
      document.getElementById('edit_faq_question').value = question;
      document.getElementById('edit_faq_answer').value = answer;
      
      let updateRoute = "{{ route('tata_usaha.faqs.update', ':id') }}";
      updateRoute = updateRoute.replace(':id', id);
      document.getElementById('editFaqForm').action = updateRoute;
      
      document.getElementById('editFaqModal').style.display = 'flex';
    }
    function closeEditFaqModal() {
      document.getElementById('editFaqModal').style.display = 'none';
    }

    // Contact Modals
    function openCreateContactModal() {
      document.getElementById('createContactModal').style.display = 'flex';
    }
    function closeCreateContactModal() {
      document.getElementById('createContactModal').style.display = 'none';
    }
    function openEditContactModal(id, platformName, value, link, icon) {
      document.getElementById('edit_contact_platform_name').value = platformName;
      document.getElementById('edit_contact_value').value = value;
      document.getElementById('edit_contact_link').value = link;
      document.getElementById('edit_contact_icon').value = icon || '';
      
      let updateRoute = "{{ route('tata_usaha.contacts.update', ':id') }}";
      updateRoute = updateRoute.replace(':id', id);
      document.getElementById('editContactForm').action = updateRoute;
      
      document.getElementById('editContactModal').style.display = 'flex';
    }
    function closeEditContactModal() {
      document.getElementById('editContactModal').style.display = 'none';
    }

    // Tab Switching
    function switchTab(tabId) {
      document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.style.display = 'none';
        pane.classList.remove('active');
      });
      const targetPane = document.getElementById(tabId);
      if (targetPane) {
        targetPane.style.display = 'flex';
        targetPane.classList.add('active');
      }
      
      document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
        btn.style.color = '#475569';
        btn.style.backgroundColor = 'transparent';
        btn.style.borderColor = 'transparent';
      });
      
      const activeBtn = document.getElementById('btn-' + tabId);
      if (activeBtn) {
        activeBtn.classList.add('active');
        activeBtn.style.color = '#008744';
        activeBtn.style.backgroundColor = '#eef5ed';
        activeBtn.style.borderColor = '#becabe';
      }

      localStorage.setItem('cms_active_tab', tabId);
    }

    document.addEventListener('DOMContentLoaded', function() {
      let activeTab = 'tab-landing';
      const hashTabMap = { '#dss': 'tab-dss', '#faq': 'tab-faq', '#kontak': 'tab-contacts', '#program': 'tab-programs' };
      @if(session('success_faq'))
        activeTab = 'tab-faq';
      @elseif(session('success_contact'))
        activeTab = 'tab-contacts';
      @else
        activeTab = hashTabMap[window.location.hash] || localStorage.getItem('cms_active_tab') || 'tab-landing';
      @endif
      switchTab(activeTab);
    });
  </script>
@endsection
