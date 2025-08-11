<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelurahanSeeder extends Seeder
{
    public function run(): void
    {
        $provId = DB::table('t_provinsi')
            ->where('nama_provinsi', 'Jawa Timur')
            ->value('id');

        $kabId = DB::table('t_kabupaten_kota')
            ->where('nama_kabupaten_kota', 'Surabaya')
            ->value('id');

        $kelurahanByKecamatan = [
            'Asemrowo' => ['Asemrowo', 'Genting Kalianak', 'Tambak Sarioso'],
            'Benowo' => ['Kandangan', 'Romokalisari', 'Sememi', 'Tambak Osowilangun'],
            'Bubutan' => ['Alun-Alun Contong', 'Bubutan', 'Gundih', 'Jepara', 'Tembok Dukuh'],
            'Bulak' => ['Bulak', 'Kedungcowek', 'Kenjeran', 'Sukolilo Baru'],
            'Dukuh Pakis' => ['Dukuh Kupang', 'Dukuh Pakis', 'Gunung Sari', 'Pradah Kalikendal'],
            'Gayungan' => ['Dukuh Menanggal', 'Gayungan', 'Ketintang', 'Menanggal'],
            'Genteng' => ['Embong Kaliasin', 'Genteng', 'Kapasari', 'Ketabang', 'Peneleh'],
            'Gubeng' => ['Airlangga', 'Barata Jaya', 'Gubeng', 'Kertajaya', 'Mojo', 'Pucangsewu'],
            'Gunung Anyar' => ['Gunung Anyar', 'Gunung Anyar Tambak', 'Rungkut Menanggal', 'Rungkut Tengah'],
            'Jambangan' => ['Jambangan', 'Karah', 'Kebonsari', 'Pagesangan'],
            'Karang Pilang' => ['Karang Pilang', 'Kebraon', 'Kedurus', 'Warugunung'],
            'Kenjeran' => ['Bulakbanteng', 'Tambakwedi', 'Tanah Kalikedinding', 'Sidotopo Wetan'],
            'Krembangan' => ['Dupak', 'Kemayoran', 'Krembangan Selatan', 'Morokrembangan', 'Perak Barat'],
            'Lakarsantri' => ['Bangkingan', 'Jeruk', 'Lakarsantri', 'Lidah Kulon', 'Lidah Wetan', 'Sumur Welut'],
            'Mulyorejo' => ['Dukuh Sutorejo', 'Kalijudan', 'Kalisari', 'Kejawan Putih Tambak', 'Manyar Sabrangan', 'Mulyorejo'],
            'Pabean Cantian' => ['Bongkaran', 'Krembangan Utara', 'Nyamplungan', 'Tanjung Perak'],
            'Pakal' => ['Babat Jerawat', 'Benowo', 'Pakal', 'Sumberejo'],
            'Rungkut' => ['Kali Rungkut', 'Kedung Baruk', 'Medokan Ayu', 'Penjaringan Sari', 'Rungkut Kidul', 'Wonorejo'],
            'Sambikerep' => ['Bringin', 'Made', 'Lontar', 'Sambikerep'],
            'Sawahan' => ['Banyu Urip', 'Kupang Krajan', 'Pakis', 'Petemon', 'Putat Jaya', 'Sawahan'],
            'Semampir' => ['Ampel', 'Pegirian', 'Sidotopo', 'Ujung', 'Wonokusumo'],
            'Simokerto' => ['Kapasan', 'Sidodadi', 'Simokerto', 'Simolawang', 'Tambakrejo'],
            'Sukolilo' => ['Gebang Putih', 'Keputih', 'Klampisngasem', 'Medokan Semampir', 'Menur Pumpungan', 'Nginden Jangkungan', 'Semolowaru'],
            'Sukomanunggal' => ['Putatgede', 'Simomulyo', 'Simomulyo Baru', 'Sonokwijenan', 'Sukomanunggal', 'Tanjungsari'],
            'Tambaksari' => ['Dukuh Setro', 'Gading', 'Kapas Madya', 'Pacar Kembang', 'Pacar Keling', 'Ploso', 'Rangkah', 'Tambaksari'],
            'Tandes' => ['Balongsari', 'Banjar Sugihan', 'Karang Poh', 'Manukan Kulon', 'Manukan Wetan', 'Tandes'],
            'Tegalsari' => ['Dr. Sutomo', 'Kedungdoro', 'Keputran', 'Tegalsari', 'Wonorejo'],
            'Tenggilis Mejoyo' => ['Kendangsari', 'Kutisari', 'Panjang Jiwo', 'Tenggilis Mejoyo'],
            'Wiyung' => ['Babatan', 'Balasklumprik', 'Jajar Tunggal', 'Wiyung'],
            'Wonocolo' => ['Bendul Merisi', 'Jemur Wonosari', 'Margorejo', 'Sidosermo', 'Siwalankerto'],
            'Wonokromo' => ['Darmo', 'Jagir', 'Ngagel', 'Ngagelrejo', 'Sawunggaling', 'Wonokromo'],
        ];

        foreach ($kelurahanByKecamatan as $namaKec => $kelList) {
            $kecId = DB::table('t_kecamatan')
                ->where('nama_kecamatan', $namaKec)
                ->value('id');

            foreach ($kelList as $kel) {
                DB::table('t_kelurahan')->insert([
                    'nama_kelurahan' => $kel,
                    'id_kecamatan' => $kecId,
                    'id_kabupaten_kota' => $kabId,
                    'id_provinsi' => $provId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
