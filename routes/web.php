<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JabatanStrukturalController;
use App\Http\Controllers\JabatanFungsionalController;
use App\Http\Controllers\RiwayatPendidikanController;
use App\Http\Controllers\RiwayatKepegawaianController;
use Illuminate\Support\Facades\Auth;


Route::redirect('/', '/login');
// Login page (GET)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Proses login (POST)
Route::post('/login', [AuthController::class, 'login']);

// Logout (POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang butuh login session (guard: web)
Route::middleware(['web', 'session.auth'])->group(function () {

    Route::get('/home', function () {
        return view('home');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Jabatan Struktural
    Route::prefix('jabatan_struktural')->name('jabatan_struktural.')->group(function () {
        Route::post('/list', [JabatanStrukturalController::class, 'list']);
        Route::get('/', [JabatanStrukturalController::class, 'index']);
        Route::get('/create', [JabatanStrukturalController::class, 'create']);
        Route::post('/store', [JabatanStrukturalController::class, 'store']);
        Route::get('/{id}/show', [JabatanStrukturalController::class, 'show']);
        Route::get('/{id}/edit', [JabatanStrukturalController::class, 'edit']);
        Route::put('/{id}/update', [JabatanStrukturalController::class, 'update']);
        Route::get('/{id}/confirm', [JabatanStrukturalController::class, 'confirm']);
        Route::delete('/{id}/delete', [JabatanStrukturalController::class, 'delete']);
    });

    // Jabatan Fungsional
    Route::prefix('jabatan_fungsional')->name('jabatan_fungsional.')->group(function () {
        Route::post('/list', [JabatanFungsionalController::class, 'list']);
        Route::get('/', [JabatanFungsionalController::class, 'index']);
        Route::get('/create', [JabatanFungsionalController::class, 'create']);
        Route::post('/store', [JabatanFungsionalController::class, 'store']);
        Route::get('/{id}/show', [JabatanFungsionalController::class, 'show']);
        Route::get('/{id}/edit', [JabatanFungsionalController::class, 'edit']);
        Route::put('/{id}/update', [JabatanFungsionalController::class, 'update']);
        Route::get('/{id}/confirm', [JabatanFungsionalController::class, 'confirm']);
        Route::delete('/{id}/delete', [JabatanFungsionalController::class, 'delete']);
    });

    // Riwayat Pendidikan
    Route::prefix('riwayat_pendidikan')->name('riwayat_pendidikan.')->group(function () {
        Route::post('/list', [RiwayatPendidikanController::class, 'list']);
        Route::get('/', [RiwayatPendidikanController::class, 'index']);
        Route::get('/create', [RiwayatPendidikanController::class, 'create']);
        Route::post('/store', [RiwayatPendidikanController::class, 'store']);
        Route::get('/{id}/show', [RiwayatPendidikanController::class, 'show']);
        Route::get('/{id}/edit', [RiwayatPendidikanController::class, 'edit']);
        Route::put('/{id}/update', [RiwayatPendidikanController::class, 'update']);
        Route::get('/{id}/confirm', [RiwayatPendidikanController::class, 'confirm']);
        Route::delete('/{id}/delete', [RiwayatPendidikanController::class, 'delete']);
    });

    // Riwayat Kepegawaian
    Route::prefix('riwayat_kepegawaian')->name('riwayat_kepegawaian.')->group(function () {
        Route::post('/list', [RiwayatKepegawaianController::class, 'list']);
        Route::get('/', [RiwayatKepegawaianController::class, 'index']);
        Route::get('/create', [RiwayatKepegawaianController::class, 'create']);
        Route::post('/store', [RiwayatKepegawaianController::class, 'store']);
        Route::get('/{id}/show', [RiwayatKepegawaianController::class, 'show']);
        Route::get('/{id}/edit', [RiwayatKepegawaianController::class, 'edit']);
        Route::put('/{id}/update', [RiwayatKepegawaianController::class, 'update']);
        Route::get('/{id}/confirm', [RiwayatKepegawaianController::class, 'confirm']);
        Route::delete('/{id}/delete', [RiwayatKepegawaianController::class, 'delete']);
    });

    Route::get('whoami', function () {
        return dd(Auth::user());
    })->name('whoami');
});
