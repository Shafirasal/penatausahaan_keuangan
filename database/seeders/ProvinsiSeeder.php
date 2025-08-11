<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('t_provinsi')->insert([
            'nama_provinsi' => 'Jawa Timur',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
