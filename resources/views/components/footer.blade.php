@php
  $addressContact = $schoolContacts->firstWhere('platform_name', 'Alamat');
  $phoneContact = $schoolContacts->firstWhere('platform_name', 'Telepon') ?? $schoolContacts->firstWhere('platform_name', 'WhatsApp');
  $emailContact = $schoolContacts->firstWhere('platform_name', 'Email');
@endphp

<!-- Footer Component -->
<footer class="bg-[#064e3b] text-[#f8f9ff] px-10 py-14 pb-6 mt-[60px] max-[640px]:px-5 max-[640px]:py-10 max-[640px]:pb-5">
  <div class="max-w-[1280px] mx-auto grid grid-cols-[1.4fr_1fr_1fr_1.2fr] gap-8 max-[1024px]:grid-cols-2 max-[1024px]:gap-x-6 max-[1024px]:gap-y-8 max-[640px]:grid-cols-1 max-[640px]:gap-7">
    <div class="flex flex-col gap-4">
      <div class="text-[16px] text-[#7ed99c]" style="font-family: 'PlusJakartaSans-Regular', sans-serif;">PMBM SCHOOL</div>
      <p class="text-[16px] leading-[1.5] text-[#f8f9ff] opacity-70" style="font-family: 'WorkSans-Regular', sans-serif;">
        Lembaga pendidikan unggulan yang berkomitmen melahirkan generasi cerdas,
        berintegritas tinggi, berakhlak mulia, dan siap bersaing di kancah global.
      </p>
    </div>

    <div class="flex flex-col gap-4">
      <div class="text-[16px] text-[#f8f9ff]" style="font-family: 'WorkSans-Regular', sans-serif;">JELAJAH</div>
      <ul class="flex flex-col gap-2 opacity-80">
        <li><a href="{{ route('home') }}" class="text-[16px] text-[#f8f9ff] no-underline hover:underline" style="font-family: 'WorkSans-Regular', sans-serif;">Home</a></li>
        <li><a href="{{ route('landing.program-khusus') }}" class="text-[16px] text-[#f8f9ff] no-underline hover:underline" style="font-family: 'WorkSans-Regular', sans-serif;">Program Studi</a></li>
        <li><a href="{{ route('home') }}#alur-pmb" class="text-[16px] text-[#f8f9ff] no-underline hover:underline" style="font-family: 'WorkSans-Regular', sans-serif;">Alur PMB</a></li>
        <li><a href="{{ route('landing.cek-kelulusan') }}" class="text-[16px] text-[#f8f9ff] no-underline hover:underline" style="font-family: 'WorkSans-Regular', sans-serif;">Cek Kelulusan</a></li>
      </ul>
    </div>

    <div class="flex flex-col gap-4">
      <div class="text-[16px] text-[#f8f9ff]" style="font-family: 'WorkSans-Regular', sans-serif;">GUIDE</div>
      <ul class="flex flex-col gap-2 opacity-80">
        <li><a href="{{ route('landing.guide') }}" class="text-[16px] text-[#f8f9ff] no-underline hover:underline" style="font-family: 'WorkSans-Regular', sans-serif;">Syarat Pendaftaran</a></li>
        <li><a href="{{ route('landing.guide') }}" class="text-[16px] text-[#f8f9ff] no-underline hover:underline" style="font-family: 'WorkSans-Regular', sans-serif;">Jadwal Pendaftaran</a></li>
        <li><a href="{{ route('student.register') }}" class="text-[16px] text-[#f8f9ff] no-underline hover:underline" style="font-family: 'WorkSans-Regular', sans-serif;">Pendaftaran PMBM</a></li>
        <li><a href="{{ route('landing.guide') }}" class="text-[16px] text-[#f8f9ff] no-underline hover:underline" style="font-family: 'WorkSans-Regular', sans-serif;">Panduan Booklet</a></li>
        <li><a href="{{ route('landing.cek-kelulusan') }}" class="text-[16px] text-[#f8f9ff] no-underline hover:underline" style="font-family: 'WorkSans-Regular', sans-serif;">Cek Kelulusan</a></li>
      </ul>
    </div>

    <div class="flex flex-col gap-4">
      <div class="text-[16px] text-[#f8f9ff]" style="font-family: 'WorkSans-Regular', sans-serif;">HUBUNGI KAMI</div>
      <ul class="flex flex-col gap-4">
        <li class="flex items-start gap-2.5">
          <svg class="w-5 h-5 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s-7-7.5-7-12a7 7 0 1 1 14 0c0 4.5-7 12-7 12z" stroke="#f8f9ff" stroke-width="1.5"/><circle cx="12" cy="9" r="2.5" stroke="#f8f9ff" stroke-width="1.5"/></svg>
          @if($addressContact)
            <a href="{{ $addressContact->link }}" target="_blank" class="text-[16px] text-[#f8f9ff] no-underline hover:underline" style="font-family: 'WorkSans-Regular', sans-serif;">{{ $addressContact->value }}</a>
          @else
            <span class="text-[16px] text-[#f8f9ff]" style="font-family: 'WorkSans-Regular', sans-serif;">{{ $landingContent['address'] ?? 'Sroyo, Kec. Jaten, Kabupaten Karanganyar, Jawa Tengah 57731' }}</span>
          @endif
        </li>
        <li class="flex items-start gap-2.5">
          <svg class="w-5 h-5 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 5c0-1.1.9-2 2-2h2.2c.5 0 1 .4 1.1.9l1 4a1 1 0 0 1-.3 1L7.6 10c1 2 2.9 4 5 5l1.1-1.4a1 1 0 0 1 1-.3l4 1c.5.1.9.6.9 1.1V18c0 1.1-.9 2-2 2h-1C9.5 20 4 14.5 4 7V6" stroke="#f8f9ff" stroke-width="1.5"/></svg>
          @if($phoneContact)
            <a href="{{ $phoneContact->link }}" class="text-[16px] text-[#f8f9ff] no-underline hover:underline" style="font-family: 'WorkSans-Regular', sans-serif;">{{ $phoneContact->value }}</a>
          @else
            <span class="text-[16px] text-[#f8f9ff]" style="font-family: 'WorkSans-Regular', sans-serif;">{{ $landingContent['phone'] ?? '0812-2667-6554' }}</span>
          @endif
        </li>
        <li class="flex items-start gap-2.5">
          <svg class="w-5 h-5 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="16" height="16" rx="2" stroke="#f8f9ff" stroke-width="1.5"/><path d="M4 6l8 6 8-6" stroke="#f8f9ff" stroke-width="1.5"/></svg>
          @if($emailContact)
            <a href="{{ $emailContact->link }}" class="text-[16px] text-[#f8f9ff] no-underline hover:underline" style="font-family: 'WorkSans-Regular', sans-serif;">{{ $emailContact->value }}</a>
          @else
            <span class="text-[16px] text-[#f8f9ff]" style="font-family: 'WorkSans-Regular', sans-serif;">{{ $landingContent['email'] ?? 'min3kra@gmail.com' }}</span>
          @endif
        </li>
      </ul>
    </div>
  </div>

  <div class="max-w-[1280px] mx-auto mt-10 pt-5 border-t border-white/10 flex items-center justify-between flex-wrap gap-3 max-[640px]:flex-col max-[640px]:items-start">
    <div class="text-[14px] opacity-50" style="font-family: 'WorkSans-Regular', sans-serif;">© 2026 PMBM School. All Rights Reserved.</div>
    <div class="flex items-center gap-1 text-[14px] opacity-60" style="font-family: 'WorkSans-Regular', sans-serif;">
      <span>Designed with</span>
      <img src="{{ asset('assets/landing/' . $activeFolder . '/container5.svg') }}" alt="Heart" class="w-2.5 h-auto" />
      <span>for Education</span>
    </div>
  </div>
</footer>
