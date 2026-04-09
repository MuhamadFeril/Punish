<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PelanggaranController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\JenisPelanggaranController;
use App\Http\Controllers\Api\SanksiController;
use App\Http\Controllers\Api\DepartemenController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\EnsureRole;

// Auth routes (public)
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected routes (require auth)
Route::middleware('auth:sanctum')->group(function () {

   
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('pelanggaran', PelanggaranController::class)->middleware('throttle:5,1')->names([
        'index' => 'pelanggaran.index',
        'store' => 'pelanggaran.store',
        'show' => 'pelanggaran.show',
        'update' => 'pelanggaran.update',
        'destroy' => 'pelanggaran.destroy'
    ]); // Batasi 60 permintaan per menit untuk endpoint ini
    Route::get('jenis-pelanggaran', [JenisPelanggaranController::class, 'index'])->name('jenis-pelanggaran.index.api');
    Route::get('sanksi', [SanksiController::class, 'exportpdf'])->name('sanksi.exportpdf');
    Route::get('karyawan', [KaryawanController::class, 'index'])->name('karyawan.index.api');
    Route::put('karyawan/{id}', [KaryawanController::class, 'update'])->middleware('throttle:5,1')->name('karyawan.update.api'); // Batasi 60 permintaan per menit untuk endpoint ini

    Route::middleware([EnsureRole::class . ':admin'])->group(function () {
        Route::apiResource('karyawan', KaryawanController::class)->except(['index', 'update'])->names([
            'store' => 'karyawan.store.api',
            'show' => 'karyawan.show.api',
            'destroy' => 'karyawan.destroy.api'
        ]);
        Route::apiResource('departemen', DepartemenController::class)->names([
            'index' => 'departemen.index.api',
            'store' => 'departemen.store.api',
            'show' => 'departemen.show.api',
            'update' => 'departemen.update.api',
            'destroy' => 'departemen.destroy.api'
        ]);
        Route::apiResource('jenis-pelanggaran', JenisPelanggaranController::class)->except(['index'])->names([
            'store' => 'jenis-pelanggaran.store.api',
            'show' => 'jenis-pelanggaran.show.api',
            'update' => 'jenis-pelanggaran.update.api',
            'destroy' => 'jenis-pelanggaran.destroy.api'
        ]);
        Route::apiResource('sanksi', SanksiController::class)->names([
            'index' => 'sanksi.index.api',
            'store' => 'sanksi.store.api',
            'show' => 'sanksi.show.api',
            'update' => 'sanksi.update.api',
            'destroy' => 'sanksi.destroy.api'
        ]);
    });
});
