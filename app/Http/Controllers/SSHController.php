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
use Yajra\DataTables\Facades\DataTables;

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

        return view('ssh.index', compact('breadcrumb', 'page', 'activeMenu'));
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
            'pagu',
            'periode',
            DB::raw('YEAR(tahun) as tahun'),
        )->with('program:id_program,nama_program', 'kegiatan:id_kegiatan,nama_kegiatan',
            'sub_kegiatan:id_sub_kegiatan,nama_sub_kegiatan', 'rekening:id_rekening,nama_rekening');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('program_nama', function ($row) {
                return $row->program ? $row->program->nama_program : '-';
            })
            ->addColumn('kegiatan_nama', function ($row) {
                return $row->kegiatan ? $row->kegiatan->nama_kegiatan : '-';
            })
            ->addColumn('nama_sub_kegiatan', function ($row) {
                return $row->sub_kegiatan ? $row->sub_kegiatan->nama_sub_kegiatan : '-';
            })
            ->addColumn('nama_rekening', function ($row) {
                return $row->rekening ? $row->rekening->nama_rekening : '-';
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<button onclick="modalAction(\'' . url('/ssh/' . $row->id_ssh . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/ssh/' . $row->id_ssh . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function create()
    {
        $program = MasterProgramModel::select('id_program', 'nama_program')->get();
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
            'pagu' => 'required|integer|min:0',
            'periode' => 'required|string|max:50',
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
                'pagu' => 'required|integer|min:0',
                'periode' => 'required|string|max:50',
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
            ->select('id_kegiatan', 'nama_kegiatan')
            ->get();

        return response()->json($kegiatan);
    }
    public function getSubKegiatanByKegiatan($id_kegiatan)
    {
        $sub_kegiatan = MasterSubKegiatanModel::where('id_kegiatan', $id_kegiatan)
            ->select('id_sub_kegiatan', 'nama_sub_kegiatan')
            ->get();

        return response()->json($sub_kegiatan);
    }
    public function getRekeningBySubKegiatan($id_sub_kegiatan)
    {
        $rekening = RekeningModel::where('id_sub_kegiatan', $id_sub_kegiatan)
            ->select('id_rekening', 'nama_rekening')
            ->get();

        return response()->json($rekening);
    }
}
