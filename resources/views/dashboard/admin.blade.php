@extends('layouts.admin')

@section('title', 'Admin Dashboard - CMS PMBM')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/admin/dashboard/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/dashboard/style.css') }}">
  <style>
    /* Make the desktop container scrollable */
    .desktop-14 {
        height: auto !important;
        min-height: 100vh !important;
        overflow: visible !important;
        padding-bottom: 120px !important;
    }
  </style>
@endsection

@section('content')
  <div class="desktop-14">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'dashboard'])

    <!-- Main Content Wrapper -->
    <div style="position: absolute; left: 340px; top: 138px; right: 40px; display: flex; flex-direction: column; gap: 24px; z-index: 10;">
      
      <!-- Stats Grid Section -->
      <div class="stats-grid" style="position: relative !important; left: auto !important; top: auto !important; right: auto !important; width: 100% !important; margin: 0 !important;">
        <!-- Total Peserta Card -->
        <a href="{{ route('scores.index') }}" class="stats-grid-link">
          <div class="total-applicants">
            <div class="container">
              <img class="background2" src="{{ asset('assets/admin/dashboard/background1.svg') }}" />
              <div class="background3">
                <div class="text2">+12%</div>
              </div>
            </div>
            <div class="container2">
              <div class="total-peserta">Total Peserta</div>
            </div>
            <div class="heading-3">
              <div class="_1-250">{{ number_format($totalPeserta) }}</div>
            </div>
          </div>
        </a>

        <!-- Total Keterima Card -->
        <a href="{{ route('scores.index', ['status' => 'Keterima']) }}" class="stats-grid-link">
          <div class="accepted">
            <div class="container">
              <img class="background7" src="{{ asset('assets/admin/dashboard/background7.svg') }}" />
              <div class="background3">
                <div class="text2">+8%</div>
              </div>
            </div>
            <div class="container2">
              <div class="total-keterima">Total Keterima</div>
            </div>
            <div class="heading-3">
              <div class="_850">{{ number_format($totalKeterima) }}</div>
            </div>
          </div>
        </a>

        <!-- Total Tidak Keterima Card -->
        <a href="{{ route('scores.index', ['status' => 'Tidak Keterima']) }}" class="stats-grid-link">
          <div class="rejected">
            <div class="container">
              <img class="background4" src="{{ asset('assets/admin/dashboard/background3.svg') }}" />
              <div class="background5">
                <div class="text3">+3%</div>
              </div>
            </div>
            <div class="container2">
              <div class="total-tidak-keterima">Total Tidak Keterima</div>
            </div>
            <div class="heading-3">
              <div class="_400">{{ number_format($totalTidakKeterima) }}</div>
            </div>
          </div>
        </a>

        <!-- Rate Card -->
        <div class="rate">
          <div class="container">
            <img class="background6" src="{{ asset('assets/admin/dashboard/background5.svg') }}" />
            <div class="background3">
              <div class="text2">+5%</div>
            </div>
          </div>
          <div class="container2">
            <div class="tingkat-kelulusan">Tingkat Kelulusan</div>
          </div>
          <div class="heading-3">
            <div class="_68">{{ $tingkatKelulusan }}%</div>
          </div>
        </div>
      </div>

      <!-- Charts Grid Section -->
      <div class="charts-grid" style="position: relative !important; left: auto !important; top: auto !important; right: auto !important; width: 100% !important; margin: 0 !important; display: flex; flex-direction: row; gap: 24px; align-items: stretch;">
        <!-- Pendaftar Chart -->
        <div class="pendaftar-chart">
          <div class="heading-4">
            <div class="jumlah-pendaftar-per-tahun">Jumlah Pendaftar Per Tahun</div>
          </div>
          <div class="horizontal-border">
            @foreach($charts['pendaftar'] as $year => $count)
              <div class="container3" style="display: flex; flex-direction: column; align-items: center; justify-content: flex-end;">
                <!-- Dynamic height for bar charts -->
                <div style="background: #298752; width: 30px; height: {{ ($count / max(max(array_values($charts['pendaftar'])), 1)) * 100 }}px; border-radius: 4px; margin-bottom: 8px;"></div>
                <div class="container4">
                  <div class="text4">{{ $year }}</div>
                </div>
                <div style="font-size: 10px; font-weight: bold; color: #6b7280; margin-top: 4px;">{{ $count }}</div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Keterima Chart -->
        <div class="keterima-chart">
          <div class="heading-4">
            <div class="jumlah-keterima-per-tahun">Jumlah Keterima Per Tahun</div>
          </div>
          <div class="horizontal-border">
            @foreach($charts['keterima'] as $year => $count)
              <div class="container3" style="display: flex; flex-direction: column; align-items: center; justify-content: flex-end;">
                <!-- Dynamic height for bar charts -->
                <div style="background: #064e3b; width: 30px; height: {{ ($count / max(max(array_values($charts['keterima'])), 1)) * 100 }}px; border-radius: 4px; margin-bottom: 8px;"></div>
                <div class="container4">
                  <div class="text4">{{ $year }}</div>
                </div>
                <div style="font-size: 10px; font-weight: bold; color: #6b7280; margin-top: 4px;">{{ $count }}</div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
