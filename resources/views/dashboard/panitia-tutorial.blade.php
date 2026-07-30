@extends('layouts.panitia')

@section('title', 'Tutorial Penggunaan Sistem - Penguji PMBM')

@section('styles')
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
      min-width: 320px;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
  </style>
@endsection

@section('content')
  <div class="relative min-h-screen bg-slate-50/50 antialiased">
    <!-- Panitia Sidebar/Topbar Included -->
    @include('components.sidebar-panitia', ['activeFolder' => 'tutorial'])

    <!-- Main Content Container with responsive padding and layout alignment -->
    <div class="relative pt-[140px] px-6 md:px-12 lg:px-16 xl:pr-10 xl:pl-[280px] flex flex-col gap-6 pb-12">
      
      <!-- Header Page Description -->
      <div class="flex flex-col gap-1.5 max-w-2xl">
        <h1 class="text-[#121c2a] text-2xl md:text-3xl font-bold tracking-tight font-sans">
          🎥 Video Tutorial Penggunaan Sistem
        </h1>
        <p class="text-slate-500 text-sm md:text-base leading-relaxed">
          Tonton tutorial untuk memahami tata cara input penilaian dan wawancara calon siswa baru MIN 3 Karanganyar.
        </p>
      </div>

      <div class="w-full max-w-3xl mt-4">
        
        <!-- Panitia Tutorial Card -->
        <div class="video-card">
          <div class="font-bold font-sans text-[16px] text-emerald-800 border-b-2 border-emerald-50 pb-2">
            Panduan Panitia Penguji (Ujian &amp; Wawancara)
          </div>
          <div class="text-[12px] text-slate-500 leading-relaxed">
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
              <div class="w-full h-full bg-[#1e293b] flex items-center justify-center text-slate-400 text-[12px] font-bold">
                Video belum diunggah oleh admin.
              </div>
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
