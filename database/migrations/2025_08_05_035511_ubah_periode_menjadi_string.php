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
        Schema::table('t_ssh', function (Blueprint $table) {
            // Ubah tipe kolom 'periode' menjadi string
            $table->string('periode')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ssh', function (Blueprint $table) {
            // Kembalikan ke tipe date (jika sebelumnya DATE)
            $table->date('periode')->change();
        });
    }
};
