@extends('layouts.landing')

@section('title', 'PMBM MIN 3 Karanganyar - Penerimaan Siswa Baru')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/landing/home/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/landing/home/style.css') }}">
  <style>
     .hero-btn-daftar {
        position: absolute;
        left: 530px;
        top: 376px;
        width: 180px;
        height: 36px;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #064e3b !important;
        border: 1px solid #0f7643 !important;
        border-radius: 4px;
        transition: all 0.25s ease-in-out !important;
        z-index: 20;
     }
     .hero-btn-daftar:hover {
        background: #056a4c !important;
        border-color: #056a4c !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 10px rgba(6, 78, 59, 0.2) !important;
     }
     .hero-btn-daftar span {
        color: rgba(255, 255, 255, 0.8);
        font-family: 'PlusJakartaSans-Bold', sans-serif;
        font-size: 15px;
        font-weight: 700;
        text-align: center;
        pointer-events: none;
        transition: color 0.25s ease-in-out;
     }
     .hero-btn-daftar:hover span {
        color: #ffffff !important;
     }
     
     .hero-btn-guide {
        position: absolute;
        left: 730px;
        top: 377px;
        width: 179px;
        height: 36px;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(15, 118, 67, 0) !important;
        border: 1px solid rgba(15, 118, 67, 0.8) !important;
        border-radius: 4px;
        transition: all 0.25s ease-in-out !important;
        z-index: 20;
     }
     .hero-btn-guide:hover {
        background: rgba(41, 135, 82, 0.15) !important;
        border-color: #298752 !important;
        transform: translateY(-1px) !important;
     }
     .hero-btn-guide span {
        color: rgba(15, 118, 67, 0.8);
        font-family: 'PlusJakartaSans-Bold', sans-serif;
        font-size: 15px;
        font-weight: 700;
        text-align: center;
        pointer-events: none;
        transition: color 0.25s ease-in-out;
     }
     .hero-btn-guide:hover span {
        color: #298752 !important;
     }
  </style>
@endsection

