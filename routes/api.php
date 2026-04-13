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

// Auth routes (public)
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

   Route::resource('karyawan', KaryawanController::class);
    Route::resource('departemen', DepartemenController::class);
    Route::resource('jenis-pelanggaran', JenisPelanggaranController::class);
    Route::resource('sanksi', SanksiController::class);
    Route::resource('pelanggaran', PelanggaranController::class);
    Route::resource('kategori', KategoriController::class);
    // Route::put('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'update']);
    // Route::delete('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'destroy']);
// Protected routes (require auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    
 
});


  
