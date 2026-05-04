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
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\EmailController;

// Auth routes (public)
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

   Route::resource('karyawan', KaryawanController::class);
        // force parameter name to 'departemen' to avoid incorrect singularization
        Route::resource('departemen', DepartemenController::class)->parameters([
            'departemen' => 'departemen'
        ]);
    Route::resource('jenis-pelanggaran', JenisPelanggaranController::class);
    Route::resource('sanksi', SanksiController::class);
    Route::resource('pelanggaran', PelanggaranController::class);
    Route::resource('kategori', KategoriController::class);
    Route::get('kategori/trashed', [KategoriController::class, 'trashed']);
    Route::post('kategori/{id}/restore', [KategoriController::class, 'restore']);
    Route::delete('kategori/{id}/force', [KategoriController::class, 'forceDelete']);
    Route::post('send-gmail', [EmailController::class, 'sendGmail']);
    // Route::put('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'update']);
    // Route::delete('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'destroy']);
// Protected routes (require auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    
 
});


  
