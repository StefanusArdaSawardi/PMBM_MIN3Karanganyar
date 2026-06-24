<!-- Admin Sidebar Component -->
<div class="rectangle-2"></div>

<div class="admin-portal">Admin Portal</div>
<img
  class="whats-app-image-2026-06-17-at-23-30-06-removebg-preview-1"
  src="{{ asset('assets/admin/' . $activeFolder . '/whats-app-image-2026-06-17-at-23-30-06-removebg-preview-10.png') }}"
  alt="Admin Logo"
/>
<div class="page-dashboard">Page/Dashboard</div>

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

<!-- Profile Section Top Right -->
<div style="position: absolute; right: 40px; top: 0; height: 116px; display: flex; align-items: center; gap: 16px; z-index: 100;">
  <div style="display: flex; flex-direction: column; align-items: flex-end; justify-content: center; gap: 2px;">
    <div style="color: #000000; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 16px; font-weight: 700; line-height: 1.2;">Admin Portal</div>
    <div style="color: rgba(0, 0, 0, 0.4); font-family: 'Roboto-Medium', sans-serif; font-size: 12px; font-weight: 500; line-height: 1.2;">Admin Tata Usaha</div>
  </div>
  <div style="background: #005b31; border-radius: 50%; display: flex; align-items: center; justify-content: center; width: 48px; height: 48px; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0, 91, 49, 0.15);">
    <div style="color: #ffffff; font-family: 'WorkSans-SemiBold', sans-serif; font-size: 14px; font-weight: 600;">AU</div>
  </div>
</div>
