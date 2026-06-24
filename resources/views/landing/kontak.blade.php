@extends('layouts.landing')

@section('title', 'Hubungi Kontak Kami - PMBM MIN 3 Karanganyar')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/landing/kontak/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/landing/kontak/style.css') }}">
@endsection

@section('content')
  <div class="kontak-min-3-kra">
    <!-- Header/Navbar Shared Component -->
    @include('components.navbar', ['activeFolder' => 'kontak'])

    <div class="cek-status-kelulusan" style="color: #064e3b !important; left: 510px; width: 420px;">Hubungi Kontak Kami</div>
    <div class="halaman-resmi-pengumuman-hasil-seleksi-penerimaan-peserta-didik-baru-pmbm-min-3-karanganyar" style="color: #374151 !important; line-height: 1.4; font-weight: 500;">
      Silakan hubungi kontak panitia PMBM MIN 3 Karanganyar jika Anda memerlukan bantuan atau informasi tambahan.
    </div>



    <!-- Dynamic 3-Column Contact & Location Card -->
    <div style="position: absolute; left: 160px; right: 160px; top: 500px; height: 480px; background: #ffffff; border-radius: 16px; border: 1px solid #becabe; padding: 35px; box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; gap: 25px; z-index: 10;">
      <div style="font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 20px; font-weight: 700; color: #064e3b; border-bottom: 2px solid #f0fdf4; padding-bottom: 12px; display: flex; align-items: center; gap: 10px;">
        HUBUNGI KONTAK & LOKASI SEKOLAH
      </div>
      
      <div style="display: flex; gap: 30px; flex: 1;">
        <!-- Kolom 1: Kontak & Medsos -->
        <div style="flex: 1; display: flex; flex-direction: column; gap: 18px;">
          <div style="font-weight: bold; font-size: 13px; color: #064e3b; text-transform: uppercase; letter-spacing: 0.5px; font-family: 'PlusJakartaSans-Bold', sans-serif;">Kontak & Media Sosial</div>
          
          <!-- Telp/WA -->
          <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $landingContent['phone'] ?? '081226676554') }}" target="_blank" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: #374151; transition: color 0.2s;" onmouseover="this.style.color='#0f7643'" onmouseout="this.style.color='#374151'">
            <div style="background: #e8f5e9; color: #0f7643; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">📞</div>
            <div>
              <div style="font-size: 10px; color: #9ca3af; font-weight: bold; font-family: sans-serif;">WHATSAPP / TELEPON</div>
              <div style="font-size: 13px; font-weight: bold; font-family: 'WorkSans-SemiBold', sans-serif;">{{ $landingContent['phone'] ?? '0812-2667-6554' }}</div>
            </div>
          </a>

          <!-- Email -->
          <a href="mailto:{{ $landingContent['email'] ?? 'min3kra@gmail.com' }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: #374151; transition: color 0.2s;" onmouseover="this.style.color='#0f7643'" onmouseout="this.style.color='#374151'">
            <div style="background: #e3f2fd; color: #1e88e5; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">✉️</div>
            <div>
              <div style="font-size: 10px; color: #9ca3af; font-weight: bold; font-family: sans-serif;">EMAIL RESMI</div>
              <div style="font-size: 13px; font-weight: bold; font-family: 'WorkSans-SemiBold', sans-serif;">{{ $landingContent['email'] ?? 'min3kra@gmail.com' }}</div>
            </div>
          </a>

          <!-- Social Media Icons Row -->
          <div style="margin-top: 5px;">
            <div style="font-size: 10px; color: #9ca3af; font-weight: bold; margin-bottom: 8px; font-family: sans-serif;">MEDIA SOSIAL SEKOLAH</div>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
              @if(!empty($landingContent['instagram']))
                <a href="https://instagram.com/{{ $landingContent['instagram'] }}" target="_blank" style="background: #fdf2f8; color: #db2777; padding: 6px 10px; border-radius: 6px; font-size: 11px; font-weight: bold; text-decoration: none; border: 1px solid #fbcfe8; transition: all 0.2s;" onmouseover="this.style.background='#fbcfe8'" onmouseout="this.style.background='#fdf2f8'">
                  Instagram
                </a>
              @endif
              @if(!empty($landingContent['facebook']))
                <a href="https://facebook.com/search/top?q={{ urlencode($landingContent['facebook']) }}" target="_blank" style="background: #eef2ff; color: #4f46e5; padding: 6px 10px; border-radius: 6px; font-size: 11px; font-weight: bold; text-decoration: none; border: 1px solid #c7d2fe; transition: all 0.2s;" onmouseover="this.style.background='#c7d2fe'" onmouseout="this.style.background='#eef2ff'">
                  Facebook
                </a>
              @endif
              @if(!empty($landingContent['youtube']))
                <a href="https://youtube.com/results?search_query={{ urlencode($landingContent['youtube']) }}" target="_blank" style="background: #fef2f2; color: #dc2626; padding: 6px 10px; border-radius: 6px; font-size: 11px; font-weight: bold; text-decoration: none; border: 1px solid #fecaca; transition: all 0.2s;" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fef2f2'">
                  YouTube
                </a>
              @endif
            </div>
          </div>
        </div>

        <!-- Kolom 2: Lokasi Sekolah -->
        <div style="flex: 1; display: flex; flex-direction: column; gap: 15px; border-left: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; padding: 0 25px;">
          <div style="font-weight: bold; font-size: 13px; color: #064e3b; text-transform: uppercase; letter-spacing: 0.5px; font-family: 'PlusJakartaSans-Bold', sans-serif;">Lokasi Sekolah</div>
          
          <div style="display: flex; align-items: flex-start; gap: 12px;">
            <div style="background: #fff8e1; color: #ffb300; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; margin-top: 2px;">📍</div>
            <div>
              <div style="font-size: 10px; color: #9ca3af; font-weight: bold; font-family: sans-serif;">ALAMAT LENGKAP</div>
              <div style="font-size: 13px; font-weight: 500; color: #374151; font-family: 'Roboto-Regular', sans-serif; line-height: 1.5; margin-top: 3px;">
                {{ $landingContent['address'] ?? 'Sroyo, Kec. Jaten, Kabupaten Karanganyar, Jawa Tengah 57731' }}
              </div>
            </div>
          </div>
          
          <div style="background: #f9fafb; border-radius: 8px; padding: 12px; border: 1px solid #e5e7eb; margin-top: auto; font-size: 11px; color: #4b5563; line-height: 1.4; font-family: 'Roboto-Regular', sans-serif;">
            <strong>Petunjuk Operasional:</strong><br>
            Lokasi sekolah kami dapat dicapai dengan mudah menggunakan kendaraan roda dua maupun roda empat melalui Jalan Utama Jaten. Gunakan peta di sebelah kanan untuk petunjuk arah langsung melalui Google Maps.
          </div>
        </div>

        <!-- Kolom 3: Google Maps Iframe -->
        <div style="flex: 1.2; display: flex; flex-direction: column; gap: 12px;">
          <div style="font-weight: bold; font-size: 13px; color: #064e3b; text-transform: uppercase; letter-spacing: 0.5px; font-family: 'PlusJakartaSans-Bold', sans-serif;">Peta Google Maps</div>
          <div style="width: 100%; flex: 1; border-radius: 8px; overflow: hidden; border: 1px solid #becabe; background: #f3f4f6;">
            <iframe 
              src="{{ $landingContent['gmaps_iframe'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.2045558900693!2d110.88796857410499!3d-7.552656974577884!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a170889ec1b5f%3A0x67db23719bc451b6!2sMIN%203%20Karanganyar!5e0!3m2!1sid!2sid!4v1719000000000!5m2!1sid!2sid' }}" 
              width="100%" 
              height="100%" 
              style="border:0;" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Shared Component -->
    @include('components.footer', ['activeFolder' => 'kontak'])
  </div>
@endsection
