# Rencana Implementasi CRUD Program Pendidikan & Integrasi Beranda (Diperbarui)

Rencana ini mencakup penambahan fitur Tambah, Edit, dan Hapus (CRUD) untuk Program Pendidikan/Jalur pada CMS Tata Usaha, integrasi program tersebut ke dalam kartu "PROGRAM PENDIDIKAN" di halaman beranda, serta sinkronisasi Judul dan Deskripsi Utama di atas area countdown.

Sesuai permintaan terbaru, tampilan modal untuk **Tambah/Edit Program** dan **Ubah Akun Pengguna** diselaraskan sepenuhnya agar memiliki struktur, kelas, dan visualisasi yang persis seperti modal **"Tambah Pengguna Baru"**. 

Selain itu, halaman **Guide PMBM** diperbaiki agar panel overlay **"Syarat & Ketentuan Pendaftaran"** disembunyikan secara default dan hanya muncul ketika kartu/tombol "Syarat Pendaftaran" ditekan. Tombol keluar/close khusus (`&times;`) juga ditambahkan di sudut kanan atas panel header overlay tersebut.

---

## User Review Required

> [!IMPORTANT]
> - **Modal Konsisten**: Semua form input (Tambah/Ubah Akun Pengguna dan Tambah/Ubah Program Pendidikan) kini didesain sebagai modal modern melayang dengan warna dominan hijau tua (`#064e3b`), latar putih bersih, bayangan premium, serta tombol aksi "Batal" dan "Simpan" yang seragam.
> - **Penyembunyian Overlay Guide**: Panel "Syarat & Ketentuan Pendaftaran" di halaman `/guide` disembunyikan secara default. Ketika kartu "Syarat Pendaftaran" diklik, JavaScript akan memunculkan overlay tersebut di atas halaman. Tombol "Tutup" di bagian bawah dan tombol silang (`&times;`) di pojok kanan atas ditambahkan untuk menutup overlay secara instan tanpa meninggalkan halaman.
> - **Penanganan Gambar/Foto Program**: Upload foto program akan disimpan secara otomatis di direktori `public/uploads/programs/` dengan penamaan file yang unik (menggunakan timestamp dan hash). File gambar lama akan dihapus dari disk secara otomatis saat program diperbarui dengan foto baru atau saat program dihapus.
> - **Responsivitas Layout Halaman Utama**: Halaman utama/beranda menggunakan positioning absolute bawaan Figma. Untuk menghindari tumpang tindih antara daftar program dinamis dan footer, kami menerapkan sistem pergeseran dinamis via JavaScript:
>   - Footer dibungkus dalam kontainer absolut tunggal (`#footer-group-wrapper`).
>   - Jika baris program pendidikan bertambah (karena bertambahnya jumlah program), JavaScript akan mendeteksi tinggi baru container dan menggeser footer ke bawah serta menyesuaikan tinggi halaman secara dinamis.

---

## Proposed Changes

### 1. Backend Integration & Data Sharing

#### [MODIFY] [LandingController.php](file:///d:/Dokumen/Codingan/Codingan%20TA/WebsitePMBM_Terbaru/PMBM_MIN3Karanganyar/app/Http/Controllers/LandingController.php)
- Memperbarui method `index()` agar memuat daftar program dari database (`Program::all()`) dan mengirimkannya ke view `landing.home`.

---

### 2. CMS Tata Usaha (Manage Content)

#### [MODIFY] [landing.blade.php](file:///d:/Dokumen/Codingan/Codingan%20TA/WebsitePMBM_Terbaru/PMBM_MIN3Karanganyar/resources/views/master/landing.blade.php)
- Mengubah tombol tambah `+` pada seksi program agar memicu modal input program baru (`openCreateProgramModal()`).
- Mengubah tombol Edit dan Hapus pada tabel program agar memanggil fungsi JavaScript `openEditProgramModal(...)` dan `confirmDeleteProgram(...)`.
- Menambahkan dua modal dialog HTML & CSS modern di bagian bawah view (**Tambah Program** & **Edit Program**) dengan gaya yang identik dengan modal "Tambah Pengguna Baru".
- Menambahkan fungsi JavaScript untuk menangani pembukaan modal, penutupan modal, mempopulasi data edit, serta menangani submit form hapus via POST.

---

### 3. Kelola Pengguna (Accounts Management)

#### [MODIFY] [index.blade.php](file:///d:/Dokumen/Codingan/Codingan%20TA/WebsitePMBM_Terbaru/PMBM_MIN3Karanganyar/resources/views/pengguna/index.blade.php)
- Mengubah seksi inline edit akun pengguna (`#editAccountSection`) menjadi modal melayang (`#editAccountModal`) dengan tata letak dan gaya yang identik dengan modal `createAccountModal` ("Tambah Pengguna Baru").
- Memperbarui javascript `editAccount(...)` dan `cancelEdit()` agar mengontrol visibilitas modal tersebut secara dinamis.

