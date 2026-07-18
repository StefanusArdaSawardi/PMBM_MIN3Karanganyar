@extends('layouts.admin')

@section('title', 'Kelola FAQ - CMS PMBM')

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
    .textarea-field {
      width: 100%;
      height: 120px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      padding: 12px 15px;
      font-family: inherit;
      font-size: 13px;
      outline: none;
      background: #ffffff;
      resize: none;
      line-height: 1.5;
      margin-top: 5px;
    }
    .textarea-field:focus {
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
      vertical-align: top;
    }
    .program-table tr:hover td {
      background-color: #f9fafb;
    }
  </style>
@endsection

@section('content')
  <div class="desktop-15" style="overflow-y: auto; height: auto; min-height: 100vh; padding-bottom: 60px;">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'faqs'])

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
            <span>💬</span> Kelola FAQ Chatbot Calon Wali Murid
          </div>
          <button type="button" class="btn-submit" onclick="openCreateFaqModal()" style="height: 36px; padding: 0 16px; font-size: 12px;">
            + Tambah FAQ Baru
          </button>
        </div>

        <div class="program-table-container">
          <table class="program-table">
            <thead>
              <tr>
                <th style="width: 30%;">Pertanyaan</th>
                <th style="width: 55%;">Jawaban</th>
                <th style="width: 15%; text-align: center;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($faqs as $faq)
                <tr>
                  <td style="font-weight: bold; color: #121c2a;">{{ $faq->question }}</td>
                  <td style="color: #4b5563; line-height: 1.5;">{{ $faq->answer }}</td>
                  <td>
                    <div style="display: flex; gap: 12px; justify-content: center; align-items: center;">
                      <button type="button" onclick="openEditFaqModal('{{ $faq->id }}', '{{ addslashes($faq->question) }}', '{{ addslashes($faq->answer) }}')" style="color: #298752; font-weight: bold; cursor: pointer; background: none; border: none; font-family: inherit; font-size: 13px;">Edit</button>
                      <form action="{{ route('tata_usaha.faqs.delete', $faq->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')" style="margin: 0; padding: 0;">
                        @csrf
                        <button type="submit" style="color: #ef4444; font-weight: bold; cursor: pointer; background: none; border: none; font-family: inherit; font-size: 13px;">Hapus</button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" style="text-align: center; color: #9ca3af; padding: 20px;">Belum ada FAQ. Silakan tambah FAQ baru.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Tambah FAQ Modal Form -->
  <div class="modal" id="createFaqModal">
    <div class="modal-content">
      <h3 style="font-weight: bold; color: #064e3b; margin-bottom: 20px; font-size: 16px;">Tambah FAQ Baru</h3>
      
      <form action="{{ route('tata_usaha.faqs.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
          <label for="faq_question">Pertanyaan (Question)</label>
          <input type="text" name="question" id="faq_question" required placeholder="Contoh: Bagaimana cara daftar ulang?" class="input-field">
        </div>
        
        <div class="form-group">
          <label for="faq_answer">Jawaban (Answer)</label>
          <textarea name="answer" id="faq_answer" required placeholder="Tulis jawaban di sini..." class="textarea-field"></textarea>
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
          <button type="button" style="background: #f3f4f6; color: #4b5563; padding: 10px 15px; border-radius: 6px; cursor: pointer; border: 1px solid #d1d5db;" onclick="closeCreateFaqModal()">Batal</button>
          <button type="submit" class="btn-submit">Simpan FAQ</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit FAQ Modal Form -->
  <div class="modal" id="editFaqModal">
    <div class="modal-content">
      <h3 style="font-weight: bold; color: #064e3b; margin-bottom: 20px; font-size: 16px;">Ubah FAQ</h3>
      
      <form id="editFaqForm" method="POST">
        @csrf
        
        <div class="form-group">
          <label for="edit_faq_question">Pertanyaan (Question)</label>
          <input type="text" name="question" id="edit_faq_question" required placeholder="Pertanyaan" class="input-field">
        </div>
        
        <div class="form-group">
          <label for="edit_faq_answer">Jawaban (Answer)</label>
          <textarea name="answer" id="edit_faq_answer" required placeholder="Tulis jawaban..." class="textarea-field"></textarea>
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
          <button type="button" style="background: #f3f4f6; color: #4b5563; padding: 10px 15px; border-radius: 6px; cursor: pointer; border: 1px solid #d1d5db;" onclick="closeEditFaqModal()">Batal</button>
          <button type="submit" class="btn-submit">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    function openCreateFaqModal() {
      document.getElementById('createFaqModal').style.display = 'flex';
    }
    function closeCreateFaqModal() {
      document.getElementById('createFaqModal').style.display = 'none';
    }
    function openEditFaqModal(id, question, answer) {
      document.getElementById('edit_faq_question').value = question;
      document.getElementById('edit_faq_answer').value = answer;
      
      let updateRoute = "{{ route('tata_usaha.faqs.update', ':id') }}";
      updateRoute = updateRoute.replace(':id', id);
      document.getElementById('editFaqForm').action = updateRoute;
      
      document.getElementById('editFaqModal').style.display = 'flex';
    }
    function closeEditFaqModal() {
      document.getElementById('editFaqModal').style.display = 'none';
    }
  </script>
@endsection
