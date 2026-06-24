@extends('layouts.admin')

@section('title', 'Daftar PMBM - Admin Portal')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/admin/applicants/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/applicants/style.css') }}">
  <style>
    /* Make the desktop container scrollable */
    .desktop-17 {
        height: auto !important;
        min-height: 100vh !important;
        overflow: visible !important;
        padding-bottom: 120px !important;
    }
    /* Scoping overlay form controls */
    .filter-select {
      width: 100%;
      height: 100%;
      padding: 0 40px 0 15px;
      font-family: inherit;
      font-size: 12px;
      font-weight: bold;
      color: #374151;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      background: #ffffff;
      cursor: pointer;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      outline: none;
    }
    .filter-select:focus {
      border-color: #298752;
    }
  </style>
@endsection

@section('content')
  <div class="desktop-17">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'applicants'])

    <!-- Content Wrapper for alignments -->
    <div style="position: absolute; left: 340px; top: 138px; right: 40px; display: flex; flex-direction: column; gap: 24px; z-index: 10;">
      
      <!-- Section Header Description -->
      <div class="section-header-description" style="position: relative !important; left: auto !important; top: auto !important; right: auto !important; width: 100% !important; margin: 0 !important; height: auto !important;">
        <div class="heading-2">
          <div class="daftar-pmbm">Daftar PMBM</div>
        </div>
        <div class="container" style="border: none; padding: 0;">
          <div class="manage-and-monitor-university-applicants-for-the-current-academic-year">
            Kelola dan pantau seluruh pendaftar calon siswa baru
            <br />
            MIN 3 Karanganyar periode aktif.
          </div>
        </div>
      </div>

      <!-- Filters Section -->
      <form action="{{ route('scores.index') }}" method="GET" style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: stretch; margin: 0; position: relative;">
        <!-- Year Filter -->
        <div class="year-filter" style="flex: 1; position: relative; top: auto; left: auto; right: auto; width: auto; margin: 0;">
          <div class="label">
            <div class="tahun-pendaftaran">TAHUN PENDAFTARAN</div>
          </div>
          <div class="container" style="border: none; padding: 0; position: relative; width: 100%; height: 42px;">
            <select name="tahun" class="filter-select" onchange="this.form.submit()">
              <option value="2026" {{ request('tahun') == '2026' ? 'selected' : '' }}>2026 / 2027</option>
              <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025 / 2026</option>
            </select>
            <img class="container3" src="{{ asset('assets/admin/applicants/container3.svg') }}" style="pointer-events: none;" />
          </div>
        </div>
        
        <!-- Program Filter -->
        <div class="program-filter" style="flex: 1; position: relative; top: auto; left: auto; right: auto; width: auto; margin: 0;">
          <div class="label">
            <div class="program-studi-jalur">PROGRAM / JALUR</div>
          </div>
          <div class="container" style="border: none; padding: 0; position: relative; width: 100%; height: 42px;">
            <select name="program" class="filter-select" onchange="this.form.submit()">
              <option value="">Semua Program</option>
              @foreach($programs as $prog)
                <option value="{{ $prog->id_program }}" {{ request('program') == $prog->id_program ? 'selected' : '' }}>
                  {{ $prog->nama_program }}
                </option>
              @endforeach
            </select>
            <img class="container5" src="{{ asset('assets/admin/applicants/container9.svg') }}" style="pointer-events: none;" />
          </div>
        </div>

        <!-- Status Filter -->
        <div class="status-filter" style="flex: 1; position: relative; top: auto; left: auto; right: auto; width: auto; margin: 0;">
          <div class="label">
            <div class="status">STATUS</div>
          </div>
          <div class="container" style="border: none; padding: 0; position: relative; width: 100%; height: 42px;">
            <select name="status" class="filter-select" onchange="this.form.submit()">
              <option value="">Semua Status</option>
              <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Baru / Perubahan Data</option>
              <option value="Berkas Diterima" {{ request('status') == 'Berkas Diterima' ? 'selected' : '' }}>Berkas Diterima</option>
              <option value="Berkas Ditolak" {{ request('status') == 'Berkas Ditolak' ? 'selected' : '' }}>Berkas Ditolak</option>
              <option value="Berkas Onsite Diterima" {{ request('status') == 'Berkas Onsite Diterima' ? 'selected' : '' }}>Berkas Onsite Diterima</option>
              <option value="Lulus" {{ request('status') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
              <option value="Tidak Lulus" {{ request('status') == 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus</option>
              <option value="Cadangan" {{ request('status') == 'Cadangan' ? 'selected' : '' }}>Cadangan</option>
              <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima (Daftar Ulang)</option>
              <option value="Mengundurkan Diri" {{ request('status') == 'Mengundurkan Diri' ? 'selected' : '' }}>Mengundurkan Diri</option>
            </select>
            <img class="container4" src="{{ asset('assets/admin/applicants/container6.svg') }}" style="pointer-events: none;" />
          </div>
        </div>

        <!-- Limit Display Filter -->
        <div class="year-filter" style="flex: 1; position: relative; top: auto; left: auto; right: auto; width: auto; margin: 0;">
          <div class="label">
            <div class="status">BATAS TAMPILAN</div>
          </div>
          <div class="container" style="border: none; padding: 0; position: relative; width: 100%; height: 42px;">
            <select name="limit" class="filter-select" onchange="this.form.submit()">
              <option value="5" {{ (isset($limit) && $limit == 5) ? 'selected' : '' }}>5 Data</option>
              <option value="10" {{ (isset($limit) && $limit == 10) ? 'selected' : '' }}>10 Data</option>
              <option value="20" {{ (isset($limit) && $limit == 20) ? 'selected' : '' }}>20 Data</option>
              <option value="30" {{ (isset($limit) && $limit == 30) ? 'selected' : '' }}>30 Data</option>
            </select>
            <img class="container4" src="{{ asset('assets/admin/applicants/container6.svg') }}" style="pointer-events: none;" />
          </div>
        </div>
      </form>

      <!-- Header List Toolbar -->
      <div class="section-actions-tools" style="position: relative !important; left: auto !important; top: auto !important; right: auto !important; width: 100% !important; margin: 0 !important; display: flex !important; flex-direction: row !important; justify-content: space-between !important; align-items: center !important;">
        <div class="heading-3-recent-applicants">Recent Applicants</div>
        <div class="container6">
          <div class="button" onclick="alert('Eksport data dalam proses pengembangan')" style="cursor: pointer;">
            <img class="container7" src="{{ asset('assets/admin/applicants/container11.svg') }}" />
            <div class="text2">Export PDF</div>
          </div>
          <div class="button2" onclick="alert('Eksport data dalam proses pengembangan')" style="cursor: pointer;">
            <img class="container8" src="{{ asset('assets/admin/applicants/container12.svg') }}" />
            <div class="text2">Export Excel</div>
          </div>
        </div>
      </div>

      <!-- Applicants List Loop -->
      <div class="section-applicant-list-responsive-cards-for-mobile-table-like-for-desktop" style="position: relative !important; left: auto !important; top: auto !important; right: auto !important; width: 100% !important; margin: 0 !important; height: auto !important; min-height: 400px; display: flex; flex-direction: column; gap: 15px; overflow: visible;">
        @forelse($pendaftarans as $item)
          <div class="applicant-card-1" style="position: relative; margin-bottom: 5px; height: 110px; width: 100%; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: border-color 0.2s;" onmouseover="this.style.borderColor='#7ed99c'" onmouseout="this.style.borderColor='#e5e7eb'">
            <!-- Program Info (Left Column) -->
            <div style="position: absolute; left: 0; top: 0; width: 180px; height: 100%; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; justify-content: center; padding-left: 20px;">
              <div style="color: #6b7280; font-size: 9px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 4px;">PROGRAM</div>
              <div style="font-size: 12px; font-weight: bold; color: #111827;">{{ $item->program->nama_program }}</div>
            </div>
            
            <!-- Details (Right Column Flexbox) -->
            <div style="position: absolute; left: 190px; top: 0; right: 0; height: 100%; display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding-right: 20px;">
              <!-- Avatar & Name Info -->
              <div style="display: flex; align-items: center; gap: 12px; width: 220px;">
                <div style="background: #298752; color: #ffffff; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;">
                  {{ strtoupper(substr($item->calonMurid->nama_murid, 0, 2)) }}
                </div>
                <div style="display: flex; flex-direction: column; justify-content: center; overflow: hidden;">
                  <div style="font-size: 14px; font-weight: bold; color: #111827; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $item->calonMurid->nama_murid }}</div>
                  <div style="font-size: 11px; color: #6b7280; margin-top: 2px;">No Reg: PMB-2026-{{ str_pad($item->id_pendaftaran, 3, '0', STR_PAD_LEFT) }}</div>
                </div>
              </div>
              
              <!-- Phone Number -->
              <div style="font-size: 13px; color: #374151; font-weight: 500; min-width: 120px;">
                {{ $item->calonMurid->ibu->nomor_telpon ?? 'No Telpon' }}
              </div>
              
              <!-- Email Address -->
              <div style="font-size: 13px; color: #6b7280; min-width: 180px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                {{ $item->calonMurid->email ?? $item->calonMurid->ibu->email }}
              </div>
              
              <!-- Status Badge -->
              @php
                $badgeBg = '#fffbeb';
                $badgeBorder = '#fde68a';
                $badgeText = '#d97706';
                
                if (in_array($item->status, ['Lulus', 'Diterima', 'Berkas Diterima', 'Berkas Onsite Diterima', 'Diterima di Program Pilihan'])) {
                    $badgeBg = '#ecfdf5';
                    $badgeBorder = '#a7f3d0';
                    $badgeText = '#047857';
                } elseif (in_array($item->status, ['Tidak Lulus', 'Berkas Ditolak', 'Mengundurkan Diri', 'Ditolak'])) {
                    $badgeBg = '#fef2f2';
                    $badgeBorder = '#fca5a5';
                    $badgeText = '#b91c1c';
                } elseif ($item->status === 'Pindahkan ke Program Reguler') {
                    $badgeBg = '#fff7ed';
                    $badgeBorder = '#ffedd5';
                    $badgeText = '#c2410c';
                }
              @endphp
              <div style="background: {{ $badgeBg }}; border: 1px solid {{ $badgeBorder }}; border-radius: 9999px; padding: 6px 12px; display: flex; align-items: center; justify-content: center; min-width: 120px; height: 28px; flex-shrink: 0;">
                <div style="color: {{ $badgeText }}; font-size: 9px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase; text-align: center;">
                  {{ $item->status === 'Pending' ? 'BARU / PENDING' : $item->status }}
                </div>
              </div>
              
              <!-- Detail Action Button -->
              <div style="display: flex; align-items: center;">
                <a href="{{ route('tata_usaha.detail', $item->id_pendaftaran) }}" style="display: flex; align-items: center; justify-content: center; text-decoration: none; width: 70px; height: 32px; background: #298752; border-radius: 6px; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#064e3b'" onmouseout="this.style.backgroundColor='#298752'">
                  <span style="font-size: 11px; font-weight: bold; color: #ffffff;">Detail</span>
                </a>
              </div>
            </div>
          </div>
        @empty
          <div style="text-align: center; color: #6b7280; padding: 40px; font-size: 14px;">
            Tidak ada calon pendaftar yang cocok dengan filter yang dipilih.
          </div>
        @endforelse
      </div>

      <!-- Pagination Section -->
      <div class="section-pagination" style="position: relative !important; left: auto !important; top: auto !important; right: auto !important; width: 100% !important; margin-top: 20px !important; display: flex; flex-direction: column; align-items: center; gap: 16px;">
        <div class="container14">
          <div class="text8">
            <span>
              <span class="text-8-span">Showing</span>
              <span class="text-8-span2">1 to {{ count($pendaftarans) }}</span>
              <span class="text-8-span">of</span>
              <span class="text-8-span2">{{ count($pendaftarans) }}</span>
              <span class="text-8-span">results</span>
            </span>
          </div>
        </div>
        <div class="container15">
          <div class="button4">
            <img class="container16" src="{{ asset('assets/admin/applicants/container51.svg') }}" />
          </div>
          <div class="button5">
            <div class="text9">1</div>
          </div>
          <div class="button4">
            <img class="container18" src="{{ asset('assets/admin/applicants/container53.svg') }}" />
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
