@extends('layouts.landing')

@section('title', 'Program Fullday - PMBM MIN 3 Karanganyar')

@section('content')
  <div class="program-detail-page">
    @include('components.navbar', ['activeFolder' => 'program-fullday'])

    @include('components.program-detail', [
      'activeProgram' => 'fullday',
      'title' => 'Program Fullday',
      'description' => 'Fokus pada pengembangan karakter holistik melalui kegiatan ekstrakurikuler seni, olahraga, dan kepemimpinan.',
      'image' => asset('assets/landing/program-fullday/save-clip-app-475343519-1307796727230381-3144782383292744901-n-10.png'),
      'features' => [
        'Karakter Unggul, Mandiri & Religius',
        'Ekstrakurikuler Lengkap Bidang Seni & Olahraga',
        'Pembinaan Karakter & Kepemimpinan Holistik',
      ],
    ])

    @include('components.footer', ['activeFolder' => 'program-fullday'])
  </div>
@endsection
