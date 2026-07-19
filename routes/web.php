<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PanitiaDashboardController;
use App\Http\Controllers\PeriodePendaftaranController;
use App\Http\Controllers\ProgramManagementController;

// 1. Public Landing Pages
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/program/khusus', [LandingController::class, 'programKhusus'])->name('landing.program-khusus');
Route::get('/program/unggulan', [LandingController::class, 'programUnggulan'])->name('landing.program-unggulan');
Route::get('/program/fullday', [LandingController::class, 'programFullday'])->name('landing.program-fullday');
Route::get('/kontak', [LandingController::class, 'kontak'])->name('landing.kontak');
Route::get('/guide', [LandingController::class, 'guide'])->name('landing.guide');

// Student registration
Route::get('/daftar', [LandingController::class, 'showRegisterForm'])->name('student.register');
Route::post('/daftar', [LandingController::class, 'storeRegisterForm'])->name('student.store');
Route::get('/daftar/edit/{id}', [LandingController::class, 'editRegisterForm'])->name('student.edit');
Route::post('/daftar/edit/{id}', [LandingController::class, 'updateRegisterForm'])->name('student.update');

// Checking graduation status
Route::get('/kelulusan', [LandingController::class, 'cekKelulusan'])->name('landing.cek-kelulusan');
Route::post('/kelulusan/cek', [LandingController::class, 'checkStatus'])->name('student.status.check');
Route::get('/api/faqs', [LandingController::class, 'getFaqsJson'])->name('landing.faqs.json');

// Document Preview (accessible by both Admin and Panitia)
Route::get('/document/preview/{type}/{filename}', [AdminDashboardController::class, 'previewDocument'])
    ->middleware('auth:tata_usaha,panitia')
    ->name('document.preview');

