@extends('layouts.panitia')

@section('title', 'Antrean Uji Wawancara - Penguji PMBM')

@section('content')
  <div class="relative min-h-screen bg-slate-50/50 antialiased">
    <!-- Panitia Sidebar/Topbar Included -->
    @include('components.sidebar-panitia', ['activeFolder' => 'queue'])

    <!-- Main Content Container with responsive padding and layout alignment -->
    <div class="relative pt-[140px] px-6 md:px-12 lg:px-16 xl:pr-10 xl:pl-[280px] flex flex-col gap-6 pb-12">
      
      <!-- Header Page Description -->
      <div class="flex flex-col gap-1.5 max-w-2xl">
        <h1 class="text-[#121c2a] text-2xl md:text-3xl font-bold tracking-tight font-sans">
          Antrean Uji Wawancara
        </h1>
        <p class="text-slate-500 text-sm md:text-base leading-relaxed">
          Daftar calon siswa yang berstatus pending dan siap diuji hari ini. Pastikan kelengkapan berkas sebelum memulai sesi.
        </p>
      </div>

      <!-- Stats Summary Card Section -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <!-- Card 1: Telah Diuji -->
        <div class="bg-white border border-emerald-100 border-l-4 border-l-emerald-600 rounded-xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
          <div class="bg-emerald-50 rounded-xl w-12 h-12 flex items-center justify-center shrink-0">
            <img class="w-[18px] h-[18px] text-emerald-600" src="{{ asset('assets/panitia/queue/container1.svg') }}" alt="Icon Telah Diuji">
          </div>
          <div class="flex flex-col">
            <span class="text-slate-400 text-[11px] font-semibold tracking-wider uppercase">Telah Diuji</span>
            <span class="text-[#121c2a] text-xl font-bold mt-0.5">{{ $telahDiujiCount }} Siswa</span>
          </div>
        </div>

        <!-- Card 2: Antrean Hari Ini -->
        <div class="bg-white border border-green-100 border-l-4 border-l-green-600 rounded-xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
          <div class="bg-green-50 rounded-xl w-12 h-12 flex items-center justify-center shrink-0">
            <img class="w-5 h-5 text-green-600" src="{{ asset('assets/panitia/queue/container5.svg') }}" alt="Icon Antrean">
          </div>
          <div class="flex flex-col">
            <span class="text-slate-400 text-[11px] font-semibold tracking-wider uppercase">Antrean Hari Ini</span>
            <span class="text-[#121c2a] text-xl font-bold mt-0.5">{{ $antreanCount }} Siswa</span>
          </div>
        </div>

        <!-- Card 3: Rata-Rata Waktu -->
        <div class="bg-white border border-teal-100 border-l-4 border-l-teal-600 rounded-xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow sm:col-span-2 lg:col-span-1">
          <div class="bg-teal-50 rounded-xl w-12 h-12 flex items-center justify-center shrink-0">
            <img class="w-[18px] h-[21px]" src="{{ asset('assets/panitia/queue/container9.svg') }}" alt="Icon Waktu">
          </div>
          <div class="flex flex-col">
            <span class="text-slate-400 text-[11px] font-semibold tracking-wider uppercase">Rata-Rata Waktu</span>
            <span class="text-[#121c2a] text-xl font-bold mt-0.5">15 Menit</span>
          </div>
        </div>
      </div>

      <!-- Active Queue List Data Table Card with Live Search Filter -->
      <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden mb-6" x-data="{ search: '' }">
        
        <!-- Header Filter & Search Input Area -->
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between gap-4 flex-wrap">
          <div class="relative flex-1 min-w-[260px] max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
              </svg>
            </div>
            <input type="text" 
                   x-model="search" 
                   placeholder="Cari nama siswa, NISN, atau No. Reg..." 
                   class="w-full pl-10 pr-4 py-2 text-xs text-slate-800 bg-white border border-slate-200 rounded-lg outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition-all shadow-sm">
            
            <!-- Clear Search Button -->
            <button x-show="search.length > 0" 
                    @click="search = ''" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 text-xs font-bold">
              ✕
            </button>
          </div>

          <div class="text-xs text-slate-400 font-medium">
            Ketik kata kunci untuk menyaring daftar
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full border-collapse text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
              <tr>
                <th scope="col" class="py-3.5 px-4 font-semibold">No. Reg</th>
                <th scope="col" class="py-3.5 px-4 font-semibold">Nama Calon Siswa</th>
                <th scope="col" class="py-3.5 px-4 font-semibold">NISN</th>
                <th scope="col" class="py-3.5 px-4 font-semibold">Program</th>
                <th scope="col" class="py-3.5 px-4 font-semibold">Status</th>
                <th scope="col" class="py-3.5 px-4 font-semibold text-center">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
              @forelse($queue as $item)
                @php
                  $searchHaystack = strtolower(
                    'PMB-2026-' . substr($item->id_pendaftaran, 3) . ' ' . 
                    ($item->calonMurid->nama_murid ?? '') . ' ' . 
                    ($item->calonMurid->nisn ?? '')
                  );
                @endphp
                <tr class="hover:bg-slate-50/80 transition-colors duration-150"
                    x-show="search === '' || '{{ $searchHaystack }}'.includes(search.toLowerCase())">
                  <td class="py-4 px-4 font-medium text-slate-900">
                    PMB-2026-{{ substr($item->id_pendaftaran, 3) }}
                  </td>
                  <td class="py-4 px-4 font-semibold text-emerald-700">
                    {{ $item->calonMurid->nama_murid ?? '-' }}
                  </td>
                  <td class="py-4 px-4 text-slate-600">
                    {{ $item->calonMurid->nisn ?? '-' }}
                  </td>
                  <td class="py-4 px-4 text-slate-600">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800">
                      {{ $item->program->nama_program ?? 'Umum' }}
                    </span>
                  </td>
                  <td class="py-4 px-4">
                    @if($role === 'pengawas_ujian')
                      @if(isset($item->nilaiUjian) && $item->nilaiUjian->nilai_hafalan !== null)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                          <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                          Selesai Uji (Hafalan: {{ $item->nilaiUjian->nilai_hafalan }})
                        </span>
                      @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                          <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                          Menunggu Uji
                        </span>
                      @endif
                    @else
                      @if(isset($item->wawancaraAnak) && $item->wawancaraAnak->rekap_wawancara !== null)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                          <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                          Selesai Wawancara
                        </span>
                      @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                          <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                          Menunggu Wawancara
                        </span>
                      @endif
                    @endif
                  </td>
                  <td class="py-4 px-4 text-center">
                    @if($role === 'pengawas_ujian')
                      <a href="{{ route('panitia.detail.ujian', $item->id_pendaftaran) }}" class="inline-flex items-center justify-center bg-emerald-600 text-white px-3.5 py-1.5 rounded-lg font-semibold text-xs transition-colors duration-150 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1 no-underline">
                        @if(isset($item->nilaiUjian) && $item->nilaiUjian->nilai_hafalan !== null)
                          Ubah Nilai
                        @else
                          Mulai Uji
                        @endif
                      </a>
                    @else
                      <a href="{{ route('panitia.detail.wawancara', $item->id_pendaftaran) }}" class="inline-flex items-center justify-center bg-emerald-600 text-white px-3.5 py-1.5 rounded-lg font-semibold text-xs transition-colors duration-150 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1 no-underline">
                        @if(isset($item->wawancaraAnak) && $item->wawancaraAnak->rekap_wawancara !== null)
                          Ubah Wawancara
                        @else
                          Mulai Wawancara
                        @endif
                      </a>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center text-slate-400 py-12 font-medium">
                    Tidak ada calon siswa dalam antrean uji hari ini.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
@endsection

@section('styles')
  <!-- Library Alpine.js untuk fitur Live Search tanpa reload -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection