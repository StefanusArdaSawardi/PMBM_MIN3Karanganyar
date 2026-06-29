@extends('layouts.landing')

@section('title', 'Panduan Pendaftaran PMBM - MIN 3 Karanganyar')

@section('content')
  <div class="relative bg-[#e5e2e1]" style="font-family: 'PlusJakartaSans-Regular', sans-serif;">
    <!-- Header/Navbar Shared Component -->
    @include('components.navbar', ['activeFolder' => 'guide'])

    <!-- Hero + Countdown -->
    <section class="relative bg-[#d9d9d9] px-6 pt-[120px] pb-16 flex flex-col items-center gap-6 text-center">
      <h1 class="text-white font-bold tracking-[-0.48px] leading-[1.2] m-0" style="font-family: 'HankenGrotesk-Bold', sans-serif; font-size: clamp(28px, 5vw, 48px);">Pendaftaran</h1>

      <div class="grid grid-cols-4 gap-4 max-w-[448px] w-full max-[480px]:grid-cols-2">
        <div class="bg-white/10 backdrop-blur-[10px] border border-white/20 rounded-2xl shadow-[0px_4px_20px_0px_rgba(0,0,0,0.04)] px-4 py-4 flex flex-col items-center gap-0">
          <div class="text-white text-[32px] font-bold" style="font-family: 'HankenGrotesk-Bold', sans-serif;">45</div>
          <div class="text-white/60 text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">HARI</div>
        </div>
        <div class="bg-white/10 backdrop-blur-[10px] border border-white/20 rounded-2xl shadow-[0px_4px_20px_0px_rgba(0,0,0,0.04)] px-4 py-4 flex flex-col items-center gap-0">
          <div class="text-white text-[32px] font-bold" style="font-family: 'HankenGrotesk-Bold', sans-serif;">02</div>
          <div class="text-white/60 text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">JAM</div>
        </div>
        <div class="bg-white/10 backdrop-blur-[10px] border border-white/20 rounded-2xl shadow-[0px_4px_20px_0px_rgba(0,0,0,0.04)] px-4 py-4 flex flex-col items-center gap-0">
          <div class="text-white text-[32px] font-bold" style="font-family: 'HankenGrotesk-Bold', sans-serif;">59</div>
          <div class="text-white/60 text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">MENIT</div>
        </div>
        <div class="bg-white/10 backdrop-blur-[10px] border border-white/20 rounded-2xl shadow-[0px_4px_20px_0px_rgba(0,0,0,0.04)] px-4 py-4 flex flex-col items-center gap-0">
          <div class="text-white text-[32px] font-bold" style="font-family: 'HankenGrotesk-Bold', sans-serif;">47</div>
          <div class="text-white/60 text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">DETIK</div>
        </div>
      </div>
    </section>

    <!-- Guide Items Grid -->
    <section class="max-w-[1170px] mx-auto px-6 -mt-10 mb-16 relative z-[2] grid grid-cols-3 gap-7 max-[1024px]:grid-cols-2 max-[640px]:grid-cols-1">
      <div class="bg-white rounded-2xl shadow-[0px_4px_20px_0px_rgba(0,0,0,0.15)] backdrop-blur-[10px] p-7 flex flex-col gap-3 cursor-pointer transition-transform duration-200 hover:-translate-y-1" onclick="openRequirementsOverlay()">
        <img class="w-9 h-9" src="{{ asset('assets/landing/guide/overlay0.svg') }}" alt="Icon" />
        <div class="text-[#1c1b1b] text-[24px] font-semibold" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">Syarat Pendaftaran</div>
        <div class="text-[#3e4a3c] text-[16px]" style="font-family: 'WorkSans-Regular', sans-serif;">Lengkapi berkas administrasi utama Anda.</div>
        <div class="text-[#006b24] text-[14px] font-semibold tracking-[0.7px] mt-2" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">View</div>
      </div>

      <div class="bg-white rounded-2xl shadow-[0px_4px_20px_0px_rgba(0,0,0,0.15)] backdrop-blur-[10px] p-7 flex flex-col gap-3 cursor-pointer transition-transform duration-200 hover:-translate-y-1" onclick="openRundownOverlay()">
        <img class="w-9 h-9" src="{{ asset('assets/landing/guide/overlay1.svg') }}" alt="Icon" />
        <div class="text-[#1c1b1b] text-[24px] font-semibold" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">Jadwal Pendaftaran</div>
        <div class="text-[#3e4a3c] text-[16px]" style="font-family: 'WorkSans-Regular', sans-serif;">Lengkapi berkas administrasi utama Anda.</div>
        <div class="text-[#006b24] text-[14px] font-semibold tracking-[0.7px] mt-2" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">View</div>
      </div>

      <div class="bg-white rounded-2xl shadow-[0px_4px_20px_0px_rgba(0,0,0,0.15)] backdrop-blur-[10px] p-7 flex flex-col gap-3 cursor-pointer transition-transform duration-200 hover:-translate-y-1" onclick="window.location.href='{{ route('student.register') }}'">
        <img class="w-9 h-9" src="{{ asset('assets/landing/guide/overlay2.svg') }}" alt="Icon" />
        <div class="text-[#1c1b1b] text-[24px] font-semibold" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">Pendaftaran PMBM</div>
        <div class="text-[#3e4a3c] text-[16px]" style="font-family: 'WorkSans-Regular', sans-serif;">Lengkapi berkas administrasi utama Anda.</div>
        <div class="text-[#006b24] text-[14px] font-semibold tracking-[0.7px] mt-2" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">View</div>
      </div>

      <div class="bg-white rounded-2xl shadow-[0px_4px_20px_0px_rgba(0,0,0,0.15)] backdrop-blur-[10px] p-7 flex flex-col gap-3 cursor-pointer transition-transform duration-200 hover:-translate-y-1" onclick="window.location.href='{{ route('landing.program-khusus') }}'">
        <img class="w-9 h-9" src="{{ asset('assets/landing/guide/overlay3.svg') }}" alt="Icon" />
        <div class="text-[#1c1b1b] text-[24px] font-semibold" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">Program</div>
        <div class="text-[#3e4a3c] text-[16px]" style="font-family: 'WorkSans-Regular', sans-serif;">Lengkapi berkas administrasi utama Anda.</div>
        <div class="text-[#006b24] text-[14px] font-semibold tracking-[0.7px] mt-2" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">View</div>
      </div>

      <div class="bg-white rounded-2xl shadow-[0px_4px_20px_0px_rgba(0,0,0,0.15)] backdrop-blur-[10px] p-7 flex flex-col gap-3 cursor-pointer transition-transform duration-200 hover:-translate-y-1" onclick="window.location.href='{{ route('landing.cek-kelulusan') }}'">
        <img class="w-9 h-9" src="{{ asset('assets/landing/guide/overlay4.svg') }}" alt="Icon" />
        <div class="text-[#1c1b1b] text-[24px] font-semibold" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">Kelulusan</div>
        <div class="text-[#3e4a3c] text-[16px]" style="font-family: 'WorkSans-Regular', sans-serif;">Lengkapi berkas administrasi utama Anda.</div>
        <div class="text-[#006b24] text-[14px] font-semibold tracking-[0.7px] mt-2" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">View</div>
      </div>

      <div class="bg-white rounded-2xl shadow-[0px_4px_20px_0px_rgba(0,0,0,0.15)] backdrop-blur-[10px] p-7 flex flex-col gap-3 cursor-pointer transition-transform duration-200 hover:-translate-y-1" onclick="window.location.href='{{ route('landing.kontak') }}'">
        <img class="w-9 h-9" src="{{ asset('assets/landing/guide/overlay5.svg') }}" alt="Icon" />
        <div class="text-[#1c1b1b] text-[24px] font-semibold" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">Kontak</div>
        <div class="text-[#3e4a3c] text-[16px]" style="font-family: 'WorkSans-Regular', sans-serif;">Lengkapi berkas administrasi utama Anda.</div>
        <div class="text-[#006b24] text-[14px] font-semibold tracking-[0.7px] mt-2" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">View</div>
      </div>
    </section>

    <!-- Requirements Modal Overlay -->
    <div id="requirementsOverlay" style="display: none;" class="fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-black/50">
      <div class="bg-white rounded-2xl w-full max-w-[820px] max-h-[85vh] overflow-y-auto relative">
        <div class="sticky top-0 bg-[#006b24] rounded-t-2xl px-8 py-6 flex items-center justify-between z-10">
          <div class="text-white text-[20px] font-semibold" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">Syarat &amp; Ketentuan Pendaftaran</div>
          <button type="button" onclick="closeRequirementsOverlay()" class="w-9 h-9 rounded-full bg-white/20 hover:bg-white/40 text-white text-[24px] flex items-center justify-center cursor-pointer border border-white/30 transition-colors duration-200 leading-none">&times;</button>
        </div>

        <div class="p-8 flex flex-col gap-0">
          <div class="bg-[#d9d9d9] border border-[#bdcab8] rounded-t-xl px-6 py-4 text-[#1c1b1b] text-[20px] font-semibold" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">Persyaratan Wajib Umum</div>
          <div class="bg-[#d9d9d9]/80 border border-[#bdcab8] px-6 py-4 text-[#1c1b1b] text-[16px]" style="font-family: 'HankenGrotesk-Regular', sans-serif;">Umur minimal 6 Tahun per Juli 2025</div>
          <div class="bg-[#d9d9d9] border border-[#bdcab8] rounded-b-xl px-6 py-4 text-[#1c1b1b] text-[16px]" style="font-family: 'HankenGrotesk-Regular', sans-serif;">Memiliki email Aktif</div>

          <div class="bg-[#d9d9d9] border border-[#bdcab8] rounded-t-xl px-6 py-4 mt-6 text-[#1c1b1b] text-[20px] font-semibold" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">Persyaratan Wajib Umum</div>
          <div class="bg-[#d9d9d9]/80 border border-[#bdcab8] px-6 py-4 text-black text-[16px]" style="font-family: 'HankenGrotesk-Regular', sans-serif;">Pas Foto Berwarna (JPG, PNG dan JPEG)</div>
          <div class="bg-[#d9d9d9] border border-[#bdcab8] px-6 py-4 text-black text-[16px]" style="font-family: 'HankenGrotesk-Regular', sans-serif;">Kartu Keluarga Asli (PDF)</div>
          <div class="bg-[#d9d9d9]/80 border border-[#bdcab8] px-6 py-4 text-black text-[16px]" style="font-family: 'HankenGrotesk-Regular', sans-serif;">Akta Kelahiran Asli (PDF)</div>
          <div class="bg-[#d9d9d9] border border-[#bdcab8] px-6 py-4 text-black text-[16px]" style="font-family: 'HankenGrotesk-Regular', sans-serif;">Kartu Identitas Anak (PDF)</div>
          <div class="bg-[#d9d9d9]/80 border border-[#bdcab8] rounded-b-xl px-6 py-4 text-black text-[16px]" style="font-family: 'HankenGrotesk-Regular', sans-serif;">NISN (Dari TK asal)</div>

          <div class="mt-6">
            <div class="text-[#1c1b1b] text-[20px] font-semibold mb-2" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">Persyaratan Tambahan (Opsional)</div>
            <div class="text-[#1c1b1b] text-[16px]" style="font-family: 'HankenGrotesk-Regular', sans-serif;">Piagam Penghargaan Juara 1/2/3 minimal tingkat Kecamatan (Jika memiliki) (PDF)</div>
          </div>

          <div class="flex gap-3 mt-8 justify-end max-[480px]:flex-col">
            <button type="button" onclick="closeRequirementsOverlay()" class="bg-[#3f4940] text-white border border-[#0f7643] rounded px-6 h-9 text-[15px] cursor-pointer" style="font-family: 'HankenGrotesk-Regular', sans-serif;">Tutup</button>
            <a href="{{ route('student.register') }}" class="bg-[#064e3b] text-white border border-[#0f7643] rounded px-6 h-9 flex items-center justify-center text-[15px] font-bold no-underline" style="font-family: 'HankenGrotesk-Regular', sans-serif;">Daftar</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Rundown Modal Overlay -->
    <div id="rundownOverlay" style="display: none;" class="fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-black/50">
      <div class="bg-white rounded-2xl w-full max-w-[820px] max-h-[85vh] overflow-y-auto relative">
        <div class="sticky top-0 bg-[#006b24] rounded-t-2xl px-8 py-6 flex items-center justify-between z-10">
          <div class="text-white text-[20px] font-semibold" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">Rundown Kegiatan PMBM</div>
          <button type="button" onclick="closeRundownOverlay()" class="w-9 h-9 rounded-full bg-white/20 hover:bg-white/40 text-white text-[24px] flex items-center justify-center cursor-pointer border border-white/30 transition-colors duration-200 leading-none">&times;</button>
        </div>

        <div class="p-8" style="font-family: 'WorkSans-Regular', sans-serif;">
          @if(empty($landingContent['rundown']))
            <div class="text-center text-gray-500 text-[16px] mt-12">
              Belum ada data jadwal rundown kegiatan.
            </div>
          @else
            <div class="relative border-l-[3px] border-[#298752] pl-7 ml-5 flex flex-col gap-7">
              @foreach($landingContent['rundown'] as $item)
                <div class="relative">
                  <div class="absolute -left-[41.5px] top-1 w-5 h-5 rounded-full bg-white border-4 border-[#298752] shadow-[0_0_0_4px_rgba(41,135,82,0.15)]"></div>

                  <div class="text-[14px] font-bold text-[#298752] mb-1 uppercase tracking-[0.5px]">
                    {{ $item['tanggal'] }}
                  </div>

                  <div class="text-[20px] font-bold text-[#1c1b1b] mb-1.5" style="font-family: 'HankenGrotesk-SemiBold', sans-serif;">
                    {{ $item['kegiatan'] }}
                  </div>

                  <div class="text-[15px] text-gray-600 leading-[1.5]">
                    {{ $item['keterangan'] }}
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Footer Shared Component -->
    @include('components.footer', ['activeFolder' => 'guide'])
  </div>
@endsection

@section('scripts')
  <script>
    function openRequirementsOverlay() {
      document.getElementById('requirementsOverlay').style.display = 'flex';
    }

    function closeRequirementsOverlay() {
      document.getElementById('requirementsOverlay').style.display = 'none';
    }

    function openRundownOverlay() {
      document.getElementById('rundownOverlay').style.display = 'flex';
    }

    function closeRundownOverlay() {
      document.getElementById('rundownOverlay').style.display = 'none';
    }
  </script>
@endsection
