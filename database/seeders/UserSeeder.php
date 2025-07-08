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

        // Tambah data pegawai
        DB::table('t_pegawai')->insert([
            'nip' => '12345',
            'nama' => 'atmin',
            'gelar_depan' => 'Dr.',
            'gelar_belakang' => 'M.Kom',
            'nik' => '3512345678900003',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1985-01-01',
            'jenis_kelamin' => 'laki-laki',
            'hp' => '08123422349',
            'email' => 'pegawai2@example.com',
            'alamat' => 'Jl. Contoh No.1',
            'rt' => 1,
            'rw' => 2,
            'kode_pos' => '60261',
            'agama' => 'islam',
            'status_kepegawaian' => 'pppk',
            'id_provinsi' => $provId,
            'id_kabupaten_kota' => $kabId,
            'id_kecamatan' => $kecId,
            'id_kelurahan' => $kelId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambah user login
        DB::table('t_user')->insert([
            'nip' => '12345',
            'level' => 'admin',
            'password' => Hash::make('12345'),
        ]);
    }
}
