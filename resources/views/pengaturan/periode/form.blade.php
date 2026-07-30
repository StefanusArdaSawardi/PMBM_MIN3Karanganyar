@extends('layouts.admin')

@section('title', ($periode ? 'Edit' : 'Tambah') . ' Periode Pendaftaran - Admin Portal')

@section('content')
  <div class="relative min-h-screen flow-root">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'periode'])

    <!-- Content Wrapper -->
    <div class="absolute left-[380px] top-[138px] right-10 flex flex-col gap-6 z-0 max-[1024px]:left-5 max-[1024px]:right-5 max-[1024px]:top-[150px]">

      <div class="bg-white border border-[#bec9be] rounded-xl p-8 max-w-[1045px]">
        <a href="{{ route('tata_usaha.periode.index') }}" class="flex items-center gap-2 text-[#3f4941] text-[15px] no-underline mb-4 w-fit">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m0 0l6 6m-6-6l6-6"/></svg>
          Kembali
        </a>

        <div class="text-[#181c1c] text-[28px] font-bold tracking-[-0.56px] mb-6" style="font-family: 'Manrope-Bold', sans-serif;">{{ $periode ? 'Edit' : 'Tambah' }} Periode Pendaftaran</div>

        <form action="{{ $periode ? route('tata_usaha.periode.update', $periode->id) : route('tata_usaha.periode.store') }}" method="POST" class="flex flex-col gap-5">
          @csrf

          <div class="flex flex-col gap-2">
            <label class="text-[#3f4941] text-[12px] font-bold">Tahun</label>
            <select name="tahun" required class="bg-[#f1f4f3] border border-[#bec9be] rounded px-4 py-4 text-[14px] text-[#181c1c] outline-none">
              <option value="">Pilih Salah Satu</option>
              @foreach([now()->year + 1, now()->year, now()->year - 1] as $year)
                <option value="{{ $year }}" {{ old('tahun', $periode->tahun ?? '') == $year ? 'selected' : '' }}>{{ $year }}</option>
              @endforeach
            </select>
            @error('tahun') <span class="text-red-600 text-[12px]">{{ $message }}</span> @enderror
          </div>

          <div class="flex flex-col gap-2">
            <label class="text-[#3f4941] text-[12px] font-bold">Judul Periode PMBM</label>
            <input type="text" name="judul" value="{{ old('judul', $periode->judul ?? '') }}" required placeholder="Contoh: Penerimaan Peserta Didik Baru 2026/2027"
                   class="bg-[#f1f4f3] border border-[#bec9be] rounded px-4 py-4 text-[14px] text-[#181c1c] outline-none">
            @error('judul') <span class="text-red-600 text-[12px]">{{ $message }}</span> @enderror
          </div>

          <div class="flex flex-col gap-2">
            <label class="text-[#3f4941] text-[12px] font-bold">Deskripsi Periode</label>
            <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat mengenai periode pendaftaran ini"
                      class="bg-[#f1f4f3] border border-[#bec9be] rounded px-4 py-4 text-[14px] text-[#181c1c] outline-none resize-y">{{ old('deskripsi', $periode->deskripsi ?? '') }}</textarea>
            @error('deskripsi') <span class="text-red-600 text-[12px]">{{ $message }}</span> @enderror
          </div>

          <div class="flex flex-col gap-2">
            <label class="text-[#3f4941] text-[12px] font-bold">Tanggal Mulai - Berakhir</label>
            <div class="flex gap-4 max-[600px]:flex-col">
              <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', isset($periode) ? \Carbon\Carbon::parse($periode->tanggal_mulai)->format('Y-m-d') : '') }}" required
                     class="flex-1 bg-[#f1f4f3] border border-[#bec9be] rounded px-4 py-4 text-[14px] text-[#181c1c] outline-none">
              <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', isset($periode) ? \Carbon\Carbon::parse($periode->tanggal_selesai)->format('Y-m-d') : '') }}" required
                     class="flex-1 bg-[#f1f4f3] border border-[#bec9be] rounded px-4 py-4 text-[14px] text-[#181c1c] outline-none">
            </div>
            @error('tanggal_mulai') <span class="text-red-600 text-[12px]">{{ $message }}</span> @enderror
            @error('tanggal_selesai') <span class="text-red-600 text-[12px]">{{ $message }}</span> @enderror
          </div>

          <div class="flex flex-col gap-2 relative">
            <label class="text-[#3f4941] text-[12px] font-bold">Tambah Jalur</label>
            @php($selectedPrograms = isset($periode) ? $periode->programs->pluck('id_program')->toArray() : old('id_programs', []))
            <button type="button" id="jalurTrigger" onclick="document.getElementById('jalurDropdown').classList.toggle('hidden')"
                    class="bg-[#f1f4f3] border border-[#bec9be] rounded px-4 py-4 text-[14px] text-[#181c1c] outline-none cursor-pointer flex items-center justify-between">
              <span id="jalurLabel">{{ count($selectedPrograms) ? count($selectedPrograms) . ' program dipilih' : 'Pilih Jalur' }}</span>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/></svg>
            </button>
            <div id="jalurDropdown" class="hidden bg-white border border-[#bec9be] rounded shadow-lg overflow-hidden">
              @foreach($programs as $prog)
                @php($isChecked = in_array($prog->id_program, $selectedPrograms))
                <label class="peer-checked:bg-[#005b31] peer-checked:text-white flex items-center px-4 py-3 text-[14px] cursor-pointer border-b border-gray-100 last:border-b-0 bg-[#f1f4f3] text-[#181c1c] hover:bg-gray-100 has-[:checked]:bg-[#005b31] has-[:checked]:text-white">
                  <input type="checkbox" name="id_programs[]" value="{{ $prog->id_program }}" onchange="updateJalurLabel()"
                         {{ $isChecked ? 'checked' : '' }} class="hidden peer">
                  {{ $prog->nama_program }}
                </label>
              @endforeach
            </div>
          </div>

          <!-- Koordinasi TIM dropdown removed -->

          <div class="flex justify-center pt-4">
            <button type="submit" class="bg-[#006a3c] text-white text-[16px] px-6 py-2 rounded cursor-pointer hover:bg-[#064e3b]">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function updateJalurLabel() {
      const count = document.querySelectorAll('input[name="id_programs[]"]:checked').length;
      document.getElementById('jalurLabel').textContent = count ? count + ' program dipilih' : 'Pilih Jalur';
    }
    document.addEventListener('click', function (e) {
      const dropdowns = [
        ['jalurDropdown', 'jalurTrigger']
      ];
      dropdowns.forEach(([dropdownId, triggerId]) => {
        const dropdown = document.getElementById(dropdownId);
        const trigger = document.getElementById(triggerId);
        if (dropdown && !dropdown.contains(e.target) && !trigger.contains(e.target)) {
          dropdown.classList.add('hidden');
        }
      });
    });
  </script>
@endsection
