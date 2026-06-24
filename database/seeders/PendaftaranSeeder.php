<?php

namespace Database\Seeders;

use App\Models\AyahCalonMurid;
use App\Models\CalonMurid;
use App\Models\IbuCalonMurid;
use App\Models\Pendaftaran;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Ambil atau buat beberapa program
        $programs = Program::all();
        if ($programs->isEmpty()) {
            $programs = Program::factory(3)->create();
        }

        // Buat 10 pendaftaran dengan data random dan beberapa tidak lengkap
        for ($i = 1; $i <= 10; $i++) {
            // Tentukan apakah data ini lengkap atau tidak (70% lengkap, 30% tidak lengkap)
            $isComplete = $faker->boolean(70);

            // Buat data Ayah
            $ayah = AyahCalonMurid::create([
                'nama_ayah' => $faker->name('male'),
                'pekerjaan' => $isComplete ? $faker->jobTitle() : null,
                'alamat' => $isComplete ? $faker->address() : null,
                'nomor_telpon' => $isComplete ? $faker->numerify('08##########') : null,
            ]);

            // Buat data Ibu
            $ibu = IbuCalonMurid::create([
                'nama_ibu' => $faker->name('female'),
                'pekerjaan' => $isComplete ? $faker->jobTitle() : null,
                'alamat' => $isComplete ? $faker->address() : null,
                'nomor_telpon' => $isComplete ? $faker->numerify('08##########') : null,
            ]);

            // Buat data Calon Murid
            $calonMurid = CalonMurid::create([
                'nama_murid' => $faker->firstName(),
                'nisn' => $isComplete ? $faker->numerify('##########') : null,
                'tempat_lahir' => $isComplete ? $faker->city() : null,
                'tanggal_lahir' => $isComplete ? $faker->dateTimeBetween('-18 years', '-12 years') : null,
                'alamat' => $isComplete ? $faker->address() : null,
                'email' => $isComplete ? $faker->safeEmail() : null,
                'kartu_keluarga' => $isComplete ? '/documents/kk_' . $i . '.pdf' : null,
                'akta_kelahiran' => $isComplete ? '/documents/akta_' . $i . '.pdf' : null,
                'kartu_identitas_anak' => $isComplete ? '/documents/kie_' . $i . '.pdf' : null,
                'id_ayah' => $ayah->id_ayah,
                'id_ibu' => $ibu->id_ibu,
                'id_kejuaraan' => null, // Bisa di-set nanti jika diperlukan
            ]);

            // Buat data Pendaftaran
            Pendaftaran::create([
                'tanggal_pendaftaran' => $faker->dateTimeBetween('-30 days', 'now'),
                'status' => $faker->randomElement(['diperiksa', 'ditolak', 'diterima', 'Seleksi', 'Tidak lulus', 'Cadangan', 'lulus']),
                'id_murid' => $calonMurid->id_murid,
                'id_program' => $programs->random()->id_program,
            ]);

            $this->command->info("Data pendaftaran ke-{$i} berhasil dibuat (" . ($isComplete ? 'Lengkap' : 'Tidak Lengkap') . ")");
        }

        $this->command->info("✓ 10 data dummy pendaftaran berhasil dibuat!");
    }
}
