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
        // Tabel Pegawai
        Schema::create('t_pegawai', function (Blueprint $table) {
            $table->string('nip', 20)->primary();
            $table->string('gelar_depan', 10)->nullable();
            $table->string('gelar_belakang', 25)->nullable();
            $table->string('nik', 18)->unique();
            $table->string('tempat_lahir', 30);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('hp', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('alamat', 100)->nullable();
            $table->integer('rt')->nullable();
            $table->integer('rw')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->enum('agama', ['islam', 'kristen', 'katolik', 'budha', 'hindu', 'konghucu']);
            $table->enum('status_kepegawaian', ['cpns', 'pns', 'pppk', 'ptt']);
            $table->string('kelurahan', 100)->nullable();
            $table->unsignedBigInteger('id_provinsi');
            $table->unsignedBigInteger('id_kabupaten_kota');
            $table->unsignedBigInteger('id_kecamatan');
            $table->timestamps();

            $table->foreign('id_provinsi')->references('id_provinsi')->on('t_provinsi');
            $table->foreign('id_kabupaten_kota')->references('id_kabupaten_kota')->on('t_kabupaten_kota');
            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('t_kecamatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_pegawai');
    }
};
