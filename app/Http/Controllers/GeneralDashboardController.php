<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SshModel;
use App\Models\RealisasiModel;

class GeneralDashboardController extends Controller
{
    /**
     * Halaman utama dashboard
     */
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'General Dashboard',
            'list'  => ['Home', 'General Dashboard']
        ];

        $page = (object) [
            'title' => 'General Dashboard'
        ];

        $activeMenu = 'General Dashboard';

        // 🔹 Ambil tahun dari request atau gunakan default (tahun sekarang)
        $tahunSekarang = date('Y');
        $tahunDipilih = $request->get('tahun', $tahunSekarang);

        // 🔹 Siapkan range tahun untuk dropdown (misalnya 4 tahun terakhir)
        $tahunRange = range($tahunSekarang - 3, $tahunSekarang);

        // 🔹 Panggil fungsi-fungsi dengan filter tahun
        $totalAnggaran = $this->getTotalAnggaran($tahunDipilih);
        $totalRealisasi = $this->getTotalRealisasi($tahunDipilih);
        $totalSisa = $totalAnggaran - $totalRealisasi;

        $realisasiPerKegiatanProgram2 = $this->getRealisasiPerKegiatanProgram2($tahunDipilih);
        $perbandinganAnggaranRealisasiSisa = $this->totalAnggaranRealisasiSisaPerkegiatan($tahunDipilih);
        $totalPBJ = $this->getTotalAnggaranPBJ($tahunDipilih);
        $totalLPSE = $this->getTotalAnggaranLPSE($tahunDipilih);
        $totalPembinaan = $this->getTotalAnggaranPembinaan($tahunDipilih);
        $trenRealisasiPerBulan = $this->getTrenRealisasiPerBulan($tahunDipilih);

        return view('dashboard.index', compact(
            'breadcrumb',
            'page',
            'activeMenu',
            'totalAnggaran',
            'totalRealisasi',
            'totalSisa',
            'realisasiPerKegiatanProgram2',
            'perbandinganAnggaranRealisasiSisa',
            'totalPBJ',
            'totalLPSE',
            'totalPembinaan',
            'tahunRange',
            'tahunSekarang',
            'tahunDipilih',
            'trenRealisasiPerBulan'

        ));
    }

    /**
     * 🔸 Total Anggaran (filter by tahun)
     */
    // public function getTotalAnggaran($tahun)
    // {
    //     return SshModel::whereYear('created_at', $tahun)
    //         ->selectRaw('SUM(COALESCE(NULLIF(pagu2, 0), pagu1, 0)) as total')
    //         ->value('total') ?? 0;
    // }
    public function getTotalAnggaran($tahun)
    {
        return SshModel::selectRaw('
            YEAR(created_at) AS tahun_data,
            SUM(pagu1) AS total_pagu1,
            SUM(pagu2) AS total_pagu2,
            CASE
                WHEN SUM(pagu2) = 0 AND SUM(pagu1) > 0 THEN SUM(pagu1)
                WHEN SUM(pagu2) > 0 THEN SUM(pagu2)
                ELSE 0
            END AS total_dipakai
        ')
        ->groupByRaw('YEAR(created_at)')
        ->whereYear('created_at', $tahun)
        ->value('total_dipakai') ?? 0;
    }

    /**
     * 🔸 Total Realisasi (filter by tahun)
     */
    public function getTotalRealisasi($tahun)
    {
        return RealisasiModel::whereYear('tanggal_realisasi', $tahun)
            ->selectRaw('SUM(nilai_realisasi) as total')
            ->value('total') ?? 0;
    }

    /**
     * 🔸 Persentase realisasi per kegiatan (Program ID = 2, filter tahun)
     */
    public function getRealisasiPerKegiatanProgram2($tahun)
    {
        $data = DB::table('t_transaksional_realisasi_anggaran as tr')
            ->join('t_master_kegiatan as k', 'tr.id_kegiatan', '=', 'k.id_kegiatan')
            ->where('tr.id_program', 2)
            ->whereYear('tr.tanggal_realisasi', $tahun)
            ->select(
                'k.nama_kegiatan',
                DB::raw('SUM(tr.nilai_realisasi) as total_realisasi')
            )
            ->groupBy('tr.id_kegiatan', 'k.nama_kegiatan')
            ->orderBy('total_realisasi', 'DESC')
            ->get();

        $totalKeseluruhan = $data->sum('total_realisasi');

        return $data->map(function ($item) use ($totalKeseluruhan) {
            $item->persentase = $totalKeseluruhan > 0
                ? round(($item->total_realisasi / $totalKeseluruhan) * 100, 2)
                : 0;
            return $item;
        });
    }

    /**
     * 🔸 Total anggaran, realisasi, dan sisa per kegiatan (Program ID = 2, filter tahun)
     */
    public function totalAnggaranRealisasiSisaPerkegiatan($tahun)
    {
        $data = DB::table('t_master_kegiatan as k')
            ->leftJoin('t_ssh as s', 's.id_kegiatan', '=', 'k.id_kegiatan')
            ->leftJoinSub(
                DB::table('t_transaksional_realisasi_anggaran')
                    ->select('id_kegiatan', DB::raw('SUM(nilai_realisasi) as total_realisasi'))
                    ->where('id_program', 2)
                    ->whereYear('tanggal_realisasi', $tahun)
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
            ->whereYear('s.created_at', $tahun)
            ->groupBy('k.id_kegiatan', 'k.nama_kegiatan')
            ->orderBy('k.id_kegiatan')
            ->get();

        return $data;
    }

    /**
     * 🔸 Total anggaran untuk kegiatan PBJ
     */
    public function getTotalAnggaranPBJ($tahun)
    {
        $total = DB::table('t_master_kegiatan as k')
            ->leftJoin('t_ssh as s', 's.id_kegiatan', '=', 'k.id_kegiatan')
            ->where('k.nama_kegiatan', 'Pengelolaan Pengadaan Barang dan Jasa')
            ->whereYear('s.created_at', $tahun)
            ->selectRaw("
                SUM(
                    CASE
                        WHEN s.pagu2 > 0 THEN s.pagu2
                        ELSE s.pagu1
                    END
                ) AS total_anggaran
            ")
            ->value('total_anggaran');

        return $total ?? 0;
    }

    /**
     * 🔸 Total anggaran untuk kegiatan LPSE
     */
    public function getTotalAnggaranLPSE($tahun)
    {
        $total = DB::table('t_master_kegiatan as k')
            ->leftJoin('t_ssh as s', 's.id_kegiatan', '=', 'k.id_kegiatan')
            ->where('k.nama_kegiatan', 'Pengelolaan Layanan Pengadaan Secara Elektronik')
            ->whereYear('s.created_at', $tahun)
            ->selectRaw("
                SUM(
                    CASE
                        WHEN s.pagu2 > 0 THEN s.pagu2
                        ELSE s.pagu1
                    END
                ) AS total_anggaran
            ")
            ->value('total_anggaran');

        return $total ?? 0;
    }

    /**
     * 🔸 Total anggaran untuk kegiatan Pembinaan Pengadaan
     */
    public function getTotalAnggaranPembinaan($tahun)
    {
        $total = DB::table('t_master_kegiatan as k')
            ->leftJoin('t_ssh as s', 's.id_kegiatan', '=', 'k.id_kegiatan')
            ->where('k.nama_kegiatan', 'Pembinaan Pengadaan')
            ->whereYear('s.created_at', $tahun)
            ->selectRaw("
                SUM(
                    CASE
                        WHEN s.pagu2 > 0 THEN s.pagu2
                        ELSE s.pagu1
                    END
                ) AS total_anggaran
            ")
            ->value('total_anggaran');

        return $total ?? 0;
    }

    /**
 * 🔸 Tren Realisasi Per Bulan dengan Persentase (filter by tahun)
 */
public function getTrenRealisasiPerBulan($tahun)
{
    return DB::table('t_transaksional_realisasi_anggaran')
        ->whereYear('tanggal_realisasi', $tahun)
        ->select(
            DB::raw('MONTH(tanggal_realisasi) AS bulan'),
            DB::raw('SUM(nilai_realisasi) AS total_realisasi')
        )
        ->groupBy(DB::raw('MONTH(tanggal_realisasi)'))
        ->orderBy('bulan')
        ->get();
}
}
