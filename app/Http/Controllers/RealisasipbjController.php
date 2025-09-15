<?php

namespace App\Http\Controllers;

use App\Models\MasterKegiatanModel;
use App\Models\MasterProgramModel;
use App\Models\MasterSubKegiatanModel;
use App\Models\RekeningModel;
use App\Models\SshModel;
use App\Models\RealisasiModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use function formatKode;

class RealisasipbjController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Realisasi',
            'list' => ['Home', 'Realisasi']
        ];

        $page = (object)[
            'title' => 'Data Realisasi'
        ];

        $activeMenu = 'realisasi';
        $listProgram = MasterProgramModel::select('id_program', 'nama_program', 'kode_program')->get()->map(function ($program) {
            $program->kode_program = formatKode($program->kode_program, 'program');
            return $program;
        });

        $tahunSekarang = now()->year;
        $tahunRange = range(2013, $tahunSekarang + 3);

        return view('realisasipbj.index', compact('breadcrumb', 'page', 'activeMenu', 'listProgram', 'tahunRange', 'tahunSekarang'));
    }


    
}