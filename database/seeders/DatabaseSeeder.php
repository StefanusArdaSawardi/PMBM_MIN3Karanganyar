<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\PanitiaPmbm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Programs
        Program::firstOrCreate(
            ['nama_program' => 'Program Khusus (Tahfidz)'],
            [
                'kuota_program' => 30,
                'persyaratan' => 'Hafal Juz 30, Lulus tes tertulis & wawancara keagamaan'
            ]
        );

        Program::firstOrCreate(
            ['nama_program' => 'Program Unggulan (Sains)'],
            [
                'kuota_program' => 32,
                'persyaratan' => 'Nilai rapor Matematika & IPA min 80, Lulus tes tertulis akademis'
            ]
        );

        Program::firstOrCreate(
            ['nama_program' => 'Program Fullday'],
            [
                'kuota_program' => 64,
                'persyaratan' => 'Lulus tes kesiapan belajar, bersedia mengikuti program fullday'
            ]
        );

        // 2. Seed Panitia account (Default / Pengawas Ujian)
        PanitiaPmbm::firstOrCreate(
            ['email' => 'panitia@min3karanganyar.sch.id'],
            [
                'nama_panitia' => 'Panitia PMBM 1',
                'no_hp' => '089876543210',
                'password' => Hash::make('Panitia@2026'),
                'password_plain' => 'Panitia@2026',
                // Tetap menggunakan default column value dari database (pengawas_ujian)
            ]
        );

        // Tambahan: Akun Baru Khusus Petugas Wawancara
        PanitiaPmbm::firstOrCreate(
            ['email' => 'wawancara@min3karanganyar.sch.id'], // Email dibedakan
            [
                'nama_panitia' => 'Petugas Wawancara 1',
                'no_hp' => '089876543211',
                'role_panitia' => 'petugas_wawancara', // Set role khusus wawancara sesuai rute middleware web.php
                'password' => Hash::make('Wawancara@2026'),
                'password_plain' => 'Wawancara@2026',
            ]
        );

        // 3. Call other seeders
        $this->call([
            PmbmPhaseSeeder::class,
            TataUsahaSeeder::class,
            PendaftaranSeeder::class,
            FaqSeeder::class,
            SchoolContactSeeder::class,
        ]);
    }
}