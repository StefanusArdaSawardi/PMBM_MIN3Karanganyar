@extends('layouts.admin')

@section('title', 'Ubah Akun Pengguna - Admin Portal')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/admin/users/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/users/style_create_edit.css') }}">
  <style>
     /* Make the desktop container scrollable */
     .desktop-19 {
        height: auto !important;
        min-height: 100vh !important;
        overflow: visible !important;
        padding-bottom: 120px !important;
     }
     
      /* Better non-overlapping layout for form and side columns */
      .grid-layout-for-desktop {
         position: absolute !important;
         left: 360px !important;
         width: 540px !important;
         right: auto !important;
         top: 290px !important;
      }
      
      .role-guidance-card-bento-style {
         position: absolute !important;
         left: 360px !important;
         width: 540px !important;
         right: auto !important;
         top: 830px !important;
      }
      
      .status-toggle {
         position: absolute !important;
         left: 360px !important;
         width: 540px !important;
         right: auto !important;
         top: 1040px !important;
         border-top: none !important;
         padding-top: 0 !important;
      }
      
      /* Responsive styling for screens narrower than 1320px */
      @media (max-width: 1320px) {
         .grid-layout-for-desktop {
            position: relative !important;
            left: 360px !important;
            width: calc(100% - 400px) !important;
            max-width: 600px !important;
            top: auto !important;
            margin-top: 180px !important;
         }
         
         .role-guidance-card-bento-style {
            position: relative !important;
            left: 360px !important;
            width: calc(100% - 400px) !important;
            max-width: 600px !important;
            top: auto !important;
            margin-top: 30px !important;
         }
         
         .status-toggle {
            position: relative !important;
            left: 360px !important;
            width: calc(100% - 400px) !important;
            max-width: 600px !important;
            top: auto !important;
            margin-top: 20px !important;
         }
      }
   </style>
@endsection

@section('content')
  <div class="desktop-19" style="padding-bottom: 500px !important;">
    <!-- Admin Sidebar -->
    @include('components.sidebar-admin', ['activeFolder' => 'users'])

    <form action="{{ route('tata_usaha.accounts.update', [$role, $id]) }}" method="POST">
      @csrf

      <div class="heading-2">
        <div class="data-identitas-pengguna">Ubah Akun: {{ $accountData['name'] }}</div>
      </div>
      
      <div class="container">
        <div class="lengkapi-informasi-di-bawah-ini-untuk-mendaftarkan-akun-staf-atau-panitia-baru-ke-dalam-sistem-pmbm">
          Perbarui informasi di bawah ini untuk mengupdate data akun staf atau panitia dalam sistem PMBM.
        </div>
      </div>

      <div class="grid-layout-for-desktop">
        <!-- Nama Lengkap -->
        <div class="full-name">
          <div class="label">
            <div class="nama-lengkap">Nama Lengkap</div>
          </div>
          <div class="container2">
            <div class="input">
              <input type="text" name="name" id="name-input" value="{{ old('name', $accountData['name']) }}" placeholder="Masukkan nama lengkap" required autocomplete="off">
              <img class="container4" src="{{ asset('assets/admin/users/container3.svg') }}" />
            </div>
          </div>
        </div>

        <!-- Alamat Email -->
        <div class="email">
          <div class="label">
            <div class="alamat-email">Alamat Email</div>
          </div>
          <div class="container2">
            <div class="input">
              <input type="email" name="email" id="email-input" value="{{ old('email', $accountData['email']) }}" placeholder="contoh@min3.sch.id" required autocomplete="off">
              <img class="container5" src="{{ asset('assets/admin/users/container6.svg') }}" />
            </div>
          </div>
        </div>

        <!-- Username -->
        <div class="username">
          <div class="label">
            <div class="username2">Username</div>
          </div>
          <div class="container2">
            <div class="input">
              <input type="text" id="username-input" placeholder="username_unik" value="{{ old('username', explode('@', $accountData['email'])[0] ?? '') }}" autocomplete="off">
              <img class="container6" src="{{ asset('assets/admin/users/container9.svg') }}" />
            </div>
          </div>
        </div>

        <!-- Hak Akses / Role -->
        <div class="role">
          <div class="label">
            <div class="hak-akses-role">Hak Akses / Role</div>
          </div>
          <div class="container2">
            <div class="options">
              <select name="role" id="role-select" required>
                @if($accountData['role'] === 'super_admin')
                  <option value="super_admin" selected>Super Admin</option>
                @else
                  <option value="tata_usaha" {{ old('role', $accountData['role']) == 'tata_usaha' ? 'selected' : '' }}>Tata Usaha / Admin</option>
                  <option value="panitia_ujian" {{ old('role', $accountData['role']) == 'panitia_ujian' ? 'selected' : '' }}>Panitia Pengawas Ujian</option>
                  <option value="panitia_wawancara" {{ old('role', $accountData['role']) == 'panitia_wawancara' ? 'selected' : '' }}>Panitia Wawancara / Pewawancara</option>
                @endif
              </select>
              <img class="container7" src="{{ asset('assets/admin/users/container11.svg') }}" />
              <img class="container8" src="{{ asset('assets/admin/users/container12.svg') }}" />
            </div>
          </div>
        </div>

        <!-- Password -->
        <div class="password">
          <div class="label">
            <div class="password2">Password Baru (Opsional)</div>
          </div>
          <div class="container2">
            <div class="input2">
              <input type="password" name="password" id="password-input" placeholder="Kosongkan jika tidak ingin mengubah">
              <img class="container9" src="{{ asset('assets/admin/users/container15.svg') }}" />
              <button type="button" class="button" id="toggle-password-btn" style="cursor: pointer; border: none; background: none; outline: none; padding: 0;">
                <img class="container10" src="{{ asset('assets/admin/users/container16.svg') }}" />
              </button>
            </div>
          </div>
        </div>

        <!-- Konfirmasi Password -->
        <div class="confirm-password">
          <div class="label">
            <div class="konfirmasi-password">Konfirmasi Password Baru</div>
          </div>
          <div class="container2">
            <div class="input">
              <input type="password" name="password_confirmation" id="confirm-password-input" placeholder="Kosongkan jika tidak ingin mengubah">
              <img class="container11" src="{{ asset('assets/admin/users/container19.svg') }}" />
            </div>
          </div>
        </div>
        
        <!-- Actions: Submit & Cancel -->
        <div style="display: flex; gap: 16px; margin-top: 16px; width: 100%;">
          <a href="{{ route('tata_usaha.accounts') }}" style="display: inline-flex; align-items: center; justify-content: center; background: #ffffff; border: 1px solid #becabe; border-radius: 9999px; padding: 12px 32px; color: #3f4940; font-family: 'WorkSans-SemiBold', sans-serif; font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s;">Batal</a>
          <button type="submit" style="display: inline-flex; align-items: center; justify-content: center; background: #005b31; border: none; border-radius: 9999px; padding: 12px 44px; color: #ffffff; font-family: 'WorkSans-SemiBold', sans-serif; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0px 4px 6px -1px rgba(0,0,0,0.1);">Simpan Perubahan</button>
        </div>
      </div>

      <!-- Bento Role Guidance Cards -->
      <div class="role-guidance-card-bento-style">
        <div class="background2">
          <img class="background3" src="{{ asset('assets/admin/users/background2.svg') }}" />
          <div class="container12">
            <div class="heading-4">
              <div class="text2">Admin TU</div>
            </div>
            <div class="container13">
              <div class="text3">
                Akses penuh ke manajemen data siswa dan pengaturan sistem.
              </div>
            </div>
          </div>
        </div>
        <div class="background4">
          <img class="background5" src="{{ asset('assets/admin/users/background4.svg') }}" />
          <div class="container12">
            <div class="heading-4">
              <div class="text4">Panitia Penguji</div>
            </div>
            <div class="container13">
              <div class="text5">
                Akses modul penilaian, screening, dan wawancara pendaftar.
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Status Toggle -->
      <div class="status-toggle">
        <div class="background-border">
          <div class="container12">
            <div class="container2">
              <div class="text6">Status Akun</div>
            </div>
            <div class="container2">
              <div class="text7">
                Tentukan apakah akun langsung aktif setelah dibuat.
              </div>
            </div>
          </div>
          <label class="label2" style="cursor: pointer; display: flex; align-items: center; position: relative;">
            <input type="checkbox" id="status-checkbox" name="status" value="1" checked style="display: none;">
            <div class="background6" id="toggle-bg" style="background-color: #005b31; transition: background-color 0.2s;"></div>
            <div class="margin">
              <div class="text8" id="toggle-text" style="color: #005b31; transition: color 0.2s;">Aktif</div>
            </div>
            <div class="background-border2" id="toggle-knob" style="transition: left 0.2s; position: absolute; left: 22px; top: 2px;"></div>
          </label>
        </div>
      </div>
    </form>
    
    <!-- Flash Validation Errors -->
    @if($errors->any())
      <div style="position: absolute; left: 362px; top: 120px; width: 542px; padding: 10px 15px; background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; font-family: sans-serif; font-size: 12px; border-radius: 6px; z-index: 100;">
        <ul style="list-style: disc; margin: 0; padding-left: 20px;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>
