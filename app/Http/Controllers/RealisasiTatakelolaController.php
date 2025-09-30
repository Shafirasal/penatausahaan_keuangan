<?php

namespace App\Http\Controllers;

use App\Models\MasterKegiatanModel;
use App\Models\MasterProgramModel;
use App\Models\MasterSubKegiatanModel;
use App\Models\RekeningModel;
use App\Models\SshModel;
use App\Models\RealisasiModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use function formatKode;

class RealisasiTatakelolaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Realisasi LPSE',
            'list'  => ['Home', 'Realisasi']
        ];

        $page = (object)[
            'title' => 'Data Realisasi LPSE'
        ];

        $activeMenu = 'realisasi';
        $listProgram = MasterProgramModel::select('id_program', 'kode_program', 'nama_program')
            ->get()
            ->map(function ($program) {
                $program->kode_program = formatKode($program->kode_program, 'program');
                return $program;
            });
    

        // ambil program berdasarkan kode (lock ke "4.01.07")
        $program = MasterProgramModel::where('kode_program', '40107')->first();
        // simpan juga format kodenya
        if ($program) {
            $program->kode_program_formatted = formatKode($program->kode_program, 'program');
        }

        // ambil kegiatan berdasarkan kode (lock ke "4.01.07.1.02")
        $kegiatan = MasterKegiatanModel::where('kode_kegiatan', '40107102')->first();
        if ($kegiatan) {
            $kegiatan->kode_kegiatan_formatted = formatKode($kegiatan->kode_kegiatan, 'kegiatan');
        }

        // Hitung pagu dan sisa awal
        if ($kegiatan) {
            $pagu = $kegiatan->p2 ?? $kegiatan->p1;

            $real = RealisasiModel::where('id_kegiatan', $kegiatan->id_kegiatan)
                ->sum('nilai_realisasi');

            $sisa = (float)$pagu - (float)$real;
        } else {
            $pagu = 0;
            $sisa = 0;
        }

        $tahunSekarang = now()->year;
        $tahunRange    = range(2013, $tahunSekarang + 3);

        return view('realisasi_tatakelola.index', compact(
            'breadcrumb',
            'page',
            'activeMenu',
            'listProgram',
            'program',
            'kegiatan',
            'pagu',
            'sisa',
            'tahunRange',
            'tahunSekarang'
        ));
    }



    public function getSummaryByKegiatan($id_kegiatan)
    {
        try {
            $kegiatan = MasterKegiatanModel::with(['rekening.ssh.realisasi'])->findOrFail($id_kegiatan);

            $total_pagu = 0;
            $total_realisasi = 0;

            foreach ($kegiatan->rekening as $rek) {
                foreach ($rek->ssh as $ssh) {
                    $total_pagu += $ssh->pagu_final;
                    $total_realisasi += $ssh->realisasi->sum('nilai_realisasi');
                }
            }

            $sisa = $total_pagu - $total_realisasi;

            return response()->json([
                'success' => true,
                'data' => [
                    'total_pagu' => $total_pagu,
                    'total_realisasi' => $total_realisasi,
                    'sisa' => $sisa
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function getSummaryBySsh($id_ssh)
    {
        try {
            // Ambil data SSH beserta relasi realisasi
            $ssh = SshModel::with('realisasi')->findOrFail($id_ssh);

            // Hitung total pagu & realisasi
            $total_pagu = (float) $ssh->pagu_final;
            $total_realisasi = (float) $ssh->realisasi->sum('nilai_realisasi');

            $sisa = $total_pagu - $total_realisasi;

            return response()->json([
                'success' => true,
                'data' => [
                    'pagu_final'      => $total_pagu,
                    'total_realisasi' => $total_realisasi,
                    'sisa'            => $sisa,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghitung summary SSH: ' . $e->getMessage()
            ], 500);
        }
    }



    // ===== CASCADING DROPDOWN METHODS =====

    /**
     * Get kegiatan berdasarkan program
     */
    /**
     * Get kegiatan berdasarkan program dengan pagu & sisa
     */
    public function getKegiatanByProgram($id_program)
    {
        try {
            $kegiatan = MasterKegiatanModel::where('id_program', $id_program)
                ->select(
                    'id_kegiatan',
                    'kode_kegiatan',
                    'nama_kegiatan',
                    DB::raw('
                    COALESCE(SUM(
                        CASE
                            WHEN sk.id_sub_kegiatan IS NOT NULL
                            THEN (
                                SELECT SUM(
                                    CASE WHEN ssh.pagu2 IS NOT NULL AND ssh.pagu2 > 0
                                        THEN ssh.pagu2 ELSE ssh.pagu1 END
                                )
                                FROM t_ssh ssh
                                LEFT JOIN t_rekening rek ON rek.id_rekening = ssh.id_rekening
                                WHERE rek.id_sub_kegiatan = sk.id_sub_kegiatan
                            )
                            ELSE 0 END
                    ), 0) as total_pagu
                '),
                    DB::raw('
                    COALESCE(SUM(
                        CASE
                            WHEN sk.id_sub_kegiatan IS NOT NULL
                            THEN (
                                SELECT SUM(ssh_realisasi.nilai_realisasi)
                                FROM t_transaksional_realisasi_anggaran ssh_realisasi
                                LEFT JOIN t_ssh ssh2 ON ssh2.id_ssh = ssh_realisasi.id_ssh
                                LEFT JOIN t_rekening rek2 ON rek2.id_rekening = ssh2.id_rekening
                                WHERE rek2.id_sub_kegiatan = sk.id_sub_kegiatan
                            )
                            ELSE 0 END
                    ), 0) as total_realisasi
                ')
                )
                ->leftJoin('t_master_sub_kegiatan as sk', 'sk.id_kegiatan', '=', 't_master_kegiatan.id_kegiatan')
                ->groupBy('id_kegiatan', 'kode_kegiatan', 'nama_kegiatan')
                ->orderBy('kode_kegiatan')
                ->get()
                ->map(function ($item) {
                    $item->kode_kegiatan = formatKode($item->kode_kegiatan, 'kegiatan');
                    $item->sisa = $item->total_pagu - $item->total_realisasi;
                    return $item;
                });

            return response()->json($kegiatan);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data kegiatan', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * Get sub kegiatan berdasarkan kegiatan
     */
    public function getSubKegiatanByKegiatan($id_kegiatan)
    {
        try {
            $subKegiatan = MasterSubKegiatanModel::with(['rekening.ssh.realisasi'])
                ->where('id_kegiatan', $id_kegiatan)
                ->orderBy('kode_sub_kegiatan')
                ->get()
                ->map(function ($item) {
                    // Hitung total pagu & realisasi
                    $total_pagu = 0;
                    $total_realisasi = 0;

                    foreach ($item->rekening as $rek) {
                        foreach ($rek->ssh as $ssh) {
                            $total_pagu += (float) $ssh->pagu_final;
                            $total_realisasi += (float) $ssh->realisasi->sum('nilai_realisasi');
                        }
                    }

                    $sisa = $total_pagu - $total_realisasi;

                    return [
                        'id_sub_kegiatan'   => $item->id_sub_kegiatan,
                        'kode_sub_kegiatan' => formatKode($item->kode_sub_kegiatan, 'sub_kegiatan'),
                        'nama_sub_kegiatan' => $item->nama_sub_kegiatan,
                        'total_pagu'        => $total_pagu,
                        'total_realisasi'   => $total_realisasi,
                        'sisa'              => $sisa
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $subKegiatan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data sub kegiatan: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Get rekening berdasarkan sub kegiatan
     */
    public function getRekeningBySubKegiatan($id_sub_kegiatan)
    {
        try {
            $rekening = RekeningModel::with(['ssh.realisasi'])
                ->where('id_sub_kegiatan', $id_sub_kegiatan)
                ->orderBy('kode_rekening')
                ->get()
                ->map(function ($item) {
                    // Hitung total pagu & realisasi
                    $total_pagu = 0;
                    $total_realisasi = 0;

                    foreach ($item->ssh as $ssh) {
                        $total_pagu += (float) $ssh->pagu_final;
                        $total_realisasi += (float) $ssh->realisasi->sum('nilai_realisasi');
                    }

                    $sisa = $total_pagu - $total_realisasi;

                    return [
                        'id_sub_kegiatan'   => $item->id_sub_kegiatan,
                        'id_rekening'   => $item->id_rekening,
                        'kode_rekening' => formatKode($item->kode_rekening, 'rekening'),
                        'nama_rekening' => $item->nama_rekening,
                        'total_pagu'        => $total_pagu,
                        'total_realisasi'   => $total_realisasi,
                        'sisa'              => $sisa
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $rekening
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get SSH berdasarkan rekening
     */
    public function getSshByRekening($id_rekening)
    {
        try {
            $ssh = DB::table('t_ssh as s')
                ->leftJoin('t_transaksional_realisasi_anggaran as r', 's.id_ssh', '=', 'r.id_ssh')
                ->where('s.id_rekening', $id_rekening)
                ->select(
                    's.id_ssh',
                    's.kode_ssh',
                    's.nama_ssh',
                    's.pagu1',
                    's.pagu2',
                    DB::raw('COALESCE(SUM(r.nilai_realisasi), 0) as realisasi'),
                    DB::raw('(CASE WHEN s.pagu2 IS NOT NULL AND s.pagu2 > 0 THEN s.pagu2 ELSE s.pagu1 END) as pagu_final')
                )
                ->groupBy('s.id_ssh', 's.kode_ssh', 's.nama_ssh', 's.pagu1', 's.pagu2')
                ->orderBy('s.kode_ssh')
                ->get()
                ->map(function ($item) {
                    $item->kode_ssh = formatKode($item->kode_ssh, 'ssh');
                    $item->sisa = $item->pagu_final - $item->realisasi;
                    return $item;
                });


            return response()->json([
                'success' => true,
                'data' => $ssh,
                'count' => $ssh->count(),
                'id_rekening' => $id_rekening
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Gagal memuat data SSH',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Form Realisasi',
            'list' => ['Home', 'Realisasi', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Realisasi'
        ];

        $activeMenu = 'realisasi';
        $listProgram = MasterProgramModel::select('id_program', 'nama_program', 'kode_program')->get()->map(function ($program) {
            $program->kode_program = formatKode($program->kode_program, 'program');
            return $program;
        });

        return view('realisasipbj.index', compact('breadcrumb', 'page', 'activeMenu', 'listProgram'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id_program'        => 'required|integer|exists:t_master_program,id_program',
            'id_kegiatan'       => 'required|integer|exists:t_master_kegiatan,id_kegiatan',
            'id_sub_kegiatan'   => 'required|integer|exists:t_master_sub_kegiatan,id_sub_kegiatan',
            'id_rekening'       => 'required|integer|exists:t_rekening,id_rekening',
            'id_ssh'            => 'required|integer|exists:t_ssh,id_ssh',
            'jenis_realisasi'   => 'required|string|in:Kwitansi,Nota,Dokumen Lainnya',
            'no_dokumen'        => 'nullable|string|max:255',
            'nilai_realisasi'   => 'required|string',
            'tanggal_realisasi' => 'required|date',
            'file'              => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        try {
            DB::beginTransaction();

            // Normalisasi nilai realisasi
            $nilai = str_replace('.', '', $validated['nilai_realisasi']);
            $nilai = str_replace(',', '.', $nilai);
            $validated['nilai_realisasi'] = (float) $nilai;

            // Ambil SSH
            $ssh = SshModel::findOrFail($validated['id_ssh']);

            // Pilih pagu yang aktif
            $pagu = $ssh->pagu2 && $ssh->pagu2 > 0 ? $ssh->pagu2 : $ssh->pagu1;

            // Hitung total realisasi yang sudah ada
            $totalRealisasi = RealisasiModel::where('id_ssh', $validated['id_ssh'])
                ->sum('nilai_realisasi');

            $sisa = $pagu - $totalRealisasi;

            if ($validated['nilai_realisasi'] > $sisa) {
                return response()->json([
                    'status'  => false,
                    'message' => "Nilai realisasi tidak boleh melebihi sisa anggaran SSH.
                              Sisa tersedia: Rp " . number_format($sisa, 0, ',', '.'),
                ], 422);
            }


            // Handle file upload
        if ($request->hasFile('file')) {
            $originalName = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $filename = time() . '_' . Str::slug($originalName) . '.' . $extension;

            $request->file('file')->storeAs('public/realisasitatakelola', $filename);

            // simpan ke array validated agar masuk ke DB
            $validated['file'] = 'realisasitatakelola/' . $filename;
        }

            // Simpan ke DB
            $realisasi = RealisasiModel::create($validated);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Data realisasi berhasil disimpan.',
                'data'    => $realisasi
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function histori($id)
    {
        $query = RealisasiModel::where('id_ssh', $id)
            ->orderByDesc('tanggal_realisasi');

        return DataTables::of($query)
            ->addIndexColumn()
            ->make(true);
    }


    // ===== CRUD METHODS (placeholder) =====

    public function list(Request $request)
    {
        // DataTables implementation
    }



    public function edit($id)
    {
        // Edit implementation
    }

    public function update(Request $request, $id)
    {
        // Update implementation
    }

    public function confirm($id)
    {
        // Confirm implementation
    }

    public function delete($id)
    {
        // Delete implementation
    }
}
