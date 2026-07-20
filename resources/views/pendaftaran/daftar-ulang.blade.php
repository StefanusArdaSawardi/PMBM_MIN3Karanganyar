@extends('layouts.admin')

@section('title', 'Daftar Ulang Siswa - Admin Portal')

@section('content')
  <div class="relative min-h-screen flow-root">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'applicants'])

    <!-- Content Wrapper -->
    <div class="absolute left-[380px] top-[180px] right-10 flex flex-col gap-6 z-0 max-[1024px]:left-5 max-[1024px]:right-5 max-[1024px]:top-[150px]">

      <!-- Page Header -->
      <div class="flex flex-col gap-1">
        <div class="text-[#181c1c] text-[28px] font-bold tracking-[-0.56px]" style="font-family: 'Manrope-Bold', sans-serif;">Pendaftaran System</div>
        <div class="text-[#3f4941] text-[14px]">Tahap Daftar Ulang Calon Siswa Baru &amp; Publikasi Hasil Kelulusan.</div>
      </div>

      <!-- Filter Bento -->
      <form action="{{ route('tata_usaha.daftar_ulang') }}" method="GET" class="flex gap-4 max-[1024px]:flex-col flex-wrap w-full bg-white border border-[#bec9be] rounded-lg shadow-[0_1px_1px_rgba(0,0,0,0.05)] p-5 items-stretch">
        @if(request()->filled('tahun'))
          <input type="hidden" name="tahun" value="{{ request('tahun') }}">
        @endif
        <!-- Search Input -->
        <div style="flex: 2; min-width: 250px; display: flex; flex-direction: column; gap: 8px;">
          <label class="text-[#3f4941] text-[12px] font-bold">Cari Calon Siswa</label>
          <div style="position: relative; display: flex; align-items: center; width: 100%;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama murid, NISN..." 
                   class="bg-[#f1f4f3] border border-[#bec9be] rounded px-4 py-2.5 text-[14px] text-[#181c1c] outline-none w-full" style="height: 40px; box-sizing: border-box;">
            <button type="submit" style="position: absolute; right: 10px; background: none; border: none; cursor: pointer; color: #005b31;">
              🔍
            </button>
          </div>
        </div>

        <!-- Program Filter -->
        <div style="flex: 1.5; min-width: 200px; display: flex; flex-direction: column; gap: 8px; position: relative;">
          <label class="text-[#3f4941] text-[12px] font-bold">Program</label>
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
        <a href="{{ route('scores.index', $queryParams) }}" class="flex-1 bg-white border border-[#bec9be] rounded-sm h-[66px] flex items-center justify-center no-underline hover:bg-gray-50">
          <span class="text-[#181c1c] text-[18px] font-bold">Pendaftaran</span>
        </a>
        <a href="{{ route('tata_usaha.grup_whatsapp', $queryParams) }}" class="flex-1 bg-white border border-[#bec9be] rounded-sm h-[66px] flex items-center justify-center no-underline hover:bg-gray-50">
          <span class="text-[#181c1c] text-[18px] font-bold">Grup WhatsApp</span>
        </a>
        <a href="{{ route('tata_usaha.verifikasi_offline', $queryParams) }}" class="flex-1 bg-white border border-[#bec9be] rounded-sm h-[66px] flex items-center justify-center no-underline hover:bg-gray-50">
          <span class="text-[#181c1c] text-[18px] font-bold">Verifikasi Offline</span>
        </a>
        <a href="{{ route('tata_usaha.seleksi', $queryParams) }}" class="flex-1 bg-white border border-[#bec9be] rounded-sm h-[66px] flex items-center justify-center no-underline hover:bg-gray-50">
          <span class="text-[#181c1c] text-[18px] font-bold">Seleksi</span>
        </a>
        <div class="flex-1 bg-[#006a3c] border border-[#bec9be] rounded-sm h-[66px] flex items-center justify-center">
          <span class="text-white text-[18px] font-bold">Daftar Ulang</span>
        </div>
      </div>

      <!-- Session Success Notification -->
      @if(session('success'))
        <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px; color: #166534; font-size: 14px;">
          ✓ {{ session('success') }}
        </div>
      @endif

      <!-- Applicants Table -->
      <div class="bg-white border border-[#bec9be] rounded-xl overflow-hidden mb-10">
        <div class="bg-[#eff4ff] grid grid-cols-5 gap-4 px-6 py-4 max-[900px]:hidden" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px;">
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Calon Siswa</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Program Kelulusan</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Batas Konfirmasi</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Status Konfirmasi</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase" style="text-align: center;">Tindakan Daftar Ulang</div>
        </div>

        <div class="flex flex-col gap-4 p-6">
          @forelse($pendaftarans as $item)
            <div class="border border-[#bec9be] rounded-lg p-6 grid grid-cols-5 gap-4 items-center max-[900px]:grid-cols-1 max-[900px]:gap-2" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px;">
              
              <!-- Student Info -->
              <div>
                <div class="text-[#181c1c] text-[16px] font-bold uppercase">{{ $item->calonMurid->nama_murid }}</div>
                <div class="text-gray-500 text-[12px] mt-1">NISN: {{ $item->calonMurid->nisn }}</div>
                <div class="text-[#006a3c] text-[12px] mt-1"><a href="{{ route('tata_usaha.detail', $item->id_pendaftaran) }}" class="no-underline hover:underline">Detail Profil ↗</a></div>
              </div>

              <!-- Program Class -->
              <div>
                <span class="text-[12px] font-bold text-gray-800">
                  {{ $item->program_kelulusan ?: ($item->program->nama_program ?? '-') }}
                </span>
              </div>

              <!-- Confirmation Deadline -->
              <div class="text-gray-600 text-[13px]">
                {{ $item->batas_konfirmasi ? \Carbon\Carbon::parse($item->batas_konfirmasi)->translatedFormat('d F Y H:i') : 'Tidak diatur' }}
              </div>

              <!-- Confirmation Status Badge -->
              <div>
                <?php
                  $status = $item->status_konfirmasi;
                  $bg = '#f3f4f6'; $fg = '#374151'; $lbl = 'Belum Konfirmasi';
                  if ($status === 'terkonfirmasi') { $bg = '#dcfce7'; $fg = '#166534'; $lbl = 'Daftar Ulang'; }
                  elseif ($status === 'mengundurkan_diri') { $bg = '#fee2e2'; $fg = '#991b1b'; $lbl = 'Mundur'; }
                ?>
                <span class="text-[11px] font-bold px-2.5 py-1 rounded-full" style="background-color: {{ $bg }}; color: {{ $fg }};">
                  {{ $lbl }}
                </span>
              </div>

              <!-- Action Confirmation Buttons -->
              <div class="flex flex-col gap-1 items-center">
                @if($item->status_konfirmasi === 'terkonfirmasi')
                  <!-- If already confirmed, show option to mark as withdrawn or cancel confirmation -->
                  <form action="{{ route('tata_usaha.status', $item->id_pendaftaran) }}" method="POST" style="margin: 0; padding: 0; width: 100%;">
                    @csrf
                    <input type="hidden" name="action" value="konfirmasi_onsite">
                    <input type="hidden" name="status_konfirmasi" value="mengundurkan_diri">
                    <button type="submit" class="w-full bg-[#ba1a1a] hover:bg-[#93000a] text-white text-[12px] font-bold py-1.5 px-3 rounded cursor-pointer border-none transition-colors">
                      ✕ Tandai Mundur
                    </button>
                  </form>
                  <form action="{{ route('tata_usaha.status', $item->id_pendaftaran) }}" method="POST" style="margin: 0; padding: 0; width: 100%; margin-top: 4px;">
                    @csrf
                    <input type="hidden" name="action" value="konfirmasi_onsite">
                    <input type="hidden" name="status_konfirmasi" value="belum_konfirmasi">
                    <button type="submit" class="w-full bg-gray-500 hover:bg-gray-600 text-white text-[11px] font-bold py-1 px-3 rounded cursor-pointer border-none transition-colors">
                      Batalkan Konfirmasi
                    </button>
                  </form>

                @elseif($item->status_konfirmasi === 'mengundurkan_diri')
                  <!-- If withdrawn, show option to confirm or cancel withdrawal -->
                  <form action="{{ route('tata_usaha.status', $item->id_pendaftaran) }}" method="POST" style="margin: 0; padding: 0; width: 100%;">
                    @csrf
                    <input type="hidden" name="action" value="konfirmasi_onsite">
                    <input type="hidden" name="status_konfirmasi" value="terkonfirmasi">
                    <button type="submit" class="w-full bg-[#005b31] hover:bg-[#064e3b] text-white text-[12px] font-bold py-1.5 px-3 rounded cursor-pointer border-none transition-colors">
                      ✓ Konfirmasi Lulus
                    </button>
                  </form>
                  <form action="{{ route('tata_usaha.status', $item->id_pendaftaran) }}" method="POST" style="margin: 0; padding: 0; width: 100%; margin-top: 4px;">
                    @csrf
                    <input type="hidden" name="action" value="konfirmasi_onsite">
                    <input type="hidden" name="status_konfirmasi" value="belum_konfirmasi">
                    <button type="submit" class="w-full bg-gray-500 hover:bg-gray-600 text-white text-[11px] font-bold py-1 px-3 rounded cursor-pointer border-none transition-colors">
                      Batalkan Mundur
                    </button>
                  </form>

                @else
                  <!-- If pending/belum_konfirmasi, show both actions -->
                  <div class="flex gap-1 w-full">
                    <form action="{{ route('tata_usaha.status', $item->id_pendaftaran) }}" method="POST" style="margin: 0; padding: 0; flex: 1;">
                      @csrf
                      <input type="hidden" name="action" value="konfirmasi_onsite">
                      <input type="hidden" name="status_konfirmasi" value="terkonfirmasi">
                      <button type="submit" class="w-full bg-[#005b31] hover:bg-[#064e3b] text-white text-[12px] font-bold py-1.5 rounded cursor-pointer border-none transition-colors">
                        ✓ Lulus
                      </button>
                    </form>
                    <form action="{{ route('tata_usaha.status', $item->id_pendaftaran) }}" method="POST" style="margin: 0; padding: 0; flex: 1;">
                      @csrf
                      <input type="hidden" name="action" value="konfirmasi_onsite">
                      <input type="hidden" name="status_konfirmasi" value="mengundurkan_diri">
                      <button type="submit" class="w-full bg-[#ba1a1a] hover:bg-[#93000a] text-white text-[12px] font-bold py-1.5 rounded cursor-pointer border-none transition-colors">
                        ✕ Mundur
                      </button>
                    </form>
                  </div>
                @endif
              </div>

            </div>
          @empty
            <div class="text-center text-gray-500 py-10">
              Tidak ada calon siswa lulus seleksi untuk daftar ulang.
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
@endsection
