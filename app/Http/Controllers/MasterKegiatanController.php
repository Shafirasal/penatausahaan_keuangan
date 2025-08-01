<?php

namespace App\Http\Controllers;

use App\Models\MasterKegiatanModel;
use App\Models\MasterProgramModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MasterKegiatanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Master Kegiatan',
            'list' => ['Home', 'Master Kegiatan']
        ];

        $page = (object)[
            'title' => 'Data Master Kegiatan'
        ];

        $activeMenu = 'kegiatan';

        return view('kegiatan.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = MasterKegiatanModel::select(
            'id_kegiatan',
            'kode_kegiatan',
            'id_program',
            'nama_kegiatan'
        )->with('program:id_program,nama_program');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('program_nama', function ($row) {
                return $row->program ? $row->program->nama_program : '-';
            })
            ->addColumn('aksi', function ($row) {
                // $btn = '<button onclick="modalAction(\'' . url('/master_kegiatan/' . $row->id_kegiatan . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn = '<button onclick="modalAction(\'' . url('/master_kegiatan/' . $row->id_kegiatan . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/master_kegiatan/' . $row->id_kegiatan . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function create()
    {
        $program = MasterProgramModel::select('id_program', 'nama_program')->get();
        return view('kegiatan.create', compact('program'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kegiatan' => 'required|string|max:8|min:8|unique:t_master_kegiatan,kode_kegiatan',
            'id_program' => 'required|integer|exists:t_master_program,id_program',
            'nama_kegiatan' => 'required|string|max:200',
        ]);

        MasterKegiatanModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function show($id)
    {
        $kegiatan = MasterKegiatanModel::with('program')->find($id);
        return view('kegiatan.show', ['kegiatan' => $kegiatan]);
    }

    public function confirm($id)
    {
        $kegiatan = MasterKegiatanModel::with('program')->find($id);
        return view('kegiatan.confirm', ['kegiatan' => $kegiatan]);
    }

    public function edit($id)
    {
        $kegiatan = MasterKegiatanModel::with('program')->find($id);
        $program = MasterProgramModel::select('id_program', 'nama_program')->get();
        return view('kegiatan.edit', compact('kegiatan', 'program'));
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_kegiatan' => 'required|string|max:8|unique:t_master_kegiatan,kode_kegiatan,' . $id . ',id_kegiatan',
                'id_program' => 'required|integer|exists:t_master_program,id_program',
                'nama_kegiatan' => 'required|string|max:200',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $kegiatan = MasterKegiatanModel::find($id);
            if ($kegiatan) {
                $kegiatan->fill($request->except(['_token', '_method']));

                if (!$kegiatan->isDirty()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada perubahan data yang dilakukan.'
                    ]);
                }

                $kegiatan->save();

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
                $kegiatan = MasterKegiatanModel::find($id);

                if ($kegiatan) {
                    $kegiatan->delete();

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
}