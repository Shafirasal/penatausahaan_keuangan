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
            $table->renameColumn('id_SSH', 'id_ssh'); // Rename the column from id_SSH to id_ssh
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_ssh', function (Blueprint $table) {
            $table->renameColumn('id_SSH', 'id_ssh'); // Revert the column name change
        });
    }
};
