@extends('layouts.landing')

@section('title', 'Hasil Kelulusan PMBM - MIN 3 Karanganyar')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/landing/hasil-kelulusan/style.css') }}">
@endsection

@section('content')
  <div class="hasil-kelulusan-page">
    @include('components.navbar', ['activeFolder' => 'hasil-kelulusan'])

    <section class="hasil-hero-section">
      <div class="hasil-hero-bg">
        <img src="{{ asset('assets/landing/home/hero-bg.jpg') }}" alt="MIN 3 Karanganyar">
      </div>
      <div class="hasil-hero-content">
        <h1 class="hasil-hero-title">Cek Status Kelulusan</h1>
        <p class="hasil-hero-subtitle">Halaman resmi pengumuman hasil seleksi penerimaan peserta didik baru PMBM MIN 3 Karanganyar.</p>
      </div>
    </section>

    <section class="hasil-card-section">
      <div class="hasil-card">
        <div class="hasil-card-accent"></div>
        <div class="hasil-card-body">
          <div class="hasil-student-name">{{ strtoupper($student->nama_murid) }}</div>

          @if($pendaftaran->status_verifikasi === 'ditolak')
            <div class="hasil-status-label" style="color: #b91c1c;">STATUS: BERKAS ONLINE DITOLAK</div>
            <p class="hasil-message">
              <strong>Alasan Penolakan: "{{ $pendaftaran->alasan_penolakan }}"</strong><br>
              Harap segera ubah dan lengkapi/revisi data dan dokumen pendaftaran Anda sesuai catatan penolakan di atas.
            </p>
            <a href="{{ route('student.edit', $pendaftaran->id_pendaftaran) }}" class="hasil-action-btn" style="background: #ef4444;">Ubah Data Pendaftaran</a>

          @elseif($pendaftaran->status_verifikasi === 'menunggu_verifikasi')
            <div class="hasil-status-label" style="color: #d97706;">STATUS: MENUNGGU VERIFIKASI BERKAS ONLINE</div>
            <p class="hasil-message">
              Berkas pendaftaran online Anda saat ini sedang dalam antrean pemeriksaan oleh panitia PMBM.<br>
              Silakan lakukan pengecekan status pendaftaran Anda secara berkala di halaman ini.
            </p>
            <a href="{{ route('landing.kontak') }}" class="hasil-action-btn" style="background: #6b7280;">Hubungi Kontak Sekolah</a>

          @elseif($pendaftaran->status_verifikasi === 'terverifikasi')
            <div class="hasil-status-label" style="color: #0d9488;">STATUS: BERKAS ONLINE TERVERIFIKASI</div>
            <p class="hasil-message">
              Berkas pendaftaran online Anda dinyatakan Lolos Verifikasi Administrasi. Tahap berikutnya silakan datang ke sekolah untuk melakukan
              <span class="hasil-emphasis">pengumpulan berkas secara onsite</span>
              dan melakukan persiapan ujian tertulis serta wawancara.
            </p>
            <a href="{{ route('landing.guide') }}" class="hasil-action-btn" style="background: #0d9488;">Lihat Panduan &amp; Berkas Fisik</a>

          @elseif($pendaftaran->status_verifikasi === 'terverifikasi_onsite' && is_null($pendaftaran->status_kelulusan))
            <div class="hasil-status-label" style="color: #2563eb;">STATUS: BERKAS ONSITE TERVERIFIKASI</div>
            <p class="hasil-message">
              Seluruh berkas fisik Anda telah kami terima secara onsite di sekolah. Anda dinyatakan
              <span class="hasil-emphasis">siap mengikuti seleksi</span>
              ujian tertulis dan wawancara. Jadwal pelaksanaan dapat dipantau melalui pengumuman resmi atau kontak panitia.
            </p>
            <a href="{{ route('landing.kontak') }}" class="hasil-action-btn" style="background: #2563eb;">Tanyakan Jadwal Ujian</a>

          @elseif($pendaftaran->status_kelulusan === 'lulus')
            @if($pendaftaran->status_konfirmasi === 'terkonfirmasi')
              <div class="hasil-status-label" style="color: #047857;">SELAMAT ANDA TELAH DITERIMA &amp; DAFTAR ULANG</div>
              <p class="hasil-message">
                Selamat! Anda telah resmi dinyatakan diterima dan menyelesaikan proses daftar ulang di MIN 3 Karanganyar. Silakan
                <span class="hasil-emphasis">klik tombol di bawah</span>
                untuk masuk ke grup WhatsApp resmi koordinasi wali murid baru.
              </p>
              <a href="https://chat.whatsapp.com/ExampleLinkPMBMMIN3KRA" target="_blank" class="hasil-action-btn" style="background: #47a26a;">Masuk Ke Grup WhatsApp Resmi</a>

            @elseif($pendaftaran->status_konfirmasi === 'mengundurkan_diri')
              <div class="hasil-status-label" style="color: #6b7280;">STATUS: MENGUNDURKAN DIRI</div>
              <p class="hasil-message">
                Status pendaftaran Anda saat ini tercatat sebagai Mengundurkan Diri dari seleksi masuk MIN 3 Karanganyar.<br>
                Hubungi pihak panitia/sekolah jika ini merupakan sebuah kekeliruan data.
              </p>
              <a href="{{ route('landing.kontak') }}" class="hasil-action-btn" style="background: #6b7280;">Hubungi Kontak Sekolah</a>

            @else
              <div class="hasil-status-label" style="color: #047857;">SELAMAT ANDA LULUS SELEKSI</div>
              <p class="hasil-message">
                Selamat! Anda dinyatakan LULUS seleksi penerimaan siswa baru MIN 3 Karanganyar. Harap segera melakukan proses
                <span class="hasil-emphasis">daftar ulang secara onsite</span>
                ke sekolah sebelum batas waktu habis.
              </p>

              @php
                $kelulusanTime = $pendaftaran->tanggal_kelulusan ? \Carbon\Carbon::parse($pendaftaran->tanggal_kelulusan) : \Carbon\Carbon::parse($pendaftaran->updated_at);
                $deadline = $kelulusanTime->addDays(7);
                $now = \Carbon\Carbon::now();
                $diffInSeconds = (int) $now->diffInSeconds($deadline, false);
              @endphp

              @if($diffInSeconds > 0)
                <div id="countdown-timer" class="hasil-countdown">
                  ⏳ SISA WAKTU KONFIRMASI DAFTAR ULANG ONSITE: <span id="timer-display" class="hasil-countdown-value">--:--:--</span>
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
                <div class="hasil-countdown">⚠️ Batas waktu konfirmasi daftar ulang onsite telah habis. Status Anda dianggap Mengundurkan Diri.</div>
              @endif

              <div style="margin-top: 20px;">
                <a href="https://chat.whatsapp.com/ExampleLinkPMBMMIN3KRA" target="_blank" class="hasil-action-btn" style="background: #47a26a;">Masuk Ke Grup WhatsApp Terbaru</a>
              </div>
            @endif

          @elseif($pendaftaran->status_kelulusan === 'cadangan')
            <div class="hasil-status-label" style="color: #d97706;">STATUS: LULUS CADANGAN</div>
            <p class="hasil-message">
              Anda dinyatakan sebagai calon siswa CADANGAN dengan peringkat antrean:
              <span class="hasil-emphasis">Peringkat Cadangan Ke-{{ $pendaftaran->peringkat_cadangan ?? 1 }}</span><br>
              Peringkat Anda dapat naik menjadi Lulus apabila terdapat calon siswa utama yang mengundurkan diri atau tidak mendaftar ulang hingga batas waktu konfirmasi onsite yang telah ditentukan.
            </p>
            <a href="{{ route('landing.kontak') }}" class="hasil-action-btn" style="background: #d97706;">Hubungi Panitia PMBM</a>

          @elseif($pendaftaran->status_kelulusan === 'tidak_lulus')
            <div class="hasil-status-label" style="color: #b91c1c;">MAAF, ANDA BELUM LULUS SELEKSI</div>
            <p class="hasil-message">
              Mohon maaf, Anda dinyatakan belum lolos seleksi PMBM periode ini. Tetap semangat, jangan berkecil hati, dan silakan
              <span class="hasil-emphasis">hubungi kontak sekolah</span>
              jika ada pertanyaan seputar program pendaftaran lainnya.
            </p>
            <a href="{{ route('landing.kontak') }}" class="hasil-action-btn" style="background: #4b5563;">Hubungi Kontak Sekolah</a>

          @else
            <div class="hasil-status-label" style="color: #d97706;">PENGUMUMAN BELUM DIBUKA</div>
            <p class="hasil-message">
              Hasil seleksi PMBM untuk calon siswa baru masih diproses oleh tim panitia penerimaan siswa baru.<br>
              Silakan lakukan pengecekan secara berkala di halaman ini sesuai tanggal pengumuman resmi.
            </p>
            <a href="{{ route('landing.kontak') }}" class="hasil-action-btn" style="background: #6b7280;">Hubungi Kontak Sekolah</a>
          @endif
        </div>
      </div>
    </section>

    @include('components.footer', ['activeFolder' => 'hasil-kelulusan'])
  </div>
@endsection
