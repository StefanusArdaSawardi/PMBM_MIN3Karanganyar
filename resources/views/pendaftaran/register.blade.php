@extends('layouts.landing')

@section('title', 'Pendaftaran Calon Siswa Baru - PMBM MIN 3 Karanganyar')

@section('content')
  <div class="relative min-h-screen bg-[#e5e2e1] flow-root" style="font-family: 'PlusJakartaSans-Regular', sans-serif;">
    <!-- Landing Navbar Included -->
    @include('components.navbar', ['activeFolder' => 'home'])

    <div class="relative z-[20] max-w-[800px] mx-auto mt-[140px] mb-[60px] bg-white rounded-[20px] shadow-[0_10px_25px_rgba(0,0,0,0.05)] p-10 max-[640px]:p-6 max-[640px]:mt-[170px]">
      <div class="text-center mb-10">
        <h1 class="text-[#064e3b] text-[28px] mb-2.5" style="font-family: 'PlusJakartaSans-ExtraBold', sans-serif;">Pendaftaran Calon Siswa Baru</h1>
        <p class="text-gray-500 text-[14px]">Lengkapi formulir pendaftaran di bawah ini untuk memulai proses seleksi PMBM.</p>
      </div>

      @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-500 text-emerald-800 p-5 rounded-xl mb-6 text-center">
          <h3 class="font-bold mb-2 text-[18px] text-emerald-700">Pendaftaran Berhasil!</h3>
          <p class="text-[14px] mb-3 text-emerald-800">Pendaftaran calon murid telah tersimpan dalam sistem.</p>
          <div class="bg-white border border-dashed border-emerald-500 p-3 rounded-lg inline-block font-bold text-[16px] text-emerald-700">
            Nomor Pendaftaran Anda: {{ session('success') }}
          </div>
          <p class="text-[12px] mt-3 text-emerald-800">Harap simpan nomor pendaftaran ini untuk melakukan cek status kelulusan nanti.</p>
        </div>
      @endif

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

      <!-- Registration Form -->
      <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data" id="registerForm">
        @csrf

        <!-- Step 1: Student Data -->
        <div class="form-step active" id="step-pane-1">
          <div class="flex items-center gap-2.5 text-[18px] font-bold text-[#064e3b] border-b-2 border-gray-100 pb-2.5 mb-6">
            <span class="bg-[#298752]/10 text-[#298752] w-7 h-7 rounded-full inline-flex items-center justify-center text-[14px]">1</span> Data Calon Murid
          </div>
          <div class="grid grid-cols-2 gap-5 max-[640px]:grid-cols-1">
            <x-form.input name="nama_murid" label="Nama Lengkap Murid" required full-width
                minlength="3" maxlength="255" pattern="[a-zA-Z\s\.,']+" title="Hanya huruf, spasi, titik, dan koma"
                value="{{ old('nama_murid') }}" placeholder="Masukkan nama lengkap siswa" />

            <x-form.input name="nik" label="NIK (Nomor Induk Kependudukan)" required
                minlength="16" maxlength="16" pattern="[0-9]{16}" title="NIK harus tepat 16 digit angka"
                value="{{ old('nik') }}" placeholder="Masukkan 16 digit NIK" inputmode="numeric" />

            <x-form.select name="jenis_kelamin" label="Jenis Kelamin" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </x-form.select>

            <x-form.input name="nisn" label="NISN" required
                minlength="10" maxlength="10" pattern="[0-9]{10}" title="NISN harus tepat 10 digit angka"
                value="{{ old('nisn') }}" placeholder="Masukkan 10 digit NISN" inputmode="numeric" />

            <x-form.select name="id_program" label="Pilihan Program Kelas" required>
                <option value="">-- Pilih Program --</option>
                @foreach($programs as $program)
                  <option value="{{ $program->id_program }}" {{ old('id_program') == $program->id_program ? 'selected' : '' }}>
                    {{ $program->nama_program }}
                  </option>
                @endforeach
            </x-form.select>

            <x-form.input name="tempat_lahir" label="Tempat Lahir" required
                minlength="3" maxlength="100" pattern="[a-zA-Z\s]+" title="Hanya huruf dan spasi"
                value="{{ old('tempat_lahir') }}" placeholder="Contoh: Karanganyar" />

            <x-form.input type="date" name="tanggal_lahir" label="Tanggal Lahir" required value="{{ old('tanggal_lahir') }}" />

            <x-form.textarea name="alamat" label="Alamat Lengkap Rumah" required full-width
                rows="3" minlength="10" placeholder="Dusun, RT/RW, Kelurahan, Kecamatan, Kabupaten">{{ old('alamat') }}</x-form.textarea>
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
                minlength="3" maxlength="255" pattern="[a-zA-Z\s\.,']+" title="Hanya huruf, spasi, titik, dan koma"
                value="{{ old('nama_ayah') }}" placeholder="Nama lengkap Ayah" />
            <x-form.input name="pekerjaan_ayah" label="Pekerjaan Ayah"
                minlength="3" maxlength="100" value="{{ old('pekerjaan_ayah') }}" placeholder="Contoh: Wiraswasta, PNS" />
            <x-form.input type="tel" name="nomor_telpon_ayah" label="No. Telpon/WhatsApp Ayah"
                pattern="(08|62)[0-9]{8,13}" title="Format Indonesia: 08xxx atau 62xxx, 10-15 digit"
                value="{{ old('nomor_telpon_ayah') }}" placeholder="08xxxxxxxxxx" inputmode="tel" />
            <x-form.input type="email" name="email_ayah" label="Email Ayah" value="{{ old('email_ayah') }}" placeholder="ayah@gmail.com" />

            <!-- Ibu -->
            <div class="flex flex-col gap-2 col-span-2 max-[640px]:col-span-1 mt-5">
              <h3 class="font-bold text-gray-700 text-[14px] mb-2.5 border-l-4 border-[#298752] pl-2.5">DATA IBU KANDUNG</h3>
            </div>
            <x-form.input name="nama_ibu" label="Nama Lengkap Ibu" required
                minlength="3" maxlength="255" pattern="[a-zA-Z\s\.,']+" title="Hanya huruf, spasi, titik, dan koma"
                value="{{ old('nama_ibu') }}" placeholder="Nama lengkap Ibu" />
            <x-form.input name="pekerjaan_ibu" label="Pekerjaan Ibu"
                minlength="3" maxlength="100" value="{{ old('pekerjaan_ibu') }}" placeholder="Contoh: Ibu Rumah Tangga" />
            <x-form.input type="tel" name="nomor_telpon_ibu" label="No. Telpon/WhatsApp Ibu"
                pattern="(08|62)[0-9]{8,13}" title="Format Indonesia: 08xxx atau 62xxx, 10-15 digit"
                value="{{ old('nomor_telpon_ibu') }}" placeholder="08xxxxxxxxxx" inputmode="tel" />
            <x-form.input type="email" name="email_ibu" label="Email Kontak Wali" required
                value="{{ old('email_ibu') }}" placeholder="kontak_wali@gmail.com" />
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

          <div class="grid grid-cols-2 gap-5 max-[640px]:grid-cols-1">
            <x-form.file-upload name="pas_foto" label="Pas Foto Berwarna" required accept="image/*" format="JPG, JPEG, PNG (Maks. 5MB)" />
            <x-form.file-upload name="kartu_keluarga" label="Kartu Keluarga (KK)" accept=".pdf,image/*" />
            <x-form.file-upload name="akta_kelahiran" label="Akta Kelahiran" accept=".pdf,image/*" />
            <x-form.file-upload name="kartu_identitas_anak" label="Kartu Identitas Anak (KIA)" accept=".pdf,image/*" />
          </div>

          <div class="flex justify-between mt-10 border-t border-gray-100 pt-5">
            <button type="button" onclick="goToStep(2)" class="px-7 py-3.5 text-[14px] font-bold rounded-xl cursor-pointer transition-all duration-300 bg-white border border-gray-300 text-gray-600 hover:bg-gray-50">Sebelumnya</button>
            <button type="button" onclick="goToStep(4)" class="px-7 py-3.5 text-[14px] font-bold rounded-xl cursor-pointer transition-all duration-300 bg-[#298752] text-white shadow-[0_4px_10px_rgba(41,135,82,0.2)] hover:bg-[#064e3b]">Selanjutnya ➔</button>
          </div>
        </div>

        <!-- Step 4: Summary & Confirm -->
        <div class="form-step hidden" id="step-pane-4">
          <div class="flex items-center gap-2.5 text-[18px] font-bold text-[#064e3b] border-b-2 border-gray-100 pb-2.5 mb-6">
            <span class="bg-[#298752]/10 text-[#298752] w-7 h-7 rounded-full inline-flex items-center justify-center text-[14px]">4</span> Konfirmasi Akhir
          </div>

          <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6">
            <h4 class="font-bold text-[#064e3b] text-[14px] mb-4">Ringkasan Data Formulir</h4>
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
                <label class="text-gray-400 font-medium">Email Kontak Wali</label>
                <p id="sum-email" class="text-gray-800 font-bold mt-1">-</p>
              </div>
            </div>
          </div>

          <!-- Checkbox agreement -->
          <div class="mt-8 flex gap-2.5 bg-emerald-50 border border-emerald-200 p-4 rounded-xl">
            <input type="checkbox" id="terms_agree" required class="w-[18px] h-[18px] mt-0.5 cursor-pointer">
            <label for="terms_agree" class="text-[13px] text-emerald-800 leading-[18px] cursor-pointer">
              Saya mengonfirmasi bahwa seluruh informasi dan berkas dokumen yang diunggah adalah sah, benar, dan sesuai dengan berkas aslinya.
            </label>
          </div>

          <div class="flex justify-between mt-10 border-t border-gray-100 pt-5">
            <button type="button" onclick="goToStep(3)" class="px-7 py-3.5 text-[14px] font-bold rounded-xl cursor-pointer transition-all duration-300 bg-white border border-gray-300 text-gray-600 hover:bg-gray-50">Sebelumnya</button>
            <button type="submit" class="px-7 py-3.5 text-[14px] font-bold rounded-xl cursor-pointer transition-all duration-300 bg-[#064e3b] text-white shadow-[0_4px_10px_rgba(6,78,59,0.2)]">Kirim Pendaftaran</button>
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
        // Validate current inputs using HTML5 built-in validation
        const currentPane = document.getElementById(`step-pane-${currentStep}`);
        const allInputs = currentPane.querySelectorAll('input, select, textarea');

        for (let input of allInputs) {
          if (!input.checkValidity()) {
            input.reportValidity();
            return;
          }
        }

        // Extra custom validation per step
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
          const nisn = document.getElementById('nisn').value;
          if (!/^[0-9]{10}$/.test(nisn)) {
            alert('NISN harus tepat 10 digit angka.\nContoh: 0012345678');
            document.getElementById('nisn').focus();
            return;
          }
          const nama = document.getElementById('nama_murid').value.trim();
          if (nama.length < 3 || !/^[a-zA-Z\s\.,\']+$/.test(nama)) {
            alert('Nama murid minimal 3 karakter dan hanya boleh berisi huruf.');
            document.getElementById('nama_murid').focus();
            return;
          }
          const tempat = document.getElementById('tempat_lahir').value.trim();
          if (tempat.length < 3 || !/^[a-zA-Z\s]+$/.test(tempat)) {
            alert('Tempat lahir minimal 3 karakter dan hanya boleh berisi huruf.\nContoh: Karanganyar');
            document.getElementById('tempat_lahir').focus();
            return;
          }
          const alamat = document.getElementById('alamat').value.trim();
          if (alamat.length < 10) {
            alert('Alamat terlalu pendek, minimal 10 karakter.\nContoh: Dusun Ngasem, RT 01/RW 02, Kel. Lalung, Kec. Karanganyar');
            document.getElementById('alamat').focus();
            return;
          }
        }

        if (currentStep === 2) {
          const namaAyah = document.getElementById('nama_ayah').value.trim();
          if (namaAyah.length < 3 || !/^[a-zA-Z\s\.,\']+$/.test(namaAyah)) {
            alert('Nama ayah minimal 3 karakter dan hanya boleh berisi huruf.');
            document.getElementById('nama_ayah').focus();
            return;
          }
          const namaIbu = document.getElementById('nama_ibu').value.trim();
          if (namaIbu.length < 3 || !/^[a-zA-Z\s\.,\']+$/.test(namaIbu)) {
            alert('Nama ibu minimal 3 karakter dan hanya boleh berisi huruf.');
            document.getElementById('nama_ibu').focus();
            return;
          }
          const telpAyah = document.getElementById('nomor_telpon_ayah').value.trim();
          if (telpAyah && !/^(08|62)[0-9]{8,13}$/.test(telpAyah)) {
            alert('No. telpon ayah harus format Indonesia.\nContoh: 081234567890');
            document.getElementById('nomor_telpon_ayah').focus();
            return;
          }
          const telpIbu = document.getElementById('nomor_telpon_ibu').value.trim();
          if (telpIbu && !/^(08|62)[0-9]{8,13}$/.test(telpIbu)) {
            alert('No. telpon ibu harus format Indonesia.\nContoh: 081234567890');
            document.getElementById('nomor_telpon_ibu').focus();
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

      document.getElementById('sum-email').innerText = document.getElementById('email_ibu').value || '-';
    }

    document.getElementById('registerForm').addEventListener('submit', function(e) {
      if (!document.getElementById('terms_agree').checked) {
        e.preventDefault();
        alert('Anda harus mencentang konfirmasi data terlebih dahulu!');
      }
    });
  </script>
@endsection
