@extends('layouts.landing')

@section('title', 'Ubah Data Pendaftaran - PMBM MIN 3 Karanganyar')

@section('content')
  <div class="relative min-h-screen bg-[#e5e2e1] flow-root" style="font-family: 'PlusJakartaSans-Regular', sans-serif;">
    <!-- Landing Navbar Included -->
    @include('components.navbar', ['activeFolder' => 'home'])

    <div class="relative z-[20] max-w-[800px] mx-auto mt-[140px] mb-[60px] bg-white rounded-[20px] shadow-[0_10px_25px_rgba(0,0,0,0.05)] p-10 max-[640px]:p-6 max-[640px]:mt-[170px]">
      <div class="text-center mb-10">
        <h1 class="text-[#064e3b] text-[28px] mb-2.5" style="font-family: 'PlusJakartaSans-ExtraBold', sans-serif;">Ubah Data Pendaftaran</h1>
        <p class="text-gray-500 text-[14px]">Perbarui informasi dan unggah ulang berkas yang salah untuk memproses verifikasi kembali.</p>
      </div>

      <!-- Rejection Note Alert -->
      <div class="bg-red-50 border border-red-300 text-red-700 p-5 rounded-xl mb-6">
        <h3 class="font-bold mb-2 text-[15px] text-red-700 flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
          Catatan Penolakan dari Tata Usaha
        </h3>
        <p class="text-[14px] font-bold bg-white p-3 rounded-lg border-l-4 border-red-500 mt-2 text-gray-700">
          "{{ $pendaftaran->alasan_penolakan }}"
        </p>
        <p class="text-[12px] mt-3 text-red-900">
          Silakan perbaiki data yang belum sesuai dan/atau unggah berkas baru yang diminta pada bagian dokumen di bawah.
        </p>
      </div>

      @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl text-[13px] mb-6">
          <p class="font-bold mb-2">Terjadi kesalahan pengisian form:</p>
          <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Stepper Header -->
      <div class="relative flex items-center justify-between mb-10">
        <div class="absolute top-5 h-1 bg-gray-200 z-[1]" style="left: 12.5%; right: 12.5%;"></div>
        <div id="progressBar" class="absolute top-5 h-1 bg-[#298752] z-[1] transition-[clip-path] duration-300 ease-in-out" style="left: 12.5%; right: 12.5%; clip-path: inset(0 100% 0 0);"></div>

        <div class="step relative z-[2] flex flex-col items-center flex-1 active" id="step-tab-1">
          <div class="step-circle w-11 h-11 rounded-full flex items-center justify-center font-bold border-4 border-white shadow-[0_4px_6px_rgba(0,0,0,0.05)] transition-all duration-300">1</div>
          <div class="step-label mt-2.5 text-[12px] font-bold max-[480px]:hidden">Data Calon Murid</div>
        </div>
        <div class="step relative z-[2] flex flex-col items-center flex-1" id="step-tab-2">
          <div class="step-circle w-11 h-11 rounded-full flex items-center justify-center font-bold border-4 border-white shadow-[0_4px_6px_rgba(0,0,0,0.05)] transition-all duration-300">2</div>
          <div class="step-label mt-2.5 text-[12px] font-bold max-[480px]:hidden">Data Orang Tua</div>
        </div>
        <div class="step relative z-[2] flex flex-col items-center flex-1" id="step-tab-3">
          <div class="step-circle w-11 h-11 rounded-full flex items-center justify-center font-bold border-4 border-white shadow-[0_4px_6px_rgba(0,0,0,0.05)] transition-all duration-300">3</div>
          <div class="step-label mt-2.5 text-[12px] font-bold max-[480px]:hidden">Berkas Dokumen</div>
        </div>
        <div class="step relative z-[2] flex flex-col items-center flex-1" id="step-tab-4">
          <div class="step-circle w-11 h-11 rounded-full flex items-center justify-center font-bold border-4 border-white shadow-[0_4px_6px_rgba(0,0,0,0.05)] transition-all duration-300">4</div>
          <div class="step-label mt-2.5 text-[12px] font-bold max-[480px]:hidden">Konfirmasi</div>
        </div>
      </div>

      <!-- Edit Form -->
      <form action="{{ route('student.update', $pendaftaran->id_pendaftaran) }}" method="POST" enctype="multipart/form-data" id="registerForm">
        @csrf

        <!-- Step 1: Student Data -->
        <div class="form-step active" id="step-pane-1">
          <div class="flex items-center gap-2.5 text-[18px] font-bold text-[#064e3b] border-b-2 border-gray-100 pb-2.5 mb-6">
            <span class="bg-[#298752]/10 text-[#298752] w-7 h-7 rounded-full inline-flex items-center justify-center text-[14px]">1</span> Data Calon Murid
          </div>
          <div class="grid grid-cols-2 gap-5 max-[640px]:grid-cols-1">
            <x-form.input name="nama_murid" label="Nama Lengkap Murid" required full-width
                value="{{ old('nama_murid', $student->nama_murid) }}" placeholder="Masukkan nama lengkap siswa" />

            <x-form.input name="nik" label="NIK (Nomor Induk Kependudukan)" required
                minlength="16" maxlength="16" pattern="[0-9]{16}" title="NIK harus tepat 16 digit angka"
                value="{{ old('nik', $student->nik) }}" placeholder="Masukkan 16 digit NIK" inputmode="numeric" />

            <x-form.select name="jenis_kelamin" label="Jenis Kelamin" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
            </x-form.select>

            <x-form.input name="nisn" label="NISN" required
                minlength="10" maxlength="10" pattern="[0-9]{10}" title="NISN harus tepat 10 digit angka"
                value="{{ old('nisn', $student->nisn) }}" placeholder="Masukkan 10 digit NISN" inputmode="numeric" />

            <x-form.select name="id_program" label="Pilihan Program Kelas" required>
                <option value="">-- Pilih Program --</option>
                @foreach($programs as $program)
                  <option value="{{ $program->id_program }}" {{ old('id_program', $pendaftaran->id_program) == $program->id_program ? 'selected' : '' }}>
                    {{ $program->nama_program }}
                  </option>
                @endforeach
            </x-form.select>

            <x-form.input name="tempat_lahir" label="Tempat Lahir" required
                minlength="3" maxlength="100" pattern="[a-zA-Z\s]+" title="Hanya huruf dan spasi"
                value="{{ old('tempat_lahir', $student->tempat_lahir) }}" placeholder="Contoh: Karanganyar" />

            <x-form.input type="date" name="tanggal_lahir" label="Tanggal Lahir" required value="{{ old('tanggal_lahir', $student->tanggal_lahir) }}" />

            <x-form.input type="email" name="email" label="Email Calon Murid / Kontak" required
                value="{{ old('email', $student->email) }}" placeholder="siswa@gmail.com" />

            <x-form.textarea name="alamat" label="Alamat Lengkap Rumah" required full-width
                rows="3" placeholder="Dusun, RT/RW, Kelurahan, Kecamatan, Kabupaten">{{ old('alamat', $student->alamat) }}</x-form.textarea>
          </div>

          <div class="flex justify-between mt-10 border-t border-gray-100 pt-5">
            <div></div>
            <button type="button" onclick="goToStep(2)" class="px-7 py-3.5 text-[14px] font-bold rounded-xl cursor-pointer transition-all duration-300 bg-[#298752] text-white shadow-[0_4px_10px_rgba(41,135,82,0.2)] hover:bg-[#064e3b]">Selanjutnya ➔</button>
          </div>
        </div>

        <!-- Step 2: Parents Data -->
        <div class="form-step hidden" id="step-pane-2">
          <div class="flex items-center gap-2.5 text-[18px] font-bold text-[#064e3b] border-b-2 border-gray-100 pb-2.5 mb-6">
            <span class="bg-[#298752]/10 text-[#298752] w-7 h-7 rounded-full inline-flex items-center justify-center text-[14px]">2</span> Data Orang Tua / Wali
          </div>

          <div class="grid grid-cols-2 gap-5 max-[640px]:grid-cols-1">
            <!-- Ayah -->
            <div class="flex flex-col gap-2 col-span-2 max-[640px]:col-span-1">
              <h3 class="font-bold text-gray-700 text-[14px] mb-2.5 border-l-4 border-[#298752] pl-2.5">DATA AYAH KANDUNG</h3>
            </div>
            <x-form.input name="nama_ayah" label="Nama Lengkap Ayah" required
                value="{{ old('nama_ayah', $ayah->nama_ayah) }}" placeholder="Nama lengkap Ayah" />
            <x-form.input name="pekerjaan_ayah" label="Pekerjaan Ayah"
                value="{{ old('pekerjaan_ayah', $ayah->pekerjaan) }}" placeholder="Contoh: Wiraswasta, PNS" />
            <x-form.input name="nomor_telpon_ayah" label="No. Telpon/WhatsApp Ayah"
                value="{{ old('nomor_telpon_ayah', $ayah->nomor_telpon) }}" placeholder="08xxxxxxxxxx" />

            <!-- Ibu -->
            <div class="flex flex-col gap-2 col-span-2 max-[640px]:col-span-1 mt-5">
              <h3 class="font-bold text-gray-700 text-[14px] mb-2.5 border-l-4 border-[#298752] pl-2.5">DATA IBU KANDUNG</h3>
            </div>
            <x-form.input name="nama_ibu" label="Nama Lengkap Ibu" required
                value="{{ old('nama_ibu', $ibu->nama_ibu) }}" placeholder="Nama lengkap Ibu" />
            <x-form.input name="pekerjaan_ibu" label="Pekerjaan Ibu"
                value="{{ old('pekerjaan_ibu', $ibu->pekerjaan) }}" placeholder="Contoh: Ibu Rumah Tangga" />
            <x-form.input name="nomor_telpon_ibu" label="No. Telpon/WhatsApp Ibu"
                value="{{ old('nomor_telpon_ibu', $ibu->nomor_telpon) }}" placeholder="08xxxxxxxxxx" />
          </div>

          <div class="flex justify-between mt-10 border-t border-gray-100 pt-5">
            <button type="button" onclick="goToStep(1)" class="px-7 py-3.5 text-[14px] font-bold rounded-xl cursor-pointer transition-all duration-300 bg-white border border-gray-300 text-gray-600 hover:bg-gray-50">Sebelumnya</button>
            <button type="button" onclick="goToStep(3)" class="px-7 py-3.5 text-[14px] font-bold rounded-xl cursor-pointer transition-all duration-300 bg-[#298752] text-white shadow-[0_4px_10px_rgba(41,135,82,0.2)] hover:bg-[#064e3b]">Selanjutnya ➔</button>
          </div>
        </div>

        <!-- Step 3: Documents Upload -->
        <div class="form-step hidden" id="step-pane-3">
          <div class="flex items-center gap-2.5 text-[18px] font-bold text-[#064e3b] border-b-2 border-gray-100 pb-2.5 mb-6">
            <span class="bg-[#298752]/10 text-[#298752] w-7 h-7 rounded-full inline-flex items-center justify-center text-[14px]">3</span> Unggah Berkas Pendaftaran
          </div>
          <p class="text-[12px] text-gray-500 mb-5">Lakukan unggah file baru *hanya* jika Anda ingin mengubah atau memperbaiki berkas yang saat ini terunggah.</p>

          <div class="grid grid-cols-2 gap-5 max-[640px]:grid-cols-1">
            <x-form.file-upload name="pas_foto" label="Pas Foto Berwarna" accept="image/*" format="JPG, JPEG, PNG (Maks. 5MB)"
                :current-file="$student->pas_foto" current-file-label="Lihat Pas Foto" />
            <x-form.file-upload name="kartu_keluarga" label="Kartu Keluarga (KK)" accept=".pdf,image/*"
                :current-file="$student->kartu_keluarga" current-file-label="Lihat Kartu Keluarga" />
            <x-form.file-upload name="akta_kelahiran" label="Akta Kelahiran" accept=".pdf,image/*"
                :current-file="$student->akta_kelahiran" current-file-label="Lihat Akta Kelahiran" />
            <x-form.file-upload name="kartu_identitas_anak" label="Kartu Identitas Anak (KIA)" accept=".pdf,image/*"
                :current-file="$student->kartu_identitas_anak" current-file-label="Lihat KIA" />
            <x-form.file-upload name="piagram_kejuaraan" label="Piagam Kejuaraan (Opsional)" accept=".pdf,image/*"
                :current-file="$student->piagram_kejuaraan ?? null" current-file-label="Lihat Piagam Kejuaraan" />
          </div>

          <div class="flex justify-between mt-10 border-t border-gray-100 pt-5">
            <button type="button" onclick="goToStep(2)" class="px-7 py-3.5 text-[14px] font-bold rounded-xl cursor-pointer transition-all duration-300 bg-white border border-gray-300 text-gray-600 hover:bg-gray-50">Sebelumnya</button>
            <button type="button" onclick="goToStep(4)" class="px-7 py-3.5 text-[14px] font-bold rounded-xl cursor-pointer transition-all duration-300 bg-[#298752] text-white shadow-[0_4px_10px_rgba(41,135,82,0.2)] hover:bg-[#064e3b]">Selanjutnya ➔</button>
          </div>
        </div>

        <!-- Step 4: Summary & Confirm -->
        <div class="form-step hidden" id="step-pane-4">
          <div class="flex items-center gap-2.5 text-[18px] font-bold text-[#064e3b] border-b-2 border-gray-100 pb-2.5 mb-6">
            <span class="bg-[#298752]/10 text-[#298752] w-7 h-7 rounded-full inline-flex items-center justify-center text-[14px]">4</span> Konfirmasi Perubahan
          </div>

          <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6">
            <h4 class="font-bold text-[#064e3b] text-[14px] mb-4">Ringkasan Perubahan Data Formulir</h4>
            <div class="grid grid-cols-2 gap-4 text-[13px] max-[480px]:grid-cols-1">
              <div>
                <label class="text-gray-400 font-medium">Nama Calon Murid</label>
                <p id="sum-name" class="text-gray-800 font-bold mt-1">-</p>
              </div>
              <div>
                <label class="text-gray-400 font-medium">Jenis Kelamin</label>
                <p id="sum-gender" class="text-gray-800 font-bold mt-1">-</p>
              </div>
              <div>
                <label class="text-gray-400 font-medium">NIK</label>
                <p id="sum-nik" class="text-gray-800 font-bold mt-1">-</p>
              </div>
              <div>
                <label class="text-gray-400 font-medium">NISN</label>
                <p id="sum-nisn" class="text-gray-800 font-bold mt-1">-</p>
              </div>
              <div>
                <label class="text-gray-400 font-medium">Tempat, Tanggal Lahir</label>
                <p id="sum-ttl" class="text-gray-800 font-bold mt-1">-</p>
              </div>
              <div>
                <label class="text-gray-400 font-medium">Program Pilihan</label>
                <p id="sum-program" class="text-gray-800 font-bold mt-1">-</p>
              </div>
              <div>
                <label class="text-gray-400 font-medium">Nama Ayah / Ibu</label>
                <p id="sum-parents" class="text-gray-800 font-bold mt-1">-</p>
              </div>
              <div>
                <label class="text-gray-400 font-medium">Email Kontak</label>
                <p id="sum-email" class="text-gray-800 font-bold mt-1">-</p>
              </div>
            </div>
          </div>

          <!-- Checkbox agreement -->
          <div class="mt-8 flex gap-2.5 bg-emerald-50 border border-emerald-200 p-4 rounded-xl">
            <input type="checkbox" id="terms_agree" required class="w-[18px] h-[18px] mt-0.5 cursor-pointer">
            <label for="terms_agree" class="text-[13px] text-emerald-800 leading-[18px] cursor-pointer">
              Saya mengonfirmasi bahwa perubahan data dan berkas dokumen yang diperbarui adalah sah, benar, dan sesuai dengan dokumen aslinya.
            </label>
          </div>

          <div class="flex justify-between mt-10 border-t border-gray-100 pt-5">
            <button type="button" onclick="goToStep(3)" class="px-7 py-3.5 text-[14px] font-bold rounded-xl cursor-pointer transition-all duration-300 bg-white border border-gray-300 text-gray-600 hover:bg-gray-50">Sebelumnya</button>
            <button type="submit" class="px-7 py-3.5 text-[14px] font-bold rounded-xl cursor-pointer transition-all duration-300 bg-[#064e3b] text-white shadow-[0_4px_10px_rgba(6,78,59,0.2)]">Simpan Perubahan & Ajukan Kembali</button>
          </div>
        </div>
      </form>
    </div>

    <!-- Shared Footer Component -->
    @include('components.footer', ['activeFolder' => 'home'])
  </div>
