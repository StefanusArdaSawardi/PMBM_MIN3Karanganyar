@extends('layouts.admin')

@section('title', 'Admin Dashboard - CMS PMBM')

@section('content')
  <div class="relative min-h-screen flow-root">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'dashboard'])

    <!-- Main Content Wrapper -->
    <div class="absolute left-[380px] top-[138px] right-10 flex flex-col gap-6 z-0 max-[1024px]:left-5 max-[1024px]:right-5 max-[1024px]:top-[150px]">

      <!-- Filter Bento -->
      <form action="{{ route('tata_usaha.dashboard') }}" method="GET" class="flex gap-4 max-[640px]:flex-col">
        <div class="flex-1 bg-white border border-[#bec9be] rounded-lg shadow-[0_1px_1px_rgba(0,0,0,0.05)] px-[17px] pt-[22px] pb-[17px] flex flex-col gap-2.5">
          <label class="text-[#3f4941] text-[12px] font-bold">Periode</label>
          <div class="bg-[#f1f4f3] border border-[#bec9be] rounded flex items-stretch">
            <input type="text" name="tahun" value="{{ request('tahun') }}" placeholder="Tahun Periode"
                   class="flex-1 min-w-0 bg-transparent px-3 py-2 text-[14px] text-[#181c1c] outline-none">
            <button type="submit" class="bg-[#005b31] text-white text-[14px] px-4 rounded-r shrink-0">Cari</button>
          </div>
        </div>

        <div class="flex-1 bg-white border border-[#bec9be] rounded-lg shadow-[0_1px_1px_rgba(0,0,0,0.05)] px-[17px] pt-[22px] pb-[17px] flex flex-col gap-2.5">
          <label class="text-[#3f4941] text-[12px] font-bold">Program</label>
          <select name="program" onchange="this.form.submit()"
                  class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none cursor-pointer">
            <option value="">Semua Program Kelas</option>
            @foreach($programs as $prog)
              <option value="{{ $prog->id_program }}" {{ request('program') == $prog->id_program ? 'selected' : '' }}>
                {{ $prog->nama_program }}
              </option>
            @endforeach
          </select>
        </div>
      </form>

      <!-- Stats Row 1 -->
      <div class="flex gap-6 max-[900px]:flex-col">
        <a href="{{ route('scores.index') }}" class="flex-1 bg-[#005b31] rounded-lg px-6 py-6 flex items-center justify-between no-underline hover:bg-[#064e3b]">
          <span class="text-white text-[20px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">Jumlah Pendaftar</span>
          <span class="text-white text-[30px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">{{ $totalPeserta }}</span>
        </a>
        <a href="{{ route('scores.index', ['status' => 'lulus']) }}" class="flex-1 bg-[#005b31] rounded-lg px-6 py-6 flex items-center justify-between no-underline hover:bg-[#064e3b]">
          <span class="text-white text-[20px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">Jumlah Keterima</span>
          <span class="text-white text-[30px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">{{ $totalKeterima }}</span>
        </a>
        <a href="{{ route('scores.index', ['status' => 'tidak_lulus']) }}" class="flex-1 bg-[#005b31] rounded-lg px-6 py-6 flex items-center justify-between no-underline hover:bg-[#064e3b]">
          <span class="text-white text-[20px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">Jumlah Ketolak</span>
          <span class="text-white text-[30px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">{{ $totalTidakKeterima }}</span>
        </a>
      </div>

      <!-- Stats Row 2 -->
      <div class="flex gap-6 max-[900px]:flex-col">
        <a href="{{ route('tata_usaha.content') }}" class="flex-1 bg-[#005b31] rounded-lg px-6 py-8 flex items-center justify-between no-underline hover:bg-[#064e3b]">
          <span class="text-white text-[20px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">Program Kelas Dibuka</span>
          <span class="text-white text-[40px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">{{ str_pad($programKelasDibuka, 2, '0', STR_PAD_LEFT) }}</span>
        </a>
        <a href="{{ route('scores.index', ['status' => 'belum_konfirmasi']) }}" class="flex-1 bg-[#005b31] rounded-lg px-6 py-8 flex items-center justify-between no-underline hover:bg-[#064e3b]">
          <span class="text-white text-[20px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">Jumlah Tidak Konfirmasi</span>
          <span class="text-white text-[40px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">{{ $totalTidakKonfirmasi }}</span>
        </a>
      </div>

      <!-- Recent Applicants Table -->
      <div class="bg-white border border-[#bec9be] rounded-xl overflow-hidden mb-10">
        <div class="bg-[#eff4ff] grid grid-cols-5 gap-4 px-6 py-4 max-[900px]:hidden">
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">No Pendaftar</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Nama Lengkap</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">NISN</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Jenis Kelamin</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Program</div>
        </div>

        <div class="flex flex-col gap-4 p-6">
          @forelse($recentApplicants as $item)
            <div class="border border-[#bec9be] rounded-lg p-6 grid grid-cols-5 gap-4 items-center max-[900px]:grid-cols-1 max-[900px]:gap-2">
              <div class="text-[#181c1c] text-[14px] font-bold">PMBM-2026-{{ str_pad($item->id_pendaftaran, 2, '0', STR_PAD_LEFT) }}</div>
              <div class="text-[#181c1c] text-[16px] font-bold uppercase">{{ $item->calonMurid->nama_murid }}</div>
              <div class="text-[#3f4941] text-[14px]">{{ $item->calonMurid->nisn }}</div>
              <div class="text-[#3f4941] text-[14px] uppercase">{{ $item->calonMurid->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
              <div class="flex items-center justify-between gap-3">
                <span class="bg-[#ffdcc3] text-[#2f1500] text-[10px] uppercase px-3 py-1 rounded-full">{{ $item->program->nama_program ?? '-' }}</span>
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

      <!-- Charts Grid -->
      <div class="flex flex-row gap-6 items-stretch mb-10 max-[900px]:flex-col">
        <div class="flex-1 bg-white border border-[#becabe] rounded-xl p-8 flex flex-col gap-8">
          <div class="text-[#121c2a] text-[20px] font-semibold" style="font-family: 'PlusJakartaSans-SemiBold', sans-serif;">Jumlah Pendaftar Per Tahun</div>
          <div class="border-b border-[#becabe] h-[200px] flex flex-row gap-3 items-end pb-6 w-full">
            @foreach($charts['pendaftar'] as $year => $count)
              <div class="flex flex-col gap-2 items-center">
                <div class="bg-[#005b31] w-10 rounded-t" style="height: {{ ($count / max(max(array_values($charts['pendaftar'])), 1)) * 100 }}px;"></div>
                <div class="text-[#121c2a] text-[12px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">{{ $year }}</div>
                <div class="text-[10px] font-bold text-gray-500">{{ $count }}</div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="flex-1 bg-white border border-[#becabe] rounded-xl p-8 flex flex-col gap-8">
          <div class="text-[#121c2a] text-[20px] font-semibold" style="font-family: 'PlusJakartaSans-SemiBold', sans-serif;">Jumlah Keterima Per Tahun</div>
          <div class="border-b border-[#becabe] h-[200px] flex flex-row gap-3 items-end pb-6 w-full">
            @foreach($charts['keterima'] as $year => $count)
              <div class="flex flex-col gap-2 items-center">
                <div class="bg-[#064e3b] w-10 rounded-t" style="height: {{ ($count / max(max(array_values($charts['keterima'])), 1)) * 100 }}px;"></div>
                <div class="text-[#121c2a] text-[12px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">{{ $year }}</div>
                <div class="text-[10px] font-bold text-gray-500">{{ $count }}</div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
