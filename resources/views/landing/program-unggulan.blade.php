@extends('layouts.landing')

@section('title', 'Program Unggulan Sains - PMBM MIN 3 Karanganyar')

@section('content')
  <div class="program-detail-page">
    @include('components.navbar', ['activeFolder' => 'program-unggulan'])

    @include('components.program-detail', [
      'activeProgram' => 'unggulan',
      'title' => 'Program Unggulan (Sains)',
      'description' => 'Fokus pada pengembangan kompetensi sains, matematika tingkat lanjut, dan logika analitis.',
      'image' => asset('assets/landing/home/save-clip-app-475743711-1307796790563708-7462844736250640796-n-20.png'),
      'features' => [
        'Bimbingan Intensif Kompetensi Bidang Studi Sains dan Matematika Terpadu',
        'Pembinaan Khusus Persiapan Olimpiade Sains Nasional & Kompetisi Sains Madrasah',
        'Praktikum Eksperimen Ilmiah & Pengembangan Logika Analitis Siswa',
      ],
    ])

    @include('components.footer', ['activeFolder' => 'program-unggulan'])
  </div>
@endsection
