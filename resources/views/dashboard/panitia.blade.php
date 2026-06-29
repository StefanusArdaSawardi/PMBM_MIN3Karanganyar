@extends('layouts.panitia')

@section('title', 'Antrean Uji Wawancara - Penguji PMBM')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/panitia/queue/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/panitia/queue/style.css') }}">
@endsection

@section('content')
  <div class="relative min-h-screen bg-white flow-root">
    <!-- Panitia Sidebar/Topbar Included -->
    @include('components.sidebar-panitia', ['activeFolder' => 'queue'])

    <div class="relative mt-[156px] mx-[146px] mr-10 flex flex-col gap-6 pb-10 max-[1024px]:mx-6 max-[1024px]:mt-[140px]">
      <!-- Header Page Description -->
      <div class="flex flex-col gap-1 max-w-[576px]">
        <div class="text-[#121c2a] text-[30px] font-bold tracking-[-0.75px]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Antrean Uji Wawancara</div>
        <div class="text-[#3f4940] text-[16px]" style="font-family: 'WorkSans-Regular', sans-serif;">
          Daftar calon siswa yang berstatus pending dan siap diuji hari ini. Pastikan kelengkapan berkas sebelum memulai sesi.
        </div>
      </div>

      <!-- Stats Summary -->
      <div class="flex flex-row gap-6 max-[900px]:flex-col">
        <div class="flex-1 min-w-[200px] bg-white/80 backdrop-blur-[4px] border border-[#005b31] border-l-4 rounded-2xl p-6 flex items-center gap-4">
          <div class="bg-[#0f7643]/20 rounded-xl w-12 h-12 flex items-center justify-center shrink-0">
            <img class="w-[18px] h-[18px]" src="{{ asset('assets/panitia/queue/container1.svg') }}" alt="">
          </div>
          <div class="flex flex-col">
            <div class="text-[#3f4940] text-[12px] font-medium tracking-[0.6px] uppercase" style="font-family: 'WorkSans-Medium', sans-serif;">TELAH DIUJI</div>
            <div class="text-[#121c2a] text-[24px] font-bold" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">{{ $telahDiujiCount }} Siswa</div>
          </div>
        </div>

        <div class="flex-1 min-w-[200px] bg-white/80 backdrop-blur-[4px] border border-[#006e2f] border-l-4 rounded-2xl p-6 flex items-center gap-4">
          <div class="bg-[#6bff8f]/20 rounded-xl w-12 h-12 flex items-center justify-center shrink-0">
            <img class="w-5 h-5" src="{{ asset('assets/panitia/queue/container5.svg') }}" alt="">
          </div>
          <div class="flex flex-col">
            <div class="text-[#3f4940] text-[12px] font-medium tracking-[0.6px] uppercase" style="font-family: 'WorkSans-Medium', sans-serif;">ANTREAN HARI INI</div>
            <div class="text-[#121c2a] text-[24px] font-bold" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">{{ $antreanCount }} Siswa</div>
          </div>
        </div>

        <div class="flex-1 min-w-[200px] bg-white/80 backdrop-blur-[4px] border border-[#185946] border-l-4 rounded-2xl p-6 flex items-center gap-4">
          <div class="bg-[#b0f0d6]/40 rounded-xl w-12 h-12 flex items-center justify-center shrink-0">
            <img class="w-[18px] h-[21px]" src="{{ asset('assets/panitia/queue/container9.svg') }}" alt="">
          </div>
          <div class="flex flex-col">
            <div class="text-[#3f4940] text-[12px] font-medium tracking-[0.6px] uppercase" style="font-family: 'WorkSans-Medium', sans-serif;">RATA-RATA WAKTU</div>
            <div class="text-[#121c2a] text-[24px] font-bold" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">15 Menit</div>
          </div>
        </div>
      </div>

      <!-- Active Queue List -->
      <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] p-6 mb-10 overflow-x-auto">
        <table class="w-full border-collapse text-[13px] min-w-[700px]">
          <thead>
            <tr>
              <th class="text-left p-3 border-b-2 border-gray-100 text-gray-600 font-bold uppercase text-[11px]">No. Reg</th>
              <th class="text-left p-3 border-b-2 border-gray-100 text-gray-600 font-bold uppercase text-[11px]">Nama Calon Siswa</th>
              <th class="text-left p-3 border-b-2 border-gray-100 text-gray-600 font-bold uppercase text-[11px]">NISN</th>
              <th class="text-left p-3 border-b-2 border-gray-100 text-gray-600 font-bold uppercase text-[11px]">Program</th>
              <th class="text-left p-3 border-b-2 border-gray-100 text-gray-600 font-bold uppercase text-[11px]">Status</th>
              <th class="text-left p-3 border-b-2 border-gray-100 text-gray-600 font-bold uppercase text-[11px]">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($queue as $item)
              <tr class="hover:bg-gray-50">
                <td class="p-[15px_12px] border-b border-gray-100 text-gray-800 font-bold">PMB-2026-{{ str_pad($item->id_murid, 3, '0', STR_PAD_LEFT) }}</td>
                <td class="p-[15px_12px] border-b border-gray-100 font-bold text-[#0f7643]">{{ $item->nama_murid }}</td>
                <td class="p-[15px_12px] border-b border-gray-100 text-gray-800">{{ $item->nisn }}</td>
                <td class="p-[15px_12px] border-b border-gray-100 text-gray-800">{{ $item->pendaftaran->program->nama_program ?? 'Umum' }}</td>
                <td class="p-[15px_12px] border-b border-gray-100">
                  @if(isset($item->hasil) && $item->hasil->nilai_wawancara !== null)
                    <span class="px-2 py-1 rounded-full text-[10px] font-bold bg-[#ecfdf5] text-[#047857]">Selesai Uji (Score: {{ $item->hasil->nilai_wawancara }})</span>
                  @else
                    <span class="px-2 py-1 rounded-full text-[10px] font-bold bg-[#fffbeb] text-[#d97706]">Menunggu Uji</span>
                  @endif
                </td>
                <td class="p-[15px_12px] border-b border-gray-100">
                  <a href="{{ route('panitia.detail', $item->id_murid) }}" class="inline-block bg-[#298752] text-white px-4 py-2 rounded-md font-bold no-underline text-[12px] hover:bg-[#064e3b]">
                    @if(isset($item->hasil) && $item->hasil->nilai_wawancara !== null)
                      Ubah Nilai
                    @else
                      Mulai Uji
                    @endif
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-gray-500 py-8">
                  Tidak ada calon siswa dalam antrean uji hari ini.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Footer Component Included -->
    @include('components.footer-panitia', ['isGrading' => false])
  </div>
@endsection
