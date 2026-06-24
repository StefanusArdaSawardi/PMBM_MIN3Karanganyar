@extends('layouts.panitia')

@section('title', 'Antrean Uji Wawancara - Penguji PMBM')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/panitia/queue/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/panitia/queue/style.css') }}">
  <style>
    .queue-container {
      position: absolute;
      left: 280px;
      top: 220px;
      right: 40px;
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      padding: 24px;
      font-family: sans-serif;
    }
    .queue-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }
    .queue-table th {
      text-align: left;
      padding: 12px;
      border-bottom: 2px solid #f3f4f6;
      color: #4b5563;
      font-weight: bold;
      text-transform: uppercase;
      font-size: 11px;
    }
    .queue-table td {
      padding: 15px 12px;
      border-bottom: 1px solid #f3f4f6;
      color: #1f2937;
    }
    .queue-table tr:hover {
      background: #f9fafb;
    }
    .btn-grade {
      background: #298752;
      color: #ffffff;
      padding: 8px 16px;
      border-radius: 6px;
      font-weight: bold;
      text-decoration: none;
      font-size: 12px;
    }
    .btn-grade:hover {
      background: #064e3b;
    }
    .badge {
      padding: 4px 8px;
      border-radius: 12px;
      font-size: 10px;
      font-weight: bold;
    }
    .badge-pending { background: #fffbeb; color: #d97706; }
    .badge-lunas { background: #ecfdf5; color: #047857; }
  </style>
@endsection

@section('content')
  <div class="desktop-22">
    <!-- Header Page Description -->
    <div class="heading-3">
      <div class="antrean-uji-wawancara">Antrean Uji Wawancara</div>
    </div>
    <div class="container">
      <div class="daftar-calon-siswa-yang-berstatus-pending-dan-siap-diuji-hari-ini-pastikan-kelengkapan-berkas-sebelum-memulai-sesi">
        Daftar calon siswa yang berstatus pending dan siap diuji hari ini.
        Pastikan kelengkapan berkas sebelum memulai sesi.
      </div>
    </div>

    <!-- Panitia Sidebar/Topbar Included -->
    @include('components.sidebar-panitia', ['activeFolder' => 'queue'])

    <!-- Stats Summary bento list -->
    <div class="dashboard-stats-summary-bento-piece">
      <div class="overlay-border-overlay-blur">
        <div class="overlay">
          <img class="container2" src="{{ asset('assets/panitia/queue/container1.svg') }}" />
        </div>
        <div class="container3">
          <div class="container4"><div class="text2">TELAH DIUJI</div></div>
          <div class="container4"><div class="text3">{{ $telahDiujiCount }} Siswa</div></div>
        </div>
      </div>
    </div>

    <div class="overlay-border-overlay-blur2">
      <div class="overlay2">
        <img class="container5" src="{{ asset('assets/panitia/queue/container5.svg') }}" />
      </div>
      <div class="container3">
        <div class="container4"><div class="text2">ANTREAN HARI INI</div></div>
        <div class="container4"><div class="text3">{{ $antreanCount }} Siswa</div></div>
      </div>
    </div>

    <div class="overlay-border-overlay-blur3">
      <div class="overlay3">
        <img class="container6" src="{{ asset('assets/panitia/queue/container9.svg') }}" />
      </div>
      <div class="container3">
        <div class="container4"><div class="text2">RATA-RATA WAKTU</div></div>
        <div class="container4"><div class="text3">15 Menit</div></div>
      </div>
    </div>

    <!-- Active Queue List Container -->
    <div class="queue-container">
      <table class="queue-table">
        <thead>
          <tr>
            <th>No. Reg</th>
            <th>Nama Calon Siswa</th>
            <th>NISN</th>
            <th>Program</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($queue as $item)
            <tr>
              <td style="font-weight: bold;">PMB-2026-{{ str_pad($item->id_murid, 3, '0', STR_PAD_LEFT) }}</td>
              <td style="font-weight: bold; color: #0f7643;">{{ $item->nama_murid }}</td>
              <td>{{ $item->nisn }}</td>
              <td>{{ $item->pendaftaran->program->nama_program ?? 'Umum' }}</td>
              <td>
                @if(isset($item->hasil) && $item->hasil->nilai_wawancara !== null)
                  <span class="badge badge-lunas">Selesai Uji (Score: {{ $item->hasil->nilai_wawancara }})</span>
                @else
                  <span class="badge badge-pending">Menunggu Uji</span>
                @endif
              </td>
              <td>
                <a href="{{ route('panitia.detail', $item->id_murid) }}" class="btn-grade">
                  @if(isset($item->hasil) && $item->hasil->nilai_wawancara !== null)
                    Ubah Nilai
                  @else
                    Mulai Uji
                  @endif
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="text-align: center; color: #6b7280; padding: 30px;">
                Tidak ada calon siswa dalam antrean uji hari ini.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Footer Component Included -->
    @include('components.footer-panitia', ['isGrading' => false])
  </div>
@endsection
