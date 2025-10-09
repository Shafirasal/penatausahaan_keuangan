<?php

namespace App\Http\Controllers;

use App\Models\RekeningModel;
use App\Models\MasterProgramModel;
use App\Models\MasterKegiatanModel;
use App\Models\MasterSubKegiatanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;



class RekeningController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Master Rekening',
            'list' => ['Home', 'Master Rekening']
        ];

        $page = (object)[
            'title' => 'Data Master Rekening'
        ];

        $activeMenu = 'rekening';
        $listProgram = MasterProgramModel::select('id_program', 'kode_program', 'nama_program')
            ->get()
            ->map(function ($program) {
                $program->kode_program = formatKode($program->kode_program, 'program');
                return $program;
            });
        return view('rekening.index', compact('breadcrumb', 'page', 'activeMenu', 'listProgram'));
    }

    public function list(Request $request)
    {
        $data = RekeningModel::select(
            'id_rekening',
            'kode_rekening',
            'id_program',
            'id_kegiatan',
            'id_sub_kegiatan',
            'nama_rekening'
        );

        // Filter berdasarkan Program
        if ($request->id_program) {
            $data->where('id_program', $request->id_program);
        }

        // Filter berdasarkan Kegiatan
        if ($request->id_kegiatan) {
            $data->where('id_kegiatan', $request->id_kegiatan);
        }

        // Filter berdasarkan Sub Kegiatan
        if ($request->id_sub_kegiatan) {
            $data->where('id_sub_kegiatan', $request->id_sub_kegiatan);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<button onclick="modalAction(\'' . url('/master_rekening/' . $row->id_rekening . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/master_rekening/' . $row->id_rekening . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->editColumn('kode_rekening', function ($row) {
                return formatKode($row->kode_rekening, 'rekening'); // Gunakan helper formatKode
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function create()
    {
        $masterProgram = MasterProgramModel::select('id_program', 'kode_program', 'nama_program')
            ->get()
            ->map(function ($p) {
                $p->kode_program = formatKode($p->kode_program, 'program');
                return $p;
            });
        return view('rekening.create', compact('masterProgram'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_rekening' => 'required|string|max:12|unique:t_rekening,kode_rekening',
            'id_program' => 'required|integer|exists:t_master_program,id_program',
            'id_kegiatan' => 'required|integer|exists:t_master_kegiatan,id_kegiatan',
            'id_sub_kegiatan' => 'required|integer|exists:t_master_sub_kegiatan,id_sub_kegiatan',
            'nama_rekening' => 'required|string|max:200',
        ]);

        RekeningModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function edit($id)
    {
        $rekening = RekeningModel::with(['program', 'kegiatan', 'subKegiatan'])->find($id);
        $masterProgram = MasterProgramModel::select('id_program', 'kode_program', 'nama_program')->get();

        // Load kegiatan berdasarkan program yang dipilih
        $kegiatan = MasterKegiatanModel::where('id_program', $rekening->id_program)
            ->select('id_kegiatan', 'kode_kegiatan', 'nama_kegiatan')
            ->get();

        // Load sub kegiatan berdasarkan kegiatan yang dipilih
        $sub_kegiatan = MasterSubKegiatanModel::where('id_kegiatan', $rekening->id_kegiatan)
            ->select('id_sub_kegiatan', 'kode_sub_kegiatan', 'nama_sub_kegiatan')
            ->get();

        return view('rekening.edit', compact('rekening', 'masterProgram', 'kegiatan', 'sub_kegiatan'));
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // 'kode_rekening' => 'required|string|max:12|min:1|unique:t_rekening,kode_rekening,' . $id . ',id_rekening',
                'kode_rekening' => 'required|string|max:12|min:1|',
                'id_program' => 'required|integer|exists:t_master_program,id_program',
                'id_kegiatan' => 'required|integer|exists:t_master_kegiatan,id_kegiatan',
                'id_sub_kegiatan' => 'required|integer|exists:t_master_sub_kegiatan,id_sub_kegiatan',
                'nama_rekening' => 'required|string|max:200',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $rekening = RekeningModel::find($id);
            if ($rekening) {
                $rekening->fill($request->except(['_token', '_method']));

                if (!$rekening->isDirty()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada perubahan data yang dilakukan.'
                    ]);
                }

                $rekening->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    public function confirm($id)
    {
        $rekening = RekeningModel::with(['program', 'kegiatan', 'subKegiatan'])->find($id);

        return view('rekening.confirm', compact('rekening'));
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $rekening = RekeningModel::find($id);

                if ($rekening) {
                    $rekening->delete();

                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus.'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan.'
                    ]);
                }
            } catch (QueryException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak dapat dihapus karena masih terkait dengan data lain.'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        return redirect()->route('master_rekening.index');
    }

    // 🔄 AJAX: Get Kegiatan berdasarkan Program
    public function getKegiatanByProgram($id_program)
    {
        $kegiatan = MasterKegiatanModel::where('id_program', $id_program)
            ->select('id_kegiatan', 'kode_kegiatan', 'nama_kegiatan')
            ->get()
            ->map(function ($item) {
                $item->kode_kegiatan = formatKode($item->kode_kegiatan, 'kegiatan');
                return $item;
            });

        return response()->json($kegiatan);
    }

    // 🔄 AJAX: Get Sub Kegiatan berdasarkan Kegiatan
    public function getSubKegiatanByKegiatan($id_kegiatan)
    {
        $subKegiatan = MasterSubKegiatanModel::where('id_kegiatan', $id_kegiatan)
            ->select('id_sub_kegiatan', 'kode_sub_kegiatan', 'nama_sub_kegiatan')
            ->get()
            ->map(function ($item) {
                $item->kode_sub_kegiatan = formatKode($item->kode_sub_kegiatan, 'sub_kegiatan');
                return $item;
            });

        return response()->json($subKegiatan);
    }

    public function import()
    {
        return view('rekening.import');
    }

    public function import_ajax(Request $request)
    {
        // Pastikan request adalah AJAX
        if (!($request->ajax() || $request->wantsJson())) {
            return redirect('/');
        }

        // Validasi file upload
        $rules = [
            'file_rekening' => ['required', 'mimes:xlsx', 'max:4096'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        // Ambil file
        $file = $request->file('file_rekening');

        try {
            // Baca file Excel
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());

            // Ambil sheet "Data"
            $sheet = $spreadsheet->getSheetByName('Data');
            if (!$sheet) {
                return response()->json([
                    'status' => false,
                    'message' => 'Sheet "Data" tidak ditemukan dalam file Excel.'
                ]);
            }

            $data = $sheet->toArray(null, true, true, true); // true agar angka panjang tidak dipotong

            $insert = [];
            $invalid_rows = [];

            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris == 1) continue; // Lewati header

                    // Ambil data dari kolom Excel
                    $kode_program       = trim((string)$value['A']);
                    $kode_kegiatan      = trim((string)$value['B']);
                    $kode_sub_kegiatan  = trim((string)$value['C']);
                    $kode_rekening      = trim((string)$value['D']);
                    $nama_rekening      = trim((string)$value['E']);    

                    $kode_program = preg_replace('/[^0-9]/', '', $kode_program);
                    $kode_kegiatan = preg_replace('/[^0-9]/', '', $kode_kegiatan);
                    $kode_sub_kegiatan = preg_replace('/[^0-9]/', '', $kode_sub_kegiatan);
                    $kode_rekening = preg_replace('/[^0-9]/', '', $kode_rekening);

                    if (empty($kode_rekening)) continue;

                    // Cari ID referensi berdasarkan kode HIRARKIS
                    $program = MasterProgramModel::where('kode_program', $kode_program)->first();

                    $kegiatan = null;
                    if ($program) {
                        $kegiatan = MasterKegiatanModel::where('kode_kegiatan', $kode_kegiatan)
                            ->where('id_program', $program->id_program)
                            ->first();
                    }

                    $sub = null;
                    if ($kegiatan) {
                        $sub = MasterSubKegiatanModel::where('kode_sub_kegiatan', $kode_sub_kegiatan)
                            ->where('id_kegiatan', $kegiatan->id_kegiatan)
                            ->first();
                    }

                    // Lewatkan jika salah satu tidak ditemukan
                    if (!$program || !$kegiatan || !$sub) continue;

                    // Cek apakah rekening sudah ada (hindari duplikat)
                    $existing = RekeningModel::where('kode_rekening', $kode_rekening)
                        ->where('id_sub_kegiatan', $sub->id_sub_kegiatan)
                        ->first();

                    if ($existing) continue;

                    // Jika semua referensi valid → siapkan untuk insert
                    if ($program && $kegiatan && $sub) {
                        $insert[] = [
                            'kode_rekening'    => $kode_rekening,
                            'id_program'       => $program->id_program,
                            'id_kegiatan'      => $kegiatan->id_kegiatan,
                            'id_sub_kegiatan'  => $sub->id_sub_kegiatan,
                            'nama_rekening'    => $nama_rekening,
                            'created_at'       => now(),
                            'updated_at'       => now(),
                        ];
                    } else {
                        $invalid_rows[] = [
                            'baris' => $baris,
                            'kode_rekening' => $kode_rekening,
                            'note' => 'Kode referensi tidak ditemukan di salah satu tabel master'
                        ];
                    }
                }

                // Insert data valid
                if (count($insert) > 0) {
                    RekeningModel::insertOrIgnore($insert);
                }

                // Buat response hasil
                return response()->json([
                    'status' => true,
                    'message' => 'Import selesai. ' . count($insert) . ' data berhasil diimport, ' . count($invalid_rows) . ' baris dilewati.',
                    'invalid_rows' => $invalid_rows
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'File Excel tidak memiliki data.'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memproses file: ' . $th->getMessage()
            ]);
        }
        return redirect('/');
    }

    // // 🔄 AJAX: Get Kegiatan berdasarkan Program
    // public function getKegiatanByProgram($id_program)
    // {
    //     $kegiatan = MasterKegiatanModel::where('id_program', $id_program)
    //                     ->select('id_kegiatan', 'kode_kegiatan', 'nama_kegiatan')
    //                     ->get();

    //     return response()->json($kegiatan);
    // }

    // // 🔄 AJAX: Get Sub Kegiatan berdasarkan Kegiatan
    // public function getSubKegiatanByKegiatan($id_kegiatan)
    // {
    //     $subKegiatan = MasterSubKegiatanModel::where('id_kegiatan', $id_kegiatan)
    //                         ->select('id_sub_kegiatan', 'kode_sub_kegiatan', 'nama_sub_kegiatan')
    //                         ->get();

    //     return response()->json($subKegiatan);
    // }
}
