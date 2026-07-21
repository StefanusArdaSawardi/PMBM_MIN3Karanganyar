@extends('layouts.panitia')

@section('title', 'Penilaian Wawancara - Penguji PMBM')

@section('content')
  <div class="relative min-h-screen bg-slate-50/10 antialiased pb-12">
    
    <!-- Panitia Sidebar Included -->
    @include('components.sidebar-panitia', ['activeFolder' => 'queue'])

    <!-- MAIN CONTENT CONTAINER (Shifted Right) -->
    <div class="relative pt-8 pb-12 pr-6 pl-[280px] max-[1024px]:pl-[240px] max-[1024px]:pr-6 flex flex-col gap-6 max-[768px]:pt-20 max-[768px]:px-4 w-full transition-all">
      
      <!-- Top Header Description Area -->
      <div class="flex justify-between items-center w-full border-b border-slate-200/40 pb-4">
        <h1 class="text-slate-900 text-lg font-bold font-sans">Penilaian Wawancara</h1>
        <div class="flex flex-col items-end text-right">
          <span class="text-slate-900 text-sm font-bold font-sans">
            {{ auth()->guard('panitia')->user()->nama_panitia ?? 'Panitia PMBM' }}
          </span>
          <span class="text-slate-400 text-[11px] font-semibold tracking-wide uppercase font-sans">
            {{ str_replace('_', ' ', auth()->guard('panitia')->user()->role_panitia ?? 'PETUGAS WAWANCARA') }}
          </span>
        </div>
      </div>
      
      <!-- Student Profile Card Box -->
      <div class="bg-white/80 backdrop-blur-md border border-slate-200/60 rounded-2xl p-6 flex flex-row justify-between items-center gap-4 shadow-sm w-full">
        <div class="flex items-center gap-4">
          <div class="bg-emerald-100 rounded-full w-14 h-14 flex items-center justify-center text-emerald-700 shrink-0 shadow-inner">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
            </svg>
          </div>
          <div class="flex flex-col min-w-0">
            <h2 class="text-slate-900 text-lg font-bold font-sans">{{ $pendaftaran->calonMurid->nama_murid }}</h2>
            <p class="text-slate-400 text-xs font-medium font-sans mt-0.5">
              Nomor Peserta: REG-2024-089
            </p>
          </div>
        </div>
        
        <div class="flex flex-col items-end text-right gap-1 shrink-0">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-900 text-white tracking-wide font-sans">
            Sesi 01 - Ruang A
          </span>
          <span class="text-slate-400 text-[11px] font-medium font-sans mt-1">
            12 Oktober 2024
          </span>
        </div>
      </div>

      <!-- Grid Split Layout (Form Content vs Widgets) -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start w-full">
        
        <!-- Left Side Form Area -->
        <form action="{{ route('panitia.grading.wawancara', $pendaftaran->id_pendaftaran) }}" method="POST" class="lg:col-span-2 flex flex-col gap-6">
          @csrf

          <!-- Instrument Selection Box -->
          <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 flex flex-col gap-6">
            <div class="flex items-center gap-2 text-slate-500 text-xs font-bold tracking-wide uppercase border-b border-slate-100 pb-3">
              <span>📋 Instrumen Penilaian Orang Tua</span>
            </div>

            <!-- Block 1: Komitmen Orang Tua -->
            <div class="flex flex-col gap-2" x-data="{ selected: 'setuju' }">
              <input type="hidden" name="komitmen_status" :value="selected">
              <h4 class="text-slate-900 text-sm font-bold font-sans">Komitmen Orang Tua</h4>
              <p class="text-slate-400 text-xs font-sans">Sejauh mana kesediaan orang tua dalam mendukung proses belajar dan peraturan.</p>
              <div class="flex items-center gap-3 mt-1">
                <button type="button" @click="selected = 'setuju'" :class="selected === 'setuju' ? 'bg-emerald-900 text-white' : 'bg-slate-100 text-slate-600'" class="px-5 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">Setuju</button>
                <button type="button" @click="selected = 'tidak'" :class="selected === 'tidak' ? 'bg-slate-300 text-slate-700' : 'bg-slate-100 text-slate-400'" class="px-5 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">Tidak</button>
              </div>
            </div>

            <!-- Block 2: Dukungan Fasilitas -->
            <div class="flex flex-col gap-2 pt-2 border-t border-slate-100" x-data="{ selected: 'setuju' }">
              <input type="hidden" name="fasilitas_status" :value="selected">
              <h4 class="text-slate-900 text-sm font-bold font-sans">Dukungan Fasilitas</h4>
              <p class="text-slate-400 text-xs font-sans">Ketersediaan sarana pendukung Fasilitas</p>
              <div class="flex items-center gap-3 mt-1">
                <button type="button" @click="selected = 'setuju'" :class="selected === 'setuju' ? 'bg-emerald-900 text-white' : 'bg-slate-100 text-slate-600'" class="px-5 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">Setuju</button>
                <button type="button" @click="selected = 'tidak'" :class="selected === 'tidak' ? 'bg-slate-300 text-slate-700' : 'bg-slate-100 text-slate-400'" class="px-5 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">Tidak</button>
              </div>
            </div>

            <!-- Block 3: Visi Misi Keluarga -->
            <div class="flex flex-col gap-2 pt-2 border-t border-slate-100" x-data="{ selected: 'setuju' }">
              <input type="hidden" name="visimisi_status" :value="selected">
              <h4 class="text-slate-900 text-sm font-bold font-sans">Visi Misi Keluarga</h4>
              <p class="text-slate-400 text-xs font-sans">Keselarasan nilai-nilai keluarga dengan visi misi pengembangan karakter Anak+</p>
              <div class="flex items-center gap-3 mt-1">
                <button type="button" @click="selected = 'setuju'" :class="selected === 'setuju' ? 'bg-emerald-900 text-white' : 'bg-slate-100 text-slate-600'" class="px-5 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">Setuju</button>
                <button type="button" @click="selected = 'tidak'" :class="selected === 'tidak' ? 'bg-slate-300 text-slate-700' : 'bg-slate-100 text-slate-400'" class="px-5 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">Tidak</button>
              </div>
            </div>
          </div>

          <!-- Card Component: Observation Textarea Area -->
          <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 flex flex-col gap-3">
            <div class="flex items-center gap-2 text-slate-700 text-xs font-bold tracking-wide uppercase">
              <span>📝 Catatan Khusus Wawancara</span>
            </div>
            <textarea name="komitmen_ortu" rows="4" required
                      placeholder="Tuliskan detail pengamatan, temuan unik, atau rekomendasi spesifik berdasarkan hasil wawancara dengan orang tua..."
                      class="w-full px-4 py-3.5 text-sm text-slate-800 border border-slate-200 rounded-xl bg-slate-50/70 outline-none focus:border-emerald-500 focus:bg-white transition-all resize-none shadow-inner">{{ $pendaftaran->wawancaraOrtu->komitmen_ortu ?? '' }}</textarea>
            
            <!-- Fallback bridge data hidden parameters to fit existing controller structures -->
            <input type="hidden" name="wawancara_aism" value="-">
            <input type="hidden" name="wawancara_irqa" value="-">
            <input type="hidden" name="wawancara_calistung" value="-">
            <input type="hidden" name="wawancara_dikte" value="-">
            <input type="hidden" name="wawancara_kemandirian" value="-">
            <input type="hidden" name="rekap_wawancara" value="-">
            <input type="hidden" name="nilai_aism" value="100">
            <input type="hidden" name="nilai_dikte" value="100">
            <input type="hidden" name="nilai_kemandirian" value="100">

            <div class="flex justify-end mt-2">
              <button type="submit" class="bg-emerald-900 text-white rounded-xl px-7 py-2.5 flex items-center justify-center gap-2 font-bold text-sm hover:bg-emerald-950 transition-all cursor-pointer font-sans">
                <span>Simpan</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
              </button>
            </div>
          </div>
        </form>

        <!-- Right Side Panel Component Blocks -->
        <div class="flex flex-col gap-6 w-full">
          
          <!-- Box 1: Ringkasan Nilai Widget -->
          <div class="bg-emerald-950 text-white rounded-2xl p-5 shadow-md flex flex-col gap-5">
            <h3 class="text-base font-bold tracking-tight font-sans">Ringkasan Nilai</h3>
            <div class="flex flex-col gap-2.5 text-xs text-slate-300 font-sans">
              <div class="flex justify-between border-b border-white/10 pb-2">
                <span>KELENGKAPAN</span>
                <span class="font-bold text-emerald-400">100% Terisi</span>
              </div>
              <div class="flex justify-between items-center pt-1">
                <span>PEWAWANCARA</span>
                <span class="font-bold text-white truncate max-w-[130px]">Bpk. Ahmad Suherman</span>
              </div>
            </div>
            
            <div class="flex flex-col gap-2.5 mt-2">
              <button type="button" class="w-full bg-emerald-400 text-emerald-950 font-bold py-2.5 rounded-xl text-xs hover:bg-emerald-300 transition-colors shadow-sm flex items-center justify-center gap-1">
                 Simpan Penilaian
              </button>
              <button type="button" class="w-full bg-transparent text-white border border-white/20 font-semibold py-2.5 rounded-xl text-xs hover:bg-white/5 transition-colors flex items-center justify-center gap-1">
                 Cetak Draft
              </button>
            </div>

            <div class="bg-white/5 rounded-xl p-3 flex gap-2 border border-white/5 mt-1">
              <span class="text-emerald-400 text-sm mt-0.5">ⓘ</span>
              <p class="text-[10px] text-slate-400 leading-normal">
                Pastikan seluruh instrumen telah terverifikasi sebelum menekan tombol simpan. Data yang sudah dikunci hanya dapat diubah melalui admin.
              </p>
            </div>
          </div>

          <!-- Box 2: Informasi Orang Tua Info Block -->
          <div class="bg-rose-50 border border-rose-100 rounded-2xl p-5 shadow-sm flex flex-col gap-4">
            <h3 class="text-slate-900 text-xs font-bold tracking-wider uppercase font-sans">Informasi Orang Tua</h3>
            <div class="flex flex-col gap-3.5 text-xs text-slate-700 font-sans">
              <div class="flex gap-3">
                <span class="text-sm"></span>
                <div class="flex flex-col">
                  <span class="text-[10px] text-slate-400 font-medium">Nama Ayah/Wali</span>
                  <span class="font-bold text-slate-950 mt-0.5">Suryadi Wulandari</span>
                </div>
              </div>
              <div class="flex gap-3 border-t border-rose-200/40 pt-2.5">
                <span class="text-sm"></span>
                <div class="flex flex-col">
                  <span class="text-[10px] text-slate-400 font-medium">Pekerjaan</span>
                  <span class="font-bold text-slate-950 mt-0.5">Pegawai Negeri Sipil</span>
                </div>
              </div>
              <div class="flex gap-3 border-t border-rose-200/40 pt-2.5">
                <span class="text-sm"></span>
                <div class="flex flex-col">
                  <span class="text-[10px] text-slate-400 font-medium">Kontak Darurat</span>
                  <span class="font-bold text-slate-950 mt-0.5">+62 812-3456-7890</span>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

    </div>
  </div>
@endsection

@section('styles')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection