@extends('layouts.landing')

@section('title', 'Panduan Pendaftaran PMBM - MIN 3 Karanganyar')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/landing/guide/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/landing/guide/style.css') }}">
@endsection

@section('content')
  <div class="dashboard-pmbm-min-3-kra">
    <!-- Header/Navbar Shared Component -->
    @include('components.navbar', ['activeFolder' => 'guide'])

    <!-- Main Guide Header -->
    <div class="heading-2">
      <div class="pendaftaran">Pendaftaran</div>
    </div>

    <!-- Guide Stats / Phase Info -->
    <div class="countdown">
      <div class="overlay-border-shadow-overlay-blur">
        <div class="container7">
          <div class="_103">45</div>
        </div>
        <div class="container8">
          <div class="text2">HARI</div>
        </div>
      </div>
      <div class="overlay-border-shadow-overlay-blur2">
        <div class="container7">
          <div class="_10">02</div>
        </div>
        <div class="container8">
          <div class="text2">JAM</div>
        </div>
      </div>
      <div class="overlay-border-shadow-overlay-blur3">
        <div class="container7">
          <div class="_48">59</div>
        </div>
        <div class="container8">
          <div class="text2">MENIT</div>
        </div>
      </div>
      <div class="overlay-border-shadow-overlay-blur4">
        <div class="container7">
          <div class="_50">47</div>
        </div>
        <div class="container8">
          <div class="text2">DETIK</div>
        </div>
      </div>
    </div>

    <!-- Guide Items List -->
    <div class="group-3" style="cursor: pointer;" onclick="openRequirementsOverlay()">
      <div class="rectangle-42"></div>
      <div class="container9">
        <div class="text3">Lengkapi berkas administrasi utama Anda.</div>
      </div>
      <img class="overlay" src="{{ asset('assets/landing/guide/overlay0.svg') }}" alt="Icon" />
      <div class="view" style="cursor: pointer;">View</div>
      <div class="syarat-pendaftaran" style="cursor: pointer;">Syarat Pendaftaran</div>
    </div>

    <div class="group-4" style="cursor: pointer;" onclick="openRundownOverlay()">
      <div class="rectangle-43"></div>
      <div class="container10">
        <div class="text3">Lengkapi berkas administrasi utama Anda.</div>
      </div>
      <img class="overlay2" src="{{ asset('assets/landing/guide/overlay1.svg') }}" alt="Icon" />
      <div class="view2" style="cursor: pointer;">View</div>
      <div class="jadwal-pendaftaran" style="cursor: pointer;">Jadwal Pendaftaran</div>
    </div>

    <div class="group-5" style="cursor: pointer;" onclick="window.location.href='{{ route('student.register') }}'">
      <div class="rectangle-44"></div>
      <div class="container11">
        <div class="text3">Lengkapi berkas administrasi utama Anda.</div>
      </div>
      <img class="overlay3" src="{{ asset('assets/landing/guide/overlay2.svg') }}" alt="Icon" />
      <div class="view3" style="cursor: pointer;">View</div>
      <div class="pendaftaran-pmbm" style="cursor: pointer;">Pendaftaran PMBM</div>
    </div>

    <div class="group-6" style="cursor: pointer;" onclick="window.location.href='{{ route('landing.program-khusus') }}'">
      <div class="rectangle-45"></div>
      <div class="container12">
        <div class="text3">Lengkapi berkas administrasi utama Anda.</div>
      </div>
      <img class="overlay4" src="{{ asset('assets/landing/guide/overlay3.svg') }}" alt="Icon" />
      <div class="view4" style="cursor: pointer;">View</div>
      <div class="program2" style="cursor: pointer;">Program</div>
    </div>

    <div class="group-7" style="cursor: pointer;" onclick="window.location.href='{{ route('landing.cek-kelulusan') }}'">
      <div class="rectangle-46"></div>
      <div class="container13">
        <div class="text3">Lengkapi berkas administrasi utama Anda.</div>
      </div>
      <img class="overlay5" src="{{ asset('assets/landing/guide/overlay4.svg') }}" alt="Icon" />
      <div class="view5" style="cursor: pointer;">View</div>
      <div class="kelulusan2" style="cursor: pointer;">Kelulusan</div>
    </div>

    <div class="group-8" style="cursor: pointer;" onclick="window.location.href='{{ route('landing.kontak') }}'">
      <div class="rectangle-47"></div>
      <div class="container14">
        <div class="text3">Lengkapi berkas administrasi utama Anda.</div>
      </div>
      <img class="overlay6" src="{{ asset('assets/landing/guide/overlay5.svg') }}" alt="Icon" />
      <div class="view6" style="cursor: pointer;">View</div>
      <div class="kontak2" style="cursor: pointer;">Kontak</div>
    </div>

    <!-- Requirements Modal Overlay Content -->
    <div id="requirementsOverlay" style="display: none; position: absolute; inset: 0; z-index: 10000;">
      <div class="rectangle-92"></div>
      <div class="rectangle-93"></div>
      <a href="{{ route('student.register') }}" class="daftar2" style="color: #ffffff; font-weight: bold; z-index: 10002;">Daftar</a>
      
      <!-- Custom exit button in top right of header -->
      <button type="button" onclick="closeRequirementsOverlay()" style="position: absolute; left: 1160px; top: 245px; width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.2); color: #ffffff; font-size: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 1px solid rgba(255,255,255,0.3); z-index: 10003; line-height: 1; transition: background 0.2s; font-family: sans-serif;" onmouseover="this.style.background='rgba(255,255,255,0.4)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">&times;</button>

      <div class="rectangle-94" style="cursor: pointer;" onclick="closeRequirementsOverlay()"></div>
      <a href="javascript:void(0);" onclick="closeRequirementsOverlay()" class="tutup" style="z-index: 10002; cursor: pointer;">Tutup</a>
      
      <div class="rectangle-95"></div>
      <div class="rectangle-96"></div>
      <div class="persyaratan-tambahan-opsional">Persyaratan Tambahan (Opsional)</div>
      <div class="piagam-penghargaan-juara-1-2-3-minimal-tingkat-kecamatan-jika-memiliki-pdf">
        Piagam Penghargaan Juara 1/2/3 minimal tingkat Kecamatan (Jika memiliki) (PDF)
      </div>
      
      <div class="rectangle-97"></div>
      <div class="rectangle-98"></div>
      <div class="rectangle-99"></div>
      <div class="rectangle-100"></div>
      <div class="persyaratan-wajib-umum">Persyaratan Wajib Umum</div>
      <div class="syarat-ketentuan-pendaftaran">Syarat &amp; Ketentuan Pendaftaran</div>
      <div class="umur-minimal-6-tahun-per-juli-2025">Umur minimal 6 Tahun per Juli 2025</div>
      <div class="memiliki-email-aktif">Memiliki email Aktif</div>
      
      <div class="rectangle-101"></div>
      <div class="rectangle-102"></div>
      <div class="rectangle-103"></div>
      <div class="rectangle-104"></div>
      <div class="rectangle-105"></div>
      <div class="rectangle-106"></div>
      
      <div class="persyaratan-wajib-umum2">Persyaratan Wajib Umum</div>
      <div class="pas-foto-berwarna-jpg-png-dan-jpeg">
        <ul class="pas-foto-berwarna-jpg-png-dan-jpeg-span">
          <li>Pas Foto Berwarna (JPG, PNG dan JPEG)</li>
        </ul>
      </div>
      <div class="kartu-keluarga-asli-pdf">
        <ul class="kartu-keluarga-asli-pdf-span">
          <li>Kartu Keluarga Asli (PDF)</li>
        </ul>
      </div>
      <div class="nisn-dari-tk-asal">
        <ul class="nisn-dari-tk-asal-span">
          <li>NISN (Dari TK asal)</li>
        </ul>
      </div>
      <div class="kartu-identitas-anak-pdf">
        <ul class="kartu-identitas-anak-pdf-span">
          <li>Kartu Identitas Anak (PDF)</li>
        </ul>
      </div>
      <div class="akta-kelahiran-asli-pdf">
        <ul class="akta-kelahiran-asli-pdf-span">
          <li>Akta Kelahiran Asli (PDF)</li>
        </ul>
      </div>
    </div>

    <!-- Rundown Modal Overlay Content -->
    <div id="rundownOverlay" style="display: none; position: absolute; inset: 0; z-index: 10000;">
      <div class="rectangle-92"></div>
      
      <!-- Custom exit button in top right of header -->
      <button type="button" onclick="closeRundownOverlay()" style="position: absolute; left: 1160px; top: 245px; width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.2); color: #ffffff; font-size: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 1px solid rgba(255,255,255,0.3); z-index: 10003; line-height: 1; transition: background 0.2s; font-family: sans-serif;" onmouseover="this.style.background='rgba(255,255,255,0.4)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">&times;</button>

      <div class="rectangle-94" style="cursor: pointer;" onclick="closeRundownOverlay()"></div>
      <a href="javascript:void(0);" onclick="closeRundownOverlay()" class="tutup" style="z-index: 10002; cursor: pointer;">Tutup</a>
      
      <div class="rectangle-97"></div>
      <div class="syarat-ketentuan-pendaftaran">Rundown Kegiatan PMBM</div>

      <!-- Rundown Timeline Content Area -->
      <div style="position: absolute; left: 350px; top: 430px; width: 820px; max-height: 680px; overflow-y: auto; padding-right: 20px; z-index: 10002; font-family: 'WorkSans-Regular', sans-serif;">
        @if(empty($landingContent['rundown']))
          <div style="text-align: center; color: #6b7280; font-size: 16px; margin-top: 50px;">
            Belum ada data jadwal rundown kegiatan.
          </div>
        @else
          <!-- Timeline layout -->
          <div style="position: relative; border-left: 3px solid #298752; padding-left: 30px; margin-left: 20px; display: flex; flex-direction: column; gap: 30px;">
            @foreach($landingContent['rundown'] as $item)
              <div style="position: relative;">
                <!-- Dot marker -->
                <div style="position: absolute; left: -41.5px; top: 4px; width: 20px; height: 20px; border-radius: 50%; background: #ffffff; border: 4px solid #298752; box-shadow: 0 0 0 4px rgba(41,135,82,0.15);"></div>
                
                <!-- Time & Date -->
                <div style="font-size: 14px; font-weight: bold; color: #298752; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">
                  {{ $item['tanggal'] }}
                </div>
                
                <!-- Title -->
                <div style="font-size: 20px; font-weight: bold; color: #1c1b1b; font-family: 'HankenGrotesk-SemiBold', sans-serif; margin-bottom: 6px;">
                  {{ $item['kegiatan'] }}
                </div>
                
                <!-- Description -->
                <div style="font-size: 15px; color: #4b5563; line-height: 1.5;">
                  {{ $item['keterangan'] }}
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>

    <!-- Footer Shared Component -->
    @include('components.footer', ['activeFolder' => 'guide'])
  </div>
@endsection

@section('scripts')
  <script>
    function openRequirementsOverlay() {
      document.getElementById('requirementsOverlay').style.display = 'block';
    }
    
    function closeRequirementsOverlay() {
      document.getElementById('requirementsOverlay').style.display = 'none';
    }

    function openRundownOverlay() {
      document.getElementById('rundownOverlay').style.display = 'block';
    }
    
    function closeRundownOverlay() {
      document.getElementById('rundownOverlay').style.display = 'none';
    }
  </script>
@endsection
