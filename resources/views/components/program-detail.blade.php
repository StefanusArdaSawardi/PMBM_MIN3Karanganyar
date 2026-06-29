@php
  $tabs = [
    ['key' => 'khusus', 'label' => 'Program Khusus (Tahfidz)', 'route' => 'landing.program-khusus'],
    ['key' => 'unggulan', 'label' => 'Program Unggulan (Sains)', 'route' => 'landing.program-unggulan'],
    ['key' => 'fullday', 'label' => 'Program Fullday', 'route' => 'landing.program-fullday'],
  ];
@endphp

<section class="program-detail-hero">
  <div class="program-detail-hero-bg">
    <img src="{{ asset('assets/landing/home/hero-bg.jpg') }}" alt="MIN 3 Karanganyar">
  </div>
  <div class="program-detail-hero-content">
    <h1 class="program-detail-title">Program Pendaftaran PMBM</h1>
    <p class="program-detail-subtitle">Kurikulum yang dirancang khusus untuk mengoptimalkan potensi akademis dan karakter anak didik di era global.</p>

    <div class="program-tabs">
      @foreach($tabs as $tab)
        <a href="{{ route($tab['route']) }}" class="program-tab {{ $activeProgram === $tab['key'] ? 'active' : '' }}">
          {{ $tab['label'] }}
        </a>
      @endforeach
    </div>
  </div>
</section>

<section class="program-detail-body">
  <div class="program-detail-card">
    <img src="{{ $image }}" alt="{{ $title }} Ilustrasi" class="program-detail-image" />

    <div class="program-detail-content">
      <h2 class="program-detail-heading">{{ $title }}</h2>
      <p class="program-detail-desc">{{ $description }}</p>

      <div class="program-feature-list">
        @foreach($features as $feature)
          <div class="program-feature-item">
            <svg class="program-feature-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="10" fill="#0f7643"/>
              <path d="M8 12.5l2.5 2.5L16 9" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>{{ $feature }}</span>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<style>
  .program-detail-hero {
    position: relative;
    overflow: hidden;
    padding: 110px 24px 48px;
    text-align: center;
  }
  .program-detail-hero-bg {
    position: absolute;
    inset: 0;
    z-index: 0;
  }
  .program-detail-hero-bg img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .program-detail-hero-bg::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
  }
  .program-detail-hero-content {
    position: relative;
    z-index: 1;
  }
  .program-detail-title {
    color: #ffffff;
    font-family: "PlusJakartaSans-Bold", sans-serif;
    font-size: clamp(22px, 4vw, 30px);
    font-weight: 700;
    letter-spacing: -0.4px;
    margin: 0 0 12px;
  }
  .program-detail-subtitle {
    color: #ffffff;
    font-family: "Roboto-Regular", sans-serif;
    font-size: 16px;
    max-width: 600px;
    margin: 0 auto 32px;
    line-height: 1.6;
  }
  .program-tabs {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 16px;
  }
  .program-tab {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 191px;
    height: 54px;
    padding: 0 20px;
    border-radius: 8px;
    font-family: "PlusJakartaSans-Bold", sans-serif;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    text-align: center;
    border: 1px solid #bdcab8;
    background: rgba(255, 255, 255, 0.9);
    color: rgba(0, 0, 0, 0.6);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
  }
  .program-tab.active {
    border-color: #0f7643;
    background: #47a26a;
    color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  .program-tab:hover:not(.active) {
    border-color: #298752;
    color: #298752;
  }

  .program-detail-body {
    max-width: 1100px;
    margin: 0 auto;
    padding: 48px 24px 64px;
  }
  .program-detail-card {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 40px;
    align-items: center;
    background: #d9d9d9;
    border: 1px solid #bdcab8;
    border-radius: 12px;
    box-shadow: 0px 4px 4px 0px rgba(255, 255, 255, 0.8);
    padding: 32px;
  }
  .program-detail-image {
    width: 100%;
    height: 327px;
    object-fit: cover;
    border-radius: 8px;
    background: #3f4940;
  }
  .program-detail-content {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }
  .program-detail-heading {
    color: #000000;
    font-family: "PlusJakartaSans-Bold", sans-serif;
    font-size: 25px;
    font-weight: 700;
    letter-spacing: -0.4px;
    margin: 0;
  }
  .program-detail-desc {
    color: rgba(0, 0, 0, 0.5);
    font-family: "Roboto-Regular", sans-serif;
    font-size: 16px;
    line-height: 1.6;
    margin: 0;
  }
  .program-feature-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
    margin-top: 8px;
  }
  .program-feature-item {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    color: #3f4940;
    font-family: "Roboto-Regular", sans-serif;
    font-size: 15px;
    line-height: 1.5;
  }
  .program-feature-icon {
    width: 26px;
    height: 26px;
    flex-shrink: 0;
  }

  @media (max-width: 800px) {
    .program-detail-card {
      grid-template-columns: 1fr;
    }
    .program-detail-image {
      height: 240px;
    }
  }
  @media (max-width: 600px) {
    .program-tab {
      min-width: 0;
      flex: 1 1 calc(50% - 8px);
      font-size: 12px;
      height: 48px;
    }
  }
</style>
