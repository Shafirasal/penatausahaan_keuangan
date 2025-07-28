<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
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

    public function showLoginForm()
    {
        return view('auth.login'); // tampilkan form login (buat view-nya)
    }


    //   public function login(Request $request)
    // {
    //     $request->validate([
    //         'nip' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     $credentials = $request->only('nip', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate(); // Hindari session fixation

    //         // Simpan data tambahan ke dalam session
    //         $user = Auth::user();
    //         session()->put('nip', $user->nip);
    //         session()->put('level', $user->level);

    //         return redirect()->intended('/home'); // arahkan ke halaman utama
    //     }

    //     return back()->withErrors([
    //         'nip' => 'NIP atau password salah.',
    //     ])->withInput();
    // }
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

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}
