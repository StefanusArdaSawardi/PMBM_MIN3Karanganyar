@extends('layouts.landing')

@section('title', 'CMS PMBM - Masuk ke Sistem')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/login/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/login/style.css') }}">
@endsection

@section('content')
  <div class="desktop-13">
    <img
      class="whats-app-image-2026-06-17-at-23-30-06-removebg-preview-1"
      src="{{ asset('assets/login/whats-app-image-2026-06-17-at-23-30-06-removebg-preview-10.png') }}"
      alt="Logo MIN 3 KRA"
    />
    <div class="silakan-masuk-ke-sistem-pengelolaan-pendaftaran">
      Silakan masuk ke sistem pengelolaan
      <br />
      pendaftaran
    </div>
    <div class="cms-pmbm">CMS PMBM</div>
    
    <div class="login-card">
      <form action="{{ route('login') }}" method="POST" class="form">
        @csrf

        <!-- Error Flash Message -->
        @if($errors->any())
          <div style="padding: 12px; background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; font-family: sans-serif; font-size: 12px; border-radius: 8px; margin-bottom: 20px; line-height: 16px;">
            {{ $errors->first() }}
          </div>
        @endif

        <!-- Guard Role Dropdown -->
        <div class="role-dropdown">
          <div class="label">
            <div class="masuk-sebagai">Masuk Sebagai</div>
          </div>
          <div class="container" style="position: relative; border: none; padding: 0;">
            <select name="role" style="width: 100%; height: 100%; padding: 0 45px 0 20px; font-family: inherit; font-size: 14px; font-weight: bold; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; background: #ffffff; cursor: pointer; -webkit-appearance: none; -moz-appearance: none; appearance: none;">
              <option value="tata_usaha">Pengurus Tata Usaha / Admin</option>
              <option value="panitia">Panitia Penguji / Wawancara</option>
            </select>
            <div class="container2" style="pointer-events: none; position: absolute; right: 15px; top: 50%; transform: translateY(-50%);">
              <img class="container3" src="{{ asset('assets/login/container3.svg') }}" />
            </div>
          </div>
        </div>

        <!-- Email Field -->
        <div class="email-field">
          <div class="label">
            <div class="alamat-email">Alamat Email</div>
          </div>
          <div class="container" style="position: relative; border: none; padding: 0;">
            <input 
              type="email" 
              name="email" 
              required 
              placeholder="admin@email.com" 
              style="width: 100%; height: 100%; padding: 0 45px 0 20px; font-family: inherit; font-size: 14px; color: #1f2937; border: 1px solid #d1d5db; border-radius: 8px; background: #ffffff;"
              value="{{ old('email') }}"
            />
            <div class="container5" style="pointer-events: none; position: absolute; right: 15px; top: 50%; transform: translateY(-50%);">
              <img class="container6" src="{{ asset('assets/login/container7.svg') }}" />
            </div>
          </div>
        </div>

        <!-- Password Field -->
        <div class="password-field">
          <div class="container7" style="margin-bottom: 8px; display: flex; justify-content: space-between;">
            <div class="label2">
              <div class="text" style="position: static;">Kata Sandi</div>
            </div>
            <div class="link">
              <a href="#" onclick="alert('Silakan hubungi Super Admin/Kepala Sekolah untuk menyetel ulang sandi Anda.')" class="text2" style="position: static;">Lupa sandi?</a>
            </div>
          </div>
          <div class="container" style="position: relative; border: none; padding: 0;">
            <input 
              type="password" 
              name="password" 
              id="login-password"
              required 
              placeholder="••••••••" 
              style="width: 100%; height: 100%; padding: 0 45px 0 20px; font-family: inherit; font-size: 14px; color: #1f2937; border: 1px solid #d1d5db; border-radius: 8px; background: #ffffff;"
            />
            <button 
              type="button" 
              onclick="togglePasswordVisibility()" 
              style="cursor: pointer; position: absolute; right: 15px; top: 50%; transform: translateY(-50%); border: none; background: none; padding: 0;"
            >
              <img class="container8" src="{{ asset('assets/login/container11.svg') }}" />
            </button>
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" style="cursor: pointer; border: none; background: none; width: 100%; display: block; padding: 0; position: relative; height: 50px;">
          <div class="submit-button-shadow" style="width: 100%; height: 100%;"></div>
          <div class="container9" style="position: absolute; left: 0; top: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #064e3b; border-radius: 10px;">
            <span class="text3" style="position: static; color: #ffffff;">Masuk Ke Sistem</span>
          </div>
          <div class="margin" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
            <img class="container10" src="{{ asset('assets/login/container13.svg') }}" />
          </div>
        </button>
      </form>
    </div>

    <!-- Login Footer -->
    <div class="footer-shared-component">
      <div class="container11">
        <div class="text4">© 2026 PMBM Sistem. All Rights Reserved.</div>
      </div>
      <div class="margin2">
        <div class="container12">
          <div class="link">
            <div class="text4">Privacy Policy</div>
          </div>
          <div class="margin3">
            <div class="text5">|</div>
          </div>
          <div class="link-margin">
            <div class="link-help-center">Help Center</div>
          </div>
          <div class="margin3">
            <div class="text5">|</div>
          </div>
          <div class="link-margin">
            <div class="link-contact-admin">Contact Admin</div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    function togglePasswordVisibility() {
      const passwordInput = document.getElementById('login-password');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
      } else {
        passwordInput.type = 'password';
      }
    }
  </script>
@endsection
