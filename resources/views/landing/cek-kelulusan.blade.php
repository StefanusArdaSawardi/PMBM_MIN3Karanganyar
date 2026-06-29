@extends('layouts.landing')

@section('title', 'Cek Kelulusan PMBM - MIN 3 Karanganyar')

@section('content')
  <div class="relative bg-[#e5e2e1]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    @include('components.navbar', ['activeFolder' => 'cek-kelulusan'])

    <section class="relative min-h-[380px] flex items-center overflow-hidden px-6 pt-[110px] pb-12">
      <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('assets/landing/home/hero-bg.jpg') }}" alt="MIN 3 Karanganyar" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/45"></div>
      </div>
      <div class="relative z-[1] w-full max-w-[700px] mx-auto text-center">
        <h1 class="text-white/90 font-bold tracking-[-0.4px] mb-4" style="font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: clamp(22px, 4vw, 30px);">Cek Status Kelulusan</h1>
        <p class="text-white text-[16px] leading-[1.6] m-0" style="font-family: 'Roboto-Regular', sans-serif;">Halaman resmi pengumuman hasil seleksi penerimaan peserta didik baru PMBM MIN 3 Karanganyar.</p>
      </div>
    </section>

    <section class="max-w-[600px] mx-auto px-6 -mt-10 mb-16 relative z-[2]">
      @if(session('error'))
        <div class="max-w-[480px] mx-auto mb-6 px-4 py-3 rounded-lg text-[13px] text-center bg-red-100 border border-red-300 text-red-700" style="font-family: 'PlusJakartaSans-Regular', sans-serif;">{{ session('error') }}</div>
      @endif
      @if(session('success_edit'))
        <div class="max-w-[480px] mx-auto mb-6 px-4 py-3 rounded-lg text-[13px] text-center bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-sm" style="font-family: 'PlusJakartaSans-Regular', sans-serif;">{{ session('success_edit') }}</div>
      @endif

      <div class="bg-white rounded-2xl shadow-[0px_4px_4px_0px_rgba(255,255,255,0.8),0px_10px_30px_rgba(0,0,0,0.1)] overflow-hidden">
        <div class="h-2 bg-[#0f7643]/90"></div>
        <div class="px-12 py-10 max-[600px]:px-6 max-[600px]:py-8 flex flex-col items-center gap-5">
          <h2 class="text-[#0f7643] text-[22px] font-medium tracking-[-0.4px] mb-2 text-center" style="font-family: 'Roboto-Medium', sans-serif;">CEK KELULUSAN</h2>

          <form action="{{ route('student.status.check') }}" method="POST" class="w-full flex flex-col items-center gap-4">
            @csrf
            <div class="w-full max-w-[280px]">
              <input type="text" name="nisn" placeholder="NISN" required
                     class="w-full h-[50px] px-[18px] border border-black/30 rounded-[10px] bg-white/80 text-[15px] text-[#1c1b1b] outline-none transition-colors duration-200 placeholder:text-[#3f4940]/60 focus:border-[#0f7643]"
                     style="font-family: 'PlusJakartaSans-Regular', sans-serif;">
            </div>
            <div class="w-full max-w-[280px]">
              <input type="text" name="nama_murid" placeholder="Nama Siswa" required
                     class="w-full h-[50px] px-[18px] border border-black/30 rounded-[10px] bg-white/80 text-[15px] text-[#1c1b1b] outline-none transition-colors duration-200 placeholder:text-[#3f4940]/60 focus:border-[#0f7643]"
                     style="font-family: 'PlusJakartaSans-Regular', sans-serif;">
            </div>
            <button type="submit"
                    class="mt-2 bg-[#005b31] text-white border-0 rounded-xl px-10 py-3 text-[15px] font-bold cursor-pointer shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.1),0px_4px_6px_-4px_rgba(0,0,0,0.1)] transition-colors duration-200 hover:bg-[#064e3b]"
                    style="font-family: 'WorkSans-Bold', sans-serif;">Cek</button>
          </form>
        </div>
      </div>
    </section>

    @include('components.footer', ['activeFolder' => 'cek-kelulusan'])
  </div>
@endsection
