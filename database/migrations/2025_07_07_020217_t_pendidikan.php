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
        Schema::create('t_pendidikan', function (Blueprint $table) {
            $table->id('id_pendidikan');
            $table->string('nip', 20);
            $table->string('nama_sekolah', 100);
            $table->enum('tingkat', ['sd', 'smp', 'sma/smk', 'd1', 'd2', 'd3', 'd4', 's1', 's2', 's3']);
            $table->string('prodi_jurusan', 100);
            $table->date('tahun_lulus');
            $table->enum('aktif', ['ya', 'tidak']);
            $table->timestamps();
            $table->foreign('nip')->references('nip')->on('t_pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_pendidikan');
    }
};
