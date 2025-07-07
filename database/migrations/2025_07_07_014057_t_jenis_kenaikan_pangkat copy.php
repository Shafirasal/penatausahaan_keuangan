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
        Schema::create('t_jenis_kenaikan_pangkat', function (Blueprint $table) {
            $table->id('id_jenis');
            $table->string('kode', 10)->unique();
            $table->string('nama_jenis', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_jenis_kenaikan_pangkat');
    }
};
