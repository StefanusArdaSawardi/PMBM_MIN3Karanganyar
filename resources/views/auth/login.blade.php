@extends('layouts.landing')

@section('title', 'CMS PMBM - Masuk ke Sistem')

@section('content')
  <div class="relative min-h-screen bg-white flex flex-col" style="font-family: 'PlusJakartaSans-Regular', sans-serif;">
    <div class="flex-1 flex flex-col items-center justify-center px-5 py-20">
      <img
        class="w-28 h-28 object-cover aspect-square mb-5"
        src="{{ asset('assets/login/whats-app-image-2026-06-17-at-23-30-06-removebg-preview-10.png') }}"
        alt="Logo MIN 3 KRA"
      />
      <div class="text-[#121c2a] text-[26px] font-bold tracking-[-0.65px] text-center" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">CMS PMBM</div>
      <div class="text-[#3f4940] text-[14px] text-center mt-2 mb-8" style="font-family: 'WorkSans-Regular', sans-serif;">
        Silakan masuk ke sistem pengelolaan
        <br>
        pendaftaran
      </div>

      <div class="bg-white border border-[#becabe] rounded-xl shadow-[0px_4px_20px_rgba(0,91,49,0.05)] p-8 max-[480px]:p-6 w-full max-w-[350px]">
        <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-6">
          @csrf

          @if($errors->any())
            <div class="p-3 bg-red-100 border border-red-300 text-red-700 text-[12px] rounded-lg leading-4">
              {{ $errors->first() }}
            </div>
          @endif

          <!-- Guard Role Dropdown -->
          <div class="flex flex-col gap-1 w-full">
            <label class="text-[#3f4940] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">Masuk Sebagai</label>
            <div class="relative w-full">
              <select name="role" class="w-full h-full px-5 py-3.5 pr-11 text-[14px] font-bold text-gray-700 border border-[#becabe] rounded-lg bg-white cursor-pointer outline-none appearance-none focus:border-[#298752]">
                <option value="tata_usaha">Pengurus Tata Usaha / Admin</option>
                <option value="panitia">Panitia Penguji / Wawancara</option>
              </select>
              <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2">
                <img src="{{ asset('assets/login/container3.svg') }}" alt="">
              </div>
            </div>
          </div>

          <!-- Email Field -->
          <div class="flex flex-col gap-1 w-full">
            <label class="text-[#3f4940] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">Alamat Email</label>
            <div class="relative w-full">
              <input
                type="email"
                name="email"
                required
                placeholder="admin@email.com"
                value="{{ old('email') }}"
                class="w-full px-5 py-3.5 pr-11 text-[14px] text-gray-800 border border-[#becabe] rounded-lg bg-white outline-none focus:border-[#298752]"
              />
              <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2">
                <img src="{{ asset('assets/login/container7.svg') }}" alt="">
              </div>
            </div>
          </div>

          <!-- Password Field -->
          <div class="flex flex-col gap-1 w-full">
            <div class="flex justify-between items-center mb-1">
              <label class="text-[#3f4940] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">Kata Sandi</label>
              <a href="#" onclick="event.preventDefault(); alert('Silakan hubungi Super Admin/Kepala Sekolah untuk menyetel ulang sandi Anda.')" class="text-[#005b31] text-[12px] font-medium whitespace-nowrap">Lupa sandi?</a>
            </div>
            <div class="relative w-full">
              <input
                type="password"
                name="password"
                id="login-password"
                required
                placeholder="••••••••"
                class="w-full px-5 py-3.5 pr-11 text-[14px] text-gray-800 border border-[#becabe] rounded-lg bg-white outline-none focus:border-[#298752]"
              />
              <button
                type="button"
                onclick="togglePasswordVisibility()"
                class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer border-none bg-none p-0"
              >
                <img src="{{ asset('assets/login/container11.svg') }}" alt="Toggle password visibility">
              </button>
            </div>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="w-full flex items-center justify-center gap-1 px-6 py-4 bg-[#064e3b] rounded-lg shadow-[0px_10px_15px_-3px_rgba(0,91,49,0.1),0px_4px_6px_-4px_rgba(0,91,49,0.1)] cursor-pointer">
            <span class="text-white text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">Masuk Ke Sistem</span>
            <img class="w-3.5 h-3.5" src="{{ asset('assets/login/container13.svg') }}" alt="">
          </button>
        </form>
      </div>
    </div>

    <!-- Login Footer -->
    <div class="bg-[#f8f9ff] border-t border-[#becabe] flex flex-col gap-1 items-center justify-center py-6 px-5">
      <div class="text-[#3f4940] text-[14px]" style="font-family: 'WorkSans-Regular', sans-serif;">© 2026 PMBM Sistem. All Rights Reserved.</div>
      <div class="flex items-center gap-4 mt-1 flex-wrap justify-center">
        <div class="text-[#3f4940] text-[14px]" style="font-family: 'WorkSans-Regular', sans-serif;">Privacy Policy</div>
        <div class="text-[#becabe] text-[12px]">|</div>
        <div class="text-[#3f4940] text-[14px]" style="font-family: 'WorkSans-Regular', sans-serif;">Help Center</div>
        <div class="text-[#becabe] text-[12px]">|</div>
        <div class="text-[#3f4940] text-[14px]" style="font-family: 'WorkSans-Regular', sans-serif;">Contact Admin</div>
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
