@extends('layouts.landing')

@section('title', 'Cek Kelulusan PMBM - MIN 3 Karanganyar')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/landing/cek-kelulusan/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/landing/cek-kelulusan/style.css') }}">
@endsection

@section('content')
  <div class="cek-kelulusan">
    <!-- Header/Navbar Shared Component -->
    @include('components.navbar', ['activeFolder' => 'cek-kelulusan'])

    <div class="cek-status-kelulusan" style="color: #064e3b !important;">Cek Status Kelulusan</div>
    <div class="halaman-resmi-pengumuman-hasil-seleksi-penerimaan-peserta-didik-baru-pmbm-min-3-karanganyar" style="color: #374151 !important; line-height: 1.4; font-weight: 500;">
      Halaman resmi pengumuman hasil seleksi penerimaan peserta didik baru PMBM MIN 3 Karanganyar.
    </div>



    <!-- Form Cek Kelulusan -->
    <div class="rectangle-19"></div>
    <div class="cek-kelulusan3">CEK KELULUSAN</div>

    <form action="{{ route('student.status.check') }}" method="POST">
      @csrf
      <!-- Input Nomor Pendaftaran -->
      <div style="position: absolute; left: 599px; top: 620px; font-family: inherit; font-size: 13px; font-weight: bold; color: #374151; text-align: left;">ID Pendaftaran</div>
      <input 
        type="text" 
        name="registration_number" 
        class="rectangle-21" 
        style="position: absolute; left: 599px; top: 645px; width: 248px; height: 48px; padding: 10px 16px; font-family: inherit; font-size: 14px; border: 1px solid #c7d2fe; border-radius: 8px; background: #ffffff; outline: none; transition: border-color 0.2s;" 
        placeholder="Input ID pendaftaran" 
        required
        onfocus="this.style.borderColor='#298752'"
        onblur="this.style.borderColor='#c7d2fe'"
      />

      <!-- Input Nama Siswa -->
      <div style="position: absolute; left: 599px; top: 710px; font-family: inherit; font-size: 13px; font-weight: bold; color: #374151; text-align: left;">Nama Calon Murid</div>
      <input 
        type="text" 
        name="nama_murid" 
        class="rectangle-23" 
        style="position: absolute; left: 599px; top: 735px; width: 248px; height: 48px; padding: 10px 16px; font-family: inherit; font-size: 14px; border: 1px solid #c7d2fe; border-radius: 8px; background: #ffffff; outline: none; transition: border-color 0.2s;" 
        placeholder="Input nama calon murid" 
        required
        onfocus="this.style.borderColor='#298752'"
        onblur="this.style.borderColor='#c7d2fe'"
      />

      <!-- Submit Button -->
      <button type="submit" class="button" style="cursor: pointer; border: none; outline: none; background: #298752 !important; border-radius: 8px; width: 248px; left: 599px; right: auto; height: 46px; display: flex; align-items: center; justify-content: center; top: 810px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#064e3b'" onmouseout="this.style.backgroundColor='#298752'">
        <span style="color: #ffffff; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 15px; font-weight: bold;">Cek Status</span>
      </button>
    </form>

    <!-- Error Flash Message -->
    @if(session('error'))
      <div style="position: absolute; left: 530px; top: 1220px; width: 490px; padding: 12px; background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; font-family: sans-serif; font-size: 13px; border-radius: 6px;">
        {{ session('error') }}
      </div>
    @endif

    <!-- Success Edit Flash Message -->
    @if(session('success_edit'))
      <div style="position: absolute; left: 480px; top: 880px; width: 480px; padding: 12px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-family: sans-serif; font-size: 13px; border-radius: 6px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05); z-index: 10;">
        {{ session('success_edit') }}
      </div>
    @endif

    <!-- Footer Shared Component -->
    @include('components.footer', ['activeFolder' => 'cek-kelulusan'])
  </div>
@endsection
