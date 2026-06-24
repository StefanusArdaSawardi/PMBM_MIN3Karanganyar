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
        Program::create([
            'nama_program' => 'Program Khusus (Tahfidz)',
            'kuota_program' => 30,
            'persyaratan' => 'Hafal Juz 30, Lulus tes tertulis & wawancara keagamaan'
        ]);

        Program::create([
            'nama_program' => 'Program Unggulan (Sains)',
            'kuota_program' => 32,
            'persyaratan' => 'Nilai rapor Matematika & IPA min 80, Lulus tes tertulis akademis'
        ]);

        Program::create([
            'nama_program' => 'Program Fullday',
            'kuota_program' => 64,
            'persyaratan' => 'Lulus tes kesiapan belajar, bersedia mengikuti program fullday'
        ]);

        // 2. Seed Panitia account
        PanitiaPmbm::create([
            'nama_panitia' => 'Panitia PMBM 1',
            'email' => 'panitia@min3karanganyar.sch.id',
            'no_hp' => '089876543210',
            'password' => Hash::make('Panitia@2026'),
            'password_plain' => 'Panitia@2026',
        ]);

        // 3. Call other seeders
        $this->call([
            PmbmPhaseSeeder::class,
            TataUsahaSeeder::class,
            PendaftaranSeeder::class,
        ]);
    }
}
