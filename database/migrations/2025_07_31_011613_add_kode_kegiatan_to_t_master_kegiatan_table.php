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
        Schema::table('t_master_kegiatan', function (Blueprint $table) {
            // Menambahkan kolom 'kode_kegiatan' setelah kolom 'id_kegiatan'
            $table->string('kode_kegiatan', 8)->after('id_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_master_kegiatan', function (Blueprint $table) {
            // Menghapus kolom 'kode_kegiatan' jika migrasi dibatalkan
            $table->dropColumn('kode_kegiatan');
        });
    }
};
