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
            $statusLabel = $pendaftaran->status;
            
            if ($pendaftaran->status === 'Pending') {
                $statusLabel = 'BARU / PENDING';
            }
            
            if (in_array($pendaftaran->status, ['Berkas Diterima', 'Berkas Onsite Diterima', 'Lulus', 'Diterima'])) {
                $badgeClass = 'status-keterima';
            } elseif (in_array($pendaftaran->status, ['Berkas Ditolak', 'Tidak Lulus', 'Mengundurkan Diri'])) {
                $badgeClass = 'status-tidak-keterima';
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
            <div class="detail-value">{{ $student->ibu->email }}</div>
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
          @if($pendaftaran->status === 'Berkas Ditolak')
            <div style="background: #fef2f2; border: 1px solid #fca5a5; border-radius: 8px; padding: 15px; margin-bottom: 20px; color: #b91c1c;">
              <strong style="display: block; margin-bottom: 5px;">✕ Pendaftaran Ditolak</strong>
              <span>Alasan Penolakan: {{ $pendaftaran->alasan_ditolak }}</span>
            </div>
          @endif

          <!-- Show reserve status warning if currently Cadangan -->
          @if($pendaftaran->status === 'Cadangan')
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

          <div style="display: flex; gap: 15px; margin-top: 15px; flex-wrap: wrap; align-items: flex-start;">
            <a href="{{ route('scores.index') }}" class="btn-action" style="background: #f3f4f6; color: #4b5563; text-decoration: none; border: 1px solid #d1d5db; border-radius: 8px;">
              ← Kembali ke Daftar
            </a>

            <!-- State: Pending (Baru/Perubahan) -->
            @if($pendaftaran->status === 'Pending')
              <!-- Action: Terima Berkas -->
              <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="status" value="Berkas Diterima">
                <button type="submit" class="btn-action" style="background: #298752; color: #ffffff; border: none; border-radius: 8px;">
                  ✓ Terima Berkas (Lolos Administrasi)
                </button>
              </form>

              <!-- Action: Tolak Berkas -->
              <button onclick="toggleRejectionForm()" class="btn-action" style="background: #ef4444; color: #ffffff; border: none; border-radius: 8px;">
                ✕ Tolak Berkas
              </button>
            @endif

            <!-- State: Berkas Ditolak -->
            @if($pendaftaran->status === 'Berkas Ditolak')
              <!-- Action: Terima Berkas (Lolos Administrasi setelah revisi) -->
              <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="status" value="Berkas Diterima">
                <button type="submit" class="btn-action" style="background: #298752; color: #ffffff; border: none; border-radius: 8px;">
                  ✓ Ubah &amp; Terima Berkas (Lolos Administrasi)
                </button>
              </form>
            @endif

            <!-- State: Berkas Diterima -->
            @if($pendaftaran->status === 'Berkas Diterima')
              <!-- Action: Verifikasi Berkas Onsite -->
              <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="status" value="Berkas Onsite Diterima">
                <button type="submit" class="btn-action" style="background: #005b31; color: #ffffff; border: none; border-radius: 8px;">
                  📁 Verifikasi Berkas Onsite Selesai (Siap Ujian &amp; Wawancara)
                </button>
              </form>
            @endif

            <!-- State: Berkas Onsite Diterima -->
            @if($pendaftaran->status === 'Berkas Onsite Diterima')
              <!-- Action: Lulus -->
              <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="status" value="Lulus">
                <button type="submit" class="btn-action" style="background: #298752; color: #ffffff; border: none; border-radius: 8px;">
                  🎓 Nyatakan Lulus Seleksi
                </button>
              </form>

              <!-- Action: Cadangan -->
              <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="status" value="Cadangan">
                <button type="submit" class="btn-action" style="background: #d97706; color: #ffffff; border: none; border-radius: 8px;" onclick="return confirm('Apakah Anda yakin ingin memasukkan calon siswa ini ke status cadangan sementara?')">
                  ⏳ Nyatakan Lulus Cadangan (1 Minggu)
                </button>
              </form>

              <!-- Action: Tidak Lulus -->
              <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="status" value="Tidak Lulus">
                <button type="submit" class="btn-action" style="background: #ef4444; color: #ffffff; border: none; border-radius: 8px;" onclick="return confirm('Apakah Anda yakin ingin menyatakan siswa ini tidak lulus?')">
                  ✕ Nyatakan Tidak Lulus
                </button>
              </form>
            @endif

            <!-- State: Lulus or Cadangan -->
            @if($pendaftaran->status === 'Lulus' || $pendaftaran->status === 'Cadangan')
              <!-- Action: Diterima (Daftar Ulang) -->
              <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="status" value="Diterima">
                <button type="submit" class="btn-action" style="background: #298752; color: #ffffff; border: none; border-radius: 8px;">
                  ✓ Daftar Ulang: Diterima
                </button>
              </form>

              <!-- Action: Mengundurkan Diri -->
              <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="status" value="Mengundurkan Diri">
                <button type="submit" class="btn-action" style="background: #6b7280; color: #ffffff; border: none; border-radius: 8px;" onclick="return confirm('Apakah Anda yakin ingin mencatat status mengundurkan diri?')">
                  ✕ Daftar Ulang: Mengundurkan Diri
                </button>
              </form>
            @endif
          </div>

          <!-- Rejection Form Popup/Toggle Area -->
          <div id="rejectionFormArea" style="display: none; background: #f8fafc; border: 1px solid #becabe; border-radius: 12px; padding: 20px; margin-top: 20px; width: 100%; max-width: 500px;">
            <h4 style="font-weight: bold; color: #b91c1c; margin-bottom: 15px; font-size: 14px;">Masukkan Alasan Penolakan Berkas</h4>
            <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST">
              @csrf
              <input type="hidden" name="status" value="Berkas Ditolak">
              <div class="form-group" style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 15px;">
                <label style="font-size: 11px; font-weight: bold; color: #4b5563;">DESKRIPSI ALASAN</label>
                <textarea name="alasan_ditolak" placeholder="Contoh: Berkas Akta Kelahiran tidak terbaca jelas atau file rusak..." style="width: 100%; padding: 10px; border: 1px solid #becabe; border-radius: 6px; font-family: inherit; font-size: 13px; height: 100px; resize: none;" required></textarea>
              </div>
              <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="toggleRejectionForm()" style="background: #e2e8f0; color: #475569; padding: 8px 15px; border-radius: 6px; border: none; cursor: pointer; font-size: 12px; font-weight: bold;">Batal</button>
                <button type="submit" style="background: #ef4444; color: #ffffff; padding: 8px 15px; border-radius: 6px; border: none; cursor: pointer; font-size: 12px; font-weight: bold;">Kirim Penolakan</button>
              </div>
            </form>
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
