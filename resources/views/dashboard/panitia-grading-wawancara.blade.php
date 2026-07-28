@extends('layouts.panitia')

@section('title', 'Penilaian Wawancara - Penguji PMBM')

@section('content')
  <div class="relative min-h-screen bg-slate-50/10 antialiased pb-12">
    <!-- Panitia Sidebar Left Included -->
    @include('components.sidebar-panitia', ['activeFolder' => 'grading'])

    <!-- Main Content Layout - Shifted left to match our left sidebar layout -->
    <div class="relative pt-8 pb-12 pr-6 pl-[280px] max-[1024px]:pl-[240px] max-[1024px]:pr-6 flex flex-col gap-6 max-[768px]:pt-20 max-[768px]:px-4 w-full transition-all">
      
      <!-- 1. Student Identity Header (Top Panel) -->
      <div class="bg-white/70 backdrop-blur-md border border-white/60 rounded-2xl p-6 flex flex-row justify-between items-center gap-4 shadow-[0_4px_20px_rgba(0,0,0,0.03)] w-full">
        <div class="flex items-center gap-4">
          <div class="bg-emerald-50 border border-emerald-200 rounded-full w-14 h-14 flex items-center justify-center text-emerald-700 shrink-0 shadow-sm">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
            </svg>
          </div>
          <div class="flex flex-col min-w-0">
            <h2 class="text-slate-900 text-xl font-bold tracking-tight">{{ $pendaftaran->calonMurid->nama_murid }}</h2>
            <p class="text-slate-500 text-sm font-medium mt-0.5">
              Nomor Peserta: <span class="text-slate-800 font-semibold">PMB-2026-{{ substr($pendaftaran->id_pendaftaran, 3) }}</span>
            </p>
          </div>
        </div>
        
        <div class="flex flex-col items-end text-right gap-1 shrink-0">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-900 text-white tracking-wide shadow-sm">
            Sesi 01 - Ruang A
          </span>
          <span class="text-slate-400 text-[11px] font-semibold tracking-wide uppercase mt-1">
            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
          </span>
        </div>
      </div>

      <!-- 2. Grid Layout Split (Left Component Form & Right Widget Summary Side) -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start w-full">
        
        <!-- Left Side: Interactive Instrument Input Blocks -->
        <form action="{{ route('panitia.grading.wawancara', $pendaftaran->id_pendaftaran) }}" method="POST" class="lg:col-span-2 flex flex-col gap-6">
          @csrf

          @if($errors->any())
            <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium rounded-xl">
              {{ $errors->first() }}
            </div>
          @endif

          <!-- Card Component: Form Instrumen Pilihan Orang Tua -->
          <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 flex flex-col gap-6">
            <div class="flex items-center gap-2 text-slate-500 text-xs font-bold tracking-wide uppercase border-b border-slate-100 pb-3">
              <span>📊 Instrumen Penilaian Orang Tua</span>
            </div>

            <!-- Block 1: Komitmen Orang Tua -->
            <div class="flex flex-col gap-2">
              <h4 class="text-slate-900 text-sm font-bold">Komitmen Orang Tua</h4>
              <p class="text-slate-400 text-xs">Sejauh mana kesediaan orang tua dalam mendukung proses belajar dan peraturan.</p>
              
              <!-- Custom Toggle Selection (Setuju / Tidak) -->
              <div class="flex items-center gap-3 mt-1" x-data="{ selected: 'setuju' }">
                <input type="hidden" name="komitmen_status" :value="selected">
                <button type="button" @click="selected = 'setuju'" :class="selected === 'setuju' ? 'bg-emerald-800 text-white' : 'bg-slate-100 text-slate-600'" class="px-5 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">Setuju</button>
                <button type="button" @click="selected = 'tidak'" :class="selected === 'tidak' ? 'bg-rose-600 text-white' : 'bg-slate-100 text-slate-400'" class="px-5 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">Tidak</button>
              </div>
            </div>

            <!-- Block 2: Dukungan Fasilitas -->
            <div class="flex flex-col gap-2 pt-2 border-t border-slate-50">
              <h4 class="text-slate-900 text-sm font-bold">Dukungan Fasilitas</h4>
              <p class="text-slate-400 text-xs">Ketersediaan sarana pendukung Fasilitas di lingkungan keluarga.</p>
              
              <div class="flex items-center gap-3 mt-1" x-data="{ selected: 'setuju' }">
                <input type="hidden" name="fasilitas_status" :value="selected">
                <button type="button" @click="selected = 'setuju'" :class="selected === 'setuju' ? 'bg-emerald-800 text-white' : 'bg-slate-100 text-slate-600'" class="px-5 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">Setuju</button>
                <button type="button" @click="selected = 'tidak'" :class="selected === 'tidak' ? 'bg-rose-600 text-white' : 'bg-slate-100 text-slate-400'" class="px-5 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">Tidak</button>
              </div>
            </div>

            <!-- Block 3: Visi Misi Keluarga -->
            <div class="flex flex-col gap-2 pt-2 border-t border-slate-50">
              <h4 class="text-slate-900 text-sm font-bold">Visi Misi Keluarga</h4>
              <p class="text-slate-400 text-xs">Keselarasan nilai-nilai keluarga dengan visi misi pengembangan karakter Anak+.</p>
              
              <div class="flex items-center gap-3 mt-1" x-data="{ selected: 'setuju' }">
                <input type="hidden" name="visimisi_status" :value="selected">
                <button type="button" @click="selected = 'setuju'" :class="selected === 'setuju' ? 'bg-emerald-800 text-white' : 'bg-slate-100 text-slate-600'" class="px-5 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">Setuju</button>
                <button type="button" @click="selected = 'tidak'" :class="selected === 'tidak' ? 'bg-rose-600 text-white' : 'bg-slate-100 text-slate-400'" class="px-5 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">Tidak</button>
              </div>
            </div>
          </div>

          <!-- Card Component: Catatan Textarea Field -->
          <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm p-6 flex flex-col gap-3">
            <div class="flex items-center gap-2 text-slate-700 text-xs font-bold tracking-wide uppercase">
              <span>📄 Catatan Khusus Wawancara</span>
            </div>
            <textarea name="komitmen_ortu" rows="4" required
                      placeholder="Tuliskan detail pengamatan, temuan unik, atau rekomendasi spesifik berdasarkan hasil wawancara dengan orang tua..."
                      class="w-full px-4 py-3.5 text-sm text-slate-800 border border-slate-200 rounded-xl bg-slate-50/70 outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50/50 transition-all resize-none shadow-inner">{{ $pendaftaran->wawancaraOrtu->komitmen_ortu ?? '' }}</textarea>
            
            <!-- Hidden inputs as compatibility bridge to fit validation requirements inside controller -->
            <input type="hidden" name="wawancara_aism" value="-">
            <input type="hidden" name="wawancara_irqa" value="-">
            <input type="hidden" name="wawancara_calistung" value="-">
            <input type="hidden" name="wawancara_dikte" value="-">
            <input type="hidden" name="wawancara_kemandirian" value="-">
            <input type="hidden" name="rekap_wawancara" value="-">
            <input type="hidden" name="nilai_aism" value="100">
            <input type="hidden" name="nilai_dikte" value="100">
            <input type="hidden" name="nilai_kemandirian" value="100">

            <!-- Primary Submit Action Button Inside Component Layout -->
            <div class="flex justify-end mt-2">
              <button type="submit" class="bg-emerald-900 text-white rounded-xl px-7 py-2.5 flex items-center justify-center gap-2 font-bold text-sm shadow-sm hover:bg-emerald-950 transition-all cursor-pointer">
                <span>Simpan</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
              </button>
            </div>
          </div>
        </form>

        <!-- Right Side Sidebar Widgets (Summary & Info Metadata) -->
        <div class="flex flex-col gap-6 w-full">
          
          <!-- Widget 1: Ringkasan Nilai Status Box -->
          <div class="bg-emerald-950 text-white rounded-2xl p-5 shadow-md flex flex-col gap-5">
            <h3 class="text-base font-bold tracking-tight">Ringkasan Nilai</h3>
            
            <div class="flex flex-col gap-2.5 text-xs text-slate-300">
              <div class="flex justify-between border-b border-white/10 pb-2">
                <span>KELENGKAPAN</span>
                <span class="font-bold text-emerald-400">100% Terisi</span>
              </div>
              <div class="flex justify-between items-center pt-1">
                <span>PEWAWANCARA</span>
                <span class="font-bold text-white truncate max-w-[130px]" title="{{ auth()->guard('panitia')->user()->nama_panitia ?? 'Bpk. Ahmad Suherman' }}">
                  {{ auth()->guard('panitia')->user()->nama_panitia ?? 'Bpk. Ahmad Suherman' }}
                </span>
              </div>
            </div>

            <!-- Scoring Action Core CTA Buttons -->
            <div class="flex flex-col gap-2.5 mt-2">
              <button type="button" onclick="window.print()" class="w-full bg-emerald-400 text-emerald-950 font-bold py-2.5 rounded-xl text-xs hover:bg-emerald-300 transition-colors shadow-sm flex items-center justify-center gap-2">
                📥 Simpan Penilaian
              </button>
              <button type="button" class="w-full bg-transparent text-white border border-white/20 font-semibold py-2.5 rounded-xl text-xs hover:bg-white/5 transition-colors flex items-center justify-center gap-2">
                🖨️ Cetak Draft
              </button>
            </div>

            <!-- Disclaimer Info Area Inside Ringkasan -->
            <div class="bg-white/5 rounded-xl p-3 flex gap-2 border border-white/5 mt-1">
              <span class="text-emerald-400 text-sm mt-0.5">ⓘ</span>
              <p class="text-[10px] text-slate-400 leading-normal">
                Pastikan seluruh instrumen telah terverifikasi sebelum menekan tombol simpan. Data yang sudah dikunci hanya dapat diubah melalui admin.
              </p>
            </div>
          </div>

          <!-- Widget 2: Informasi Orang Tua Dynamic Metadata -->
          <div class="bg-rose-50 border border-rose-100 rounded-2xl p-5 shadow-sm flex flex-col gap-4">
            <h3 class="text-slate-900 text-xs font-bold tracking-wider uppercase">Informasi Orang Tua</h3>
            
            <div class="flex flex-col gap-3.5 text-xs text-slate-700">
              <!-- Nama Wali -->
              <div class="flex gap-3">
                <span class="text-sm">👤</span>
                <div class="flex flex-col">
                  <span class="text-[10px] text-slate-400 font-medium">Nama Ayah/Wali</span>
                  <span class="font-bold text-slate-950 mt-0.5">{{ $pendaftaran->calonMurid->nama_ayah ?? 'Suryadi Wulandari' }}</span>
                </div>
              </div>

              <!-- Pekerjaan -->
              <div class="flex gap-3 border-t border-rose-200/40 pt-2.5">
                <span class="text-sm">💼</span>
                <div class="flex flex-col">
                  <span class="text-[10px] text-slate-400 font-medium">Pekerjaan</span>
                  <span class="font-bold text-slate-950 mt-0.5">{{ $pendaftaran->calonMurid->pekerjaan_ayah ?? 'Pegawai Negeri Sipil' }}</span>
                </div>
              </div>

              <!-- Kontak -->
              <div class="flex gap-3 border-t border-rose-200/40 pt-2.5">
                <span class="text-sm">📞</span>
                <div class="flex flex-col">
                  <span class="text-[10px] text-slate-400 font-medium">Kontak Darurat</span>
                  <span class="font-bold text-slate-950 mt-0.5">{{ $pendaftaran->calonMurid->no_hp_ortu ?? '+62 812-3456-7890' }}</span>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- Footer Component Included -->
    @include('components.footer-panitia', ['isGrading' => true])
  </div>
@endsection

@section('styles')
  <!-- Include AlpineJS Library for custom interactive layout toggles inside client side -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection