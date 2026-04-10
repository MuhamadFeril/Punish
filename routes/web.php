<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\JenisPelanggaranController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\SanksiController;

// Home
Route::get('/', function () {
    return view('welcome');
});

// ===== AUTH ROUTES (Public - Guest Only) =====
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// ===== PROTECTED ROUTES (Require Login) =====
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Profile
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // ===== ALL AUTHENTICATED CAN VIEW (index, show) =====
    Route::get('karyawan', [KaryawanController::class, 'index'])->name('karyawan.index.web');
    Route::get('karyawan/{karyawan}', [KaryawanController::class, 'show'])->name('karyawan.show.web');
    
    Route::get('departemen', [DepartemenController::class, 'index'])->name('departemen.index.web');
    Route::get('departemen/{departemen}', [DepartemenController::class, 'show'])->name('departemen.show.web');
    
    Route::get('jenis-pelanggaran', [JenisPelanggaranController::class, 'index'])->name('jenis-pelanggaran.index.web');
    Route::get('jenis-pelanggaran/{jenis_pelanggaran}', [JenisPelanggaranController::class, 'show'])->name('jenis-pelanggaran.show.web');
    
    Route::get('sanksi', [SanksiController::class, 'index'])->name('sanksi.index.web');
    Route::get('sanksi/{sanksi}', [SanksiController::class, 'show'])->name('sanksi.show.web');
    Route::get('sanksi/{sanksi}/download', [SanksiController::class, 'downloadPdf'])->name('sanksi.download');

    // ===== PELANGGARAN - ALL AUTHENTICATED CAN CRUD =====
    Route::resource('pelanggaran', PelanggaranController::class)->names([
        'index' => 'pelanggaran.index.web',
        'create' => 'pelanggaran.create.web',
        'store' => 'pelanggaran.store.web',
        'show' => 'pelanggaran.show.web',
        'edit' => 'pelanggaran.edit.web',
        'update' => 'pelanggaran.update.web',
        'destroy' => 'pelanggaran.destroy.web'
    ]);

    // ===== ADMIN ONLY ROUTES =====
    Route::middleware('role:admin')->group(function () {
        // Karyawan Management
        Route::post('karyawan', [KaryawanController::class, 'store'])->name('karyawan.store.admin');
        Route::get('karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create.web');
        Route::get('karyawan/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit.web');
        Route::put('karyawan/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update.admin');
        Route::delete('karyawan/{karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy.admin');

        // Departemen Management
        Route::post('departemen', [DepartemenController::class, 'store'])->name('departemen.store.web');
        Route::get('departemen/create', [DepartemenController::class, 'create'])->name('departemen.create.web');
        Route::get('departemen/{departemen}/edit', [DepartemenController::class, 'edit'])->name('departemen.edit.web');
        Route::put('departemen/{departemen}', [DepartemenController::class, 'update'])->name('departemen.update.web');
        Route::delete('departemen/{departemen}', [DepartemenController::class, 'destroy'])->name('departemen.destroy.web');

        // Jenis Pelanggaran Management
        Route::post('jenis-pelanggaran', [JenisPelanggaranController::class, 'store'])->name('jenis-pelanggaran.store.web');
        Route::get('jenis-pelanggaran/create', [JenisPelanggaranController::class, 'create'])->name('jenis-pelanggaran.create.web');
        Route::get('jenis-pelanggaran/{jenis_pelanggaran}/edit', [JenisPelanggaranController::class, 'edit'])->name('jenis-pelanggaran.edit.web'); 
        Route::put('jenis-pelanggaran/{jenis_pelanggaran}', [JenisPelanggaranController::class, 'update'])->name('jenis-pelanggaran.update.web');
        Route::delete('jenis-pelanggaran/{jenis_pelanggaran}', [JenisPelanggaranController::class, 'destroy'])->name('jenis-pelanggaran.destroy.web');

        // Sanksi Management
        Route::post('sanksi', [SanksiController::class, 'store'])->name('sanksi.store.web');
        Route::get('sanksi/create', [SanksiController::class, 'create'])->name('sanksi.create.web');
        Route::get('sanksi/{sanksi}/edit', [SanksiController::class, 'edit'])->name('sanksi.edit.web');
        Route::put('sanksi/{sanksi}', [SanksiController::class, 'update'])->name('sanksi.update.web');
        Route::delete('sanksi/{sanksi}', [SanksiController::class, 'destroy'])->name('sanksi.destroy.web');
    });
});
