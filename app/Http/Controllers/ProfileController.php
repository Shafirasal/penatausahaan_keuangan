<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    /**
     * Update data profil (nama, email, hp, foto).
     */
    public function update(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $authUser = Auth::user();
            $user = UserModel::find($authUser->id_user);
            $pegawai = $user->pegawai;

            // Rules validasi
            $rules = [
                'nama' => 'required|string|max:255',
                'hp' => 'nullable|string|max:20',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('t_pegawai', 'email')->ignore($pegawai->nip, 'nip'),
                ],
             'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:10000',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            // Update data pegawai
            $pegawai->nama = $request->nama;
            $pegawai->hp = $request->hp;
            $pegawai->email = $request->email;

            // Upload foto (opsional)
            if ($request->hasFile('foto')) {
                if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                    Storage::disk('public')->delete($pegawai->foto);
                }
                $path = $request->file('foto')->store('foto_profile', 'public');
                $pegawai->foto = $path;
            }

            $pegawai->save();

            return response()->json([
                'status' => true,
                'message' => 'Profil berhasil diperbarui.'
            ]);
        }

        return redirect('/');
    }

    public function updatePassword(Request $request)
    {

        if ($request->ajax() || $request->wantsJson()) {
            $authUser = Auth::user();
            $user = UserModel::find($authUser->id_user);

            // Rules validasi
            $rules = [
                'current_password' => 'required|string',
                'password' => 'required|string|min:5|confirmed',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            // Cek password lama
            // Verifikasi password lama
            if (!Hash::check($request->current_password, $user->password)) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Password lama tidak sesuai.',
                        'field' => 'current_password'
                    ]);
                }
                return back()->withErrors([
                    'current_password' => 'Password lama tidak sesuai.'
                ]);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Password berhasil diganti.'
            ]);
        }

        return redirect('/');
    }
}
