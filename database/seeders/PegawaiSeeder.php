<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $provId = DB::table('t_provinsi')->where('nama_provinsi', 'Jawa Timur')->value('id_provinsi');
        $kabId = DB::table('t_kabupaten_kota')->where('nama_kabupaten_kota', 'Kota Surabaya')->value('id_kabupaten_kota');
        $kecId = DB::table('t_kecamatan')->where('nama_kecamatan', 'Bubutan')->value('id_kecamatan');
        $kelId = DB::table('t_kelurahan')->where('nama_kelurahan', 'Alun-Alun Contong')->value('id_kelurahan');

        DB::table('t_pegawai')->insert([
            'nip' => '678901234567890123',
            'nama' => 'kuroo',
            'gelar_depan' => 'Ir.',
            'gelar_belakang' => 'S.T',
            'nik' => '3512345618900004',
            'tempat_lahir' => 'Malang',
            'tanggal_lahir' => '1990-05-10',
            'jenis_kelamin' => 'perempuan',
            'hp' => '08123456789',
            'email' => 'user2@example.com',
            'alamat' => 'Jl. Kedua No.2',
            'rt' => 5,
            'rw' => 6,
            'kode_pos' => '65123',
            'agama' => 'islam',
            'status_kepegawaian' => 'pppk',
            'id_provinsi' => $provId,
            'id_kabupaten_kota' => $kabId,
            'id_kecamatan' => $kecId,
            'id_kelurahan' => $kelId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
