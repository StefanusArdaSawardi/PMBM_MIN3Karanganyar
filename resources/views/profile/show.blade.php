@extends('layouts.admin')

@section('title', 'Detail Registrasi - Admin Portal')

@section('content')
  <div class="relative min-h-screen flow-root">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'applicants'])

    <!-- Content Wrapper -->
    <div class="absolute left-[380px] top-[180px] right-10 flex flex-col gap-6 z-0 max-[1024px]:left-5 max-[1024px]:right-5 max-[1024px]:top-[150px]">

      <!-- Page Header -->
      <div class="flex flex-col gap-1">
        <div class="text-[#181c1c] text-[28px] font-bold tracking-[-0.56px]" style="font-family: 'Manrope-Bold', sans-serif;">Detail Registrasi {{ $student->nama_murid }}</div>
        <div class="text-[#3f4941] text-[14px]">Kelola dan pantau seluruh pendaftar calon siswa baru MIN 3 Karanganyar periode aktif.</div>
      </div>

      <!-- Breadcrumb & Reg Number -->
      <div class="flex items-center justify-between flex-wrap gap-3">
        <div class="flex items-center gap-3">
          <div class="text-[#004228] text-[22px] font-semibold">Detail Registrasi: {{ $student->nama_murid }}</div>
          <span class="bg-[#93f4b0] text-[#00723d] text-[12px] font-bold px-3 py-1 rounded-full">PMBM-2026-{{ str_pad($pendaftaran->id_pendaftaran, 4, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="flex gap-3">
          <button type="button" onclick="window.print()" class="border border-[#6f7a71] rounded-lg px-4 py-2 flex items-center gap-2 text-[#004228] text-[14px] cursor-pointer bg-white">
            <svg width="15" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v8H6v-8z"/></svg>
            Cetak Formulir
          </button>
          <button type="button" onclick="alert('Fitur dalam proses pengembangan')" class="bg-[#004228] rounded-lg px-4 py-2 flex items-center gap-2 text-white text-[14px] cursor-pointer">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Data
          </button>
        </div>
      </div>

      @php
        $step1Active = in_array($pendaftaran->status_verifikasi, ['menunggu_verifikasi', 'ditolak']);
        $step1Completed = in_array($pendaftaran->status_verifikasi, ['terverifikasi', 'terverifikasi_onsite']);

        $stepWaCompleted = $pendaftaran->status_grup_wa === 'sudah_masuk';
        $stepWaActive = $step1Completed && !$stepWaCompleted;

        $step2Completed = $pendaftaran->status_verifikasi === 'terverifikasi_onsite';
        $step2Active = $stepWaCompleted && !$step2Completed;

        $step3Completed = !is_null($pendaftaran->status_kelulusan);
        $step3Active = $step2Completed && !$step3Completed;

        $step4Completed = !is_null($pendaftaran->status_konfirmasi) && $pendaftaran->status_konfirmasi !== 'belum_konfirmasi';
        $step4Disabled = !$step3Completed || $pendaftaran->status_kelulusan === 'tidak_lulus';
        $step4Active = !$step4Disabled && !$step4Completed;

        $steps = [
          ['label' => 'Pendaftaran', 'sub' => '(ONLINE VERIFICATION)', 'done' => $step1Completed, 'active' => $step1Active],
          ['label' => 'Grup WhatsApp', 'sub' => '', 'done' => $stepWaCompleted, 'active' => $stepWaActive],
          ['label' => 'Verifikasi Offline', 'sub' => '', 'done' => $step2Completed, 'active' => $step2Active],
          ['label' => 'Seleksi', 'sub' => '', 'done' => $step3Completed, 'active' => $step3Active],
          ['label' => 'Daftar Ulang', 'sub' => '', 'done' => $step4Completed, 'active' => $step4Active],
        ];
        $currentStepIndex = collect($steps)->search(fn($s) => $s['active']);
        if ($currentStepIndex === false) {
            $currentStepIndex = collect($steps)->filter(fn($s) => $s['done'])->count();
        }
      @endphp

      <!-- Progress Stepper -->
      <div class="bg-white border border-[#bfc9c0] rounded-xl p-6 overflow-x-auto">
        <div class="flex items-center justify-between min-w-[700px] relative px-4">
          <div class="absolute bg-[#bfc9c0] h-[2px] left-[40px] right-[40px] top-[20px]"></div>
          <div class="absolute bg-[#004228] h-[2px] left-[40px] top-[20px]" style="width: {{ $currentStepIndex > 0 ? (($currentStepIndex) / (count($steps) - 1)) * 100 : 0 }}%; max-width: calc(100% - 80px);"></div>
          @foreach($steps as $i => $step)
            <div class="bg-white flex flex-col gap-2 items-center px-4 relative z-10">
              <div class="{{ $step['done'] ? 'bg-[#004228] text-white' : ($step['active'] ? 'bg-[#005b31] text-white' : 'bg-[#e0e3e2] text-[#6f7a71]') }} flex items-center justify-center rounded-full size-10 text-[14px] font-bold shrink-0">
                {{ $i + 1 }}
              </div>
              <div class="text-[14px] {{ $step['done'] || $step['active'] ? 'text-[#004228]' : 'text-[#3f4942]' }} text-center whitespace-nowrap">{{ $step['label'] }}</div>
              @if($step['sub'])
                <div class="text-[9px] font-semibold text-[#004228] uppercase tracking-wide text-center whitespace-nowrap">{{ $step['sub'] }}</div>
              @endif
              <div class="text-[10px] text-[#6f7a71] whitespace-nowrap">{{ $step['done'] ? 'Selesai' : ($step['active'] ? 'Aktif' : 'Menunggu') }}</div>
            </div>
          @endforeach
        </div>
      </div>

      <!-- Two Column Layout -->
      <div class="flex gap-6 items-start max-[1100px]:flex-col {{ $step3Active ? 'hidden' : '' }}">
        <!-- Left Column -->
        <div class="flex-1 flex flex-col gap-6 min-w-0">

          <!-- Identity Card -->
          <div class="bg-white border border-[#bfc9c0] rounded-xl p-6 flex flex-col gap-4">
            <div class="border-b border-[#bfc9c0] pb-4 flex items-center gap-3 text-[#004228] text-[18px] font-semibold">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 20c0-4 3.6-6 8-6s8 2 8 6"/></svg>
              {{ $step4Active ? 'Identitas Siswa Baru' : 'Identitas Calon Siswa' }}
            </div>
            <div class="grid grid-cols-2 gap-x-12 gap-y-4">
              <div class="flex flex-col gap-1">
                <div class="text-[#6f7a71] text-[11px] font-bold tracking-wide uppercase">Nama Lengkap</div>
                <div class="text-[#181c1c] text-[16px] font-semibold">{{ $student->nama_murid }}</div>
              </div>
              <div class="flex flex-col gap-1">
                <div class="text-[#6f7a71] text-[11px] font-bold tracking-wide uppercase">NISN</div>
                <div class="text-[#181c1c] text-[16px] font-semibold">{{ $student->nisn }}</div>
              </div>
              <div class="flex flex-col gap-1">
                <div class="text-[#6f7a71] text-[11px] font-bold tracking-wide uppercase">Tempat</div>
                <div class="text-[#181c1c] text-[16px] font-semibold">{{ $student->tempat_lahir }}</div>
              </div>
              <div class="flex flex-col gap-1">
                <div class="text-[#6f7a71] text-[11px] font-bold tracking-wide uppercase">Tanggal Lahir</div>
                <div class="text-[#181c1c] text-[16px] font-semibold">{{ date('d M Y', strtotime($student->tanggal_lahir)) }}</div>
              </div>
              <div class="flex flex-col gap-1">
                <div class="text-[#6f7a71] text-[11px] font-bold tracking-wide uppercase">Jenis Kelamin</div>
                <div class="text-[#181c1c] text-[16px] font-semibold">{{ $student->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
              </div>
              <div class="flex flex-col gap-1">
                <div class="text-[#6f7a71] text-[11px] font-bold tracking-wide uppercase">Alamat Domisili</div>
                <div class="text-[#181c1c] text-[16px] font-semibold">{{ $student->alamat }}</div>
              </div>
            </div>
          </div>

          @if($stepWaActive)
            <!-- Admin Action Card -->
            <div class="bg-[#004228]/5 border border-[#004228]/10 rounded-xl p-6 flex flex-col gap-3">
              <div class="text-[#004228] text-[12px] font-semibold tracking-wide">Tindakan Admin</div>
              <div class="text-[#3f4942] text-[14px]">Verifikasi manual jika siswa sudah bergabung di grup tanpa melalui link.</div>
              <form action="{{ route('tata_usaha.grup_whatsapp.status', $pendaftaran->id_pendaftaran) }}" method="POST">
                @csrf
                <input type="hidden" name="status_grup_wa" value="sudah_masuk">
                <button type="submit" class="bg-[#004228] text-white rounded-lg py-3 w-full text-[16px] cursor-pointer">Tandai Sudah Bergabung</button>
              </form>
            </div>
          @endif

          @unless($stepWaActive || $stepWaCompleted)
            <!-- Documents Checklist Card -->
            <div class="bg-white border border-[#bfc9c0] rounded-xl p-6 flex flex-col gap-4">
              <div class="border-b border-[#bfc9c0] pb-4 flex items-center justify-between">
                <div class="flex items-center gap-3 text-[#004228] text-[18px] font-semibold">
                  <svg width="16" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 2v6h6M9 13h6M9 17h6"/></svg>
                  Kelengkapan Berkas Online
                </div>
                @php
                  $allDocsPresent = $student->pas_foto && $student->kartu_keluarga && $student->akta_kelahiran && $student->kartu_identitas_anak;
                @endphp
                <span class="{{ $allDocsPresent ? 'bg-[#d9e6da] text-[#004228]' : 'bg-[#ffdad6] text-[#ba1a1a]' }} text-[12px] font-bold px-3 py-1 rounded-full">
                  {{ $allDocsPresent ? 'Lengkap' : 'Belum Lengkap' }}
                </span>
              </div>
              <div class="flex flex-col gap-3">
                @php
                  $docs = [
                    ['label' => 'Pas Foto 3x4', 'value' => $student->pas_foto, 'type' => 'pas_foto'],
                    ['label' => 'Kartu Keluarga (KK)', 'value' => $student->kartu_keluarga, 'type' => 'kartu_keluarga'],
                    ['label' => 'Akta Kelahiran', 'value' => $student->akta_kelahiran, 'type' => 'akta_kelahiran'],
                    ['label' => 'KIA', 'value' => $student->kartu_identitas_anak, 'type' => 'kartu_identitas_anak'],
                  ];
                @endphp
                @foreach($docs as $doc)
                  @if($doc['value'])
                    <div class="bg-[#f1f4f3] border border-[#bfc9c0] rounded-lg p-3 flex items-center justify-between">
                      <span class="flex items-center gap-3 text-[#181c1c] text-[14px]">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#004228" stroke-width="1.5" class="shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 2v6h6M9 13h6M9 17h6"/></svg>
                        {{ $doc['label'] }}
                      </span>
                      <button type="button" onclick="previewDoc('{{ route('document.preview', ['type' => $doc['type'], 'filename' => basename($doc['value'])]) }}')" class="text-[#004228] text-[14px] font-bold cursor-pointer">Lihat</button>
                    </div>
                  @else
                    <div class="bg-[rgba(255,218,214,0.2)] border-2 border-dashed border-[#ba1a1a] rounded-lg p-3 flex items-center justify-between">
                      <span class="flex items-center gap-3 text-[#ba1a1a] text-[14px]">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ba1a1a" stroke-width="1.5" class="shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                        {{ $doc['label'] }} (belum diunggah)
                      </span>
                    </div>
                  @endif
                @endforeach
              </div>

              <!-- Document Viewer -->
              <div id="document-viewer-container" class="border border-gray-200 rounded-xl h-[200px] flex items-center justify-center bg-gray-50 text-gray-500 text-[13px] font-medium overflow-hidden relative transition-[height] duration-300">
                <div class="text-center p-5">
                  <svg class="mx-auto mb-2" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
                  Pilih dokumen di atas untuk melihat tampilan berkas secara langsung
                </div>
              </div>

              <div class="bg-[#d9e6da] rounded-lg p-4 text-[#131e17] text-[12px]">
                Tahap saat ini: {{ $step1Completed ? 'Verifikasi Onsite' : 'Verifikasi Dokumen Online' }}. Orang tua telah diinformasikan melalui Email &amp; WhatsApp untuk memantau progres pendaftaran.
              </div>

              @if($pendaftaran->status_verifikasi === 'menunggu_verifikasi')
                <div class="border-t border-[#bfc9c0] pt-4 flex flex-col gap-4">
                  <div class="text-[#004228] text-[12px] font-bold uppercase tracking-wide">Persetujuan Berkas Pendaftaran Online</div>
                  
                  <div class="flex gap-4">
                    <!-- Approve Button Form -->
                    <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST" style="flex: 1; margin: 0; padding: 0;">
                      @csrf
                      <input type="hidden" name="action" value="verifikasi_berkas">
                      <input type="hidden" name="status_verifikasi" value="terverifikasi">
                      <button type="submit" class="bg-[#004228] text-white rounded-lg py-2.5 w-full text-[14px] font-bold cursor-pointer border-none hover:bg-[#064e3b] transition-colors">
                        ✓ Setujui &amp; Verifikasi Berkas
                      </button>
                    </form>
                    
                    <!-- Reject Toggle Button -->
                    <button type="button" onclick="toggleRejectionForm()" class="bg-[#ffdad6] text-[#ba1a1a] rounded-lg py-2.5 px-4 text-[14px] font-bold cursor-pointer border-none hover:bg-[#ffb4ab] transition-colors">
                      ✕ Tolak Berkas
                    </button>
                  </div>

                  <!-- Hidden Rejection Form Area -->
                  <div id="rejectionFormArea" class="hidden border border-[#ba1a1a] rounded-lg p-4 bg-[#ffdad6]/20 flex flex-col gap-3">
                    <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST" class="flex flex-col gap-3" style="margin: 0; padding: 0;">
                      @csrf
                      <input type="hidden" name="action" value="verifikasi_berkas">
                      <input type="hidden" name="status_verifikasi" value="ditolak">
                      
                      <div class="flex flex-col gap-1">
                        <label for="alasan_penolakan" class="text-[#ba1a1a] text-[12px] font-bold">Alasan Penolakan Berkas:</label>
                        <textarea name="alasan_penolakan" id="alasan_penolakan" required rows="3" placeholder="Contoh: File Akta Kelahiran buram / tidak terbaca." 
                                  class="w-full px-3 py-2 text-[13px] border border-[#ba1a1a]/50 rounded bg-white outline-none focus:border-[#ba1a1a] resize-none"></textarea>
                      </div>

                      <button type="submit" class="bg-[#ba1a1a] text-white rounded py-2 w-full text-[13px] font-bold cursor-pointer border-none hover:bg-[#93000a] transition-colors">
                        Kirim Penolakan
                      </button>
                    </form>
                  </div>
                </div>
              @endif

              @if($pendaftaran->status_verifikasi === 'ditolak')
                <div class="bg-[#ffdad6] border border-[#ba1a1a] rounded-lg p-4 text-[#ba1a1a] text-[13px]">
                  <strong>Berkas Ditolak:</strong> {{ $pendaftaran->alasan_penolakan ?? 'Tidak ada alasan penolakan yang dicantumkan.' }}
                </div>
              @endif
            </div>
          @endunless

          @if($step2Active)
            <!-- Verifikasi Offline: Admin Action Button -->
            <div style="background: #ffffff; border-radius: 12px; border: 1px solid #becabe; padding: 24px; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; gap: 15px; width: 100%;">
              <div style="font-weight: bold; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 16px; color: #064e3b; border-bottom: 2px solid #f0fdf4; padding-bottom: 8px;">
                📝 Verifikasi Berkas Fisik (Onsite)
              </div>
              <p style="font-size: 13px; color: #4b5563; line-height: 1.5; margin: 0;">
                Calon murid telah hadir di sekolah untuk pemeriksaan kelengkapan berkas fisik secara langsung.
              </p>
              
              <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST" style="margin: 0; padding: 0;">
                @csrf
                <input type="hidden" name="action" value="cek_berkas_onsite">
                <button type="submit" class="bg-[#005b31] text-white rounded-lg py-3 w-full text-[15px] font-bold cursor-pointer hover:bg-[#064e3b] transition-colors border-none" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                  ✓ Tandai Sudah Verifikasi Fisik
                </button>
              </form>
            </div>
          @endif

        </div>

        <!-- Right Column -->
        <div class="w-[380px] shrink-0 flex flex-col gap-6 max-[1100px]:w-full {{ $step2Active ? 'hidden' : '' }}">

          <!-- Program Choice Card -->
          <div class="bg-[#004228] rounded-xl p-6 flex flex-col gap-6 shadow-lg relative overflow-hidden">
            <svg class="absolute -bottom-8 -right-[31.67px] w-[146.667px] h-[120px] opacity-10 pointer-events-none" viewBox="0 0 146.667 120" fill="none"><path d="M133.333 93.3333V47.3333L73.3333 80L0 40L73.3333 0L146.667 40V93.3333H133.333V93.3333M73.3333 120L26.6667 94.6667V61.3333L73.3333 86.6667L120 61.3333V94.6667L73.3333 120V120" fill="white"/></svg>
            <div class="flex items-center gap-3 relative">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" class="shrink-0"><path d="M3 16V9H5V16H3V16M9 16V9H11V16H9V16M0 20V18H20V20H0V20M15 16V9H17V16H15V16M0 7V5L10 0L20 5V7H0V7M4.45 5H10H15.55H4.45V5M4.45 5H15.55L10 2.25L4.45 5V5" fill="white"/></svg>
              <span class="text-white text-[18px] font-semibold">Pilihan Program</span>
            </div>
            <div class="bg-[#005c39] rounded-lg px-4 pt-[17px] pb-4 flex flex-col gap-1 relative">
              <div class="text-[#86d2a6] text-[10px] font-bold uppercase opacity-80">Program Peminatan</div>
              <div class="text-white text-[20px] font-bold">{{ $pendaftaran->program->nama_program ?? '-' }}</div>
            </div>
          </div>

          <!-- Parent Contact Card -->
          <div class="bg-white border border-[#bfc9c0] rounded-xl p-6 flex flex-col gap-6">
            <div class="border-b border-[#bfc9c0] pb-4 flex items-center gap-3 text-[#004228] text-[18px] font-semibold">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5-4.13a4 4 0 100-8 4 4 0 000 8zm6 8v-2a4 4 0 00-3-3.87"/></svg>
              Data Orang Tua / Wali
            </div>

            <div class="flex gap-4 items-start">
              <div class="bg-[#ebeeed] rounded-lg size-12 flex items-center justify-center shrink-0 text-[#3f4941]">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 20c0-4 3.6-6 8-6s8 2 8 6"/></svg>
              </div>
              <div class="flex-1 min-w-0">
                <div class="text-[#6f7a71] text-[11px] font-bold uppercase">Nama Ayah</div>
                <div class="text-[#181c1c] text-[14px] font-semibold">{{ $student->ayah->nama_ayah ?? '-' }}</div>
                <div class="text-[#6f7a71] text-[14px] mt-1">Pekerjaan: {{ $student->ayah->pekerjaan ?? '-' }}</div>
              </div>
            </div>

            <div class="flex gap-4 items-start">
              <div class="bg-[#ebeeed] rounded-lg size-12 flex items-center justify-center shrink-0 text-[#3f4941]">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 20c0-4 3.6-6 8-6s8 2 8 6"/></svg>
              </div>
              <div class="flex-1 min-w-0">
                <div class="text-[#6f7a71] text-[11px] font-bold uppercase">Nama Ibu</div>
                <div class="text-[#181c1c] text-[14px] font-semibold">{{ $student->ibu->nama_ibu ?? '-' }}</div>
                <div class="text-[#6f7a71] text-[14px] mt-1">Pekerjaan: {{ $student->ibu->pekerjaan ?? '-' }}</div>
              </div>
            </div>

            <div class="border-t border-[#bfc9c0] pt-4 flex flex-col gap-1">
              <div class="text-[#6f7a71] text-[11px] font-bold uppercase">Nomor Telepon</div>
              <div class="text-[#181c1c] text-[14px] font-semibold">{{ $student->ibu->nomor_telpon ?? $student->ayah->nomor_telpon ?? '-' }}</div>
            </div>

            <div class="flex flex-col gap-1">
              <div class="text-[#6f7a71] text-[11px] font-bold uppercase">Email</div>
              <div class="text-[#181c1c] text-[14px] font-semibold">{{ $student->email ?? '-' }}</div>
            </div>

            @php
              $waRaw = preg_replace('/\D/', '', $student->ibu->nomor_telpon ?? $student->ayah->nomor_telpon ?? '');
              $waNumber = preg_replace('/^0/', '62', $waRaw);
            @endphp
            @if($waNumber)
              <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="bg-[#e6e9e8] rounded-lg py-2 flex items-center justify-center gap-2 text-[#004228] text-[16px] no-underline">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.44 1.32 4.94L2.05 22l5.29-1.39a9.9 9.9 0 004.7 1.2h.01c5.46 0 9.9-4.45 9.9-9.91C21.96 6.45 17.51 2 12.04 2zm0 18.06h-.01a8.2 8.2 0 01-4.19-1.15l-.3-.18-3.14.82.84-3.06-.2-.31a8.14 8.14 0 01-1.25-4.34c0-4.5 3.67-8.16 8.19-8.16 2.19 0 4.24.85 5.79 2.4a8.1 8.1 0 012.4 5.77c0 4.5-3.67 8.21-8.13 8.21zm4.48-6.14c-.24-.12-1.44-.71-1.66-.79-.22-.08-.39-.12-.55.12-.16.24-.63.79-.78.95-.14.16-.29.18-.53.06-.24-.12-1.02-.38-1.94-1.2-.72-.64-1.2-1.43-1.35-1.67-.14-.24-.02-.37.11-.49.11-.11.24-.29.36-.43.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.55-1.32-.75-1.81-.2-.48-.4-.41-.55-.42-.14-.01-.3-.01-.46-.01-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.7 2.6 4.12 3.64.58.25 1.03.4 1.38.51.58.18 1.11.16 1.53.1.47-.07 1.44-.59 1.64-1.16.2-.57.2-1.06.14-1.16-.06-.1-.22-.16-.46-.28z"/></svg>
                Hubungi via WhatsApp
              </a>
            @endif
          </div>
        </div>
      </div>

      @if($step4Active)
        <!-- Action Footer -->
        <div class="bg-[#e6e9e8] border border-[#bfc9c0] rounded-xl p-6 flex items-center justify-between gap-4 max-[700px]:flex-col">
          <div class="flex items-center gap-4 text-[#3f4942] text-[14px]">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="shrink-0"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01"/></svg>
            <div>Laporan ini dibuat secara otomatis oleh <strong>Pusat Evaluasi Terpadu</strong>. Perubahan data harus seizin Panitia Inti Seleksi.</div>
          </div>
          <div class="flex gap-4 shrink-0">
            <button type="button" onclick="window.print()" class="border border-[#004228] text-[#004228] rounded-lg px-6 py-3 text-[16px] font-bold cursor-pointer bg-white">Cetak Laporan</button>
            <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST">
              @csrf
              <input type="hidden" name="action" value="konfirmasi_onsite">
              <input type="hidden" name="status_konfirmasi" value="terkonfirmasi">
              <button type="submit" class="bg-[#004228] text-white rounded-lg px-6 py-3 text-[16px] font-bold cursor-pointer shadow-lg">Verifikasi Daftar Ulang →</button>
            </form>
          </div>
        </div>
      @endif

      @if($step3Active)
        @php
          $hasil = $student->hasil;
          $dssRecommendation = $hasil ? \App\Services\DssService::getRecommendation($pendaftaran) : null;
        @endphp
        <!-- Student Card + Rekomendasi Akhir -->
        <div class="grid grid-cols-3 gap-6 max-[900px]:grid-cols-1">
          <div class="col-span-2 bg-white border border-black/5 shadow-sm rounded-xl p-6 flex gap-8 items-center max-[900px]:flex-col">
            <div class="relative shrink-0">
              <div class="bg-[#c4c4c4] border-4 border-[#ebeeed] rounded-2xl shadow-lg size-32 flex items-center justify-center overflow-hidden">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 20c0-4 3.6-6 8-6s8 2 8 6"/></svg>
              </div>
              <div class="absolute -bottom-3 right-2 bg-[#004228] text-white text-[10px] font-bold uppercase tracking-wide px-2 py-1 rounded-full whitespace-nowrap">
                REG: #{{ str_pad($pendaftaran->id_pendaftaran, 8, '0', STR_PAD_LEFT) }}
              </div>
            </div>
            <div class="flex-1 flex flex-col gap-2 min-w-0">
              <span class="bg-[#93f4b0] text-[#00723d] text-[10px] font-bold uppercase px-3 py-1 rounded-full w-fit">Calon Siswa Baru</span>
              <div class="text-[#004228] text-[28px] font-bold tracking-tight">{{ $student->nama_murid }}</div>
              <div class="grid grid-cols-2 gap-x-8 gap-y-1 text-[14px]">
                <div><span class="font-semibold text-[#181c1c]">NISN:</span> <span class="text-[#3f4942]">{{ $student->nisn }}</span></div>
                <div><span class="font-semibold text-[#181c1c]">Tempat Lahir:</span> <span class="text-[#3f4942]">{{ $student->tempat_lahir }}</span></div>
                <div><span class="font-semibold text-[#181c1c]">Tgl Lahir:</span> <span class="text-[#3f4942]">{{ date('d M Y', strtotime($student->tanggal_lahir)) }}</span></div>
                <div><span class="font-semibold text-[#181c1c]">Pilihan:</span> <span class="text-[#3f4942]">{{ $pendaftaran->program->nama_program ?? '-' }}</span></div>
              </div>
            </div>
          </div>

          <div class="bg-[#004228] rounded-xl p-6 flex flex-col gap-4 shadow-lg">
            <div class="flex items-center justify-between">
              <span class="text-white/80 text-[18px] font-semibold">Rekomendasi Akhir</span>
              <svg width="16" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
              @if($pendaftaran->nilaiUjian)
                <div class="text-[#7ada99] text-[30px] font-bold">{{ $pendaftaran->dssRanking->rekomendasi ?? 'Dalam Proses' }}</div>
                <div class="text-white/70 text-[14px]">Skor Akumulasi: {{ number_format($pendaftaran->dssRanking->nilai_total ?? 0, 1) }} / 100</div>
              @else
                <div class="text-[#7ada99] text-[20px] font-bold">Menunggu Penilaian</div>
                <div class="text-white/70 text-[14px]">Nilai belum diinput oleh panitia.</div>
              @endif
            </div>
          </div>
        </div>

        @if($pendaftaran->nilaiUjian)
          <!-- Detailed Scores -->
          <div class="grid grid-cols-3 gap-6 max-[900px]:grid-cols-2 max-[600px]:grid-cols-1" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
            @php
              $nilai = $pendaftaran->nilaiUjian;
              $scores = [
                ['label' => 'Hafalan', 'value' => $nilai->nilai_hafalan ?? 0],
                ['label' => 'AISM', 'value' => $nilai->nilai_aism ?? 0],
                ['label' => 'Iqro', 'value' => $nilai->nilai_iqro ?? 0],
                ['label' => 'Calistung', 'value' => $nilai->nilai_calistung ?? 0],
                ['label' => 'Dikte', 'value' => $nilai->nilai_dikte ?? 0],
                ['label' => 'Kemandirian', 'value' => $nilai->nilai_kemandirian ?? 0],
              ];
            @endphp
            @foreach($scores as $score)
              <div class="bg-white border border-black/5 shadow-sm rounded-xl p-6 flex flex-col gap-1">
                <div class="bg-[#93f4b0]/30 rounded-lg size-10 flex items-center justify-center text-[#004228]">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5-2v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V8l8-4 8 4z"/></svg>
                </div>
                <div class="text-[#3f4942] text-[12px] font-semibold uppercase tracking-wide pt-3">{{ $score['label'] }}</div>
                <div class="flex items-baseline gap-1 pb-3">
                  <span class="text-[#004228] text-[30px] font-bold">{{ $score['value'] }}</span>
                  <span class="text-[#3f4942] text-[14px]">/ 100</span>
                </div>
                <div class="bg-[#ebeeed] h-1.5 rounded-full w-full overflow-hidden">
                  <div class="bg-[#006d3a] h-full rounded-full" style="width: {{ min(100, $score['value']) }}%"></div>
                </div>
              </div>
            @endforeach
          </div>

          <!-- Interview Summaries -->
          <div class="grid grid-cols-2 gap-6 max-[900px]:grid-cols-1">
            <div class="bg-white border border-black/5 shadow-sm rounded-xl p-6 flex flex-col gap-4">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-[#004228] text-[18px] font-semibold">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.97-4.03 9-9 9a9 9 0 01-4-.93L3 21l1.07-3.2A8.96 8.96 0 013 12c0-4.97 4.03-9 9-9s9 4.03 9 9z"/></svg>
                  Ringkasan Wawancara
                </div>
                <span class="text-[#3f4942] text-[12px] italic">{{ $hasil->created_at->format('d M Y') }}</span>
              </div>
              <div class="bg-[#f1f4f3] rounded-xl p-4 flex flex-col gap-1">
                <div class="text-[#004228] text-[12px] font-bold uppercase tracking-wide">Catatan Observasi</div>
                <div class="text-[#181c1c] text-[14px] italic">{{ $hasil->catatan ?? 'Belum ada catatan observasi dari panitia.' }}</div>
              </div>
            </div>

            <div class="bg-white border border-black/5 shadow-sm rounded-xl p-6 flex flex-col gap-4">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-[#004228] text-[18px] font-semibold">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5-4.13a4 4 0 100-8 4 4 0 000 8zm6 8v-2a4 4 0 00-3-3.87"/></svg>
                  Wawancara Orang Tua
                </div>
                <span class="text-[#3f4942] text-[12px] italic">Status: Selesai</span>
              </div>
              <div class="flex gap-4 max-[600px]:flex-col">
                <div class="flex-1 border border-[#bfc9c0] rounded-xl p-4">
                  <div class="text-[#3f4942] text-[10px] font-bold uppercase">Rating Dukungan Ortu</div>
                  <div class="text-[#181c1c] text-[14px] font-medium">{{ $hasil->rating_ortu }} / 10</div>
                </div>
              </div>
              @if($hasil->catatan_manual || $hasil->catatan_otomatis)
                <div class="bg-[#f1f4f3] border border-[#bfc9c0] rounded-xl p-4 flex flex-col gap-2">
                  <div class="text-[#004228] text-[12px] font-bold">Catatan Administratif:</div>
                  <div class="text-[#3f4942] text-[14px]">{{ $hasil->catatan_manual ?? $hasil->catatan_otomatis }}</div>
                </div>
              @endif
            </div>
          </div>
        @endif

        <!-- Action Footer -->
        <div class="bg-[#e6e9e8] border border-[#bfc9c0] rounded-xl p-6 flex items-center justify-between gap-4 max-[700px]:flex-col">
          <div class="flex items-center gap-4 text-[#3f4942] text-[14px]">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="shrink-0"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01"/></svg>
            <div>Laporan ini dibuat secara otomatis oleh <strong>Pusat Evaluasi Terpadu</strong>. Perubahan data harus seizin Panitia Inti Seleksi.</div>
          </div>
          <div class="flex gap-4 shrink-0">
            <button type="button" onclick="window.print()" class="border border-[#004228] text-[#004228] rounded-lg px-6 py-3 text-[16px] font-bold cursor-pointer bg-white">Cetak Laporan</button>
            @if($hasil && !$step3Completed)
              <form action="{{ route('tata_usaha.status', $pendaftaran->id_pendaftaran) }}" method="POST">
                @csrf
                <input type="hidden" name="action" value="penetapan_kelulusan">
                <input type="hidden" name="status_kelulusan" value="lulus">
                <button type="submit" class="bg-[#004228] text-white rounded-lg px-6 py-3 text-[16px] font-bold cursor-pointer shadow-lg">Lanjut ke Daftar Ulang →</button>
              </form>
            @endif
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    function toggleRejectionForm() {
      const area = document.getElementById('rejectionFormArea');
      if (area.classList.contains('hidden')) {
        area.classList.remove('hidden');
        area.scrollIntoView({ behavior: 'smooth' });
      } else {
        area.classList.add('hidden');
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