@section('content')
  <div class="dashboard-pmbm-min-3-kra" id="page-container">
    <!-- Header/Navbar Shared Component -->
    @include('components.navbar', ['activeFolder' => 'home'])

    <!-- Hero / Main content section -->
    <div class="penerimaan-siswa-baru-min-3-karanganyar">
      {{ strtoupper($landingContent['main_heading'] ?? 'PENERIMAAN SISWA BARU MIN 3 KARANGANYAR') }}
    </div>
    <div class="alur-pendaftaran-pmbm" id="alur-pmb">ALUR PENDAFTARAN PMBM</div>
    <div class="bergabunglah-bersama-sekolah-yang-berkomitmen-membentuk-generasi-unggul-berakhlak-mulia-dan-berprestasi-di-tingkat-nasional-maupun-internasional">
      {{ $landingContent['sub_heading'] ?? 'Bergabunglah bersama sekolah yang berkomitmen membentuk generasi unggul, berakhlak mulia dan berprestasi di tingkat nasional maupun internasional.' }}
    </div>

    <!-- Countdown Timer Section -->
    <div class="rectangle-5"></div>
    <div class="rectangle-6"></div>
    <div class="rectangle-7"></div>
    <div class="rectangle-8"></div>
    
    <div class="_100" id="cd-days">100</div>
    <div class="hari">HARI</div>
    
    <div class="_02" id="cd-hours" style="left: 653px;">02</div>
    <div class="jam">JAM</div>
    
    <div class="_59" id="cd-minutes" style="left: 754px;">59</div>
    <div class="menit">MENIT</div>
    
    <div class="_47" id="cd-seconds" style="left: 855px;">47</div>
    <div class="detik">DETIK</div>

    <!-- Call to Actions -->
    <a href="{{ route('student.register') }}" class="hero-btn-daftar">
       <span>Daftar Sekarang</span>
    </a>
    
    <a href="{{ route('landing.guide') }}" class="hero-btn-guide">
       <span>Guide PMBM</span>
    </a>

    <!-- Alur Steps -->
    <div class="klik-daftar-merupakan-langkah-awal-untuk-mendaftar-pmbm">
      Klik Daftar merupakan langkah awal untuk mendaftar PMBM.
    </div>
    <div class="isi-formulir-lengkapi-data-diri-dan-dokuemen-yang-telah-di-tentukan">
      Isi Formulir lengkapi data diri dan dokumen yang telah ditentukan.
    </div>
    <div class="mengikuti-tes-dan-wawancara-secara-offline-di-sekolah">
      Mengikuti tes dan wawancara secara offline di sekolah.
    </div>
    <div class="pengumuman-resmi-hasil-seleksi-dapat-dilihat-langsung-melalui-tulisan-kelulusan-di-dashboard">
      Pengumuman resmi hasil seleksi dapat dilihat langsung melalui tulisan
      kelulusan di dashboard.
    </div>
    
    <div class="ellipse-2"></div>
    <div class="_01">01</div>
    <div class="daftar2">Daftar</div>
    
    <div class="ellipse-3"></div>
    <div class="_022" style="left: 602px;">02</div>
    <div class="isi-formulir-berkas">Isi Formulir &amp; Berkas</div>
    
    <div class="ellipse-4"></div>
    <div class="_03">03</div>
    <div class="tes-wawancara">Tes &amp; Wawancara</div>
    
    <div class="ellipse-5"></div>
    <div class="_04">04</div>
    <div class="hasil-kelulusan">Hasil Kelulusan</div>
    
    <div class="line-1"></div>
    <div class="line-2"></div>
    <div class="line-3"></div>

    <!-- Programs of Education -->
    <div class="program-pendidikan">PROGRAM PENDIDIKAN</div>
    
    <div class="kurikulum-yang-dirancang-khusus-untuk-mengoptimalkan-potensi-akademis-dan-karakter-anak-didik-di-era-global">
      Kurikulum yang dirancang khusus untuk mengoptimalkan potensi akademis dan karakter anak didik di era global.
    </div>
    
    <div id="programs-container" style="position: absolute; left: 191px; top: 981px; width: 983px; display: flex; gap: 40px; justify-content: flex-start; flex-wrap: wrap; align-items: stretch; z-index: 10;">
      @foreach($programs as $program)
        @php
          $link = '#';
          $nameLower = strtolower($program->nama_program);
          if (strpos($nameLower, 'khusus') !== false || strpos($nameLower, 'tahfidz') !== false) {
              $link = route('landing.program-khusus');
          } elseif (strpos($nameLower, 'unggulan') !== false || strpos($nameLower, 'sains') !== false) {
              $link = route('landing.program-unggulan');
          } elseif (strpos($nameLower, 'fullday') !== false || strpos($nameLower, 'reguler') !== false) {
              $link = route('landing.program-fullday');
          }
          
          $imageUrl = $program->image ? asset($program->image) : asset('assets/landing/home/save-clip-app-475743711-1307796790563708-7462844736250640796-n-10.png');
        @endphp
        <div style="width: calc(33.333% - 27px); min-width: 280px; background: #eaeaea; border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0px 4px 10px rgba(0,0,0,0.05); border: 1px solid #bdcab8; transition: transform 0.2s; margin-bottom: 20px;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
          <img src="{{ $imageUrl }}" style="width: 100%; height: 180px; object-fit: cover;" alt="{{ $program->nama_program }}" />
          <div style="padding: 20px; display: flex; flex-direction: column; gap: 10px; flex: 1;">
            @if($link !== '#')
              <a href="{{ $link }}" style="font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 15px; font-weight: 700; color: #064e3b; text-align: center; text-decoration: none;">{{ $program->nama_program }}</a>
            @else
              <span style="font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 15px; font-weight: 700; color: #064e3b; text-align: center;">{{ $program->nama_program }}</span>
            @endif
            <div style="font-family: 'Roboto-Regular', sans-serif; font-size: 12px; line-height: 1.6; color: #4b5563; text-align: center;">
              {{ $program->persyaratan }}
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Footer Shared Component -->
    @include('components.footer', ['activeFolder' => 'home'])
  </div>
@endsection

@section('scripts')
  <script>
    // 1. Countdown Timer Logic
    const targetDate = new Date("{{ $landingContent['countdown_target'] ?? '2026-07-31T23:59:00' }}");

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

    // 2. Chatbox Toggle Placeholder
    function toggleChatbox() {
      alert("Fitur Tanya Asisten PMBM akan segera dihubungkan dengan API Chat!");
    }

    // 3. Dynamic Footer Positioning based on programs count/height
    window.addEventListener('DOMContentLoaded', (event) => {
      const container = document.getElementById('programs-container');
      const footer = document.getElementById('footer-group-wrapper');
      const page = document.getElementById('page-container');
      if (container && footer && page) {
        const containerTop = 981; // fixed absolute top position
        const containerHeight = container.offsetHeight;
        const containerBottom = containerTop + containerHeight;
        
        const minSpacing = 80;
        const desiredFooterTop = containerBottom + minSpacing;
        const defaultFooterTop = 1563; // original coordinate top from stylesheet
        
        if (desiredFooterTop > defaultFooterTop) {
          const delta = desiredFooterTop - defaultFooterTop;
          footer.style.top = delta + 'px';
          
          const defaultPageHeight = 1927; // original page height
          page.style.height = (defaultPageHeight + delta) + 'px';
        }
      }
    });
  </script>
@endsection
