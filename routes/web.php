<?php

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

Route::get('/', function () {
    return view('home');
});



Route::prefix('riwayat_pendidikan')->group(function () {
    Route::get('/', [RiwayatPendidikanController::class, 'index']);
    Route::post('/list', [RiwayatPendidikanController::class, 'list']);
    Route::get('/create', [RiwayatPendidikanController::class, 'create']);
});
