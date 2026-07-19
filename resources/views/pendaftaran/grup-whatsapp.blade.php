@extends('layouts.admin')

@section('title', 'Grup WhatsApp - Admin Portal')

@section('content')
  <div class="relative min-h-screen flow-root">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'applicants'])

    <!-- Content Wrapper -->
    <div class="absolute left-[380px] top-[180px] right-10 flex flex-col gap-6 z-0 max-[1024px]:left-5 max-[1024px]:right-5 max-[1024px]:top-[150px]">

      <!-- Page Header -->
      <div class="flex flex-col gap-1">
        <div class="text-[#181c1c] text-[28px] font-bold tracking-[-0.56px]" style="font-family: 'Manrope-Bold', sans-serif;">Pendaftaran System</div>
        <div class="text-[#3f4941] text-[14px]">Kelola dan pantau seluruh pendaftar calon siswa baru MIN 3 Karanganyar periode aktif.</div>
      </div>

      <!-- Filter Bento -->
      <form action="{{ route('tata_usaha.grup_whatsapp') }}" method="GET" class="flex gap-4 max-[640px]:flex-col">
        @if(request()->filled('tahun'))
          <input type="hidden" name="tahun" value="{{ request('tahun') }}">
        @endif
        <div class="flex-1 bg-white border border-[#bec9be] rounded-lg shadow-[0_1px_1px_rgba(0,0,0,0.05)] px-[17px] pt-[22px] pb-[17px] flex flex-col gap-2.5">
          <label class="text-[#3f4941] text-[12px] font-bold">Periode Aktif</label>
          @if(isset($activePeriod) && $activePeriod)
            <div class="bg-[#005b31] text-white rounded px-3 py-2 text-[14px] flex items-center gap-2">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              {{ $activePeriod->judul }} ({{ $activePeriod->tahun }})
            </div>
          @else
            <div class="bg-red-100 border border-red-300 text-red-700 rounded px-3 py-2 text-[14px]">
              Tidak ada periode aktif
            </div>
          @endif
        </div>

        <div class="flex-1 bg-white border border-[#bec9be] rounded-lg shadow-[0_1px_1px_rgba(0,0,0,0.05)] px-[17px] pt-[22px] pb-[17px] flex flex-col gap-2.5 relative">
          <label class="text-[#3f4941] text-[12px] font-bold">Program</label>
          <input type="hidden" name="program" id="programFilterInput" value="{{ request('program') }}">
          <button type="button" id="programFilterTrigger" onclick="document.getElementById('programFilterDropdown').classList.toggle('hidden')"
                  class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none cursor-pointer flex items-center justify-between gap-2">
            <span id="programFilterLabel">
              @php($selectedProgram = $programs->firstWhere('id_program', request('program')))
              {{ $selectedProgram->nama_program ?? 'Semua Program Kelas' }}
            </span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/></svg>
          </button>
          <div id="programFilterDropdown" class="hidden absolute left-[17px] right-[17px] top-full mt-1 bg-white border border-[#bec9be] rounded shadow-lg z-30 overflow-hidden">
            <button type="button" onclick="selectProgramFilter('', 'Semua Program Kelas')"
                    class="w-full text-left px-3 py-2 text-[14px] {{ !request('program') ? 'bg-[#005b31] text-white' : 'bg-[#f1f4f3] text-[#181c1c]' }} hover:opacity-90">
              Semua Program Kelas
            </button>
            @foreach($programs as $prog)
              <button type="button" onclick="selectProgramFilter('{{ $prog->id_program }}', '{{ $prog->nama_program }}')"
                      class="w-full text-left px-3 py-2 text-[14px] {{ request('program') == $prog->id_program ? 'bg-[#005b31] text-white' : 'bg-[#f1f4f3] text-[#181c1c]' }} hover:opacity-90">
                {{ $prog->nama_program }}
              </button>
            @endforeach
          </div>
        </div>
      </form>

      <script>
        function selectProgramFilter(id, label) {
          document.getElementById('programFilterInput').value = id;
          document.getElementById('programFilterLabel').textContent = label;
          document.getElementById('programFilterDropdown').classList.add('hidden');
          document.getElementById('programFilterInput').closest('form').submit();
        }
        function selectPeriodeFilter(id, label) {
          document.getElementById('periodeFilterInput').value = id;
          document.getElementById('periodeFilterLabel').textContent = label;
          document.getElementById('periodeFilterDropdown').classList.add('hidden');
          document.getElementById('periodeFilterInput').closest('form').submit();
        }
        document.addEventListener('click', function (e) {
          const dropdowns = [
            ['programFilterDropdown', 'programFilterTrigger'],
            ['periodeFilterDropdown', 'periodeFilterTrigger'],
          ];
          dropdowns.forEach(([dropdownId, triggerId]) => {
            const dropdown = document.getElementById(dropdownId);
            const trigger = document.getElementById(triggerId);
            if (dropdown && !dropdown.contains(e.target) && !trigger.contains(e.target)) {
              dropdown.classList.add('hidden');
            }
          });
        });
      </script>

      <!-- Category Tabs -->
      <!-- Category Tabs -->
      @php($queryParams = request()->only(['tahun']))
      <div class="flex gap-4 max-[900px]:flex-wrap">
        <a href="{{ route('scores.index', $queryParams) }}" class="flex-1 bg-white border border-[#bec9be] rounded-sm h-[66px] flex items-center justify-center no-underline hover:bg-gray-50">
          <span class="text-[#181c1c] text-[18px] font-bold">Pendaftaran</span>
        </a>
        <div class="flex-1 bg-[#006a3c] border border-[#bec9be] rounded-sm h-[66px] flex items-center justify-center">
          <span class="text-white text-[18px] font-bold">Grup WhatsApp</span>
        </div>
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
      <div class="flex gap-4 max-[640px]:flex-wrap">
        <a href="{{ route('tata_usaha.grup_whatsapp', array_merge(request()->except('status'), ['status' => 'belum_masuk'])) }}"
           class="rounded px-6 py-2 no-underline {{ request('status') == 'belum_masuk' ? 'bg-[#ba1a1a]' : 'bg-white' }}">
          <span class="{{ request('status') == 'belum_masuk' ? 'text-white' : 'text-[#ba1a1a]' }} text-[16px]">Belum Masuk</span>
        </a>
        <a href="{{ route('tata_usaha.grup_whatsapp', array_merge(request()->except('status'), ['status' => 'sudah_masuk'])) }}"
           class="rounded px-6 py-2 no-underline {{ request('status') == 'sudah_masuk' ? 'bg-[#006a3c]' : 'bg-white' }}">
          <span class="{{ request('status') == 'sudah_masuk' ? 'text-white' : 'text-[#006a3c]' }} text-[16px]">Sudah Masuk</span>
        </a>
        @if(request()->filled('status'))
          <a href="{{ route('tata_usaha.grup_whatsapp', request()->except('status')) }}" class="rounded px-6 py-2 no-underline flex items-center">
            <span class="text-[#3f4941] text-[14px] underline">Reset filter status</span>
          </a>
        @endif
      </div>

      @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-300 text-emerald-700 text-[13px] rounded-md p-3 font-bold">
          {{ session('success') }}
        </div>
      @endif

      <!-- Applicants Table -->
      <div class="bg-white border border-[#bec9be] rounded-xl overflow-hidden mb-10">
        <div class="bg-[#eff4ff] grid grid-cols-5 gap-4 px-6 py-4 max-[900px]:hidden">
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">No Pendaftar</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Nama Lengkap</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">NISN</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Jenis Kelamin</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Program</div>
        </div>

        <div class="flex flex-col gap-4 p-6">
          @forelse($pendaftarans as $item)
            <div class="border border-[#bec9be] rounded-lg p-6 grid grid-cols-5 gap-4 items-center max-[900px]:grid-cols-1 max-[900px]:gap-2">
              <div class="text-[#181c1c] text-[14px] font-bold">PMBM-2026-{{ str_pad($item->id_pendaftaran, 2, '0', STR_PAD_LEFT) }}</div>
              <div class="text-[#181c1c] text-[16px] font-bold uppercase">{{ $item->calonMurid->nama_murid }}</div>
              <div class="text-[#3f4941] text-[14px]">{{ $item->calonMurid->nisn }}</div>
              <div class="text-[#3f4941] text-[14px] uppercase">{{ $item->calonMurid->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
              <div class="flex items-center justify-between gap-3">
                <span class="text-[10px] uppercase px-3 py-1 rounded-full" style="background: {{ $item->program->badge_color['bg'] ?? '#ffdcc3' }}; color: {{ $item->program->badge_color['text'] ?? '#2f1500' }};">{{ $item->program->nama_program ?? '-' }}</span>
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
