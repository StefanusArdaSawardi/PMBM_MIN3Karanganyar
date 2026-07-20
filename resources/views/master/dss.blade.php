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
      <div style="background: #ffffff; border-radius: 12px; border: 1px solid #becabe; padding: 24px; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; gap: 20px; max-width: 750px; width: 100%;">
        <div style="display: flex; align-items: center; border-bottom: 2px solid #f0fdf4; padding-bottom: 12px;">
          <div style="font-weight: bold; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 16px; color: #064e3b; display: flex; align-items: center; gap: 8px;">
            <span>⚙️</span> Konfigurasi Parameter DSS Seleksi PMBM (Sistem Cerdas)
          </div>
        </div>

        <form action="{{ route('tata_usaha.dss.update') }}" method="POST" style="display: flex; flex-direction: column; gap: 24px;">
          @csrf
          <div style="display: flex; flex-direction: column; gap: 16px; width: 100%;">
            
            <!-- Bobot Kriteria Perhitungan -->
            <div style="background: #f9fafb; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; display: flex; flex-direction: column; gap: 14px;">
              <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; border-bottom: 1px dashed #d1d5db; padding-bottom: 10px;">
                <div style="font-weight: bold; font-size: 13px; color: #374151; text-transform: uppercase; letter-spacing: 0.5px;">Bobot Kriteria Penilaian DSS (%)</div>
                <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: bold;">
                  <span style="color: #4b5563;">Total Bobot saat ini:</span>
                  <span id="totalWeightBadge" style="padding: 4px 10px; border-radius: 20px; font-size: 13px; font-weight: bold; background: #dcfce7; color: #166534; transition: all 0.2s;">100%</span>
                </div>
              </div>
              
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

              <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <div>
                  <label style="font-size: 11px; font-weight: 700; color: #4b5563;">HAFALAN (%)</label>
                  <input type="number" name="weight_hafalan" class="input-field dss-weight-input" value="{{ old('weight_hafalan', $weights['hafalan']) }}" required min="0" max="100">
                </div>

                <div>
                  <label style="font-size: 11px; font-weight: 700; color: #4b5563;">AISM (%)</label>
                  <input type="number" name="weight_aism" class="input-field dss-weight-input" value="{{ old('weight_aism', $weights['aism']) }}" required min="0" max="100">
                </div>

                <div>
                  <label style="font-size: 11px; font-weight: 700; color: #4b5563;">IQRO (%)</label>
                  <input type="number" name="weight_iqro" class="input-field dss-weight-input" value="{{ old('weight_iqro', $weights['iqro']) }}" required min="0" max="100">
                </div>

                <div>
                  <label style="font-size: 11px; font-weight: 700; color: #4b5563;">CALISTUNG (%)</label>
                  <input type="number" name="weight_calistung" class="input-field dss-weight-input" value="{{ old('weight_calistung', $weights['calistung']) }}" required min="0" max="100">
                </div>

                <div>
                  <label style="font-size: 11px; font-weight: 700; color: #4b5563;">DIKTE (%)</label>
                  <input type="number" name="weight_dikte" class="input-field dss-weight-input" value="{{ old('weight_dikte', $weights['dikte']) }}" required min="0" max="100">
                </div>

                <div>
                  <label style="font-size: 11px; font-weight: 700; color: #4b5563;">KEMANDIRIAN (%)</label>
                  <input type="number" name="weight_kemandirian" class="input-field dss-weight-input" value="{{ old('weight_kemandirian', $weights['kemandirian']) }}" required min="0" max="100">
                </div>
              </div>

              <div id="weightValidationMessage" style="font-size: 11px; color: #059669; margin-top: 4px; font-weight: bold; display: flex; align-items: center; gap: 6px;">
                <span>✅</span> Total distribusi bobot valid (100%).
              </div>
            </div>
          </div>

          <div style="display: flex; justify-content: flex-end; margin-top: 5px;">
            <button type="submit" class="btn-submit" id="btnSubmitDss">
              Simpan Konfigurasi &amp; Rekalkulasi DSS
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const weightInputs = document.querySelectorAll('.dss-weight-input');
      const badge = document.getElementById('totalWeightBadge');
      const msg = document.getElementById('weightValidationMessage');
      const submitBtn = document.getElementById('btnSubmitDss');

      function calculateTotal() {
        let total = 0;
        weightInputs.forEach(input => {
          total += parseInt(input.value) || 0;
        });

        badge.textContent = total + '%';
        if (total === 100) {
          badge.style.background = '#dcfce7';
          badge.style.color = '#166534';
          msg.innerHTML = '<span>✅</span> Total distribusi bobot valid (100%).';
          msg.style.color = '#059669';
          submitBtn.disabled = false;
          submitBtn.style.opacity = '1';
          submitBtn.style.cursor = 'pointer';
        } else {
          badge.style.background = '#fee2e2';
          badge.style.color = '#991b1b';
          msg.innerHTML = '<span>⚠️</span> Total distribusi bobot harus persis 100%. (Selisih: ' + (100 - total) + '%)';
          msg.style.color = '#dc2626';
        }
      }

      weightInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
      });

      calculateTotal();
    });
  </script>
@endsection
