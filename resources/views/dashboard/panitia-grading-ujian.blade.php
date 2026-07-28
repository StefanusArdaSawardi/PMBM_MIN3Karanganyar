@extends('layouts.panitia')

@section('title', 'Penilaian Ujian - Penguji PMBM')

@section('content')
  <div class="relative min-h-screen bg-slate-50/10 antialiased pb-12" x-data="{ step: 1 }">
    <!-- Panitia Sidebar Left Included -->
    @include('components.sidebar-panitia', ['activeFolder' => 'queue'])

    <!-- Main Content Layout -->
    <div class="relative pt-8 pb-12 pr-8 pl-[290px] max-[1024px]:pl-[250px] max-[1024px]:pr-6 flex flex-col gap-6 max-[768px]:pt-20 max-[768px]:px-4 w-full transition-all">
      
      <!-- Premium Student Identity Header -->
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

      <!-- 6-Step Progress Tracker - Dynamic Line Width & Dynamic Colors -->
      <div class="bg-white/40 backdrop-blur-sm border border-white/40 rounded-2xl p-5 shadow-sm w-full overflow-x-auto">
        <div class="flex items-center justify-between min-w-[750px] px-6 relative">
          <!-- Background Line Connecting steps -->
          <div class="absolute top-4 left-8 right-8 h-0.5 bg-slate-200/70 -z-10"></div>
          
          <!-- Dynamic Progress Line -->
          <div class="absolute top-4 left-8 h-0.5 bg-emerald-600 -z-10 transition-all duration-300"
               :style="'width: ' + ((step - 1) * 17.6) + '%'"></div>

          <!-- Step 1 -->
          <div class="flex flex-col items-center cursor-pointer" @click="step = 1">
            <div class="rounded-full w-8 h-8 flex items-center justify-center text-xs font-bold shadow-sm z-10 transition-all duration-300"
                 :class="step >= 1 ? 'bg-emerald-700 text-white ring-4 ring-emerald-100' : 'bg-slate-200 text-slate-500'">1</div>
            <span class="text-[11px] mt-2 tracking-wide transition-colors" :class="step >= 1 ? 'text-emerald-700 font-bold' : 'text-slate-400 font-medium'">Hafalan</span>
          </div>
          <!-- Step 2 -->
          <div class="flex flex-col items-center cursor-pointer" @click="step = 2">
            <div class="rounded-full w-8 h-8 flex items-center justify-center text-xs font-bold shadow-sm z-10 transition-all duration-300"
                 :class="step >= 2 ? 'bg-emerald-700 text-white ring-4 ring-emerald-100' : 'bg-slate-200 text-slate-500'">2</div>
            <span class="text-[11px] mt-2 tracking-wide transition-colors" :class="step >= 2 ? 'text-emerald-700 font-bold' : 'text-slate-400 font-medium'">Aism</span>
          </div>
          <!-- Step 3 -->
          <div class="flex flex-col items-center cursor-pointer" @click="step = 3">
            <div class="rounded-full w-8 h-8 flex items-center justify-center text-xs font-bold shadow-sm z-10 transition-all duration-300"
                 :class="step >= 3 ? 'bg-emerald-700 text-white ring-4 ring-emerald-100' : 'bg-slate-200 text-slate-500'">3</div>
            <span class="text-[11px] mt-2 tracking-wide transition-colors" :class="step >= 3 ? 'text-emerald-700 font-bold' : 'text-slate-400 font-medium'">Iqro</span>
          </div>
          <!-- Step 4 -->
          <div class="flex flex-col items-center cursor-pointer" @click="step = 4">
            <div class="rounded-full w-8 h-8 flex items-center justify-center text-xs font-bold shadow-sm z-10 transition-all duration-300"
                 :class="step >= 4 ? 'bg-emerald-700 text-white ring-4 ring-emerald-100' : 'bg-slate-200 text-slate-500'">4</div>
            <span class="text-[11px] mt-2 tracking-wide transition-colors" :class="step >= 4 ? 'text-emerald-700 font-bold' : 'text-slate-400 font-medium'">Calistung</span>
          </div>
          <!-- Step 5 -->
          <div class="flex flex-col items-center cursor-pointer" @click="step = 5">
            <div class="rounded-full w-8 h-8 flex items-center justify-center text-xs font-bold shadow-sm z-10 transition-all duration-300"
                 :class="step >= 5 ? 'bg-emerald-700 text-white ring-4 ring-emerald-100' : 'bg-slate-200 text-slate-500'">5</div>
            <span class="text-[11px] mt-2 tracking-wide transition-colors" :class="step >= 5 ? 'text-emerald-700 font-bold' : 'text-slate-400 font-medium'">Dikte</span>
          </div>
          <!-- Step 6 -->
          <div class="flex flex-col items-center cursor-pointer" @click="step = 6">
            <div class="rounded-full w-8 h-8 flex items-center justify-center text-xs font-bold shadow-sm z-10 transition-all duration-300"
                 :class="step == 6 ? 'bg-emerald-700 text-white ring-4 ring-emerald-100' : 'bg-slate-200 text-slate-500'">6</div>
            <span class="text-[11px] mt-2 tracking-wide transition-colors" :class="step == 6 ? 'text-emerald-700 font-bold' : 'text-slate-400 font-medium'">Kemandirian</span>
          </div>
        </div>
      </div>

      <!-- Main Scoring Form Card Layout -->
      <form action="{{ route('panitia.grading.ujian', $pendaftaran->id_pendaftaran) }}" method="POST" class="bg-white border border-slate-200/70 rounded-2xl shadow-[0_4px_25px_rgba(0,0,0,0.02)] overflow-hidden w-full flex flex-col min-h-[420px] justify-between">
        @csrf

        @if($errors->any())
          <div class="m-6 p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium rounded-xl">
            {{ $errors->first() }}
          </div>
        @endif

        <!-- ==================== INSTRUMEN 1: HAFALAN ==================== -->
        <div x-show="step === 1" class="flex flex-col justify-between flex-1">
          <div class="border-b border-slate-100 px-8 py-6 bg-slate-50/50 flex flex-col gap-1">
            <h3 class="text-slate-900 text-lg font-bold flex items-center gap-2"><span class="inline-block w-2 h-5 bg-emerald-600 rounded-sm"></span>1. Instrumen Hafalan</h3>
            <p class="text-slate-500 text-sm pl-4">Penilaian terhadap kemampuan hafalan surat pendek dan doa harian Calon Siswa.</p>
          </div>
          <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8 items-center my-auto w-full max-w-5xl mx-auto">
            <div class="md:col-span-2 flex flex-col gap-2 w-full order-2 md:order-1">
              <label class="text-slate-700 text-xs font-bold tracking-wide uppercase">Catatan Observasi (Opsional)</label>
              <textarea name="catatan_hafalan" rows="4" placeholder="Tulis catatan khusus mengenai performa hafalan..." class="w-full px-4 py-3.5 text-sm text-slate-800 border border-slate-200 rounded-xl bg-slate-50/70 outline-none focus:border-emerald-500 focus:bg-white transition-all resize-none shadow-inner"></textarea>
            </div>
            <div class="flex flex-col items-center gap-3 w-full order-1 md:order-2 md:border-l md:border-slate-100">
              <span class="text-slate-400 text-[10px] font-bold tracking-widest uppercase mb-1">SKOR TEKNIS (1-100)</span>
              <div class="bg-emerald-50/60 border-2 border-emerald-400 rounded-2xl w-36 h-36 flex flex-col items-center justify-center shadow-inner focus-within:bg-white transition-all">
                <input type="number" name="nilai_hafalan" required min="1" max="100" value="{{ $pendaftaran->nilaiUjian->nilai_hafalan ?? '' }}" class="w-full bg-transparent text-center text-slate-900 text-4xl font-extrabold outline-none" placeholder="0" oninput="if(value > 100) value = 100;">
                <span class="text-emerald-700 text-[10px] font-bold tracking-wider uppercase mt-1">SCORE</span>
              </div>
            </div>
          </div>
        </div>

        <!-- ==================== INSTRUMEN 2: AISM ==================== -->
        <div x-show="step === 2" class="flex flex-col justify-between flex-1" x-cloak>
          <div class="border-b border-slate-100 px-8 py-6 bg-slate-50/50 flex flex-col gap-1">
            <h3 class="text-slate-900 text-lg font-bold flex items-center gap-2"><span class="inline-block w-2 h-5 bg-emerald-600 rounded-sm"></span>2. Instrumen Membaca Aism</h3>
            <p class="text-slate-500 text-sm pl-4">Penilaian terhadap kemampuan membaca metode Aism.</p>
          </div>
          <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8 items-center my-auto w-full max-w-5xl mx-auto">
            <div class="md:col-span-2 flex flex-col gap-2 w-full order-2 md:order-1">
              <label class="text-slate-700 text-xs font-bold tracking-wide uppercase">Catatan Observasi (Opsional)</label>
              <textarea name="catatan_aism" rows="4" placeholder="Tulis catatan khusus mengenai performa Aism..." class="w-full px-4 py-3.5 text-sm text-slate-800 border border-slate-200 rounded-xl bg-slate-50/70 outline-none focus:border-emerald-500 focus:bg-white transition-all resize-none shadow-inner"></textarea>
            </div>
            <div class="flex flex-col items-center gap-3 w-full order-1 md:order-2 md:border-l md:border-slate-100">
              <span class="text-slate-400 text-[10px] font-bold tracking-widest uppercase mb-1">SKOR TEKNIS (1-100)</span>
              <div class="bg-emerald-50/60 border-2 border-emerald-400 rounded-2xl w-36 h-36 flex flex-col items-center justify-center shadow-inner focus-within:bg-white transition-all">
                <!-- Fallback name if matching specific custom logic, else generic value -->
                <input type="number" name="nilai_aism" min="1" max="100" class="w-full bg-transparent text-center text-slate-900 text-4xl font-extrabold outline-none" placeholder="0" oninput="if(value > 100) value = 100;">
                <span class="text-emerald-700 text-[10px] font-bold tracking-wider uppercase mt-1">SCORE</span>
              </div>
            </div>
          </div>
        </div>

        <!-- ==================== INSTRUMEN 3: IQRO ==================== -->
        <div x-show="step === 3" class="flex flex-col justify-between flex-1" x-cloak>
          <div class="border-b border-slate-100 px-8 py-6 bg-slate-50/50 flex flex-col gap-1">
            <h3 class="text-slate-900 text-lg font-bold flex items-center gap-2"><span class="inline-block w-2 h-5 bg-emerald-600 rounded-sm"></span>3. Instrumen Membaca Iqro</h3>
            <p class="text-slate-500 text-sm pl-4">Penilaian terhadap kelancaran, makhraj, dan hukum bacaan Iqro.</p>
          </div>
          <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8 items-center my-auto w-full max-w-5xl mx-auto">
            <div class="md:col-span-2 flex flex-col gap-2 w-full order-2 md:order-1">
              <label class="text-slate-700 text-xs font-bold tracking-wide uppercase">Catatan Observasi (Opsional)</label>
              <textarea name="catatan_iqro" rows="4" placeholder="Tulis catatan mengenai performa bacaan Iqro..." class="w-full px-4 py-3.5 text-sm text-slate-800 border border-slate-200 rounded-xl bg-slate-50/70 outline-none focus:border-emerald-500 focus:bg-white transition-all resize-none shadow-inner"></textarea>
            </div>
            <div class="flex flex-col items-center gap-3 w-full order-1 md:order-2 md:border-l md:border-slate-100">
              <span class="text-slate-400 text-[10px] font-bold tracking-widest uppercase mb-1">SKOR TEKNIS (1-100)</span>
              <div class="bg-emerald-50/60 border-2 border-emerald-400 rounded-2xl w-36 h-36 flex flex-col items-center justify-center shadow-inner focus-within:bg-white transition-all">
                <input type="number" name="nilai_iqro" required min="1" max="100" value="{{ $pendaftaran->nilaiUjian->nilai_iqro ?? '' }}" class="w-full bg-transparent text-center text-slate-900 text-4xl font-extrabold outline-none" placeholder="0" oninput="if(value > 100) value = 100;">
                <span class="text-emerald-700 text-[10px] font-bold tracking-wider uppercase mt-1">SCORE</span>
              </div>
            </div>
          </div>
        </div>

        <!-- ==================== INSTRUMEN 4: CALISTUNG ==================== -->
        <div x-show="step === 4" class="flex flex-col justify-between flex-1" x-cloak>
          <div class="border-b border-slate-100 px-8 py-6 bg-slate-50/50 flex flex-col gap-1">
            <h3 class="text-slate-900 text-lg font-bold flex items-center gap-2"><span class="inline-block w-2 h-5 bg-emerald-600 rounded-sm"></span>4. Instrumen Calistung</h3>
            <p class="text-slate-500 text-sm pl-4">Penilaian kemampuan dasar membaca, menulis, dan berhitung logis.</p>
          </div>
          <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8 items-center my-auto w-full max-w-5xl mx-auto">
            <div class="md:col-span-2 flex flex-col gap-2 w-full order-2 md:order-1">
              <label class="text-slate-700 text-xs font-bold tracking-wide uppercase">Catatan Observasi (Opsional)</label>
              <textarea name="catatan_calistung" rows="4" placeholder="Tulis catatan performa Calistung..." class="w-full px-4 py-3.5 text-sm text-slate-800 border border-slate-200 rounded-xl bg-slate-50/70 outline-none focus:border-emerald-500 focus:bg-white transition-all resize-none shadow-inner"></textarea>
            </div>
            <div class="flex flex-col items-center gap-3 w-full order-1 md:order-2 md:border-l md:border-slate-100">
              <span class="text-slate-400 text-[10px] font-bold tracking-widest uppercase mb-1">SKOR TEKNIS (1-100)</span>
              <div class="bg-emerald-50/60 border-2 border-emerald-400 rounded-2xl w-36 h-36 flex flex-col items-center justify-center shadow-inner focus-within:bg-white transition-all">
                <input type="number" name="nilai_calistung" required min="1" max="100" value="{{ $pendaftaran->nilaiUjian->nilai_calistung ?? '' }}" class="w-full bg-transparent text-center text-slate-900 text-4xl font-extrabold outline-none" placeholder="0" oninput="if(value > 100) value = 100;">
                <span class="text-emerald-700 text-[10px] font-bold tracking-wider uppercase mt-1">SCORE</span>
              </div>
            </div>
          </div>
        </div>

        <!-- ==================== INSTRUMEN 5: DIKTE ==================== -->
        <div x-show="step === 5" class="flex flex-col justify-between flex-1" x-cloak>
          <div class="border-b border-slate-100 px-8 py-6 bg-slate-50/50 flex flex-col gap-1">
            <h3 class="text-slate-900 text-lg font-bold flex items-center gap-2"><span class="inline-block w-2 h-5 bg-emerald-600 rounded-sm"></span>5. Instrumen Mendikte</h3>
            <p class="text-slate-500 text-sm pl-4">Penilaian akurasi penulisan kata dengar dan ketangkasan menyerap instruksi vokal.</p>
          </div>
          <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8 items-center my-auto w-full max-w-5xl mx-auto">
            <div class="md:col-span-2 flex flex-col gap-2 w-full order-2 md:order-1">
              <label class="text-slate-700 text-xs font-bold tracking-wide uppercase">Catatan Observasi (Opsional)</label>
              <textarea name="catatan_dikte" rows="4" placeholder="Tulis catatan performa mendikte siswa..." class="w-full px-4 py-3.5 text-sm text-slate-800 border border-slate-200 rounded-xl bg-slate-50/70 outline-none focus:border-emerald-500 focus:bg-white transition-all resize-none shadow-inner"></textarea>
            </div>
            <div class="flex flex-col items-center gap-3 w-full order-1 md:order-2 md:border-l md:border-slate-100">
              <span class="text-slate-400 text-[10px] font-bold tracking-widest uppercase mb-1">SKOR TEKNIS (1-100)</span>
              <div class="bg-emerald-50/60 border-2 border-emerald-400 rounded-2xl w-36 h-36 flex flex-col items-center justify-center shadow-inner focus-within:bg-white transition-all">
                <input type="number" name="nilai_dikte" min="1" max="100" class="w-full bg-transparent text-center text-slate-900 text-4xl font-extrabold outline-none" placeholder="0" oninput="if(value > 100) value = 100;">
                <span class="text-emerald-700 text-[10px] font-bold tracking-wider uppercase mt-1">SCORE</span>
              </div>
            </div>
          </div>
        </div>

        <!-- ==================== INSTRUMEN 6: KEMANDIRIAN ==================== -->
        <div x-show="step === 6" class="flex flex-col justify-between flex-1" x-cloak>
          <div class="border-b border-slate-100 px-8 py-6 bg-slate-50/50 flex flex-col gap-1">
            <h3 class="text-slate-900 text-lg font-bold flex items-center gap-2"><span class="inline-block w-2 h-5 bg-emerald-600 rounded-sm"></span>6. Instrumen Kemandirian</h3>
            <p class="text-slate-500 text-sm pl-4">Penilaian adaptabilitas mental psikososial dan kemandirian perilaku tanpa wali murid.</p>
          </div>
          <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8 items-center my-auto w-full max-w-5xl mx-auto">
            <div class="md:col-span-2 flex flex-col gap-2 w-full order-2 md:order-1">
              <label class="text-slate-700 text-xs font-bold tracking-wide uppercase">Catatan Observasi (Opsional)</label>
              <textarea name="catatan_kemandirian" rows="4" placeholder="Tulis catatan mengenai kemandirian dan kesiapan psikologis anak..." class="w-full px-4 py-3.5 text-sm text-slate-800 border border-slate-200 rounded-xl bg-slate-50/70 outline-none focus:border-emerald-500 focus:bg-white transition-all resize-none shadow-inner"></textarea>
            </div>
            <div class="flex flex-col items-center gap-3 w-full order-1 md:order-2 md:border-l md:border-slate-100">
              <span class="text-slate-400 text-[10px] font-bold tracking-widest uppercase mb-1">SKOR TEKNIS (1-100)</span>
              <div class="bg-emerald-50/60 border-2 border-emerald-400 rounded-2xl w-36 h-36 flex flex-col items-center justify-center shadow-inner focus-within:bg-white transition-all">
                <input type="number" name="nilai_kemandirian" min="1" max="100" class="w-full bg-transparent text-center text-slate-900 text-4xl font-extrabold outline-none" placeholder="0" oninput="if(value > 100) value = 100;">
                <span class="text-emerald-700 text-[10px] font-bold tracking-wider uppercase mt-1">SCORE</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Footer Section - Dynamic Control Buttons -->
        <div class="border-t border-slate-100 px-8 py-5 flex items-center justify-between bg-slate-50/50">
          <span class="text-slate-400 text-xs font-bold tracking-wider uppercase" x-text="'BAGIAN ' + step + ' DARI 6'"></span>
          
          <div class="flex items-center gap-3">
            <!-- Back Trigger Action Button -->
            <button type="button" x-show="step > 1" @click="step--" class="border border-slate-300 bg-white rounded-xl px-5 py-2.5 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors shadow-sm" x-cloak>
              Kembali
            </button>
            <a href="{{ route('panitia.dashboard') }}" x-show="step === 1" class="border border-slate-300 bg-white rounded-xl px-6 py-2.5 text-slate-600 text-sm font-semibold text-center no-underline hover:bg-slate-50 transition-colors shadow-sm">
              Batal
            </a>
            
            <!-- Next Step Trigger Button -->
            <button type="button" x-show="step < 6" @click="step++" class="bg-emerald-700 text-white rounded-xl px-7 py-2.5 flex items-center justify-center gap-2 font-bold text-sm shadow-sm hover:bg-emerald-800 transition-all cursor-pointer">
              <span>Lanjut</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
              </svg>
            </button>

            <!-- Final Submit Button -->
            <button type="submit" x-show="step === 6" class="bg-emerald-800 text-white rounded-xl px-8 py-2.5 flex items-center justify-center gap-2 font-bold text-sm shadow-sm hover:bg-emerald-900 transition-all cursor-pointer" x-cloak>
              <span>Simpan Semua</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </button>
          </div>
        </div>
      </form>

      <!-- Bottom Metadata Alignments -->
      <div class="flex justify-between items-center text-slate-400 text-[11px] px-2 font-medium">
        <span class="flex items-center gap-1.5"><span class="text-emerald-600 font-bold text-sm">✓</span> Draft Tersemat Aman</span>
        <span>Verifikasi Keaslian Data: <span class="text-slate-600 font-bold tracking-wider">#AUTH-9921-X</span></span>
      </div>
    </div>

    <!-- Footer Component Included -->
    @include('components.footer-panitia', ['isGrading' => true])
  </div>
@endsection

@section('styles')
  <!-- Tambahkan library Alpine.js via CDN agar logika x-show dan step berjalan instan tanpa compile npm -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    [x-cloak] { display: none !important; }
  </style>
@endsection