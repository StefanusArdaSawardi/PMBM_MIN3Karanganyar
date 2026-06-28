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
            $jk = $faker->randomElement(['L', 'P']);
            $calonMurid = CalonMurid::create([
                'nama_murid' => $faker->firstName($jk === 'L' ? 'male' : 'female') . ' ' . $faker->lastName(),
                'jenis_kelamin' => $jk,
                'nik' => $isComplete ? $faker->numerify('3315############') : null,
                'nisn' => $isComplete ? $faker->numerify('##########') : null,
                'tempat_lahir' => $isComplete ? $faker->city() : null,
                'tanggal_lahir' => $isComplete ? $faker->dateTimeBetween('-15 years', '-10 years') : null,
                'alamat' => $isComplete ? $faker->address() : null,
                'email' => $isComplete ? $faker->safeEmail() : null,
                'kartu_keluarga' => $isComplete ? '/documents/kk_' . $i . '.pdf' : null,
                'akta_kelahiran' => $isComplete ? '/documents/akta_' . $i . '.pdf' : null,
                'kartu_identitas_anak' => $isComplete ? '/documents/kie_' . $i . '.pdf' : null,
                'id_ayah' => $ayah->id_ayah,
                'id_ibu' => $ibu->id_ibu,
                'id_kejuaraan' => null,
            ]);

            // Tentukan kombinasi status pendaftaran realistis
            $status_verifikasi = $faker->randomElement(['menunggu_verifikasi', 'ditolak', 'terverifikasi', 'terverifikasi_onsite']);
            $status_kelulusan = null;
            $status_konfirmasi = null;
            $alasan_penolakan = null;
            $peringkat_cadangan = null;

            if ($status_verifikasi === 'ditolak') {
                $alasan_penolakan = $faker->randomElement([
                    'File Kartu Keluarga buram / tidak terbaca.',
                    'File Akta Kelahiran terpotong.',
                    'NISN tidak terdaftar di data kemendikbud.',
                    'Dokumen persyaratan kurang lengkap.'
                ]);
            } elseif ($status_verifikasi === 'terverifikasi_onsite') {
                $status_kelulusan = $faker->randomElement(['lulus', 'tidak_lulus', 'cadangan', null]);
                
                if ($status_kelulusan === 'lulus') {
                    $status_konfirmasi = $faker->randomElement(['belum_konfirmasi', 'terkonfirmasi', 'mengundurkan_diri']);
                } elseif ($status_kelulusan === 'cadangan') {
                    $peringkat_cadangan = $faker->numberBetween(1, 5);
                }
            }

            // Buat data Pendaftaran
            Pendaftaran::create([
                'tanggal_pendaftaran' => $faker->dateTimeBetween('-30 days', 'now'),
                'status_verifikasi' => $status_verifikasi,
                'status_kelulusan' => $status_kelulusan,
                'status_konfirmasi' => $status_konfirmasi,
                'alasan_penolakan' => $alasan_penolakan,
                'peringkat_cadangan' => $peringkat_cadangan,
                'id_murid' => $calonMurid->id_murid,
                'id_program' => $programs->random()->id_program,
            ]);

            $this->command->info("Data pendaftaran ke-{$i} berhasil dibuat (" . ($isComplete ? 'Lengkap' : 'Tidak Lengkap') . ")");
        }

        $this->command->info("✓ 10 data dummy pendaftaran berhasil dibuat!");
    }
}
