<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        $kabId = DB::table('t_kabupaten_kota')
            ->where('nama_kabupaten_kota', 'Surabaya')
            ->value('id');

        $kecamatanList = [
            'Asemrowo',
            'Benowo',
            'Bubutan',
            'Bulak',
            'Dukuh Pakis',
            'Gayungan',
            'Genteng',
            'Gubeng',
            'Gunung Anyar',
            'Jambangan',
            'Karang Pilang',
            'Kenjeran',
            'Krembangan',
            'Lakarsantri',
            'Mulyorejo',
            'Pabean Cantian',
            'Pakal',
            'Rungkut',
            'Sambikerep',
            'Sawahan',
            'Semampir',
            'Simokerto',
            'Sukolilo',
            'Sukomanunggal',
            'Tambaksari',
            'Tandes',
            'Tegalsari',
            'Tenggilis Mejoyo',
            'Wiyung',
            'Wonocolo',
            'Wonokromo',
            // tambahkan daftar kecamatan lainnya...
        ];

        foreach ($kecamatanList as $namaKecamatan) {
            DB::table('t_kecamatan')->insert([
                'nama_kecamatan' => $namaKecamatan,
                'id_kabupaten_kota' => $kabId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
