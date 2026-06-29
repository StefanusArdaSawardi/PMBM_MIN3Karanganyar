<!-- Panitia Sidebar/Topbar Component -->
<nav class="absolute top-0 left-0 right-0 h-[116px] bg-[#d9d9d9] flex items-center px-[34px] max-[1024px]:h-24 max-[1024px]:px-4">
  <img
    class="w-[58px] h-[58px] object-cover aspect-square shrink-0 max-[1024px]:w-[42px] max-[1024px]:h-[42px]"
    src="{{ asset('assets/panitia/' . $activeFolder . '/whats-app-image-2026-06-17-at-23-30-06-removebg-preview-10.png') }}"
    alt="Logo"
  />
  <div class="flex flex-col ml-3 max-[1024px]:ml-2">
    <div class="text-black text-[20px] font-bold tracking-[-0.4px] max-[1024px]:text-[16px]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Penguji</div>
    <div class="text-black text-[14px] font-bold tracking-[-0.4px] max-[1024px]:text-[13px]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">
      <a href="{{ route('panitia.dashboard') }}" class="text-inherit no-underline">Antrean</a> |
      <a href="#" onclick="event.preventDefault(); document.getElementById('panitia-logout-form').submit();" class="text-inherit no-underline">Keluar</a>
    </div>
  </div>

  <div class="ml-auto flex items-center gap-4">
    <div class="flex-col items-end max-[1024px]:hidden">
      <div class="text-black text-[20px] font-bold tracking-[-0.4px]" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Penguji</div>
      <div class="text-black/40 text-[15px] font-medium tracking-[-0.4px]" style="font-family: 'Roboto-Medium', sans-serif;">Penguji PMBM</div>
    </div>
    <div class="bg-[#005b31] rounded-full w-[60px] h-[60px] flex items-center justify-center cursor-pointer shrink-0 max-[1024px]:w-12 max-[1024px]:h-12"
         onclick="event.preventDefault(); document.getElementById('panitia-logout-form').submit();" title="Klik untuk keluar">
      <span class="text-white text-[16px] font-semibold" style="font-family: 'WorkSans-SemiBold', sans-serif;">AU</span>
    </div>
  </div>
</nav>

<!-- Logout Form -->
<form id="panitia-logout-form" action="{{ route('panitia.logout') }}" method="POST" class="hidden">
  @csrf
</form>
