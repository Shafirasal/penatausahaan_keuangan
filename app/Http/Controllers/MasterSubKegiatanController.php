<?php

namespace App\Http\Controllers;

use App\Models\MasterKegiatanModel;
use App\Models\MasterProgramModel;
use App\Models\MasterSubKegiatanModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use function formatKode;

class MasterSubKegiatanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Master Sub Kegiatan',
            'list' => ['Home', 'Master Sub Kegiatan']
        ];

        $page = (object)[
            'title' => 'Data Master Sub Kegiatan'
        ];

        $activeMenu = 'sub_kegiatan';
        // $listProgram = MasterProgramModel::select('id_program', 'nama_program')->get();
        //TAMBAHKAN format kode program + kode_program field
        $listProgram = MasterProgramModel::select('id_program', 'nama_program', 'kode_program')->get()->map(function ($program) {
            $program->kode_program = formatKode($program->kode_program, 'program');
            return $program;
        });
        return view('sub_kegiatan.index', compact('breadcrumb', 'page', 'activeMenu', 'listProgram'));
    }

public function list(Request $request)
{
    $data = MasterSubKegiatanModel::select(
        'id_sub_kegiatan',
        'kode_sub_kegiatan',
        'id_kegiatan',
        'id_program',
        'nama_sub_kegiatan'
    )->with('program:id_program,nama_program', 'kegiatan:id_kegiatan,nama_kegiatan');

    // Filter berdasarkan Program (gunakan ID bukan nama)
    if ($request->id_program) {
        $data->where('id_program', $request->id_program);
    }

    // Filter berdasarkan Kegiatan
    if ($request->id_kegiatan) {
        $data->where('id_kegiatan', $request->id_kegiatan);
    }

    return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('program_nama', function ($row) {
            return $row->program ? $row->program->nama_program : '-';
        })
        ->addColumn('kegiatan_nama', function ($row) {
            return $row->kegiatan ? $row->kegiatan->nama_kegiatan : '-';
        })
        ->addColumn('aksi', function ($row) {
            $btn = '<button onclick="modalAction(\'' . url('/master_sub_kegiatan/' . $row->id_sub_kegiatan . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/master_sub_kegiatan/' . $row->id_sub_kegiatan . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        // ->editColumn('kode_sub_kegiatan', function ($row) {
        //     $kode = $row->kode_sub_kegiatan;
        //     return '[' . substr($kode, 0, 1) . '.' . substr($kode, 1, 2) . '.' . substr($kode, 3, 2) . '.' . substr($kode, 5, 1) . '.' . substr($kode, 6, 2) . ']';
        // })
        ->editColumn('kode_sub_kegiatan', function ($row) {
            return formatKode($row->kode_sub_kegiatan, 'sub_kegiatan'); // ✅ GANTI dengan helper
        })
        ->rawColumns(['aksi'])
        ->toJson();
}

    public function create()
    {
        // $program = MasterProgramModel::select('id_program', 'nama_program', 'kode_program')->get();
        // return view('sub_kegiatan.create', compact('program'));

        $program = MasterProgramModel::select('id_program', 'nama_program', 'kode_program')
        ->get()
        ->map(function ($p) {
            $p->kode_program = formatKode($p->kode_program, 'program');
            return $p;
        });
        
    return view('sub_kegiatan.create', compact('program'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_sub_kegiatan' => 'required|string|max:12|min:1|unique:t_master_sub_kegiatan,kode_sub_kegiatan',
            'id_program' => 'required|integer|exists:t_master_program,id_program',
            'id_kegiatan' => 'required|integer|exists:t_master_kegiatan,id_kegiatan',
            'nama_sub_kegiatan' => 'required|string|max:200',
        ]);

        MasterSubKegiatanModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function confirm($id)
    {
        $sub_kegiatan = MasterSubKegiatanModel::with(['program', 'kegiatan'])->find($id);

        return view('sub_kegiatan.confirm', ['sub_kegiatan' => $sub_kegiatan]);
    }

    public function edit($id)
    {
        $sub_kegiatan = MasterSubKegiatanModel::with(['program', 'kegiatan'])->find($id);
        $program = MasterProgramModel::select('id_program', 'nama_program')->get();
        $kegiatan = MasterKegiatanModel::select('id_kegiatan', 'nama_kegiatan')->get(); // semua kegiatan

        return view('sub_kegiatan.edit', compact('sub_kegiatan', 'program', 'kegiatan'));
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_sub_kegiatan' => 'required|string|max:12|min:1|unique:t_master_sub_kegiatan,kode_sub_kegiatan,' . $id . ',id_sub_kegiatan',
                'id_program' => 'required|integer|exists:t_master_program,id_program',
                'id_kegiatan' => 'required|integer|exists:t_master_kegiatan,id_kegiatan',
                'nama_sub_kegiatan' => 'required|string|max:200',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $sub_kegiatan = MasterSubKegiatanModel::find($id);
            if ($sub_kegiatan) {
                $sub_kegiatan->fill($request->except(['_token', '_method']));

                if (!$sub_kegiatan->isDirty()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada perubahan data yang dilakukan.'
                    ]);
                }

                $sub_kegiatan->save();

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
                $sub_kegiatan = MasterSubKegiatanModel::find($id);

                if ($sub_kegiatan) {
                    $sub_kegiatan->delete();

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

        return redirect()->route('kegiatan.index');
    }

    // 🔄 AJAX: Get Kegiatan berdasarkan Program
    public function getKegiatanByProgram($id_program)
    {
        $kegiatan = MasterKegiatanModel::where('id_program', $id_program)
            ->select('id_kegiatan', 'nama_kegiatan', 'kode_kegiatan')
            ->get()
            ->map(function ($item) {
            $item->kode_kegiatan = formatKode($item->kode_kegiatan, 'kegiatan'); // ✅ TAMBAHKAN format
            return $item;
        });

        return response()->json($kegiatan);

        
    }
    
}
