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
    Route::apiResource('pelanggaran', PelanggaranController::class)->middleware('throttle:5,1'); // Batasi 60 permintaan per menit untuk endpoint ini

    // Karyawan dapat dilihat oleh semua user yang sudah login
    Route::get('karyawan', [KaryawanController::class, 'index']);
    Route::get('karyawan/{id}', [KaryawanController::class, 'show']);

    // Jenis pelanggaran dan sanksi yang bisa diakses semua user
    Route::get('jenis-pelanggaran', [JenisPelanggaranController::class, 'index']);
    Route::get('sanksi', [SanksiController::class, 'index']);
    Route::get('sanksi/{sanksi}', [SanksiController::class, 'show']);
    Route::get('sanksi/export-pdf', [SanksiController::class, 'exportPdf']);

    Route::middleware([EnsureRole::class . ':admin'])->group(function () {
        Route::post('karyawan', [KaryawanController::class, 'store'])->middleware('throttle:5,1');
        Route::put('karyawan/{id}', [KaryawanController::class, 'update'])->middleware('throttle:5,1');
        Route::delete('karyawan/{id}', [KaryawanController::class, 'destroy']);

        Route::apiResource('departemen', DepartemenController::class);
        Route::apiResource('jenis-pelanggaran', JenisPelanggaranController::class)->except(['index']);
        Route::apiResource('sanksi', SanksiController::class)->except(['index', 'show']);
    });
});
