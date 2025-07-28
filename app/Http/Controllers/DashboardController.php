<?php

namespace App\Http\Controllers;

use App\Models\PegawaiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $authUser = Auth::user();
        $idPegawai = $authUser->nip; // Ambil ID pegawai dari user login

        $pegawai = PegawaiModel::with([
            'riwayatPendidikan' => function ($q) {
                $q->where('aktif', 'ya');
            },
            'jabatanFungsional' => function ($q) {
                $q->where('aktif', 'ya');
            },
            'jabatanStruktural' => function ($q) {
                $q->where('aktif', 'ya');
            },
            'riwayatKepegawaian' => function ($q) {
                $q->where('aktif', 'ya');
            }
        ])->findOrFail($idPegawai);

        return view('home', [
            'pegawai' => $pegawai,
            'riwayatPendidikan' => $pegawai->riwayatPendidikan,
            'jabatanFungsional' => $pegawai->jabatanFungsional,
            'jabatanStruktural' => $pegawai->jabatanStruktural,
            'riwayatKepegawaian' => $pegawai->riwayatKepegawaian,
        ]);
    }
}
