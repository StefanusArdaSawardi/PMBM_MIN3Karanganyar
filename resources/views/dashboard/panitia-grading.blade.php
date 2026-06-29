@extends('layouts.panitia')

@section('title', 'Instrumen Penilaian - Penguji PMBM')

@section('content')
  <div class="relative min-h-screen bg-white flow-root">
    <!-- Panitia Sidebar/Topbar Included -->
    @include('components.sidebar-panitia', ['activeFolder' => 'grading'])

    <div class="relative mt-[156px] mx-[146px] flex flex-col gap-6 pb-10 max-[1024px]:mx-6 max-[1024px]:mt-[140px]">
      <!-- Student Identity Header -->
      <div class="bg-white border-l-4 border-[#005b31] rounded-xl shadow-[0_1px_1px_rgba(0,0,0,0.05)] pl-7 pr-6 py-6 flex flex-col gap-4 max-w-[640px] max-[640px]:max-w-none">
        <div class="flex flex-col gap-1.5">
          <div class="text-[#6f7a70] text-[12px] font-medium tracking-[0.6px] uppercase" style="font-family: 'WorkSans-Medium', sans-serif;">SEDANG DIUJI:</div>
          <div class="text-[#121c2a] text-[24px] font-bold" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">{{ $student->nama_murid }}</div>
          <div class="flex items-center gap-3 flex-wrap">
            <div class="text-[#3f4940] text-[14px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">
              <span class="font-semibold">No. Daftar:</span>
              <span style="font-family: 'WorkSans-Regular', sans-serif;"> PMB-2026-{{ str_pad($student->id_murid, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="bg-[#6bff8f]/20 border border-[#006e2f]/20 rounded-full px-3 py-1">
              <div class="text-[#006e2f] text-[12px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">{{ $student->pendaftaran->program->nama_program ?? 'Umum' }}</div>
            </div>
          </div>
        </div>
        <div class="bg-[#e6eeff] border border-[#becabe] rounded-lg flex items-center gap-2 p-3 self-start">
          <img class="w-[22px] h-[19px]" src="{{ asset('assets/panitia/grading/container6.svg') }}" alt="">
          <div class="text-[#007432] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">Sesi Wawancara &amp; Ujian</div>
        </div>
      </div>

      <!-- Progress Tracker -->
      <div class="flex items-center justify-center gap-4 max-[640px]:gap-3">
        <div class="flex flex-col items-center">
          <div class="bg-[#005b31] rounded-full w-8 h-8 flex items-center justify-center text-white text-[12px] font-bold">1</div>
          <div class="text-[#005b31] text-[12px] mt-1" style="font-family: 'WorkSans-Regular', sans-serif;">Identitas</div>
        </div>
        <div class="bg-[#005b31] h-px w-12 max-[640px]:w-6"></div>
        <div class="flex flex-col items-center">
          <div class="bg-[#0f7643] rounded-full w-8 h-8 flex items-center justify-center text-white text-[12px] font-bold">2</div>
          <div class="text-[#0f7643] text-[12px] mt-1" style="font-family: 'WorkSans-Regular', sans-serif;">Penilaian</div>
        </div>
        <div class="bg-[#becabe] h-px w-12 max-[640px]:w-6"></div>
        <div class="flex flex-col items-center">
          <div class="border-2 border-[#becabe] rounded-full w-8 h-8 flex items-center justify-center text-[#becabe] text-[12px] font-bold">3</div>
          <div class="text-[#becabe] text-[12px] mt-1" style="font-family: 'WorkSans-Regular', sans-serif;">Selesai</div>
        </div>
      </div>

      <!-- Main Scoring Form -->
      <form action="{{ route('panitia.grading', $student->id_murid) }}" method="POST" class="bg-white border border-[#becabe] rounded-xl shadow-[0_1px_2px_rgba(0,0,0,0.05)] overflow-hidden max-w-[800px] w-full mx-auto">
        @csrf

        <!-- Messages Flash -->
        @if(session('success_grading'))
          <div class="m-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-[13px] rounded-lg">
            {{ session('success_grading') }}
          </div>
        @endif

        @if($errors->any())
          <div class="m-4 p-3 bg-red-100 border border-red-300 text-red-700 text-[13px] rounded-lg">
            {{ $errors->first() }}
          </div>
        @endif

        <!-- Header -->
        <div class="bg-[#eff4ff] border-b border-[#becabe] px-6 py-6 flex items-center gap-3">
          <div class="text-[20px]">📝</div>
          <div class="text-[#121c2a] text-[20px] font-semibold" style="font-family: 'PlusJakartaSans-SemiBold', sans-serif;">Instrumen Penilaian Calon Siswa</div>
        </div>

        <div class="p-6 flex flex-col gap-6">
          <!-- 1. Nilai Hafalan -->
          <div class="flex flex-col gap-1">
            <label for="nilai_hafalan" class="text-[#121c2a] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">1. Nilai Hafalan (1 - 100)</label>
            <input type="number" name="nilai_hafalan" id="nilai_hafalan" required min="1" max="100"
                   value="{{ $student->hasil->nilai_hafalan ?? '' }}" placeholder="Masukkan nilai hafalan (1 - 100)"
                   class="w-full px-[17px] py-3 text-[14px] text-gray-800 border border-[#becabe] rounded-lg bg-[#f8f9ff] outline-none focus:border-[#298752]">
          </div>

          <!-- 2. Nilai Wawancara -->
          <div class="flex flex-col gap-1">
            <label for="nilai_wawancara" class="text-[#121c2a] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">2. Nilai Wawancara (1 - 100)</label>
            <input type="number" name="nilai_wawancara" id="nilai_wawancara" required min="1" max="100"
                   value="{{ $student->hasil->nilai_wawancara ?? '' }}" placeholder="Masukkan nilai wawancara (1 - 100)"
                   class="w-full px-[17px] py-3 text-[14px] text-gray-800 border border-[#becabe] rounded-lg bg-[#f8f9ff] outline-none focus:border-[#298752]">
          </div>

          <!-- 3. Nilai Calistung -->
          <div class="flex flex-col gap-1">
            <label for="nilai_calistung" class="text-[#121c2a] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">3. Nilai Calistung (1 - 100)</label>
            <input type="number" name="nilai_calistung" id="nilai_calistung" required min="1" max="100"
                   value="{{ $student->hasil->nilai_calistung ?? '' }}" placeholder="Masukkan nilai calistung (1 - 100)"
                   class="w-full px-[17px] py-3 text-[14px] text-gray-800 border border-[#becabe] rounded-lg bg-[#f8f9ff] outline-none focus:border-[#298752]">
          </div>

          <!-- 4. Nilai Tasmi -->
          <div class="flex flex-col gap-1">
            <label for="nilai_tasmi" class="text-[#121c2a] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">4. Nilai Tasmi (1 - 100)</label>
            <input type="number" name="nilai_tasmi" id="nilai_tasmi" required min="1" max="100"
                   value="{{ $student->hasil->nilai_tasmi ?? '' }}" placeholder="Masukkan nilai tasmi (1 - 100)"
                   class="w-full px-[17px] py-3 text-[14px] text-gray-800 border border-[#becabe] rounded-lg bg-[#f8f9ff] outline-none focus:border-[#298752]">
          </div>

          <!-- 5. Nilai Mandiri -->
          <div class="flex flex-col gap-1">
            <label for="nilai_mandiri" class="text-[#121c2a] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">5. Nilai Mandiri (1 - 100)</label>
            <input type="number" name="nilai_mandiri" id="nilai_mandiri" required min="1" max="100"
                   value="{{ $student->hasil->nilai_mandiri ?? '' }}" placeholder="Masukkan nilai mandiri (1 - 100)"
                   class="w-full px-[17px] py-3 text-[14px] text-gray-800 border border-[#becabe] rounded-lg bg-[#f8f9ff] outline-none focus:border-[#298752]">
          </div>

          <!-- 6. Jalur Prestasi -->
          <div class="border border-[#becabe] rounded-lg p-[17px] flex items-center gap-3">
            <input type="checkbox" id="prestasi_check"
                   class="w-5 h-5 cursor-pointer rounded border border-gray-300"
                   {{ $student->id_kejuaraan ? 'checked' : '' }} disabled>
            <label for="prestasi_check" class="flex items-center gap-2 text-[#3f4940] text-[14px] font-medium cursor-pointer" style="font-family: 'WorkSans-Medium', sans-serif;">
              <span class="text-[20px]">🏆</span> Calon Murid Memiliki Prestasi Terverifikasi
            </label>
          </div>

          <!-- 7. Rating Dukungan Orang Tua -->
          <div class="flex flex-col gap-1">
            <label for="rating_ortu" class="text-[#121c2a] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">6. Rating Dukungan Orang Tua (Skala 1 - 10)</label>
            <input type="number" name="rating_ortu" id="rating_ortu" min="1" max="10"
                   value="{{ $student->hasil->rating_ortu ?? '8' }}" placeholder="Rating angka 1 s/d 10"
                   class="w-full px-[17px] py-3 text-[14px] text-gray-800 border border-[#becabe] rounded-lg bg-[#f8f9ff] outline-none focus:border-[#298752]">
            <div class="text-[#6f7a70] text-[12px] italic" style="font-family: 'WorkSans-Regular', sans-serif;">* 10 (Sangat Mendukung), 1 (Tidak Mendukung)</div>
          </div>

          <!-- 8. Catatan Penguji -->
          <div class="flex flex-col gap-1">
            <label for="catatan" class="text-[#121c2a] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">7. Catatan &amp; Rekomendasi Penguji</label>
            <textarea name="catatan" id="catatan" rows="4" placeholder="Tuliskan catatan khusus atau rekomendasi hasil wawancara di sini..."
                      class="w-full px-[17px] py-3 text-[14px] text-gray-800 border border-[#becabe] rounded-lg bg-[#f8f9ff] outline-none focus:border-[#298752] resize-none">{{ $student->hasil->catatan_manual ?? '' }}</textarea>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-[#eff4ff] border-t border-[#becabe] px-6 py-6 flex items-center justify-end gap-4 max-[480px]:flex-col max-[480px]:items-stretch">
          <a href="{{ route('panitia.dashboard') }}" class="border border-[#6f7a70] rounded-lg px-10 py-3 text-[#3f4940] text-[16px] font-bold text-center no-underline" style="font-family: 'WorkSans-SemiBold', sans-serif;">
            Batal
          </a>
          <button type="submit" class="bg-[#005b31] rounded-lg px-10 py-3 flex items-center justify-center gap-2 shadow-[0_4px_6px_-1px_rgba(0,0,0,0.1),0_2px_4px_-2px_rgba(0,0,0,0.1)] cursor-pointer">
            <img class="w-[18px] h-[18px]" src="{{ asset('assets/panitia/grading/container34.svg') }}" alt="">
            <span class="text-white text-[16px] font-bold" style="font-family: 'WorkSans-SemiBold', sans-serif;">Simpan Nilai &amp; Selesai</span>
          </button>
        </div>
      </form>
    </div>

    <!-- Footer Component Included -->
    @include('components.footer-panitia', ['isGrading' => true])
  </div>
@endsection
