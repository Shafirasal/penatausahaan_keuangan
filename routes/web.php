<?php

use App\Http\Controllers\JabatanStrukturalController;
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
Route::get('/home', function () {
    return view('home');
})->middleware('web');




Route::prefix('jabatan_struktural')->name('jabatan_struktural.')->group(function() {
    Route::get('/list', [JabatanStrukturalController::class, 'list'])->name('data');
    Route::resource('/', JabatanStrukturalController::class)->parameters(['' => 'id']);
});


Route::prefix('riwayat_pendidikan')->group(function () {
    Route::get('/', [RiwayatPendidikanController::class, 'index']);
    Route::post('/list', [RiwayatPendidikanController::class, 'list']);
    Route::get('/create', [RiwayatPendidikanController::class, 'create']);
    Route::get('/{id}/show', [RiwayatPendidikanController::class, 'show']);
    Route::get('/{id}/confirm', [RiwayatPendidikanController::class, 'confirm']);
    Route::delete('/{id}/delete', [RiwayatPendidikanController::class, 'delete']);

});
