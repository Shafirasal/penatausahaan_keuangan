<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\SshModel;
use App\Models\RealisasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        // Ambil data realisasi untuk section pelayanan
        $dataBagian = $this->getRealisasiByBagian();

        // Hitung total keseluruhan
        $totalKeseluruhan = [
            'pagu' => $dataBagian['pbj']['pagu'] + $dataBagian['lpse']['pagu'] + $dataBagian['pembinaan']['pagu'],
            'realisasi' => $dataBagian['pbj']['realisasi'] + $dataBagian['lpse']['realisasi'] + $dataBagian['pembinaan']['realisasi'],
        ];
        $totalKeseluruhan['selisih'] = $totalKeseluruhan['pagu'] - $totalKeseluruhan['realisasi'];
        $totalKeseluruhan['persentase'] = $totalKeseluruhan['pagu'] > 0
            ? round(($totalKeseluruhan['realisasi'] / $totalKeseluruhan['pagu']) * 100, 2)
            : 0;

        return view('auth.login', compact('dataBagian', 'totalKeseluruhan'));
    }

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

        if ($user->level === 'pimpinan') {

            return response()->json([
                'redirect' => url('/general_dashboard'),
                'message'  => 'Login berhasil.',
            ]);
        } else {
            return response()->json([
                'redirect' => url('/dashboard'),
                'message'  => 'Login berhasil.',
            ]);
        }
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
     * Mengambil data realisasi untuk 3 bagian (PBJ, LPSE, Pembinaan)
     */
    private function getRealisasiByBagian()
    {
        // Definisi kode kegiatan untuk setiap bagian
        $kodeKegiatan = [
            'pbj' => '40107101',
            'lpse' => '40107102',
            'pembinaan' => '40107103'
        ];

        $result = [];

        foreach ($kodeKegiatan as $bagian => $kode) {
            $data = $this->hitungRealisasi($kode);
            $result[$bagian] = $data;
        }

        return $result;
    }

    /**
     * Menghitung total pagu, realisasi, selisih, dan persentase berdasarkan kode kegiatan
     */
    private function hitungRealisasi($kodeKegiatan)
    {
        // Ambil total pagu dari t_ssh berdasarkan kode_kegiatan
        // Menggunakan relasi: SSH -> SubKegiatan -> Kegiatan
        $totalPagu = SshModel::whereHas('sub_kegiatan.kegiatan', function($query) use ($kodeKegiatan) {
                $query->where('kode_kegiatan', $kodeKegiatan);
            })
            ->selectRaw('SUM(COALESCE(NULLIF(pagu2, 0), pagu1, 0)) as total')
            ->value('total') ?? 0;

        // Ambil total realisasi dari t_transaksional_realisasi_anggaran
        // Menggunakan relasi: Realisasi -> SSH -> SubKegiatan -> Kegiatan
        $totalRealisasi = RealisasiModel::whereHas('ssh.sub_kegiatan.kegiatan', function($query) use ($kodeKegiatan) {
                $query->where('kode_kegiatan', $kodeKegiatan);
            })
            ->selectRaw('SUM(COALESCE(nilai_realisasi, 0)) as total')
            ->value('total') ?? 0;

        // Hitung selisih dan persentase
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