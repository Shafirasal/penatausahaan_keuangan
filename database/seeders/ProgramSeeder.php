<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_master_program')->insert([
            [
                'kode_program' => '40101',
                'nama_program' => 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH PROVINSI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_program' => '40107',
                'nama_program' => 'PROGRAM KEBIJAKAN DAN PELAYANAN PENGADAAN BARANG DAN JASA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}


