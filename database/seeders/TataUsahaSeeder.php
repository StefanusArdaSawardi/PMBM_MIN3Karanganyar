<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengurusTataUsaha;
use Illuminate\Support\Facades\Hash;

class TataUsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\PengurusTataUsaha::firstOrCreate(
            ['email' => 'tata.usaha@min3karanganyar.sch.id'],
            [
                'nama_pengurus' => 'Admin Tata Usaha',
                'no_hp' => '081234567890',
                'password' => Hash::make('TataUsaha@2026'),
                'password_plain' => 'TataUsaha@2026',
                'role' => 'super admin',
            ]
        );

        // Seed default FAQs
        $defaultFaqs = [
            ['question' => 'Kapan pendaftaran PMBM ditutup?', 'answer' => 'Pendaftaran PMBM ditutup pada tanggal 31 Juli 2026.'],
            ['question' => 'Apa saja program kelas yang bisa dipilih?', 'answer' => 'Terdapat Program Regular IPA, Regular IPS, Unggulan Bahasa, dan Program Keagamaan.'],
            ['question' => 'Bagaimana cara mengecek status pendaftaran?', 'answer' => 'Masuk ke menu Cek Status, masukkan Nama Murid atau NISN serta Nama Ibu Kandung.'],
            ['question' => 'Apakah berkas prestasi/piagam wajib dimasukkan?', 'answer' => 'Berkas prestasi tidak wajib, hanya dimasukkan jika calon murid memiliki piagam juara.'],
        ];

        foreach ($defaultFaqs as $faq) {
            \App\Models\Faq::firstOrCreate(['question' => $faq['question']], $faq);
        }

        $this->command->info('✅ Akun Tata Usaha (Super Admin) & FAQ default berhasil dibuat!');
        $this->command->info('Email: tata.usaha@min3karanganyar.sch.id');
        $this->command->info('Password: TataUsaha@2026');
    }
}
