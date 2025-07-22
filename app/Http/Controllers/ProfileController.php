<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\UserModel;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        // Ambil user yang sedang login melalui session web
        // $user = Auth::user();
        $user = UserModel::findOrFail(Auth::id());

        if (!$user) {
            return redirect()->route('login')->withErrors('Anda harus login terlebih dahulu.');
        }

        // Ambil relasi pegawai
        $pegawai = $user->pegawai;

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'hp' => 'nullable|string|max:20',
            'email' => [
                'required',
                'email',
                Rule::unique('t_pegawai', 'email')->ignore($pegawai->nip, 'nip'),
            ],
            'password' => 'nullable|string|min:5',
            'foto' => 'nullable|image|max:2048',
        ]);
        
        // Update data pegawai
        $pegawai->nama = $request->nama;
        $pegawai->hp = $request->hp;
        $pegawai->email = $request->email;

        // Handle upload dan simpan foto
        if ($request->hasFile('foto')) {
            if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            $pegawai->foto = $request->file('foto')->store('foto_profile', 'public');
        }

        $pegawai->save();

        /** @var \App\Models\UserModel $user */

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