---

### 4. Guide PMBM Page

#### [MODIFY] [guide.blade.php](file:///d:/Dokumen/Codingan/Codingan%20TA/WebsitePMBM_Terbaru/PMBM_MIN3Karanganyar/resources/views/landing/guide.blade.php)
- Menambahkan atribut pembungkus `requirementsOverlay` untuk semua tag elemen overlay "Syarat & Ketentuan Pendaftaran" (lines 118-173) dengan default style `display: none;`.
- Memberikan trigger `onclick="openRequirementsOverlay()"` dan kursor pointer pada kartu `group-3` ("Syarat Pendaftaran").
- Mengubah tautan "Tutup" di bagian bawah agar tidak mengarah ke `/home`, melainkan memanggil fungsi `closeRequirementsOverlay()`.
- Menambahkan tombol silang khusus (`&times;`) pada pojok kanan atas header panel overlay (`left: 1160px; top: 245px;`) untuk keluar secara instan.
- Menambahkan section `@section('scripts')` dengan fungsi JS `openRequirementsOverlay()` dan `closeRequirementsOverlay()`.

---

### 5. Public Views & Shared Components

#### [MODIFY] [footer.blade.php](file:///d:/Dokumen/Codingan/Codingan%20TA/WebsitePMBM_Terbaru/PMBM_MIN3Karanganyar/resources/views/components/footer.blade.php)
- Membungkus seluruh elemen footer di dalam wrapper absolut `<div id="footer-group-wrapper" style="position: absolute; left: 0; top: 0; width: 100%; height: 100%;">` sehingga seluruh anak elemen footer yang diposisikan secara absolut dapat digeser sebagai satu kesatuan tanpa merusak koordinat internalnya.

#### [MODIFY] [home.blade.php](file:///d:/Dokumen/Codingan/Codingan%20TA/WebsitePMBM_Terbaru/PMBM_MIN3Karanganyar/resources/views/landing/home.blade.php)
- Memberikan ID `page-container` pada div pembungkus utama `.dashboard-pmbm-min-3-kra`.
- Mengintegrasikan teks judul utama dan deskripsi singkat di atas area countdown dengan data CMS:
  - Judul Utama: Menggunakan `{{ strtoupper($landingContent['main_heading'] ?? 'PENERIMAAN SISWA BARU MIN 3 KARANGANYAR') }}`.
  - Deskripsi Singkat: Menggunakan `{{ $landingContent['sub_heading'] ?? '...' }}`.
- Menggantikan 3 kolom kartu program pendidikan statis menjadi sebuah loop `@foreach($programs as $program)` yang menghasilkan kartu program secara dinamis:
  - Menampilkan foto program (menggunakan fallback gambar default jika kosong).
  - Menampilkan nama program dan deskripsinya.
  - Menyelaraskan tinggi kartu dengan `align-items: stretch`.
  - Secara cerdas menghubungkan tautan ke halaman detail program khusus jika nama program mengandung kata kunci yang cocok ("Khusus/Tahfidz", "Unggulan/Sains", atau "Fullday").
- Menambahkan JavaScript untuk mendeteksi tinggi aktual kartu program dan menyesuaikan koordinat `top` dari `#footer-group-wrapper` serta `height` dari `#page-container` secara dinamis demi menghindari tumpang tindih.

---

## Verification Plan

### Manual Verification
1. Login ke portal Tata Usaha dan masuk ke menu **Kelola Konten**.
2. Di bagian **Kategori Program Studi / Jalur**, klik tombol `+`. Pastikan modal "Tambah Program Baru" muncul melayang dengan desain hijau-putih yang rapi.
3. Isi data program baru dan simpan. Uji fitur **Edit** untuk memastikan modal "Ubah Program" muncul dengan data terpopulasi dan preview foto lama terlampir.
4. Uji tombol **Hapus** dan konfirmasi untuk menghapus data.
5. Masuk ke menu **Kelola Akun**, klik **Edit** pada salah satu pengguna. Pastikan modal "Ubah Akun: [Nama]" muncul melayang dengan struktur persis seperti "Tambah Pengguna Baru".
6. Buka beranda utama (`/`) untuk memastikan kartu program studi dan teks di atas countdown terupdate dinamis serta footer bergeser mulus tanpa overlap.
7. Buka halaman Guide PMBM (`/guide`). Pastikan overlay "Syarat & Ketentuan Pendaftaran" disembunyikan secara default.
8. Klik kartu **Syarat Pendaftaran**. Pastikan overlay muncul ke permukaan.
9. Uji tombol silang (`&times;`) di pojok kanan atas dan tombol **Tutup** di bagian bawah. Keduanya harus menutup overlay secara instan dan mengembalikan tampilan daftar guide semula tanpa me-reload halaman.
