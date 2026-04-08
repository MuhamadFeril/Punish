<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PelanggaranController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\JenisPelanggaranController;
use App\Http\Controllers\Api\SanksiController;
use App\Http\Controllers\Api\DepartemenController;
use App\Http\Controllers\Api\AuthController;

// Auth routes (public)
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected routes (require auth)
Route::middleware('auth:sanctum')->group(function () {

   
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('pelanggaran', PelanggaranController::class)->middleware('throttle:5,1'); // Batasi 60 permintaan per menit untuk endpoint ini
    Route::middleware([\App\Http\Middleware\EnsureRole::class . ':admin'])
        ->get('sanksi/export-pdf', [SanksiController::class, 'exportPdf'])-> middleware('throttle:5,1'); // Batasi 5 permintaan per menit untuk endpoint ini

    Route::apiResource('sanksi', SanksiController::class);

    Route::middleware([\App\Http\Middleware\EnsureRole::class . ':admin'])->group(function () {
        Route::apiResource('karyawan', KaryawanController::class);
        Route::apiResource('departemen', DepartemenController::class);
        Route::apiResource('jenis-pelanggaran', JenisPelanggaranController::class);
    });
});
