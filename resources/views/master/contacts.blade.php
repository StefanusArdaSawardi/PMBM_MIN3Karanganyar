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
    </div>
  </div>

  <!-- Tambah Kontak Modal Form -->
  <div class="modal" id="createContactModal">
    <div class="modal-content">
      <h3 style="font-weight: bold; color: #064e3b; margin-bottom: 20px; font-size: 16px;">Tambah Kontak / Medsos Baru</h3>
      
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
          <small style="font-size: 10px; color: #6b7280; display: block; margin-top: 4px;">Masukkan nama class Bootstrap icon (misal: 'whatsapp' untuk bi-whatsapp).</small>
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
          <button type="button" style="background: #f3f4f6; color: #4b5563; padding: 10px 15px; border-radius: 6px; cursor: pointer; border: 1px solid #d1d5db;" onclick="closeCreateContactModal()">Batal</button>
          <button type="submit" class="btn-submit">Simpan Kontak</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Kontak Modal Form -->
  <div class="modal" id="editContactModal">
    <div class="modal-content">
      <h3 style="font-weight: bold; color: #064e3b; margin-bottom: 20px; font-size: 16px;">Ubah Kontak / Medsos</h3>
      
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
          <button type="button" style="background: #f3f4f6; color: #4b5563; padding: 10px 15px; border-radius: 6px; cursor: pointer; border: 1px solid #d1d5db;" onclick="closeEditContactModal()">Batal</button>
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
