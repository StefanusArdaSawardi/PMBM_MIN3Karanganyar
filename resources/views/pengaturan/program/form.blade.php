@extends('layouts.admin')

@section('title', ($program ? 'Edit' : 'Tambah') . ' Program - Admin Portal')

@section('content')
  <div class="relative min-h-screen flow-root">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'program'])

    <!-- Content Wrapper -->
    <div class="absolute left-[380px] top-[138px] right-10 flex flex-col gap-6 z-0 max-[1024px]:left-5 max-[1024px]:right-5 max-[1024px]:top-[150px]">

      @if(session('error'))
        <div class="bg-red-50 border border-red-300 text-red-700 text-[13px] rounded-md p-3 font-bold">
          {{ session('error') }}
        </div>
      @endif

      <div class="bg-white border border-[#becabe] rounded-xl shadow-[0_4px_4px_rgba(0,0,0,0.25)] p-8 max-w-[1045px]">
        <div class="text-[#005b31] text-[20px] text-center mb-6">{{ $program ? 'EDIT PROGRAM' : 'TAMBAH PROGRAM' }}</div>

        <form action="{{ $program ? route('tata_usaha.program.update', $program->id_program) : route('tata_usaha.program.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
          @csrf

          <div class="flex flex-col gap-2">
            <label class="text-[#3f4940] text-[14px] font-semibold tracking-wide">NAMA PROGRAM</label>
            <input type="text" name="nama_program" value="{{ old('nama_program', $program->nama_program ?? '') }}" required
                   class="border border-black/25 rounded px-4 py-2.5 text-[14px] text-[#3f4940] outline-none">
            @error('nama_program') <span class="text-red-600 text-[12px]">{{ $message }}</span> @enderror
          </div>

          <div class="grid grid-cols-2 gap-4 max-[700px]:grid-cols-1">
            <div class="flex flex-col gap-2">
              <label class="text-[#3f4940] text-[14px] font-semibold tracking-wide">DESKRIPSI</label>
              <textarea name="persyaratan" required rows="3"
                        class="border border-black/25 rounded px-4 py-2.5 text-[14px] text-[#3f4940] outline-none resize-none">{{ old('persyaratan', $program->persyaratan ?? '') }}</textarea>
              @error('persyaratan') <span class="text-red-600 text-[12px]">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4940] text-[14px] font-semibold tracking-wide">POINT</label>
              <div id="poinList" class="border border-black/25 rounded px-4 py-2.5 flex flex-col gap-1"></div>
              <button type="button" onclick="addPoinField()" class="text-[#005b31] text-[12px] font-semibold cursor-pointer w-fit">+ Tambah Poin</button>
            </div>
          </div>

          <div class="flex flex-col gap-2">
            <label class="text-[#3f4940] text-[14px] font-semibold tracking-wide">KUOTA SISWA</label>
            <input type="number" name="kuota_program" value="{{ old('kuota_program', $program->kuota_program ?? '') }}" required min="0"
                   class="border border-black/25 rounded px-4 py-2.5 text-[14px] text-[#3f4940] outline-none">
            @error('kuota_program') <span class="text-red-600 text-[12px]">{{ $message }}</span> @enderror
          </div>

          <div class="flex flex-col gap-2">
            <label class="text-[#3f4940] text-[14px] font-semibold tracking-wide">FOTO PROGRAM (BISA LEBIH DARI 1)</label>
            <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/jpg"
                   class="border border-black/25 rounded px-4 py-2.5 text-[14px] text-[#3f4940] outline-none">
            <div class="text-[#3f4940] text-[12px]">Choose File JPG, PNG (Pilih satu atau lebih)</div>
            
            @if($program && count($program->images) > 0)
              <div class="text-[#3f4940] text-[12px] font-bold mt-2">FOTO AKTIF:</div>
              <div class="flex flex-wrap gap-3 mt-1" style="display: flex; gap: 12px; flex-wrap: wrap;">
                @foreach($program->images as $imgUrl)
                  <div class="relative group w-20 h-20 border border-gray-200 rounded overflow-hidden" style="position: relative; width: 80px; height: 80px;">
                    <img src="{{ asset($imgUrl) }}" class="w-full h-full object-cover" style="width: 100%; height: 100%; object-fit: cover;">
                    <input type="hidden" name="existing_images[]" value="{{ $imgUrl }}">
                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-0 right-0 bg-red-600 text-white rounded-bl p-1 text-[10px] cursor-pointer hover:bg-red-800 border-none" style="position: absolute; top: 0; right: 0; background: #dc2626; color: white; border: none; padding: 2px 6px; cursor: pointer;" title="Hapus foto ini">&times;</button>
                  </div>
                @endforeach
              </div>
            @endif
            @error('images') <span class="text-red-600 text-[12px]">{{ $message }}</span> @enderror
            @error('images.*') <span class="text-red-600 text-[12px]">{{ $message }}</span> @enderror
          </div>

          <div class="flex flex-col gap-3">
            <label class="text-[#005b31] text-[14px] font-semibold tracking-wide">KRITERIA PERSYARATAN</label>
            
            <div class="overflow-x-auto">
              <table class="w-full text-left border-collapse" style="min-width: 400px;">
                <thead>
                  <tr class="border-b border-[#bec9be]">
                    <th class="pb-2 text-[#3f4940] text-[12px] font-bold uppercase" style="width: 50%;">Kategori Penilaian</th>
                    <th class="pb-2 text-[#3f4940] text-[12px] font-bold uppercase" style="width: 35%;">Nilai Minimum Kelulusan</th>
                    <th class="pb-2 text-center text-[#3f4940] text-[12px] font-bold uppercase" style="width: 15%;">Tindakan</th>
                  </tr>
                </thead>
                <tbody id="criteriaListTable">
                  <!-- Dynamic rows inserted via JS -->
                </tbody>
              </table>
            </div>
            
            <button type="button" onclick="addCriteriaRow()" class="text-[#005b31] text-[13px] font-semibold cursor-pointer w-fit mt-2">
              ➕ Tambah Kriteria Persyaratan Baru
            </button>
          </div>

          <div class="flex justify-center gap-3 pt-2">
            <button type="submit" class="bg-[#005b31] text-white text-[14px] font-semibold tracking-wide px-6 py-2.5 rounded-[10px] cursor-pointer">Simpan</button>
            <a href="{{ route('tata_usaha.program.index') }}" class="bg-gray-100 text-gray-600 border border-gray-300 text-[14px] font-semibold tracking-wide px-6 py-2.5 rounded-[10px] no-underline">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function addPoinField(value = '') {
      const wrapper = document.createElement('div');
      wrapper.className = 'flex gap-2 items-center';
      wrapper.innerHTML = `
        <input type="text" name="poin_unggulan[]" value="${value.replace(/"/g, '&quot;')}" class="flex-1 bg-transparent border-b border-gray-200 py-1 text-[13px] text-[#3f4940] outline-none">
        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 cursor-pointer bg-none border-none text-[14px]">&times;</button>
      `;
      document.getElementById('poinList').appendChild(wrapper);
    }

    let criteriaIndex = 0;
    function addCriteriaRow(namaKriteria = '', nilaiMinimum = 0) {
      const tbody = document.getElementById('criteriaListTable');
      const row = document.createElement('tr');
      row.className = 'border-b border-gray-100';
      row.innerHTML = `
        <td class="py-2.5">
          <select name="criteria[${criteriaIndex}][nama_kriteria]" class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2.5 text-[14px] text-[#181c1c] outline-none w-full" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="hafalan" ${namaKriteria === 'hafalan' ? 'selected' : ''}>Hafalan</option>
            <option value="aism" ${namaKriteria === 'aism' ? 'selected' : ''}>AISM</option>
            <option value="iqro" ${namaKriteria === 'iqro' ? 'selected' : ''}>Iqro</option>
            <option value="calistung" ${namaKriteria === 'calistung' ? 'selected' : ''}>Calistung</option>
            <option value="dikte" ${namaKriteria === 'dikte' ? 'selected' : ''}>Dikte</option>
            <option value="kemandirian" ${namaKriteria === 'kemandirian' ? 'selected' : ''}>Kemandirian</option>
          </select>
        </td>
        <td class="py-2.5 px-2">
          <input type="number" name="criteria[${criteriaIndex}][nilai_minimum]" value="${nilaiMinimum}" min="0" max="100" placeholder="Ketik nilai (contoh: 70)" required
                 class="border border-black/25 rounded px-3 py-2.5 text-[14px] text-[#3f4940] outline-none w-full">
        </td>
        <td class="py-2.5 text-center">
          <button type="button" onclick="this.closest('tr').remove()" class="bg-[#ba1a1a] hover:bg-[#93000a] text-white font-bold px-3 py-2 rounded text-[12px] cursor-pointer border-none transition-colors">
            Hapus
          </button>
        </td>
      `;
      tbody.appendChild(row);
      criteriaIndex++;
    }

    document.addEventListener('DOMContentLoaded', function () {
      // Points Unggulan
      const existing = @json(old('poin_unggulan', $program->poin_unggulan ?? []));
      if (existing.length) {
        existing.forEach(p => addPoinField(p));
      } else {
        addPoinField(); addPoinField();
      }

      // Requirements Criteria
      const existingCriteria = @json(old('criteria', $program ? $program->criteria->toArray() : []));
      if (existingCriteria.length) {
        existingCriteria.forEach(c => {
          addCriteriaRow(c.nama_kriteria, c.nilai_minimum);
        });
      }
    });
  </script>
@endsection
