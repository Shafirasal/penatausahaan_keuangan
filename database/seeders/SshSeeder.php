<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SshSeeder extends Seeder
{
    public function run(): void
    {
        // Struktur yang diperbaiki
        $data = [
            '40107' => [
                '40107103' => [
                    '401071030001' => [
                        '510201010025' => [
                            ['kode_ssh' => '11120103000200034', 'nama_ssh' => 'Fotokopi', 'pagu' => 472844, 'periode' => '1', 'tahun' => null],
                        ],
                        '510201010032' => [
                            ['kode_ssh' => '11120103000900071', 'nama_ssh' => 'Pakaian Dinas Lapangan', 'pagu' => 14628000, 'periode' => '1', 'tahun' => null],
                        ],
                        '510201010035' => [
                            ['kode_ssh' => '11120103001200018', 'nama_ssh' => 'Hand Bag', 'pagu' => 31040000, 'periode' => '1', 'tahun' => null],
                        ],
                        '510201010052' => [
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 18480000, 'periode' => '1', 'tahun' => null],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 9200000, 'periode' => '1', 'tahun' => null],
                        ],
                        '510202010026' => [
                            ['kode_ssh' => '81020201002600012', 'nama_ssh' => 'Honorarium Jasa Tenaga Administrasi', 'pagu' => 168000000, 'periode' => '1', 'tahun' => null],
                            ['kode_ssh' => '81020201002600038', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi', 'pagu' => 84000000, 'periode' => '1', 'tahun' => null],
                            ['kode_ssh' => '81020201002600072', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi', 'pagu' => 54720000, 'periode' => '1', 'tahun' => null],
                        ],
                        '510202010047' => [
                            ['kode_ssh' => '81020201004700018', 'nama_ssh' => 'Jasa Event Organizer', 'pagu' => 71200000, 'periode' => '1', 'tahun' => null],
                            ['kode_ssh' => '81020201004700020', 'nama_ssh' => 'Jasa Event Organizer Pameran/Pelaksanaan Kegiatan', 'pagu' => 0, 'periode' => '1', 'tahun' => null],
                            ['kode_ssh' => '81020201004700067', 'nama_ssh' => 'Jasa Event Organizer Pameran/Pelaksanaan Kegiatan', 'pagu' => 50450600, 'periode' => '1', 'tahun' => null],
                        ],
                        '510202020005' => [
                            ['kode_ssh' => '81020202000500053', 'nama_ssh' => '# Iuran Jaminan Kesehatan (BPJS) Non ASN', 'pagu' => 7144956, 'periode' => '1', 'tahun' => null],
                        ],
                        '510202020006' => [
                            ['kode_ssh' => '81020202000600007', 'nama_ssh' => 'Jaminan Kecelakaan Kerja (JKK) Non ASN', 'pagu' => 345600, 'periode' => '1', 'tahun' => null],
                        ],
                        '510202020007' => [
                            ['kode_ssh' => '81020202000700007', 'nama_ssh' => 'Jaminan Kematian (JKM) Non ASN', 'pagu' => 432000, 'periode' => '1', 'tahun' => null],
                        ],
                        '510202040036' => [
                            ['kode_ssh' => '81020204003600117', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4', 'pagu' => 1231000, 'periode' => '1', 'tahun' => null],
                        ],
                        '510202120001' => [
                            ['kode_ssh' => '81020213000100017', 'nama_ssh' => 'Beban Kursus Singkat/Pelatihan', 'pagu' => 294400000, 'periode' => '1', 'tahun' => null],
                        ],
                        '510204010003' => [
                            ['kode_ssh' => '81020401000300340', 'nama_ssh' => 'Uang Transport Perjalanan dinas di dalam kota yang kurang dari 8 (delapan) jam', 'pagu' => 13600000, 'periode' => '1', 'tahun' => null],
                        ],
                    ],
                ],
            ],
        ];

        $insertedCount = 0;
        $skippedCount = 0;

        foreach ($data as $kodeProgram => $listKegiatan) {
            echo "Processing Program: $kodeProgram\n";
            
            $programId = DB::table('t_master_program')
                ->where('kode_program', $kodeProgram)
                ->value('id_program');

            if (!$programId) {
                echo "❌ Program $kodeProgram tidak ditemukan\n";
                continue;
            }
            echo "✅ Program ID: $programId\n";

            foreach ($listKegiatan as $kodeKegiatan => $listSubKegiatan) {
                echo "  Processing Kegiatan: $kodeKegiatan\n";
                
                $kegiatanId = DB::table('t_master_kegiatan')
                    ->where('kode_kegiatan', $kodeKegiatan)
                    ->where('id_program', $programId)
                    ->value('id_kegiatan');

                if (!$kegiatanId) {
                    echo "  ❌ Kegiatan $kodeKegiatan tidak ditemukan\n";
                    continue;
                }
                echo "  ✅ Kegiatan ID: $kegiatanId\n";

                foreach ($listSubKegiatan as $kodeSubKegiatan => $listRekening) {
                    echo "    Processing Sub Kegiatan: $kodeSubKegiatan\n";
                    
                    $subKegiatanId = DB::table('t_master_sub_kegiatan')
                        ->where('kode_sub_kegiatan', $kodeSubKegiatan)
                        ->where('id_program', $programId)
                        ->where('id_kegiatan', $kegiatanId)
                        ->value('id_sub_kegiatan');

                    if (!$subKegiatanId) {
                        echo "    ❌ Sub Kegiatan $kodeSubKegiatan tidak ditemukan\n";
                        continue;
                    }
                    echo "    ✅ Sub Kegiatan ID: $subKegiatanId\n";

                    foreach ($listRekening as $kodeRekening => $listSsh) {
                        echo "      Processing Rekening: $kodeRekening\n";
                        
                        $rekeningId = DB::table('t_rekening')
                            ->where('kode_rekening', $kodeRekening)
                            ->where('id_program', $programId)
                            ->where('id_kegiatan', $kegiatanId)
                            ->where('id_sub_kegiatan', $subKegiatanId)
                            ->value('id_rekening');

                        if (!$rekeningId) {
                            echo "      ❌ Rekening $kodeRekening tidak ditemukan\n";
                            continue;
                        }
                        echo "      ✅ Rekening ID: $rekeningId\n";

                        foreach ($listSsh as $ssh) {
                            echo "        Processing SSH: {$ssh['kode_ssh']}\n";
                            
                            // Cek apakah SSH sudah ada
                            $existingSsh = DB::table('t_ssh')
                                ->where('kode_ssh', $ssh['kode_ssh'])
                                ->where('id_program', $programId)
                                ->where('id_kegiatan', $kegiatanId)
                                ->where('id_sub_kegiatan', $subKegiatanId)
                                ->where('id_rekening', $rekeningId)
                                ->exists();

                            if ($existingSsh) {
                                echo "        ⏭️  SSH {$ssh['kode_ssh']} sudah ada, skip\n";
                                $skippedCount++;
                                continue;
                            }

                            try {
                                DB::table('t_ssh')->insert([
                                    'kode_ssh' => $ssh['kode_ssh'],
                                    'id_program' => $programId,
                                    'id_kegiatan' => $kegiatanId,
                                    'id_sub_kegiatan' => $subKegiatanId,
                                    'id_rekening' => $rekeningId,
                                    'nama_ssh' => $ssh['nama_ssh'],
                                    'pagu' => $ssh['pagu'],
                                    'periode' => $ssh['periode'],
                                    'tahun' => $ssh['tahun'],
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                                
                                echo "        ✅ SSH {$ssh['kode_ssh']} berhasil disimpan\n";
                                $insertedCount++;
                                
                            } catch (\Exception $e) {
                                echo "        ❌ Error inserting SSH {$ssh['kode_ssh']}: " . $e->getMessage() . "\n";
                            }
                        }
                    }
                }
            }
        }

        echo "\n=== SUMMARY ===\n";
        echo "Data berhasil disimpan: $insertedCount\n";
        echo "Data di-skip: $skippedCount\n";
        echo "Total: " . ($insertedCount + $skippedCount) . "\n";
    }
}