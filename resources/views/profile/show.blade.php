@extends('layouts.admin')

@section('title', 'Detail Calon Murid - Admin Portal')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/admin/profile/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/profile/style.css') }}">
  <style>
    .profile-card {
      position: absolute;
      left: 340px;
      top: 150px;
      right: 40px;
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      padding: 30px;
      font-family: sans-serif;
    }
    .profile-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid #f3f4f6;
      padding-bottom: 20px;
      margin-bottom: 25px;
    }
    .profile-header h2 {
      font-size: 20px;
      color: #064e3b;
      font-weight: bold;
    }
    .status-badge {
      padding: 6px 16px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: bold;
    }
    .status-pending { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .status-keterima { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .status-tidak-keterima { background: #fef2f2; color: #b91c1c; border: 1px solid #fca5a5; }

    .grid-details {
      display: grid;
      grid-template-cols: 1fr 1fr;
      gap: 30px;
    }
    .detail-section h3 {
      font-size: 13px;
      font-weight: bold;
      color: #374151;
      text-transform: uppercase;
      border-left: 4px solid #298752;
      padding-left: 10px;
      margin-bottom: 15px;
    }
    .detail-row {
      display: flex;
      margin-bottom: 12px;
      font-size: 13px;
    }
    .detail-label {
      width: 140px;
      color: #6b7280;
      font-weight: 500;
    }
    .detail-value {
      flex: 1;
      color: #1f2937;
      font-weight: bold;
    }
    .document-link {
      display: inline-block;
      background: #f3f4f6;
      color: #298752;
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: bold;
      margin-right: 10px;
      margin-bottom: 10px;
      text-decoration: none;
      border: 1px solid #e5e7eb;
    }
    .document-link:hover {
      background: #e6f4ea;
    }
    .btn-action {
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 13px;
      font-weight: bold;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
    
    /* Workflow Tracker */
    .workflow-tracker {
      display: flex;
      flex-direction: column;
      gap: 20px;
      margin-top: 20px;
      font-family: inherit;
    }
    .tracker-step {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      transition: all 0.3s ease;
    }
    .tracker-step.completed {
      border-color: #a7f3d0;
      background: #f0fdf4;
    }
    .tracker-step.active {
      border-color: #3b82f6;
      background: #eff6ff;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.05);
    }
    .tracker-step.disabled {
      opacity: 0.5;
      pointer-events: none;
    }
    .tracker-step-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .tracker-step-title {
      font-size: 14px;
      font-weight: bold;
      color: #334155;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .tracker-step.completed .tracker-step-title {
      color: #065f46;
    }
    .tracker-step.active .tracker-step-title {
      color: #1e3a8a;
    }
    .tracker-badge {
      font-size: 10px;
      font-weight: bold;
      padding: 4px 8px;
      border-radius: 9999px;
      text-transform: uppercase;
    }
    .tracker-badge.completed { background: #d1fae5; color: #065f46; }
    .tracker-badge.active { background: #dbeafe; color: #1e40af; }
    .tracker-badge.pending { background: #f1f5f9; color: #64748b; }
    .tracker-badge.tidak-lulus { background: #fee2e2; color: #b91c1c; }
  </style>
@endsection

@section('content')
  <!-- Background shell block -->
  <div class="desktop-19" style="height: 100vh; overflow-y: auto;">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'applicants'])

    <!-- Dynamic Profile Card Overlay -->
    <div class="profile-card">
      <div class="profile-header">
        <div>
          <h2>Detail Calon Murid: {{ $student->nama_murid }}</h2>
          <p style="color: #6b7280; font-size: 12px; margin-top: 4px;">No Registrasi: PMB-2026-{{ str_pad($pendaftaran->id_pendaftaran, 3, '0', STR_PAD_LEFT) }} | Jalur: {{ $pendaftaran->program->nama_program }}</p>
        </div>
        <div>
          @php
            $badgeClass = 'status-pending';
            $statusLabel = '';
            
            if ($pendaftaran->status_verifikasi === 'menunggu_verifikasi') {
                $statusLabel = 'Menunggu Verifikasi';
                $badgeClass = 'status-pending';
            } elseif ($pendaftaran->status_verifikasi === 'ditolak') {
                $statusLabel = 'Berkas Online Ditolak';
                $badgeClass = 'status-tidak-keterima';
            } elseif ($pendaftaran->status_verifikasi === 'terverifikasi') {
                $statusLabel = 'Berkas Online Terverifikasi';
                $badgeClass = 'status-keterima';
            } elseif ($pendaftaran->status_verifikasi === 'terverifikasi_onsite') {
                if (is_null($pendaftaran->status_kelulusan)) {
                    $statusLabel = 'Berkas Onsite Terverifikasi';
                    $badgeClass = 'status-keterima';
                } else {
                    if ($pendaftaran->status_kelulusan === 'lulus') {
                        if ($pendaftaran->status_konfirmasi === 'terkonfirmasi') {
                            $statusLabel = 'Diterima (Terkonfirmasi)';
                            $badgeClass = 'status-keterima';
                        } elseif ($pendaftaran->status_konfirmasi === 'mengundurkan_diri') {
                            $statusLabel = 'Mengundurkan Diri';
                            $badgeClass = 'status-tidak-keterima';
                        } else {
                            $statusLabel = 'Lulus (Belum Konfirmasi)';
                            $badgeClass = 'status-keterima';
                        }
                    } elseif ($pendaftaran->status_kelulusan === 'cadangan') {
                        $statusLabel = 'Lulus Cadangan';
                        $badgeClass = 'status-pending';
                    } elseif ($pendaftaran->status_kelulusan === 'tidak_lulus') {
                        $statusLabel = 'Tidak Lulus';
                        $badgeClass = 'status-tidak-keterima';
                    }
                }
            }
          @endphp
          <span class="status-badge {{ $badgeClass }}">{{ strtoupper($statusLabel) }}</span>
        </div>
      </div>

      <!-- Detail Grid Content -->
      <div class="grid-details">
        
        <!-- Section A: Student Personal Data -->
        <div class="detail-section">
          <h3>Identitas Calon Siswa</h3>
          
          <div class="detail-row">
            <div class="detail-label">Nama Lengkap</div>
            <div class="detail-value">{{ $student->nama_murid }}</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">NISN</div>
            <div class="detail-value">{{ $student->nisn }}</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">TTL</div>
            <div class="detail-value">{{ $student->tempat_lahir }}, {{ date('d F Y', strtotime($student->tanggal_lahir)) }}</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Alamat Rumah</div>
            <div class="detail-value">{{ $student->alamat }}</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Tanggal Daftar</div>
            <div class="detail-value">{{ date('d M Y H:i', strtotime($pendaftaran->created_at)) }}</div>
          </div>
        </div>

        <!-- Section B: Family Data -->
        <div class="detail-section">
          <h3>Identitas Orang Tua / Wali</h3>
          
          <div class="detail-row">
            <div class="detail-label">Nama Ayah</div>
            <div class="detail-value">{{ $student->ayah->nama_ayah }}</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Pekerjaan Ayah</div>
            <div class="detail-value">{{ $student->ayah->pekerjaan ?? '-' }}</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">No. WA Ayah</div>
            <div class="detail-value">{{ $student->ayah->nomor_telpon ?? '-' }}</div>
          </div>
          
          <div class="detail-row" style="margin-top: 15px;">
            <div class="detail-label">Nama Ibu</div>
            <div class="detail-value">{{ $student->ibu->nama_ibu }}</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Pekerjaan Ibu</div>
            <div class="detail-value">{{ $student->ibu->pekerjaan ?? '-' }}</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">No. WA Ibu</div>
            <div class="detail-value">{{ $student->ibu->nomor_telpon ?? '-' }}</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Email Kontak</div>
            <div class="detail-value">{{ $student->email ?? '-' }}</div>
          </div>
        </div>

        <!-- Section C: Documents Uploaded -->
        <div class="detail-section full-width" style="grid-column: span 2; border-top: 1px solid #f3f4f6; padding-top: 25px;">
          <h3>Berkas Dokumen</h3>
          <div style="display: flex; gap: 24px; margin-top: 15px;">
            <!-- Left Side: Document List Buttons -->
            <div style="flex: 1; display: flex; flex-direction: column; gap: 10px; max-width: 250px;">
              @if($student->pas_foto)
                <button type="button" onclick="previewDoc('{{ route('document.preview', ['type' => 'pas_foto', 'filename' => basename($student->pas_foto)]) }}')" style="width: 100%; text-align: left; margin: 0; cursor: pointer; font-family: inherit; font-size: 13px; display: inline-block; background: #f3f4f6; color: #298752; padding: 10px 16px; border-radius: 8px; font-weight: bold; border: 1px solid #e5e7eb; transition: all 0.2s; outline: none;" onmouseover="this.style.background='#e6f4ea'" onmouseout="this.style.background='#f3f4f6'">🖼️ Pas Foto</button>
              @endif
              @if($student->kartu_keluarga)
                <button type="button" onclick="previewDoc('{{ route('document.preview', ['type' => 'kartu_keluarga', 'filename' => basename($student->kartu_keluarga)]) }}')" style="width: 100%; text-align: left; margin: 0; cursor: pointer; font-family: inherit; font-size: 13px; display: inline-block; background: #f3f4f6; color: #298752; padding: 10px 16px; border-radius: 8px; font-weight: bold; border: 1px solid #e5e7eb; transition: all 0.2s; outline: none;" onmouseover="this.style.background='#e6f4ea'" onmouseout="this.style.background='#f3f4f6'">📄 Kartu Keluarga</button>
              @endif
              @if($student->akta_kelahiran)
                <button type="button" onclick="previewDoc('{{ route('document.preview', ['type' => 'akta_kelahiran', 'filename' => basename($student->akta_kelahiran)]) }}')" style="width: 100%; text-align: left; margin: 0; cursor: pointer; font-family: inherit; font-size: 13px; display: inline-block; background: #f3f4f6; color: #298752; padding: 10px 16px; border-radius: 8px; font-weight: bold; border: 1px solid #e5e7eb; transition: all 0.2s; outline: none;" onmouseover="this.style.background='#e6f4ea'" onmouseout="this.style.background='#f3f4f6'">📄 Akta Kelahiran</button>
              @endif
              @if($student->kartu_identitas_anak)
                <button type="button" onclick="previewDoc('{{ route('document.preview', ['type' => 'kartu_identitas_anak', 'filename' => basename($student->kartu_identitas_anak)]) }}')" style="width: 100%; text-align: left; margin: 0; cursor: pointer; font-family: inherit; font-size: 13px; display: inline-block; background: #f3f4f6; color: #298752; padding: 10px 16px; border-radius: 8px; font-weight: bold; border: 1px solid #e5e7eb; transition: all 0.2s; outline: none;" onmouseover="this.style.background='#e6f4ea'" onmouseout="this.style.background='#f3f4f6'">📄 KIA</button>
              @endif
            </div>
            
            <!-- Right Side: Document Viewer Box -->
            <div style="flex: 2;">
              <div id="document-viewer-container" style="border: 1px solid #e5e7eb; border-radius: 12px; height: 200px; display: flex; align-items: center; justify-content: center; background: #f9fafb; color: #6b7280; font-size: 13px; font-weight: 500; overflow: hidden; position: relative; transition: height 0.3s ease;">
                <div style="text-align: center; padding: 20px;">
                  <div style="font-size: 32px; margin-bottom: 8px;">📂</div>
                  Pilih dokumen di sebelah kiri untuk melihat tampilan berkas secara langsung
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Section D: Actions & Verification -->
        <div class="detail-section full-width" style="grid-column: span 2; border-top: 1px solid #f3f4f6; padding-top: 25px;">
          <h3>Verifikasi &amp; Transisi Status</h3>
          
          <!-- Show rejection reason if currently Berkas Ditolak -->
          @if($pendaftaran->status_verifikasi === 'ditolak')
            <div style="background: #fef2f2; border: 1px solid #fca5a5; border-radius: 8px; padding: 15px; margin-bottom: 20px; color: #b91c1c;">
              <strong style="display: block; margin-bottom: 5px;">✕ Pendaftaran Ditolak</strong>
              <span>Alasan Penolakan: {{ $pendaftaran->alasan_penolakan }}</span>
            </div>
          @endif
 
          <!-- Show reserve status warning if currently Cadangan -->
          @if($pendaftaran->status_kelulusan === 'cadangan')
            @php
              $expiredAt = $pendaftaran->updated_at->addWeek();
              $daysLeft = now()->diffInDays($expiredAt, false);
            @endphp
            <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
              <strong style="display: block; color: #d97706; margin-bottom: 5px;">⏳ Status Cadangan Sementara</strong>
              <span style="color: #4b5563; font-size: 13px;">Status ini akan berubah otomatis menjadi <strong>Tidak Lulus</strong> pada {{ $expiredAt->format('d M Y H:i') }} (sisa {{ max(0, ceil($daysLeft)) }} hari lagi) jika tidak diubah ke status Lulus.</span>
            </div>
          @endif
          <!-- Error alert inside the actions block -->
          @if(session('error'))
            <div style="padding: 10px 15px; background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; font-size: 13px; border-radius: 6px; margin-bottom: 20px; font-weight: bold;">
              {{ session('error') }}
            </div>
          @endif
          
          <!-- Workflow Tracker -->
          <div class="workflow-tracker">
            
            <!-- STEP 1: Verifikasi Berkas Online -->
            @php
              $step1Active = in_array($pendaftaran->status_verifikasi, ['menunggu_verifikasi', 'ditolak']);
              $step1Completed = in_array($pendaftaran->status_verifikasi, ['terverifikasi', 'terverifikasi_onsite']);
            @endphp
            <div class="tracker-step @if($step1Completed) completed @elseif($step1Active) active @endif">
              <div class="tracker-step-header">
                <span class="tracker-step-title">
                  <span>1️⃣</span> Verifikasi Berkas Online
                </span>
                <span class="tracker-badge @if($step1Completed) completed @elseif($pendaftaran->status_verifikasi === 'ditolak') tidak-lulus @else active @endif">
                  {{ $pendaftaran->status_verifikasi === 'ditolak' ? 'Ditolak' : ($step1Completed ? 'Selesai' : 'Aktif') }}
                </span>
              </div>
              
              <div class="tracker-step-content" style="font-size: 13px; color: #4b5563; margin-top: 8px;">
                @if($step1Completed)
                  <p style="color: #047857; font-weight: bold;">✓ Berkas administrasi online telah disetujui.</p>
                @elseif($pendaftaran->status_verifikasi === 'ditolak')
                  <p style="color: #b91c1c; font-weight: bold; margin-bottom: 10px;">✕ Berkas online ditolak dengan alasan: "{{ $pendaftaran->alasan_penolakan }}"</p>
                  <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="action" value="verifikasi_berkas">
                    <input type="hidden" name="status_verifikasi" value="terverifikasi">
                    <button type="submit" class="btn-action" style="background: #298752; color: #ffffff; border: none; border-radius: 8px;">
                      ✓ Ubah &amp; Setujui Berkas
                    </button>
                  </form>
                @else
                  <p style="margin-bottom: 15px;">Periksa berkas dokumen yang diunggah pendaftar. Tentukan apakah lolos administrasi atau ditolak.</p>
                  <div style="display: flex; gap: 10px;">
                    <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST" style="display: inline;">
                      @csrf
                      <input type="hidden" name="action" value="verifikasi_berkas">
                      <input type="hidden" name="status_verifikasi" value="terverifikasi">
                      <button type="submit" class="btn-action" style="background: #298752; color: #ffffff; border: none; border-radius: 8px;">
                        ✓ Terima Berkas (Lolos Administrasi)
                      </button>
                    </form>
                    
                    <button onclick="toggleRejectionForm()" class="btn-action" style="background: #ef4444; color: #ffffff; border: none; border-radius: 8px;">
                      ✕ Tolak Berkas
                    </button>
                  </div>

                  <!-- Rejection Form Inline -->
                  <div id="rejectionFormArea" style="display: none; background: #ffffff; border: 1px solid #fca5a5; border-radius: 8px; padding: 15px; margin-top: 15px;">
                    <h4 style="font-weight: bold; color: #b91c1c; margin-bottom: 10px; font-size: 13px;">Alasan Penolakan Berkas</h4>
                    <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST">
                      @csrf
                      <input type="hidden" name="action" value="verifikasi_berkas">
                      <input type="hidden" name="status_verifikasi" value="ditolak">
                      <div class="form-group" style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 15px;">
                        <textarea name="alasan_penolakan" placeholder="Sebutkan berkas yang kurang atau tidak sesuai..." style="width: 100%; padding: 10px; border: 1px solid #becabe; border-radius: 6px; font-family: inherit; font-size: 13px; height: 80px; resize: none;" required></textarea>
                      </div>
                      <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <button type="button" onclick="toggleRejectionForm()" style="background: #e2e8f0; color: #475569; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; font-size: 11px; font-weight: bold;">Batal</button>
                        <button type="submit" style="background: #ef4444; color: #ffffff; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; font-size: 11px; font-weight: bold;">Kirim</button>
                      </div>
                    </form>
                  </div>
                @endif
              </div>
            </div>

            <!-- STEP 2: Verifikasi Berkas Onsite -->
            @php
              $step2Disabled = !$step1Completed;
              $step2Active = $pendaftaran->status_verifikasi === 'terverifikasi';
              $step2Completed = $pendaftaran->status_verifikasi === 'terverifikasi_onsite';
            @endphp
            <div class="tracker-step @if($step2Disabled) disabled @elseif($step2Completed) completed @elseif($step2Active) active @endif">
              <div class="tracker-step-header">
                <span class="tracker-step-title">
                  <span>2️⃣</span> Verifikasi Berkas Onsite
                </span>
                <span class="tracker-badge @if($step2Completed) completed @elseif($step2Active) active @else pending @endif">
                  @if($step2Completed) Selesai @elseif($step2Active) Aktif @else Menunggu @endif
                </span>
              </div>
              
              <div class="tracker-step-content" style="font-size: 13px; color: #4b5563; margin-top: 8px;">
                @if($step2Completed)
                  <p style="color: #047857; font-weight: bold;">✓ Berkas fisik telah diverifikasi secara onsite.</p>
                @elseif($step2Active)
                  <p style="margin-bottom: 12px;">Wali murid harus mengumpulkan berkas fisik secara onsite ke sekolah. Jika berkas fisik sudah lengkap dan terverifikasi oleh panitia, tandai di bawah.</p>
                  <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="cek_berkas_onsite">
                    <button type="submit" class="btn-action" style="background: #008744; color: #ffffff; border: none; border-radius: 8px;">
                      📁 Konfirmasi Berkas Onsite Lengkap
                    </button>
                  </form>
                @else
                  <p>Menunggu verifikasi berkas online disetujui.</p>
                @endif
              </div>
            </div>

            <!-- STEP 3: Evaluasi &amp; Penetapan Kelulusan -->
            @php
              $step3Disabled = !$step2Completed;
              $hasHasil = !is_null($student->hasil);
              $step3Completed = !is_null($pendaftaran->status_kelulusan);
              $step3Active = $step2Completed && !$step3Completed;
            @endphp
            <div class="tracker-step @if($step3Disabled) disabled @elseif($step3Completed) completed @elseif($step3Active) active @endif">
              <div class="tracker-step-header">
                <span class="tracker-step-title">
                  <span>3️⃣</span> Evaluasi &amp; Penetapan Kelulusan
                </span>
                <span class="tracker-badge @if($step3Completed) completed @elseif($step3Active) active @else pending @endif">
                  @if($step3Completed) Selesai @elseif($step3Active) Aktif @else Menunggu @endif
                </span>
              </div>
              
              <div class="tracker-step-content" style="font-size: 13px; color: #4b5563; margin-top: 8px;">
                <!-- Nilai & Rekomendasi Display -->
                @if($hasHasil)
                  <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin-bottom: 15px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.01);">
                    <strong style="color: #0f7643; display: block; margin-bottom: 8px; font-size: 12px; text-transform: uppercase;">Hasil Ujian &amp; Wawancara (Panitia)</strong>
                    <div style="display: grid; grid-template-cols: 1fr 1fr; gap: 8px; margin-bottom: 8px;">
                      <div>Hafalan: <strong>{{ $student->hasil->nilai_hafalan }}</strong></div>
                      <div>Wawancara: <strong>{{ $student->hasil->nilai_wawancara }}</strong></div>
                      <div>Calistung: <strong>{{ $student->hasil->nilai_calistung }}</strong></div>
                      <div>Tasmi: <strong>{{ $student->hasil->nilai_tasmi }}</strong></div>
                      <div>Kemandirian: <strong>{{ $student->hasil->nilai_mandiri }}</strong></div>
                    </div>
                    <div style="border-top: 1px solid #f1f5f9; padding-top: 8px; margin-top: 8px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                      <div>Nilai Akhir Rata-rata: <strong style="font-size: 14px; color: #008744;">{{ number_format($student->hasil->nilai_akhir, 2) }}</strong></div>
                      @php
                        $recom = \App\Services\DssService::getRecommendation($pendaftaran);
                        $recomColor = $recom === 'Diterima di Program Pilihan' ? '#047857' : ($recom === 'Pindahkan ke Program Reguler' ? '#c2410c' : '#b91c1c');
                      @endphp
                      <div>Saran Sistem DSS: <strong style="color: {{ $recomColor }}">{{ $recom }}</strong></div>
                    </div>
                    
                    @if($student->hasil->inputted_by)
                      <div style="border-top: 1px solid #f1f5f9; padding-top: 8px; margin-top: 8px; font-size: 12px; color: #4b5563;">
                        Diuput oleh: <strong>{{ $student->hasil->inputted_by }}</strong>
                      </div>
                    @endif

                    <div style="border-top: 1px solid #f1f5f9; padding-top: 10px; margin-top: 10px;">
                      <form action="{{ route('tata_usaha.change_program', $pendaftaran->id_pendaftaran) }}" method="POST" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        @csrf
                        <label for="change_id_program" style="font-size: 12px; color: #374151; font-weight: 600;">Ubah Program Pilihan:</label>
                        <select name="id_program" id="change_id_program" style="padding: 4px 8px; border: 1px solid #becabe; border-radius: 6px; font-family: inherit; font-size: 12px; outline: none; background: #ffffff;">
                          @foreach(\App\Models\Program::all() as $prog)
                            <option value="{{ $prog->id_program }}" {{ $pendaftaran->id_program == $prog->id_program ? 'selected' : '' }}>
                              {{ $prog->nama_program }}
                            </option>
                          @endforeach
                        </select>
                        <button type="submit" style="background: #005b31; color: white; padding: 4px 10px; border: none; border-radius: 6px; font-size: 11px; font-weight: bold; cursor: pointer;">
                          Ubah Jalur
                        </button>
                      </form>
                    </div>
                  </div>
                @else
                  <div style="background: #fffbeb; border: 1px solid #fef3c7; border-radius: 8px; padding: 12px; margin-bottom: 15px; color: #b45309;">
                    ⏳ Menunggu panitia PMBM memasukkan nilai tes tertulis &amp; wawancara calon siswa.
                  </div>
                @endif

                @if($step3Completed)
                  <p>Kelulusan ditetapkan: <strong style="color: #008744; text-transform: uppercase;">{{ $pendaftaran->status_kelulusan }}</strong> @if($pendaftaran->status_kelulusan === 'cadangan' && $pendaftaran->peringkat_cadangan) (Antrean ke-{{ $pendaftaran->peringkat_cadangan }}) @endif</p>
                @elseif($step3Active)
                  @if($hasHasil)
                    <p style="margin-bottom: 12px;">Pilih keputusan kelulusan untuk siswa ini berdasarkan hasil evaluasi di atas:</p>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                      <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="penetapan_kelulusan">
                        <input type="hidden" name="status_kelulusan" value="lulus">
                        <button type="submit" class="btn-action" style="background: #298752; color: #ffffff; border: none; border-radius: 8px;">Nyatakan Lulus</button>
                      </form>

                      <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="penetapan_kelulusan">
                        <input type="hidden" name="status_kelulusan" value="cadangan">
                        <button type="submit" class="btn-action" style="background: #d97706; color: #ffffff; border: none; border-radius: 8px;">Lulus Cadangan</button>
                      </form>

                      <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="penetapan_kelulusan">
                        <input type="hidden" name="status_kelulusan" value="tidak_lulus">
                        <button type="submit" class="btn-action" style="background: #ef4444; color: #ffffff; border: none; border-radius: 8px;" onclick="return confirm('Apakah Anda yakin?')">Tidak Lulus</button>
                      </form>
                    </div>
                  @else
                    <p>Keputusan kelulusan terkunci hingga nilai ujian dimasukkan oleh panitia.</p>
                  @endif
                @else
                  <p>Menunggu berkas fisik onsite diverifikasi.</p>
                @endif
              </div>
            </div>

            <!-- STEP 4: Konfirmasi Daftar Ulang Onsite -->
            @php
              $step4Disabled = !$step3Completed || $pendaftaran->status_kelulusan === 'tidak_lulus';
              $step4Completed = !is_null($pendaftaran->status_konfirmasi) && $pendaftaran->status_konfirmasi !== 'belum_konfirmasi';
              $step4Active = !$step4Disabled && !$step4Completed;
            @endphp
            <div class="tracker-step @if($step4Disabled) disabled @elseif($step4Completed) completed @elseif($step4Active) active @endif">
              <div class="tracker-step-header">
                <span class="tracker-step-title">
                  <span>4️⃣</span> Konfirmasi &amp; Daftar Ulang Onsite
                </span>
                <span class="tracker-badge @if($step4Completed) completed @elseif($step4Active) active @else pending @endif">
                  @if($step4Completed) Selesai @elseif($step4Active) Aktif @else Menunggu @endif
                </span>
              </div>
              
              <div class="tracker-step-content" style="font-size: 13px; color: #4b5563; margin-top: 8px;">
                @if($pendaftaran->status_kelulusan === 'tidak_lulus')
                  <p>Calon siswa dinyatakan Tidak Lulus, tidak memerlukan daftar ulang.</p>
                @elseif($step4Completed)
                  <p>Konfirmasi status: <strong style="text-transform: uppercase; color: #008744;">{{ $pendaftaran->status_konfirmasi }}</strong></p>
                @elseif($step4Active)
                  @if($pendaftaran->status_kelulusan === 'lulus')
                    <p style="margin-bottom: 12px;">Wali murid harus melakukan konfirmasi daftar ulang secara onsite. Update status kehadiran di bawah:</p>
                    <div style="display: flex; gap: 10px;">
                      <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="konfirmasi_onsite">
                        <input type="hidden" name="status_konfirmasi" value="terkonfirmasi">
                        <button type="submit" class="btn-action" style="background: #298752; color: #ffffff; border: none; border-radius: 8px;">Terkonfirmasi (Hadir)</button>
                      </form>

                      <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="konfirmasi_onsite">
                        <input type="hidden" name="status_konfirmasi" value="mengundurkan_diri">
                        <button type="submit" class="btn-action" style="background: #6b7280; color: #ffffff; border: none; border-radius: 8px;" onclick="return confirm('Apakah Anda yakin?')">Mengundurkan Diri</button>
                      </form>
                    </div>
                  @elseif($pendaftaran->status_kelulusan === 'cadangan')
                    <p style="margin-bottom: 12px;">Calon siswa ini berada dalam status Cadangan. Anda dapat mempromosikan mereka ke Lulus jika ada siswa utama yang mengundurkan diri.</p>
                    <div style="display: flex; gap: 10px;">
                      <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="promosi_cadangan">
                        <button type="submit" class="btn-action" style="background: #0f7643; color: #ffffff; border: none; border-radius: 8px;">⭐ Promosikan ke Lulus</button>
                      </form>

                      <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="penetapan_kelulusan">
                        <input type="hidden" name="status_kelulusan" value="tidak_lulus">
                        <button type="submit" class="btn-action" style="background: #ef4444; color: #ffffff; border: none; border-radius: 8px;" onclick="return confirm('Apakah Anda yakin?')">Tolak (Tidak Lulus)</button>
                      </form>
                    </div>
                  @endif
                @else
                  <p>Menunggu hasil kelulusan diumumkan.</p>
                @endif
              </div>
            </div>

          </div>

          <div style="margin-top: 30px;">
            <a href="{{ route('scores.index') }}" class="btn-action" style="background: #f3f4f6; color: #4b5563; text-decoration: none; border: 1px solid #d1d5db; border-radius: 8px;">
              ← Kembali ke Daftar
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    function toggleRejectionForm() {
      const area = document.getElementById('rejectionFormArea');
      if (area.style.display === 'none' || area.style.display === '') {
        area.style.display = 'block';
        area.scrollIntoView({ behavior: 'smooth' });
      } else {
        area.style.display = 'none';
      }
    }

    function previewDoc(url) {
      const container = document.getElementById('document-viewer-container');
      const isPdf = url.toLowerCase().endsWith('.pdf') || url.toLowerCase().includes('pdf');
      
      container.style.height = '480px';
      container.innerHTML = `
        <div style="position: absolute; top: 10px; right: 10px; z-index: 10;">
          <a href="${url}" target="_blank" style="background: rgba(0, 91, 49, 0.9); color: white; padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: bold; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.15);">
            Buka di Tab Baru ↗
          </a>
        </div>
        ${isPdf 
          ? `<iframe src="${url}" style="width: 100%; height: 100%; border: none;"></iframe>`
          : `<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; padding: 10px;"><img src="${url}" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" /></div>`
        }
      `;
    }
  </script>
@endsection
