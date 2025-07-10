<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh', 'logout']]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:20|unique:users',
            'level' => 'required|string|in:pegawai,admin,operator',
            'password' => 'required|string|min:5',
        ]);

        $user = UserModel::create([
            'nip' => $request->nip,
            'level' => $request->level,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::guard('api')->login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('nip', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'NIP atau password salah',
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'user' => Auth::guard('api')->user(),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout(Request $request)
{
    // Hapus semua data session
    $request->session()->invalidate();

    // Regenerasi token CSRF untuk sesi berikutnya (jika diperlukan)
    $request->session()->regenerateToken();

    // Return JSON response
    return response()->json([
        'success' => true,
        'message' => 'Berhasil logout dan sesi dihapus'
    ]);
}




    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::guard('api')->user(),
            'authorisation' => [
                'token' => JWTAuth::parseToken()->refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function syncSession(Request $request)
    {
        try {
            $token = $request->bearerToken();
            if (!$token) {
                return response()->json(['error' => 'Token not provided'], 401);
            }

            $user = JWTAuth::setToken($token)->authenticate();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            Auth::login($user);

            session()->put('nip', $user->nip);
            session()->put('level', $user->level);
            session()->put('nama', optional($user->pegawai)->nama); // pakai relasi

            return response()->json(['message' => 'Session synced']);
        } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Token error: ' . $e->getMessage()], 401);
        }
    }
}
