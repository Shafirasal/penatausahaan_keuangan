<?php

namespace App\Http\Controllers;

use App\Models\MasterKegiatanModel;
use App\Models\MasterProgramModel;
use App\Models\MasterSubKegiatanModel;
use App\Models\RekeningModel;
use App\Models\SshModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Yajra\DataTables\Facades\DataTables;
use function formatKode;

class SSHController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'SSH',
            'list' => ['Home', 'SSH']
        ];

        $page = (object)[
            'title' => 'Data SSH'
        ];

        $activeMenu = 'ssh';
        $listProgram = MasterProgramModel::select('id_program', 'nama_program', 'kode_program')->get()->map(function ($program) {
            $program->kode_program = formatKode($program->kode_program, 'program');
            return $program;
        });

        $tahunSekarang = now()->year;
        $tahunRange = range(2013, $tahunSekarang + 3); // 2013-now+3

        return view('ssh.index', compact('breadcrumb', 'page', 'activeMenu', 'listProgram', 'tahunRange', 'tahunSekarang'));
    }

    public function list(Request $request)
    {
        $data = SshModel::select(
            'id_ssh',
            'kode_ssh',
            'id_kegiatan',
            'id_program',
            'id_sub_kegiatan',
            'id_rekening',
            'nama_ssh',
            DB::raw("CONCAT('Rp ', FORMAT(pagu1, 0, 'id_ID')) as pagu1"),
            DB::raw("CONCAT('Rp ', FORMAT(pagu2, 0, 'id_ID')) as pagu2"),
            DB::raw('YEAR(tahun) as tahun'),
        )->with(
            'program:id_program,nama_program,kode_program',
            'kegiatan:id_kegiatan,nama_kegiatan,kode_kegiatan',
            'sub_kegiatan:id_sub_kegiatan,nama_sub_kegiatan,kode_sub_kegiatan',
            'rekening:id_rekening,nama_rekening,kode_rekening'
        )->filterTahun($request->tahun);

        // Filter Program
        if ($request->id_program) {
            $data->where('id_program', $request->id_program);
        }

        // Filter Kegiatan
        if ($request->id_kegiatan) {
            $data->where('id_kegiatan', $request->id_kegiatan);
        }

        // Filter Sub Kegiatan
        if ($request->id_sub_kegiatan) {
            $data->where('id_sub_kegiatan', $request->id_sub_kegiatan);
        }

        // Filter Rekening
        if ($request->id_rekening) {
            $data->where('id_rekening', $request->id_rekening);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<button onclick="modalAction(\'' . url('/ssh/' . $row->id_ssh . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/ssh/' . $row->id_ssh . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->editColumn('kode_ssh', function ($row) {
                return formatKode($row->kode_ssh, 'ssh');
            })

            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function create()
    {
        $program = MasterProgramModel::select('id_program', 'nama_program', 'kode_program')->get()
            ->map(function ($p) {
                $p->kode_program = formatKode($p->kode_program, 'program');
                return $p;
            });
        return view('ssh.create', compact('program'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_ssh' => 'required|string|max:17|min:1|unique:t_ssh,kode_ssh',
            'id_program' => 'required|integer|exists:t_master_program,id_program',
            'id_kegiatan' => 'required|integer|exists:t_master_kegiatan,id_kegiatan',
            'id_sub_kegiatan' => 'required|integer|exists:t_master_sub_kegiatan,id_sub_kegiatan',
            'id_rekening' => 'required|integer|exists:t_rekening,id_rekening',
            'nama_ssh' => 'required|string|max:200',
            'pagu1' => 'required|integer|min:0',
            'pagu2' => 'required|integer|min:0',
            'tahun' => 'required|date',
        ]);

        SshModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function confirm($id)
    {
        $ssh = SshModel::with(['program', 'kegiatan', 'sub_kegiatan', 'rekening'])->find($id);

        return view('ssh.confirm', ['ssh' => $ssh]);
    }

    public function edit($id)
    {
        $ssh = SshModel::with(['program', 'kegiatan', 'sub_kegiatan', 'rekening'])->find($id);
        $program = MasterProgramModel::select('id_program', 'nama_program')->get();
        $kegiatan = MasterKegiatanModel::select('id_kegiatan', 'nama_kegiatan')->get();
        $sub_kegiatan = MasterSubKegiatanModel::select('id_sub_kegiatan', 'nama_sub_kegiatan')->get();
        $rekening = RekeningModel::select('id_rekening', 'nama_rekening')->get();

        return view('ssh.edit', compact('sub_kegiatan', 'program', 'kegiatan', 'rekening', 'ssh'));
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_ssh' => 'required|string|max:17|min:1|unique:t_ssh,kode_ssh,' . $id . ',id_ssh',
                'id_program' => 'required|integer|exists:t_master_program,id_program',
                'id_kegiatan' => 'required|integer|exists:t_master_kegiatan,id_kegiatan',
                'id_sub_kegiatan' => 'required|integer|exists:t_master_sub_kegiatan,id_sub_kegiatan',
                'id_rekening' => 'required|integer|exists:t_rekening,id_rekening',
                'nama_ssh' => 'required|string|max:200',
                'pagu1' => 'required|integer|min:0',
                'pagu2' => 'required|integer|min:0',
                'tahun' => 'required|date',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $ssh = SshModel::find($id);
            if ($ssh) {
                $ssh->fill($request->except(['_token', '_method']));

                if (!$ssh->isDirty()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada perubahan data yang dilakukan.'
                    ]);
                }

                $ssh->save();

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

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $ssh = SshModel::find($id);

                if ($ssh) {
                    $ssh->delete();

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

        return redirect()->route('ssh.index');
    }

    // 🔄 AJAX: Get Kegiatan berdasarkan Program
    public function getKegiatanByProgram($id_program)
    {
        $kegiatan = MasterKegiatanModel::where('id_program', $id_program)
            ->select('id_kegiatan', 'nama_kegiatan', 'kode_kegiatan')
            ->get()
            ->map(function ($item) {
                $item->kode_kegiatan = formatKode($item->kode_kegiatan, 'kegiatan');
                return $item;
            });

        return response()->json($kegiatan);
    }
    public function getSubKegiatanByKegiatan($id_kegiatan)
    {
        $sub_kegiatan = MasterSubKegiatanModel::where('id_kegiatan', $id_kegiatan)
            ->select('id_sub_kegiatan', 'nama_sub_kegiatan', 'kode_sub_kegiatan')
            ->get()
            ->map(function ($item) {
                $item->kode_sub_kegiatan = formatKode($item->kode_sub_kegiatan, 'sub_kegiatan');
                return $item;
            });

        return response()->json($sub_kegiatan);
    }

    public function getRekeningBySubKegiatan($id_sub_kegiatan)
    {
        $rekening = RekeningModel::where('id_sub_kegiatan', $id_sub_kegiatan)
            ->select('id_rekening', 'nama_rekening', 'kode_rekening')
            ->get()
            ->map(function ($item) {
                $item->kode_rekening = formatKode($item->kode_rekening, 'rekening');
                return $item;
            });

        return response()->json($rekening);
    }

    public function import()
    {
        return view('ssh.import');
    }

    public function import_ajax(Request $request)
    {
        // Pastikan request adalah AJAX
        if (!($request->ajax() || $request->wantsJson())) {
            return redirect('/');
        }

        // Validasi file upload
        $rules = [
            'file_ssh' => ['required', 'mimes:xlsx', 'max:4096'],
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
        $file = $request->file('file_ssh');

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
                    $kode_ssh         = trim((string)$value['A']);
                    $kode_program     = trim((string)$value['B']);
                    $kode_kegiatan    = trim((string)$value['C']);
                    $kode_sub_kegiatan = trim((string)$value['D']);
                    $kode_rekening    = trim((string)$value['E']);
                    $nama_ssh         = trim((string)$value['F']);
                    $pagu1            = (int)$value['G'];
                    $pagu2            = (int)$value['H'];
                    // Konversi kolom tahun agar selalu berbentuk YYYY-MM-DD
                    if (is_numeric($value['I'])) {
                        // Jika berupa serial Excel (misal 45842)
                        try {
                            $tahun = Date::excelToDateTimeObject($value['I'])->format('Y-m-d');
                        } catch (\Exception $e) {
                            $tahun = null;
                        }
                    } else {
                        // Jika berupa string tanggal
                        $tahun = trim((string)$value['I']);
                        $timestamp = strtotime($tahun);
                        $tahun = $timestamp ? date('Y-m-d', $timestamp) : null;
                    }

                    // Hilangkan karakter non-digit dari kode
                    $kode_ssh = preg_replace('/[^0-9]/', '', $kode_ssh);
                    $kode_program = preg_replace('/[^0-9]/', '', $kode_program);
                    $kode_kegiatan = preg_replace('/[^0-9]/', '', $kode_kegiatan);
                    $kode_sub_kegiatan = preg_replace('/[^0-9]/', '', $kode_sub_kegiatan);
                    $kode_rekening = preg_replace('/[^0-9]/', '', $kode_rekening);

                    if (empty($kode_ssh)) continue;

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

                    $rekening = null;
                    if ($sub) {
                        $rekening = RekeningModel::where('kode_rekening', $kode_rekening)
                            ->where('id_sub_kegiatan', $sub->id_sub_kegiatan)
                            ->first();
                    }

                    // Jika semua referensi valid → siapkan untuk insert
                    if ($program && $kegiatan && $sub && $rekening) {
                        // ✅ Cek apakah kode_ssh sudah ada di rekening yang sama
                        $exists = SshModel::where('kode_ssh', $kode_ssh)
                            ->where('id_rekening', $rekening->id_rekening)
                            ->exists();

                        if (!$exists) {
                            $insert[] = [
                                'kode_ssh' => $kode_ssh,
                                'id_program' => $program->id_program,
                                'id_kegiatan' => $kegiatan->id_kegiatan,
                                'id_sub_kegiatan' => $sub->id_sub_kegiatan,
                                'id_rekening' => $rekening->id_rekening,
                                'nama_ssh' => $nama_ssh,
                                'pagu1' => $pagu1,
                                'pagu2' => $pagu2,
                                'tahun' => $tahun,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        } else {
                            // Simpan baris yang duplikat
                            $invalid_rows[] = [
                                'baris' => $baris,
                                'kode_ssh' => $kode_ssh,
                                'note' => 'Kode SSH sudah ada pada rekening yang sama'
                            ];
                        }
                    } else {
                        $invalid_rows[] = [
                            'baris' => $baris,
                            'kode_ssh' => $kode_ssh,
                            'note' => 'Kode referensi tidak ditemukan di salah satu tabel master'
                        ];
                    }
                }

                // Insert data valid
                if (count($insert) > 0) {
                    SshModel::insertOrIgnore($insert);
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
}
