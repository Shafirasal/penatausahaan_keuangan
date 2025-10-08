<?php

namespace App\Http\Controllers;

use App\Models\MasterProgramModel;
use App\Models\MasterKegiatanModel;
use App\Models\MasterSubKegiatanModel;
use App\Models\RekeningModel;
use App\Models\SshModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yajra\DataTables\Facades\DataTables;


class TreeViewController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Tree View SSH',
            'list'  => ['Home', 'Tree View SSH']
        ];

        $page = (object)[
            'title' => 'Data Rekening ➜ SSH (Tree)'
        ];

        $activeMenu = 'tree_view';

        // dropdown Program (tampilkan kode yang sudah diformat)
        $listProgram = MasterProgramModel::select('id_program', 'kode_program', 'nama_program')
            ->orderBy('kode_program')
            ->get()
            ->map(function ($p) {
                $p->kode_program = formatKode($p->kode_program, 'program');
                return $p;
            });

        $tahunSekarang = now()->year;
        $tahunRange = range(2013, $tahunSekarang + 3);

        // view: resources/views/tree_view/index.blade.php
        return view('tree_view.index', compact('breadcrumb', 'page', 'activeMenu', 'listProgram', 'tahunSekarang', 'tahunRange'));
    }

    /** Dropdown: Kegiatan by Program (kode diformat) */
    public function getKegiatanByProgram($id_program)
    {
        $rows = MasterKegiatanModel::where('id_program', $id_program)
            ->select('id_kegiatan', 'kode_kegiatan', 'nama_kegiatan')
            ->orderBy('kode_kegiatan')
            ->get()
            ->map(function ($r) {
                $r->kode_kegiatan = formatKode($r->kode_kegiatan, 'kegiatan');
                return $r;
            });

        return response()->json($rows);
    }

    /** Dropdown: Sub Kegiatan by Kegiatan (kode diformat) */
    public function getSubKegiatanByKegiatan($id_kegiatan)
    {
        $rows = MasterSubKegiatanModel::where('id_kegiatan', $id_kegiatan)
            ->select('id_sub_kegiatan', 'kode_sub_kegiatan', 'nama_sub_kegiatan')
            ->orderBy('kode_sub_kegiatan')
            ->get()
            ->map(function ($r) {
                $r->kode_sub_kegiatan = formatKode($r->kode_sub_kegiatan, 'sub_kegiatan');
                return $r;
            });

        return response()->json($rows);
    }

    /**
     * DataTables level-1: Sub Kegiatan dengan realisasi yang benar
     */
    public function listSubKegiatan(Request $request)
    {
        $id_program      = $request->id_program;
        $id_kegiatan     = $request->id_kegiatan;
        $id_sub_kegiatan = $request->id_sub_kegiatan;
        $tahun = $request->tahun ?? now()->year;
        $ssh_search = $request->ssh_search; // 👈 tambahan SEARCH

        $q = MasterSubKegiatanModel::query()
            ->select([
                't_master_sub_kegiatan.id_sub_kegiatan',
                't_master_sub_kegiatan.kode_sub_kegiatan',
                't_master_sub_kegiatan.nama_sub_kegiatan',
                // Ambil SUM pagu langsung dari t_ssh (tanpa join realisasi)
                DB::raw("(SELECT COALESCE(SUM(pagu1),0) FROM t_ssh
                  WHERE t_ssh.id_sub_kegiatan = t_master_sub_kegiatan.id_sub_kegiatan
                  AND YEAR(t_ssh.tahun) = {$tahun}) AS p1"),
                DB::raw("(SELECT COALESCE(SUM(pagu2),0) FROM t_ssh
                  WHERE t_ssh.id_sub_kegiatan = t_master_sub_kegiatan.id_sub_kegiatan
                  AND YEAR(t_ssh.tahun) = {$tahun}) AS p2"),
                // Total realisasi dipisah subquery agar tidak duplikasi
                DB::raw("(SELECT COALESCE(SUM(nilai_realisasi),0)
                  FROM t_transaksional_realisasi_anggaran r
                  WHERE r.id_sub_kegiatan = t_master_sub_kegiatan.id_sub_kegiatan) AS total_realisasi")
            ])
            ->addSelect(DB::raw("(
        (SELECT COALESCE(SUM(CASE WHEN pagu2 > 0 THEN pagu2 ELSE pagu1 END),0)
         FROM t_ssh WHERE t_ssh.id_sub_kegiatan = t_master_sub_kegiatan.id_sub_kegiatan
         AND YEAR(t_ssh.tahun) = {$tahun})
        -
        (SELECT COALESCE(SUM(nilai_realisasi),0)
         FROM t_transaksional_realisasi_anggaran r
         WHERE r.id_sub_kegiatan = t_master_sub_kegiatan.id_sub_kegiatan)
    ) as sisa_total"))
            ->when($id_program, fn($x) => $x->where('t_master_sub_kegiatan.id_program', $id_program))
            ->when($id_kegiatan, fn($x) => $x->where('t_master_sub_kegiatan.id_kegiatan', $id_kegiatan))
            ->when($id_sub_kegiatan, fn($x) => $x->where('t_master_sub_kegiatan.id_sub_kegiatan', $id_sub_kegiatan));

        // 🔍 tambahan: filter jika ssh_search ada SEARCH
        if (!empty($ssh_search) && strlen($ssh_search) >= 3) {
            $q->whereExists(function ($query) use ($ssh_search, $tahun) {
                $query->select(DB::raw(1))
                    ->from('t_ssh')
                    ->whereColumn('t_ssh.id_sub_kegiatan', 't_master_sub_kegiatan.id_sub_kegiatan')
                    ->where(function ($q) use ($ssh_search) {
                        $q->where('t_ssh.kode_ssh', 'LIKE', "%{$ssh_search}%")
                            ->orWhere('t_ssh.nama_ssh', 'LIKE', "%{$ssh_search}%");
                    })
                    ->whereYear('t_ssh.tahun', $tahun);
            });
        }
        $q->groupBy('t_master_sub_kegiatan.id_sub_kegiatan', 't_master_sub_kegiatan.kode_sub_kegiatan', 't_master_sub_kegiatan.nama_sub_kegiatan');

        return DataTables::of($q)
            ->addIndexColumn()
            ->addColumn(
                'expand',
                fn($row) =>
                '<a href="#" class="btn btn-sm btn-outline-primary btn-expand-sub" data-id="' . $row->id_sub_kegiatan . '">
                <i class="fas fa-chevron-right"></i>
             </a>'
            )
            ->addColumn('kode', fn($row) => formatKode($row->kode_sub_kegiatan, 'sub_kegiatan'))
            ->addColumn(
                'uraian',
                fn($row) =>
                '<span class="px-2 py-1" style="background-color: #ffA500; color:#663c00; border-radius:4px;">
        ' . e($row->nama_sub_kegiatan) . '
    </span>'
            )
            ->addColumn('p1', fn($row) => number_format((float)$row->p1, 0, ',', '.'))
            ->addColumn('p2', fn($row) => number_format((float)$row->p2, 0, ',', '.'))
            ->addColumn('real', fn($row) => number_format((float)$row->total_realisasi, 0, ',', '.'))
            ->addColumn('sisa', fn($row) => number_format((float)$row->sisa_total, 0, ',', '.'))
            ->rawColumns(['expand', 'uraian'])
            ->toJson();
    }

    public function listRekeningBySubKegiatan($id_sub_kegiatan, Request $request)
    {
        $id_program   = $request->query('id_program');
        $id_kegiatan  = $request->query('id_kegiatan');
        $filter_sub   = $request->query('id_sub_kegiatan');
        $tahun        = $request->tahun ?? now()->year;
        $ssh_search   = $request->query('ssh_search'); // UNTUK SEARCH

        $rekening = RekeningModel::query()
            ->from('t_rekening')
            ->select([
                't_rekening.id_rekening',
                't_rekening.kode_rekening',
                't_rekening.nama_rekening',
                't_master_sub_kegiatan.kode_sub_kegiatan',

                // ✅ SUM pagu dari SSH saja (tanpa join realisasi)
                DB::raw("(SELECT COALESCE(SUM(pagu1),0)
                      FROM t_ssh
                      WHERE t_ssh.id_rekening = t_rekening.id_rekening
                        AND t_ssh.id_sub_kegiatan = {$id_sub_kegiatan}
                        AND YEAR(t_ssh.tahun) = {$tahun}) AS p1"),

                DB::raw("(SELECT COALESCE(SUM(pagu2),0)
                      FROM t_ssh
                      WHERE t_ssh.id_rekening = t_rekening.id_rekening
                        AND t_ssh.id_sub_kegiatan = {$id_sub_kegiatan}
                        AND YEAR(t_ssh.tahun) = {$tahun}) AS p2"),

                // ✅ SUM realisasi dari tabel realisasi langsung
                DB::raw("(SELECT COALESCE(SUM(nilai_realisasi),0)
                      FROM t_transaksional_realisasi_anggaran r
                      WHERE r.id_rekening = t_rekening.id_rekening
                        AND r.id_sub_kegiatan = {$id_sub_kegiatan}) AS total_realisasi"),

                // ✅ sisa = pagu - realisasi
                DB::raw("(
                (SELECT COALESCE(SUM(CASE WHEN pagu2 > 0 THEN pagu2 ELSE pagu1 END),0)
                 FROM t_ssh
                 WHERE t_ssh.id_rekening = t_rekening.id_rekening
                   AND t_ssh.id_sub_kegiatan = {$id_sub_kegiatan}
                   AND YEAR(t_ssh.tahun) = {$tahun})
                -
                (SELECT COALESCE(SUM(nilai_realisasi),0)
                 FROM t_transaksional_realisasi_anggaran r
                 WHERE r.id_rekening = t_rekening.id_rekening
                   AND r.id_sub_kegiatan = {$id_sub_kegiatan})
            ) as sisa_total"),
            ])
            ->leftJoin('t_master_sub_kegiatan', 't_master_sub_kegiatan.id_sub_kegiatan', '=', 't_rekening.id_sub_kegiatan')
            ->where('t_rekening.id_sub_kegiatan', $id_sub_kegiatan)
            ->when($id_program, fn($x) => $x->where('t_rekening.id_program', $id_program))
            ->when($id_kegiatan, fn($x) => $x->where('t_rekening.id_kegiatan', $id_kegiatan))
            ->when($filter_sub, fn($x) => $x->where('t_rekening.id_sub_kegiatan', $filter_sub))

            // ✅ search SSH tetap jalan
            ->when(!empty($ssh_search) && strlen($ssh_search) >= 3, function ($q) use ($ssh_search, $tahun) {
                $q->whereExists(function ($sub) use ($ssh_search, $tahun) {
                    $sub->select(DB::raw(1))
                        ->from('t_ssh')
                        ->whereColumn('t_ssh.id_rekening', 't_rekening.id_rekening')
                        ->where(function ($xx) use ($ssh_search) {
                            $xx->where('t_ssh.kode_ssh', 'LIKE', "%{$ssh_search}%")
                                ->orWhere('t_ssh.nama_ssh', 'LIKE', "%{$ssh_search}%");
                        })
                        ->whereYear('t_ssh.tahun', $tahun);
                });
            })
            ->orderBy('t_rekening.kode_rekening')
            ->get();

        // generate HTML
        $html = '';
        foreach ($rekening as $row) {
            $html .= '<tr class="child-of-' . $id_sub_kegiatan . '">';
            $html .= '<td class="text-center">
            <a href="#" class="btn btn-sm btn-outline-secondary btn-expand-rek" data-id="' . $row->id_rekening . '">
                <i class="fas fa-chevron-right"></i>
            </a>
        </td>';
            $html .= '<td>' .  e(formatKode($row->kode_sub_kegiatan, 'sub_kegiatan')) . '.' . e(formatKode($row->kode_rekening, 'rekening')) . '</td>';
            $html .= '<td><span class="px-2 py-1 rounded" style="background:#fff3cd; color:#856404;">' . e($row->nama_rekening) . '</span></td>';
            $html .= '<td class="text-right">' . number_format($row->p1, 0, ',', '.') . '</td>';
            $html .= '<td class="text-right">' . number_format($row->p2, 0, ',', '.') . '</td>';
            $html .= '<td class="text-right">' . number_format($row->total_realisasi, 0, ',', '.') . '</td>';
            $html .= '<td class="text-right">' . number_format((float)$row->sisa_total, 0, ',', '.') . '</td>';
            $html .= '</tr>';
        }

        if ($rekening->isEmpty()) {
            $html .= '<tr class="child-of-' . $id_sub_kegiatan . '"><td colspan="7" class="text-center text-muted">Tidak ada data rekening.</td></tr>';
        }

        return response($html);
    }


    public function listRekening(Request $request)
    {
        $id_program      = $request->id_program;
        $id_kegiatan     = $request->id_kegiatan;
        $id_sub_kegiatan = $request->id_sub_kegiatan;
        $tahun = $request->tahun ?? now()->year;

        // Subquery untuk SSH
        $sshAgg = DB::table('t_ssh')
            ->select(
                'id_rekening',
                DB::raw("COALESCE(SUM(pagu1),0) AS total_p1"),
                DB::raw("COALESCE(SUM(pagu2),0) AS total_p2")
            )
            ->whereYear('tahun', $tahun)
            ->when($id_program, fn($q) => $q->where('id_program', $id_program))
            ->when($id_kegiatan, fn($q) => $q->where('id_kegiatan', $id_kegiatan))
            ->when($id_sub_kegiatan, fn($q) => $q->where('id_sub_kegiatan', $id_sub_kegiatan))
            ->groupBy('id_rekening');

        // Subquery untuk Realisasi
        $realAgg = DB::table('t_transaksional_realisasi_anggaran')
            ->select(
                'id_rekening',
                DB::raw("COALESCE(SUM(nilai_realisasi),0) AS total_real")
            )
            ->groupBy('id_rekening');

        $q = RekeningModel::query()
            ->from('t_rekening')
            ->select([
                't_rekening.id_rekening',
                't_rekening.kode_rekening',
                't_rekening.nama_rekening',
                't_rekening.id_program',
                't_rekening.id_kegiatan',
                't_rekening.id_sub_kegiatan',
                't_master_sub_kegiatan.kode_sub_kegiatan',
                DB::raw("COALESCE(ssh.total_p1,0) as anggaran_periode1"),
                DB::raw("COALESCE(ssh.total_p2,0) as anggaran_periode2"),
                DB::raw("COALESCE(real.total_real,0) as total_realisasi"),
                DB::raw("(
                COALESCE(CASE WHEN ssh.total_p2 > 0 THEN ssh.total_p2 ELSE ssh.total_p1 END,0)
                - COALESCE(real.total_real,0)
            ) as sisa_total")
            ])
            ->leftJoinSub($sshAgg, 'ssh', 'ssh.id_rekening', '=', 't_rekening.id_rekening')
            ->leftJoinSub($realAgg, 'real', 'real.id_rekening', '=', 't_rekening.id_rekening')
            ->leftJoin('t_master_sub_kegiatan', 't_master_sub_kegiatan.id_sub_kegiatan', '=', 't_rekening.id_sub_kegiatan')
            ->when($id_program, fn($x) => $x->where('t_rekening.id_program', $id_program))
            ->when($id_kegiatan, fn($x) => $x->where('t_rekening.id_kegiatan', $id_kegiatan))
            ->when($id_sub_kegiatan, fn($x) => $x->where('t_rekening.id_sub_kegiatan', $id_sub_kegiatan));

        return DataTables::of($q)
            ->addIndexColumn()
            ->addColumn(
                'expand',
                fn($row) =>
                '<a href="#" class="btn btn-sm btn-outline-primary btn-expand" data-id="' . $row->id_rekening . '"><i class="fas fa-chevron-right"></i></a>'
            )
            ->addColumn('kode', function ($row) {
                return formatKode($row->kode_sub_kegiatan, 'sub_kegiatan') . '.' .
                    formatKode($row->kode_rekening, 'rekening');
            })
            ->addColumn(
                'uraian',
                fn($row) =>
                '<span class="px-2 py-1 rounded" style="background-color:#fff3cd; color:#856404;">'
                    . e($row->nama_rekening) .
                    '</span>'
            )
            ->addColumn('p1', fn($row) => number_format((float)$row->anggaran_periode1, 0, ',', '.'))
            ->addColumn('p2', fn($row) => number_format((float)$row->anggaran_periode2, 0, ',', '.'))
            ->addColumn('real', fn($row) => number_format((float)$row->total_realisasi, 0, ',', '.'))
            ->addColumn('sisa', fn($row) => number_format((float)$row->sisa_total, 0, ',', '.'))
            ->rawColumns(['expand', 'uraian'])
            ->toJson();
    }

    /**
     * Child rows: tabel SSH di bawah suatu Rekening dengan realisasi yang benar
     */
    public function listSshByRekening($id_rekening, Request $request)
    {
        $id_program      = $request->query('id_program');
        $id_kegiatan     = $request->query('id_kegiatan');
        $id_sub_kegiatan = $request->query('id_sub_kegiatan');
        $tahun = $request->tahun ?? now()->year;
        $ssh_search = $request->query('ssh_search'); //UNTUK SEARCH

        $ssh = SshModel::query()
            ->from('t_ssh')
            ->select([
                't_ssh.id_ssh',
                't_ssh.kode_ssh',
                't_ssh.nama_ssh',
                't_rekening.kode_rekening',
                't_master_sub_kegiatan.kode_sub_kegiatan',
                DB::raw("COALESCE(t_ssh.pagu1,0) AS p1"),
                DB::raw("COALESCE(t_ssh.pagu2,0) AS p2"),
                DB::raw("COALESCE(SUM(realisasi.nilai_realisasi),0) AS total_realisasi"),
                DB::raw("(COALESCE(CASE WHEN t_ssh.pagu2 > 0 THEN t_ssh.pagu2 ELSE t_ssh.pagu1 END,0) - COALESCE(SUM(realisasi.nilai_realisasi),0)) AS sisa_total")
            ])
            ->leftJoin('t_master_sub_kegiatan', 't_master_sub_kegiatan.id_sub_kegiatan', '=', 't_ssh.id_sub_kegiatan')
            ->leftJoin('t_rekening', 't_rekening.id_rekening', '=', 't_ssh.id_rekening')
            ->leftJoin('t_transaksional_realisasi_anggaran as realisasi', function ($join) {
                $join->on('realisasi.id_ssh', '=', 't_ssh.id_ssh');
            })
            ->where('t_ssh.id_rekening', $id_rekening)
            ->when($id_program, fn($x) => $x->where('t_ssh.id_program', $id_program))
            ->when($id_kegiatan, fn($x) => $x->where('t_ssh.id_kegiatan', $id_kegiatan))
            ->when($id_sub_kegiatan, fn($x) => $x->where('t_ssh.id_sub_kegiatan', $id_sub_kegiatan))
            ->whereYear('t_ssh.tahun', $tahun)
            // 🔍 tambahan: filter SSH langsung UNTUK SEARCH
            ->when(!empty($ssh_search) && strlen($ssh_search) >= 3, function ($x) use ($ssh_search) {
                $x->where(function ($q) use ($ssh_search) {
                    $q->where('t_ssh.kode_ssh', 'LIKE', "%{$ssh_search}%")
                        ->orWhere('t_ssh.nama_ssh', 'LIKE', "%{$ssh_search}%");
                });
            })
            ->groupBy(
                't_ssh.id_ssh',
                't_ssh.kode_ssh',
                't_ssh.nama_ssh',
                't_ssh.pagu1',
                't_ssh.pagu2',
                't_ssh.id_rekening',
                't_ssh.id_sub_kegiatan',
                't_master_sub_kegiatan.kode_sub_kegiatan',
                't_rekening.kode_rekening'
            )
            ->orderBy('t_ssh.kode_ssh')
            ->get();

        $html = '';
        foreach ($ssh as $row) {
            $namaSSH = $row->nama_ssh;
            if (!empty($ssh_search)) {
                $namaSSH = preg_replace('/(' . preg_quote($ssh_search, '/') . ')/i', '<mark>$1</mark>', $namaSSH);
            }
            $html .= '<tr class="child-of-' . $id_rekening . '">';
            $html .= '<td></td>'; // kolom expand kosong
            $html .= '<td>' . e(formatKode($row->kode_sub_kegiatan, 'sub_kegiatan')) . '.' . e(formatKode($row->kode_rekening, 'rekening')) . '.' . e(formatKode($row->kode_ssh, 'ssh')) . '</td>';
            $html .= '<td><span class="px-2 py-1" style="background-color:#d4edda; color:#155724;">' . $namaSSH . '</span></td>';
            $html .= '<td class="text-right">' . number_format($row->p1, 0, ',', '.') . '</td>';
            $html .= '<td class="text-right">' . number_format($row->p2, 0, ',', '.') . '</td>';
            $html .= '<td class="text-right">' . number_format($row->total_realisasi, 0, ',', '.') . '</td>';
            $html .= '<td class="text-right">' . number_format($row->sisa_total, 0, ',', '.') . '</td>';
            $html .= '</tr>';
        }

        if ($ssh->isEmpty()) {
            $html .= '<tr class="child-of-' . $id_rekening . '"><td colspan="7" class="text-center text-muted">Tidak ada data SSH.</td></tr>';
        }

        return response($html);
    }



public function export_excel()
{
    // Ambil data dengan join antar tabel
    $data = DB::table('t_ssh AS ssh')
        ->join('t_rekening AS rek', 'rek.id_rekening', '=', 'ssh.id_rekening')
        ->join('t_master_sub_kegiatan AS sub', 'sub.id_sub_kegiatan', '=', 'ssh.id_sub_kegiatan')
        ->leftJoin('t_transaksional_realisasi_anggaran AS rea', 'rea.id_ssh', '=', 'ssh.id_ssh')
        ->select(
            'sub.nama_sub_kegiatan',
            'rek.nama_rekening',
            'ssh.nama_ssh',
            DB::raw('COALESCE(ssh.pagu1, 0) AS pagu1'),
            DB::raw('COALESCE(ssh.pagu2, 0) AS pagu2'),
            DB::raw('COALESCE(SUM(rea.nilai_realisasi), 0) AS total_realisasi'),
            DB::raw('(CASE WHEN COALESCE(ssh.pagu2, 0) > 0 
                        THEN COALESCE(ssh.pagu2, 0) 
                        ELSE COALESCE(ssh.pagu1, 0) END 
                    - COALESCE(SUM(rea.nilai_realisasi), 0)) AS sisa')
        )

        ->groupBy('ssh.id_ssh')
        ->orderBy('sub.nama_sub_kegiatan')
        ->get();

    // Siapkan spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header kolom
    $headers = [
        'A1' => 'No',
        'B1' => 'Nama Sub Kegiatan',
        'C1' => 'Nama Rekening',
        'D1' => 'Nama SSH',
        'E1' => 'Pagu 1',
        'F1' => 'Pagu 2',
        'G1' => 'Realisasi',
        'H1' => 'Sisa'
    ];

    foreach ($headers as $cell => $text) {
        $sheet->setCellValue($cell, $text);
    }

    $sheet->getStyle('A1:G1')->getFont()->setBold(true);

    // Isi data
    $no = 1;
    $baris = 2;
    foreach ($data as $item) {
    $pagu_dipakai = $item->pagu2 > 0 ? $item->pagu2 : $item->pagu1;
    $sisa = $pagu_dipakai - $item->total_realisasi;


        $sheet->setCellValue('A'.$baris, $no);
        $sheet->setCellValue('B'.$baris, $item->nama_sub_kegiatan);
        $sheet->setCellValue('C'.$baris, $item->nama_rekening);
        $sheet->setCellValue('D'.$baris, $item->nama_ssh);
        $sheet->setCellValue('E'.$baris, $item->pagu1);
        $sheet->setCellValue('F'.$baris, $item->pagu2);
        $sheet->setCellValue('G'.$baris, $item->total_realisasi);
        $sheet->setCellValue('H'.$baris, $sisa);


        $no++;
        $baris++;
    }

    // Auto width kolom
    foreach (range('A', 'H') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }
     $sheet->setTitle('Data Anggaran'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Aanggaran ' . date('Y-m-d H:i:s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
        exit;
}




}
