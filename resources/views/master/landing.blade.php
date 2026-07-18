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
    <div style="position: absolute; left: 380px; top: 180px; right: 40px; display: flex; flex-direction: column; gap: 24px; z-index: 10;">
      
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
        </div>

        <div style="display: flex; flex-direction: row; gap: 24px; width: 100%; align-items: stretch; height: auto; flex-wrap: wrap;">
          <!-- Row 2: Terms and Conditions -->
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
        </div></div>

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

  <!-- Tambah Program Modal Form -->
  <div class="modal" id="createProgramModal">
    <div class="modal-content" style="width: 500px; max-height: 90vh; overflow-y: auto;">
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
          <h4 style="font-size: 11px; font-weight: bold; color: #064e3b; margin-bottom: 10px; text-transform: uppercase;">Kriteria Persyaratan Kelulusan</h4>
          <div id="createCriteriaContainer" style="display: flex; flex-direction: column; gap: 10px;">
            <!-- Dynamic rows will be inserted here -->
          </div>
          <button type="button" onclick="addCriteriaRow('createCriteriaContainer')" style="margin-top: 10px; background: #eef5ed; color: #005b31; font-weight: bold; padding: 6px 12px; border: 1px dashed #005b31; border-radius: 6px; cursor: pointer; font-size: 11px; width: 100%;">+ Tambah Kriteria</button>
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
    <div class="modal-content" style="width: 500px; max-height: 90vh; overflow-y: auto;">
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
          <h4 style="font-size: 11px; font-weight: bold; color: #064e3b; margin-bottom: 10px; text-transform: uppercase;">Kriteria Persyaratan Kelulusan</h4>
          <div id="editCriteriaContainer" style="display: flex; flex-direction: column; gap: 10px;">
            <!-- Dynamic rows will be inserted here -->
          </div>
          <button type="button" onclick="addCriteriaRow('editCriteriaContainer')" style="margin-top: 10px; background: #eef5ed; color: #005b31; font-weight: bold; padding: 6px 12px; border: 1px dashed #005b31; border-radius: 6px; cursor: pointer; font-size: 11px; width: 100%;">+ Tambah Kriteria</button>
        </div>
        
        <div style="display: flex; justify-content: justify-content-end; gap: 10px; margin-top: 25px;">
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
    const criteriaOptions = [
      { value: 'hafalan', label: 'Hafalan' },
      { value: 'aism', label: 'AISM' },
      { value: 'iqro', label: 'Iqro' },
      { value: 'calistung', label: 'Calistung' },
      { value: 'dikte', label: 'Dikte' },
      { value: 'kemandirian', label: 'Kemandirian' }
    ];

    function addCriteriaRow(containerId, name = '', minVal = '') {
      const container = document.getElementById(containerId);
      const rowId = 'row_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5);
      
      let optionsHtml = '';
      criteriaOptions.forEach(opt => {
        const selected = opt.value === name ? 'selected' : '';
        optionsHtml += `<option value="${opt.value}" ${selected}>${opt.label}</option>`;
      });

      const rowHtml = `
        <div id="${rowId}" style="display: flex; gap: 10px; align-items: center; width: 100%;">
          <select name="criteria_name[]" style="flex: 1.5; padding: 8px 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 12px; outline: none; background: #ffffff;">
            ${optionsHtml}
          </select>
          <input type="number" name="criteria_min[]" value="${minVal !== '' ? minVal : 50}" min="0" max="100" placeholder="Min (0-100)" style="flex: 1; padding: 8px 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 12px; outline: none;">
          <button type="button" onclick="document.getElementById('${rowId}').remove()" style="background: #fee2e2; color: #ef4444; border: 1px solid #fecaca; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: bold; font-family: inherit;">Hapus</button>
        </div>
      `;
      container.insertAdjacentHTML('beforeend', rowHtml);
    }

    function openCreateProgramModal() {
      document.getElementById('createCriteriaContainer').innerHTML = '';
      addCriteriaRow('createCriteriaContainer', 'hafalan', 50);
      addCriteriaRow('createCriteriaContainer', 'calistung', 50);
      addCriteriaRow('createCriteriaContainer', 'iqro', 50);
      document.getElementById('createProgramModal').style.display = 'flex';
    }

    function closeCreateProgramModal() {
      document.getElementById('createProgramModal').style.display = 'none';
    }

    function openEditProgramModal(id, name, persyaratan, kuota, imageUrl, criteriaJson) {
      document.getElementById('editProgramTitle').innerText = 'Ubah Program: ' + name;
      document.getElementById('edit_nama_program').value = name;
      document.getElementById('edit_persyaratan').value = persyaratan;
      document.getElementById('edit_kuota_program').value = kuota;
      document.getElementById('edit_image').value = '';
      
      const container = document.getElementById('editCriteriaContainer');
      container.innerHTML = '';
      
      if (criteriaJson && criteriaJson.length > 0) {
        criteriaJson.forEach(c => {
          addCriteriaRow('editCriteriaContainer', c.nama_kriteria, c.nilai_minimum);
        });
      } else {
        addCriteriaRow('editCriteriaContainer', 'hafalan', 50);
        addCriteriaRow('editCriteriaContainer', 'calistung', 50);
      }
      
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
      const hashTabMap = { '#program': 'tab-programs' };
      activeTab = hashTabMap[window.location.hash] || localStorage.getItem('cms_active_tab') || 'tab-landing';
      switchTab(activeTab);
    });
  </script>
@endsection