// 2. Authentication Login Portal
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// 3. Admin (Tata Usaha) Dashboard Area
Route::middleware('auth:tata_usaha')->prefix('tata-usaha')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('tata_usaha.dashboard');
    Route::post('/periode/publish', [AdminDashboardController::class, 'publishGraduation'])->name('tata_usaha.periode.publish');
    Route::post('/periode/trigger-countdown', [AdminDashboardController::class, 'triggerCountdown'])->name('tata_usaha.periode.trigger_countdown');
    
    // Applicant List (Matches the frontend route names)
    Route::get('/applicants', [AdminDashboardController::class, 'applicants'])->name('scores.index');
    Route::get('/applicants/{id}', [AdminDashboardController::class, 'detail'])->name('tata_usaha.detail');
    Route::post('/applicants/{id}/status', [AdminDashboardController::class, 'updateStatus'])->name('tata_usaha.status');
    Route::post('/applicants/{id}/change-program', [AdminDashboardController::class, 'changeProgram'])->name('tata_usaha.change_program');

    // Grup WhatsApp
    Route::get('/grup-whatsapp', [AdminDashboardController::class, 'grupWhatsapp'])->name('tata_usaha.grup_whatsapp');
    Route::post('/grup-whatsapp/{id}/status', [AdminDashboardController::class, 'updateGrupWhatsapp'])->name('tata_usaha.grup_whatsapp.status');

    // Additional Workflow Stages
    Route::get('/verifikasi-offline', [AdminDashboardController::class, 'verifikasiOffline'])->name('tata_usaha.verifikasi_offline');
    Route::get('/seleksi', [AdminDashboardController::class, 'seleksi'])->name('tata_usaha.seleksi');
    Route::get('/daftar-ulang', [AdminDashboardController::class, 'daftarUlang'])->name('tata_usaha.daftar_ulang');

    // Content Management (CMS)
    Route::get('/content', [AdminDashboardController::class, 'showContent'])->name('tata_usaha.content');

    // Periode Pendaftaran CRUD
    Route::get('/periode', [PeriodePendaftaranController::class, 'index'])->name('tata_usaha.periode.index');
    Route::get('/periode/create', [PeriodePendaftaranController::class, 'create'])->name('tata_usaha.periode.create');
    Route::post('/periode', [PeriodePendaftaranController::class, 'store'])->name('tata_usaha.periode.store');
    Route::get('/periode/edit/{id}', [PeriodePendaftaranController::class, 'edit'])->name('tata_usaha.periode.edit');
    Route::post('/periode/update/{id}', [PeriodePendaftaranController::class, 'update'])->name('tata_usaha.periode.update');
    Route::post('/periode/delete/{id}', [PeriodePendaftaranController::class, 'destroy'])->name('tata_usaha.periode.destroy');
    Route::post('/periode/toggle-status/{id}', [PeriodePendaftaranController::class, 'toggleStatus'])->name('tata_usaha.periode.toggle_status');

    // Kelola Program (halaman terpisah)
    Route::get('/program', [ProgramManagementController::class, 'index'])->name('tata_usaha.program.index');
    Route::get('/program/create', [ProgramManagementController::class, 'create'])->name('tata_usaha.program.create');
    Route::post('/program', [ProgramManagementController::class, 'store'])->name('tata_usaha.program.store');
    Route::get('/program/edit/{id}', [ProgramManagementController::class, 'edit'])->name('tata_usaha.program.edit');
    Route::post('/program/update/{id}', [ProgramManagementController::class, 'update'])->name('tata_usaha.program.update');
    Route::post('/program/delete/{id}', [ProgramManagementController::class, 'destroy'])->name('tata_usaha.program.destroy');

    Route::get('/guide-manage', [AdminDashboardController::class, 'showGuide'])->name('tata_usaha.guide');
    Route::post('/guide-manage/update', [AdminDashboardController::class, 'updateGuide'])->name('tata_usaha.guide.update');
    Route::get('/contacts', [AdminDashboardController::class, 'showContacts'])->name('tata_usaha.contacts.index');
    Route::get('/faqs', [AdminDashboardController::class, 'showFaqs'])->name('tata_usaha.faqs.index');
    Route::get('/dss-config', [AdminDashboardController::class, 'showDssConfig'])->name('tata_usaha.dss.index');
    Route::get('/tutorial', [AdminDashboardController::class, 'showTutorial'])->name('tata_usaha.tutorial.view');
    Route::post('/content/text', [AdminDashboardController::class, 'updateContentText'])->name('tata_usaha.content.update_text');
    Route::post('/content/settings', [AdminDashboardController::class, 'updateSettings'])->name('tata_usaha.settings.update');
    Route::post('/content/dss-config', [AdminDashboardController::class, 'updateDssConfig'])->name('tata_usaha.dss.update');
    Route::post('/content/terms', [AdminDashboardController::class, 'updateTerms'])->name('tata_usaha.content.update_terms');
    Route::post('/content/booklet', [AdminDashboardController::class, 'uploadBooklet'])->name('tata_usaha.content.upload_booklet');
    Route::post('/content/background', [AdminDashboardController::class, 'updateBackground'])->name('tata_usaha.content.update_background');
    Route::post('/content/contact', [AdminDashboardController::class, 'updateGeneralContact'])->name('tata_usaha.content.update_contact');
    Route::post('/content/rundown', [AdminDashboardController::class, 'storeRundown'])->name('tata_usaha.rundown.store');
    Route::post('/content/rundown/update/{index}', [AdminDashboardController::class, 'updateRundown'])->name('tata_usaha.rundown.update');
    Route::post('/content/rundown/delete/{index}', [AdminDashboardController::class, 'deleteRundown'])->name('tata_usaha.rundown.delete');

    // Programs CRUD
    Route::post('/content/programs', [AdminDashboardController::class, 'storeProgram'])->name('tata_usaha.programs.store');
    Route::post('/content/programs/update/{id}', [AdminDashboardController::class, 'updateProgram'])->name('tata_usaha.programs.update');
    Route::post('/content/programs/delete/{id}', [AdminDashboardController::class, 'deleteProgram'])->name('tata_usaha.programs.delete');
 
    // FAQs CRUD
    Route::post('/content/faqs', [AdminDashboardController::class, 'storeFaq'])->name('tata_usaha.faqs.store');
    Route::post('/content/faqs/update/{id}', [AdminDashboardController::class, 'updateFaq'])->name('tata_usaha.faqs.update');
    Route::post('/content/faqs/delete/{id}', [AdminDashboardController::class, 'deleteFaq'])->name('tata_usaha.faqs.delete');
 
    // School Contacts CRUD
    Route::post('/content/contacts', [AdminDashboardController::class, 'storeContact'])->name('tata_usaha.contacts.store');
    Route::post('/content/contacts/update/{id}', [AdminDashboardController::class, 'updateContact'])->name('tata_usaha.contacts.update');
    Route::post('/content/contacts/delete/{id}', [AdminDashboardController::class, 'deleteContact'])->name('tata_usaha.contacts.delete');

    // User Accounts Management
    Route::get('/accounts', [AdminDashboardController::class, 'accounts'])->name('tata_usaha.accounts');
    Route::get('/accounts/create', [AdminDashboardController::class, 'createAccount'])->name('tata_usaha.accounts.create');
    Route::post('/accounts', [AdminDashboardController::class, 'storeAccount'])->name('tata_usaha.accounts.store');
    Route::get('/accounts/edit/{role}/{id}', [AdminDashboardController::class, 'editAccountPage'])->name('tata_usaha.accounts.edit');
    Route::post('/accounts/update/{role}/{id}', [AdminDashboardController::class, 'updateAccount'])->name('tata_usaha.accounts.update');
    Route::post('/accounts/delete/{role}/{id}', [AdminDashboardController::class, 'deleteAccount'])->name('tata_usaha.accounts.delete');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('tata_usaha.logout');
});

// 4. Panitia (Interview) Dashboard Area
Route::middleware('auth:panitia')->prefix('panitia')->group(function () {
    Route::get('/dashboard', [PanitiaDashboardController::class, 'index'])->name('panitia.dashboard');
    
    // Tambahan: Rute Hasil Nilai (Bisa diakses oleh semua role panitia)
    Route::get('/hasil-nilai', [PanitiaDashboardController::class, 'hasilNilai'])->name('panitia.hasil-nilai');
    
    // Rute khusus Pengawas Ujian
    Route::middleware('panitia.role:pengawas_ujian')->group(function () {
        Route::get('/grading/ujian/{id}', [PanitiaDashboardController::class, 'detailUjian'])->name('panitia.detail.ujian');
        Route::post('/grading/ujian/{id}', [PanitiaDashboardController::class, 'storeUjian'])->name('panitia.grading.ujian');
    });

    // Rute khusus Petugas Wawancara
    Route::middleware('panitia.role:petugas_wawancara')->group(function () {
        Route::get('/grading/wawancara/{id}', [PanitiaDashboardController::class, 'detailWawancara'])->name('panitia.detail.wawancara');
        Route::post('/grading/wawancara/{id}', [PanitiaDashboardController::class, 'storeWawancara'])->name('panitia.grading.wawancara');
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('panitia.logout');
});
