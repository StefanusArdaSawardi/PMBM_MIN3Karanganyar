@extends('layouts.admin')

@section('title', 'Seleksi Siswa - Admin Portal')

@section('content')
  <div class="relative min-h-screen flow-root">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'applicants'])

    <!-- Content Wrapper -->
    <div class="absolute left-[380px] top-[180px] right-10 flex flex-col gap-6 z-0 max-[1024px]:left-5 max-[1024px]:right-5 max-[1024px]:top-[150px]">

      <!-- Page Header -->
      <div class="flex flex-col gap-1">
        <div class="text-[#181c1c] text-[28px] font-bold tracking-[-0.56px]" style="font-family: 'Manrope-Bold', sans-serif;">Pendaftaran System</div>
        <div class="text-[#3f4941] text-[14px]">Tahap Seleksi, Rekomendasi DSS (Decision Support System), &amp; Penetapan Kelulusan.</div>
      </div>

      <!-- Filter Bento -->
      <form action="{{ route('tata_usaha.seleksi') }}" method="GET" class="flex gap-4 max-[1024px]:flex-col flex-wrap w-full bg-white border border-[#bec9be] rounded-lg shadow-[0_1px_1px_rgba(0,0,0,0.05)] p-5 items-stretch">
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
          <label class="text-[#3f4941] text-[12px] font-bold">Program Pilihan</label>
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
        <div class="flex-1 bg-[#006a3c] border border-[#bec9be] rounded-sm h-[66px] flex items-center justify-center">
          <span class="text-white text-[18px] font-bold">Seleksi</span>
        </div>
        <a href="{{ route('tata_usaha.daftar_ulang', $queryParams) }}" class="flex-1 bg-white border border-[#bec9be] rounded-sm h-[66px] flex items-center justify-center no-underline hover:bg-gray-50">
          <span class="text-[#181c1c] text-[18px] font-bold">Daftar Ulang</span>
        </a>
      </div>

      <!-- Session Success Notification -->
      @if(session('success'))
        <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px; color: #166534; font-size: 14px;">
          ✓ {{ session('success') }}
        </div>
      @endif

      <!-- Applicants Table -->
      <div class="bg-white border border-[#bec9be] rounded-xl overflow-hidden mb-10">
        <div class="bg-[#eff4ff] p-6 max-[900px]:hidden">
          <div style="display: grid; grid-template-columns: 2fr 3fr 1.5fr 1.5fr 2fr; gap: 20px; font-weight: bold; font-size: 12px; color: #3f4941; text-transform: uppercase; letter-spacing: 0.5px;">
            <div>Calon Siswa</div>
            <div>Nilai Asesmen (Hafalan, AISM, Iqro, Calistung, Dikte, Mandiri)</div>
            <div class="text-center">Rekomendasi DSS</div>
            <div>Program Kelulusan</div>
            <div class="text-center">Validasi Status Kelulusan</div>
          </div>
        </div>

        <div class="flex flex-col gap-4 p-6">
          @forelse($pendaftarans as $item)
            <div class="border border-[#bec9be] rounded-lg p-6" style="display: grid; grid-template-columns: 2fr 3fr 1.5fr 1.5fr 2fr; gap: 20px; align-items: center; background-color: #fff;">
              
              <!-- Student Info -->
              <div>
                <div class="text-[#181c1c] text-[16px] font-bold uppercase">{{ $item->calonMurid->nama_murid }}</div>
                <div class="text-gray-500 text-[12px] mt-1">NISN: {{ $item->calonMurid->nisn }}</div>
                <div class="text-gray-500 text-[12px]">Pilihan Awal: <strong>{{ $item->program->nama_program ?? '-' }}</strong></div>
                <div class="mt-2"><a href="{{ route('tata_usaha.detail', $item->id_pendaftaran) }}" class="text-[#006a3c] text-[13px] font-bold no-underline hover:underline">Lihat Detail Profil ↗</a></div>
              </div>

              <!-- Assessment Scores -->
              <div>
                @if($item->nilaiUjian)
                  <?php $n = $item->nilaiUjian; ?>
                  <div class="grid grid-cols-3 gap-2" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
                    <div style="background-color: #f3f4f6; border-radius: 6px; padding: 6px; text-align: center; font-size: 12px;">
                      <span class="text-gray-500 block font-semibold" style="font-size: 10px;">Hafalan</span>
                      <strong class="text-gray-800 text-[14px]">{{ $n->nilai_hafalan ?? 0 }}</strong>
                    </div>
                    <div style="background-color: #f3f4f6; border-radius: 6px; padding: 6px; text-align: center; font-size: 12px;">
                      <span class="text-gray-500 block font-semibold" style="font-size: 10px;">AISM</span>
                      <strong class="text-gray-800 text-[14px]">{{ $n->nilai_aism ?? 0 }}</strong>
                    </div>
                    <div style="background-color: #f3f4f6; border-radius: 6px; padding: 6px; text-align: center; font-size: 12px;">
                      <span class="text-gray-500 block font-semibold" style="font-size: 10px;">Iqro</span>
                      <strong class="text-gray-800 text-[14px]">{{ $n->nilai_iqro ?? 0 }}</strong>
                    </div>
                    <div style="background-color: #f3f4f6; border-radius: 6px; padding: 6px; text-align: center; font-size: 12px;">
                      <span class="text-gray-500 block font-semibold" style="font-size: 10px;">Calistung</span>
                      <strong class="text-gray-800 text-[14px]">{{ $n->nilai_calistung ?? 0 }}</strong>
                    </div>
                    <div style="background-color: #f3f4f6; border-radius: 6px; padding: 6px; text-align: center; font-size: 12px;">
                      <span class="text-gray-500 block font-semibold" style="font-size: 10px;">Dikte</span>
                      <strong class="text-gray-800 text-[14px]">{{ $n->nilai_dikte ?? 0 }}</strong>
                    </div>
                    <div style="background-color: #f3f4f6; border-radius: 6px; padding: 6px; text-align: center; font-size: 12px;">
                      <span class="text-gray-500 block font-semibold" style="font-size: 10px;">Kemandirian</span>
                      <strong class="text-gray-800 text-[14px]">{{ $n->nilai_kemandirian ?? 0 }}</strong>
                    </div>
                  </div>
                @else
                  <div class="text-amber-600 bg-amber-50 border border-amber-200 rounded px-3 py-2 text-[13px] text-center">
                    ⚠️ Nilai Asesmen Belum Diinput Panitia
                  </div>
                @endif
              </div>

              <!-- DSS Recommendation -->
              <div class="text-center">
                @if($item->nilaiUjian && $item->dssRanking)
                  <?php
                    $rec = $item->dssRanking->rekomendasi;
                    $bg = '#f3f4f6'; $fg = '#374151';
                    if ($rec === 'Lulus Seleksi') { $bg = '#dcfce7'; $fg = '#15803d'; }
                    elseif ($rec === 'Cadangan') { $bg = '#fef3c7'; $fg = '#b45309'; }
                    elseif ($rec === 'Tidak Lulus') { $bg = '#fee2e2'; $fg = '#b91c1c'; }
                  ?>
                  <span class="text-[12px] font-bold px-3 py-1.5 rounded-full" style="background-color: {{ $bg }}; color: {{ $fg }};">
                    {{ $rec }}
                  </span>
                  <div class="text-[11px] text-gray-500 mt-2">Skor: {{ number_format($item->dssRanking->nilai_total ?? 0, 1) }}</div>
                @else
                  <span class="text-[12px] font-semibold bg-gray-100 text-gray-400 px-3 py-1 rounded-full">
                    Belum Dinilai
                  </span>
                @endif
              </div>

              <!-- Program Kelulusan Selector -->
              <div>
                <form action="{{ route('tata_usaha.change_program', $item->id_pendaftaran) }}" method="POST" style="margin: 0; padding: 0;">
                  @csrf
                  <input type="hidden" name="type" value="kelulusan">
                  <select name="id_program" onchange="this.form.submit()" class="bg-gray-50 border border-[#bec9be] rounded px-2 py-1.5 text-[12px] text-gray-700 w-full cursor-pointer outline-none">
                    <?php $currentGradName = $item->program_kelulusan ?: ($item->program->nama_program ?? ''); ?>
                    @foreach($programs as $p)
                      <option value="{{ $p->id_program }}" {{ $currentGradName === $p->nama_program ? 'selected' : '' }}>
                        {{ $p->nama_program }}
                      </option>
                    @endforeach
                  </select>
                </form>
              </div>

              <!-- Validation Buttons -->
              <div class="flex flex-col gap-2 align-stretch">
                <!-- Current status label -->
                <div class="text-center mb-1">
                  <?php
                    $valStatus = $item->status_kelulusan;
                    $lbl = 'Belum Ditetapkan'; $badgeColor = '#6b7280';
                    if ($valStatus === 'lulus') { $lbl = 'LULUS'; $badgeColor = '#10b981'; }
                    elseif ($valStatus === 'tidak_lulus') { $lbl = 'TIDAK LULUS'; $badgeColor = '#ef4444'; }
                    elseif ($valStatus === 'cadangan') { $lbl = 'CADANGAN'; $badgeColor = '#f59e0b'; }
                  ?>
                  <span class="text-[10px] font-bold text-white px-2.5 py-0.5 rounded" style="background-color: {{ $badgeColor }};">
                    {{ $lbl }}
                  </span>
                </div>
                
                <form action="{{ route('tata_usaha.status', $item->id_pendaftaran) }}" method="POST" class="flex gap-1" style="margin: 0; padding: 0; width: 100%;">
                  @csrf
                  <input type="hidden" name="action" value="penetapan_kelulusan">
                  
                  <button type="submit" name="status_kelulusan" value="lulus" class="flex-1 bg-[#10b981] hover:bg-[#059669] text-white text-[12px] font-bold py-1.5 rounded cursor-pointer border-none transition-colors">
                    Lulus
                  </button>
                  <button type="submit" name="status_kelulusan" value="cadangan" class="flex-1 bg-[#f59e0b] hover:bg-[#d97706] text-white text-[12px] font-bold py-1.5 rounded cursor-pointer border-none transition-colors">
                    Cadang
                  </button>
                  <button type="submit" name="status_kelulusan" value="tidak_lulus" class="flex-1 bg-[#ef4444] hover:bg-[#dc2626] text-white text-[12px] font-bold py-1.5 rounded cursor-pointer border-none transition-colors">
                    Gagal
                  </button>
                </form>
              </div>

            </div>
          @empty
            <div class="text-center text-gray-500 py-10">
              Tidak ada calon siswa pada tahap seleksi.
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
@endsection
