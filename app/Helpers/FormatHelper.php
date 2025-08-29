<?php

if (!function_exists('formatKode')) {
    function formatKode($kode, $jenis)
    {
        switch ($jenis) {
            case 'program':
                return sprintf(
                    '%s.%s.%s',
                    substr($kode, 0, 1),
                    substr($kode, 1, 2),
                    substr($kode, 3, 2)
                );

            case 'kegiatan':
                return sprintf(
                    '%s.%s.%s.%s.%s',
                    substr($kode, 0, 1),
                    substr($kode, 1, 2),
                    substr($kode, 3, 2),
                    substr($kode, 5, 1),
                    substr($kode, 6, 2)
                );

            case 'sub_kegiatan':
                return sprintf(
                    '%s.%s.%s.%s.%s.%s',
                    substr($kode, 0, 1),
                    substr($kode, 1, 2),
                    substr($kode, 3, 2),
                    substr($kode, 5, 1),
                    substr($kode, 6, 2),
                    substr($kode, 8, 4)
                );

            case 'rekening':
                return sprintf(
                    '%s.%s.%s.%s.%s.%s',
                    substr($kode, 0, 1),
                    substr($kode, 1, 1),
                    substr($kode, 2, 2),
                    substr($kode, 4, 2),
                    substr($kode, 6, 2),
                    substr($kode, 8, 4)
                );

            case 'ssh':
                return sprintf(
                    '%s.%s.%s.%s.%s.%s.%s',
                    substr($kode, 0, 1),
                    substr($kode, 1, 1),
                    substr($kode, 2, 2),
                    substr($kode, 4, 2),
                    substr($kode, 6, 2),
                    substr($kode, 8, 4),
                    substr($kode, 12, 5)
                );

            default:
                return $kode; // Kalau jenis tidak dikenal, kembalikan apa adanya
        }
    }
}