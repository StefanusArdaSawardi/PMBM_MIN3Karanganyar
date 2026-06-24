@extends('layouts.landing')

@section('title', 'Hasil Kelulusan PMBM - MIN 3 Karanganyar')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/landing/hasil-kelulusan/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/landing/hasil-kelulusan/style.css') }}">
@endsection

@section('content')
  <div class="kelulusan">
    <!-- Header/Navbar Shared Component -->
    @include('components.navbar', ['activeFolder' => 'hasil-kelulusan'])

    <div class="cek-status-kelulusan">Cek Status Kelulusan</div>
    <div class="halaman-resmi-pengumuman-hasil-seleksi-penerimaan-peserta-didik-baru-pmbm-min-3-karanganyar">
      Halaman resmi pengumuman hasil seleksi penerimaan peserta didik baru PMBM MIN 3 Karanganyar.
    </div>

    <!-- Informasi Sidebar Panel -->
    <div class="rectangle-16"></div>
    <div class="container">
      <div class="heading-5">
        <div class="informasi">INFORMASI</div>
      </div>
      <div class="list">
        <div class="item">
          <a href="{{ route('landing.guide') }}" class="syarat-daftar" style="color: inherit;">Syarat Daftar</a>
        </div>
        <div class="item">
          <a href="{{ route('landing.guide') }}" class="biaya-pendidikan" style="color: inherit;">Biaya Pendidikan</a>
        </div>
        <div class="item">
          <a href="#" class="brosur-digital" style="color: inherit;" onclick="alert('Brosur digital sedang dipersiapkan!');">Brosur Digital</a>
        </div>
        <div class="item">
          <a href="#" class="panduan-siswa" style="color: inherit;" onclick="alert('Panduan siswa sedang dipersiapkan!');">Panduan Siswa</a>
        </div>
      </div>
    </div>

    <!-- Card Background -->
    <div class="rectangle-19"></div>
    
    <!-- Dynamic Student Name -->
    <div class="tania-talia">{{ strtoupper($student->nama_murid) }}</div>

    @if(in_array(strval($pendaftaran->status), ['Diterima', 'Diterima di Program Pilihan']))
      <!-- Status Diterima (Sudah Daftar Ulang) -->
      <div class="selamat-anda-telah-keterima" style="color: #047857;">SELAMAT ANDA TELAH DITERIMA</div>
      
      <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
        <span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Selamat! Anda telah resmi dinyatakan lulus seleksi dan diterima sebagai siswa baru di MIN 3 Karanganyar untuk program pilihan Anda. Silakan
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span2">
            klik tombol
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            di bawah ini untuk masuk ke grup WhatsApp resmi koordinasi wali murid baru untuk proses daftar ulang.
          </span>
        </span>
      </div>

      <!-- WhatsApp Link Button -->
      <a href="https://chat.whatsapp.com/ExampleLinkPMBMMIN3KRA" target="_blank" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px;">
        <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
          Masuk Ke Grup WhatsApp Terbaru
        </span>
      </a>

    @elseif(strval($pendaftaran->status) === 'Lulus')
      <!-- Status Lulus Seleksi (Belum Daftar Ulang) -->
      <div class="selamat-anda-telah-keterima" style="color: #047857;">SELAMAT ANDA LULUS SELEKSI</div>
      
      <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
        <span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Selamat! Anda dinyatakan LULUS seleksi penerimaan siswa baru MIN 3 Karanganyar. Harap segera melakukan proses
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span2">
            daftar ulang
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            secara langsung ke sekolah atau menghubungi panitia PMBM. Gabung ke grup koordinasi via tombol berikut.
          </span>
        </span>
      </div>

      <!-- WhatsApp Link Button -->
      <a href="https://chat.whatsapp.com/ExampleLinkPMBMMIN3KRA" target="_blank" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px;">
        <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
          Masuk Ke Grup WhatsApp Terbaru
        </span>
      </a>

    @elseif(strval($pendaftaran->status) === 'Cadangan')
      <!-- Status Cadangan Sementara (1 Minggu) -->
      <div class="selamat-anda-telah-keterima" style="color: #d97706;">STATUS: LULUS CADANGAN</div>
      
      <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
        <span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Anda dinyatakan sebagai calon siswa CADANGAN. Status ini bersifat sementara dengan durasi 1 minggu (hingga
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span2">
            {{ \Carbon\Carbon::parse($pendaftaran->updated_at)->addWeek()->translatedFormat('d F Y') }}
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            ). Jika tidak diubah ke status Lulus setelah tanggal tersebut, status akan berubah menjadi Tidak Lulus secara otomatis.
          </span>
        </span>
      </div>
      
      <a href="{{ route('landing.kontak') }}" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px; background: #d97706;">
        <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
          Hubungi Panitia PMBM
        </span>
      </a>

    @elseif(strval($pendaftaran->status) === 'Berkas Diterima')
      <!-- Status Berkas Online Diterima (Silakan Datang Ke Sekolah) -->
      <div class="selamat-anda-telah-keterima" style="color: #0d9488;">STATUS: BERKAS ONLINE DITERIMA</div>
      
      <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
        <span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Berkas pendaftaran online Anda dinyatakan Lolos Verifikasi Administrasi. Tahap berikutnya silakan datang ke sekolah untuk melakukan
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span2">
            pengumpulan berkas secara onsite
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            dan melakukan persiapan ujian tertulis serta wawancara.
          </span>
        </span>
      </div>
      
      <a href="{{ route('landing.guide') }}" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px; background: #0d9488;">
        <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
          Lihat Panduan &amp; Berkas Fisik
        </span>
      </a>

    @elseif(strval($pendaftaran->status) === 'Berkas Onsite Diterima')
      <!-- Status Berkas Onsite Diterima (Siap Ujian & Wawancara) -->
      <div class="selamat-anda-telah-keterima" style="color: #2563eb;">STATUS: BERKAS ONSITE DITERIMA</div>
      
      <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
        <span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Seluruh berkas fisik Anda telah kami terima secara onsite di sekolah. Anda dinyatakan
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span2">
            siap mengikuti seleksi
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            ujian tertulis dan wawancara. Jadwal pelaksanaan dapat dipantau melalui pengumuman resmi atau kontak panitia.
          </span>
        </span>
      </div>
      
      <a href="{{ route('landing.kontak') }}" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px; background: #2563eb;">
        <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
          Tanyakan Jadwal Ujian
        </span>
      </a>

    @elseif(strval($pendaftaran->status) === 'Berkas Ditolak')
      <!-- Status Berkas Online Ditolak (Ada yang salah, perlu diganti) -->
      <div class="selamat-anda-telah-keterima" style="color: #b91c1c;">STATUS: BERKAS ONLINE DITOLAK</div>
      
      <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
        <span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span" style="color: #b91c1c; font-weight: bold;">
            Alasan Penolakan: "{{ $pendaftaran->alasan_ditolak }}"
          </span>
          <br>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Harap segera ubah dan lengkapi/revisi data dan dokumen pendaftaran Anda sesuai catatan penolakan di atas.
          </span>
        </span>
      </div>
      
      <a href="{{ route('student.edit', $pendaftaran->id_pendaftaran) }}" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px; background: #ef4444;">
        <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
          Ubah Data Pendaftaran
        </span>
      </a>

    @php
      $contactPath = storage_path('app/landing_content.json');
      $contactJson = [];
      if (file_exists($contactPath)) {
          $contactJson = json_decode(file_get_contents($contactPath), true);
      }
      $waLink = isset($contactJson['phone']) ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $contactJson['phone']) : 'https://wa.me/6281226676554';
    @endphp

    @elseif(strval($pendaftaran->status) === 'Pindahkan ke Program Reguler')
      <!-- Status Rekomendasi Pindah Program Reguler -->
      <div class="selamat-anda-telah-keterima" style="color: #c2410c;">REKOMENDASI PINDAH PROGRAM REGULER</div>
      
      <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
        <span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Berdasarkan hasil pemeringkatan seleksi dan batas kuota program pilihan utama Anda, Anda direkomendasikan untuk
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span2">
            dipindahkan ke Program Reguler (Fullday)
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            di MIN 3 Karanganyar. Silakan klik tombol WhatsApp di bawah untuk koordinasi dengan Panitia PMBM.
          </span>
        </span>
      </div>
      
      <a href="{{ $waLink }}" target="_blank" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px; background: #c2410c;">
        <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
          Hubungi Panitia via WhatsApp
        </span>
      </a>

    @elseif(in_array(strval($pendaftaran->status), ['Tidak Lulus', 'Gagal', 'Tidak Keterima', 'Ditolak']))
      <!-- Status Tidak Lulus Seleksi -->
      <div class="selamat-anda-telah-keterima" style="color: #b91c1c;">MAAF, ANDA BELUM LULUS SELEKSI</div>
      
      <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
        <span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Mohon maaf, Anda dinyatakan belum lolos seleksi PMBM periode ini. Tetap semangat, jangan berkecil hati, dan silakan
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span2">
            hubungi kontak sekolah
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            jika ada pertanyaan seputar program pendaftaran lainnya.
          </span>
        </span>
      </div>
      
      <a href="{{ route('landing.kontak') }}" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px; background: #4b5563;">
        <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
          Hubungi Kontak Sekolah
        </span>
      </a>

    @elseif(strval($pendaftaran->status) === 'Mengundurkan Diri')
      <!-- Status Mengundurkan Diri -->
      <div class="selamat-anda-telah-keterima" style="color: #6b7280;">STATUS: MENGUNDURKAN DIRI</div>
      
      <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
        <span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Status pendaftaran Anda saat ini tercatat sebagai Mengundurkan Diri dari seleksi masuk MIN 3 Karanganyar.
          </span>
          <br>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Hubungi pihak panitia/sekolah jika ini merupakan sebuah kekeliruan data.
          </span>
        </span>
      </div>
      
      <a href="{{ route('landing.kontak') }}" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px; background: #6b7280;">
        <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
          Hubungi Kontak Sekolah
        </span>
      </a>

    @else
      <!-- Status Pending / Baru / Perubahan Data -->
      <div class="selamat-anda-telah-keterima" style="color: #d97706;">STATUS: DALAM PROSES VERIFIKASI</div>
      
      <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
        <span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Berkas pendaftaran Anda saat ini sedang berada dalam antrean proses pemeriksaan (Screening) oleh panitia PMBM.
          </span>
          <br>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Silakan lakukan pengecekan status di halaman pengumuman hasil kelulusan ini secara berkala.
          </span>
        </span>
      </div>
      
      <a href="{{ route('landing.kontak') }}" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px; background: #6b7280;">
        <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
          Tanyakan Status ke Admin
        </span>
      </a>
    @endif

    <!-- Footer Shared Component -->
    @include('components.footer', ['activeFolder' => 'hasil-kelulusan'])
  </div>
@endsection
