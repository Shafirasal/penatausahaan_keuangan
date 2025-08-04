<?php

namespace App\Http\Controllers;

use App\Models\MasterKegiatanModel;
use App\Models\MasterProgramModel;
use App\Models\MasterSubKegiatanModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

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

        return view('sub_kegiatan.index', compact('breadcrumb', 'page', 'activeMenu'));
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

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('program_nama', function ($row) {
                return $row->program ? $row->program->nama_program : '-';
            })
            ->addColumn('kegiatan_nama', function ($row) {
                return $row->kegiatan ? $row->kegiatan->nama_kegiatan : '-';
            })
            ->addColumn('aksi', function ($row) {
                // $btn = '<button onclick="modalAction(\'' . url('/master_sub_kegiatan/' . $row->id_kegiatan . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn = '<button onclick="modalAction(\'' . url('/master_sub_kegiatan/' . $row->id_sub_kegiatan . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/master_sub_kegiatan/' . $row->id_sub_kegiatan . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function create()
    {
        $program = MasterProgramModel::select('id_program', 'nama_program')->get();
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
            ->select('id_kegiatan', 'nama_kegiatan')
            ->get();

        return response()->json($kegiatan);
    }
}
