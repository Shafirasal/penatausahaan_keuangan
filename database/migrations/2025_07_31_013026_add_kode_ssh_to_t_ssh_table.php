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
            // Menambahkan kolom 'kode_ssh' setelah kolom 'id_sub_ssh'
            $table->string('kode_ssh', 17)->after('id_ssh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_ssh', function (Blueprint $table) {
            // Menghapus kolom 'kode_ssh' jika migrasi dibatalkan
            $table->dropColumn('kode_ssh');
        });
    }
};
