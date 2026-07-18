<!-- Admin Sidebar Component -->
<nav class="fixed top-0 left-0 right-0 h-[116px] bg-white flex items-center px-8 z-20 max-[1024px]:h-24 max-[1024px]:px-4">
  <!-- Mobile Hamburger Toggle -->
  <button id="adminSidebarToggle" onclick="document.body.classList.toggle('admin-sidebar-open')" class="hidden max-[1024px]:block mr-3 bg-none border-none cursor-pointer text-[#005b31] p-2" aria-label="Toggle menu">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
  </button>

  <img
    class="w-[58px] h-[58px] object-cover aspect-square shrink-0 max-[1024px]:w-[42px] max-[1024px]:h-[42px]"
    src="{{ asset('assets/admin/' . $activeFolder . '/whats-app-image-2026-06-17-at-23-30-06-removebg-preview-10.png') }}"
    alt="Admin Logo"
  />
  <div class="text-black text-[20px] font-bold tracking-[-0.4px] ml-3 max-[1024px]:text-[15px]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Super Admin</div>
  <div class="text-black text-[20px] font-bold tracking-[-0.4px] ml-9 max-[1024px]:hidden" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Page/Dashboard</div>

  <div class="ml-auto flex items-center gap-4">
    <div class="flex-col items-end max-[1024px]:hidden">
      <div class="text-black text-[20px] font-bold tracking-[-0.4px]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Super Admin</div>
      <div class="text-black/40 text-[15px] font-medium tracking-[-0.4px]" style="font-family: 'Roboto-Medium', sans-serif;">Super Admin</div>
    </div>
    <div class="bg-[#005b31] rounded-full w-[60px] h-[60px] flex items-center justify-center shrink-0 max-[1024px]:w-12 max-[1024px]:h-12">
      <span class="text-white text-[16px] font-semibold" style="font-family: 'WorkSans-SemiBold', sans-serif;">AU</span>
    </div>
  </div>
</nav>

<!-- Mobile Sidebar Backdrop -->
<div id="adminSidebarBackdrop" onclick="document.body.classList.remove('admin-sidebar-open')" class="hidden fixed inset-0 bg-black/40 z-[150] admin-sidebar-backdrop"></div>

