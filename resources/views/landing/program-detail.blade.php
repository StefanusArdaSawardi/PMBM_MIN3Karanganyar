@extends('layouts.landing')

@section('title', ($program ? $program->nama_program : 'Program Pendaftaran') . ' - PMBM MIN 3 Karanganyar')

@section('content')
  <div class="program-detail-page">
    @include('components.navbar', ['activeFolder' => 'program-khusus'])

    @include('components.program-detail', [
      'activeProgramId' => $program->id_program,
      'title' => $program->nama_program,
      'description' => $program->persyaratan,
      'image' => $program->image ? asset($program->image) : asset('assets/landing/program-khusus/save-clip-app-475343519-1307796727230381-3144782383292744901-n-10.png'),
      'features' => (is_array($program->poin_unggulan) && count($program->poin_unggulan) > 0) ? $program->poin_unggulan : [
        'Fokus pendalaman materi program',
        'Pembinaan karakter & akhlak mulia',
        'Fasilitas penunjang belajar lengkap'
      ],
    ])

    @include('components.footer', ['activeFolder' => 'program-khusus'])
  </div>
@endsection
