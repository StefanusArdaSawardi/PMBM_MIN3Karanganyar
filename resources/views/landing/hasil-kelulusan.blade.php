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

    @if($pendaftaran->status_verifikasi === 'ditolak')
      <!-- Status Berkas Online Ditolak (Ada yang salah, perlu diganti) -->
      <div class="selamat-anda-telah-keterima" style="color: #b91c1c;">STATUS: BERKAS ONLINE DITOLAK</div>
      
      <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
        <span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span" style="color: #b91c1c; font-weight: bold;">
            Alasan Penolakan: "{{ $pendaftaran->alasan_penolakan }}"
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

    @elseif($pendaftaran->status_verifikasi === 'menunggu_verifikasi')
      <!-- Status Pending / Baru / Perubahan Data -->
      <div class="selamat-anda-telah-keterima" style="color: #d97706;">STATUS: MENUNGGU VERIFIKASI BERKAS ONLINE</div>
      
      <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
        <span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Berkas pendaftaran online Anda saat ini sedang dalam antrean pemeriksaan oleh panitia PMBM.
          </span>
          <br>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Silakan lakukan pengecekan status pendaftaran Anda secara berkala di halaman ini.
          </span>
        </span>
      </div>
      
      <a href="{{ route('landing.kontak') }}" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px; background: #6b7280;">
        <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
          Hubungi Kontak Sekolah
        </span>
      </a>

    @elseif($pendaftaran->status_verifikasi === 'terverifikasi')
      <!-- Status Berkas Online Diterima (Silakan Datang Ke Sekolah) -->
      <div class="selamat-anda-telah-keterima" style="color: #0d9488;">STATUS: BERKAS ONLINE TERVERIFIKASI</div>
      
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

    @elseif($pendaftaran->status_verifikasi === 'terverifikasi_onsite' && is_null($pendaftaran->status_kelulusan))
      <!-- Status Berkas Onsite Diterima (Siap Ujian & Wawancara, Menunggu Kelulusan) -->
      <div class="selamat-anda-telah-keterima" style="color: #2563eb;">STATUS: BERKAS ONSITE TERVERIFIKASI</div>
      
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

    @elseif($pendaftaran->status_kelulusan === 'lulus')
      @if($pendaftaran->status_konfirmasi === 'terkonfirmasi')
        <!-- Status Diterima (Sudah Daftar Ulang) -->
        <div class="selamat-anda-telah-keterima" style="color: #047857;">SELAMAT ANDA TELAH DITERIMA &amp; DAFTAR ULANG</div>
        
        <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
          <span>
            <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
              Selamat! Anda telah resmi dinyatakan diterima dan menyelesaikan proses daftar ulang di MIN 3 Karanganyar. Silakan
            </span>
            <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span2">
              klik tombol di bawah
            </span>
            <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
              untuk masuk ke grup WhatsApp resmi koordinasi wali murid baru.
            </span>
          </span>
        </div>

        <!-- WhatsApp Link Button -->
        <a href="https://chat.whatsapp.com/ExampleLinkPMBMMIN3KRA" target="_blank" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px;">
          <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
            Masuk Ke Grup WhatsApp Resmi
          </span>
        </a>
      @elseif($pendaftaran->status_konfirmasi === 'mengundurkan_diri')
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
        <!-- Status Lulus Seleksi (Belum Daftar Ulang) -->
        <div class="selamat-anda-telah-keterima" style="color: #047857;">SELAMAT ANDA LULUS SELEKSI</div>
        
        <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
          <span>
            <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
              Selamat! Anda dinyatakan LULUS seleksi penerimaan siswa baru MIN 3 Karanganyar. Harap segera melakukan proses
            </span>
            <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span2">
              daftar ulang secara onsite
            </span>
            <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
              ke sekolah sebelum batas waktu habis.
            </span>
          </span>
          
          @php
            $kelulusanTime = $pendaftaran->tanggal_kelulusan ? \Carbon\Carbon::parse($pendaftaran->tanggal_kelulusan) : \Carbon\Carbon::parse($pendaftaran->updated_at);
            $deadline = $kelulusanTime->addDays(7);
            $now = \Carbon\Carbon::now();
            $diffInSeconds = $now->diffInSeconds($deadline, false);
          @endphp

          @if($diffInSeconds > 0)
            <div id="countdown-timer" style="margin-top: 15px; font-weight: bold; color: #ef4444; font-size: 14px; background: #fff5f5; border: 1px solid #fee2e2; padding: 10px; border-radius: 8px;">
              ⏳ SISA WAKTU KONFIRMASI DAFTAR ULANG ONSITE: <span id="timer-display" style="font-family: monospace; font-size: 15px;">--:--:--</span>
            </div>
            <script>
              (function() {
                  let diff = {{ $diffInSeconds }};
                  function updateDisplay() {
                      if (diff <= 0) {
                          document.getElementById('timer-display').innerText = "Waktu Habis (Dianggap Mengundurkan Diri)";
                          return;
                      }
                      let days = Math.floor(diff / (3600 * 24));
                      let hours = Math.floor((diff % (3600 * 24)) / 3600);
                      let minutes = Math.floor((diff % 3600) / 60);
                      let seconds = diff % 60;
                      
                      let text = "";
                      if (days > 0) text += days + " hari ";
                      text += String(hours).padStart(2, '0') + ":" + String(minutes).padStart(2, '0') + ":" + String(seconds).padStart(2, '0');
                      document.getElementById('timer-display').innerText = text;
                      diff--;
                      setTimeout(updateDisplay, 1000);
                  }
                  updateDisplay();
              })();
            </script>
          @else
            <div style="margin-top: 15px; font-weight: bold; color: #ef4444; font-size: 14px; background: #fff5f5; border: 1px solid #fee2e2; padding: 10px; border-radius: 8px;">
              ⚠️ Batas waktu konfirmasi daftar ulang onsite telah habis. Status Anda dianggap Mengundurkan Diri.
            </div>
          @endif
        </div>

        <!-- WhatsApp Link Button -->
        <a href="https://chat.whatsapp.com/ExampleLinkPMBMMIN3KRA" target="_blank" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px;">
          <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
            Masuk Ke Grup WhatsApp Terbaru
          </span>
        </a>
      @endif

    @elseif($pendaftaran->status_kelulusan === 'cadangan')
      <!-- Status Cadangan Sementara (1 Minggu) -->
      <div class="selamat-anda-telah-keterima" style="color: #d97706;">STATUS: LULUS CADANGAN</div>
      
      <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
        <span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Anda dinyatakan sebagai calon siswa CADANGAN dengan peringkat antrean:
          </span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span2">
            Peringkat Cadangan Ke-{{ $pendaftaran->peringkat_cadangan ?? 1 }}
          </span>
          <br>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Peringkat Anda dapat naik menjadi Lulus apabila terdapat calon siswa utama yang mengundurkan diri atau tidak mendaftar ulang hingga batas waktu konfirmasi onsite yang telah ditentukan.
          </span>
        </span>
      </div>
      
      <a href="{{ route('landing.kontak') }}" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px; background: #d97706;">
        <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
          Hubungi Panitia PMBM
        </span>
      </a>

    @elseif($pendaftaran->status_kelulusan === 'tidak_lulus')
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

    @else
      <!-- Status Default / Belum Diumumkan -->
      <div class="selamat-anda-telah-keterima" style="color: #d97706;">PENGUMUMAN BELUM DIBUKA</div>
      
      <div class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app">
        <span>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Hasil seleksi PMBM untuk calon siswa baru masih diproses oleh tim panitia penerimaan siswa baru.
          </span>
          <br>
          <span class="untuk-informasi-pendaftaran-ulang-dan-berkas-fisik-lebih-lanjut-silahkan-klik-link-di-bawah-ini-untuk-bergabung-ke-dalam-grup-what-s-app-span">
            Silakan lakukan pengecekan secara berkala di halaman ini sesuai tanggal pengumuman resmi.
          </span>
        </span>
      </div>
      
      <a href="{{ route('landing.kontak') }}" class="rectangle-21" style="display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 6px; background: #6b7280;">
        <span class="masuk-ke-grup-whats-app-terbaru" style="position: static; font-size: 14px; font-weight: bold; color: #ffffff;">
          Hubungi Kontak Sekolah
        </span>
      </a>
    @endif

    <!-- Footer Shared Component -->
    @include('components.footer', ['activeFolder' => 'hasil-kelulusan'])
  </div>
@endsection
