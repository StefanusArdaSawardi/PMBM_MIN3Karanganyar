<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File; // Wajib ditambahin biar bisa baca file JSON

// 1. HALAMAN UTAMA (Login)
Route::match(['get', 'post'], '/', function (\Illuminate\Http\Request $request) {
    if ($request->isMethod('post')) {
        $role = $request->input('role');
        if ($role === 'admin_tu') {
            return redirect()->route('tu.dashboard');
        } elseif ($role === 'panitia') {
            return redirect()->route('panitia.antrean');
        }
    }
    return view('auth.login');
})->name('login');


// 2. KELOMPOK ROUTE: Admin TU
Route::prefix('admin-tu')->group(function () {
    
    // Halaman Dashboard (Langsung nge-load data JSON dari sini biar ga error!)
    Route::get('/dashboard', function () {
        $jsonPath = database_path('data/pendaftar_terbaru.json');
        
        $pendaftar = [];
        if (File::exists($jsonPath)) {
            $pendaftar = json_decode(File::get($jsonPath), true);
        }

        return view('pages.admin-tu.dashboard', compact('pendaftar'));
    })->name('tu.dashboard');
    
    // Halaman Screen Web PMBM
    Route::get('/screen-web', function () {
        return view('pages.admin-tu.screen-pmbm');
    })->name('tu.screen');

    // Halaman Applicant List / Daftar PMBM
    Route::get('/applicant-list', function () {
        return view('pages.admin-tu.daftar-pmbm');
    })->name('tu.applicant');

    Route::get('/account-management', function () {
        return view('pages.admin-tu.kelola-akun');
    })->name('tu.account');

    Route::get('/accepted-list', function () {
        return view('pages.admin-tu.pendaftar-keterima');
    })->name('tu.accepted');
    
});


// 3. KELOMPOK ROUTE: Panitia Penguji
Route::prefix('panitia')->group(function () {
    Route::get('/antrean', function () {
        return view('pages.panitia.daftar-wawancara');
    })->name('panitia.antrean');
    
    Route::get('/penilaian', function () {
        return view('pages.panitia.form-penilaian');
    })->name('panitia.penilaian');
});