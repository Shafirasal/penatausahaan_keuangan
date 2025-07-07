<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanFungsionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_jabatan_fungsional')->insert([
            'nip' => '12345',
            'nama_jabatan' => 'Analis Data',
            'tmt_jabatan' => 2020,
            'status_fungsional' => 'ya',
            'status_diklat' => 'tidak',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
