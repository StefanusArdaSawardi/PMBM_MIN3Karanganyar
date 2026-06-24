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
        // 1. pengurus_tata_usahas
        if (Schema::hasTable('pengurus_tata_usahas')) {
            Schema::table('pengurus_tata_usahas', function (Blueprint $table) {
                if (Schema::hasColumn('pengurus_tata_usahas', 'alamat') && !Schema::hasColumn('pengurus_tata_usahas', 'no_hp')) {
                    $table->renameColumn('alamat', 'no_hp');
                }
                if (!Schema::hasColumn('pengurus_tata_usahas', 'password_plain')) {
                    $table->string('password_plain')->nullable();
                }
            });
        }

        // 2. panitia_pmbms
        if (Schema::hasTable('panitia_pmbms')) {
            Schema::table('panitia_pmbms', function (Blueprint $table) {
                if (Schema::hasColumn('panitia_pmbms', 'alamat') && !Schema::hasColumn('panitia_pmbms', 'no_hp')) {
                    $table->renameColumn('alamat', 'no_hp');
                }
                if (!Schema::hasColumn('panitia_pmbms', 'password_plain')) {
                    $table->string('password_plain')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. pengurus_tata_usahas
        if (Schema::hasTable('pengurus_tata_usahas')) {
            Schema::table('pengurus_tata_usahas', function (Blueprint $table) {
                if (Schema::hasColumn('pengurus_tata_usahas', 'no_hp') && !Schema::hasColumn('pengurus_tata_usahas', 'alamat')) {
                    $table->renameColumn('no_hp', 'alamat');
                }
                if (Schema::hasColumn('pengurus_tata_usahas', 'password_plain')) {
                    $table->dropColumn('password_plain');
                }
            });
        }

        // 2. panitia_pmbms
        if (Schema::hasTable('panitia_pmbms')) {
            Schema::table('panitia_pmbms', function (Blueprint $table) {
                if (Schema::hasColumn('panitia_pmbms', 'no_hp') && !Schema::hasColumn('panitia_pmbms', 'alamat')) {
                    $table->renameColumn('no_hp', 'alamat');
                }
                if (Schema::hasColumn('panitia_pmbms', 'password_plain')) {
                    $table->dropColumn('password_plain');
                }
            });
        }
    }
};
