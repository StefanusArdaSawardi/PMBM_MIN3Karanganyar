<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Clear existing programs
        DB::table('programs')->truncate();

        // Insert new 3 programs
        DB::table('programs')->insert([
            [
                'id_program' => 1,
                'nama_program' => 'Khusus / Tahfidz',
                'kuota_program' => 40,
                'persyaratan' => 'Fokus pada hafalan Al-Quran (Tahfidz), pendalaman Fiqih, dan pembentukan karakter Islami yang kuat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_program' => 2,
                'nama_program' => 'Unggulan / Sains',
                'kuota_program' => 50,
                'persyaratan' => 'Fokus pada pengembangan kompetensi sains, matematika tingkat lanjut, dan logika analitis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_program' => 3,
                'nama_program' => 'Fullday / Reguler',
                'kuota_program' => 50,
                'persyaratan' => 'Program reguler dengan jam belajar penuh (fullday), mengembangkan semua aspek akademik dan karakter.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('programs')->truncate();
    }
};
