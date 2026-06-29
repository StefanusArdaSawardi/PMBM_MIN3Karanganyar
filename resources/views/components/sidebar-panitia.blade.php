<!-- Panitia Sidebar/Topbar Component -->
<div class="rectangle-2"></div>
<img
  class="whats-app-image-2026-06-17-at-23-30-06-removebg-preview-1"
  src="{{ asset('assets/panitia/' . $activeFolder . '/whats-app-image-2026-06-17-at-23-30-06-removebg-preview-10.png') }}"
  alt="Logo"
/>
<div class="penguji">Penguji</div>
<div class="page-dashboard">
  <a href="{{ route('panitia.dashboard') }}" style="color: inherit;">Antrean</a> |
  <a href="#" onclick="event.preventDefault(); document.getElementById('panitia-logout-form').submit();" style="color: inherit;">Keluar</a>
</div>

<div class="panitia-profile-box">
  <div class="panitia-profile-text">
    <div class="penguji2">Penguji</div>
    <div class="penguji-pmbm">Penguji PMBM</div>
  </div>
  <div class="background" style="cursor: pointer;" onclick="event.preventDefault(); document.getElementById('panitia-logout-form').submit();" title="Klik untuk keluar">
    <div class="text">AU</div>
  </div>
</div>

<!-- Logout Form -->
<form id="panitia-logout-form" action="{{ route('panitia.logout') }}" method="POST" style="display: none;">
  @csrf
</form>

<style>
  .panitia-profile-box {
    position: absolute;
    right: 24px;
    top: 0;
    height: 96px;
    display: flex;
    align-items: center;
    z-index: 100;
  }
  @media (min-width: 1025px) {
    .panitia-profile-box {
      height: 116px;
    }
  }
  .panitia-profile-text {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
  }
  .panitia-profile-box .penguji2,
  .panitia-profile-box .penguji-pmbm {
    position: static !important;
    left: auto !important;
    top: auto !important;
  }
  .panitia-profile-box .background {
    position: static !important;
    left: auto !important;
    top: auto !important;
    margin-left: 16px;
  }

  @media (max-width: 1024px) {
    .rectangle-2 {
      height: 96px !important;
    }
    .penguji {
      left: 64px !important;
      top: 24px !important;
      font-size: 16px !important;
    }
    .whats-app-image-2026-06-17-at-23-30-06-removebg-preview-1 {
      left: 16px !important;
      top: 19px !important;
      width: 42px !important;
      height: 42px !important;
    }
    .page-dashboard {
      left: 16px !important;
      top: 70px !important;
      font-size: 13px !important;
    }
    .panitia-profile-text {
      display: none !important;
    }
  }
</style>
