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
        // Alter t_user
        Schema::table('t_user', function (Blueprint $table) {
            $table->dropForeign(['nip']);
            $table->foreign('nip')
                  ->references('nip')->on('t_pegawai')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        // Alter t_jabatan_fungsional
        Schema::table('t_jabatan_fungsional', function (Blueprint $table) {
            $table->dropForeign(['nip']);
            $table->foreign('nip')
                  ->references('nip')->on('t_pegawai')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        // Alter t_jabatan_struktural
        Schema::table('t_jabatan_struktural', function (Blueprint $table) {
            $table->dropForeign(['nip']);
            $table->foreign('nip')
                  ->references('nip')->on('t_pegawai')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        // Alter t_riwayat_kepegawaian
        Schema::table('t_riwayat_kepegawaian', function (Blueprint $table) {
            $table->dropForeign(['nip']);
            $table->foreign('nip')
                  ->references('nip')->on('t_pegawai')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        // Alter t_pendidikan
        Schema::table('t_pendidikan', function (Blueprint $table) {
            $table->dropForeign(['nip']);
            $table->foreign('nip')
                  ->references('nip')->on('t_pegawai')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_user', function (Blueprint $table) {
            $table->dropForeign(['nip']);
        });
        Schema::table('t_jabatan_fungsional', function (Blueprint $table) {
            $table->dropForeign(['nip']);
        });
        Schema::table('t_jabatan_struktural', function (Blueprint $table) {
            $table->dropForeign(['nip']);
        });
        Schema::table('t_riwayat_kepegawaian', function (Blueprint $table) {
            $table->dropForeign(['nip']);
        });
        Schema::table('t_pendidikan', function (Blueprint $table) {
            $table->dropForeign(['nip']);
        });
    }
};
