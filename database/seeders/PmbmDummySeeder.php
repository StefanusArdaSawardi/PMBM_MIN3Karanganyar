<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeriodePendaftaran;
use App\Models\Pendaftaran;
use App\Models\CalonMurid;
use App\Models\Program;

class PmbmDummySeeder extends Seeder
{
    public function run()
    {
        // 1. Pastikan ada Periode Pendaftaran yang berstatus 'aktif'
        $periode = PeriodePendaftaran::updateOrCreate(
            ['status' => 'aktif'],
            [
                'nama_periode' => 'Gelombang 1 - 2026/2027',
                'tahun_ajaran' => '2026/2027',
            ]
        );

        // 2. Pastikan minimal ada 1 Program (opsional, fallback ke 'Umum')
        $program = Program::firstOrCreate(
            ['nama_program' => 'Reguler'],
            ['kuota' => 100]
        );

        // 3. Data Dummy Siswa 1
        $siswa1 = CalonMurid::create([
            'nama_murid' => 'Achmad Fauzi',
            'nisn' => '0098765432',
            'jenis_kelamin' => 'L',
        ]);

        Pendaftaran::create([
            'id_pendaftaran' => 'PMB0001', // Sesuaikan format primary key tabelmu
            'periode_pendaftaran_id' => $periode->id,
            'calon_murid_id' => $siswa1->id, // Sesuaikan foreign key calon murid
            'program_id' => $program->id,
            'status_verifikasi' => 'terverifikasi_onsite',
            'status' => 'pending',
        ]);

        // 4. Data Dummy Siswa 2
        $siswa2 = CalonMurid::create([
            'nama_murid' => 'Siti Aminah',
            'nisn' => '0091234567',
            'jenis_kelamin' => 'P',
        ]);

        Pendaftaran::create([
            'id_pendaftaran' => 'PMB0002',
            'periode_pendaftaran_id' => $periode->id,
            'calon_murid_id' => $siswa2->id,
            'program_id' => $program->id,
            'status_verifikasi' => 'terverifikasi_onsite',
            'status' => 'pending',
        ]);

        $this->command->info('Data dummy antrean PMBM berhasil ditambahkan!');
    }
}