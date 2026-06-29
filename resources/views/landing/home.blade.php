@extends('layouts.landing')

@section('title', 'PMBM MIN 3 Karanganyar - Penerimaan Siswa Baru')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/landing/home/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/landing/home/style.css') }}">
@endsection

@section('content')
  <div class="home-page">
    <!-- Header/Navbar Shared Component -->
    @include('components.navbar', ['activeFolder' => 'home'])

    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-bg-photo">
        <img src="{{ asset('assets/landing/home/hero-bg.jpg') }}" alt="MIN 3 Karanganyar">
      </div>
      <div class="hero-content">
        <span class="hero-daftar-tag">Daftar</span>
        <h1 class="hero-title">{{ strtoupper($landingContent['main_heading'] ?? 'PENERIMAAN SISWA BARU MIN 3 KARANGANYAR') }}</h1>
        <p class="hero-subtitle">{{ $landingContent['sub_heading'] ?? 'Bergabunglah bersama sekolah yang berkomitmen membentuk generasi unggul, berakhlak mulia dan berprestasi di tingkat nasional maupun internasional.' }}</p>

        <div class="countdown-row">
          <div class="countdown-card">
            <div class="countdown-value" id="cd-days">100</div>
            <div class="countdown-label">HARI</div>
          </div>
          <div class="countdown-card">
            <div class="countdown-value" id="cd-hours">02</div>
            <div class="countdown-label">JAM</div>
          </div>
          <div class="countdown-card">
            <div class="countdown-value" id="cd-minutes">59</div>
            <div class="countdown-label">MENIT</div>
          </div>
          <div class="countdown-card">
            <div class="countdown-value" id="cd-seconds">47</div>
            <div class="countdown-label">DETIK</div>
          </div>
        </div>

        <div class="hero-cta-row">
          <a href="{{ route('student.register') }}" class="hero-btn hero-btn-daftar">Daftar Sekarang</a>
          <a href="{{ route('landing.guide') }}" class="hero-btn hero-btn-guide">Guide PMBM</a>
        </div>
      </div>
    </section>

    <!-- Alur Pendaftaran Section -->
    <section class="alur-section" id="alur-pmb">
      <h2 class="section-title">ALUR PENDAFTARAN PMBM</h2>

      <div class="alur-steps">
        <div class="alur-step">
          <div class="alur-circle">01</div>
          <div class="alur-step-title">Daftar</div>
          <div class="alur-step-desc">Klik Daftar merupakan langkah awal untuk mendaftar PMBM.</div>
        </div>
        <div class="alur-connector"></div>
        <div class="alur-step">
          <div class="alur-circle">02</div>
          <div class="alur-step-title">Isi Formulir &amp; Berkas</div>
          <div class="alur-step-desc">Isi Formulir lengkapi data diri dan dokumen yang telah ditentukan.</div>
        </div>
        <div class="alur-connector"></div>
        <div class="alur-step">
          <div class="alur-circle">03</div>
          <div class="alur-step-title">Tes &amp; Wawancara</div>
          <div class="alur-step-desc">Mengikuti tes dan wawancara secara offline di sekolah.</div>
        </div>
        <div class="alur-connector"></div>
        <div class="alur-step">
          <div class="alur-circle">04</div>
          <div class="alur-step-title">Hasil Kelulusan</div>
          <div class="alur-step-desc">Pengumuman resmi hasil seleksi dapat dilihat langsung melalui tulisan kelulusan di dashboard.</div>
        </div>
      </div>
    </section>

    <!-- Program Pendidikan Section -->
    <section class="program-section">
      <h2 class="section-title">PROGRAM PENDIDIKAN</h2>
      <p class="program-section-desc">Kurikulum yang dirancang khusus untuk mengoptimalkan potensi akademis dan karakter anak didik di era global.</p>

      <div id="programs-container" class="programs-grid">
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
          <div class="program-card">
            <img src="{{ $imageUrl }}" alt="{{ $program->nama_program }}" />
            <div class="program-card-body">
              @if($link !== '#')
                <a href="{{ $link }}" class="program-card-title">{{ $program->nama_program }}</a>
              @else
                <span class="program-card-title">{{ $program->nama_program }}</span>
              @endif
              <div class="program-card-desc">
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
  </script>
@endsection
