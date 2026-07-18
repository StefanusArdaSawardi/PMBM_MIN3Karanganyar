@extends('layouts.admin')

@section('title', 'Tutorial Penggunaan Sistem - CMS PMBM')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/admin/landing-manage/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/landing-manage/style.css') }}">
  <style>
    .video-container {
      background: #000;
      border-radius: 8px;
      overflow: hidden;
      aspect-ratio: 16/9;
      width: 100%;
      border: 1px solid #becabe;
    }
    .video-card {
      background: #ffffff;
      border-radius: 12px;
      border: 1px solid #becabe;
      padding: 24px;
      box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05);
      flex: 1;
      min-width: 340px;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
  </style>
@endsection

@section('content')
  <div class="desktop-15" style="overflow-y: auto; height: auto; min-height: 100vh; padding-bottom: 60px;">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'tutorial-view'])

    <!-- Main Content Wrapper -->
    <div style="position: absolute; left: 380px; top: 180px; right: 40px; display: flex; flex-direction: column; gap: 24px; z-index: 10;">
      
      <!-- Page Header -->
      <div style="display: flex; flex-direction: column; gap: 4px;">
        <div style="font-weight: bold; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 24px; color: #064e3b;">🎥 Video Tutorial Penggunaan Sistem</div>
        <div style="font-size: 13px; color: #475569;">Tonton tutorial untuk memahami tata cara pengelolaan sistem pendaftaran PMBM.</div>
      </div>

      <div style="display: flex; flex-direction: row; gap: 24px; width: 100%; align-items: stretch; height: auto; flex-wrap: wrap; margin-top: 10px;">
        
        <!-- Admin/TU Tutorial Card -->
        <div class="video-card">
          <div style="font-weight: bold; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 16px; color: #064e3b; border-bottom: 2px solid #f0fdf4; padding-bottom: 8px;">
            1. Panduan Staf Admin &amp; Tata Usaha
          </div>
          <div style="font-size: 12px; color: #64748b; line-height: 1.5;">
            Panduan lengkap mengenai pengelolaan periode pendaftaran, kelola jalur pendaftaran beserta kriteria kelulusan, dan pengaturan sistem DSS.
          </div>

          <div class="video-container">
            @if(!empty($content['guide_admin_video_file']))
              <video src="{{ asset($content['guide_admin_video_file']) }}" controls style="width: 100%; height: 100%; object-fit: contain;"></video>
            @elseif(!empty($content['guide_admin_video_url']))
              @php
                $url = $content['guide_admin_video_url'];
                $embedUrl = $url;
                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $match)) {
                    $embedUrl = "https://www.youtube.com/embed/" . $match[1];
                }
              @endphp
              <iframe src="{{ $embedUrl }}" frameborder="0" allowfullscreen style="width: 100%; height: 100%;"></iframe>
            @else
              <div style="width: 100%; height: 100%; background: #1e293b; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 12px; font-weight: bold;">
                Video belum diunggah oleh admin.
              </div>
            @endif
          </div>
        </div>

        <!-- Panitia Tutorial Card -->
        <div class="video-card">
          <div style="font-weight: bold; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 16px; color: #064e3b; border-bottom: 2px solid #f0fdf4; padding-bottom: 8px;">
            2. Panduan Panitia Penguji (Ujian &amp; Wawancara)
          </div>
          <div style="font-size: 12px; color: #64748b; line-height: 1.5;">
            Panduan bagi panitia untuk melakukan input penilaian onsite: hafalan, calistung, iqro, AISM, dikte, dan kemandirian calon murid.
          </div>

          <div class="video-container">
            @if(!empty($content['guide_panitia_video_file']))
              <video src="{{ asset($content['guide_panitia_video_file']) }}" controls style="width: 100%; height: 100%; object-fit: contain;"></video>
            @elseif(!empty($content['guide_panitia_video_url']))
              @php
                $url = $content['guide_panitia_video_url'];
                $embedUrl = $url;
                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $match)) {
                    $embedUrl = "https://www.youtube.com/embed/" . $match[1];
                }
              @endphp
              <iframe src="{{ $embedUrl }}" frameborder="0" allowfullscreen style="width: 100%; height: 100%;"></iframe>
            @else
              <div style="width: 100%; height: 100%; background: #1e293b; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 12px; font-weight: bold;">
                Video belum diunggah oleh admin.
              </div>
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
