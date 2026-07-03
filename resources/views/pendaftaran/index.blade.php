@extends('layouts.admin')

@section('title', 'Daftar PMBM - Admin Portal')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/admin/applicants/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/applicants/style.css') }}">
@endsection

@section('content')
  <div class="relative min-h-screen flow-root">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'applicants'])

    <!-- Content Wrapper -->
    <div class="absolute left-[340px] top-[138px] right-10 flex flex-col gap-6 z-10 max-[1024px]:left-5 max-[1024px]:right-5 max-[1024px]:top-[240px]">

      <!-- Section Header Description -->
      <div class="flex flex-col gap-1">
        <div class="text-[#121c2a] text-[26px] font-bold" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Daftar PMBM</div>
        <div class="text-[#3f4940] text-[14px]" style="font-family: 'WorkSans-Regular', sans-serif;">
          Kelola dan pantau seluruh pendaftar calon siswa baru
          <br class="max-[640px]:hidden">
          MIN 3 Karanganyar periode aktif.
        </div>
      </div>

      <!-- Filters Section -->
      <form action="{{ route('scores.index') }}" method="GET" class="flex flex-row gap-4 items-stretch max-[768px]:flex-wrap">
        <div class="flex-1 min-w-[150px] bg-[#eff4ff] border border-[#becabe] rounded-xl p-4 flex flex-col gap-2">
          <label class="text-[#3f4940] text-[12px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">TAHUN PENDAFTARAN</label>
          <select name="tahun" onchange="this.form.submit()" class="w-full text-[12px] font-bold text-gray-700 border border-gray-300 rounded-lg bg-white px-4 py-2.5 cursor-pointer outline-none focus:border-[#298752]">
            <option value="2026" {{ request('tahun') == '2026' ? 'selected' : '' }}>2026 / 2027</option>
            <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025 / 2026</option>
          </select>
        </div>

        <div class="flex-1 min-w-[150px] bg-[#eff4ff] border border-[#becabe] rounded-xl p-4 flex flex-col gap-2">
          <label class="text-[#3f4940] text-[12px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">PROGRAM / JALUR</label>
          <select name="program" onchange="this.form.submit()" class="w-full text-[12px] font-bold text-gray-700 border border-gray-300 rounded-lg bg-white px-4 py-2.5 cursor-pointer outline-none focus:border-[#298752]">
            <option value="">Semua Program</option>
            @foreach($programs as $prog)
              <option value="{{ $prog->id_program }}" {{ request('program') == $prog->id_program ? 'selected' : '' }}>
                {{ $prog->nama_program }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="flex-1 min-w-[150px] bg-[#eff4ff] border border-[#becabe] rounded-xl p-4 flex flex-col gap-2">
          <label class="text-[#3f4940] text-[12px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">STATUS</label>
          <select name="status" onchange="this.form.submit()" class="w-full text-[12px] font-bold text-gray-700 border border-gray-300 rounded-lg bg-white px-4 py-2.5 cursor-pointer outline-none focus:border-[#298752]">
            <option value="">Semua Status</option>
            <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Baru / Menunggu Verifikasi</option>
            <option value="terverifikasi" {{ request('status') == 'terverifikasi' ? 'selected' : '' }}>Berkas Diterima</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Berkas Ditolak</option>
            <option value="terverifikasi_onsite" {{ request('status') == 'terverifikasi_onsite' ? 'selected' : '' }}>Berkas Onsite Diterima</option>
            <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
            <option value="tidak_lulus" {{ request('status') == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
            <option value="cadangan" {{ request('status') == 'cadangan' ? 'selected' : '' }}>Cadangan</option>
            <option value="terkonfirmasi" {{ request('status') == 'terkonfirmasi' ? 'selected' : '' }}>Diterima (Daftar Ulang)</option>
            <option value="mengundurkan_diri" {{ request('status') == 'mengundurkan_diri' ? 'selected' : '' }}>Mengundurkan Diri</option>
          </select>
        </div>

        <div class="flex-1 min-w-[150px] bg-[#eff4ff] border border-[#becabe] rounded-xl p-4 flex flex-col gap-2">
          <label class="text-[#3f4940] text-[12px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">BATAS TAMPILAN</label>
          <select name="limit" onchange="this.form.submit()" class="w-full text-[12px] font-bold text-gray-700 border border-gray-300 rounded-lg bg-white px-4 py-2.5 cursor-pointer outline-none focus:border-[#298752]">
            <option value="5" {{ (isset($limit) && $limit == 5) ? 'selected' : '' }}>5 Data</option>
            <option value="10" {{ (isset($limit) && $limit == 10) ? 'selected' : '' }}>10 Data</option>
            <option value="20" {{ (isset($limit) && $limit == 20) ? 'selected' : '' }}>20 Data</option>
            <option value="30" {{ (isset($limit) && $limit == 30) ? 'selected' : '' }}>30 Data</option>
          </select>
        </div>
      </form>

      <!-- Header List Toolbar -->
      <div class="flex flex-row justify-between items-center max-[640px]:flex-col max-[640px]:items-start max-[640px]:gap-3">
        <div class="text-[#121c2a] text-[20px] font-semibold" style="font-family: 'PlusJakartaSans-SemiBold', sans-serif;">Recent Applicants</div>
        <div class="flex flex-row gap-2">
          <button type="button" onclick="alert('Eksport data dalam proses pengembangan')" class="bg-[#e6eeff] border border-[#becabe] rounded-lg px-4 py-2 flex items-center gap-2 cursor-pointer">
            <img class="w-4 h-4" src="{{ asset('assets/admin/applicants/container11.svg') }}" />
            <span class="text-[#3f4940] text-[14px] font-semibold tracking-[0.7px]">Export PDF</span>
          </button>
          <button type="button" onclick="alert('Eksport data dalam proses pengembangan')" class="bg-[#e6eeff] border border-[#becabe] rounded-lg px-4 py-2 flex items-center gap-2 cursor-pointer">
            <img class="w-4 h-4" src="{{ asset('assets/admin/applicants/container12.svg') }}" />
            <span class="text-[#3f4940] text-[14px] font-semibold tracking-[0.7px]">Export Excel</span>
          </button>
        </div>
      </div>

      <!-- Applicants List -->
      <div class="flex flex-col gap-4 min-h-[400px]">
        @forelse($pendaftarans as $item)
          <div class="relative bg-white border border-gray-200 rounded-xl shadow-[0_1px_3px_rgba(0,0,0,0.05)] transition-colors hover:border-[#7ed99c] flex flex-row max-[768px]:flex-col">
            <!-- Program Info -->
            <div class="w-[180px] shrink-0 border-r border-gray-200 flex flex-col justify-center px-5 py-4 max-[768px]:w-full max-[768px]:border-r-0 max-[768px]:border-b">
              <div class="text-gray-500 text-[9px] font-bold tracking-[0.5px] uppercase mb-1">PROGRAM</div>
              <div class="text-[12px] font-bold text-gray-900">{{ $item->program->nama_program }}</div>
            </div>

            <!-- Details -->
            <div class="flex-1 flex flex-row items-center justify-between gap-4 px-5 py-4 flex-wrap max-[768px]:flex-col max-[768px]:items-start max-[768px]:gap-3">
              <!-- Avatar & Name -->
              <div class="flex items-center gap-3 w-[220px] max-[768px]:w-full">
                <div class="bg-[#298752] text-white w-11 h-11 rounded-full flex items-center justify-center font-bold text-[16px] shrink-0">
                  {{ strtoupper(substr($item->calonMurid->nama_murid, 0, 2)) }}
                </div>
                <div class="flex flex-col justify-center overflow-hidden">
                  <div class="text-[14px] font-bold text-gray-900 text-ellipsis overflow-hidden whitespace-nowrap">{{ $item->calonMurid->nama_murid }}</div>
                  <div class="text-[11px] text-gray-500 mt-0.5">No Reg: PMB-2026-{{ str_pad($item->id_pendaftaran, 3, '0', STR_PAD_LEFT) }}</div>
                </div>
              </div>

              <!-- Phone -->
              <div class="text-[13px] text-gray-700 font-medium min-w-[120px]">
                {{ $item->calonMurid->ibu->nomor_telpon ?? 'No Telpon' }}
              </div>

              <!-- Email -->
              <div class="text-[13px] text-gray-500 min-w-[180px] max-w-[220px] text-ellipsis overflow-hidden whitespace-nowrap">
                {{ $item->calonMurid->email }}
              </div>

              <!-- Status Badge -->
              @php
                $badgeBg = '#fffbeb';
                $badgeBorder = '#fde68a';
                $badgeText = '#d97706';

                if (in_array($item->status_label, ['Lulus', 'Diterima (Daftar Ulang)', 'Berkas Diterima', 'Berkas Onsite Diterima'])) {
                    $badgeBg = '#ecfdf5';
                    $badgeBorder = '#a7f3d0';
                    $badgeText = '#047857';
                } elseif ($item->status_label === 'Siap Seleksi') {
                    $badgeBg = '#eff6ff';
                    $badgeBorder = '#bfdbfe';
                    $badgeText = '#1d4ed8';
                } elseif (in_array($item->status_label, ['Tidak Lulus', 'Berkas Ditolak', 'Mengundurkan Diri'])) {
                    $badgeBg = '#fef2f2';
                    $badgeBorder = '#fca5a5';
                    $badgeText = '#b91c1c';
                } elseif ($item->status_label === 'Cadangan') {
                    $badgeBg = '#fff7ed';
                    $badgeBorder = '#ffedd5';
                    $badgeText = '#c2410c';
                }
              @endphp
              <div class="rounded-full px-3 py-1.5 flex items-center justify-center min-w-[120px] h-7 shrink-0" style="background: {{ $badgeBg }}; border: 1px solid {{ $badgeBorder }};">
                <div class="text-[9px] font-extrabold tracking-[0.5px] uppercase text-center" style="color: {{ $badgeText }};">
                  {{ strtoupper($item->status_label) }}
                </div>
              </div>

              <!-- Detail Button -->
              <a href="{{ route('tata_usaha.detail', $item->id_pendaftaran) }}" class="flex items-center justify-center no-underline w-[70px] h-8 bg-[#298752] rounded-md transition-colors hover:bg-[#064e3b]">
                <span class="text-[11px] font-bold text-white">Detail</span>
              </a>
            </div>
          </div>
        @empty
          <div class="text-center text-gray-500 py-10 text-[14px]">
            Tidak ada calon pendaftar yang cocok dengan filter yang dipilih.
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      <div class="flex flex-col items-center gap-4 py-6">
        <div class="text-[16px]">
          <span class="text-[#3f4940]">Showing</span>
          <span class="text-[#121c2a] font-semibold">1 to {{ count($pendaftarans) }}</span>
          <span class="text-[#3f4940]">of</span>
          <span class="text-[#121c2a] font-semibold">{{ count($pendaftarans) }}</span>
          <span class="text-[#3f4940]">results</span>
        </div>
        <div class="flex items-center gap-1">
          <div class="rounded-lg w-8 h-8 flex items-center justify-center">
            <img class="w-auto" src="{{ asset('assets/admin/applicants/container51.svg') }}" />
          </div>
          <div class="bg-[#005b31] rounded-lg w-8 h-8 flex items-center justify-center">
            <div class="text-white text-[16px]">1</div>
          </div>
          <div class="rounded-lg w-8 h-8 flex items-center justify-center">
            <img class="w-auto" src="{{ asset('assets/admin/applicants/container53.svg') }}" />
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
