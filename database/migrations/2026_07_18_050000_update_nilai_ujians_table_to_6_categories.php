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
        Schema::table('nilai_ujians', function (Blueprint $table) {
            // Drop old column
            if (Schema::hasColumn('nilai_ujians', 'nilai_tasmi')) {
                $table->dropColumn('nilai_tasmi');
            }
            
            // Add new 6-category columns
            $table->integer('nilai_aism')->nullable()->after('nilai_hafalan');
            $table->integer('nilai_iqro')->nullable()->after('nilai_aism');
            $table->integer('nilai_dikte')->nullable()->after('nilai_calistung');
            $table->integer('nilai_kemandirian')->nullable()->after('nilai_dikte');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_ujians', function (Blueprint $table) {
            $table->dropColumn(['nilai_aism', 'nilai_iqro', 'nilai_dikte', 'nilai_kemandirian']);
            $table->integer('nilai_tasmi')->nullable()->after('nilai_hafalan');
        });
    }
};
