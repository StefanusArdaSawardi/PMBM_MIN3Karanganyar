@extends('layouts.admin')

@section('title', 'Konfigurasi DSS - CMS PMBM')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/admin/landing-manage/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/landing-manage/style.css') }}">
  <style>
    .input-field {
      width: 100%;
      height: 40px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      padding: 10px 15px;
      font-family: inherit;
      font-size: 13px;
      outline: none;
      background: #ffffff;
      margin-top: 5px;
    }
    .input-field:focus {
      border-color: #298752;
    }
    .btn-submit {
      padding: 12px 24px;
      background: #298752;
      color: #ffffff;
      font-weight: bold;
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      cursor: pointer;
      font-size: 13px;
      border: none;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .btn-submit:hover {
      background: #064e3b;
    }
  </style>
@endsection

@section('content')
  <div class="desktop-15" style="overflow-y: auto; height: auto; min-height: 100vh; padding-bottom: 60px;">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'dss'])

    <!-- Main Content Wrapper -->
    <div style="position: absolute; left: 380px; top: 180px; right: 40px; display: flex; flex-direction: column; gap: 24px; z-index: 10;">
      
      <!-- Messages Flash -->
      @if(session('success'))
        <div style="padding: 10px 15px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; font-family: sans-serif; font-size: 12px; border-radius: 6px; width: 100%;">
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div style="padding: 10px 15px; background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; font-family: sans-serif; font-size: 12px; border-radius: 6px; width: 100%;">
          {{ session('error') }}
        </div>
      @endif
      
      <!-- Section: Konfigurasi Parameter DSS Seleksi PMBM -->
      <div style="background: #ffffff; border-radius: 12px; border: 1px solid #becabe; padding: 24px; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; gap: 20px;">
        <div style="display: flex; align-items: center; border-bottom: 2px solid #f0fdf4; padding-bottom: 12px;">
          <div style="font-weight: bold; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 16px; color: #064e3b; display: flex; align-items: center; gap: 8px;">
            <span>⚙️</span> Konfigurasi Parameter DSS Seleksi PMBM (Sistem Cerdas)
          </div>
        </div>

        <form action="{{ route('tata_usaha.dss.update') }}" method="POST" style="display: flex; flex-direction: column; gap: 24px;">
          @csrf
          <div style="display: flex; flex-direction: row; gap: 24px; width: 100%; align-items: stretch; justify-content: center; flex-wrap: wrap;">
            
            <!-- Column 1: Bobot Kriteria Perhitungan -->
            <div style="flex: 1; min-width: 320px; background: #f9fafb; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; display: flex; flex-direction: column; gap: 12px;">
              <div style="font-weight: bold; font-size: 13px; color: #374151; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">Bobot Kriteria Penilaian DSS (%)</div>
              
              @php
                $rawWeights = $dssConfig['weights'] ?? [];
                $weights = [
                  'hafalan' => $rawWeights['hafalan'] ?? 20,
                  'aism' => $rawWeights['aism'] ?? 15,
                  'iqro' => $rawWeights['iqro'] ?? ($rawWeights['tasmi'] ?? 20),
                  'calistung' => $rawWeights['calistung'] ?? 20,
                  'dikte' => $rawWeights['dikte'] ?? 15,
                  'kemandirian' => $rawWeights['kemandirian'] ?? ($rawWeights['mandiri'] ?? 10)
                ];
              @endphp

              <div>
                <label style="font-size: 11px; font-weight: 700; color: #4b5563;">HAFALAN</label>
                <input type="number" name="weight_hafalan" class="input-field" value="{{ old('weight_hafalan', $weights['hafalan']) }}" required min="0" max="100">
              </div>

              <div>
                <label style="font-size: 11px; font-weight: 700; color: #4b5563;">AISM</label>
                <input type="number" name="weight_aism" class="input-field" value="{{ old('weight_aism', $weights['aism']) }}" required min="0" max="100">
              </div>

              <div>
                <label style="font-size: 11px; font-weight: 700; color: #4b5563;">IQRO</label>
                <input type="number" name="weight_iqro" class="input-field" value="{{ old('weight_iqro', $weights['iqro']) }}" required min="0" max="100">
              </div>

              <div>
                <label style="font-size: 11px; font-weight: 700; color: #4b5563;">CALISTUNG</label>
                <input type="number" name="weight_calistung" class="input-field" value="{{ old('weight_calistung', $weights['calistung']) }}" required min="0" max="100">
              </div>

              <div>
                <label style="font-size: 11px; font-weight: 700; color: #4b5563;">DIKTE</label>
                <input type="number" name="weight_dikte" class="input-field" value="{{ old('weight_dikte', $weights['dikte']) }}" required min="0" max="100">
              </div>

              <div>
                <label style="font-size: 11px; font-weight: 700; color: #4b5563;">KEMANDIRIAN</label>
                <input type="number" name="weight_kemandirian" class="input-field" value="{{ old('weight_kemandirian', $weights['kemandirian']) }}" required min="0" max="100">
              </div>

              <small style="font-size: 10px; color: #ef4444; display: block; margin-top: 5px; font-weight: bold;">
                * Jumlah total keenam bobot kriteria wajib sama dengan 100%.
              </small>
            </div>

            <!-- Column 2: Predikat Batas Angka -->
            <div style="flex: 1; min-width: 320px; background: #f9fafb; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; display: flex; flex-direction: column; gap: 12px;">
              <div style="font-weight: bold; font-size: 13px; color: #374151; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">Predikat Batas Angka DSS (Global)</div>
              
              <!-- Sangat Cakap -->
              <div>
                <label style="font-size: 11px; font-weight: 700; color: #047857; text-transform: uppercase;">Sangat Cakap</label>
                <div style="display: flex; gap: 8px; align-items: center; margin-top: 4px;">
                  <input type="number" name="pred_sangat_cakap_min" class="input-field" style="width: 100%;" value="{{ old('pred_sangat_cakap_min', $sangatCakap['min']) }}" required placeholder="Min">
                  <span style="font-size: 12px; color: #9ca3af;">s.d</span>
                  <input type="number" name="pred_sangat_cakap_max" class="input-field" style="width: 100%;" value="{{ old('pred_sangat_cakap_max', $sangatCakap['max']) }}" required placeholder="Max">
                </div>
              </div>

              <!-- Cakap -->
              <div>
                <label style="font-size: 11px; font-weight: 700; color: #2563eb; text-transform: uppercase;">Cakap</label>
                <div style="display: flex; gap: 8px; align-items: center; margin-top: 4px;">
                  <input type="number" name="pred_cakap_min" class="input-field" style="width: 100%;" value="{{ old('pred_cakap_min', $cakap['min']) }}" required placeholder="Min">
                  <span style="font-size: 12px; color: #9ca3af;">s.d</span>
                  <input type="number" name="pred_cakap_max" class="input-field" style="width: 100%;" value="{{ old('pred_cakap_max', $cakap['max']) }}" required placeholder="Max">
                </div>
              </div>

              <!-- Cukup Cakap -->
              <div>
                <label style="font-size: 11px; font-weight: 700; color: #d97706; text-transform: uppercase;">Cukup Cakap</label>
                <div style="display: flex; gap: 8px; align-items: center; margin-top: 4px;">
                  <input type="number" name="pred_cukup_cakap_min" class="input-field" style="width: 100%;" value="{{ old('pred_cukup_cakap_min', $cukupCakap['min']) }}" required placeholder="Min">
                  <span style="font-size: 12px; color: #9ca3af;">s.d</span>
                  <input type="number" name="pred_cukup_cakap_max" class="input-field" style="width: 100%;" value="{{ old('pred_cukup_cakap_max', $cukupCakap['max']) }}" required placeholder="Max">
                </div>
              </div>

              <!-- Butuh Perhatian -->
              <div>
                <label style="font-size: 11px; font-weight: 700; color: #b91c1c; text-transform: uppercase;">Butuh Perhatian</label>
                <div style="display: flex; gap: 8px; align-items: center; margin-top: 4px;">
                  <input type="number" name="pred_perhatian_min" class="input-field" style="width: 100%;" value="{{ old('pred_perhatian_min', $butuhPerhatian['min']) }}" required placeholder="Min">
                  <span style="font-size: 12px; color: #9ca3af;">s.d</span>
                  <input type="number" name="pred_perhatian_max" class="input-field" style="width: 100%;" value="{{ old('pred_perhatian_max', $butuhPerhatian['max']) }}" required placeholder="Max">
                </div>
              </div>
            </div>
          </div>

          <div style="display: flex; justify-content: flex-end; margin-top: 15px;">
            <button type="submit" class="btn-submit">
              Simpan Konfigurasi &amp; Rekalkulasi DSS
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