@endsection

@section('scripts')
  <script>
    // 1. Interactive Username and Email sync
    const usernameInput = document.getElementById('username-input');
    const emailInput = document.getElementById('email-input');

    usernameInput.addEventListener('input', function() {
      const val = this.value.trim().toLowerCase().replace(/[^a-z0-9_.-]/g, '');
      this.value = val;
      if (val && !emailInput.value.includes('@')) {
        emailInput.value = val + '@min3.sch.id';
      }
    });

    emailInput.addEventListener('input', function() {
      const email = this.value.trim();
      if (email.includes('@')) {
        const parts = email.split('@');
        usernameInput.value = parts[0];
      } else {
        usernameInput.value = email;
      }
    });

    // 2. Password show/hide eye toggle
    const passwordInput = document.getElementById('password-input');
    const confirmPasswordInput = document.getElementById('confirm-password-input');
    const togglePasswordBtn = document.getElementById('toggle-password-btn');

    togglePasswordBtn.addEventListener('click', function() {
      const isPassword = passwordInput.getAttribute('type') === 'password';
      passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
      confirmPasswordInput.setAttribute('type', isPassword ? 'text' : 'password');
      this.style.opacity = isPassword ? '0.6' : '1';
    });

    // 3. Custom status switch toggle
    const checkbox = document.getElementById('status-checkbox');
    const toggleBg = document.getElementById('toggle-bg');
    const toggleText = document.getElementById('toggle-text');
    const toggleKnob = document.getElementById('toggle-knob');
    
    checkbox.addEventListener('change', function() {
      if (this.checked) {
        toggleBg.style.backgroundColor = '#005b31';
        toggleText.style.color = '#005b31';
        toggleText.textContent = 'Aktif';
        toggleKnob.style.left = '22px';
      } else {
        toggleBg.style.backgroundColor = '#becabe';
        toggleText.style.color = '#6f7a70';
        toggleText.textContent = 'Nonaktif';
        toggleKnob.style.left = '2px';
      }
    });
  </script>
@endsection
