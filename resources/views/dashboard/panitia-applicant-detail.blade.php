@extends('layouts.panitia')

@section('title', 'Detail Calon Murid - Penguji PMBM')

@section('styles')
  <style>
    @media print {
      aside, nav, button, a, #adminSidebarToggle, .admin-sidebar-backdrop, .admin-sidebar-panel, form, #document-viewer-container, .bg-[#d9e6da], .bg-[#004228] {
        display: none !important;
      }
      .relative, .absolute {
        position: static !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        left: 0 !important;
        top: 0 !important;
      }
      body {
        background: white !important;
        color: black !important;
      }
      .bg-white, .bg-[#f1f4f3] {
        background: transparent !important;
        border-color: #ccc !important;
        box-shadow: none !important;
      }
    }
  </style>
@endsection

@section('content')
  <div class="relative min-h-screen bg-slate-50/50 antialiased">
    <!-- Panitia Sidebar Included -->
    @include('components.sidebar-panitia', ['activeFolder' => 'result'])

    <!-- Main Content Container with responsive padding and layout alignment -->
    <div class="relative pt-[140px] px-6 md:px-12 lg:px-16 xl:pr-10 xl:pl-[280px] flex flex-col gap-6 pb-12">

      <!-- Back Button Link -->
      <a href="{{ route('panitia.hasil-nilai') }}" class="flex items-center gap-2 text-[#3f4941] text-[15px] no-underline w-fit hover:underline font-bold print:hidden" style="font-family: 'Manrope-Bold', sans-serif;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m0 0l6 6m-6-6l6-6"/></svg>
        Kembali ke Halaman Rekap Penilaian
      </a>

      <!-- Page Header -->
      <div class="flex flex-col gap-1">
        <div class="text-[#181c1c] text-[28px] font-bold tracking-[-0.56px]" style="font-family: 'Manrope-Bold', sans-serif;">Detail Calon Murid: {{ $student->nama_murid }}</div>
        <div class="text-[#3f4941] text-[14px]">Informasi lengkap dan rekapitulasi penilaian calon siswa baru MIN 3 Karanganyar.</div>
      </div>

      <!-- Breadcrumb & Reg Number -->
      <div class="flex items-center justify-between flex-wrap gap-3">
        <div class="flex items-center gap-3">
          <div class="text-[#004228] text-[22px] font-semibold">Profil Registrasi</div>
          <span class="bg-[#93f4b0] text-[#00723d] text-[12px] font-bold px-3 py-1 rounded-full">PMBM-2026-{{ str_pad($pendaftaran->id_pendaftaran, 4, '0', STR_PAD_LEFT) }}</span>
          @php
            $statusLabel = $pendaftaran->status_label;
            $badgeBg = 'bg-slate-100 border-slate-200 text-slate-700';
            if ($pendaftaran->status_kelulusan === 'lulus') {
                $badgeBg = 'bg-green-100 border-green-200 text-green-800';
            } elseif ($pendaftaran->status_kelulusan === 'cadangan') {
                $badgeBg = 'bg-amber-100 border-amber-200 text-amber-800';
            } elseif ($pendaftaran->status_kelulusan === 'tidak_lulus') {
                $badgeBg = 'bg-red-100 border-red-200 text-red-800';
            } elseif ($pendaftaran->status_verifikasi === 'terverifikasi_onsite') {
                $badgeBg = 'bg-blue-100 border-blue-200 text-blue-800';
            } elseif ($pendaftaran->status_verifikasi === 'terverifikasi') {
                $badgeBg = 'bg-sky-100 border-sky-200 text-sky-800';
            } elseif ($pendaftaran->status_verifikasi === 'ditolak') {
                $badgeBg = 'bg-red-100 border-red-200 text-red-800';
            }
          @endphp
          <span class="{{ $badgeBg }} text-[12px] font-bold px-3 py-1 rounded-full border">
            Status: {{ $statusLabel }}
          </span>
        </div>
        <div class="flex gap-3 print:hidden">
          <button type="button" onclick="window.print()" class="border border-[#6f7a71] rounded-lg px-4 py-2 flex items-center gap-2 text-[#004228] text-[14px] cursor-pointer bg-white">
            <svg width="15" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v8H6v-8z"/></svg>
            Cetak Formulir
          </button>
        </div>
      </div>

      <!-- Two Column Layout -->
      <div class="flex gap-6 items-start max-[1100px]:flex-col">
        <!-- Left Column -->
        <div class="flex-1 flex flex-col gap-6 min-w-0 w-full">

          <!-- Identity Card -->
          <div class="bg-white border border-[#bfc9c0] rounded-xl p-6 flex flex-col gap-4">
            <div class="border-b border-[#bfc9c0] pb-4 flex items-center gap-3 text-[#004228] text-[18px] font-semibold">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 20c0-4 3.6-6 8-6s8 2 8 6"/></svg>
              {{ $pendaftaran->status_kelulusan === 'lulus' ? 'Identitas Siswa Baru' : 'Identitas Calon Siswa' }}
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
                <div class="text-[#6f7a71] text-[11px] font-bold tracking-wide uppercase">NIK</div>
                <div class="text-[#181c1c] text-[16px] font-semibold">{{ $student->nik ?? '-' }}</div>
              </div>
              <div class="flex flex-col gap-1 col-span-2">
                <div class="text-[#6f7a71] text-[11px] font-bold tracking-wide uppercase">Alamat Domisili</div>
                <div class="text-[#181c1c] text-[16px] font-semibold">{{ $student->alamat }}</div>
              </div>
            </div>
          </div>

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
                    <button type="button" onclick="previewDoc('{{ route('document.preview', ['type' => $doc['type'], 'filename' => basename($doc['value'])]) }}')" class="text-[#004228] text-[14px] font-bold cursor-pointer print:hidden">Lihat</button>
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
            <div id="document-viewer-container" class="border border-gray-200 rounded-xl h-[200px] flex items-center justify-center bg-gray-50 text-gray-500 text-[13px] font-medium overflow-hidden relative transition-[height] duration-300 print:hidden">
              <div class="text-center p-5">
                <svg class="mx-auto mb-2" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
                Pilih dokumen di atas untuk melihat tampilan berkas secara langsung
              </div>
            </div>
          </div>

        </div>

        <!-- Right Column -->
        <div class="w-[380px] shrink-0 flex flex-col gap-6 max-[1100px]:w-full">

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
              <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="bg-[#e6e9e8] rounded-lg py-2 flex items-center justify-center gap-2 text-[#004228] text-[16px] no-underline print:hidden">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.44 1.32 4.94L2.05 22l5.29-1.39a9.9 9.9 0 004.7 1.2h.01c5.46 0 9.9-4.45 9.9-9.91C21.96 6.45 17.51 2 12.04 2zm0 18.06h-.01a8.2 8.2 0 01-4.19-1.15l-.3-.18-3.14.82.84-3.06-.2-.31a8.14 8.14 0 01-1.25-4.34c0-4.5 3.67-8.16 8.19-8.16 2.19 0 4.24.85 5.79 2.4a8.1 8.1 0 012.4 5.77c0 4.5-3.67 8.21-8.13 8.21zm4.48-6.14c-.24-.12-1.44-.71-1.66-.79-.22-.08-.39-.12-.55.12-.16.24-.63.79-.78.95-.14.16-.29.18-.53.06-.24-.12-1.02-.38-1.94-1.2-.72-.64-1.2-1.43-1.35-1.67-.14-.24-.02-.37.11-.49.11-.11.24-.29.36-.43.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.55-1.32-.75-1.81-.2-.48-.4-.41-.55-.42-.14-.01-.3-.01-.46-.01-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.7 2.6 4.12 3.64.58.25 1.03.4 1.38.51.58.18 1.11.16 1.53.1.47-.07 1.44-.59 1.64-1.16.2-.57.2-1.06.14-1.16-.06-.1-.22-.16-.46-.28z"/></svg>
                Hubungi via WhatsApp
              </a>
            @endif
          </div>
        </div>
      </div>

      <!-- Detailed Scores & Interviews (Always visible if exists) -->
      @if($pendaftaran->nilaiUjian)
        @php
          $hasil = $student->hasil;
          $dssRecommendation = $hasil ? \App\Services\DssService::getRecommendation($pendaftaran) : null;
        @endphp
        
        <!-- Student Card + Rekomendasi Akhir -->
        <div class="grid grid-cols-3 gap-6 max-[900px]:grid-cols-1 mt-6">
          <div class="col-span-2 bg-white border border-[#bfc9c0] shadow-sm rounded-xl p-6 flex gap-8 items-center max-[900px]:flex-col">
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

          <div class="bg-[#004228] rounded-xl p-6 flex flex-col gap-4 shadow-lg justify-between">
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

        <!-- Detailed Scores -->
        <div class="grid grid-cols-3 gap-6 max-[900px]:grid-cols-2 max-[600px]:grid-cols-1 mt-6" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
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
            <div class="bg-white border border-[#bec9be] shadow-sm rounded-2xl p-6 flex flex-col justify-between gap-3">
              <div class="flex items-center justify-between">
                <div class="bg-[#e8f5e9] border border-[#c8e6c9] rounded-xl w-10 h-10 flex items-center justify-center text-[#006a3c]">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5-2v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V8l8-4 8 4z"/></svg>
                </div>
              </div>
              <div class="text-[#3f4942] text-[11px] font-bold uppercase tracking-wider">{{ $score['label'] }}</div>
              <div class="flex items-baseline gap-1">
                <span class="text-[#181c1c] text-[28px] font-bold" style="font-family: 'Manrope-Bold', sans-serif;">{{ $score['value'] }}</span>
                <span class="text-[#6f7a71] text-[14px]">/ 100</span>
              </div>
              <div class="bg-[#ebeeed] h-2 rounded-full w-full overflow-hidden mt-1">
                <div class="bg-[#006a3c] h-full rounded-full" style="width: {{ min(100, max(0, $score['value'])) }}%"></div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Interview Summaries -->
        @if($pendaftaran->wawancaraOrtu || $pendaftaran->wawancaraAnak)
          <div class="grid grid-cols-2 gap-6 max-[900px]:grid-cols-1 mt-6" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
            <!-- Wawancara & Observasi Anak -->
            <div class="bg-white border border-[#bec9be] shadow-sm rounded-xl p-6 flex flex-col gap-4">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-[#004228] text-[18px] font-semibold">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.97-4.03 9-9 9a9 9 0 01-4-.93L3 21l1.07-3.2A8.96 8.96 0 013 12c0-4.97 4.03-9 9-9s9 4.03 9 9z"/></svg>
                  Wawancara &amp; Observasi Anak
                </div>
                <span class="text-[#3f4942] text-[12px] italic">
                  {{ $pendaftaran->wawancaraAnak ? $pendaftaran->wawancaraAnak->created_at->format('d M Y') : 'Terdata' }}
                </span>
              </div>
              <div class="bg-[#f1f4f3] rounded-xl p-4 flex flex-col gap-2.5">
                <div class="text-[#004228] text-[12px] font-bold uppercase tracking-wide">Status Evaluasi &amp; Catatan Khusus Anak</div>
                @php
                  $wan = $pendaftaran->wawancaraAnak;
                  $hasNotes = $wan && ($wan->wawancara_irqa || $wan->wawancara_aism || $wan->wawancara_calistung || $wan->wawancara_dikte || $wan->wawancara_kemandirian || $wan->rekap_wawancara);
                @endphp
                @if($hasNotes)
                  <div class="flex flex-col gap-1.5 text-[13px] text-[#181c1c]">
                    @if($wan->rekap_wawancara)
                      <div class="font-medium text-slate-800 italic">"{{ $wan->rekap_wawancara }}"</div>
                    @endif
                    @if($wan->wawancara_irqa)
                      <div><strong class="text-[#004228]">Catatan Hafalan &amp; Iqro:</strong> {{ $wan->wawancara_irqa }}</div>
                    @endif
                    @if($wan->wawancara_aism)
                      <div><strong class="text-[#004228]">Catatan AISM:</strong> {{ $wan->wawancara_aism }}</div>
                    @endif
                    @if($wan->wawancara_calistung)
                      <div><strong class="text-[#004228]">Catatan Calistung:</strong> {{ $wan->wawancara_calistung }}</div>
                    @endif
                    @if($wan->wawancara_dikte)
                      <div><strong class="text-[#004228]">Catatan Dikte:</strong> {{ $wan->wawancara_dikte }}</div>
                    @endif
                    @if($wan->wawancara_kemandirian)
                      <div><strong class="text-[#004228]">Catatan Kemandirian:</strong> {{ $wan->wawancara_kemandirian }}</div>
                    @endif
                  </div>
                @else
                  <div class="text-[#181c1c] text-[14px]">
                    Observasi dan evaluasi 6 instrumen kemampuan anak telah selesai diuji &amp; terdata oleh Panitia Penguji PMBM.
                  </div>
                @endif
              </div>
            </div>

            <!-- Catatan Wawancara Orang Tua -->
            <div class="bg-white border border-[#bfc9c0] rounded-xl p-6 flex flex-col gap-4 shadow-sm">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-[#004228] text-[18px] font-semibold">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5-4.13a4 4 0 100-8 4 4 0 000 8zm6 8v-2a4 4 0 00-3-3.87"/></svg>
                  Catatan Wawancara Orang Tua
                </div>
                <span class="text-[#3f4942] text-[12px] italic">
                  {{ $pendaftaran->wawancaraOrtu ? $pendaftaran->wawancaraOrtu->created_at->format('d M Y') : '-' }}
                </span>
              </div>
              <div class="bg-[#f1f4f3] border border-[#bfc9c0] rounded-xl p-4 flex flex-col gap-3">
                <div class="text-[#004228] text-[13px] font-bold border-b border-[#bfc9c0] pb-2">Indeks Penilaian Orang Tua:</div>
                <div class="flex flex-col gap-1.5 text-[13px] text-[#181c1c] pb-2 border-b border-[#bfc9c0]">
                  <div><strong class="text-[#004228]">Komitmen Orang Tua:</strong> {{ ucfirst($pendaftaran->wawancaraOrtu->komitmen_ortu_status ?? 'Belum diisi') }}</div>
                  <div><strong class="text-[#004228]">Dukungan Fasilitas:</strong> {{ ucfirst($pendaftaran->wawancaraOrtu->dukungan_fasilitas_status ?? 'Belum diisi') }}</div>
                  <div><strong class="text-[#004228]">Visi Misi Keluarga:</strong> {{ ucfirst($pendaftaran->wawancaraOrtu->visi_misi_status ?? 'Belum diisi') }}</div>
                </div>
                <div class="text-[#004228] text-[12px] font-bold">Catatan Khusus Orang Tua:</div>
                <div class="text-[#181c1c] text-[14px] leading-relaxed font-medium">
                  {{ $pendaftaran->wawancaraOrtu->komitmen_ortu ?? 'Belum ada catatan komitmen dari orang tua.' }}
                </div>
              </div>
            </div>
          </div>
        @else
          <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 text-amber-700 text-center text-[14px] mt-6">
            ⚠️ Data wawancara dan observasi belum diinput oleh panitia.
          </div>
        @endif

        <!-- Action Footer -->
        <div class="bg-[#e6e9e8] border border-[#bfc9c0] rounded-xl p-6 flex items-center justify-between gap-4 max-[700px]:flex-col mt-6 w-full">
          <div class="flex items-center gap-4 text-[#3f4942] text-[14px]">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="shrink-0"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01"/></svg>
            <div>Laporan ini dibuat secara otomatis oleh <strong>Pusat Evaluasi Terpadu</strong>. Perubahan data harus seizin Panitia Inti Seleksi.</div>
          </div>
          <div class="flex gap-4 shrink-0">
            <button type="button" onclick="window.print()" class="border border-[#004228] text-[#004228] rounded-lg px-6 py-3 text-[16px] font-bold cursor-pointer bg-white">Cetak Laporan</button>
          </div>
        </div>
      @else
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 text-amber-700 text-center text-[14px] mt-6 w-full">
          ⚠️ Hasil wawancara dan nilai ujian observasi belum diinput oleh panitia.
        </div>
      @endif

    </div>
  </div>
@endsection

@section('scripts')
  <script>
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
