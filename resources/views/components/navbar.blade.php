@php
  $isHomeActive = Request::routeIs('home');
  $isProgramActive = Request::routeIs('landing.program-khusus') || Request::routeIs('landing.program-unggulan') || Request::routeIs('landing.program-fullday');
  $isKelulusanActive = Request::routeIs('landing.cek-kelulusan') || Request::routeIs('student.status.check') || Request::routeIs('landing.hasil-kelulusan');
  $isKontakActive = Request::routeIs('landing.kontak');
@endphp

<!-- Navbar Component -->
<div class="rectangle-2"></div>
<div class="pmbm-min-3-karanganyar">PMBM MIN 3 KARANGANYAR</div>
<img
  class="whats-app-image-2026-06-17-at-23-30-06-removebg-preview-1"
  src="{{ asset('assets/landing/' . $activeFolder . '/whats-app-image-2026-06-17-at-23-30-06-removebg-preview-10.png') }}"
  alt="Logo MIN 3 Karanganyar"
/>
<a href="{{ route('home') }}" class="home {{ $isHomeActive ? 'active' : '' }}" style="cursor: pointer;">Home</a>
<a href="{{ route('landing.program-khusus') }}" class="program {{ $isProgramActive ? 'active' : '' }}" style="cursor: pointer;">Program</a>
<a href="{{ route('landing.cek-kelulusan') }}" class="kelulusan {{ $isKelulusanActive ? 'active' : '' }}" style="cursor: pointer;">Kelulusan</a>
<a href="{{ route('landing.kontak') }}" class="kontak {{ $isKontakActive ? 'active' : '' }}" style="cursor: pointer;">Kontak</a>

<!-- Guide PMBM Button -->
<a href="{{ route('landing.guide') }}" class="rectangle-3" style="cursor: pointer;"></a>
<a href="{{ route('landing.guide') }}" class="guide-pmbm" style="cursor: pointer;">Guide PMBM</a>

<!-- Daftar Button -->
<a href="{{ route('student.register') }}" class="rectangle-4" style="cursor: pointer;"></a>
<a href="{{ route('student.register') }}" class="daftar" style="cursor: pointer;">Daftar</a>

<style>
  /* Unified navbar styling matching the Home page format */
  .rectangle-2 {
    background: rgba(196, 196, 196, 0.35) !important;
    width: 1440px !important;
    position: absolute !important;
    left: 0px !important;
    top: 0px !important;
    z-index: 999 !important;
  }
  
  .pmbm-min-3-karanganyar {
    color: #298752 !important; /* Theme green */
    text-align: left !important;
    font-family: "PlusJakartaSans-ExtraBold", sans-serif !important;
    font-size: 20px !important;
    line-height: 24px !important;
    letter-spacing: -0.4px !important;
    font-weight: 800 !important;
    position: absolute !important;
    left: 253px !important;
    top: 50px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    z-index: 1000 !important;
  }
  
  .whats-app-image-2026-06-17-at-23-30-06-removebg-preview-1 {
    width: 58px !important;
    height: 58px !important;
    position: absolute !important;
    left: 190px !important;
    top: 29px !important;
    object-fit: cover !important;
    aspect-ratio: 1 !important;
    z-index: 1000 !important;
  }
  
  /* Menu Items Common Styles */
  .home, .program, .kelulusan, .kontak {
    text-align: left !important;
    font-family: "PlusJakartaSans-Bold", sans-serif !important;
    font-size: 15px !important;
    line-height: 24px !important;
    letter-spacing: -0.4px !important;
    font-weight: 700 !important;
    position: absolute !important;
    top: 46px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    transition: all 0.25s ease-in-out !important;
    cursor: pointer !important;
    z-index: 1000 !important;
    pointer-events: auto !important;
  }
  
  .home { left: 601px !important; }
  .program { left: 678px !important; }
  .kelulusan { left: 776px !important; }
  .kontak { left: 888px !important; }
  
  /* Active states & Colors */
  .home {
    color: {{ $isHomeActive ? '#298752' : '#000000' }} !important;
  }
  .program {
    color: {{ $isProgramActive ? '#298752' : '#000000' }} !important;
  }
  .kelulusan {
    color: {{ $isKelulusanActive ? '#298752' : '#000000' }} !important;
  }
  .kontak {
    color: {{ $isKontakActive ? '#298752' : '#000000' }} !important;
  }
  
  /* Hover effects */
  .home:hover, .program:hover, .kelulusan:hover, .kontak:hover {
    color: #298752 !important; /* Theme green */
    transform: translateY(-1px) !important;
  }
  
  /* Buttons Positioning and Styles */
  .rectangle-3 {
    background: rgba(15, 118, 67, 0) !important;
    border: 1px solid #0f7643 !important;
    width: 107px !important;
    height: 36px !important;
    position: absolute !important;
    left: 1022px !important;
    top: 40px !important;
    border-radius: 4px !important;
    transition: all 0.25s ease-in-out !important;
    z-index: 1000 !important;
  }
  .rectangle-3:hover {
    background: rgba(41, 135, 82, 0.15) !important;
    border-color: #298752 !important;
  }
  
  .guide-pmbm {
    color: rgba(15, 118, 67, 0.8) !important;
    text-align: left !important;
    font-family: "PlusJakartaSans-Bold", sans-serif !important;
    font-size: 15px !important;
    line-height: 24px !important;
    letter-spacing: -0.4px !important;
    font-weight: 700 !important;
    position: absolute !important;
    left: 1029px !important;
    top: 46px !important;
    width: 90px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    pointer-events: none !important; /* Let clicks pass through to the rectangle-3 link */
    z-index: 1001 !important;
  }
  
  .rectangle-4 {
    background: #064e3b !important;
    border: 1px solid #0f7643 !important;
    width: 107px !important;
    height: 36px !important;
    position: absolute !important;
    left: 1142px !important;
    top: 40px !important;
    border-radius: 4px !important;
    transition: all 0.25s ease-in-out !important;
    z-index: 1000 !important;
  }
  .rectangle-4:hover {
    background: #064e3b !important;
    border-color: #064e3b !important;
  }
  
  .daftar {
    color: rgba(255, 255, 255, 0.8) !important;
    text-align: center !important;
    font-family: "PlusJakartaSans-Bold", sans-serif !important;
    font-size: 15px !important;
    line-height: 24px !important;
    letter-spacing: -0.4px !important;
    font-weight: 700 !important;
    position: absolute !important;
    left: 1172px !important;
    top: 46px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    pointer-events: none !important; /* Let clicks pass through to the rectangle-4 link */
    z-index: 1001 !important;
  }
</style>

