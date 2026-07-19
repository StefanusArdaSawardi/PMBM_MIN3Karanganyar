@extends('layouts.panitia')

@section('title', 'Hasil Nilai Ujian - Penguji PMBM')

@section('content')
  <div class="relative min-h-screen bg-slate-50/10 antialiased pb-12">
    <!-- Include Sidebar Kiri (activeFolder diset ke 'result' agar menu Hasil Nilai menyala hijau) -->
    @include('components.sidebar-panitia', ['activeFolder' => 'result'])

    <!-- Main Content Container -->
    <div class="relative pt-8 pb-12 pr-6 pl-[280px] max-[1024px]:pl-[240px] max-[1024px]:pr-6 flex flex-col gap-6 max-[768px]:pt-20 max-[768px]:px-4 w-full transition-all">
      
      <!-- Header Description -->
      <div class="flex flex-col gap-1.5 max-w-2xl">
        <h1 class="text-[#121c2a] text-2xl md:text-3xl font-bold tracking-tight font-sans">
          Hasil Penilaian Ujian
        </h1>
        <p class="text-slate-500 text-sm md:text-base leading-relaxed">
          Daftar calon siswa yang telah menyelesaikan seluruh tahapan instrumen uji hari ini. Data di bawah ini telah tersimpan permanen.
        </p>
      </div>

      <!-- Table Completed Data List -->
      <div class="bg-white rounded-2xl shadow-[0_4px_25px_rgba(0,0,0,0.02)] border border-slate-200/60 overflow-hidden mb-6 w-full">
        <div class="overflow-x-auto">
          <table class="w-full border-collapse text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
              <tr>
                <th scope="col" class="py-4 px-5 font-semibold">No. Reg</th>
                <th scope="col" class="py-4 px-5 font-semibold">Nama Calon Siswa</th>
                <th scope="col" class="py-4 px-5 font-semibold">NISN</th>
                <th scope="col" class="py-4 px-5 font-semibold text-center">Skor Hafalan</th>
                <th scope="col" class="py-4 px-5 font-semibold text-center">Skor Iqro</th>
                <th scope="col" class="py-4 px-5 font-semibold text-center">Skor Calistung</th>
                <th scope="col" class="py-4 px-5 font-semibold text-center">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
              @forelse($students as $student)
                <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                  <td class="py-4 px-5 font-medium text-slate-900">
                    PMB-2026-{{ substr($student->id_pendaftaran, 3) }}
                  </td>
                  <td class="py-4 px-5 font-semibold text-emerald-800">
                    {{ $student->calonMurid->nama_murid ?? '-' }}
                  </td>
                  <td class="py-4 px-5 text-slate-600">
                    {{ $student->calonMurid->nisn ?? '-' }}
                  </td>
                  <td class="py-4 px-5 text-center font-bold text-slate-900">
                    {{ $student->nilaiUjian->nilai_hafalan ?? '0' }}
                  </td>
                  <td class="py-4 px-5 text-center font-bold text-slate-900">
                    {{ $student->nilaiUjian->nilai_iqro ?? '0' }}
                  </td>
                  <td class="py-4 px-5 text-center font-bold text-slate-900">
                    {{ $student->nilaiUjian->nilai_calistung ?? '0' }}
                  </td>
                  <td class="py-4 px-5 text-center">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                      Selesai Dinilai
                    </span>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center text-slate-400 py-16 font-medium bg-white">
                    Belum ada siswa yang didefinisikan selesai uji hari ini.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>

    <!-- Footer Component Included -->
    @include('components.footer-panitia', ['isGrading' => false])
  </div>
@endsection