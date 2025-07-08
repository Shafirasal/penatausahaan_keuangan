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
            'instansi' => 'Dinas Komunikasi dan Informatika',
            'tmt_jabatan' => '2020-01-01',
            'PAK' => 80,
            'status_fungsional' => 'promosi',
            'status_diklat' => 'diklat fungsional',
            'aktif' => 'ya',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
