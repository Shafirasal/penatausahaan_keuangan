<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\SshModel;
use App\Models\RealisasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct()
    {
        // Gunakan middleware auth session kecuali untuk login dan register
        $this->middleware('guest')->except(['logout']);
    }

    /**
     * Tampilkan form login dengan data realisasi untuk section pelayanan
     */
    public function showLoginForm()
    {
        // Ambil tahun sekarang
        $tahun = date('Y');

        // Ambil data realisasi untuk section pelayanan (4 bagian) - filtered by tahun
        $dataBagian = $this->getRealisasiByBagian($tahun);
        
        // Hitung total keseluruhan (hanya 3 bagian: PBJ, LPSE, Pembinaan)
        $totalKeseluruhan = [
            'pagu' => $dataBagian['pbj']['pagu'] + $dataBagian['lpse']['pagu'] + $dataBagian['pembinaan']['pagu'],
            'realisasi' => $dataBagian['pbj']['realisasi'] + $dataBagian['lpse']['realisasi'] + $dataBagian['pembinaan']['realisasi'],
        ];
        $totalKeseluruhan['selisih'] = $totalKeseluruhan['pagu'] - $totalKeseluruhan['realisasi'];
        $totalKeseluruhan['persentase'] = $totalKeseluruhan['pagu'] > 0 
            ? round(($totalKeseluruhan['realisasi'] / $totalKeseluruhan['pagu']) * 100, 2) 
            : 0;
        
        return view('auth.login', compact('dataBagian', 'totalKeseluruhan', 'tahun'));
    }
    // public function showLoginForm()
    // {
        // Ambil data realisasi untuk section pelayanan (4 bagian)
    //     $dataBagian = $this->getRealisasiByBagian();
        
         // Hitung total keseluruhan (hanya 3 bagian: PBJ, LPSE, Pembinaan)
    //     $totalKeseluruhan = [
    //         'pagu' => $dataBagian['pbj']['pagu'] + $dataBagian['lpse']['pagu'] + $dataBagian['pembinaan']['pagu'],
    //         'realisasi' => $dataBagian['pbj']['realisasi'] + $dataBagian['lpse']['realisasi'] + $dataBagian['pembinaan']['realisasi'],
    //     ];
    //     $totalKeseluruhan['selisih'] = $totalKeseluruhan['pagu'] - $totalKeseluruhan['realisasi'];
    //     $totalKeseluruhan['persentase'] = $totalKeseluruhan['pagu'] > 0 
    //     //    ? round(($totalKeseluruhan['realisasi'] / $totalKeseluruhan['pagu']) * 100, 2) 
    //         : 0;
        
    //     return view('auth.login', compact('dataBagian', 'totalKeseluruhan'));
    // }

    /**
     * Proses login dengan AJAX
     */
    public function login(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('nip', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'errors' => ['nip' => ['NIP atau password salah.']]
            ], 422);
        }

        $request->session()->regenerate();

        /** @var \App\Models\UserModel $user */
        $user = Auth::user();
        session()->put('nip', $user->nip);
        session()->put('level', $user->level);

        return response()->json([
            'redirect' => url('/dashboard'),
            'message'  => 'Login berhasil.',
        ]);
    }

    /**
     * Register user baru
     */
    public function register(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:20|unique:t_user,nip',
            'level' => 'required|string|in:pegawai,admin,operator',
            'password' => 'required|string|min:5',
        ]);

        $user = UserModel::create([
            'nip' => $request->nip,
            'level' => $request->level,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user); // langsung login setelah register

        return redirect('/profile')->with('success', 'Registrasi berhasil.');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }

    /**
     * Mengambil data realisasi untuk 4 bagian (PBJ, LPSE, Pembinaan, Tata Kelola)
     * Filtered berdasarkan field tahun di t_ssh
     */
    private function getRealisasiByBagian($tahun)
    {
        $result = [];
        
        // 3 Bagian berdasarkan kode_kegiatan
        $kodeKegiatan = [
            'pbj' => '40107101',
            'lpse' => '40107102',
            'pembinaan' => '40107103'
        ];
        
        foreach ($kodeKegiatan as $bagian => $kode) {
            $result[$bagian] = $this->hitungRealisasiByKegiatan($kode, $tahun);
        }
        
        // Tata Kelola berdasarkan kode_program (semua kegiatan dalam program 40101)
        $result['tatakelola'] = $this->hitungRealisasiByProgram('40101', $tahun);
        
        return $result;
    }

    /**
     * Mengambil data realisasi untuk 4 bagian (PBJ, LPSE, Pembinaan, Tata Kelola)
     */
    // private function getRealisasiByBagian()
    // {
    //     $result = [];
        
    //     // 3 Bagian berdasarkan kode_kegiatan
    //     $kodeKegiatan = [
    //         'pbj' => '40107101',
    //         'lpse' => '40107102',
    //         'pembinaan' => '40107103'
    //     ];
        
    //     foreach ($kodeKegiatan as $bagian => $kode) {
    //         $result[$bagian] = $this->hitungRealisasiByKegiatan($kode);
    //     }
        
    //     // Tata Kelola berdasarkan kode_program (semua kegiatan dalam program 40101)
    //     $result['tatakelola'] = $this->hitungRealisasiByProgram('40101');
        
    //     return $result;
    // }

    /**
     * Menghitung realisasi berdasarkan kode_kegiatan dengan filter tahun
     */
    private function hitungRealisasiByKegiatan($kodeKegiatan, $tahun)
    {
        // Ambil total pagu dengan logika baru - filter berdasarkan field tahun di t_ssh
        $paguData = DB::table('t_ssh as s')
            ->join('t_master_sub_kegiatan as sk', 's.id_sub_kegiatan', '=', 'sk.id_sub_kegiatan')
            ->join('t_master_kegiatan as k', 'sk.id_kegiatan', '=', 'k.id_kegiatan')
            ->where('k.kode_kegiatan', $kodeKegiatan)
            ->whereYear('s.tahun', $tahun)
            ->selectRaw('
                SUM(s.pagu1) AS total_pagu1,
                SUM(s.pagu2) AS total_pagu2,
                CASE
                    WHEN SUM(s.pagu2) = 0 AND SUM(s.pagu1) > 0 THEN SUM(s.pagu1)
                    WHEN SUM(s.pagu2) > 0 THEN SUM(s.pagu2)
                    ELSE 0
                END AS total_dipakai
            ')
            ->first();
        
        $totalPagu = $paguData->total_dipakai ?? 0;
        
        // Ambil total realisasi - filter berdasarkan field tahun di t_ssh
        $totalRealisasi = DB::table('t_transaksional_realisasi_anggaran as r')
            ->join('t_ssh as s', 'r.id_ssh', '=', 's.id_ssh')
            ->join('t_master_sub_kegiatan as sk', 's.id_sub_kegiatan', '=', 'sk.id_sub_kegiatan')
            ->join('t_master_kegiatan as k', 'sk.id_kegiatan', '=', 'k.id_kegiatan')
            ->where('k.kode_kegiatan', $kodeKegiatan)
            ->whereYear('s.tahun', $tahun)
            ->sum('r.nilai_realisasi') ?? 0;
        
        return $this->formatHasilRealisasi($totalPagu, $totalRealisasi);
    }
    
    
    /**
     * Menghitung realisasi berdasarkan kode_kegiatan (LOGIKA BARU)
     */
    // private function hitungRealisasiByKegiatan($kodeKegiatan)
    // {
    //     // Ambil total pagu dengan logika BARU
    //     $paguData = DB::table('t_ssh as s')
    //         ->join('t_master_sub_kegiatan as sk', 's.id_sub_kegiatan', '=', 'sk.id_sub_kegiatan')
    //         ->join('t_master_kegiatan as k', 'sk.id_kegiatan', '=', 'k.id_kegiatan')
    //         ->where('k.kode_kegiatan', $kodeKegiatan)
    //         ->selectRaw('
    //             SUM(s.pagu1) AS total_pagu1,
    //             SUM(s.pagu2) AS total_pagu2,
    //             CASE
    //                 WHEN SUM(s.pagu2) = 0 AND SUM(s.pagu1) > 0 THEN SUM(s.pagu1)
    //                 WHEN SUM(s.pagu2) > 0 THEN SUM(s.pagu2)
    //                 ELSE 0
    //             END AS total_dipakai
    //         ')
    //         ->first();
        
    //     $totalPagu = $paguData->total_dipakai ?? 0;
        
    //     // Ambil total realisasi
    //     $totalRealisasi = DB::table('t_transaksional_realisasi_anggaran as r')
    //         ->join('t_ssh as s', 'r.id_ssh', '=', 's.id_ssh')
    //         ->join('t_master_sub_kegiatan as sk', 's.id_sub_kegiatan', '=', 'sk.id_sub_kegiatan')
    //         ->join('t_master_kegiatan as k', 'sk.id_kegiatan', '=', 'k.id_kegiatan')
    //         ->where('k.kode_kegiatan', $kodeKegiatan)
    //         ->sum('r.nilai_realisasi') ?? 0;
        
    //     return $this->formatHasilRealisasi($totalPagu, $totalRealisasi);
    // }
    
    private function hitungRealisasiByProgram($kodeProgram, $tahun)
    {
        // Ambil total pagu dengan logika baru - filter berdasarkan field tahun di t_ssh
        $paguData = DB::table('t_ssh as s')
            ->join('t_master_sub_kegiatan as sk', 's.id_sub_kegiatan', '=', 'sk.id_sub_kegiatan')
            ->join('t_master_kegiatan as k', 'sk.id_kegiatan', '=', 'k.id_kegiatan')
            ->join('t_master_program as p', 'k.id_program', '=', 'p.id_program')
            ->where('p.kode_program', $kodeProgram)
            ->whereYear('s.tahun', $tahun)
            ->selectRaw('
                SUM(s.pagu1) AS total_pagu1,
                SUM(s.pagu2) AS total_pagu2,
                CASE
                    WHEN SUM(s.pagu2) = 0 AND SUM(s.pagu1) > 0 THEN SUM(s.pagu1)
                    WHEN SUM(s.pagu2) > 0 THEN SUM(s.pagu2)
                    ELSE 0
                END AS total_dipakai
            ')
            ->first();
        
        $totalPagu = $paguData->total_dipakai ?? 0;
        
        // Ambil total realisasi - filter berdasarkan field tahun di t_ssh
        $totalRealisasi = DB::table('t_transaksional_realisasi_anggaran as r')
            ->join('t_ssh as s', 'r.id_ssh', '=', 's.id_ssh')
            ->join('t_master_sub_kegiatan as sk', 's.id_sub_kegiatan', '=', 'sk.id_sub_kegiatan')
            ->join('t_master_kegiatan as k', 'sk.id_kegiatan', '=', 'k.id_kegiatan')
            ->join('t_master_program as p', 'k.id_program', '=', 'p.id_program')
            ->where('p.kode_program', $kodeProgram)
            ->whereYear('s.tahun', $tahun)
            ->selectRaw('SUM(r.nilai_realisasi) as total')
            ->value('total') ?? 0;
        
        return $this->formatHasilRealisasi($totalPagu, $totalRealisasi);
    }
    /**
     * Menghitung realisasi berdasarkan kode_program
     */
    // private function hitungRealisasiByProgram($kodeProgram)
    // {
    //     // Ambil total pagu dengan logika BARU
    //     $paguData = DB::table('t_ssh as s')
    //         ->join('t_master_sub_kegiatan as sk', 's.id_sub_kegiatan', '=', 'sk.id_sub_kegiatan')
    //         ->join('t_master_kegiatan as k', 'sk.id_kegiatan', '=', 'k.id_kegiatan')
    //         ->join('t_master_program as p', 'k.id_program', '=', 'p.id_program')
    //         ->where('p.kode_program', $kodeProgram)
    //         ->selectRaw('
    //             SUM(s.pagu1) AS total_pagu1,
    //             SUM(s.pagu2) AS total_pagu2,
    //             CASE
    //                 WHEN SUM(s.pagu2) = 0 AND SUM(s.pagu1) > 0 THEN SUM(s.pagu1)
    //                 WHEN SUM(s.pagu2) > 0 THEN SUM(s.pagu2)
    //                 ELSE 0
    //             END AS total_dipakai
    //         ')
    //         ->first();
        
    //     $totalPagu = $paguData->total_dipakai ?? 0;
        
    //     // Ambil total realisasi
    //     $totalRealisasi = DB::table('t_transaksional_realisasi_anggaran as r')
    //         ->join('t_ssh as s', 'r.id_ssh', '=', 's.id_ssh')
    //         ->join('t_master_sub_kegiatan as sk', 's.id_sub_kegiatan', '=', 'sk.id_sub_kegiatan')
    //         ->join('t_master_kegiatan as k', 'sk.id_kegiatan', '=', 'k.id_kegiatan')
    //         ->join('t_master_program as p', 'k.id_program', '=', 'p.id_program')
    //         ->where('p.kode_program', $kodeProgram)
    //         ->selectRaw('SUM(r.nilai_realisasi) as total')
    //         ->value('total') ?? 0;
        
    //     return $this->formatHasilRealisasi($totalPagu, $totalRealisasi);
    // }
    
    /**
     * Format hasil perhitungan realisasi
     */
    private function formatHasilRealisasi($totalPagu, $totalRealisasi)
    {
        $selisih = $totalPagu - $totalRealisasi;
        $persentase = $totalPagu > 0 ? round(($totalRealisasi / $totalPagu) * 100, 2) : 0;
        
        return [
            'pagu' => $totalPagu,
            'realisasi' => $totalRealisasi,
            'selisih' => $selisih,
            'persentase' => $persentase
        ];
    }
}