@endsection

@section('scripts')
  <style>
    .step.active .step-circle { background: #298752; color: #ffffff; transform: scale(1.1); }
    .step.completed .step-circle { background: #064e3b; color: #ffffff; }
    .step:not(.active):not(.completed) .step-circle { background: #e5e7eb; color: #6b7280; }
    .step.active .step-label { color: #298752; }
    .step.completed .step-label { color: #064e3b; }
    .step:not(.active):not(.completed) .step-label { color: #9ca3af; }
    .form-step.active { display: block; }
  </style>
  <script>
    let currentStep = 1;
    const totalSteps = 4;

    function goToStep(stepNum) {
      if (stepNum > currentStep) {
        const currentPane = document.getElementById(`step-pane-${currentStep}`);
        const requiredInputs = currentPane.querySelectorAll('input[required], select[required], textarea[required]');

        for (let input of requiredInputs) {
          if (!input.checkValidity()) {
            input.reportValidity();
            return;
          }
        }

        if (currentStep === 1) {
          const nik = document.getElementById('nik').value;
          if (!/^[0-9]{16}$/.test(nik)) {
            alert('NIK harus tepat 16 digit angka.');
            document.getElementById('nik').focus();
            return;
          }
          const jk = document.getElementById('jenis_kelamin').value;
          if (!jk) {
            alert('Pilih jenis kelamin terlebih dahulu.');
            document.getElementById('jenis_kelamin').focus();
            return;
          }
        }
      }

      // Hide all panes
      for (let i = 1; i <= totalSteps; i++) {
        document.getElementById(`step-pane-${i}`).classList.remove('active');
        document.getElementById(`step-pane-${i}`).classList.add('hidden');
        document.getElementById(`step-tab-${i}`).classList.remove('active', 'completed');

        if (i < stepNum) {
          document.getElementById(`step-tab-${i}`).classList.add('completed');
        }
      }

      // Show target step pane
      document.getElementById(`step-pane-${stepNum}`).classList.remove('hidden');
      document.getElementById(`step-pane-${stepNum}`).classList.add('active');
      document.getElementById(`step-tab-${stepNum}`).classList.add('active');

      // Update progress bar fill
      const progressPercent = ((stepNum - 1) / (totalSteps - 1)) * 100;
      document.getElementById('progressBar').style.clipPath = `inset(0 ${100 - progressPercent}% 0 0)`;

      if (stepNum === 4) {
        updateSummary();
      }

      currentStep = stepNum;
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function updateSummary() {
      document.getElementById('sum-name').innerText = document.getElementById('nama_murid').value || '-';
      const jk = document.getElementById('jenis_kelamin').value;
      document.getElementById('sum-gender').innerText = jk === 'L' ? 'Laki-laki' : (jk === 'P' ? 'Perempuan' : '-');
      document.getElementById('sum-nik').innerText = document.getElementById('nik').value || '-';
      document.getElementById('sum-nisn').innerText = document.getElementById('nisn').value || '-';

      const tl = document.getElementById('tempat_lahir').value || '';
      const tgl = document.getElementById('tanggal_lahir').value || '';
      document.getElementById('sum-ttl').innerText = tl && tgl ? `${tl}, ${tgl}` : '-';

      const programSelect = document.getElementById('id_program');
      document.getElementById('sum-program').innerText = programSelect.options[programSelect.selectedIndex]?.text || '-';

      const ayah = document.getElementById('nama_ayah').value || '-';
      const ibu = document.getElementById('nama_ibu').value || '-';
      document.getElementById('sum-parents').innerText = `${ayah} / ${ibu}`;

      document.getElementById('sum-email').innerText = document.getElementById('email').value || '-';
    }

    document.getElementById('registerForm').addEventListener('submit', function(e) {
      if (!document.getElementById('terms_agree').checked) {
        e.preventDefault();
        alert('Anda harus mencentang konfirmasi data terlebih dahulu!');
      }
    });
  </script>
@endsection
