<?php

namespace App\Http\Controllers;

use App\Models\MasterProgramModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MasterProgramController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Master Program',
            'list' => ['Home', 'Master Program']
        ];

        $page = (object)[
            'title' => 'Data Master Program'
        ];

        $activeMenu = 'program';

        return view('program.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = MasterProgramModel::select(
            'id_program',
            'kode_program',
            'nama_program'
        );

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                // $btn = '<button onclick="modalAction(\'' . url('/master_program/' . $row->id_program . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn = '<button onclick="modalAction(\'' . url('/master_program/' . $row->id_program . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/master_program/' . $row->id_program . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function create()
    {
        return view('program.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_program' => 'required|string|max:5|min:1|unique:t_master_program,kode_program',
            'nama_program' => 'required|string|max:200',
        ]);

        MasterProgramModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function show($id)
    {
        $program = MasterProgramModel::find($id);
        return view('program.show', ['program' => $program]);
    }

    public function confirm($id)
    {
        $program = MasterProgramModel::find($id);
        return view('program.confirm', ['program' => $program]);
    }

    public function edit($id)
    {
        $program = MasterProgramModel::find($id);
        return view('program.edit', ['program' => $program]);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_program' => 'required|string|max:10|unique:t_master_program,kode_program,' . $id . ',id_program',
                'nama_program' => 'required|string|max:200',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $program = MasterProgramModel::find($id);
            if ($program) {
                $program->fill($request->except(['_token', '_method']));

                if (!$program->isDirty()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada perubahan data yang dilakukan.'
                    ]);
                }

                $program->save();

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
                $program = MasterProgramModel::find($id);

                if ($program) {
                    $program->delete();

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

        return redirect()->route('program.index');
    }
}
