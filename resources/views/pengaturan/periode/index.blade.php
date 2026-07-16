@extends('layouts.admin')

@section('title', 'Kelola Data Periode - Admin Portal')

@section('content')
  <div class="relative min-h-screen flow-root">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'periode'])

    <!-- Content Wrapper -->
    <div class="absolute left-[380px] top-[138px] right-10 flex flex-col gap-6 z-0 max-[1024px]:left-5 max-[1024px]:right-5 max-[1024px]:top-[150px]">

      <!-- Page Header -->
      <div class="flex flex-col gap-1">
        <div class="text-[#181c1c] text-[28px] font-bold tracking-[-0.56px]" style="font-family: 'Manrope-Bold', sans-serif;">Kelola Data Periode</div>
        <div class="text-[#3f4941] text-[14px]">Daftar Periode Pendaftaran</div>
      </div>

      @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-300 text-emerald-700 text-[13px] rounded-md p-3 font-bold">
          {{ session('success') }}
        </div>
      @endif

      <!-- Filter + Add Button -->
      <form action="{{ route('tata_usaha.periode.index') }}" method="GET" class="flex items-end gap-4 max-[700px]:flex-col max-[700px]:items-stretch">
        <div class="flex-1 bg-white border border-[#bec9be] rounded-lg shadow-[0_1px_1px_rgba(0,0,0,0.05)] px-[17px] pt-[22px] pb-[17px] flex flex-col gap-2.5">
          <label class="text-[#3f4941] text-[12px] font-bold">Daftar Periode Pendaftaran</label>
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Berdasarkan Periode"
                 class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none w-full max-w-[528px]"
                 onchange="this.form.submit()">
        </div>
        <a href="{{ route('tata_usaha.periode.create') }}" class="bg-[#006a3c] text-white text-[16px] px-6 py-2 rounded no-underline hover:bg-[#064e3b] shrink-0 h-fit">Tambah</a>
      </form>

      <!-- Periode Table -->
      <div class="bg-white border border-[#bec9be] rounded-xl overflow-hidden mb-10">
        <div class="bg-[#eff4ff] grid grid-cols-7 gap-4 px-6 py-4 max-[900px]:hidden">
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Periode</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Judul Utama</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Tanggal Mulai-Berakhir</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Program Dibuka</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Status</div>
          <div class="text-black text-[12px] font-medium tracking-[1.2px] uppercase">Aksi</div>
          <div></div>
        </div>

        <div class="flex flex-col gap-4 p-6">
          @forelse($periodes as $periode)
            <div class="border border-[#bec9be] rounded-lg p-6 grid grid-cols-7 gap-4 items-center max-[900px]:grid-cols-1 max-[900px]:gap-2">
              <div class="text-[#181c1c] text-[14px] font-bold">{{ $periode->tahun }}</div>
              <div class="text-[#181c1c] text-[13px] font-medium">{{ $periode->judul }}</div>
              <div class="text-[#3f4941] text-[10px]">
                {{ \Carbon\Carbon::parse($periode->tanggal_mulai)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($periode->tanggal_selesai)->translatedFormat('d M') }}
              </div>
              <div class="text-[#3f4941] text-[14px]">{{ $periode->jumlah_program }}</div>
              <div class="{{ $periode->status === 'aktif' ? 'text-[#006b24]' : 'text-[#3f4940]' }} text-[14px] font-medium">
                {{ $periode->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
              </div>
              <div class="flex items-center gap-3 flex-wrap">
                <a href="{{ route('tata_usaha.periode.edit', $periode->id) }}" class="border border-[#005b31]/20 text-[#005b31] text-[12px] font-medium px-4 py-1.5 rounded-lg no-underline">Edit</a>
                <form action="{{ route('tata_usaha.periode.destroy', $periode->id) }}" method="POST" onsubmit="return confirm('Hapus periode ini?')">
                  @csrf
                  <button type="submit" class="border border-[#ba1a1a]/20 text-[#ba1a1a] text-[12px] font-medium px-4 py-1.5 rounded-lg cursor-pointer bg-white">Hapus</button>
                </form>
              </div>
              <div class="flex justify-end">
                <a href="{{ route('scores.index', ['tahun' => $periode->tahun]) }}" class="bg-[#006a3c] text-white text-[16px] px-6 py-2 rounded no-underline hover:bg-[#064e3b]">Detail</a>
              </div>
            </div>
          @empty
            <div class="text-center text-gray-500 py-10">
              Belum ada data periode pendaftaran.
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
@endsection
