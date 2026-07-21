@extends('layouts.admin')

@section('title', 'Kelola Kontak - CMS PMBM')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/admin/landing-manage/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/landing-manage/style.css') }}">
  <style>
    .input-field {
      width: 100%;
      height: 40px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      padding: 10px 15px;
      font-family: inherit;
      font-size: 13px;
      outline: none;
      background: #ffffff;
      margin-top: 5px;
    }
    .input-field:focus {
      border-color: #298752;
    }
    .btn-submit {
      padding: 10px 20px;
      background: #298752;
      color: #ffffff;
      font-weight: bold;
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      cursor: pointer;
      font-size: 13px;
      border: none;
    }
    .btn-submit:hover {
      background: #064e3b;
    }
    .program-table-container {
      border: 1px solid #becabe;
      border-radius: 8px;
      margin-top: 15px;
      background-color: #ffffff;
      width: 100%;
      overflow-x: auto;
    }
    .program-table {
      width: 100%;
      border-collapse: collapse;
      font-family: inherit;
      font-size: 13px;
      text-align: left;
    }
    .program-table th {
      background-color: #f0fdf4;
      color: #064e3b;
      font-weight: bold;
      font-size: 11px;
      text-transform: uppercase;
      padding: 12px 16px;
      border-bottom: 2px solid #becabe;
    }
    .program-table td {
      padding: 12px 16px;
      border-bottom: 1px solid #e5e7eb;
      color: #374151;
      vertical-align: middle;
    }
    .program-table tr:hover td {
      background-color: #f9fafb;
    }

    /* Modal Styling */
    .modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(4px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }
    
    .modal-content {
      width: 90%;
      max-width: 480px;
      background: linear-gradient(135deg, #005b31 0%, #064e3b 100%);
      border-radius: 16px;
      padding: 30px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
      color: #ffffff;
      font-family: 'Plus Jakarta Sans', sans-serif;
      box-sizing: border-box;
      animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
      from { transform: scale(0.9); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    .modal-content h3 {
      font-size: 20px;
      font-weight: bold;
      color: #ffffff !important;
      margin-top: 0;
      margin-bottom: 20px;
      text-align: center;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      padding-bottom: 12px;
    }

    .modal-content label {
      font-size: 12px;
      font-weight: bold;
      color: rgba(255, 255, 255, 0.9);
      display: block;
      margin-bottom: 6px;
      text-align: left;
    }

    .modal-content .form-group {
      margin-bottom: 16px;
      text-align: left;
    }

    .modal-content .input-field {
      width: 100% !important;
      background: linear-gradient(180deg, #ffffff 0%, #f3f4f6 100%) !important;
      border: 1px solid rgba(255, 255, 255, 0.8) !important;
      border-radius: 8px !important;
      color: #1f2937 !important;
      font-size: 14px !important;
      padding: 10px 14px !important;
      box-sizing: border-box !important;
      outline: none !important;
      transition: all 0.2s;
    }

    .modal-content .input-field:focus {
      border-color: #93f4b0 !important;
      box-shadow: 0 0 0 3px rgba(147, 244, 176, 0.3) !important;
    }

    .modal-content .btn-submit {
      background: #ffffff !important;
      color: #064e3b !important;
      padding: 10px 20px !important;
      border-radius: 8px !important;
      font-weight: bold !important;
      border: none !important;
      cursor: pointer !important;
      transition: all 0.2s !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
    }
    
    .modal-content .btn-submit:hover {
      background: #dcfce7 !important;
      transform: translateY(-1px);
    }

    .modal-content .btn-cancel {
      background: rgba(255, 255, 255, 0.1) !important;
      color: #ffffff !important;
      border: 1px solid rgba(255, 255, 255, 0.3) !important;
      padding: 10px 20px !important;
      border-radius: 8px !important;
      font-weight: bold !important;
      cursor: pointer !important;
      transition: all 0.2s !important;
    }

    .modal-content .btn-cancel:hover {
      background: rgba(255, 255, 255, 0.2) !important;
    }
  </style>
@endsection

@section('content')
  <div class="desktop-15" style="overflow-y: auto; height: auto; min-height: 100vh; padding-bottom: 60px;">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'contacts'])

    <!-- Main Content Wrapper -->
    <div style="position: absolute; left: 380px; top: 180px; right: 40px; display: flex; flex-direction: column; gap: 24px; z-index: 10;">
      
      <!-- Messages Flash -->
      @if(session('success'))
        <div style="padding: 10px 15px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; font-family: sans-serif; font-size: 12px; border-radius: 6px; width: 100%;">
          {{ session('success') }}
        </div>
      @endif
      
      <div style="background: #ffffff; border-radius: 12px; border: 1px solid #becabe; padding: 24px; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; gap: 20px;">
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #f0fdf4; padding-bottom: 12px; flex-wrap: wrap; gap: 10px;">
          <div style="font-weight: bold; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 16px; color: #064e3b; display: flex; align-items: center; gap: 8px;">
            <span>📞</span> Kelola Kontak &amp; Media Sosial Sekolah
          </div>
          <button type="button" class="btn-submit" onclick="openCreateContactModal()" style="height: 36px; padding: 0 16px; font-size: 12px;">
            + Tambah Kontak Baru
          </button>
        </div>

        <div class="program-table-container">
          <table class="program-table">
            <thead>
              <tr>
                <th style="width: 20%;">Platform / Media</th>
                <th style="width: 25%;">Nilai / Kontak</th>
                <th style="width: 30%;">Tautan Link</th>
                <th style="width: 15%;">Ikon (Icon)</th>
                <th style="width: 10%; text-align: center;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($contacts as $con)
                <tr>
                  <td style="font-weight: bold; color: #121c2a;">{{ $con->platform_name }}</td>
                  <td style="color: #374151; font-weight: 600;">{{ $con->value }}</td>
                  <td style="color: #4b5563; word-break: break-all;"><a href="{{ $con->link }}" target="_blank" style="color: #298752; text-decoration: underline;">{{ $con->link }}</a></td>
                  <td style="color: #6b7280; font-family: monospace;">{{ $con->icon ?? '-' }}</td>
                  <td>
                    <div style="display: flex; gap: 12px; justify-content: center; align-items: center;">
                      <button type="button" onclick="openEditContactModal('{{ $con->id }}', '{{ addslashes($con->platform_name) }}', '{{ addslashes($con->value) }}', '{{ addslashes($con->link) }}', '{{ $con->icon }}')" style="color: #298752; font-weight: bold; cursor: pointer; background: none; border: none; font-family: inherit; font-size: 13px;">Edit</button>
                      <form action="{{ route('tata_usaha.contacts.delete', $con->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kontak ini?')" style="margin: 0; padding: 0;">
                        @csrf
                        <button type="submit" style="color: #ef4444; font-weight: bold; cursor: pointer; background: none; border: none; font-family: inherit; font-size: 13px;">Hapus</button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" style="text-align: center; color: #9ca3af; padding: 20px;">Belum ada data kontak. Silakan tambah kontak baru.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- WhatsApp Group Link Management Card -->
      <div style="background: #ffffff; border-radius: 12px; border: 1px solid #becabe; padding: 24px; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; gap: 16px;">
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #f0fdf4; padding-bottom: 12px;">
          <div style="font-weight: bold; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 16px; color: #064e3b; display: flex; align-items: center; gap: 8px;">
            <span>💬</span> Link Grup WhatsApp Calon Wali Murid
          </div>
        </div>

        <p style="font-size: 12px; color: #6b7280; margin: 0;">Kelola tautan grup WhatsApp yang akan ditampilkan kepada calon siswa pada tahap pendaftaran awal, saat lulus seleksi, dan saat konfirmasi ulang (diterima).</p>

        <form action="{{ route('tata_usaha.content.update_text') }}" method="POST" style="display: flex; flex-direction: column; gap: 16px;">
          @csrf
          
          <!-- Link 1: Pendaftaran Awal -->
          <div style="display: flex; flex-direction: column; gap: 4px;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 4px;">
              <label style="font-size: 11px; font-weight: bold; color: #4b5563; text-transform: uppercase; display: block;">1. Tautan Grup WhatsApp PMBM (Pendaftaran Awal)</label>
              @if(!empty($whatsappGroupLink))
                <a href="{{ $whatsappGroupLink }}" target="_blank" style="font-size: 11px; font-weight: bold; color: #005b31; text-decoration: underline; display: inline-flex; align-items: center; gap: 3px;">
                  ↗ Buka Link Grup WA Pendaftaran Awal
                </a>
              @endif
            </div>
            <div style="display: flex; gap: 8px; align-items: center;">
              <input type="url" id="wa_group_link_1" name="whatsapp_group_link" value="{{ $whatsappGroupLink ?? '' }}" placeholder="Contoh: https://chat.whatsapp.com/grup-pendaftaran"
                     style="flex: 1; width: 100%; padding: 10px 14px; border: 1px solid #becabe; border-radius: 8px; font-size: 13px; outline: none; font-family: inherit; box-sizing: border-box;">
              @if(!empty($whatsappGroupLink))
                <a href="{{ $whatsappGroupLink }}" target="_blank" style="background: #005b31; color: white; padding: 10px 16px; border-radius: 8px; font-size: 12px; font-weight: bold; text-decoration: none; white-space: nowrap; display: inline-flex; align-items: center; gap: 4px;">
                  ↗ Kunjungi Link
                </a>
              @endif
            </div>
            <span style="font-size: 11px; color: #6b7280;">Diberikan kepada pendaftar baru setelah berhasil mengisi formulir pendaftaran online.</span>
          </div>

          <!-- Link 2: Lulus Seleksi -->
          <div style="display: flex; flex-direction: column; gap: 4px;">
            <label style="font-size: 11px; font-weight: bold; color: #047857; text-transform: uppercase; display: block;">2. Tautan Grup WhatsApp Lulus Seleksi</label>
            <input type="url" name="whatsapp_group_lulus_link" value="{{ $whatsappGroupLulusLink ?? '' }}" placeholder="Contoh: https://chat.whatsapp.com/grup-lulus-seleksi"
                   style="width: 100%; padding: 10px 14px; border: 1px solid #becabe; border-radius: 8px; font-size: 13px; outline: none; font-family: inherit; box-sizing: border-box;">
            <span style="font-size: 11px; color: #6b7280;">Diberikan pada halaman Cek Status Kelulusan bagi pendaftar dengan status <strong>Lulus Seleksi</strong> (sebelum daftar ulang).</span>
          </div>

          <!-- Link 3: Diterima / Konfirmasi Ulang -->
          <div style="display: flex; flex-direction: column; gap: 4px;">
            <label style="font-size: 11px; font-weight: bold; color: #1e40af; text-transform: uppercase; display: block;">3. Tautan Grup WhatsApp Resmi / Konfirmasi Ulang (Diterima)</label>
            <input type="url" name="whatsapp_group_diterima_link" value="{{ $whatsappGroupDiterimaLink ?? '' }}" placeholder="Contoh: https://chat.whatsapp.com/grup-resmi-murid-baru"
                   style="width: 100%; padding: 10px 14px; border: 1px solid #becabe; border-radius: 8px; font-size: 13px; outline: none; font-family: inherit; box-sizing: border-box;">
            <span style="font-size: 11px; color: #6b7280;">Diberikan pada halaman Cek Status Kelulusan bagi siswa yang telah <strong>Diterima &amp; Selesai Daftar Ulang</strong>.</span>
          </div>

          <div style="display: flex; justify-content: flex-end; margin-top: 4px;">
            <button type="submit" style="background: #064e3b; color: #ffffff; padding: 10px 24px; border-radius: 8px; cursor: pointer; border: none; font-weight: bold; font-size: 13px; font-family: inherit; white-space: nowrap;">
              Simpan Semua Link Grup WhatsApp
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>

  <!-- Tambah Kontak Modal Form -->
  <div class="modal" id="createContactModal">
    <div class="modal-content">
      <h3>Tambah Kontak / Medsos Baru</h3>
      
      <form action="{{ route('tata_usaha.contacts.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
          <label for="contact_platform_name">Platform / Media</label>
          <input type="text" name="platform_name" id="contact_platform_name" required placeholder="Contoh: WhatsApp, Instagram, Telepon" class="input-field">
        </div>
        
        <div class="form-group">
          <label for="contact_value">Nilai / Kontak (Display Value)</label>
          <input type="text" name="value" id="contact_value" required placeholder="Contoh: @min3kra atau 0812..." class="input-field">
        </div>
 
        <div class="form-group">
          <label for="contact_link">Tautan URL Link</label>
          <input type="text" name="link" id="contact_link" required placeholder="Contoh: https://wa.me/628..." class="input-field">
        </div>
 
        <div class="form-group">
          <label for="contact_icon">Nama Ikon (Bootstrap Icon Name)</label>
          <input type="text" name="icon" id="contact_icon" placeholder="Contoh: whatsapp, instagram, phone, envelope" class="input-field">
          <small style="font-size: 10px; color: rgba(255,255,255,0.7); display: block; margin-top: 4px;">Masukkan nama class Bootstrap icon (misal: 'whatsapp' untuk bi-whatsapp).</small>
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
          <button type="button" class="btn-cancel" onclick="closeCreateContactModal()">Batal</button>
          <button type="submit" class="btn-submit">Simpan Kontak</button>
        </div>
      </form>
    </div>
  </div>
 
  <!-- Edit Kontak Modal Form -->
  <div class="modal" id="editContactModal">
    <div class="modal-content">
      <h3>Ubah Kontak / Medsos</h3>
      
      <form id="editContactForm" method="POST">
        @csrf
        
        <div class="form-group">
          <label for="edit_contact_platform_name">Platform / Media</label>
          <input type="text" name="platform_name" id="edit_contact_platform_name" required placeholder="Platform/Media" class="input-field">
        </div>
        
        <div class="form-group">
          <label for="edit_contact_value">Nilai / Kontak (Display Value)</label>
          <input type="text" name="value" id="edit_contact_value" required placeholder="Kontak" class="input-field">
        </div>
 
        <div class="form-group">
          <label for="edit_contact_link">Tautan URL Link</label>
          <input type="text" name="link" id="edit_contact_link" required placeholder="URL Link" class="input-field">
        </div>
 
        <div class="form-group">
          <label for="edit_contact_icon">Nama Ikon (Bootstrap Icon Name)</label>
          <input type="text" name="icon" id="edit_contact_icon" placeholder="Bootstrap Icon Name" class="input-field">
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
          <button type="button" class="btn-cancel" onclick="closeEditContactModal()">Batal</button>
          <button type="submit" class="btn-submit">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    function openCreateContactModal() {
      document.getElementById('createContactModal').style.display = 'flex';
    }
    function closeCreateContactModal() {
      document.getElementById('createContactModal').style.display = 'none';
    }
    function openEditContactModal(id, platformName, value, link, icon) {
      document.getElementById('edit_contact_platform_name').value = platformName;
      document.getElementById('edit_contact_value').value = value;
      document.getElementById('edit_contact_link').value = link;
      document.getElementById('edit_contact_icon').value = icon || '';
      
      let updateRoute = "{{ route('tata_usaha.contacts.update', ':id') }}";
      updateRoute = updateRoute.replace(':id', id);
      document.getElementById('editContactForm').action = updateRoute;
      
      document.getElementById('editContactModal').style.display = 'flex';
    }
    function closeEditContactModal() {
      document.getElementById('editContactModal').style.display = 'none';
    }
  </script>
@endsection
