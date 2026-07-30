@extends('layouts.admin')

@section('title', 'Edit Pendaftaran Calon Murid - Admin Portal')

@section('content')
  <div class="relative min-h-screen bg-[#f8f9ff] flow-root">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'applicants'])

    <!-- Content Wrapper -->
    <div class="absolute left-[380px] top-[180px] right-10 flex flex-col gap-6 z-0 max-[1024px]:left-5 max-[1024px]:right-5 max-[1024px]:top-[150px] pb-12">
      <!-- Back Button -->
      <a href="{{ route('tata_usaha.detail', $pendaftaran->id_pendaftaran) }}" class="flex items-center gap-2 text-[#3f4941] text-[15px] no-underline w-fit hover:underline font-bold" style="font-family: 'Manrope-Bold', sans-serif;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m0 0l6 6m-6-6l6-6"/></svg>
        Kembali ke Detail Pendaftaran
      </a>

      <!-- Page Header -->
      <div class="flex flex-col gap-1">
        <div class="text-[#181c1c] text-[28px] font-bold tracking-[-0.56px]" style="font-family: 'Manrope-Bold', sans-serif;">Ubah Data Pendaftaran</div>
        <div class="text-[#3f4941] text-[14px]">Edit data diri calon murid, data orang tua (wali), dan program pilihan pendaftaran.</div>
      </div>

      @if($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-700 text-[13px] rounded-md p-4 font-bold max-w-[800px]">
          <div class="mb-1">Terjadi kesalahan pengisian form:</div>
          <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('tata_usaha.applicants.update', $pendaftaran->id_pendaftaran) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6 max-w-[800px] w-full bg-white border border-[#bec9be] rounded-xl p-8 shadow-sm">
        @csrf

        <!-- SECTION 1: Identitas Calon Murid -->
        <div class="flex flex-col gap-4 border-b border-gray-100 pb-6">
          <div class="text-[#005b31] text-[18px] font-bold" style="font-family: 'Manrope-Bold', sans-serif;">1. Identitas Calon Murid</div>
          
          <div class="grid grid-cols-2 gap-4 max-[600px]:grid-cols-1">
            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Nama Lengkap Murid</label>
              <input type="text" name="nama_murid" value="{{ old('nama_murid', $student->nama_murid) }}" required
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none">
            </div>
            
            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Jenis Kelamin</label>
              <select name="jenis_kelamin" required class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2.5 text-[14px] text-[#181c1c] outline-none">
                <option value="L" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
              </select>
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">NIK</label>
              <input type="text" name="nik" value="{{ old('nik', $student->nik) }}" required maxlength="16" minlength="16"
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none">
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">NISN</label>
              <input type="text" name="nisn" value="{{ old('nisn', $student->nisn) }}" required maxlength="10" minlength="10"
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none">
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Tempat Lahir</label>
              <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $student->tempat_lahir) }}" required
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none">
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $student->tanggal_lahir) }}" required
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none">
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Email Calon Murid</label>
              <input type="email" name="email" value="{{ old('email', $student->email) }}" required
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none">
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Pilihan Program Studi</label>
              <select name="id_program" required class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2.5 text-[14px] text-[#181c1c] outline-none">
                @foreach($programs as $prog)
                  <option value="{{ $prog->id_program }}" {{ old('id_program', $pendaftaran->id_program) == $prog->id_program ? 'selected' : '' }}>
                    {{ $prog->nama_program }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="flex flex-col gap-2 mt-2">
            <label class="text-[#3f4941] text-[12px] font-bold uppercase">Alamat Domisili Murid</label>
            <textarea name="alamat" rows="3" required
                      class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none resize-y">{{ old('alamat', $student->alamat) }}</textarea>
          </div>
        </div>

        <!-- SECTION 2: Data Ayah Kandung -->
        <div class="flex flex-col gap-4 border-b border-gray-100 pb-6">
          <div class="text-[#005b31] text-[18px] font-bold" style="font-family: 'Manrope-Bold', sans-serif;">2. Data Ayah Kandung</div>
          
          <div class="grid grid-cols-2 gap-4 max-[600px]:grid-cols-1">
            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Nama Lengkap Ayah</label>
              <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $ayah->nama_ayah ?? '') }}" required
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none">
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Pekerjaan Ayah</label>
              <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $ayah->pekerjaan ?? '') }}"
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none">
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Nomor Telepon Ayah</label>
              <input type="text" name="nomor_telpon_ayah" value="{{ old('nomor_telpon_ayah', $ayah->nomor_telpon ?? '') }}"
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none">
            </div>
          </div>
        </div>

        <!-- SECTION 3: Data Ibu Kandung -->
        <div class="flex flex-col gap-4 border-b border-gray-100 pb-6">
          <div class="text-[#005b31] text-[18px] font-bold" style="font-family: 'Manrope-Bold', sans-serif;">3. Data Ibu Kandung</div>
          
          <div class="grid grid-cols-2 gap-4 max-[600px]:grid-cols-1">
            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Nama Lengkap Ibu</label>
              <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $ibu->nama_ibu ?? '') }}" required
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none">
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Pekerjaan Ibu</label>
              <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $ibu->pekerjaan ?? '') }}"
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none">
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Nomor Telepon Ibu</label>
              <input type="text" name="nomor_telpon_ibu" value="{{ old('nomor_telpon_ibu', $ibu->nomor_telpon ?? '') }}"
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[14px] text-[#181c1c] outline-none">
            </div>
          </div>
        </div>

        <!-- SECTION 4: Upload Berkas (Opsional) -->
        <div class="flex flex-col gap-4 pb-6">
          <div class="text-[#005b31] text-[18px] font-bold" style="font-family: 'Manrope-Bold', sans-serif;">4. Pembaruan Berkas Dokumen (Opsional)</div>
          <p class="text-[12px] text-gray-500 mt-[-8px]">Biarkan kosong jika tidak ingin mengubah berkas dokumen yang sudah ada.</p>

          <div class="grid grid-cols-2 gap-4 max-[600px]:grid-cols-1">
            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Pas Foto 3x4 (Image)</label>
              <input type="file" name="pas_foto" accept="image/*"
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[13px] text-[#181c1c] outline-none">
              @if($student->pas_foto)
                <div class="text-[11px] text-emerald-700">File tersedia: <a href="{{ asset($student->pas_foto) }}" target="_blank" class="underline">Lihat Pas Foto</a></div>
              @endif
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Kartu Keluarga (KK)</label>
              <input type="file" name="kartu_keluarga" accept=".pdf,image/*"
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[13px] text-[#181c1c] outline-none">
              @if($student->kartu_keluarga)
                <div class="text-[11px] text-emerald-700">File tersedia: <a href="{{ asset($student->kartu_keluarga) }}" target="_blank" class="underline">Lihat KK</a></div>
              @endif
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Akta Kelahiran</label>
              <input type="file" name="akta_kelahiran" accept=".pdf,image/*"
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[13px] text-[#181c1c] outline-none">
              @if($student->akta_kelahiran)
                <div class="text-[11px] text-emerald-700">File tersedia: <a href="{{ asset($student->akta_kelahiran) }}" target="_blank" class="underline">Lihat Akta</a></div>
              @endif
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">KIA (Kartu Identitas Anak)</label>
              <input type="file" name="kartu_identitas_anak" accept=".pdf,image/*"
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[13px] text-[#181c1c] outline-none">
              @if($student->kartu_identitas_anak)
                <div class="text-[11px] text-emerald-700">File tersedia: <a href="{{ asset($student->kartu_identitas_anak) }}" target="_blank" class="underline">Lihat KIA</a></div>
              @endif
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[#3f4941] text-[12px] font-bold uppercase">Piagam Kejuaraan (Opsional)</label>
              <input type="file" name="piagram_kejuaraan" accept=".pdf,image/*"
                     class="bg-[#f1f4f3] border border-[#bec9be] rounded px-3 py-2 text-[13px] text-[#181c1c] outline-none">
              @if($student->piagram_kejuaraan)
                <div class="text-[11px] text-emerald-700">File tersedia: <a href="{{ asset($student->piagram_kejuaraan) }}" target="_blank" class="underline">Lihat Piagam</a></div>
              @endif
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
          <a href="{{ route('tata_usaha.detail', $pendaftaran->id_pendaftaran) }}" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 font-bold px-6 py-2.5 rounded text-[14px] no-underline">
            Batal
          </a>
          <button type="submit" class="bg-[#005b31] hover:bg-[#064e3b] text-white font-bold px-8 py-2.5 rounded text-[14px] border-none cursor-pointer">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
