<!-- Panitia Sidebar/Topbar Component -->
<div class="rectangle-2"></div>
<div class="background" style="cursor: pointer;" onclick="event.preventDefault(); document.getElementById('panitia-logout-form').submit();" title="Klik untuk keluar">
  <div class="text">AU</div>
</div>
<div class="penguji">Penguji</div>
<img
  class="whats-app-image-2026-06-17-at-23-30-06-removebg-preview-1"
  src="{{ asset('assets/panitia/' . $activeFolder . '/whats-app-image-2026-06-17-at-23-30-06-removebg-preview-10.png') }}"
  alt="Logo"
/>
<div class="page-dashboard">
  <a href="{{ route('panitia.dashboard') }}" style="color: inherit;">Antrean</a> | 
  <a href="#" onclick="event.preventDefault(); document.getElementById('panitia-logout-form').submit();" style="color: inherit;">Keluar</a>
</div>
<div class="penguji2">Penguji</div>
<div class="penguji-pmbm">Penguji PMBM</div>
<div class="penguji-pmbm2">Penguji PMBM</div>

<!-- Logout Form -->
<form id="panitia-logout-form" action="{{ route('panitia.logout') }}" method="POST" style="display: none;">
  @csrf
</form>
