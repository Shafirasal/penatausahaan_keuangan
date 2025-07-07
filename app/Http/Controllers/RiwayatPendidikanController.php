<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPendidikanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RiwayatPendidikanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Riwayat Pendidikan',
            'list' => ['Home', 'Riwayat Pendidikan']
        ];

        $page = (object)[
            'title' => 'Data Riwayat Pendidikan Pegawai'
        ];

        $activeMenu = 'pendidikan';

        return view('riwayat_pendidikan.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = RiwayatPendidikanModel::select(
            'id_pendidikan',
            'nama_sekolah',
            'jenjang',
            'prodi_jurusan',
            'tahun_lulus',
            'aktif'
        );
    }

    // Tambahan lainnya seperti create, store, edit, update, show, confirm, delete bisa kamu tiru dari MataKuliahController.
}
