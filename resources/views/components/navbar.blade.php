@php
  $isHomeActive = Request::routeIs('home');
  $isProgramActive = Request::routeIs('landing.program-khusus') || Request::routeIs('landing.program-unggulan') || Request::routeIs('landing.program-fullday');
  $isKelulusanActive = Request::routeIs('landing.cek-kelulusan') || Request::routeIs('student.status.check') || Request::routeIs('landing.hasil-kelulusan');
  $isKontakActive = Request::routeIs('landing.kontak');
  $isOnDark = in_array($activeFolder, ['home', 'program-khusus', 'program-unggulan', 'program-fullday', 'cek-kelulusan', 'hasil-kelulusan', 'kontak']);
@endphp

<!-- Navbar Component -->
<nav class="absolute top-0 left-0 right-0 z-[999] flex flex-wrap items-center justify-between gap-4 px-10 py-4 max-[1024px]:px-5 max-[1024px]:py-3 {{ $isOnDark ? 'bg-transparent' : 'bg-[rgba(196,196,196,0.35)]' }}">
  <a href="{{ route('home') }}" class="flex items-center gap-3 no-underline">
    <img
      class="w-11 h-11 shrink-0 object-cover aspect-square"
      src="{{ asset('assets/landing/' . $activeFolder . '/whats-app-image-2026-06-17-at-23-30-06-removebg-preview-10.png') }}"
      alt="Logo MIN 3 Karanganyar"
    />
    <span class="max-[640px]:hidden whitespace-nowrap text-[16px] font-extrabold tracking-[-0.4px] {{ $isOnDark ? 'text-white' : 'text-[#298752]' }}" style="font-family: 'PlusJakartaSans-ExtraBold', sans-serif;">PMBM MIN 3 KARANGANYAR</span>
  </a>

  <div class="flex flex-wrap items-center gap-7 max-[1024px]:order-3 max-[1024px]:w-full max-[1024px]:justify-center max-[1024px]:gap-4">
    <a href="{{ route('home') }}"
       class="whitespace-nowrap text-[15px] font-bold tracking-[-0.4px] transition-all duration-250 ease-in-out hover:text-[#298752] hover:-translate-y-px {{ $isHomeActive ? 'text-[#298752]' : ($isOnDark ? 'text-white/85' : 'text-black') }}"
       style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Home</a>
    <a href="{{ route('landing.program-khusus') }}"
       class="whitespace-nowrap text-[15px] font-bold tracking-[-0.4px] transition-all duration-250 ease-in-out hover:text-[#298752] hover:-translate-y-px {{ $isProgramActive ? 'text-[#298752]' : ($isOnDark ? 'text-white/85' : 'text-black') }}"
       style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Program</a>
    <a href="{{ route('landing.cek-kelulusan') }}"
       class="whitespace-nowrap text-[15px] font-bold tracking-[-0.4px] transition-all duration-250 ease-in-out hover:text-[#298752] hover:-translate-y-px {{ $isKelulusanActive ? 'text-[#298752]' : ($isOnDark ? 'text-white/85' : 'text-black') }}"
       style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Kelulusan</a>
    <a href="{{ route('landing.kontak') }}"
       class="whitespace-nowrap text-[15px] font-bold tracking-[-0.4px] transition-all duration-250 ease-in-out hover:text-[#298752] hover:-translate-y-px {{ $isKontakActive ? ($isOnDark ? 'text-white underline' : 'text-[#298752]') : ($isOnDark ? 'text-white/85' : 'text-black') }}"
       style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Kontak</a>
  </div>

  <div class="flex flex-wrap items-center gap-3">
    <a href="{{ route('landing.guide') }}"
       class="flex items-center justify-center h-9 px-[18px] max-[640px]:px-3 max-[640px]:text-[13px] rounded text-[15px] font-bold tracking-[-0.4px] whitespace-nowrap transition-all duration-250 ease-in-out text-white bg-[rgba(15,118,67,0)] border border-[#0f7643] hover:bg-[rgba(41,135,82,0.15)] hover:border-[#298752]"
       style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Guide PMBM</a>
    <a href="{{ route('student.register') }}"
       class="flex items-center justify-center h-9 px-[18px] max-[640px]:px-3 max-[640px]:text-[13px] rounded text-[15px] font-bold tracking-[-0.4px] whitespace-nowrap transition-all duration-250 ease-in-out text-white bg-[#064e3b] border border-[#0f7643] hover:bg-[#056a4c] hover:border-[#056a4c]"
       style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Daftar</a>
  </div>
</nav>
