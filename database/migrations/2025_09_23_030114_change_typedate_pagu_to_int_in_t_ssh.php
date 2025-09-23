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
            // ubah tipe data kolom pagu1 dan pagu2 ke integer
            $table->integer('pagu1')->nullable()->change();
            $table->integer('pagu2')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_ssh', function (Blueprint $table) {
            // kembalikan lagi ke decimal(15,2)
            $table->decimal('pagu1', 15, 2)->nullable()->change();
            $table->decimal('pagu2', 15, 2)->nullable()->change();
        });
    }
};
