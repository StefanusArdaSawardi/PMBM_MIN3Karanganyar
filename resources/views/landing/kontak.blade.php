@extends('layouts.landing')

@section('title', 'Hubungi Kontak Kami - PMBM MIN 3 Karanganyar')

@section('content')
  <div class="relative bg-[#e5e2e1]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    @include('components.navbar', ['activeFolder' => 'kontak'])

    <section class="relative min-h-[380px] flex items-center overflow-hidden px-6 pt-[110px] pb-12">
      <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('assets/landing/home/hero-bg.jpg') }}" alt="MIN 3 Karanganyar" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/45"></div>
      </div>
      <div class="relative z-[1] w-full max-w-[700px] mx-auto text-center">
        <h1 class="text-white/90 font-bold tracking-[-0.4px] mb-4" style="font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: clamp(22px, 4vw, 30px);">Hubungi Kontak Kami</h1>
        <p class="text-white text-[16px] leading-[1.6] m-0" style="font-family: 'Roboto-Regular', sans-serif;">Jika ada kendala atau pertanyaan hubungi kami.</p>
      </div>
    </section>

    @php
      $addressContact = $schoolContacts->firstWhere('platform_name', 'Alamat');
      $phoneContact = $schoolContacts->firstWhere('platform_name', 'Telepon') ?? $schoolContacts->firstWhere('platform_name', 'WhatsApp');
      $emailContact = $schoolContacts->firstWhere('platform_name', 'Email');
    @endphp

    <section class="max-w-[1200px] mx-auto px-6 -mt-10 mb-16 relative z-[2]">
      <div class="grid grid-cols-[1fr_1.2fr] gap-8 items-start max-[900px]:grid-cols-1">
        <!-- Kartu Kontak -->
        <div class="bg-white rounded-2xl border border-[#d9d9d9] shadow-[0px_4px_4px_rgba(255,255,255,0.8)] p-9 flex flex-col gap-[22px] max-[600px]:p-6">
          <div class="text-[#1c1b1b] text-[20px] font-bold" style="font-family: 'WorkSans-Bold', sans-serif;">HUBUNGI KAMI</div>

          <a href="#" onclick="toggleChatbox(); return false;"
             class="inline-flex items-center justify-center gap-2 bg-[#005b31] text-white text-[15px] font-bold no-underline rounded-xl px-6 py-3 w-fit shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.1),0px_4px_6px_-4px_rgba(0,0,0,0.1)] transition-colors duration-200 hover:bg-[#06713d]"
             style="font-family: 'WorkSans-Bold', sans-serif;">
            <span>💬</span> Tanya Asisten PMBM
          </a>

          <div class="flex items-start gap-3 no-underline text-[#1c1b1b]">
            <div class="w-7 h-7 flex items-center justify-center text-[18px] shrink-0 text-[#064e3b]">📍</div>
            <div>
              <div class="text-[16px] font-bold text-[#1c1b1b] mb-0.5" style="font-family: 'WorkSans-Bold', sans-serif;">Alamat Lengkap</div>
              <div class="text-[16px] text-[#1c1b1b]" style="font-family: 'WorkSans-Regular', sans-serif;">
                {{ $addressContact->value ?? 'Sroyo, Kec. Jaten, Kabupaten Karanganyar, Jawa Tengah 57731' }}
              </div>
            </div>
          </div>

          @if($phoneContact)
          <a href="{{ $phoneContact->link }}" target="_blank" class="flex items-start gap-3 no-underline text-[#1c1b1b]">
            <div class="w-7 h-7 flex items-center justify-center text-[18px] shrink-0 text-[#064e3b]">📞</div>
            <div>
              <div class="text-[16px] font-bold text-[#1c1b1b] mb-0.5" style="font-family: 'WorkSans-Bold', sans-serif;">Telepon</div>
              <div class="text-[16px] text-[#1c1b1b]" style="font-family: 'WorkSans-Regular', sans-serif;">{{ $phoneContact->value }}</div>
            </div>
          </a>
          @endif

          @if($emailContact)
          <a href="{{ $emailContact->link }}" class="flex items-start gap-3 no-underline text-[#1c1b1b]">
            <div class="w-7 h-7 flex items-center justify-center text-[18px] shrink-0 text-[#064e3b]">✉️</div>
            <div>
              <div class="text-[16px] font-bold text-[#1c1b1b] mb-0.5" style="font-family: 'WorkSans-Bold', sans-serif;">Email</div>
              <div class="text-[16px] text-[#1c1b1b]" style="font-family: 'WorkSans-Regular', sans-serif;">{{ $emailContact->value }}</div>
            </div>
          </a>
          @endif
        </div>

        <!-- Kartu Peta -->
        <div class="bg-white rounded-2xl border border-[#d9d9d9] overflow-hidden min-h-[378px] flex max-[900px]:min-h-[280px]">
          <iframe
            src="https://maps.google.com/maps?q=MIN+3+Karanganyar+Sroyo+Jaten+Karanganyar&output=embed"
            class="w-full flex-1 border-0 block"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>
    </section>

    @include('components.footer', ['activeFolder' => 'kontak'])
  </div>
@endsection
