@extends('layouts.landing')

@section('title', 'Hubungi Kontak Kami - PMBM MIN 3 Karanganyar')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/landing/kontak/style.css') }}">
@endsection

@section('content')
  <div class="kontak-page">
    @include('components.navbar', ['activeFolder' => 'kontak'])

    <section class="kontak-hero-section">
      <div class="kontak-hero-bg">
        <img src="{{ asset('assets/landing/home/hero-bg.jpg') }}" alt="MIN 3 Karanganyar">
      </div>
      <div class="kontak-hero-content">
        <h1 class="kontak-hero-title">Hubungi Kontak Kami</h1>
        <p class="kontak-hero-subtitle">Jika ada kendala atau pertanyaan hubungi kami.</p>
      </div>
    </section>

    @php
      $addressContact = $schoolContacts->firstWhere('platform_name', 'Alamat');
      $phoneContact = $schoolContacts->firstWhere('platform_name', 'Telepon') ?? $schoolContacts->firstWhere('platform_name', 'WhatsApp');
      $emailContact = $schoolContacts->firstWhere('platform_name', 'Email');
    @endphp

    <section class="kontak-card-section">
      <div class="kontak-card-columns">
        <!-- Kartu Kontak -->
        <div class="kontak-card">
          <div class="kontak-card-title">HUBUNGI KAMI</div>

          <a href="#" onclick="toggleChatbox(); return false;" class="kontak-chat-btn">
            <span>💬</span> Tanya Asisten PMBM
          </a>

          <div class="kontak-info-row">
            <div class="kontak-info-icon">📍</div>
            <div>
              <div class="kontak-info-label">Alamat Lengkap</div>
              <div class="kontak-info-value">
                {{ $addressContact->value ?? 'Sroyo, Kec. Jaten, Kabupaten Karanganyar, Jawa Tengah 57731' }}
              </div>
            </div>
          </div>

          @if($phoneContact)
          <a href="{{ $phoneContact->link }}" target="_blank" class="kontak-info-row">
            <div class="kontak-info-icon">📞</div>
            <div>
              <div class="kontak-info-label">Telepon</div>
              <div class="kontak-info-value">{{ $phoneContact->value }}</div>
            </div>
          </a>
          @endif

          @if($emailContact)
          <a href="{{ $emailContact->link }}" class="kontak-info-row">
            <div class="kontak-info-icon">✉️</div>
            <div>
              <div class="kontak-info-label">Email</div>
              <div class="kontak-info-value">{{ $emailContact->value }}</div>
            </div>
          </a>
          @endif
        </div>

        <!-- Kartu Peta -->
        <div class="kontak-map-card">
          <iframe
            src="https://maps.google.com/maps?q=MIN+3+Karanganyar+Sroyo+Jaten+Karanganyar&output=embed"
            class="kontak-map-img"
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
