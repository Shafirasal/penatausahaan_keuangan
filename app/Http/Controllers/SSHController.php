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
}
