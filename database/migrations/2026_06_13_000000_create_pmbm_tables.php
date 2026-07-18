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
        // Drop legacy tables if exist
        Schema::dropIfExists('students');
        Schema::dropIfExists('majors');

        // 1. programs
        Schema::create('programs', function (Blueprint $table) {
            $table->string('id_program', 10)->primary(); // varchar PK
            $table->string('nama_program');
            $table->integer('kuota_program');
            $table->text('persyaratan')->nullable();
            $table->timestamps();
        });

        // 2. ayah_calon_murids
        Schema::create('ayah_calon_murids', function (Blueprint $table) {
            $table->string('id_ayah', 10)->primary(); // varchar PK
            $table->string('nama_ayah');
            $table->string('pekerjaan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('nomor_telpon')->nullable();
            $table->timestamps();
        });

        // 3. ibu_calon_murids
        Schema::create('ibu_calon_murids', function (Blueprint $table) {
            $table->string('id_ibu', 10)->primary(); // varchar PK
            $table->string('nama_ibu');
            $table->string('pekerjaan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('nomor_telpon')->nullable();
            $table->timestamps();
        });

        // 4. calon_murids
        Schema::create('calon_murids', function (Blueprint $table) {
            $table->string('id_murid', 10)->primary(); // varchar PK
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
            
            $table->string('id_ayah', 10);
            $table->string('id_ibu', 10);
            $table->string('piagram_kejuaraan')->nullable();
            $table->timestamps();

            $table->foreign('id_ayah')->references('id_ayah')->on('ayah_calon_murids')->onDelete('cascade');
            $table->foreign('id_ibu')->references('id_ibu')->on('ibu_calon_murids')->onDelete('cascade');
        });

        // 5. pendaftarans
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->string('id_pendaftaran', 10)->primary(); // varchar PK
            $table->date('tanggal_pendaftaran');
            $table->string('status_verifikasi')->default('menunggu_verifikasi');
            $table->string('status_kelulusan')->nullable();
            $table->string('status_konfirmasi')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->integer('peringkat_cadangan')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->timestamp('tanggal_kelulusan')->nullable();
            $table->timestamp('tanggal_konfirmasi')->nullable();
            
            $table->string('id_murid', 10);
            $table->string('id_program', 10);
            $table->timestamps();

            $table->foreign('id_murid')->references('id_murid')->on('calon_murids')->onDelete('cascade');
            $table->foreign('id_program')->references('id_program')->on('programs')->onDelete('cascade');
        });

        // 6. pengurus_tata_usahas
        Schema::create('pengurus_tata_usahas', function (Blueprint $table) {
            $table->string('id_pengurus', 10)->primary(); // varchar PK
            $table->string('nama_pengurus');
            $table->string('alamat')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        // 7. panitia_pmbms
        Schema::create('panitia_pmbms', function (Blueprint $table) {
            $table->string('id_panitia', 10)->primary(); // varchar PK
            $table->string('nama_panitia');
            $table->string('alamat')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role_panitia', ['pengawas_ujian', 'petugas_wawancara'])->default('pengawas_ujian');
            $table->timestamps();
        });

        // 8. jadwal_wawancara_dan_ujians
        Schema::create('jadwal_wawancara_dan_ujians', function (Blueprint $table) {
            $table->string('id_jadwal', 10)->primary(); // varchar PK
            $table->date('tanggal_jadwal');
            $table->time('jam_jadwal');
            
            $table->string('id_murid', 10);
            $table->string('id_ayah', 10);
            $table->string('id_ibu', 10);
            $table->string('id_program', 10);
            $table->timestamps();

            $table->foreign('id_murid')->references('id_murid')->on('calon_murids')->onDelete('cascade');
            $table->foreign('id_ayah')->references('id_ayah')->on('ayah_calon_murids')->onDelete('cascade');
            $table->foreign('id_ibu')->references('id_ibu')->on('ibu_calon_murids')->onDelete('cascade');
            $table->foreign('id_program')->references('id_program')->on('programs')->onDelete('cascade');
        });

        // 9. hasil_wawancara_dan_ujians
        Schema::create('hasil_wawancara_dan_ujians', function (Blueprint $table) {
            $table->string('id_hasil', 10)->primary(); // varchar PK
            $table->integer('nilai_ujian')->nullable();
            $table->integer('nilai_wawancara')->nullable();
            $table->text('catatan')->nullable();
            
            $table->string('id_murid', 10);
            $table->string('id_ayah', 10);
            $table->string('id_ibu', 10);
            $table->string('id_panitia', 10);
            $table->string('id_program', 10);
            $table->timestamps();

            $table->foreign('id_murid')->references('id_murid')->on('calon_murids')->onDelete('cascade');
            $table->foreign('id_ayah')->references('id_ayah')->on('ayah_calon_murids')->onDelete('cascade');
            $table->foreign('id_ibu')->references('id_ibu')->on('ibu_calon_murids')->onDelete('cascade');
            $table->foreign('id_panitia')->references('id_panitia')->on('panitia_pmbms')->onDelete('cascade');
            $table->foreign('id_program')->references('id_program')->on('programs')->onDelete('cascade');
        });

        // 10. school_contacts
        Schema::create('school_contacts', function (Blueprint $table) {
            $table->id(); // keep ID auto increment or change? Let's keep it as is, or we can use default id()
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
        Schema::dropIfExists('programs');
    }
};
