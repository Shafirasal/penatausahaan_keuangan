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
        Schema::table('t_master_program', function (Blueprint $table) {
            // Menambahkan kolom 'kode_program' setelah kolom 'id_program'
            $table->string('kode_program', 5)->after('id_program');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_master_program', function (Blueprint $table) {
            // Menghapus kolom 'kode_program' jika migrasi dibatalkan
            $table->dropColumn('kode_program');
        });
    }
};
