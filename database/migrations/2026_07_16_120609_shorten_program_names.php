<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $map = [
        1 => ['new' => 'Tahfidz', 'old' => 'Khusus / Tahfidz'],
        2 => ['new' => 'Sains', 'old' => 'Unggulan / Sains'],
        3 => ['new' => 'Fullday', 'old' => 'Fullday / Reguler'],
    ];

    public function up(): void
    {
        foreach ($this->map as $id => $names) {
            DB::table('programs')->where('id_program', $id)->update(['nama_program' => $names['new']]);
        }
    }

    public function down(): void
    {
        foreach ($this->map as $id => $names) {
            DB::table('programs')->where('id_program', $id)->update(['nama_program' => $names['old']]);
        }
    }
};
