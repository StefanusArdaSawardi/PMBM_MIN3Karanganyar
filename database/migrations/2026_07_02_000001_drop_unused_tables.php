<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Drop unused tables: chat_messages, school_contracts, school_programs
     */
    public function up(): void
    {
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('school_contracts');
        Schema::dropIfExists('school_programs');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // These tables are intentionally removed and should not be recreated.
    }
};
