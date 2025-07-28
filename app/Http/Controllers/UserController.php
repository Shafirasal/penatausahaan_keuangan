<?php

namespace App\Http\Controllers;

use App\Models\PegawaiModel;
use App\Models\UserModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

        public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list'  => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';
        $level = ['pegawai', 'admin', 'operator'];

        return view('user.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
{
    // Ambil semua data user dan relasi ke pegawai (berdasarkan NIP)
    $data = UserModel::with('pegawai')
        ->select('id_user', 'nip', 'level', 'created_at', 'updated_at');

    // Filter level jika disediakan di request
if ($request->has('level') && $request->level != '') {
    $data->where('level', $request->level);
}


    return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('nama_pegawai', function ($row) {return $row->pegawai->nama ?? '-';})
        ->addColumn('aksi', function ($row) {
            return '
                <button onclick="modalAction(`' . url('/user/' . $row->id_user . '/edit') . '`)" class="btn btn-warning btn-sm">Edit</button>
                <button onclick="modalAction(`' . url('/user/' . $row->id_user . '/confirm') . '`)" class="btn btn-danger btn-sm">Hapus</button>
            ';
        })
        ->rawColumns(['aksi'])
        ->make(true);
}
    // Menampilkan form tambah user
public function create()
{
    $pegawai = PegawaiModel::select('nip', 'nama')->get();

    return view('user.create', [
        'pegawai' => $pegawai
    ]);
}

    public function store(Request $request)
    {
        $request->validate([
        'nip' => 'required|string|max:20|unique:t_user,nip',
        'level' => 'required|in:pegawai,admin,operator',
        'password' => 'required|min:5|max:225',
        ]);

        UserModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan.'
        ]);
    }
public function delete(Request $request, $id)
{
    // Cek apakah request berasal dari AJAX
    if ($request->ajax() || $request->wantsJson()) {
        try {
            // Cari data berdasarkan primary key 'id_user'
            $user = UserModel::find($id);

            if ($user) {
                // Hapus data
                $user->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data user berhasil dihapus.'
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

    // Jika bukan AJAX, redirect ke halaman daftar user
    return redirect()->route('user.index');
}

public function confirm(string $id)
{
    $user = UserModel::find($id);

    return view('user.confirm', ['user' => $user]);
}


public function edit(string $id)
{
    $user = UserModel::find($id);

    if (!$user) {
        abort(404, 'Data tidak ditemukan.');
    }

    return view('user.edit', [
        'user' => $user,
    ]);
}


// public function update(Request $request, $id)
// {
//     if ($request->ajax() || $request->wantsJson()) {
//         $rules = [
//             'level' => 'required|in:pegawai,admin,operator',
//         ];

//         // Hanya validasi password jika diisi
//         if ($request->filled('password')) {
//             $rules['password'] = 'min:5|max:225';
//         }

//         $validator = Validator::make($request->all(), $rules);

//         if ($validator->fails()) {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Validasi gagal.',
//                 'msgField' => $validator->errors()
//             ]);
//         }

//         $user = UserModel::find($id);

//         if ($user) {
//             $user->level = $request->level;

//             if ($request->filled('password')) {
//                 $user->password = Hash::make($request->password);
//             }

//             $user->save();

//             return response()->json([
//                 'status' => true,
//                 'message' => 'Data user berhasil diperbarui.'
//             ]);
//         } else {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Data tidak ditemukan.'
//             ]);
//         }
//     }

//     return redirect('/user');
// }

// public function update(Request $request, $id)
// {
//     $user = UserModel::find($id);

//     if (!$user) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Data tidak ditemukan'
//         ]);
//     }

//     // Validasi
//     $validated = $request->validate([
//         'level'    => 'required|in:pegawai,admin,operator',
//         'password' => 'nullable|string|min:5|max:225',
//     ]);

//     // Update data
//     $user->level = $validated['level'];

//     // Jika password diisi, update password
//     if (!empty($validated['password'])) {
//         $user->password = Hash::make($validated['password']);
//     }

//     $user->save();

//     return response()->json([
//         'status' => true,
//         'message' => 'Data user berhasil diperbarui.'
//     ]);
// }


public function update(Request $request, $id)
{
    if ($request->ajax() || $request->wantsJson()) {
        $user = UserModel::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ]);
        }

        // Aturan dasar (wajib)
        $rules = [
            'level' => 'required|in:pegawai,admin,operator',
        ];

        // Jika password baru diisi, tambahkan validasi password
        if ($request->filled('password')) {
            $rules['current_password'] = 'required|string';
            $rules['password'] = 'required|string|min:5|confirmed';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        // Verifikasi password lama jika ingin mengubah password
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Password lama tidak sesuai.',
                    'field' => 'current_password'
                ]);
            }

            $user->password = Hash::make($request->password);
        }

        // Update level
        $user->level = $request->level;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil diperbarui.'
        ]);
    }

    return redirect('/user');
}
}
