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
        Schema::table('hasil_wawancara_dan_ujians', function (Blueprint $table) {
            $table->integer('nilai_hafalan')->default(0)->after('nilai_wawancara');
            $table->integer('nilai_calistung')->default(0)->after('nilai_hafalan');
            $table->integer('nilai_tasmi')->default(0)->after('nilai_calistung');
            $table->integer('nilai_mandiri')->default(0)->after('nilai_tasmi');
            $table->double('nilai_akhir')->default(0.0)->after('nilai_mandiri');
            $table->text('catatan_otomatis')->nullable()->after('nilai_akhir');
            $table->text('catatan_manual')->nullable()->after('catatan_otomatis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_wawancara_dan_ujians', function (Blueprint $table) {
            $table->dropColumn([
                'nilai_hafalan',
                'nilai_calistung',
                'nilai_tasmi',
                'nilai_mandiri',
                'nilai_akhir',
                'catatan_otomatis',
                'catatan_manual'
            ]);
        });
    }
};
