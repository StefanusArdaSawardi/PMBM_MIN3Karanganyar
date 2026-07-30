@extends('layouts.admin')

@section('title', 'Pendaftaran System - Admin Portal')

@section('content')
  <div class="relative min-h-screen flow-root">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'applicants'])

    <!-- Content Wrapper -->
    <div class="absolute left-[380px] top-[180px] right-10 flex flex-col gap-6 z-0 max-[1024px]:left-5 max-[1024px]:right-5 max-[1024px]:top-[150px]">

      <!-- Page Header -->
      <div class="flex flex-col gap-1">
        <div class="text-[#181c1c] text-[28px] font-bold tracking-[-0.56px]" style="font-family: 'Manrope-Bold', sans-serif;">Pendaftaran System</div>
        <div class="text-[#3f4941] text-[14px]">Kelola dan pantau seluruh pendaftar calon siswa baru MIN 3 Karanganyar periode {{ $activePeriod ? $activePeriod->tahun : 'aktif' }}.</div>
      </div>

      <!-- Filter Bento -->
      <form action="{{ route('scores.index') }}" method="GET" class="flex gap-4 max-[1024px]:flex-col flex-wrap w-full bg-white border border-[#bec9be] rounded-lg shadow-[0_1px_1px_rgba(0,0,0,0.05)] p-5 items-stretch">
        @if(request()->filled('tahun'))
          <input type="hidden" name="tahun" value="{{ request('tahun') }}">
        @endif
        <!-- Search Input -->
        <div style="flex: 2; min-width: 250px; display: flex; flex-direction: column; gap: 8px;">
          <label class="text-[#3f4941] text-[12px] font-bold">Cari Calon Siswa</label>
          <div style="position: relative; display: flex; align-items: center; width: 100%;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama murid, NISN, atau nama orang tua..." 
                   class="bg-[#f1f4f3] border border-[#bec9be] rounded px-4 py-2.5 text-[14px] text-[#181c1c] outline-none w-full" style="height: 40px; box-sizing: border-box;">
            <button type="submit" style="position: absolute; right: 10px; background: none; border: none; cursor: pointer; color: #005b31;">
              🔍
            </button>
          </div>
        </div>

        <!-- Program Filter -->
        <div style="flex: 1.5; min-width: 200px; display: flex; flex-direction: column; gap: 8px; position: relative;">
          <label class="text-[#3f4941] text-[12px] font-bold">Program Kelas</label>
          <input type="hidden" name="program" id="programFilterInput" value="{{ request('program') }}">
          <button type="button" id="programFilterTrigger" onclick="document.getElementById('programFilterDropdown').classList.toggle('hidden')"
                  class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2.5 text-[14px] text-[#181c1c] outline-none cursor-pointer flex items-center justify-between gap-2" style="height: 40px; width: 100%;">
            <span id="programFilterLabel" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
              @php($selectedProgram = $programs->firstWhere('id_program', request('program')))
              {{ $selectedProgram->nama_program ?? 'Semua Program Kelas' }}
            </span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/></svg>
          </button>
          <div id="programFilterDropdown" class="hidden absolute left-0 right-0 top-full mt-1 bg-white border border-[#bec9be] rounded shadow-lg z-30 overflow-hidden">
            <button type="button" onclick="selectProgramFilter('', 'Semua Program Kelas')"
                    class="w-full text-left px-3 py-2 text-[14px] {{ !request('program') ? 'bg-[#005b31] text-white' : 'bg-[#f1f4f3] text-[#181c1c]' }} hover:opacity-90 border-none cursor-pointer">
              Semua Program Kelas
            </button>
            @foreach($programs as $prog)
              <button type="button" onclick="selectProgramFilter('{{ $prog->id_program }}', '{{ $prog->nama_program }}')"
                      class="w-full text-left px-3 py-2 text-[14px] {{ request('program') == $prog->id_program ? 'bg-[#005b31] text-white' : 'bg-[#f1f4f3] text-[#181c1c]' }} hover:opacity-90 border-none cursor-pointer">
                {{ $prog->nama_program }}
              </button>
            @endforeach
          </div>
        </div>

        <!-- Sort Filter -->
        <div style="flex: 1; min-width: 150px; display: flex; flex-direction: column; gap: 8px;">
          <label class="text-[#3f4941] text-[12px] font-bold">Urutkan</label>
          <select name="sort" onchange="this.form.submit()" class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2.5 text-[14px] text-[#181c1c] outline-none cursor-pointer" style="height: 40px;">
            <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Pendaftaran Baru</option>
            <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Pendaftaran Lama</option>
            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
          </select>
        </div>

        <!-- Limit Filter -->
        <div style="flex: 0.8; min-width: 100px; display: flex; flex-direction: column; gap: 8px;">
          <label class="text-[#3f4941] text-[12px] font-bold">Tampilkan</label>
          <select name="limit" onchange="this.form.submit()" class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2.5 text-[14px] text-[#181c1c] outline-none cursor-pointer" style="height: 40px;">
            <option value="5" {{ request('limit') == 5 ? 'selected' : '' }}>5 Baris</option>
            <option value="10" {{ !request('limit') || request('limit') == 10 ? 'selected' : '' }}>10 Baris</option>
            <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20 Baris</option>
            <option value="30" {{ request('limit') == 30 ? 'selected' : '' }}>30 Baris</option>
          </select>
        </div>
      </form>

      <script>
        function selectProgramFilter(id, label) {
          document.getElementById('programFilterInput').value = id;
          document.getElementById('programFilterLabel').textContent = label;
          document.getElementById('programFilterDropdown').classList.add('hidden');
          document.getElementById('programFilterInput').closest('form').submit();
        }
        document.addEventListener('click', function (e) {
          const dropdown = document.getElementById('programFilterDropdown');
          const trigger = document.getElementById('programFilterTrigger');
          if (dropdown && !dropdown.contains(e.target) && !trigger.contains(e.target)) {
            dropdown.classList.add('hidden');
          }
        });
      </script>

      <!-- Category Tabs -->
      @php($queryParams = request()->only(['tahun']))
      <div class="flex gap-4 max-[900px]:flex-wrap">
        <div class="flex-1 bg-[#006a3c] border border-[#bec9be] rounded-sm h-[66px] flex items-center justify-center">
          <span class="text-white text-[18px] font-bold">Pendaftaran</span>
        </div>
        <a href="{{ route('tata_usaha.grup_whatsapp', $queryParams) }}" class="flex-1 bg-white border border-[#bec9be] rounded-sm h-[66px] flex items-center justify-center no-underline hover:bg-gray-50">
          <span class="text-[#181c1c] text-[18px] font-bold">Grup WhatsApp</span>
        </a>
        <a href="{{ route('tata_usaha.verifikasi_offline', $queryParams) }}" class="flex-1 bg-white border border-[#bec9be] rounded-sm h-[66px] flex items-center justify-center no-underline hover:bg-gray-50">
          <span class="text-[#181c1c] text-[18px] font-bold">Verifikasi Offline</span>
        </a>
        <a href="{{ route('tata_usaha.seleksi', $queryParams) }}" class="flex-1 bg-white border border-[#bec9be] rounded-sm h-[66px] flex items-center justify-center no-underline hover:bg-gray-50">
          <span class="text-[#181c1c] text-[18px] font-bold">Seleksi</span>
        </a>
        <a href="{{ route('tata_usaha.daftar_ulang', $queryParams) }}" class="flex-1 bg-white border border-[#bec9be] rounded-sm h-[66px] flex items-center justify-center no-underline hover:bg-gray-50">
          <span class="text-[#181c1c] text-[18px] font-bold">Daftar Ulang</span>
        </a>
      </div>

      <!-- Status Sub-Filter -->
      @php($curStatus = request('status'))
      <div class="flex gap-4 max-[640px]:flex-wrap">
        <a href="{{ route('scores.index', array_merge(request()->except('status'), ['status' => 'menunggu_verifikasi'])) }}"
           class="rounded px-6 py-2 no-underline {{ in_array($curStatus, ['menunggu_verifikasi', 'belum_konfirmasi']) ? 'bg-[#109aaa]' : 'bg-white border border-[#bec9be]' }}">
          <span class="{{ in_array($curStatus, ['menunggu_verifikasi', 'belum_konfirmasi']) ? 'text-white' : 'text-[#109aaa]' }} text-[16px] font-medium">Belum Terkonfirmasi</span>
        </a>
        <a href="{{ route('scores.index', array_merge(request()->except('status'), ['status' => 'ditolak'])) }}"
           class="rounded px-6 py-2 no-underline {{ $curStatus == 'ditolak' ? 'bg-[#ba1a1a]' : 'bg-white border border-[#bec9be]' }}">
          <span class="{{ $curStatus == 'ditolak' ? 'text-white' : 'text-[#ba1a1a]' }} text-[16px] font-medium">Tolak</span>
        </a>
        <a href="{{ route('scores.index', array_merge(request()->except('status'), ['status' => 'terverifikasi'])) }}"
           class="rounded px-6 py-2 no-underline {{ in_array($curStatus, ['terverifikasi', 'terkonfirmasi']) ? 'bg-[#006a3c]' : 'bg-white border border-[#bec9be]' }}">
          <span class="{{ in_array($curStatus, ['terverifikasi', 'terkonfirmasi']) ? 'text-white' : 'text-[#006a3c]' }} text-[16px] font-medium">Terima</span>
        </a>
        @if(request()->filled('status') || request()->filled('search'))
          <a href="{{ route('scores.index') }}" class="rounded px-6 py-2 no-underline flex items-center">
            <span class="text-[#3f4941] text-[14px] underline">Reset filter &amp; pencarian</span>
          </a>
        @endif
      </div>

      <!-- Applicants Table (Scrollable Container) -->
      <div class="bg-white border border-[#bec9be] rounded-xl overflow-x-auto w-full mb-10">
        <div class="bg-[#eff4ff] px-6 py-4" style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 16px; min-width: 900px;">
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Tanggal Daftar</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Nama Lengkap</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">NISN</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Jenis Kelamin</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Status</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Program</div>
        </div>

        <div class="flex flex-col gap-4 p-6" style="min-width: 900px;">
          @forelse($pendaftarans as $item)
            <div class="border border-[#bec9be] rounded-lg p-6 items-center" style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 16px;">
              <div class="text-[#181c1c] text-[14px] font-bold">
                {{ \Carbon\Carbon::parse($item->tanggal_pendaftaran)->translatedFormat('d F Y') }}
              </div>
              <div class="text-[#181c1c] text-[16px] font-bold uppercase">{{ $item->calonMurid->nama_murid }}</div>
              <div class="text-[#3f4941] text-[14px]">{{ $item->calonMurid->nisn }}</div>
              <div class="text-[#3f4941] text-[14px] uppercase">{{ $item->calonMurid->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
              
              <!-- Status Column Badge -->
              <div>
                <?php
                  if ($item->status_konfirmasi === 'terkonfirmasi') {
                      $statusLabel = 'Diterima';
                      $statusBg = '#d9e6da';
                      $statusColor = '#004228';
                  } elseif ($item->status_konfirmasi === 'mengundurkan_diri') {
                      $statusLabel = 'Mundur';
                      $statusBg = '#fee2e2';
                      $statusColor = '#991b1b';
                  } elseif ($item->status_kelulusan === 'lulus') {
                      $statusLabel = 'Lulus';
                      $statusBg = '#dcfce7';
                      $statusColor = '#166534';
                  } elseif ($item->status_kelulusan === 'tidak_lulus') {
                      $statusLabel = 'Tidak Lulus';
                      $statusBg = '#fee2e2';
                      $statusColor = '#991b1b';
                  } elseif ($item->status_kelulusan === 'cadangan') {
                      $statusLabel = 'Cadangan';
                      $statusBg = '#fef3c7';
                      $statusColor = '#92400e';
                  } elseif ($item->status_verifikasi === 'terverifikasi_onsite') {
                      $statusLabel = 'Verifikasi Fisik';
                      $statusBg = '#dbeafe';
                      $statusColor = '#1e40af';
                  } elseif ($item->status_verifikasi === 'terverifikasi') {
                      $statusLabel = 'Terverifikasi';
                      $statusBg = '#e0f2fe';
                      $statusColor = '#075985';
                  } elseif ($item->status_verifikasi === 'ditolak') {
                      $statusLabel = 'Ditolak';
                      $statusBg = '#fee2e2';
                      $statusColor = '#ba1a1a';
                  } else {
                      $statusLabel = 'Menunggu';
                      $statusBg = '#f3f4f6';
                      $statusColor = '#374151';
                  }
                ?>
                <span class="text-[11px] font-bold px-2.5 py-1 rounded-full" style="background-color: {{ $statusBg }}; color: {{ $statusColor }}; whitespace: nowrap;">
                  {{ $statusLabel }}
                </span>
              </div>

              <div class="flex items-center justify-between gap-3">
                <span class="text-[10px] uppercase px-3 py-1 rounded-full" style="background: {{ $item->program->badge_color['bg'] ?? '#ffdcc3' }}; color: {{ $item->program->badge_color['text'] ?? '#2f1500' }}; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $item->program->nama_program ?? '-' }}</span>
                <a href="{{ route('tata_usaha.detail', $item->id_pendaftaran) }}" class="bg-[#006a3c] text-white text-[16px] px-6 py-2 rounded no-underline hover:bg-[#064e3b]">Detail</a>
              </div>
            </div>
          @empty
            <div class="text-center text-gray-500 py-10">
              Tidak ada pendaftar yang cocok dengan filter yang dipilih.
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
@endsection
