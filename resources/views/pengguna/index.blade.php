@extends('layouts.admin')

@section('title', 'Kelola Pengguna - Admin Portal')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/admin/users/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/users/style.css') }}">
  <style>
    .account-row {
      display: flex;
      align-items: center;
      padding: 15px;
      border-bottom: 1px solid #f3f4f6;
    }
    .modal {
      display: none;
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 1000;
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: #ffffff;
      padding: 30px;
      border-radius: 15px;
      width: 450px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .form-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
      margin-bottom: 15px;
    }
    .form-group label {
      font-size: 11px;
      font-weight: bold;
      color: #4b5563;
      text-transform: uppercase;
    }
    .form-group input, .form-group select {
      padding: 10px 12px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      font-size: 13px;
      outline: none;
    }
    .form-group input:focus, .form-group select:focus {
      border-color: #298752;
    }
  </style>
@endsection

@section('content')
  <div class="desktop-18" style="overflow-y: auto; height: auto; min-height: 100vh; padding-bottom: 60px;">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'users'])

    <!-- Content Wrapper for alignments -->
    <div style="position: absolute; left: 340px; top: 138px; right: 40px; display: flex; flex-direction: column; gap: 20px; z-index: 10;">
      
      <!-- Messages Flash -->
      @if(session('success'))
        <div style="padding: 10px 15px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; font-family: sans-serif; font-size: 12px; border-radius: 6px; z-index: 100; width: 100%;">
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div style="padding: 10px 15px; background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; font-family: sans-serif; font-size: 12px; border-radius: 6px; z-index: 100; width: 100%;">
          <ul style="list-style: disc; margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Hero Header Section -->
      <div class="hero-header-section" style="position: relative; left: auto; top: auto; right: auto; width: 100%; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05); margin: 0; padding-right: 280px; height: auto;">
        <div class="container">
          <div class="heading-2">
            <div class="kelola-akun-pengguna">Kelola Akun Pengguna</div>
          </div>
          <div class="container2">
            <div class="manajemen-hak-akses-role-pengguna-dan-konfigurasi-status-akun-sistem-pmbm-min-3-karanganyar">
              Manajemen hak akses, role pengguna, dan konfigurasi status akun sistem PMBM MIN 3 Karanganyar.
            </div>
          </div>
        </div>
        
        <!-- Tambah Pengguna Button inside the card -->
        <a href="{{ route('tata_usaha.accounts.create') }}" class="button" style="text-decoration: none; display: flex; align-items: center; cursor: pointer; position: absolute; right: 24px; top: 50%; transform: translateY(-50%); left: auto; margin: 0; z-index: 20;">
          <div class="button-shadow"></div>
          <img class="container3" src="{{ asset('assets/admin/users/container2.svg') }}" />
          <div class="text2">Tambah Pengguna Baru</div>
        </a>
      </div>

      <!-- Main Content Area -->
      <div class="main-content-area" style="position: relative; left: auto; top: auto; right: auto; width: 100%; height: auto; min-height: auto; margin: 0; padding: 0; display: block;">
        <div class="table-list-section" style="height: auto; width: 100%;">
          <div class="background-horizontal-border">
            <div class="heading-3">
              <div class="daftar-pengguna-sistem">Daftar Pengguna Sistem</div>
            </div>
          </div>

          <!-- Search and Filter Bar -->
          <div style="display: flex; gap: 15px; padding: 15px 24px; background: #ffffff; border-bottom: 1px solid #e5e7eb; align-items: center; justify-content: space-between; flex-wrap: wrap;">
            <div style="position: relative; flex: 1; min-width: 240px; max-width: 320px;">
              <input type="text" id="searchInput" placeholder="Cari nama atau email..." style="width: 100%; padding: 10px 12px 10px 36px; border: 1px solid #becabe; border-radius: 8px; font-size: 13px; outline: none; background: #ffffff;" onkeyup="filterUsers()">
              <svg style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #9ca3af; fill: none; stroke: currentColor; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
            </div>
            
            <div style="display: flex; gap: 10px; align-items: center;">
              <label for="roleFilter" style="font-size: 11px; color: #4b5563; font-weight: bold; font-family: sans-serif; letter-spacing: 0.5px;">FILTER ROLE:</label>
              <select id="roleFilter" style="padding: 8px 12px; border: 1px solid #becabe; border-radius: 8px; font-size: 13px; outline: none; background: #ffffff; cursor: pointer;" onchange="filterUsers()">
                <option value="all">Semua Role</option>
                <option value="super_admin">Super Admin</option>
                <option value="tata_usaha">Tata Usaha / Admin</option>
                <option value="panitia">Panitia Penguji</option>
              </select>
            </div>
          </div>
          
          <div class="container9" style="height: auto; overflow: visible; width: 100%;">
            <div class="table" style="height: auto; width: 100%;">
              <div class="header-row" style="display: flex; align-items: center; padding: 12px 16px; background: #eff4ff; border-bottom: 1px solid #becabe; width: 100%;">
                <div style="flex: 2; color: #6f7a70; font-family: 'WorkSans-SemiBold', sans-serif; font-size: 12px; font-weight: bold; letter-spacing: 0.8px; text-transform: uppercase;">IDENTITAS PENGGUNA</div>
                <div style="flex: 1; color: #6f7a70; font-family: 'WorkSans-SemiBold', sans-serif; font-size: 12px; font-weight: bold; letter-spacing: 0.8px; text-transform: uppercase;">STATUS</div>
                <div style="flex: 1; color: #6f7a70; font-family: 'WorkSans-SemiBold', sans-serif; font-size: 12px; font-weight: bold; letter-spacing: 0.8px; text-transform: uppercase;">AKSI</div>
              </div>
              
              <div class="body" style="max-height: 400px; overflow-y: auto; display: flex; flex-direction: column; width: 100%;">
                @foreach($accounts as $acc)
                  <div class="account-row" data-name="{{ $acc['name'] }}" data-email="{{ $acc['email'] }}" data-role="{{ $acc['role'] }}" style="display: flex; align-items: center; border-bottom: 1px solid #f3f4f6; padding: 12px 16px; font-size: 12px; width: 100%;">
                    <div style="flex: 2; display: flex; align-items: center; gap: 12px; overflow: hidden;">
                      <div style="background: #298752; color: #ffffff; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">
                        {{ strtoupper(substr($acc['name'], 0, 2)) }}
                      </div>
                      <div style="overflow: hidden;">
                        <div style="font-weight: bold; color: #1f2937; font-size: 13px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $acc['name'] }}</div>
                        <div style="color: #6b7280; font-size: 11px; margin-top: 2px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $acc['email'] }} | Role: <span style="font-weight: bold; color: #064e3b;">{{ $acc['role_label'] }}</span></div>
                      </div>
                    </div>
                    
                    <div style="flex: 1; display: flex; align-items: center;">
                      <span style="background: #e6f4ea; color: #137333; font-size: 10px; font-weight: bold; padding: 4px 8px; border-radius: 12px;">
                        Active
                      </span>
                    </div>
                    
                    <div style="flex: 1; display: flex; align-items: center; gap: 15px;">
                      <!-- Edit Button -->
                      <a href="{{ route('tata_usaha.accounts.edit', [$acc['role'], $acc['id']]) }}" style="color: #298752; font-weight: bold; cursor: pointer; text-decoration: none; font-size: 12px;">
                        Edit
                      </a>

                      <!-- Delete Form -->
                      @if(!empty($acc['is_super_admin']))
                        <span style="color: #9ca3af; font-size: 11px; font-weight: bold; font-style: italic; cursor: not-allowed;" title="Akun Super Admin Utama tidak dapat dihapus">
                          (Super Admin)
                        </span>
                      @else
                        <form action="{{ route('tata_usaha.accounts.delete', [$acc['role'], $acc['id']]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $acc['name'] }}?')">
                          @csrf
                          <button type="submit" style="color: #ef4444; font-weight: bold; cursor: pointer; border: none; background: none; font-size: 12px; padding: 0; outline: none;">
                            Hapus
                          </button>
                        </form>
                      @endif
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
          
          <div class="pagination-footer">
            <div class="container10">
              <div class="text7" id="showingText">Showing 1-{{ count($accounts) }} of {{ count($accounts) }} users</div>
            </div>
            <div class="container14">
              <div class="button3">
                <img class="container15" src="{{ asset('assets/admin/users/container25.svg') }}" />
              </div>
              <div class="button2">
                <img class="container16" src="{{ asset('assets/admin/users/container26.svg') }}" />
              </div>
            </div>
          </div>
        </div>
        
        <!-- Edit Account Section is now modal-based (moved below) -->
      </div>
    </div>
  </div>

@endsection

@section('scripts')
  <script>
    function filterUsers() {
      const searchVal = document.getElementById('searchInput').value.toLowerCase();
      const roleVal = document.getElementById('roleFilter').value;
      const rows = document.querySelectorAll('.account-row');
      
      let visibleCount = 0;
      rows.forEach(row => {
        const name = row.getAttribute('data-name').toLowerCase();
        const email = row.getAttribute('data-email').toLowerCase();
        const role = row.getAttribute('data-role');
        
        const matchesSearch = name.includes(searchVal) || email.includes(searchVal);
        const matchesRole = roleVal === 'all' || role === roleVal;
        
        if (matchesSearch && matchesRole) {
          row.style.display = 'flex';
          visibleCount++;
        } else {
          row.style.display = 'none';
        }
      });
      
      document.getElementById('showingText').textContent = `Showing ${visibleCount} of ${rows.length} users`;
    }
  </script>
@endsection
