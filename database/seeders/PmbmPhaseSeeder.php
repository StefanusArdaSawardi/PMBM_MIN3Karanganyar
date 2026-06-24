<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PmbmPhase;

class PmbmPhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseDate = now()->startOfDay();

        PmbmPhase::create([
            'nama_phase' => 'Pendaftaran',
            'deskripsi' => 'Fase pendaftaran calon murid dibuka. Silakan mengisi formulir pendaftaran online.',
            'tanggal_mulai' => $baseDate->copy()->addDays(1),
            'tanggal_selesai' => $baseDate->copy()->addDays(15),
            'status' => 'inactive',
            'urutan' => 1,
        ]);

        PmbmPhase::create([
            'nama_phase' => 'Verifikasi Berkas',
            'deskripsi' => 'Panitia melakukan verifikasi dan validasi berkas pendaftaran dari calon murid.',
            'tanggal_mulai' => $baseDate->copy()->addDays(16),
            'tanggal_selesai' => $baseDate->copy()->addDays(25),
            'status' => 'inactive',
            'urutan' => 2,
        ]);

        PmbmPhase::create([
            'nama_phase' => 'Wawancara dan Ujian',
            'deskripsi' => 'Tahap wawancara dan ujian tertulis untuk calon murid yang lolos verifikasi.',
            'tanggal_mulai' => $baseDate->copy()->addDays(26),
            'tanggal_selesai' => $baseDate->copy()->addDays(35),
            'status' => 'inactive',
            'urutan' => 3,
        ]);

        PmbmPhase::create([
            'nama_phase' => 'Pengumuman Hasil',
            'deskripsi' => 'Pengumuman hasil penerimaan dan peringkat calon murid berdasarkan hasil ujian dan wawancara.',
            'tanggal_mulai' => $baseDate->copy()->addDays(36),
            'tanggal_selesai' => $baseDate->copy()->addDays(40),
            'status' => 'inactive',
            'urutan' => 4,
        ]);

        PmbmPhase::create([
            'nama_phase' => 'Pendaftaran Ulang',
            'deskripsi' => 'Tahap pendaftaran ulang bagi calon murid yang diterima untuk mengkonfirmasi kehadiran.',
            'tanggal_mulai' => $baseDate->copy()->addDays(41),
            'tanggal_selesai' => $baseDate->copy()->addDays(50),
            'status' => 'inactive',
            'urutan' => 5,
        ]);
    }
}
