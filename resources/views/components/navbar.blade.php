@php
  $isHomeActive = Request::routeIs('home');
  $isProgramActive = Request::routeIs('landing.program-khusus') || Request::routeIs('landing.program-unggulan') || Request::routeIs('landing.program-fullday');
  $isKelulusanActive = Request::routeIs('landing.cek-kelulusan') || Request::routeIs('student.status.check') || Request::routeIs('landing.hasil-kelulusan');
  $isKontakActive = Request::routeIs('landing.kontak');
  $isOnDark = in_array($activeFolder, ['home', 'program-khusus', 'program-unggulan', 'program-fullday', 'cek-kelulusan', 'hasil-kelulusan', 'kontak']);
@endphp

<!-- Navbar Component -->
<nav class="site-navbar {{ $isOnDark ? 'site-navbar-on-dark' : '' }}">
  <a href="{{ route('home') }}" class="navbar-brand">
    <img
      class="navbar-logo"
      src="{{ asset('assets/landing/' . $activeFolder . '/whats-app-image-2026-06-17-at-23-30-06-removebg-preview-10.png') }}"
      alt="Logo MIN 3 Karanganyar"
    />
    <span class="navbar-brand-text">PMBM MIN 3 KARANGANYAR</span>
  </a>

  <div class="navbar-links">
    <a href="{{ route('home') }}" class="navbar-link {{ $isHomeActive ? 'active' : '' }}">Home</a>
    <a href="{{ route('landing.program-khusus') }}" class="navbar-link {{ $isProgramActive ? 'active' : '' }}">Program</a>
    <a href="{{ route('landing.cek-kelulusan') }}" class="navbar-link {{ $isKelulusanActive ? 'active' : '' }}">Kelulusan</a>
    <a href="{{ route('landing.kontak') }}" class="navbar-link {{ $isKontakActive ? 'active' : '' }}">Kontak</a>
  </div>

  <div class="navbar-actions">
    <a href="{{ route('landing.guide') }}" class="navbar-btn navbar-btn-outline">Guide PMBM</a>
    <a href="{{ route('student.register') }}" class="navbar-btn navbar-btn-solid">Daftar</a>
  </div>
</nav>

<style>
  .site-navbar {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 999;
    background: rgba(196, 196, 196, 0.35);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 16px 40px;
    flex-wrap: wrap;
  }
  .site-navbar-on-dark {
    background: transparent;
  }
  .site-navbar-on-dark .navbar-brand-text {
    color: #ffffff;
  }
  .site-navbar-on-dark .navbar-link {
    color: rgba(255, 255, 255, 0.85);
  }
  .site-navbar-on-dark .navbar-link.active {
    color: #ffffff;
    text-decoration: underline;
  }
  .site-navbar-on-dark .navbar-link:hover {
    color: #ffffff;
  }
  .navbar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
  }
  .navbar-logo {
    width: 44px;
    height: 44px;
    object-fit: cover;
    aspect-ratio: 1;
    flex-shrink: 0;
  }
  .navbar-brand-text {
    color: #298752;
    font-family: "PlusJakartaSans-ExtraBold", sans-serif;
    font-size: 16px;
    font-weight: 800;
    letter-spacing: -0.4px;
    white-space: nowrap;
  }
  .navbar-links {
    display: flex;
    align-items: center;
    gap: 28px;
    flex-wrap: wrap;
  }
  .navbar-link {
    color: #000000;
    font-family: "PlusJakartaSans-Bold", sans-serif;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: -0.4px;
    text-decoration: none;
    transition: color 0.25s ease-in-out, transform 0.25s ease-in-out;
    white-space: nowrap;
  }
  .navbar-link.active {
    color: #298752;
  }
  .navbar-link:hover {
    color: #298752;
    transform: translateY(-1px);
  }
  .navbar-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
  }
  .navbar-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 36px;
    padding: 0 18px;
    border-radius: 4px;
    font-family: "PlusJakartaSans-Bold", sans-serif;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: -0.4px;
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.25s ease-in-out;
  }
  .navbar-btn-outline {
    background: rgba(15, 118, 67, 0);
    border: 1px solid #0f7643;
    color: #ffffff;
  }
  .navbar-btn-outline:hover {
    background: rgba(41, 135, 82, 0.15);
    border-color: #298752;
    color: #ffffff;
  }
  .navbar-btn-solid {
    background: #064e3b;
    border: 1px solid #0f7643;
    color: #ffffff;
  }
  .navbar-btn-solid:hover {
    background: #056a4c;
    border-color: #056a4c;
    color: #ffffff;
  }

  @media (max-width: 1024px) {
    .site-navbar {
      padding: 12px 20px;
    }
    .navbar-links {
      gap: 16px;
      order: 3;
      width: 100%;
      justify-content: center;
    }
  }

  @media (max-width: 640px) {
    .navbar-brand-text {
      display: none;
    }
    .navbar-btn {
      padding: 0 12px;
      font-size: 13px;
    }
  }
</style>
