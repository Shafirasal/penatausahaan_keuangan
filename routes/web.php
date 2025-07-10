<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JabatanFungsionalController;
use App\Http\Controllers\JabatanStrukturalController;
use App\Http\Controllers\RiwayatKepegawaianController;
use App\Http\Controllers\RiwayatPendidikanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/sync-session', [AuthController::class, 'syncSession'])->middleware('web');

Route::post('/logout', [AuthController::class, 'logout'])->middleware(['web'])->name('logout');
Route::middleware(['web', 'session.auth'])->group(function () {
Route::get('/home', function () {
    return view('home');
});




Route::prefix('jabatan_struktural')->name('jabatan_struktural.')->middleware('web')->group(function () {
    Route::post('/list', [JabatanStrukturalController::class, 'list']);
    Route::get('/', [JabatanStrukturalController::class, 'index']);
    Route::get('/{id}/show', [JabatanStrukturalController::class, 'show']);
    Route::get('/{id}/edit', [JabatanStrukturalController::class, 'edit']);
    Route::put('/{id}/update', [JabatanStrukturalController::class, 'update']);
    Route::get('/create', [JabatanStrukturalController::class, 'create']);
    Route::post('/store', [JabatanStrukturalController::class, 'store']);
    Route::get('/{id}/confirm', [JabatanStrukturalController::class, 'confirm']);
    Route::delete('/{id}/delete', [JabatanStrukturalController::class, 'delete']);
});


Route::prefix('riwayat_pendidikan')->middleware('web')->group(function () {
    Route::get('/', [RiwayatPendidikanController::class, 'index']);
    Route::post('/list', [RiwayatPendidikanController::class, 'list']);
    Route::get('/create', [RiwayatPendidikanController::class, 'create']);
    Route::post('/store', [RiwayatPendidikanController::class, 'store']);
    Route::get('/{id}/show', [RiwayatPendidikanController::class, 'show']);
    Route::get('/{id}/confirm', [RiwayatPendidikanController::class, 'confirm']);
    Route::delete('/{id}/delete', [RiwayatPendidikanController::class, 'delete']);
    Route::get('/{id}/edit', [RiwayatPendidikanController::class, 'edit']);
    Route::put('/{id}/update', [RiwayatPendidikanController::class, 'update']);
});

Route::prefix('jabatan_fungsional')->middleware('web')->group(function () {
    Route::get('/', [JabatanFungsionalController::class, 'index']);
    Route::post('/list', [JabatanFungsionalController::class, 'list']);
    Route::get('/create', [JabatanFungsionalController::class, 'create']);
    Route::post('/store', [JabatanFungsionalController::class, 'store']);
    Route::get('/{id}/show', [JabatanFungsionalController::class, 'show']);
    Route::get('/{id}/edit', [JabatanFungsionalController::class, 'edit']);
    Route::put('/{id}/update', [JabatanFungsionalController::class, 'update']);
    Route::get('/{id}/confirm', [JabatanFungsionalController::class, 'confirm']);
    Route::delete('/{id}/delete', [JabatanFungsionalController::class, 'delete']);
});



Route::prefix('riwayat_kepegawaian')->middleware('web')->group(function () {
    Route::get('/', [RiwayatKepegawaianController::class, 'index']);
    Route::post('/list', [RiwayatKepegawaianController::class, 'list']);
    Route::get('/create', [RiwayatKepegawaianController::class, 'create']);
    Route::post('/store', [RiwayatKepegawaianController::class, 'store']);
    Route::get('/{id}/show', [RiwayatKepegawaianController::class, 'show']);
    Route::get('/{id}/confirm', [RiwayatKepegawaianController::class, 'confirm']);
    Route::delete('/{id}/delete', [RiwayatKepegawaianController::class, 'delete']);
        Route::get('/{id}/edit', [RiwayatKepegawaianController::class, 'edit']);
    Route::put('/{id}/update', [RiwayatKepegawaianController::class, 'update']);
});

});

