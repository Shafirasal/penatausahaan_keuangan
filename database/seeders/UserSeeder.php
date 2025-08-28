<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tambah data provinsi, kabupaten, kecamatan dummy
        $provId = DB::table('t_provinsi')->insertGetId([
            'nama_provinsi' => 'Jawa Timur'
        ]);

        $kabId = DB::table('t_kabupaten_kota')->insertGetId([
            'nama_kabupaten_kota' => 'Surabaya',
            'id_provinsi' => $provId,
        ]);

        $kecId = DB::table('t_kecamatan')->insertGetId([
            'nama_kecamatan' => 'Bubutan',
            'id_kabupaten_kota' => $kabId,
        ]);

        $kelId = DB::table('t_kelurahan')->insertGetId([
            'nama_kelurahan' => 'Alun-Alun Contong',
            'id_kecamatan' => $kecId,
        ]);

        // Tambah pegawai kedua
        DB::table('t_pegawai')->insert([
            'nip' => '23456',
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

        // Tambah user login kedua
        // DB::table('t_user')->insert([
        //     'nip' => '45678',
        //     'level' => 'pegawai',
        //     'password' => Hash::make('45678'),
        // ]);

    }
}
