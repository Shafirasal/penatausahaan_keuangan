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
        Schema::create('t_kelurahan', function (Blueprint $table) {
            $table->id('id_kelurahan');
            $table->string('nama_kelurahan', 50);
            $table->unsignedBigInteger('id_kecamatan');
            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('t_kecamatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_kelurahan');
    }
};
