<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_unit_kerja')->insert([
            ['nama_unit_kerja' => 'Bagian Pengelolaan Layanan Pengadaan Secara Elektronik'],
            ['nama_unit_kerja' => 'Sub Bagian Pembinaan Pengadaan Barang/Jasa'],
            ['nama_unit_kerja' => 'Unit Pelaksana Teknis Pelayanan Pengadaan Barang/Jasa'],
        ]);
    }
}
