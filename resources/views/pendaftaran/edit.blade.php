@extends('layouts.landing')

@section('title', 'Ubah Data Pendaftaran - PMBM MIN 3 Karanganyar')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/landing/home/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/landing/home/style.css') }}">
  <style>
    .register-container {
      max-width: 800px;
      margin: 0 auto;
      position: absolute;
      left: calc(50% - 400px);
      top: 150px;
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.05);
      padding: 40px;
      z-index: 20;
    }

    .form-header {
      text-align: center;
      margin-bottom: 40px;
    }

    .form-header h1 {
      color: #064e3b;
      font-size: 28px;
      font-family: 'PlusJakartaSans-ExtraBold', sans-serif;
      margin-bottom: 10px;
    }

    .form-header p {
      color: #6b7280;
      font-size: 14px;
    }

    /* Stepper */
    .stepper {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 40px;
      position: relative;
    }

    .stepper::before {
      content: '';
      position: absolute;
      top: 20px;
      left: 0;
      right: 0;
      height: 4px;
      background: #e5e7eb;
      z-index: 1;
    }

    .stepper-progress {
      position: absolute;
      top: 20px;
      left: 0;
      height: 4px;
      background: #298752;
      z-index: 1;
      transition: width 0.3s ease;
      width: 0%;
    }

    .step {
      position: relative;
      z-index: 2;
      display: flex;
      flex-direction: column;
      align-items: center;
      flex: 1;
    }

    .step-circle {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: #e5e7eb;
      color: #6b7280;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      border: 4px solid #ffffff;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
    }

    .step.active .step-circle {
      background: #298752;
      color: #ffffff;
      transform: scale(1.1);
    }

    .step.completed .step-circle {
      background: #064e3b;
      color: #ffffff;
    }

    .step-label {
      margin-top: 10px;
      font-size: 12px;
      font-weight: 700;
      color: #9ca3af;
    }

    .step.active .step-label {
      color: #298752;
    }

    .step.completed .step-label {
      color: #064e3b;
    }

    /* Form Fields */
    .form-step {
      display: none;
    }

    .form-step.active {
      display: block;
    }

    .section-title {
      font-size: 18px;
      font-weight: bold;
      color: #064e3b;
      border-bottom: 2px solid #f3f4f6;
      padding-bottom: 10px;
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .section-title span {
      background: rgba(41, 135, 82, 0.1);
      color: #298752;
      width: 28px;
      height: 28px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
    }

    .form-grid {
      display: grid;
      grid-template-cols: 1fr 1fr;
      gap: 20px;
    }

    .full-width {
      grid-column: span 2;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .form-group label {
      font-size: 12px;
      font-weight: bold;
      color: #4b5563;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .form-group input, .form-group select, .form-group textarea {
      padding: 12px 16px;
      border: 1px solid #d1d5db;
      border-radius: 10px;
      font-size: 14px;
      font-family: inherit;
      background: #f9fafb;
      transition: all 0.3s ease;
      outline: none;
    }

    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
      border-color: #298752;
      background: #ffffff;
      box-shadow: 0 0 0 3px rgba(41, 135, 82, 0.1);
    }

    /* Buttons */
    .button-group {
      display: flex;
      justify-content: space-between;
      margin-top: 40px;
      border-top: 1px solid #f3f4f6;
      padding-top: 20px;
    }

    .btn {
      padding: 14px 28px;
      font-size: 14px;
      font-weight: bold;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-prev {
      background: #ffffff;
      border: 1px solid #d1d5db;
      color: #4b5563;
    }

    .btn-prev:hover {
      background: #f9fafb;
    }

    .btn-next {
      background: #298752;
      color: #ffffff;
      box-shadow: 0 4px 10px rgba(41, 135, 82, 0.2);
    }

    .btn-next:hover {
      background: #064e3b;
    }

    .btn-submit {
      background: #064e3b;
      color: #ffffff;
      box-shadow: 0 4px 10px rgba(6, 78, 59, 0.2);
    }

    /* Document upload cards */
    .upload-card {
      background: #f9fafb;
      border: 1px dashed #d1d5db;
      border-radius: 12px;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .upload-card label {
      font-weight: bold;
      font-size: 13px;
      color: #374151;
    }

    .upload-card input[type="file"] {
      font-size: 12px;
    }

    /* Alert */
    .error-alert {
      background: #fee2e2;
      border: 1px solid #fca5a5;
      color: #b91c1c;
      padding: 16px;
      border-radius: 12px;
      font-size: 13px;
      margin-bottom: 24px;
    }

    /* Summary Card */
    .summary-card {
      background: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 16px;
      padding: 24px;
    }

    .summary-grid {
      display: grid;
      grid-template-cols: 1fr 1fr;
      gap: 16px;
      font-size: 13px;
    }

    .summary-item label {
      color: #9ca3af;
      font-weight: 500;
    }

    .summary-item p {
      color: #1f2937;
      font-weight: bold;
      margin-top: 4px;
    }
  </style>
@endsection

@section('content')
  <div class="dashboard-pmbm-min-3-kra" style="min-height: 1550px;">
    <!-- Landing Navbar Included -->
    @include('components.navbar', ['activeFolder' => 'cek-kelulusan'])

    <div class="register-container">
    <div class="form-header">
      <h1>Ubah Data Pendaftaran</h1>
      <p>Perbarui informasi dan unggah ulang berkas yang salah untuk memproses verifikasi kembali.</p>
    </div>

    <!-- Rejection Note Alert -->
    <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; padding: 20px; border-radius: 12px; margin-bottom: 24px; font-family: sans-serif;">
      <h3 style="font-weight: bold; margin-bottom: 8px; font-size: 15px; color: #b91c1c; display: flex; align-items: center; gap: 8px;">
        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        Catatan Penolakan dari Tata Usaha
      </h3>
      <p style="font-size: 14px; font-weight: bold; background: #ffffff; padding: 12px; border-radius: 8px; border-left: 4px solid #ef4444; margin-top: 8px; color: #374151;">
        "{{ $pendaftaran->alasan_ditolak }}"
      </p>
      <p style="font-size: 12px; margin-top: 12px; color: #7f1d1d;">
        Silakan perbaiki data yang belum sesuai dan/atau unggah berkas baru yang diminta pada bagian dokumen di bawah.
      </p>
    </div>

    @if($errors->any())
      <div class="error-alert">
        <p style="font-weight: bold; margin-bottom: 8px;">Terjadi kesalahan pengisian form:</p>
        <ul style="list-style: disc; padding-left: 20px;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Stepper Header -->
    <div class="stepper">
      <div class="stepper-progress" id="progressBar"></div>
      
      <div class="step active" id="step-tab-1">
        <div class="step-circle">1</div>
        <div class="step-label">Data Calon Murid</div>
      </div>
      <div class="step" id="step-tab-2">
        <div class="step-circle">2</div>
        <div class="step-label">Data Orang Tua</div>
      </div>
      <div class="step" id="step-tab-3">
        <div class="step-circle">3</div>
        <div class="step-label">Berkas Dokumen</div>
      </div>
      <div class="step" id="step-tab-4">
        <div class="step-circle">4</div>
        <div class="step-label">Konfirmasi</div>
      </div>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('student.update', $pendaftaran->id_pendaftaran) }}" method="POST" enctype="multipart/form-data" id="registerForm">
      @csrf

      <!-- Step 1: Student Data -->
      <div class="form-step active" id="step-pane-1">
        <div class="section-title">
          <span>1</span> Data Calon Murid
        </div>
        <div class="form-grid">
          <div class="form-group full-width">
            <label for="nama_murid">Nama Lengkap Murid <span style="color: red;">*</span></label>
            <input type="text" name="nama_murid" id="nama_murid" required value="{{ old('nama_murid', $student->nama_murid) }}" placeholder="Masukkan nama lengkap siswa">
          </div>
          <div class="form-group">
            <label for="nik">NIK (Nomor Induk Kependudukan) <span style="color: red;">*</span></label>
            <input type="text" name="nik" id="nik" required minlength="16" maxlength="16" pattern="[0-9]{16}" title="NIK harus tepat 16 digit angka" value="{{ old('nik', $student->nik) }}" placeholder="Masukkan 16 digit NIK" inputmode="numeric">
          </div>
          <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin <span style="color: red;">*</span></label>
            <select name="jenis_kelamin" id="jenis_kelamin" required>
              <option value="">-- Pilih Jenis Kelamin --</option>
              <option value="L" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
              <option value="P" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
          </div>
          <div class="form-group">
            <label for="nisn">NISN <span style="color: red;">*</span></label>
            <input type="text" name="nisn" id="nisn" required minlength="10" maxlength="10" pattern="[0-9]{10}" title="NISN harus tepat 10 digit angka" value="{{ old('nisn', $student->nisn) }}" placeholder="Masukkan 10 digit NISN" inputmode="numeric">
          </div>
          <div class="form-group">
            <label for="id_program">Pilihan Program Kelas <span style="color: red;">*</span></label>
            <select name="id_program" id="id_program" required>
              <option value="">-- Pilih Program --</option>
              @foreach($programs as $program)
                <option value="{{ $program->id_program }}" {{ old('id_program', $pendaftaran->id_program) == $program->id_program ? 'selected' : '' }}>
                  {{ $program->nama_program }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="tempat_lahir">Tempat Lahir <span style="color: red;">*</span></label>
            <input type="text" name="tempat_lahir" id="tempat_lahir" required minlength="3" maxlength="100" pattern="[a-zA-Z\s]+" title="Hanya huruf dan spasi" value="{{ old('tempat_lahir', $student->tempat_lahir) }}" placeholder="Contoh: Karanganyar">
          </div>
          <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir <span style="color: red;">*</span></label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" required value="{{ old('tanggal_lahir', $student->tanggal_lahir) }}">
          </div>
          <div class="form-group full-width">
            <label for="alamat">Alamat Lengkap Rumah <span style="color: red;">*</span></label>
            <textarea name="alamat" id="alamat" rows="3" required placeholder="Dusun, RT/RW, Kelurahan, Kecamatan, Kabupaten">{{ old('alamat', $student->alamat) }}</textarea>
          </div>
        </div>

        <div class="button-group">
          <div></div> <!-- Spacer -->
          <button type="button" class="btn btn-next" onclick="goToStep(2)">Selanjutnya ➔</button>
        </div>
      </div>

      <!-- Step 2: Parents Data -->
      <div class="form-step" id="step-pane-2">
        <div class="section-title">
          <span>2</span> Data Orang Tua / Wali
        </div>
        
        <div class="form-grid">
          <!-- Ayah -->
          <div class="form-group full-width">
            <h3 style="font-weight: bold; color: #374151; font-size: 14px; margin-bottom: 10px; border-left: 4px solid #298752; padding-left: 10px;">DATA AYAH KANDUNG</h3>
          </div>
          <div class="form-group">
            <label for="nama_ayah">Nama Lengkap Ayah <span style="color: red;">*</span></label>
            <input type="text" name="nama_ayah" id="nama_ayah" required value="{{ old('nama_ayah', $ayah->nama_ayah) }}" placeholder="Nama lengkap Ayah">
          </div>
          <div class="form-group">
            <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
            <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $ayah->pekerjaan) }}" placeholder="Contoh: Wiraswasta, PNS">
          </div>
          <div class="form-group">
            <label for="nomor_telpon_ayah">No. Telpon/WhatsApp Ayah</label>
            <input type="text" name="nomor_telpon_ayah" id="nomor_telpon_ayah" value="{{ old('nomor_telpon_ayah', $ayah->nomor_telpon) }}" placeholder="08xxxxxxxxxx">
          </div>
          <div class="form-group">
            <label for="email_ayah">Email Ayah</label>
            <input type="email" name="email_ayah" id="email_ayah" value="{{ old('email_ayah', $ayah->email) }}" placeholder="ayah@gmail.com">
          </div>
          
          <!-- Ibu -->
          <div class="form-group full-width" style="margin-top: 20px;">
            <h3 style="font-weight: bold; color: #374151; font-size: 14px; margin-bottom: 10px; border-left: 4px solid #298752; padding-left: 10px;">DATA IBU KANDUNG</h3>
          </div>
          <div class="form-group">
            <label for="nama_ibu">Nama Lengkap Ibu <span style="color: red;">*</span></label>
            <input type="text" name="nama_ibu" id="nama_ibu" required value="{{ old('nama_ibu', $ibu->nama_ibu) }}" placeholder="Nama lengkap Ibu">
          </div>
          <div class="form-group">
            <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
            <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $ibu->pekerjaan) }}" placeholder="Contoh: Ibu Rumah Tangga">
          </div>
          <div class="form-group">
            <label for="nomor_telpon_ibu">No. Telpon/WhatsApp Ibu</label>
            <input type="text" name="nomor_telpon_ibu" id="nomor_telpon_ibu" value="{{ old('nomor_telpon_ibu', $ibu->nomor_telpon) }}" placeholder="08xxxxxxxxxx">
          </div>
          <div class="form-group">
            <label for="email_ibu">Email Kontak Wali <span style="color: red;">*</span></label>
            <input type="email" name="email_ibu" id="email_ibu" required value="{{ old('email_ibu', $ibu->email) }}" placeholder="kontak_wali@gmail.com">
          </div>
        </div>

        <div class="button-group">
          <button type="button" class="btn btn-prev" onclick="goToStep(1)">Sebelumnya</button>
          <button type="button" class="btn btn-next" onclick="goToStep(3)">Selanjutnya ➔</button>
        </div>
      </div>

      <!-- Step 3: Documents Upload -->
      <div class="form-step" id="step-pane-3">
        <div class="section-title">
          <span>3</span> Unggah Berkas Pendaftaran
        </div>
        <p style="font-size: 12px; color: #6b7280; margin-bottom: 20px;">Lakukan unggah file baru *hanya* jika Anda ingin mengubah atau memperbaiki berkas yang saat ini terunggah.</p>
        
        <div class="form-grid">
          <div class="upload-card">
            <label for="pas_foto">Pas Foto Berwarna</label>
            <input type="file" name="pas_foto" id="pas_foto" accept="image/*">
            <p style="font-size: 10px; color: #9ca3af;">Format: JPG, JPEG, PNG (Maks. 5MB)</p>
            @if($student->pas_foto)
              <div style="font-size: 11px; margin-top: 4px; background: rgba(41,135,82,0.06); padding: 6px; border-radius: 6px;">
                📂 Berkas saat ini: <a href="{{ asset($student->pas_foto) }}" target="_blank" style="color: #298752; font-weight: bold; text-decoration: underline;">Lihat Pas Foto</a>
              </div>
            @endif
          </div>
          
          <div class="upload-card">
            <label for="kartu_keluarga">Kartu Keluarga (KK)</label>
            <input type="file" name="kartu_keluarga" id="kartu_keluarga" accept=".pdf,image/*">
            <p style="font-size: 10px; color: #9ca3af;">Format: PDF, PNG, JPG (Maks. 5MB)</p>
            @if($student->kartu_keluarga)
              <div style="font-size: 11px; margin-top: 4px; background: rgba(41,135,82,0.06); padding: 6px; border-radius: 6px;">
                📂 Berkas saat ini: <a href="{{ asset($student->kartu_keluarga) }}" target="_blank" style="color: #298752; font-weight: bold; text-decoration: underline;">Lihat Kartu Keluarga</a>
              </div>
            @endif
          </div>
          
          <div class="upload-card">
            <label for="akta_kelahiran">Akta Kelahiran</label>
            <input type="file" name="akta_kelahiran" id="akta_kelahiran" accept=".pdf,image/*">
            <p style="font-size: 10px; color: #9ca3af;">Format: PDF, PNG, JPG (Maks. 5MB)</p>
            @if($student->akta_kelahiran)
              <div style="font-size: 11px; margin-top: 4px; background: rgba(41,135,82,0.06); padding: 6px; border-radius: 6px;">
                📂 Berkas saat ini: <a href="{{ asset($student->akta_kelahiran) }}" target="_blank" style="color: #298752; font-weight: bold; text-decoration: underline;">Lihat Akta Kelahiran</a>
              </div>
            @endif
          </div>
          
          <div class="upload-card">
            <label for="kartu_identitas_anak">Kartu Identitas Anak (KIA)</label>
            <input type="file" name="kartu_identitas_anak" id="kartu_identitas_anak" accept=".pdf,image/*">
            <p style="font-size: 10px; color: #9ca3af;">Format: PDF, PNG, JPG (Maks. 5MB)</p>
            @if($student->kartu_identitas_anak)
              <div style="font-size: 11px; margin-top: 4px; background: rgba(41,135,82,0.06); padding: 6px; border-radius: 6px;">
                📂 Berkas saat ini: <a href="{{ asset($student->kartu_identitas_anak) }}" target="_blank" style="color: #298752; font-weight: bold; text-decoration: underline;">Lihat KIA</a>
              </div>
            @endif
          </div>
        </div>

        <div class="button-group">
          <button type="button" class="btn btn-prev" onclick="goToStep(2)">Sebelumnya</button>
          <button type="button" class="btn btn-next" onclick="goToStep(4)">Selanjutnya ➔</button>
        </div>
      </div>

      <!-- Step 4: Summary & Confirm -->
      <div class="form-step" id="step-pane-4">
        <div class="section-title">
          <span>4</span> Konfirmasi Perubahan
        </div>

        <div class="summary-card">
          <h4 style="font-weight: bold; color: #064e3b; font-size: 14px; margin-bottom: 16px;">Ringkasan Perubahan Data Formulir</h4>
          <div class="summary-grid">
            <div class="summary-item">
              <label>Nama Calon Murid</label>
              <p id="sum-name">-</p>
            </div>
            <div class="summary-item">
              <label>Jenis Kelamin</label>
              <p id="sum-gender">-</p>
            </div>
            <div class="summary-item">
              <label>NIK</label>
              <p id="sum-nik">-</p>
            </div>
            <div class="summary-item">
              <label>NISN</label>
              <p id="sum-nisn">-</p>
            </div>
            <div class="summary-item">
              <label>Tempat, Tanggal Lahir</label>
              <p id="sum-ttl">-</p>
            </div>
            <div class="summary-item">
              <label>Program Pilihan</label>
              <p id="sum-program">-</p>
            </div>
            <div class="summary-item">
              <label>Nama Ayah / Ibu</label>
              <p id="sum-parents">-</p>
            </div>
            <div class="summary-item">
              <label>Email Kontak Wali</label>
              <p id="sum-email">-</p>
            </div>
          </div>
        </div>

        <!-- Checkbox agreement -->
        <div style="margin-top: 30px; display: flex; gap: 10px; background: #ecfdf5; border: 1px solid #a7f3d0; padding: 16px; border-radius: 12px;">
          <input type="checkbox" id="terms_agree" required style="width: 18px; height: 18px; margin-top: 2px; cursor: pointer;">
          <label for="terms_agree" style="font-size: 13px; color: #065f46; line-height: 18px; cursor: pointer;">
            Saya mengonfirmasi bahwa perubahan data dan berkas dokumen yang diperbarui adalah sah, benar, dan sesuai dengan dokumen aslinya.
          </label>
        </div>

        <div class="button-group">
          <button type="button" class="btn btn-prev" onclick="goToStep(3)">Sebelumnya</button>
          <button type="submit" class="btn btn-submit">Simpan Perubahan & Ajukan Kembali</button>
        </div>
      </div>
    </form>
  </div>

  <!-- Shared Footer Component -->
  @include('components.footer', ['activeFolder' => 'cek-kelulusan'])
  </div>
@endsection

@section('scripts')
  <script>
    let currentStep = 1;
    const totalSteps = 4;

    function goToStep(stepNum) {
      if (stepNum > currentStep) {
        // Validate current inputs
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
        document.getElementById(`step-tab-${i}`).classList.remove('active', 'completed');
        
        if (i < stepNum) {
          document.getElementById(`step-tab-${i}`).classList.add('completed');
        }
      }

      // Show target step pane
      document.getElementById(`step-pane-${stepNum}`).classList.add('active');
      document.getElementById(`step-tab-${stepNum}`).classList.add('active');

      // Update progress bar width
      const progressWidth = ((stepNum - 1) / (totalSteps - 1)) * 100;
      document.getElementById('progressBar').style.width = `${progressWidth}%`;

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
