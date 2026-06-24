<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PanitiaDashboardController;

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

// 2. Authentication Login Portal
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// 3. Admin (Tata Usaha) Dashboard Area
Route::middleware('auth:tata_usaha')->prefix('tata-usaha')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('tata_usaha.dashboard');
    
    // Applicant List (Matches the frontend route names)
    Route::get('/applicants', [AdminDashboardController::class, 'applicants'])->name('scores.index');
    Route::get('/applicants/{id}', [AdminDashboardController::class, 'detail'])->name('tata_usaha.detail');
    Route::post('/applicants/{id}/status', [AdminDashboardController::class, 'updateStatus'])->name('tata_usaha.status');

    // Document Preview
    Route::get('/document/preview/{type}/{filename}', [AdminDashboardController::class, 'previewDocument'])->name('document.preview');

    // Content Management (CMS)
    Route::get('/content', [AdminDashboardController::class, 'showContent'])->name('tata_usaha.content');
    Route::post('/content/text', [AdminDashboardController::class, 'updateContentText'])->name('tata_usaha.content.update_text');
    Route::post('/content/settings', [AdminDashboardController::class, 'updateSettings'])->name('tata_usaha.settings.update');
    Route::post('/content/dss-config', [AdminDashboardController::class, 'updateDssConfig'])->name('tata_usaha.dss.update');
    Route::post('/content/terms', [AdminDashboardController::class, 'updateTerms'])->name('tata_usaha.content.update_terms');
    Route::post('/content/booklet', [AdminDashboardController::class, 'uploadBooklet'])->name('tata_usaha.content.upload_booklet');
    Route::post('/content/background', [AdminDashboardController::class, 'updateBackground'])->name('tata_usaha.content.update_background');
    Route::post('/content/contact', [AdminDashboardController::class, 'updateContact'])->name('tata_usaha.content.update_contact');
    Route::post('/content/rundown', [AdminDashboardController::class, 'storeRundown'])->name('tata_usaha.rundown.store');
    Route::post('/content/rundown/update/{index}', [AdminDashboardController::class, 'updateRundown'])->name('tata_usaha.rundown.update');
    Route::post('/content/rundown/delete/{index}', [AdminDashboardController::class, 'deleteRundown'])->name('tata_usaha.rundown.delete');

    // Programs CRUD
    Route::post('/content/programs', [AdminDashboardController::class, 'storeProgram'])->name('tata_usaha.programs.store');
    Route::post('/content/programs/update/{id}', [AdminDashboardController::class, 'updateProgram'])->name('tata_usaha.programs.update');
    Route::post('/content/programs/delete/{id}', [AdminDashboardController::class, 'deleteProgram'])->name('tata_usaha.programs.delete');

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
    Route::get('/grading/{id}', [PanitiaDashboardController::class, 'detail'])->name('panitia.detail');
    Route::post('/grading/{id}', [PanitiaDashboardController::class, 'storeGrading'])->name('panitia.grading');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('panitia.logout');
});
