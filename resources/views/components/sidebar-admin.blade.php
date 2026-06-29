<!-- Admin Sidebar Component -->
<div class="rectangle-2"></div>

<!-- Mobile Hamburger Toggle -->
<button id="adminSidebarToggle" onclick="document.body.classList.toggle('admin-sidebar-open')" class="admin-sidebar-toggle" aria-label="Toggle menu">
  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
</button>

<div class="admin-portal">Admin Portal</div>
<img
  class="whats-app-image-2026-06-17-at-23-30-06-removebg-preview-1"
  src="{{ asset('assets/admin/' . $activeFolder . '/whats-app-image-2026-06-17-at-23-30-06-removebg-preview-10.png') }}"
  alt="Admin Logo"
/>
<div class="page-dashboard">Page/Dashboard</div>

<!-- Mobile Sidebar Backdrop -->
<div id="adminSidebarBackdrop" onclick="document.body.classList.remove('admin-sidebar-open')" class="admin-sidebar-backdrop"></div>

<div class="admin-sidebar-panel">
  <div class="rectangle-129"></div>
  <div class="rectangle-130"></div>
  <div class="rectangle-131"></div>
  <div class="rectangle-132"></div>
  <div class="rectangle-133"></div>

  <a href="{{ route('tata_usaha.dashboard') }}" class="dashboard">Dashboard</a>
  <a href="{{ route('tata_usaha.content') }}" class="screening">Kelola Konten</a>
  <a href="{{ route('scores.index') }}" class="applicant-list">Pendaftaran</a>
  <a href="{{ route('tata_usaha.accounts') }}" class="account-management">Kelola Akun</a>

  <!-- Logout Form -->
  <form id="logout-form" action="{{ route('tata_usaha.logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
  <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout">Keluar</a>
</div>

<!-- Profile Section Top Right -->
<div class="admin-profile-box" style="position: absolute; right: 40px; top: 0; height: 116px; display: flex; align-items: center; gap: 16px; z-index: 100;">
  <div class="admin-profile-text" style="display: flex; flex-direction: column; align-items: flex-end; justify-content: center; gap: 2px;">
    <div style="color: #000000; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 16px; font-weight: 700; line-height: 1.2;">Admin Portal</div>
    <div style="color: rgba(0, 0, 0, 0.4); font-family: 'Roboto-Medium', sans-serif; font-size: 12px; font-weight: 500; line-height: 1.2;">Admin Tata Usaha</div>
  </div>
  <div style="background: #005b31; border-radius: 50%; display: flex; align-items: center; justify-content: center; width: 48px; height: 48px; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0, 91, 49, 0.15);">
    <div style="color: #ffffff; font-family: 'WorkSans-SemiBold', sans-serif; font-size: 14px; font-weight: 600;">AU</div>
  </div>
</div>

<style>
  .admin-sidebar-toggle {
    display: none;
    position: fixed;
    left: 16px;
    top: 58px;
    transform: translateY(-50%);
    z-index: 200;
    background: none;
    border: none;
    cursor: pointer;
    color: #005b31;
    padding: 8px;
  }
  .admin-sidebar-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.4);
    z-index: 150;
  }

  @media (max-width: 1024px) {
    .admin-sidebar-toggle {
      display: block;
    }
    .admin-portal {
      left: 110px !important;
      font-size: 15px !important;
    }
    .whats-app-image-2026-06-17-at-23-30-06-removebg-preview-1 {
      left: 56px !important;
      width: 42px !important;
      height: 42px !important;
    }
    .page-dashboard {
      display: none !important;
    }
    .admin-profile-box {
      right: 16px !important;
    }
    .admin-profile-text {
      display: none !important;
    }
    .admin-sidebar-panel {
      position: fixed;
      left: 0;
      top: 0;
      width: 310px;
      height: 100vh;
      z-index: 160;
      transform: translateX(-100%);
      transition: transform 0.25s ease;
    }
    .admin-sidebar-panel .rectangle-129 {
      height: 100vh;
    }
    body.admin-sidebar-open .admin-sidebar-panel {
      transform: translateX(0);
    }
    body.admin-sidebar-open .admin-sidebar-backdrop {
      display: block;
    }
  }
</style>
