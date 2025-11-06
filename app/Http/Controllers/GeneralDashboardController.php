<?php

namespace App\Http\Controllers;

use App\Models\RealisasiModel;
use App\Models\SshModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralDashboardController extends Controller
{
    /**
     * Halaman utama dashboard
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'General Dashboard',
            'list'  => ['Home', 'General Dashboard']
        ];

        $page = (object) [
            'title' => 'General Dashboard'
        ];

        $activeMenu = 'General Dashboard';
        $totalAnggaran = $this->getTotalAnggaran();
        $totalRealisasi = $this->getTotalRealisasi();
        $totalSisa = $totalAnggaran - $totalRealisasi; 
        // $perbandinganPerTahun = $this->getPerbandinganRealisasiSisaAnggaran();
        // $persentaseRealisasiPerTahun = $this ->getPersentaseRealisasiPerTahun();
        $realisasiPerKegiatanProgram2 = $this->getRealisasiPerKegiatanProgram2();
        $perbandinganAnggaranRealisasiSisa = $this->totalAnggaranRealisasiSisaPerkegiatan();
        

        return view('dashboard.index', compact(
    'breadcrumb', 'page', 'activeMenu', 'totalAnggaran',
             'totalSisa', 'totalRealisasi', 'realisasiPerKegiatanProgram2', 'perbandinganAnggaranRealisasiSisa'
            
            ));
    }

    /**
     * Mengambil total anggaran dari tabel SSH
     */
    public function getTotalAnggaran()
    {
        return SshModel::selectRaw('SUM(COALESCE(NULLIF(pagu2, 0), pagu1, 0)) as total')->value('total') ?? 0;
    }

    public function getTotalRealisasi()
    {
        return RealisasiModel::selectRaw('SUM(nilai_realisasi) as total')->value('total') ?? 0;
    }

    //menghitung presentase otal realisasi pada kegiatan di program id 2
    public function getRealisasiPerKegiatanProgram2()
    {
    $data = DB::table('t_transaksional_realisasi_anggaran as tr')
        ->join('t_master_kegiatan as k', 'tr.id_kegiatan', '=', 'k.id_kegiatan')
        ->where('tr.id_program', 2)
        ->select(
            'k.nama_kegiatan',
            DB::raw('SUM(tr.nilai_realisasi) as total_realisasi')
        )
        ->groupBy('tr.id_kegiatan', 'k.nama_kegiatan')
        ->orderBy('total_realisasi', 'DESC')
        ->get();

    // Hitung total keseluruhan untuk persentase
    $totalKeseluruhan = $data->sum('total_realisasi');

    // Tambahkan persentase ke setiap item
    $dataWithPercentage = $data->map(function ($item) use ($totalKeseluruhan) {
        $item->persentase = $totalKeseluruhan > 0 
            ? round(($item->total_realisasi / $totalKeseluruhan) * 100, 2) 
            : 0;
        return $item;
    });

    return $dataWithPercentage;
    }



     public function totalAnggaranRealisasiSisaPerkegiatan()
    {
        $data = DB::table('t_master_kegiatan as k')
            ->leftJoin('t_ssh as s', 's.id_kegiatan', '=', 'k.id_kegiatan')
            ->leftJoinSub(
                DB::table('t_transaksional_realisasi_anggaran')
                    ->select('id_kegiatan', DB::raw('SUM(nilai_realisasi) as total_realisasi'))
                    ->where('id_program', 2)
                    ->groupBy('id_kegiatan'),
                'tr',
                function ($join) {
                    $join->on('tr.id_kegiatan', '=', 'k.id_kegiatan');
                }
            )
            ->select(
                'k.id_kegiatan',
                'k.nama_kegiatan',
                DB::raw("
                    SUM(
                        CASE 
                            WHEN s.pagu2 IS NOT NULL AND s.pagu2 > 0 THEN s.pagu2
                            ELSE s.pagu1
                        END
                    ) AS total_anggaran
                "),
                DB::raw("COALESCE(SUM(DISTINCT tr.total_realisasi), 0) AS total_realisasi"),
                DB::raw("
                    (
                        SUM(
                            CASE 
                                WHEN s.pagu2 IS NOT NULL AND s.pagu2 > 0 THEN s.pagu2
                                ELSE s.pagu1
                            END
                        ) - COALESCE(SUM(DISTINCT tr.total_realisasi), 0)
                    ) AS sisa_anggaran
                ")
            )
            ->where('k.id_program', 2)
            ->groupBy('k.id_kegiatan', 'k.nama_kegiatan')
            ->orderBy('k.id_kegiatan')
            ->get();

       return $data;

    }
}
