@extends('layouts.landing')

@section('title', 'Program Khusus Tahfidz - PMBM MIN 3 Karanganyar')

@section('content')
  <div class="program-detail-page">
    @include('components.navbar', ['activeFolder' => 'program-khusus'])

    @include('components.program-detail', [
      'activeProgram' => 'khusus',
      'title' => 'Program Khusus (Tahfidz)',
      'description' => 'Fokus pada hafalan Al-Qur’an dengan tajwid yang benar serta pemahaman nilai-nilai spiritual.',
      'image' => asset('assets/landing/program-khusus/save-clip-app-475343519-1307796727230381-3144782383292744901-n-10.png'),
      'features' => [
        'Tahfidz Intensif',
        'Bahasa Arab Dasar',
        'Pembinaan Akhlak & Karakter Islami',
      ],
    ])

    @include('components.footer', ['activeFolder' => 'program-khusus'])
  </div>
@endsection
