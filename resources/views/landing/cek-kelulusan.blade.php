@extends('layouts.landing')

@section('title', 'Cek Kelulusan PMBM - MIN 3 Karanganyar')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/landing/cek-kelulusan/style.css') }}">
@endsection

@section('content')
  <div class="cek-kelulusan-page">
    @include('components.navbar', ['activeFolder' => 'cek-kelulusan'])

    <section class="cek-hero-section">
      <div class="cek-hero-bg">
        <img src="{{ asset('assets/landing/home/hero-bg.jpg') }}" alt="MIN 3 Karanganyar">
      </div>
      <div class="cek-hero-content">
        <h1 class="cek-hero-title">Cek Status Kelulusan</h1>
        <p class="cek-hero-subtitle">Halaman resmi pengumuman hasil seleksi penerimaan peserta didik baru PMBM MIN 3 Karanganyar.</p>
      </div>
    </section>

    <section class="cek-form-section">
      @if(session('error'))
        <div class="cek-flash-message cek-flash-error">{{ session('error') }}</div>
      @endif
      @if(session('success_edit'))
        <div class="cek-flash-message cek-flash-success">{{ session('success_edit') }}</div>
      @endif

      <div class="cek-form-card">
        <div class="cek-form-card-accent"></div>
        <div class="cek-form-card-body">
          <h2 class="cek-form-title">CEK KELULUSAN</h2>

          <form action="{{ route('student.status.check') }}" method="POST" style="width: 100%; display: flex; flex-direction: column; align-items: center; gap: 16px;">
            @csrf
            <div class="cek-form-field">
              <input type="text" name="nisn" class="cek-form-input" placeholder="NISN" required>
            </div>
            <div class="cek-form-field">
              <input type="text" name="nama_murid" class="cek-form-input" placeholder="Nama Siswa" required>
            </div>
            <button type="submit" class="cek-form-submit">Cek</button>
          </form>
        </div>
      </div>
    </section>

    @include('components.footer', ['activeFolder' => 'cek-kelulusan'])
  </div>
@endsection
