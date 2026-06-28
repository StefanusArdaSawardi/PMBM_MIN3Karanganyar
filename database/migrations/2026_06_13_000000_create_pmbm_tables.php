<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop legacy tables
        Schema::dropIfExists('students');
        Schema::dropIfExists('majors');

        // 1. programs
        Schema::create('programs', function (Blueprint $table) {
            $table->id('id_program');
            $table->string('nama_program');
            $table->integer('kuota_program');
            $table->text('persyaratan')->nullable();
            $table->timestamps();
        });

        // 2. kejuaraans
        Schema::create('kejuaraans', function (Blueprint $table) {
            $table->id('id_kejuaraan');
            $table->string('nama_kejuaraan');
            $table->date('tanggal_kejuaraan')->nullable();
            $table->string('tingkat_kejuaraan')->nullable();
            $table->string('piagram_kejuaraan')->nullable(); // Certificate document path
            $table->timestamps();
        });

        // 3. ayah_calon_murids
        Schema::create('ayah_calon_murids', function (Blueprint $table) {
            $table->id('id_ayah');
            $table->string('nama_ayah');
            $table->string('pekerjaan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('nomor_telpon')->nullable();
            $table->timestamps();
        });

        // 4. ibu_calon_murids
        Schema::create('ibu_calon_murids', function (Blueprint $table) {
            $table->id('id_ibu');
            $table->string('nama_ibu');
            $table->string('pekerjaan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('nomor_telpon')->nullable();
            $table->timestamps();
        });

        // 5. calon_murids
        Schema::create('calon_murids', function (Blueprint $table) {
            $table->id('id_murid');
            $table->string('nama_murid');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('nisn')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('kartu_keluarga')->nullable(); // Document path
            $table->string('akta_kelahiran')->nullable();  // Document path
            $table->string('kartu_identitas_anak')->nullable(); // Document path
            
            $table->foreignId('id_ayah')->constrained('ayah_calon_murids', 'id_ayah')->onDelete('cascade');
            $table->foreignId('id_ibu')->constrained('ibu_calon_murids', 'id_ibu')->onDelete('cascade');
            $table->foreignId('id_kejuaraan')->nullable()->constrained('kejuaraans', 'id_kejuaraan')->onDelete('set null');
            $table->timestamps();
        });

        // 6. pendaftarans
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id('id_pendaftaran');
            $table->date('tanggal_pendaftaran');
            $table->string('status_verifikasi')->default('menunggu_verifikasi');
            $table->string('status_kelulusan')->nullable();
            $table->string('status_konfirmasi')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->integer('peringkat_cadangan')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->timestamp('tanggal_kelulusan')->nullable();
            $table->timestamp('tanggal_konfirmasi')->nullable();
            
            $table->foreignId('id_murid')->constrained('calon_murids', 'id_murid')->onDelete('cascade');
            $table->foreignId('id_program')->constrained('programs', 'id_program')->onDelete('cascade');
            $table->timestamps();
        });

        // 7. pengurus_tata_usahas
        Schema::create('pengurus_tata_usahas', function (Blueprint $table) {
            $table->id('id_pengurus');
            $table->string('nama_pengurus');
            $table->string('alamat')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        // 8. panitia_pmbms
        Schema::create('panitia_pmbms', function (Blueprint $table) {
            $table->id('id_panitia');
            $table->string('nama_panitia');
            $table->string('alamat')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        // 9. jadwal_wawancara_dan_ujians
        Schema::create('jadwal_wawancara_dan_ujians', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->date('tanggal_jadwal');
            $table->time('jam_jadwal');
            
            $table->foreignId('id_murid')->constrained('calon_murids', 'id_murid')->onDelete('cascade');
            $table->foreignId('id_ayah')->constrained('ayah_calon_murids', 'id_ayah')->onDelete('cascade');
            $table->foreignId('id_ibu')->constrained('ibu_calon_murids', 'id_ibu')->onDelete('cascade');
            $table->foreignId('id_program')->constrained('programs', 'id_program')->onDelete('cascade');
            $table->timestamps();
        });

        // 10. hasil_wawancara_dan_ujians
        Schema::create('hasil_wawancara_dan_ujians', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->integer('nilai_ujian')->nullable();
            $table->integer('nilai_wawancara')->nullable();
            $table->text('catatan')->nullable();
            
            $table->foreignId('id_murid')->constrained('calon_murids', 'id_murid')->onDelete('cascade');
            $table->foreignId('id_ayah')->constrained('ayah_calon_murids', 'id_ayah')->onDelete('cascade');
            $table->foreignId('id_ibu')->constrained('ibu_calon_murids', 'id_ibu')->onDelete('cascade');
            $table->foreignId('id_panitia')->constrained('panitia_pmbms', 'id_panitia')->onDelete('cascade');
            $table->foreignId('id_program')->constrained('programs', 'id_program')->onDelete('cascade');
            $table->timestamps();
        });

        // 11. school_contacts
        Schema::create('school_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('platform_name');
            $table->string('value');
            $table->string('link');
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_contacts');
        Schema::dropIfExists('hasil_wawancara_dan_ujians');
        Schema::dropIfExists('jadwal_wawancara_dan_ujians');
        Schema::dropIfExists('panitia_pmbms');
        Schema::dropIfExists('pengurus_tata_usahas');
        Schema::dropIfExists('pendaftarans');
        Schema::dropIfExists('calon_murids');
        Schema::dropIfExists('ibu_calon_murids');
        Schema::dropIfExists('ayah_calon_murids');
        Schema::dropIfExists('kejuaraans');
        Schema::dropIfExists('programs');
    }
};
