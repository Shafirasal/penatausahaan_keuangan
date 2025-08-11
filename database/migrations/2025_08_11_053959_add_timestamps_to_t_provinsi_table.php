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
    Schema::table('t_provinsi', function (Blueprint $table) {
        $table->timestamps(); // ini menambah created_at & updated_at
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::table('t_provinsi', function (Blueprint $table) {
        $table->dropTimestamps(); // hapus kolom kalau rollback
    });
    }
};
