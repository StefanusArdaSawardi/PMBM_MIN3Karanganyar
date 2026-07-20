@extends('layouts.landing')

@section('title', 'Hasil Kelulusan PMBM - MIN 3 Karanganyar')

@section('content')
  <div class="relative bg-[#e5e2e1]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    @include('components.navbar', ['activeFolder' => 'hasil-kelulusan'])

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

    <section class="max-w-[700px] mx-auto px-6 -mt-10 mb-16 relative z-[2]">
      <div class="bg-white rounded-2xl shadow-[0px_4px_4px_0px_rgba(255,255,255,0.8),0px_10px_30px_rgba(0,0,0,0.1)] overflow-hidden">
        <div class="h-2 bg-[#0f7643]/90"></div>
        <div class="px-12 py-10 max-[600px]:px-6 max-[600px]:py-8 text-center">
          <div class="text-black font-bold tracking-[-0.4px] mb-4 text-[24px]" style="font-family: 'Roboto-Bold', sans-serif;">{{ strtoupper($student->nama_murid) }}</div>

          @if($pendaftaran->status_verifikasi === 'ditolak')
            <div class="font-bold tracking-[-0.4px] mb-3 text-[22px]" style="font-family: 'Roboto-Regular', sans-serif; color: #b91c1c;">STATUS: BERKAS ONLINE DITOLAK</div>
            <p class="text-black/55 text-[16px] leading-[1.6] mx-auto mb-6 max-w-[560px]" style="font-family: 'Roboto-Regular', sans-serif;">
              <strong class="text-black font-bold">Alasan Penolakan: "{{ $pendaftaran->alasan_penolakan }}"</strong><br>
              Harap segera ubah dan lengkapi/revisi data dan dokumen pendaftaran Anda sesuai catatan penolakan di atas.
            </p>
            <a href="{{ route('student.edit', $pendaftaran->id_pendaftaran) }}"
               class="inline-flex items-center justify-center min-w-[248px] h-[54px] px-6 rounded-[10px] text-[14px] font-bold text-white no-underline border border-black/20 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_6px_14px_rgba(0,0,0,0.15)]"
               style="font-family: 'PlusJakartaSans-Bold', sans-serif; background: #ef4444;">Ubah Data Pendaftaran</a>

          @elseif($pendaftaran->status_verifikasi === 'menunggu_verifikasi')
            <div class="font-bold tracking-[-0.4px] mb-3 text-[22px]" style="font-family: 'Roboto-Regular', sans-serif; color: #d97706;">STATUS: MENUNGGU VERIFIKASI BERKAS ONLINE</div>
            <p class="text-black/55 text-[16px] leading-[1.6] mx-auto mb-6 max-w-[560px]" style="font-family: 'Roboto-Regular', sans-serif;">
              Berkas pendaftaran online Anda saat ini sedang dalam antrean pemeriksaan oleh panitia PMBM.<br>
              Silakan lakukan pengecekan status pendaftaran Anda secara berkala di halaman ini.
            </p>
            <a href="{{ route('landing.kontak') }}"
               class="inline-flex items-center justify-center min-w-[248px] h-[54px] px-6 rounded-[10px] text-[14px] font-bold text-white no-underline border border-black/20 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_6px_14px_rgba(0,0,0,0.15)]"
               style="font-family: 'PlusJakartaSans-Bold', sans-serif; background: #6b7280;">Hubungi Kontak Sekolah</a>

          @elseif($pendaftaran->status_verifikasi === 'terverifikasi')
            <div class="font-bold tracking-[-0.4px] mb-3 text-[22px]" style="font-family: 'Roboto-Regular', sans-serif; color: #0d9488;">STATUS: BERKAS ONLINE TERVERIFIKASI</div>
            <p class="text-black/55 text-[16px] leading-[1.6] mx-auto mb-6 max-w-[560px]" style="font-family: 'Roboto-Regular', sans-serif;">
              Berkas pendaftaran online Anda dinyatakan Lolos Verifikasi Administrasi. Tahap berikutnya silakan datang ke sekolah untuk melakukan
              <span class="text-black font-bold">pengumpulan berkas secara onsite</span>
              dan melakukan persiapan ujian tertulis serta wawancara.
            </p>
            <a href="{{ route('landing.guide') }}"
               class="inline-flex items-center justify-center min-w-[248px] h-[54px] px-6 rounded-[10px] text-[14px] font-bold text-white no-underline border border-black/20 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_6px_14px_rgba(0,0,0,0.15)]"
               style="font-family: 'PlusJakartaSans-Bold', sans-serif; background: #0d9488;">Lihat Panduan &amp; Berkas Fisik</a>

          @elseif($pendaftaran->status_verifikasi === 'terverifikasi_onsite' && is_null($pendaftaran->status_kelulusan))
            <div class="font-bold tracking-[-0.4px] mb-3 text-[22px]" style="font-family: 'Roboto-Regular', sans-serif; color: #2563eb;">STATUS: BERKAS ONSITE TERVERIFIKASI</div>
            <p class="text-black/55 text-[16px] leading-[1.6] mx-auto mb-6 max-w-[560px]" style="font-family: 'Roboto-Regular', sans-serif;">
              Seluruh berkas fisik Anda telah kami terima secara onsite di sekolah. Anda dinyatakan
              <span class="text-black font-bold">siap mengikuti seleksi</span>
              ujian tertulis dan wawancara. Jadwal pelaksanaan dapat dipantau melalui pengumuman resmi atau kontak panitia.
            </p>
            <a href="{{ route('landing.kontak') }}"
               class="inline-flex items-center justify-center min-w-[248px] h-[54px] px-6 rounded-[10px] text-[14px] font-bold text-white no-underline border border-black/20 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_6px_14px_rgba(0,0,0,0.15)]"
               style="font-family: 'PlusJakartaSans-Bold', sans-serif; background: #2563eb;">Tanyakan Jadwal Ujian</a>

          @elseif($pendaftaran->status_kelulusan === 'lulus')
            @php
              $programName = $pendaftaran->program_kelulusan ?: ($pendaftaran->program->nama_program ?? '-');
            @endphp
            @if($pendaftaran->status_konfirmasi === 'terkonfirmasi')
              @php
                $waLinkDiterima = !empty($landingContent['whatsapp_group_diterima_link']) 
                  ? $landingContent['whatsapp_group_diterima_link'] 
                  : (!empty($landingContent['whatsapp_group_lulus_link']) ? $landingContent['whatsapp_group_lulus_link'] : ($landingContent['whatsapp_group_link'] ?? '#'));
              @endphp
              <div class="font-bold tracking-[-0.4px] mb-1 text-[22px]" style="font-family: 'Roboto-Regular', sans-serif; color: #047857;">SELAMAT ANDA TELAH DITERIMA &amp; DAFTAR ULANG</div>
              <div class="text-[#047857] font-bold text-[16px] mb-3" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Program: {{ $programName }}</div>
              <p class="text-black/55 text-[16px] leading-[1.6] mx-auto mb-6 max-w-[560px]" style="font-family: 'Roboto-Regular', sans-serif;">
                Selamat! Anda telah resmi dinyatakan diterima dan menyelesaikan proses daftar ulang di MIN 3 Karanganyar pada program <strong class="text-black font-bold">{{ $programName }}</strong>. Silakan
                <span class="text-black font-bold">klik tombol di bawah</span>
                untuk masuk ke grup WhatsApp resmi koordinasi wali murid baru.
              </p>
              <a href="{{ $waLinkDiterima }}" target="_blank"
                 class="inline-flex items-center justify-center min-w-[248px] h-[54px] px-6 rounded-[10px] text-[14px] font-bold text-white no-underline border border-black/20 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_6px_14px_rgba(0,0,0,0.15)]"
                 style="font-family: 'PlusJakartaSans-Bold', sans-serif; background: #47a26a;">Masuk Ke Grup WhatsApp Resmi</a>

            @elseif($pendaftaran->status_konfirmasi === 'mengundurkan_diri')
              <div class="font-bold tracking-[-0.4px] mb-3 text-[22px]" style="font-family: 'Roboto-Regular', sans-serif; color: #6b7280;">STATUS: MENGUNDURKAN DIRI</div>
              <p class="text-black/55 text-[16px] leading-[1.6] mx-auto mb-6 max-w-[560px]" style="font-family: 'Roboto-Regular', sans-serif;">
                Status pendaftaran Anda saat ini tercatat sebagai Mengundurkan Diri dari seleksi masuk MIN 3 Karanganyar.<br>
                Hubungi pihak panitia/sekolah jika ini merupakan sebuah kekeliruan data.
              </p>
              <a href="{{ route('landing.kontak') }}"
                 class="inline-flex items-center justify-center min-w-[248px] h-[54px] px-6 rounded-[10px] text-[14px] font-bold text-white no-underline border border-black/20 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_6px_14px_rgba(0,0,0,0.15)]"
                 style="font-family: 'PlusJakartaSans-Bold', sans-serif; background: #6b7280;">Hubungi Kontak Sekolah</a>

            @else
              @php
                $waLinkLulus = !empty($landingContent['whatsapp_group_lulus_link']) 
                  ? $landingContent['whatsapp_group_lulus_link'] 
                  : ($landingContent['whatsapp_group_link'] ?? '#');
              @endphp
              <div class="font-bold tracking-[-0.4px] mb-1 text-[22px]" style="font-family: 'Roboto-Regular', sans-serif; color: #047857;">SELAMAT ANDA LULUS SELEKSI</div>
              <div class="text-[#047857] font-bold text-[16px] mb-3" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">Program: {{ $programName }}</div>
              <p class="text-black/55 text-[16px] leading-[1.6] mx-auto mb-6 max-w-[560px]" style="font-family: 'Roboto-Regular', sans-serif;">
                Selamat! Anda dinyatakan LULUS seleksi penerimaan siswa baru MIN 3 Karanganyar pada program <strong class="text-black font-bold">{{ $programName }}</strong>. Harap segera melakukan proses
                <span class="text-black font-bold">daftar ulang secara onsite</span>
                ke sekolah.
              </p>

              <div class="mt-5">
                <a href="{{ $waLinkLulus }}" target="_blank"
                   class="inline-flex items-center justify-center min-w-[248px] h-[54px] px-6 rounded-[10px] text-[14px] font-bold text-white no-underline border border-black/20 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_6px_14px_rgba(0,0,0,0.15)]"
                   style="font-family: 'PlusJakartaSans-Bold', sans-serif; background: #47a26a;">Masuk Ke Grup WhatsApp Terbaru</a>
              </div>
            @endif

          @elseif($pendaftaran->status_kelulusan === 'cadangan')
            <div class="font-bold tracking-[-0.4px] mb-3 text-[22px]" style="font-family: 'Roboto-Regular', sans-serif; color: #d97706;">STATUS: LULUS CADANGAN</div>
            <p class="text-black/55 text-[16px] leading-[1.6] mx-auto mb-6 max-w-[560px]" style="font-family: 'Roboto-Regular', sans-serif;">
              Anda dinyatakan sebagai calon siswa CADANGAN.<br>
              Status Anda dapat naik menjadi Lulus apabila terdapat calon siswa utama yang mengundurkan diri atau tidak mendaftar ulang hingga batas waktu konfirmasi onsite yang telah ditentukan.
            </p>
            <a href="{{ route('landing.kontak') }}"
               class="inline-flex items-center justify-center min-w-[248px] h-[54px] px-6 rounded-[10px] text-[14px] font-bold text-white no-underline border border-black/20 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_6px_14px_rgba(0,0,0,0.15)]"
               style="font-family: 'PlusJakartaSans-Bold', sans-serif; background: #d97706;">Hubungi Panitia PMBM</a>

          @elseif($pendaftaran->status_kelulusan === 'tidak_lulus')
            <div class="font-bold tracking-[-0.4px] mb-3 text-[22px]" style="font-family: 'Roboto-Regular', sans-serif; color: #b91c1c;">MAAF, ANDA BELUM LULUS SELEKSI</div>
            <p class="text-black/55 text-[16px] leading-[1.6] mx-auto mb-6 max-w-[560px]" style="font-family: 'Roboto-Regular', sans-serif;">
              Mohon maaf, Anda dinyatakan belum lolos seleksi PMBM periode ini. Tetap semangat, jangan berkecil hati, dan silakan
              <span class="text-black font-bold">hubungi kontak sekolah</span>
              jika ada pertanyaan seputar program pendaftaran lainnya.
            </p>
            <a href="{{ route('landing.kontak') }}"
               class="inline-flex items-center justify-center min-w-[248px] h-[54px] px-6 rounded-[10px] text-[14px] font-bold text-white no-underline border border-black/20 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_6px_14px_rgba(0,0,0,0.15)]"
               style="font-family: 'PlusJakartaSans-Bold', sans-serif; background: #4b5563;">Hubungi Kontak Sekolah</a>

          @else
            <div class="font-bold tracking-[-0.4px] mb-3 text-[22px]" style="font-family: 'Roboto-Regular', sans-serif; color: #d97706;">PENGUMUMAN BELUM DIBUKA</div>
            <p class="text-black/55 text-[16px] leading-[1.6] mx-auto mb-6 max-w-[560px]" style="font-family: 'Roboto-Regular', sans-serif;">
              Hasil seleksi PMBM untuk calon siswa baru masih diproses oleh tim panitia penerimaan siswa baru.<br>
              Silakan lakukan pengecekan secara berkala di halaman ini sesuai tanggal pengumuman resmi.
            </p>
            <a href="{{ route('landing.kontak') }}"
               class="inline-flex items-center justify-center min-w-[248px] h-[54px] px-6 rounded-[10px] text-[14px] font-bold text-white no-underline border border-black/20 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_6px_14px_rgba(0,0,0,0.15)]"
               style="font-family: 'PlusJakartaSans-Bold', sans-serif; background: #6b7280;">Hubungi Kontak Sekolah</a>
          @endif
        </div>
      </div>
    </section>

    @include('components.footer', ['activeFolder' => 'hasil-kelulusan'])
  </div>
@endsection
