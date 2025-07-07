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
        Schema::create('t_jabatan_struktural', function (Blueprint $table) {
            $table->id('id_jabatan_struktural');
            $table->string('nip', 20);
            $table->string('nama_jabatan', 100);
            $table->enum('jenis_penilaian', ['...']); // sesuaikan nilainya
            $table->string('unit_kerja', 100);
            $table->string('unit_jabatan', 100);
            $table->enum('status_jabatan', ['ya', 'tidak']);
            $table->timestamps();
            $table->foreign('nip')->references('nip')->on('t_pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_jabatan_struktural');
    }
};
