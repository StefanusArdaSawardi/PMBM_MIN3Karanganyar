<!-- Panitia Left Sidebar Component -->
<aside class="fixed top-0 left-0 bottom-0 w-[260px] bg-white/70 backdrop-blur-md border-r border-slate-200/50 flex flex-col justify-between p-6 shadow-sm z-50 max-[1024px]:w-[220px] max-[768px]:hidden transition-all">
  
  <div class="flex flex-col gap-6">
    <!-- Profile Section -->
    <div class="flex items-center gap-3 pb-5 border-b border-slate-200/50">
      <div class="bg-emerald-700 text-white rounded-xl w-12 h-12 flex items-center justify-center shrink-0 shadow-sm cursor-pointer hover:bg-rose-600 transition-colors group"
           onclick="event.preventDefault(); document.getElementById('panitia-logout-form').submit();"
           title="Klik untuk keluar aplikasi">
        <span class="text-sm font-bold tracking-wider uppercase group-hover:hidden">
          {{ substr(auth()->guard('panitia')->user()->nama_panitia ?? 'PA', 0, 2) }}
        </span>
        <svg class="w-5 h-5 hidden group-hover:block transition-all text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
        </svg>
      </div>
      <div class="flex flex-col min-w-0">
        <div class="text-slate-900 text-sm font-bold truncate font-sans">
          {{ auth()->guard('panitia')->user()->nama_panitia ?? 'Panitia PMBM 1' }}
        </div>
        <div class="text-slate-400 text-[11px] font-semibold tracking-wide uppercase truncate font-sans mt-0.5">
          {{ str_replace('_', ' ', auth()->guard('panitia')->user()->role_panitia ?? 'PENGAWAS UJIAN') }}
        </div>
      </div>
    </div>

    <!-- Application Brand Link -->
    <div class="flex items-center gap-3 px-2">
      <img
        class="w-10 h-10 object-cover aspect-square rounded-lg"
        src="{{ asset('assets/panitia/queue/whats-app-image-2026-06-17-at-23-30-06-removebg-preview-10.png') }}"
        alt="Logo PMBM"
      />
      <span class="text-slate-900 font-bold tracking-tight text-base font-sans">Panel Penguji</span>
    </div>

    <!-- Navigation Menu (Vertikal) -->
    <nav class="flex flex-col gap-1.5 mt-2">
      <!-- Menu 1: Penilaian -->
      <a href="{{ route('panitia.dashboard') }}" 
         class="flex items-center px-4 py-2.5 rounded-xl text-sm font-medium transition-colors no-underline font-sans {{ $activeFolder === 'queue' ? 'bg-emerald-600 text-white shadow-sm font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-emerald-600' }}">
        Penilaian
      </a>
      
      <!-- Menu 2: Hasil Nilai -->
      <a href="{{ route('panitia.hasil-nilai') }}" 
         class="flex items-center px-4 py-2.5 rounded-xl text-sm font-medium transition-colors no-underline font-sans {{ $activeFolder === 'result' ? 'bg-emerald-600 text-white shadow-sm font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-emerald-600' }}">
        Hasil Nilai
      </a>
    </nav>
  </div>

  <!-- Logout Button at Bottom -->
  <button onclick="event.preventDefault(); document.getElementById('panitia-logout-form').submit();" 
          class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl text-sm font-bold transition-colors border border-rose-200/30">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
    </svg>
    Keluar
  </button>
</aside>

<!-- Mobile Topbar Navigation Fallback (Hanya muncul di layar HP) -->
<nav class="hidden max-[768px]:flex fixed top-0 left-0 right-0 h-16 bg-white border-b border-slate-200 items-center justify-between px-4 z-50">
  <div class="flex items-center gap-2">
    <img class="w-8 h-8 object-cover" src="{{ asset('assets/panitia/queue/whats-app-image-2026-06-17-at-23-30-06-removebg-preview-10.png') }}" alt="Logo">
    <span class="text-slate-900 font-bold text-sm">PMBM</span>
  </div>
  <div class="flex gap-4 text-xs font-bold">
    <a href="{{ route('panitia.dashboard') }}" class="{{ $activeFolder === 'queue' ? 'text-emerald-600' : 'text-slate-500' }} no-underline">Penilaian</a>
    <a href="{{ route('panitia.hasil-nilai') }}" class="{{ $activeFolder === 'result' ? 'text-emerald-600' : 'text-slate-500' }} no-underline">Hasil</a>
    <a href="#" onclick="event.preventDefault(); document.getElementById('panitia-logout-form').submit();" class="text-rose-500 no-underline">Keluar</a>
  </div>
</nav>

<!-- Hidden Logout Form -->
<form id="panitia-logout-form" action="{{ route('panitia.logout') }}" method="POST" class="hidden">
  @csrf
</form>