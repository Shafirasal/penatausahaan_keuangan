<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_golongan')->insert([
            ['nama_golongan' => 'I/a - Juru Muda'],
            ['nama_golongan' => 'I/b - Juru Muda Tingkat I'],
            ['nama_golongan' => 'I/c - Juru'],
            ['nama_golongan' => 'I/d - Juru Tingkat I'],
            ['nama_golongan' => 'II/a - Pengatur Muda'],
            ['nama_golongan' => 'II/b - Pengatur Muda Tingkat I'],
            ['nama_golongan' => 'II/c - Pengatur'],
            ['nama_golongan' => 'II/d - Pengatur Tingkat I'],
            ['nama_golongan' => 'III/a - Penata Muda'],
            ['nama_golongan' => 'III/b - Penata Muda Tingkat I'],
            ['nama_golongan' => 'III/c - Penata'],
            ['nama_golongan' => 'III/d - Penata Tingkat I'],
            ['nama_golongan' => 'IV/a - Pembina'],
            ['nama_golongan' => 'IV/b - Pembina Tingkat I'],
            ['nama_golongan' => 'IV/c - Pembina Utama Muda'],
            ['nama_golongan' => 'IV/d - Pembina Utama Madya'],
            ['nama_golongan' => 'IV/e - Pembina Utama'],
        ]);
    }
}
