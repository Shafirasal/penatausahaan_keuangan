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
            // ubah pagu1 & pagu2 jadi decimal(15,2)
            $table->decimal('pagu1', 15, 2)->nullable()->change();
            $table->decimal('pagu2', 15, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_ssh', function (Blueprint $table) {
            // rollback ke tipe awal
            $table->integer('pagu1')->nullable()->change();
            $table->string('pagu2', 255)->nullable()->change();
        });
    }
};
