@extends('layouts.landing')

@section('title', 'PMBM MIN 3 Karanganyar - Penerimaan Siswa Baru')

@section('content')
  <div class="relative bg-white" style="font-family: 'PlusJakartaSans-Regular', sans-serif;">
    <!-- Header/Navbar Shared Component -->
    @include('components.navbar', ['activeFolder' => 'home'])

    <!-- Hero Section -->
    <section class="relative min-h-[472px] flex items-center overflow-hidden pt-[90px] pb-10">
      <div class="absolute inset-0 overflow-hidden z-0">
        <img src="{{ asset('assets/landing/home/hero-bg.jpg') }}" alt="MIN 3 Karanganyar" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/45"></div>
      </div>
      <div class="relative z-[1] w-full max-w-[900px] mx-auto px-6 flex flex-col items-center gap-4 text-center">

        @if($activePeriod)
          <span class="text-white/80 text-[15px] font-bold tracking-[-0.4px]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Daftar</span>
          <h1 class="text-white font-extrabold tracking-[-0.4px] leading-[1.3] m-0" style="font-family: 'PlusJakartaSans-ExtraBold', sans-serif; font-size: clamp(20px, 4vw, 30px);">{{ strtoupper($activePeriod->judul) }}</h1>

          @if($activePeriod->deskripsi)
            <p class="text-white/80 text-[15px] tracking-[-0.4px] leading-[1.6] max-w-[600px] m-0" style="font-family: 'PlusJakartaSans-Regular', sans-serif;">{{ $activePeriod->deskripsi }}</p>
          @endif

          <div class="flex items-center gap-2 mt-1">
            <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-[10px] border border-white/20 rounded-full px-4 py-1.5 text-white/90 text-[13px]" style="font-family: 'PlusJakartaSans-SemiBold', sans-serif;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              {{ \Carbon\Carbon::parse($activePeriod->tanggal_mulai)->translatedFormat('d F Y') }} – {{ \Carbon\Carbon::parse($activePeriod->tanggal_selesai)->translatedFormat('d F Y') }}
            </span>
          </div>

          @if($activePeriod->isOpen())
            <div class="flex flex-wrap justify-center gap-3 mt-2">
              <div class="backdrop-blur-[10px] bg-white/10 border border-white/20 rounded-2xl shadow-[0px_4px_20px_0px_rgba(0,0,0,0.04)] w-[90px] h-20 flex flex-col items-center justify-center gap-1">
                <div class="text-white text-[28px] font-bold leading-[1.2]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;" id="cd-days">00</div>
                <div class="text-white/60 text-[12px] font-semibold tracking-[0.7px]" style="font-family: 'PlusJakartaSans-SemiBold', sans-serif;">HARI</div>
              </div>
              <div class="backdrop-blur-[10px] bg-white/10 border border-white/20 rounded-2xl shadow-[0px_4px_20px_0px_rgba(0,0,0,0.04)] w-[90px] h-20 flex flex-col items-center justify-center gap-1">
                <div class="text-white text-[28px] font-bold leading-[1.2]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;" id="cd-hours">00</div>
                <div class="text-white/60 text-[12px] font-semibold tracking-[0.7px]" style="font-family: 'PlusJakartaSans-SemiBold', sans-serif;">JAM</div>
              </div>
              <div class="backdrop-blur-[10px] bg-white/10 border border-white/20 rounded-2xl shadow-[0px_4px_20px_0px_rgba(0,0,0,0.04)] w-[90px] h-20 flex flex-col items-center justify-center gap-1">
                <div class="text-white text-[28px] font-bold leading-[1.2]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;" id="cd-minutes">00</div>
                <div class="text-white/60 text-[12px] font-semibold tracking-[0.7px]" style="font-family: 'PlusJakartaSans-SemiBold', sans-serif;">MENIT</div>
              </div>
              <div class="backdrop-blur-[10px] bg-white/10 border border-white/20 rounded-2xl shadow-[0px_4px_20px_0px_rgba(0,0,0,0.04)] w-[90px] h-20 flex flex-col items-center justify-center gap-1">
                <div class="text-white text-[28px] font-bold leading-[1.2]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;" id="cd-seconds">00</div>
                <div class="text-white/60 text-[12px] font-semibold tracking-[0.7px]" style="font-family: 'PlusJakartaSans-SemiBold', sans-serif;">DETIK</div>
              </div>
            </div>

            <div class="flex flex-wrap justify-center gap-3 mt-2">
              <a href="{{ route('student.register') }}"
                 class="flex items-center justify-center h-9 px-6 rounded text-[15px] font-bold tracking-[-0.4px] whitespace-nowrap transition-all duration-250 ease-in-out text-white/80 bg-[#064e3b] border border-[#0f7643] hover:bg-[#056a4c] hover:border-[#056a4c] hover:text-white hover:-translate-y-px hover:shadow-[0_4px_10px_rgba(6,78,59,0.2)]"
                 style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Daftar Sekarang</a>
              <a href="{{ route('landing.guide') }}"
                 class="flex items-center justify-center h-9 px-6 rounded text-[15px] font-bold tracking-[-0.4px] whitespace-nowrap transition-all duration-250 ease-in-out text-[#0f7643]/80 bg-[rgba(15,118,67,0)] border border-[#0f7643]/80 hover:bg-[rgba(41,135,82,0.15)] hover:border-[#298752] hover:text-[#298752] hover:-translate-y-px"
                 style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Guide PMBM</a>
            </div>
          @else
            {{-- Periode aktif tapi di luar tanggal --}}
            <div class="bg-white/10 backdrop-blur-[10px] border border-white/20 rounded-xl px-6 py-3 mt-2">
              <p class="text-white/90 text-[14px] m-0" style="font-family: 'PlusJakartaSans-SemiBold', sans-serif;">
                @if(now()->lt($activePeriod->tanggal_mulai))
                  Pendaftaran akan dibuka pada {{ \Carbon\Carbon::parse($activePeriod->tanggal_mulai)->translatedFormat('d F Y') }}
                @else
                  Pendaftaran sudah ditutup pada {{ \Carbon\Carbon::parse($activePeriod->tanggal_selesai)->translatedFormat('d F Y') }}
                @endif
              </p>
            </div>
            <div class="flex flex-wrap justify-center gap-3 mt-2">
              <a href="{{ route('landing.guide') }}"
                 class="flex items-center justify-center h-9 px-6 rounded text-[15px] font-bold tracking-[-0.4px] whitespace-nowrap transition-all duration-250 ease-in-out text-[#0f7643]/80 bg-[rgba(15,118,67,0)] border border-[#0f7643]/80 hover:bg-[rgba(41,135,82,0.15)] hover:border-[#298752] hover:text-[#298752] hover:-translate-y-px"
                 style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Guide PMBM</a>
            </div>
          @endif

        @else
          {{-- Tidak ada periode aktif --}}
          <h1 class="text-white font-extrabold tracking-[-0.4px] leading-[1.3] m-0" style="font-family: 'PlusJakartaSans-ExtraBold', sans-serif; font-size: clamp(20px, 4vw, 30px);">{{ strtoupper($landingContent['main_heading'] ?? 'PENERIMAAN SISWA BARU MIN 3 KARANGANYAR') }}</h1>
          <p class="text-white text-[15px] tracking-[-0.4px] leading-[1.6] max-w-[600px] m-0" style="font-family: 'PlusJakartaSans-Regular', sans-serif;">{{ $landingContent['sub_heading'] ?? 'Bergabunglah bersama sekolah yang berkomitmen membentuk generasi unggul, berakhlak mulia dan berprestasi di tingkat nasional maupun internasional.' }}</p>
          <div class="bg-white/10 backdrop-blur-[10px] border border-white/20 rounded-xl px-6 py-3 mt-2">
            <p class="text-white/90 text-[14px] m-0" style="font-family: 'PlusJakartaSans-SemiBold', sans-serif;">Belum ada pendaftaran yang dibuka saat ini.</p>
          </div>
          <div class="flex flex-wrap justify-center gap-3 mt-2">
            <a href="{{ route('landing.guide') }}"
               class="flex items-center justify-center h-9 px-6 rounded text-[15px] font-bold tracking-[-0.4px] whitespace-nowrap transition-all duration-250 ease-in-out text-[#0f7643]/80 bg-[rgba(15,118,67,0)] border border-[#0f7643]/80 hover:bg-[rgba(41,135,82,0.15)] hover:border-[#298752] hover:text-[#298752] hover:-translate-y-px"
               style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Guide PMBM</a>
          </div>
        @endif

      </div>
    </section>

    <!-- Alur Pendaftaran Section -->
    <section class="max-w-[1200px] mx-auto px-6 pt-16 pb-10 text-center" id="alur-pmb">
      <h2 class="text-black text-center font-bold tracking-[-0.4px] text-[25px] mb-4" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">ALUR PENDAFTARAN PMBM</h2>

      <div class="flex items-start justify-center gap-0 mt-10 flex-wrap max-[768px]:flex-col max-[768px]:gap-6">
        <div class="flex flex-col items-center gap-2.5 w-[190px] shrink-0">
          <div class="w-[51px] h-[51px] rounded-full bg-[#0f7643] text-[#f8f9ff] text-[22px] font-bold flex items-center justify-center" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">01</div>
          <div class="text-black text-[12px] font-bold" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Daftar</div>
          <div class="text-black/40 text-[10px] leading-[1.6] text-center" style="font-family: 'Roboto-Regular', sans-serif;">Klik Daftar merupakan langkah awal untuk mendaftar PMBM.</div>
        </div>
        <div class="self-start mt-[25px] w-10 h-px bg-black shrink-0 max-[768px]:hidden"></div>
        <div class="flex flex-col items-center gap-2.5 w-[190px] shrink-0">
          <div class="w-[51px] h-[51px] rounded-full bg-[#0f7643] text-[#f8f9ff] text-[22px] font-bold flex items-center justify-center" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">02</div>
          <div class="text-black text-[12px] font-bold" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Isi Formulir &amp; Berkas</div>
          <div class="text-black/40 text-[10px] leading-[1.6] text-center" style="font-family: 'Roboto-Regular', sans-serif;">Isi Formulir lengkapi data diri dan dokumen yang telah ditentukan.</div>
        </div>
        <div class="self-start mt-[25px] w-10 h-px bg-black shrink-0 max-[768px]:hidden"></div>
        <div class="flex flex-col items-center gap-2.5 w-[190px] shrink-0">
          <div class="w-[51px] h-[51px] rounded-full bg-[#0f7643] text-[#f8f9ff] text-[22px] font-bold flex items-center justify-center" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">03</div>
          <div class="text-black text-[12px] font-bold" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Tes &amp; Wawancara</div>
          <div class="text-black/40 text-[10px] leading-[1.6] text-center" style="font-family: 'Roboto-Regular', sans-serif;">Mengikuti tes dan wawancara secara offline di sekolah.</div>
        </div>
        <div class="self-start mt-[25px] w-10 h-px bg-black shrink-0 max-[768px]:hidden"></div>
        <div class="flex flex-col items-center gap-2.5 w-[190px] shrink-0">
          <div class="w-[51px] h-[51px] rounded-full bg-[#0f7643] text-[#f8f9ff] text-[22px] font-bold flex items-center justify-center" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">04</div>
          <div class="text-black text-[12px] font-bold" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Hasil Kelulusan</div>
          <div class="text-black/40 text-[10px] leading-[1.6] text-center" style="font-family: 'Roboto-Regular', sans-serif;">Pengumuman resmi hasil seleksi dapat dilihat langsung melalui tulisan kelulusan di dashboard.</div>
        </div>
      </div>
    </section>

    <!-- Program Pendidikan Section -->
    <section class="max-w-[1100px] mx-auto px-6 pt-6 pb-[60px] text-center">
      <h2 class="text-black text-center font-bold tracking-[-0.4px] text-[25px] mb-4" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">PROGRAM PENDIDIKAN</h2>
      <p class="text-black/40 text-[16px] max-w-[700px] mx-auto mb-8 leading-[1.6]" style="font-family: 'Roboto-Regular', sans-serif;">Kurikulum yang dirancang khusus untuk mengoptimalkan potensi akademis dan karakter anak didik di era global.</p>

      <div id="programs-container" class="grid grid-cols-3 gap-8 max-[900px]:grid-cols-2 max-[600px]:grid-cols-1">
        @foreach($programs as $program)
          @php
            $link = route('landing.program-detail', $program->id_program);
            $imageUrl = $program->image ? asset($program->image) : asset('assets/landing/home/save-clip-app-475743711-1307796790563708-7462844736250640796-n-10.png');
          @endphp
          <div class="bg-[#eaeaea] rounded-xl overflow-hidden flex flex-col shadow-[0px_4px_10px_rgba(0,0,0,0.05)] border border-[#bdcab8] transition-all duration-250 ease hover:-translate-y-1.5 hover:shadow-[0px_12px_24px_rgba(6,78,59,0.12)]">
            <img src="{{ $imageUrl }}" alt="{{ $program->nama_program }}" class="w-full h-[180px] object-cover" />
            <div class="p-5 flex flex-col gap-2.5 flex-1">
              @if($link !== '#')
                <a href="{{ $link }}" class="text-[15px] font-bold text-[#064e3b] text-center no-underline transition-colors duration-200 hover:text-[#298752]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">{{ $program->nama_program }}</a>
              @else
                <span class="text-[15px] font-bold text-[#064e3b] text-center" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">{{ $program->nama_program }}</span>
              @endif
              <div class="text-[12px] leading-[1.6] text-gray-600 text-center" style="font-family: 'Roboto-Regular', sans-serif;">
                {{ $program->persyaratan }}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </section>

    <!-- Footer Shared Component -->
    @include('components.footer', ['activeFolder' => 'home'])
  </div>
@endsection

@section('scripts')
  <script>
    @if(isset($activePeriod) && $activePeriod && $activePeriod->isOpen())
      const targetDate = new Date("{{ \Carbon\Carbon::parse($activePeriod->tanggal_selesai)->format('Y-m-d') }}T23:59:59");

      function updateCountdown() {
        const now = new Date();
        const diff = targetDate - now;

        if (diff <= 0) {
          document.getElementById('cd-days').innerText = "00";
          document.getElementById('cd-hours').innerText = "00";
          document.getElementById('cd-minutes').innerText = "00";
          document.getElementById('cd-seconds').innerText = "00";
          return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        document.getElementById('cd-days').innerText = String(days).padStart(2, '0');
        document.getElementById('cd-hours').innerText = String(hours).padStart(2, '0');
        document.getElementById('cd-minutes').innerText = String(minutes).padStart(2, '0');
        document.getElementById('cd-seconds').innerText = String(seconds).padStart(2, '0');
      }

      updateCountdown();
      setInterval(updateCountdown, 1000);
    @endif
  </script>
@endsection
