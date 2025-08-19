<?php

namespace App\Http\Controllers;

use App\Models\RekeningModel;
use App\Models\MasterProgramModel;
use App\Models\MasterKegiatanModel;
use App\Models\MasterSubKegiatanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
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
        ->map(function($p){
            $p->kode_program = formatKode($p -> kode_program, 'program');
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