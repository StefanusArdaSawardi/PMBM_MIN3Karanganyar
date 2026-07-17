@extends('layouts.admin')

@section('title', 'Kelola Program - Admin Portal')

@section('content')
  <div class="relative min-h-screen flow-root">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'program'])

    <!-- Content Wrapper -->
    <div class="absolute left-[380px] top-[138px] right-10 flex flex-col gap-6 z-0 max-[1024px]:left-5 max-[1024px]:right-5 max-[1024px]:top-[150px]">

      <!-- Page Header -->
      <div class="flex flex-col gap-1">
        <div class="text-[#181c1c] text-[28px] font-bold tracking-[-0.56px]" style="font-family: 'Manrope-Bold', sans-serif;">Kelola Program</div>
        <div class="text-[#3f4941] text-[14px]">Menambahkan data Program</div>
      </div>

      @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-300 text-emerald-700 text-[13px] rounded-md p-3 font-bold">
          {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div class="bg-red-50 border border-red-300 text-red-700 text-[13px] rounded-md p-3 font-bold">
          {{ session('error') }}
        </div>
      @endif

      <div class="bg-white border border-[#becabe] rounded-xl shadow-[0_4px_4px_rgba(0,0,0,0.25)] overflow-hidden mb-10">
        <div class="flex items-center justify-between px-6 py-6">
          <div class="text-black text-[20px]">Kategori Program Studi /Jalur</div>
          <a href="{{ route('tata_usaha.program.create') }}" class="bg-[#005b31] text-white text-[14px] font-semibold tracking-wide px-6 py-2.5 rounded-[10px] no-underline">+ Tambah Program</a>
        </div>

        <div class="bg-[#d9d9d9] grid grid-cols-[1fr_1.3fr_1.3fr_0.6fr] gap-4 px-6 py-4">
          <div class="text-[#3f4940] text-[14px] font-semibold tracking-wide">NAMA PROGRAM</div>
          <div class="text-[#3f4940] text-[14px] font-semibold tracking-wide">TIPE / DESKRIPSI</div>
          <div class="text-[#3f4940] text-[14px] font-semibold tracking-wide">POIN UNGGULAN</div>
          <div class="text-[#3f4940] text-[14px] font-semibold tracking-wide text-center">AKSI</div>
        </div>

        <div class="divide-y divide-gray-100">
          @forelse($programs as $program)
            <div class="grid grid-cols-[1fr_1.3fr_1.3fr_0.6fr] gap-4 px-6 py-5 items-start">
              <div class="text-[#121c2a] text-[14px] font-semibold">{{ $program->nama_program }}</div>
              <div class="text-[#3f4940] text-[14px] leading-snug pr-4">{{ $program->persyaratan }}</div>
              <ul class="list-disc pl-4 text-[12px] text-[#3f4940] leading-relaxed">
                @forelse($program->poin_unggulan ?? [] as $poin)
                  <li>{{ $poin }}</li>
                @empty
                  <li class="text-gray-400 list-none -ml-4">-</li>
                @endforelse
              </ul>
              <div class="flex flex-col gap-2 items-center">
                <a href="{{ route('tata_usaha.program.edit', $program->id_program) }}" class="border border-[#005b31]/20 text-[#005b31] text-[12px] font-medium px-6 py-1.5 rounded-lg bg-white w-full text-center no-underline">Edit</a>
                <form action="{{ route('tata_usaha.program.destroy', $program->id_program) }}" method="POST" onsubmit="return confirm('Hapus program {{ addslashes($program->nama_program) }}?')" class="w-full">
                  @csrf
                  <button type="submit" class="border border-[#ba1a1a]/20 text-[#ba1a1a] text-[12px] font-medium px-4 py-1.5 rounded-lg cursor-pointer bg-white w-full">Hapus</button>
                </form>
              </div>
            </div>
          @empty
            <div class="text-center text-gray-500 py-10">
              Belum ada data program.
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

@endsection
