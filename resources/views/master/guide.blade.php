@extends('layouts.admin')

@section('title', 'Kelola Video Panduan - CMS PMBM')

@section('content')
  <div class="relative min-h-screen bg-[#f8f9ff] flow-root">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'guide-manage'])

    <!-- Content Wrapper -->
    <div class="absolute left-[380px] top-[180px] right-10 flex flex-col gap-6 z-0 max-[1024px]:left-5 max-[1024px]:right-5 max-[1024px]:top-[150px] pb-12">
      <!-- Page Header -->
      <div class="flex flex-col gap-1">
        <div class="text-[#181c1c] text-[28px] font-bold tracking-[-0.56px]" style="font-family: 'Manrope-Bold', sans-serif;">Kelola Video Panduan Pendaftaran</div>
        <div class="text-[#3f4941] text-[14px]">Unggah video panduan atau tautkan URL tutorial untuk orang tua dan panitia.</div>
      </div>

      @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-300 text-emerald-700 text-[13px] rounded-md p-3 font-bold">
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-700 text-[13px] rounded-md p-3 font-bold">
          {{ $errors->first() }}
        </div>
      @endif

      <form action="{{ route('tata_usaha.guide.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6 max-w-[800px] w-full bg-white border border-[#bec9be] rounded-xl p-8 shadow-sm">
        @csrf

        <!-- 1. Video Panduan Orang Tua (Pendaftaran) -->
        <div class="flex flex-col gap-4 border-b border-gray-100 pb-6">
          <div class="text-[#005b31] text-[18px] font-bold" style="font-family: 'Manrope-Bold', sans-serif;">1. Video Panduan untuk Orang Tua (Halaman Utama)</div>
          
          <div class="flex flex-col gap-2">
            <label class="text-[#3f4941] text-[12px] font-bold uppercase">Tautan URL Video (YouTube / Web Link)</label>
            <input type="text" name="guide_parent_video_url" value="{{ $content['guide_parent_video_url'] ?? '' }}" placeholder="Contoh: https://www.youtube.com/watch?v=xxxx"
                   class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none w-full">
          </div>

        </div>

        <!-- 2. Video Tutorial Staf (Admin) -->
        <div class="flex flex-col gap-4 border-b border-gray-100 pb-6">
          <div class="text-[#005b31] text-[18px] font-bold" style="font-family: 'Manrope-Bold', sans-serif;">2. Video Tutorial Penggunaan Sistem (Admin / Tata Usaha)</div>
          
          <div class="flex flex-col gap-2">
            <label class="text-[#3f4941] text-[12px] font-bold uppercase">Tautan URL Video Tutorial Admin</label>
            <input type="text" name="guide_admin_video_url" value="{{ $content['guide_admin_video_url'] ?? '' }}" placeholder="Contoh: https://www.youtube.com/watch?v=yyyy"
                   class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none w-full">
          </div>

        </div>

        <!-- 3. Video Tutorial Staf (Panitia) -->
        <div class="flex flex-col gap-4 pb-6">
          <div class="text-[#005b31] text-[18px] font-bold" style="font-family: 'Manrope-Bold', sans-serif;">3. Video Tutorial Penggunaan Sistem (Panitia Pengawas/Wawancara)</div>
          
          <div class="flex flex-col gap-2">
            <label class="text-[#3f4941] text-[12px] font-bold uppercase">Tautan URL Video Tutorial Panitia</label>
            <input type="text" name="guide_panitia_video_url" value="{{ $content['guide_panitia_video_url'] ?? '' }}" placeholder="Contoh: https://www.youtube.com/watch?v=zzzz"
                   class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none w-full">
          </div>

        </div>

        <!-- Action Button -->
        <div class="flex justify-end gap-4 mt-4">
          <button type="submit" class="bg-[#006a3c] text-white font-bold text-[16px] px-8 py-2.5 rounded hover:bg-[#064e3b] cursor-pointer border-none shadow-sm">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
