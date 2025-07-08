<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('t_pendidikan')->insert([
    [
        'nip' => '12345',
        'nama_sekolah' => 'sd negeri 1 surabaya',
        'tingkat' => 'sd',
        'prodi_jurusan' => '',
        'tahun_lulus' => 1997,
        'aktif' => 'tidak',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'nip' => '12345',
        'nama_sekolah' => 'smp negeri 2 surabaya',
        'tingkat' => 'smp',
        'prodi_jurusan' => '',
        'tahun_lulus' => 2000,
        'aktif' => 'tidak',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'nip' => '12345',
        'nama_sekolah' => 'sma negeri 3 surabaya',
        'tingkat' => 'sma/smk',
        'prodi_jurusan' => 'ipa',
        'tahun_lulus' => 2003,
        'aktif' => 'tidak',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'nip' => '12345',
        'nama_sekolah' => 'universitas airlangga',
        'tingkat' => 's1',
        'prodi_jurusan' => 'ilmu komputer',
        'tahun_lulus' => 2008,
        'aktif' => 'tidak',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'nip' => '12345',
        'nama_sekolah' => 'institut teknologi bandung',
        'tingkat' => 's3',
        'prodi_jurusan' => 'sistem informasi',
        'tahun_lulus' => 2018,
        'aktif' => 'ya',
        'created_at' => now(),
        'updated_at' => now(),
    ]   ]);
    }
}
