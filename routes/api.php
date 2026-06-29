<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PelanggaranController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\JenisPelanggaranController;
use App\Http\Controllers\Api\SanksiController;
use App\Http\Controllers\Api\DepartemenController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CaptchaController;
use App\Http\Middleware\EnsureRole;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\EmailController;

// Auth routes (public)
Route::post('register', [AuthController::class, 'register']);
Route::post('register/send-otp', [AuthController::class, 'sendOtp']);
Route::post('register/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('login', [AuthController::class, 'login']);
Route::post('google', [AuthController::class, 'google']);

// Captcha API routes
Route::get('captcha', [CaptchaController::class, 'generateCaptcha']);
Route::post('captcha/validate', [CaptchaController::class, 'validateCaptcha']);

Route::middleware(['auth:sanctum', 'otp.verified'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('otp/verify', [AuthController::class, 'verifyOtp']);
    Route::post('otp/resend', [AuthController::class, 'resendOtp']);
    
    // ===== ALL AUTHENTICATED CAN VIEW (index, show) =====
    Route::get('departemen', [DepartemenController::class, 'index']);
    Route::get('departemen/{departemen}', [DepartemenController::class, 'show']);
    
    Route::get('jenis-pelanggaran', [JenisPelanggaranController::class, 'index']);
    Route::get('jenis-pelanggaran/{jenis_pelanggaran}', [JenisPelanggaranController::class, 'show']);
    
    Route::get('sanksi', [SanksiController::class, 'index']);
    Route::get('sanksi/{sanksi}', [SanksiController::class, 'show']);
    
    // ===== PELANGGARAN - ALL AUTHENTICATED CAN CRUD =====
    Route::resource('pelanggaran', PelanggaranController::class);
    Route::post('send-gmail', [EmailController::class, 'sendGmail']);
    
    // ===== ADMIN ONLY ROUTES =====
    Route::middleware('role:admin')->group(function () {
        // Karyawan Management (completely restricted from users)
        Route::resource('karyawan', KaryawanController::class);
        
        // Departemen Management (CRUD only)
        Route::post('departemen', [DepartemenController::class, 'store']);
        Route::put('departemen/{departemen}', [DepartemenController::class, 'update']);
        Route::delete('departemen/{departemen}', [DepartemenController::class, 'destroy']);
        
        // Jenis Pelanggaran Management (CRUD only)
        Route::post('jenis-pelanggaran', [JenisPelanggaranController::class, 'store']);
        Route::put('jenis-pelanggaran/{jenis_pelanggaran}', [JenisPelanggaranController::class, 'update']);
        Route::delete('jenis-pelanggaran/{jenis_pelanggaran}', [JenisPelanggaranController::class, 'destroy']);
        
        // Sanksi Management (CRUD only)
        Route::post('sanksi', [SanksiController::class, 'store']);
        Route::put('sanksi/{sanksi}', [SanksiController::class, 'update']);
        Route::delete('sanksi/{sanksi}', [SanksiController::class, 'destroy']);
        
        // Kategori Management
        Route::resource('kategori', KategoriController::class);
        Route::get('kategori/trashed', [KategoriController::class, 'trashed']);
        Route::post('kategori/{id}/restore', [KategoriController::class, 'restore']);
        Route::delete('kategori/{id}/force', [KategoriController::class, 'forceDelete']);
    });
});


  
