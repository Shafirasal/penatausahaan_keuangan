<?php

use App\Http\Controllers\GeneralDashboardController;
use App\Http\Controllers\MasterProgramController;

use App\Http\Controllers\RealisasipbjController;
use App\Http\Controllers\RealisasiTatakelolaController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JabatanStrukturalController;
use App\Http\Controllers\JabatanFungsionalController;
use App\Http\Controllers\RiwayatPendidikanController;
use App\Http\Controllers\RiwayatKepegawaianController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\MasterKegiatanController;
use App\Http\Controllers\MasterSubKegiatanController;
use App\Http\Controllers\RealisasilpseController;
use App\Http\Controllers\RealisasiPembinaanController;
use App\Http\Controllers\SSHController;
use App\Http\Controllers\TreeViewController;
use App\Http\Controllers\DashboardRealisasiController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;


Route::redirect('/', '/login');
Route::get('/realisasi/pelayanan', [DashboardRealisasiController::class, 'getPersentaseBagian'])
    ->name('realisasi.pelayanan');

// Login page (GET)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Proses login (POST)
Route::post('/login', [AuthController::class, 'login']);

// Logout (POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang butuh login session (guard: web)
Route::middleware(['web', 'session.auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', function () {
        return view('profile.change_password');
    })->name('profile.change_password');
    Route::put('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update_password');


    Route::prefix('general_dashboard')->name('general_dashboard.')->group(function () {
        Route::get('/', [GeneralDashboardController::class, 'index']);
        Route::get('/grafik', [GeneralDashboardController::class, 'grafik']);
        Route::get('/rekap', [GeneralDashboardController::class, 'rekap']);
        // Route::get('/dashboard/perbandingan', [GeneralDashboardController::class, 'getPerbandinganRealisasiSisaAnggaranPerTahun']);
        // Route::get('/anggaran', [GeneralDashboardController::class, 'index'])->name('anggaran.index');

    });

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




    Route::group(['middleware' => ['cek.level:admin']], function () {
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/list', [UserController::class, 'list']);
            Route::get('/create', [UserController::class, 'create']);
            Route::post('/store', [UserController::class, 'store']);
            Route::get('/{id}/show', [UserController::class, 'show']);  // Perbaikan URL
            Route::get('/{id}/edit', [UserController::class, 'edit']);
            Route::put('/{id}/update', [UserController::class, 'update']); // Perbaikan URL
            Route::get('/{id}/confirm', [UserController::class, 'confirm']);
            Route::delete('/{id}/delete', [UserController::class, 'delete']);
            Route::get('/import', [UserController::class, 'import']);
            Route::post('/import_ajax', [UserController::class, 'import_ajax']);
        });
   
        // Pegawai
        Route::prefix('pegawai')->name('pegawai.')->group(function () {
            Route::post('/list', [PegawaiController::class, 'list']);
            Route::get('/', [PegawaiController::class, 'index']);
            Route::get('/create', [PegawaiController::class, 'create']);
            Route::post('/store', [PegawaiController::class, 'store']);
            Route::post('/check_nip', [PegawaiController::class, 'checkNip']);
            Route::get('/{nip}/show', [PegawaiController::class, 'show']);
            Route::get('/{nip}/edit', [PegawaiController::class, 'edit']);
            Route::put('/{nip}/update', [PegawaiController::class, 'update']);
            Route::get('/{nip}/confirm', [PegawaiController::class, 'confirm']);
            Route::delete('/{nip}/delete', [PegawaiController::class, 'delete']);

            Route::get('/provinsi/{id_provinsi}/kabupaten', [PegawaiController::class, 'getKabupatenByProvinsi']);
            Route::get('/kabupaten/{id_kabupaten}/kecamatan', [PegawaiController::class, 'getKecamatanByKabupaten']);
            Route::get('/kecamatan/{id_kecamatan}/kelurahan', [PegawaiController::class, 'getKelurahanByKecamatan']);
        });

});
        // master program
        Route::group(['middleware' => ['cek.level:admin,operator']], function () {
        Route::prefix('master_program')->name('master_program.')->group(function () {
            Route::post('/list', [MasterProgramController::class, 'list']);
            Route::get('/', [MasterProgramController::class, 'index']);
            Route::get('/create', [MasterProgramController::class, 'create']);
            Route::post('/store', [MasterProgramController::class, 'store']);
            Route::get('/{id}/show', [MasterProgramController::class, 'show']);
            Route::get('/{id}/edit', [MasterProgramController::class, 'edit']);
            Route::put('/{id}/update', [MasterProgramController::class, 'update']);
            Route::get('/{id}/confirm', [MasterProgramController::class, 'confirm']);
            Route::delete('/{id}/delete', [MasterProgramController::class, 'delete']);
        });

        // master kegiatan
        Route::prefix('master_kegiatan')->name('master_kegiatan.')->group(function () {
            Route::post('/list', [MasterKegiatanController::class, 'list']);
            Route::get('/', [MasterKegiatanController::class, 'index']);
            Route::get('/create', [MasterKegiatanController::class, 'create']);
            Route::post('/store', [MasterKegiatanController::class, 'store']);
            Route::get('/{id}/show', [MasterKegiatanController::class, 'show']);
            Route::get('/{id}/edit', [MasterKegiatanController::class, 'edit']);
            Route::put('/{id}/update', [MasterKegiatanController::class, 'update']);
            Route::get('/{id}/confirm', [MasterKegiatanController::class, 'confirm']);
            Route::delete('/{id}/delete', [MasterKegiatanController::class, 'delete']);
        });
        // master subkegiatan
        Route::prefix('master_sub_kegiatan')->name('master_sub_kegiatan.')->group(function () {
            Route::post('/list', [MasterSubKegiatanController::class, 'list']);
            Route::get('/', [MasterSubKegiatanController::class, 'index']);
            Route::get('/create', [MasterSubKegiatanController::class, 'create']);
            Route::post('/store', [MasterSubKegiatanController::class, 'store']);
            Route::get('/{id}/edit', [MasterSubKegiatanController::class, 'edit']);
            Route::put('/{id}/update', [MasterSubKegiatanController::class, 'update']);
            Route::get('/{id}/confirm', [MasterSubKegiatanController::class, 'confirm']);
            Route::delete('/{id}/delete', [MasterSubKegiatanController::class, 'delete']);

            Route::get('/program/{id_program}/kegiatan', [MasterSubKegiatanController::class, 'getKegiatanByProgram']);
        });



        Route::prefix('master_rekening')->name('rekening.')->group(function () {

            Route::post('/list', [RekeningController::class, 'list']);
            Route::get('/', [RekeningController::class, 'index']);
            Route::get('/create', [RekeningController::class, 'create']);
            Route::post('/store', [RekeningController::class, 'store']);
            Route::get('/{id}/edit', [RekeningController::class, 'edit']);
            Route::put('/{id}/update', [RekeningController::class, 'update']);
            Route::delete('/{id}/delete', [RekeningController::class, 'delete']);
            Route::get('/{id}/confirm', [RekeningController::class, 'confirm']);
            Route::get('/import', [RekeningController::class, 'import']);
            Route::post('/import_ajax', [RekeningController::class, 'import_ajax']);

            // Cascading select (seperti provinsi → kabupaten → dst)
            Route::get('/program/{id_program}/kegiatan', [RekeningController::class, 'getKegiatanByProgram']);
            Route::get('/kegiatan/{id_kegiatan}/sub_kegiatan', [RekeningController::class, 'getSubKegiatanByKegiatan']);
        });

        Route::prefix('ssh')->name('ssh.')->group(function () {

            Route::post('/list', [SSHController::class, 'list']);
            Route::get('/', [SSHController::class, 'index']);
            Route::get('/create', [SSHController::class, 'create']);
            Route::post('/store', [SSHController::class, 'store']);
            Route::get('/{id}/edit', [SSHController::class, 'edit']);
            Route::put('/{id}/update', [SSHController::class, 'update']);
            Route::get('/{id}/confirm', [SSHController::class, 'confirm']);
            Route::delete('/{id}/delete', [SSHController::class, 'delete']);
            Route::get('/import', [SSHController::class, 'import']);
            Route::post('/import_ajax', [SSHController::class, 'import_ajax']);

            // Cascading select (seperti provinsi → kabupaten → dst)
            Route::get('/program/{id_program}/kegiatan', [SSHController::class, 'getKegiatanByProgram']);
            Route::get('/kegiatan/{id_kegiatan}/sub_kegiatan', [SSHController::class, 'getSubKegiatanByKegiatan']);
            Route::get('/sub_kegiatan/{id_sub_kegiatan}/rekening', [SSHController::class, 'getRekeningBySubKegiatan']);
        });
 
});
        Route::group(['middleware' => ['cek.level:admin,pimpinan']], function () {
        Route::prefix('tree_view')->group(function () {
            Route::get('/', [TreeViewController::class, 'index']);
            Route::post('/list-sub_kegiatan', [TreeViewController::class, 'listSubKegiatan']);
            // Route::post('/list-rekening', [TreeViewController::class, 'listRekening']);
            Route::get('/{id_sub_kegiatan}/rekening', [TreeViewController::class, 'listRekeningBySubKegiatan']);
            Route::get('/{id_rekening}/ssh', [TreeViewController::class, 'listSshByRekening']);
            Route::get('/program/{id_program}/kegiatan', [TreeViewController::class, 'getKegiatanByProgram']);
            Route::get('/kegiatan/{id_kegiatan}/sub_kegiatan', [TreeViewController::class, 'getSubKegiatanByKegiatan']);
            Route::get('/export_excel', [TreeViewController::class, 'export_excel']);
        });

});

        Route::group(['middleware' => ['cek.level:admin,operator']], function () {
        Route::prefix('realisasipbj')->group(function () {
            // DataTables
            Route::post('/list', [RealisasipbjController::class, 'list']);

            // CRUD
            Route::get('/', [RealisasipbjController::class, 'index']);
            Route::get('/create', [RealisasipbjController::class, 'create']);
            Route::post('/store', [RealisasipbjController::class, 'store']);
            Route::get('/{id}/edit', [RealisasipbjController::class, 'edit']);
            Route::put('/{id}/update', [RealisasipbjController::class, 'update']);
            Route::get('/{id}/confirm', [RealisasipbjController::class, 'confirm']);
            Route::delete('/{id}/delete', [RealisasipbjController::class, 'delete']);

            // Cascading select + Summary
            Route::get('/program/{id_program}/kegiatan',        [RealisasipbjController::class, 'getKegiatanByProgram']);
            Route::get('/kegiatan/{id_kegiatan}/summary',       [RealisasipbjController::class, 'getSummaryByKegiatan']);
            Route::get('/ssh/{id_ssh}/summary',                 [RealisasipbjController::class, 'getSummaryBySsh']);
            Route::get('/kegiatan/{id_kegiatan}/sub_kegiatan',  [RealisasipbjController::class, 'getSubKegiatanByKegiatan']);
            Route::get('/sub_kegiatan/{id_sub_kegiatan}/rekening', [RealisasipbjController::class, 'getRekeningBySubKegiatan']);
            Route::get('/rekening/{id_rekening}/ssh',           [RealisasipbjController::class, 'getSshByRekening']);
            Route::get('/ssh/{id}/histori', [RealisasipbjController::class, 'histori']);
        });


    Route::prefix('realisasilpse')->group(function () {
        // DataTables
        Route::post('/list', [RealisasilpseController::class, 'list']);

        // CRUD
        Route::get('/', [RealisasilpseController::class, 'index']);
        Route::get('/create', [RealisasilpseController::class, 'create']);
        Route::post('/store', [RealisasilpseController::class, 'store']);
        Route::get('/{id}/edit', [RealisasilpseController::class, 'edit']);
        Route::put('/{id}/update', [RealisasilpseController::class, 'update']);
        Route::get('/{id}/confirm', [RealisasilpseController::class, 'confirm']);
        Route::delete('/{id}/delete', [RealisasilpseController::class, 'delete']);

        // Cascading select
        Route::get('/program/{id_program}/kegiatan',        [RealisasilpseController::class, 'getKegiatanByProgram']);
        Route::get('/kegiatan/{id_kegiatan}/summary',        [RealisasilpseController::class, 'getSummaryByKegiatan']);
        Route::get('/ssh/{id_ssh}/summary',        [RealisasilpseController::class, 'getSummaryBySsh']);
        Route::get('/kegiatan/{id_kegiatan}/sub_kegiatan',  [RealisasilpseController::class, 'getSubKegiatanByKegiatan']);
        Route::get('/sub_kegiatan/{id_sub_kegiatan}/rekening', [RealisasilpseController::class, 'getRekeningBySubKegiatan']);
        Route::get('/rekening/{id_rekening}/ssh',           [RealisasilpseController::class, 'getSshByRekening']);

        Route::get('/ssh/{id}/histori', [RealisasilpseController::class, 'histori']);
    });


    Route::prefix('realisasipembinaan')->group(function () {
        // DataTables
        Route::post('/list', [RealisasiPembinaanController::class, 'list']);

        // CRUD
        Route::get('/', [RealisasiPembinaanController::class, 'index']);
        Route::get('/create', [RealisasiPembinaanController::class, 'create']);
        Route::post('/store', [RealisasiPembinaanController::class, 'store']);
        Route::get('/{id}/edit', [RealisasiPembinaanController::class, 'edit']);
        Route::put('/{id}/update', [RealisasiPembinaanController::class, 'update']);
        Route::get('/{id}/confirm', [RealisasiPembinaanController::class, 'confirm']);
        Route::delete('/{id}/delete', [RealisasiPembinaanController::class, 'delete']);

        // Cascading select
        Route::get('/program/{id_program}/kegiatan',        [RealisasiPembinaanController::class, 'getKegiatanByProgram']);
        Route::get('/kegiatan/{id_kegiatan}/summary',        [RealisasiPembinaanController::class, 'getSummaryByKegiatan']);
        Route::get('/ssh/{id_ssh}/summary',        [RealisasiPembinaanController::class, 'getSummaryBySsh']);
        Route::get('/kegiatan/{id_kegiatan}/sub_kegiatan',  [RealisasiPembinaanController::class, 'getSubKegiatanByKegiatan']);
        Route::get('/sub_kegiatan/{id_sub_kegiatan}/rekening', [RealisasiPembinaanController::class, 'getRekeningBySubKegiatan']);
        Route::get('/rekening/{id_rekening}/ssh',           [RealisasiPembinaanController::class, 'getSshByRekening']);

        Route::get('/ssh/{id}/histori', [RealisasiPembinaanController::class, 'histori']);
    });

    Route::prefix('realisasitatakelola')->group(function () {
        // DataTables
        Route::post('/list', [RealisasiTatakelolaController::class, 'list']);

        // CRUD
        Route::get('/', [RealisasiTatakelolaController::class, 'index']);
        Route::get('/create', [RealisasiTatakelolaController::class, 'create']);
        Route::post('/store', [RealisasiTatakelolaController::class, 'store']);
        Route::get('/{id}/edit', [RealisasiTatakelolaController::class, 'edit']);
        Route::put('/{id}/update', [RealisasiTatakelolaController::class, 'update']);
        Route::get('/{id}/confirm', [RealisasiTatakelolaController::class, 'confirm']);
        Route::delete('/{id}/delete', [RealisasiTatakelolaController::class, 'delete']);

        // Cascading select
        Route::get('/program/{id_program}/kegiatan',        [RealisasiTatakelolaController::class, 'getKegiatanByProgram']);
        Route::get('/kegiatan/{id_kegiatan}/summary',        [RealisasiTatakelolaController::class, 'getSummaryByKegiatan']);
        Route::get('/ssh/{id_ssh}/summary',        [RealisasiTatakelolaController::class, 'getSummaryBySsh']);
        Route::get('/kegiatan/{id_kegiatan}/sub_kegiatan',  [RealisasiTatakelolaController::class, 'getSubKegiatanByKegiatan']);
        Route::get('/sub_kegiatan/{id_sub_kegiatan}/rekening', [RealisasiTatakelolaController::class, 'getRekeningBySubKegiatan']);
        Route::get('/rekening/{id_rekening}/ssh',           [RealisasiTatakelolaController::class, 'getSshByRekening']);

        Route::get('/ssh/{id}/histori', [RealisasiTatakelolaController::class, 'histori']);
    });
});

});