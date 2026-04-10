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
    
    // Pelanggaran API
    Route::apiResource('pelanggaran', PelanggaranController::class)->middleware('throttle:5,1')->parameters(['pelanggaran' => 'pelanggaran'])->names([
        'index' => 'api.pelanggaran.index',
        'store' => 'api.pelanggaran.store',
        'show' => 'api.pelanggaran.show',
        'update' => 'api.pelanggaran.update',
        'destroy' => 'api.pelanggaran.destroy',
    ]);
    
    Route::middleware([EnsureRole::class . ':admin'])->group(function () {
        Route::apiResource('karyawan', KaryawanController::class)
            ->parameters(['karyawan' => 'karyawan'])
            ->names([
                'index' => 'api.karyawan.index',
                'store' => 'api.karyawan.store',
                'show' => 'api.karyawan.show',
                'update' => 'api.karyawan.update',
                'destroy' => 'api.karyawan.destroy',
            ]);
        
        Route::apiResource('departemen', DepartemenController::class)
            ->parameters(['departemen' => 'departemen'])
            ->names([
                'index' => 'api.departemen.index',
                'store' => 'api.departemen.store',
                'show' => 'api.departemen.show',
                'update' => 'api.departemen.update',
                'destroy' => 'api.departemen.destroy',
            ]);
        
        Route::apiResource('jenis-pelanggaran', JenisPelanggaranController::class)
            ->parameters(['jenis-pelanggaran' => 'jenis_pelanggaran'])
            ->names([
                'index' => 'api.jenis-pelanggaran.index',
                'store' => 'api.jenis-pelanggaran.store',
                'show' => 'api.jenis-pelanggaran.show',
                'update' => 'api.jenis-pelanggaran.update',
                'destroy' => 'api.jenis-pelanggaran.destroy',
            ]);
        
        // Sanksi routes - PDF export MUST come before apiResource
        Route::get('sanksi/export/pdf', [SanksiController::class, 'exportPdf'])->name('api.sanksi.export-pdf');
        Route::apiResource('sanksi', SanksiController::class)
            ->parameters(['sanksi' => 'sanksi'])
            ->names([
                'index' => 'api.sanksi.index',
                'store' => 'api.sanksi.store',
                'show' => 'api.sanksi.show',
                'update' => 'api.sanksi.update',
                'destroy' => 'api.sanksi.destroy',
            ]);
    });
});