<aside class="fixed top-[116px] left-0 w-[355px] bottom-0 bg-[#f8f9ff] flex flex-col z-10 overflow-y-auto max-[1024px]:top-0 max-[1024px]:h-screen max-[1024px]:-translate-x-full max-[1024px]:transition-transform max-[1024px]:duration-300 max-[1024px]:z-[160] admin-sidebar-panel">
  @php($activeFolder = $activeFolder ?? '')
  <a href="{{ route('tata_usaha.dashboard') }}" class="{{ $activeFolder === 'dashboard' ? 'bg-[#005b31]' : 'bg-white hover:bg-gray-50' }} h-[93px] flex items-center px-9 no-underline">
    <span class="{{ $activeFolder === 'dashboard' ? 'text-white' : 'text-[#005b31]' }} text-[20px] font-bold tracking-[-0.4px]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Dashboard</span>
  </a>
  <a href="{{ route('scores.index') }}" class="{{ $activeFolder === 'applicants' ? 'bg-[#005b31]' : 'bg-white hover:bg-gray-50' }} h-[93px] flex items-center px-9 no-underline">
    <span class="{{ $activeFolder === 'applicants' ? 'text-white' : 'text-[#005b31]' }} text-[20px] font-bold tracking-[-0.4px]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Pendaftaran System</span>
  </a>
  @php($pengaturanOpen = $activeFolder === 'periode' || $activeFolder === 'program' || $activeFolder === 'landing-manage' || $activeFolder === 'guide-manage' || $activeFolder === 'contacts' || $activeFolder === 'faqs' || $activeFolder === 'dss')
  <button type="button" onclick="document.getElementById('pengaturanSubmenu').classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')"
          class="{{ $pengaturanOpen ? 'bg-[#005b31]' : 'bg-white hover:bg-gray-50' }} h-[93px] flex items-center justify-between px-9 w-full cursor-pointer">
    <span class="{{ $pengaturanOpen ? 'text-white' : 'text-[#005b31]' }} text-[20px] font-bold tracking-[-0.4px]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Pengaturan</span>
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{{ $pengaturanOpen ? '#ffffff' : '#005b31' }}" stroke-width="2" class="transition-transform {{ $pengaturanOpen ? 'rotate-180' : '' }}"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/></svg>
  </button>
  <div id="pengaturanSubmenu" class="{{ $pengaturanOpen ? '' : 'hidden' }} flex flex-col">
    <a href="{{ route('tata_usaha.periode.index') }}" class="{{ $activeFolder === 'periode' ? 'bg-[#005b31]' : 'bg-white hover:bg-gray-50' }} h-[70px] flex items-center pl-14 pr-9 no-underline">
      <span class="{{ $activeFolder === 'periode' ? 'text-white' : 'text-[#005b31]' }} text-[16px] font-bold">Data Periode</span>
    </a>
    <a href="{{ route('tata_usaha.program.index') }}" class="{{ $activeFolder === 'program' || $activeFolder === 'landing-manage' ? 'bg-[#005b31]' : 'bg-white hover:bg-gray-50' }} h-[70px] flex items-center pl-14 pr-9 no-underline">
      <span class="{{ $activeFolder === 'program' || $activeFolder === 'landing-manage' ? 'text-white' : 'text-[#005b31]' }} text-[16px] font-bold">Kelola Program</span>
    </a>
    <a href="{{ route('tata_usaha.guide') }}" class="{{ $activeFolder === 'guide-manage' ? 'bg-[#005b31]' : 'bg-white hover:bg-gray-50' }} h-[70px] flex items-center pl-14 pr-9 no-underline">
      <span class="{{ $activeFolder === 'guide-manage' ? 'text-white' : 'text-[#005b31]' }} text-[16px] font-bold">Guide Pendaftaran</span>
    </a>
    <a href="{{ route('tata_usaha.contacts.index') }}" class="{{ $activeFolder === 'contacts' ? 'bg-[#005b31]' : 'bg-white hover:bg-gray-50' }} h-[70px] flex items-center pl-14 pr-9 no-underline">
      <span class="{{ $activeFolder === 'contacts' ? 'text-white' : 'text-[#005b31]' }} text-[16px] font-bold">Kontak</span>
    </a>
    <a href="{{ route('tata_usaha.faqs.index') }}" class="{{ $activeFolder === 'faqs' ? 'bg-[#005b31]' : 'bg-white hover:bg-gray-50' }} h-[70px] flex items-center pl-14 pr-9 no-underline">
      <span class="{{ $activeFolder === 'faqs' ? 'text-white' : 'text-[#005b31]' }} text-[16px] font-bold">Pengaturan FAQ</span>
    </a>
    <a href="{{ route('tata_usaha.dss.index') }}" class="{{ $activeFolder === 'dss' ? 'bg-[#005b31]' : 'bg-white hover:bg-gray-50' }} h-[70px] flex items-center pl-14 pr-9 no-underline">
      <span class="{{ $activeFolder === 'dss' ? 'text-white' : 'text-[#005b31]' }} text-[16px] font-bold">DSS</span>
    </a>
  </div>
  
  <a href="{{ route('tata_usaha.tutorial.view') }}" class="{{ $activeFolder === 'tutorial-view' ? 'bg-[#005b31]' : 'bg-white hover:bg-gray-50' }} h-[93px] flex items-center px-9 no-underline">
    <span class="{{ $activeFolder === 'tutorial-view' ? 'text-white' : 'text-[#005b31]' }} text-[20px] font-bold tracking-[-0.4px]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Tutorial Penggunaan</span>
  </a>

  @if(auth()->guard('tata_usaha')->user()->role === 'super admin')
    <a href="{{ route('tata_usaha.accounts') }}" class="{{ $activeFolder === 'users' ? 'bg-[#005b31]' : 'bg-white hover:bg-gray-50' }} h-[93px] flex items-center px-9 no-underline">
      <span class="{{ $activeFolder === 'users' ? 'text-white' : 'text-[#005b31]' }} text-[20px] font-bold tracking-[-0.4px]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Account Management</span>
    </a>
  @endif

  <div class="flex-1 bg-[#f8f9ff]"></div>

  <!-- Logout Form -->
  <form id="logout-form" action="{{ route('tata_usaha.logout') }}" method="POST" class="hidden">
    @csrf
  </form>
  <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="px-9 py-8 no-underline">
    <span class="text-red-600 text-[20px] font-bold tracking-[-0.4px]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Logout</span>
  </a>
</aside>

<style>
  @media (max-width: 1024px) {
    body.admin-sidebar-open .admin-sidebar-panel {
      translate: 0 0;
    }
    body.admin-sidebar-open .admin-sidebar-backdrop {
      display: block;
    }
  }
</style>
