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
        Schema::table('t_rekening', function (Blueprint $table) {
            // Menambahkan kolom 'kode_rekening' setelah kolom 'id_rekening'
            $table->string('kode_rekening', 12)->after('id_rekening');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_rekening', function (Blueprint $table) {
            // Menghapus kolom 'kode_rekening' jika migrasi dibatalkan
            $table->dropColumn('kode_rekening');
        });
    }
};
