@extends('layouts.panitia')

@section('title', 'Keterangan Wawancara - Penguji PMBM')

@section('content')
  <div class="relative min-h-screen bg-slate-50/10 antialiased pb-12">
    
    <!-- SIDEBAR KIRI SESUAI GAMBAR FIGMA KEDUA -->
    <aside class="fixed top-0 left-0 bottom-0 w-[260px] bg-white border-r border-slate-200/60 flex flex-col justify-between p-6 shadow-sm z-50 max-[1024px]:w-[220px] max-[768px]:hidden transition-all">
      <div class="flex flex-col gap-6">
        <div class="flex items-center gap-3 px-2 py-2">
          <div class="bg-emerald-800 rounded-lg p-2 shrink-0">
            <span class="text-white text-lg">🏫</span>
          </div>
          <span class="text-slate-900 font-bold tracking-tight text-sm font-sans leading-tight">Panitia Penilaian</span>
        </div>

        <nav class="flex flex-col gap-1 mt-4">
          <a href="{{ route('panitia.dashboard') }}" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-xl text-sm font-bold no-underline font-sans transition-all">
            Penilaian
          </a>
          <a href="#" class="flex items-center px-4 py-3 bg-emerald-900 text-white rounded-xl text-sm font-bold shadow-sm no-underline font-sans transition-all mt-1">
            Keterangan wawancara
          </a>
        </nav>
      </div>

      <button onclick="event.preventDefault(); document.getElementById('panitia-logout-form').submit();" 
              class="w-full flex items-center justify-start px-4 py-3 text-rose-600 hover:bg-rose-50 rounded-xl text-sm font-bold transition-all no-underline font-sans">
        Logout
      </button>
    </aside>

    <form id="panitia-logout-form" action="{{ route('panitia.logout') }}" method="POST" class="hidden">
      @csrf
    </form>

    <!-- MAIN CONTENT AREA -->
    <div class="relative pt-8 pb-12 pr-6 pl-[280px] max-[1024px]:pl-[240px] max-[1024px]:pr-6 flex flex-col gap-6 max-[768px]:pt-20 max-[768px]:px-4 w-full transition-all">
      
      <!-- Top Title Bar -->
      <div class="flex justify-between items-center w-full border-b border-slate-200/40 pb-4">
        <h1 class="text-slate-900 text-lg font-bold font-sans">Penilaian</h1>
        <div class="flex flex-col items-end text-right">
          <span class="text-slate-900 text-sm font-bold font-sans">Admin Portal</span>
          <span class="text-slate-400 text-[11px] font-medium font-sans">Super Admin</span>
        </div>
      </div>

      <!-- Stats Summary Row Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 w-full">
        <div class="bg-rose-50 border border-rose-100 rounded-xl p-4 flex justify-between items-center">
          <div>
            <span class="text-slate-400 text-[11px] font-semibold block">Total Pendaftar</span>
            <span class="text-slate-800 text-xl font-bold mt-1 block">124</span>
          </div>
          <span class="text-lg bg-white p-2 rounded-lg shadow-sm">👥</span>
        </div>
        <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 flex justify-between items-center">
          <div>
            <span class="text-slate-400 text-[11px] font-semibold block">Lulus Seleksi</span>
            <span class="text-emerald-700 text-xl font-bold mt-1 block">86</span>
          </div>
          <span class="text-lg bg-white p-2 rounded-lg shadow-sm">✓</span>
        </div>
        <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 flex justify-between items-center">
          <div>
            <span class="text-slate-400 text-[11px] font-semibold block">Cadangan</span>
            <span class="text-amber-700 text-xl font-bold mt-1 block">24</span>
          </div>
          <span class="text-lg bg-white p-2 rounded-lg shadow-sm">📋</span>
        </div>
        <div class="bg-rose-50 border border-rose-100 rounded-xl p-4 flex justify-between items-center">
          <div>
            <span class="text-slate-400 text-[11px] font-semibold block">Tidak Lulus</span>
            <span class="text-rose-700 text-xl font-bold mt-1 block">14</span>
          </div>
          <span class="text-lg bg-white p-2 rounded-lg shadow-sm">✕</span>
        </div>
      </div>

      <!-- Data Table Layout Area with Live Search -->
      <div class="bg-white border border-slate-200/60 rounded-xl shadow-sm overflow-hidden w-full mt-2" x-data="{ search: '' }">
        
        <!-- Header Filter & Live Search Bar Component -->
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between gap-4 flex-wrap">
          <div class="relative flex-1 min-w-[260px] max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
              </svg>
            </div>
            <input type="text" 
                   x-model="search" 
                   placeholder="Cari nama siswa atau No. Pendaftar..." 
                   class="w-full pl-10 pr-4 py-2 text-xs text-slate-800 bg-white border border-slate-200 rounded-lg outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition-all shadow-sm">
            
            <!-- Clear Button -->
            <button x-show="search.length > 0" 
                    @click="search = ''" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 text-xs font-bold">
              ✕
            </button>
          </div>

          <div class="text-xs text-slate-400 font-medium">
            Ketik kata kunci untuk filter rekapitulasi
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full border-collapse text-left text-xs whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
              <tr>
                <th scope="col" class="py-3.5 px-4">No Pendaftar</th>
                <th scope="col" class="py-3.5 px-4">Nama Lengkap</th>
                <th scope="col" class="py-3.5 px-4 text-center">Komitmen</th>
                <th scope="col" class="py-3.5 px-4 text-center">Dukungan</th>
                <th scope="col" class="py-3.5 px-4 text-center">Visi Misi</th>
                <th scope="col" class="py-3.5 px-4 text-center">Status</th>
                <th scope="col" class="py-3.5 px-4 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
              @forelse($students as $index => $student)
                @php
                  $searchHaystack = strtolower(
                    'PMBM-2026-0' . ($index + 1) . ' ' . 
                    ($student->calonMurid->nama_murid ?? '')
                  );
                @endphp
                <tr class="hover:bg-slate-50/50 transition-colors"
                    x-data="{ deleted: false }"
                    x-show="!deleted && (search === '' || '{{ $searchHaystack }}'.includes(search.toLowerCase()))">
                  <td class="py-4 px-4 font-bold text-slate-900">
                    PMBM-2026-0{{ $index + 1 }}
                  </td>
                  <td class="py-4 px-4 font-bold text-slate-800 uppercase">
                    {{ $student->calonMurid->nama_murid }}
                  </td>
                  <td class="py-4 px-4 text-center text-slate-500">
                    {{ $student->wawancaraOrtu->komitmen ?? 'Setuju' }}
                  </td>
                  <td class="py-4 px-4 text-center text-slate-500">
                    {{ $student->wawancaraOrtu->dukungan ?? 'Setuju' }}
                  </td>
                  <td class="py-4 px-4 text-center text-slate-500">
                    {{ $student->wawancaraOrtu->visimisi ?? 'Setuju' }}
                  </td>
                  <td class="py-4 px-4 text-center">
                    @if(($student->wawancaraOrtu->status_lulus ?? 'LULUS') === 'LULUS')
                      <span class="px-2.5 py-0.5 rounded text-[9px] font-extrabold bg-green-100 text-green-700 tracking-wide uppercase">Lulus</span>
                    @elseif(($student->wawancaraOrtu->status_lulus ?? 'LULUS') === 'CADANGAN')
                      <span class="px-2.5 py-0.5 rounded text-[9px] font-extrabold bg-amber-600 text-white tracking-wide uppercase">Cadangan</span>
                    @else
                      <span class="px-2.5 py-0.5 rounded text-[9px] font-extrabold bg-rose-700 text-white tracking-wide uppercase">Tidak Lulus</span>
                    @endif
                  </td>
                  <td class="py-4 px-4 text-center flex items-center justify-center gap-2">
                    <a href="{{ route('panitia.detail.wawancara', $student->id_pendaftaran) }}" class="bg-white border border-slate-200 text-slate-600 px-3 py-1 rounded font-semibold text-[10px] hover:bg-slate-50 no-underline shadow-sm transition-colors">Edit</a>
                    <button type="button" @click="if(confirm('Apakah Anda yakin ingin menghapus data wawancara ini?')) deleted = true" class="bg-white border border-rose-200 text-rose-600 px-2 py-1 rounded font-semibold text-[10px] hover:bg-rose-50 shadow-sm transition-colors cursor-pointer">Hapus</button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center text-slate-400 py-12 font-medium">Belum ada data rekap wawancara.</td>
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
  <!-- Library Alpine.js untuk fitur Live Search & Hapus Interaktif -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection