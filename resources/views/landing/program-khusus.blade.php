@extends('layouts.landing')

@section('title', 'Program Khusus Tahfidz - PMBM MIN 3 Karanganyar')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/landing/program-khusus/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/landing/program-khusus/style.css') }}">
@endsection

@section('content')
  <div class="pmbm-program-khusus">
    <!-- Header/Navbar Shared Component -->
    @include('components.navbar', ['activeFolder' => 'program-khusus'])

    <div class="program-pendaftaran-pmbm" style="color: #064e3b !important; left: 518px; width: 420px;">Program Pendaftaran PMBM</div>
    <div class="kurikulum-yang-dirancang-khusus-untuk-mengoptimalkan-potensi-akademis-dan-karakter-anak-didik-di-era-global" style="color: #374151 !important; line-height: 1.4; font-weight: 500;">
      Kurikulum yang dirancang khusus untuk mengoptimalkan potensi akademis dan
      karakter anak didik di era global.
    </div>



    <!-- Program Details -->
    <div class="rectangle-19"></div>
    <div class="fokus-pada-hafalan-al-qur-an-dengan-tajwid-yang-benar-serta-pemahaman-nilai-nilai-spiritual">
      Fokus pada hafalan Al-Qur’an dengan tajwid yang benar serta pemahaman
      nilai-nilai spiritual.
    </div>
    <div class="program-khusus-tahfidz">Program Khusus (Tahfidz)</div>
    
    <div class="rectangle-11"></div>
    <!-- Unified Tab Navigation Program -->
    <div style="position: absolute; left: 410px; top: 541px; display: flex; gap: 33px; z-index: 20;">
      <a href="{{ route('landing.program-khusus') }}" style="display: flex; align-items: center; justify-content: center; width: 191px; height: 54px; border-radius: 8px; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 14px; font-weight: 700; text-decoration: none; text-align: center; border: 1px solid #0f7643; background: #47a26a; color: #ffffff; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        Program Khusus (Tahfidz)
      </a>
      <a href="{{ route('landing.program-unggulan') }}" style="display: flex; align-items: center; justify-content: center; width: 191px; height: 54px; border-radius: 8px; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 14px; font-weight: 700; text-decoration: none; text-align: center; border: 1px solid #bdcab8; background: rgba(255, 255, 255, 0.9); color: rgba(0, 0, 0, 0.6); transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        Program Unggulan (Sains)
      </a>
      <a href="{{ route('landing.program-fullday') }}" style="display: flex; align-items: center; justify-content: center; width: 191px; height: 54px; border-radius: 8px; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 14px; font-weight: 700; text-decoration: none; text-align: center; border: 1px solid #bdcab8; background: rgba(255, 255, 255, 0.9); color: rgba(0, 0, 0, 0.6); transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        Program Fullday
      </a>
    </div>
    
    <img
      class="save-clip-app-475343519-1307796727230381-3144782383292744901-n-1"
      src="{{ asset('assets/landing/program-khusus/save-clip-app-475343519-1307796727230381-3144782383292744901-n-10.png') }}"
      alt="Program Tahfidz Ilustrasi"
    />
    
    <!-- Feature Checkmarks & Points (Dynamic Flex Container) -->
    <div style="position: absolute; left: 665px; top: 891px; width: 450px; display: flex; flex-direction: column; gap: 12px; z-index: 10;">
      <!-- Item 1 -->
      <div style="display: flex; align-items: flex-start; gap: 13px;">
        <img src="{{ asset('assets/landing/program-khusus/check-fill0.svg') }}" alt="Icon" style="width: 30px; height: 30px; flex-shrink: 0;" />
        <div style="color: #3f4940; text-align: left; font-family: 'Roboto-Regular', sans-serif; font-size: 15px; line-height: 24px; letter-spacing: -0.4px; font-weight: 400; padding-top: 3px;">
          Tahfidz Intensif
        </div>
      </div>
      <!-- Item 2 -->
      <div style="display: flex; align-items: flex-start; gap: 13px;">
        <img src="{{ asset('assets/landing/program-khusus/check-fill1.svg') }}" alt="Icon" style="width: 30px; height: 30px; flex-shrink: 0;" />
        <div style="color: #3f4940; text-align: left; font-family: 'Roboto-Regular', sans-serif; font-size: 15px; line-height: 24px; letter-spacing: -0.4px; font-weight: 400; padding-top: 3px;">
          Bahasa Arab Dasar
        </div>
      </div>
      <!-- Item 3 -->
      <div style="display: flex; align-items: flex-start; gap: 13px;">
        <img src="{{ asset('assets/landing/program-khusus/check-fill2.svg') }}" alt="Icon" style="width: 30px; height: 30px; flex-shrink: 0;" />
        <div style="color: #3f4940; text-align: left; font-family: 'Roboto-Regular', sans-serif; font-size: 15px; line-height: 24px; letter-spacing: -0.4px; font-weight: 400; padding-top: 3px;">
          Pembinaan Akhlak &amp; Karakter Islami
        </div>
      </div>
    </div>
    
    <!-- Footer Shared Component -->
    @include('components.footer', ['activeFolder' => 'program-khusus'])
  </div>
@endsection
