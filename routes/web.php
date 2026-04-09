<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

    // ===== ADMIN ONLY ROUTES =====
    Route::middleware('role:admin')->group(function () {
        // Karyawan Management (except show, index yang bisa dilihat semua user)
        Route::post('karyawan', [KaryawanController::class, 'store'])->name('karyawan.store.admin');
        Route::get('karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
        Route::get('karyawan/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
        Route::put('karyawan/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update.admin');
        Route::delete('karyawan/{karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy.admin');

        // Departemen Management
        Route::resource('departemen', DepartemenController::class)
            ->except(['index'])
            ->parameters(['departemen' => 'departemen'])
            ->names([
                'store' => 'departemen.store.admin',
                'show' => 'departemen.show.admin',
                'update' => 'departemen.update.admin',
                'destroy' => 'departemen.destroy.admin'
            ]);

        // Jenis Pelanggaran Management
        Route::resource('jenis-pelanggaran', JenisPelanggaranController::class)
            ->except(['index'])
            ->parameters(['jenis-pelanggaran' => 'jenis_pelanggaran'])
            ->names([
                'store' => 'jenis-pelanggaran.store.admin',
                'show' => 'jenis-pelanggaran.show.admin',
                'update' => 'jenis-pelanggaran.update.admin',
                'destroy' => 'jenis-pelanggaran.destroy.admin'
            ]);

        // Sanksi CRUD untuk admin
        Route::get('sanksi/create', [SanksiController::class, 'create'])->name('sanksi.create');
        Route::post('sanksi', [SanksiController::class, 'store'])->name('sanksi.store.admin');
        Route::get('sanksi/{sanksi}/edit', [SanksiController::class, 'edit'])->name('sanksi.edit');
        Route::put('sanksi/{sanksi}', [SanksiController::class, 'update'])->name('sanksi.update.admin');
        Route::delete('sanksi/{sanksi}', [SanksiController::class, 'destroy'])->name('sanksi.destroy.admin');
    });

    // All authenticated users can view
    Route::get('karyawan', [KaryawanController::class, 'index'])->name('karyawan.index.web');
    Route::get('karyawan/{karyawan}', [KaryawanController::class, 'show'])->name('karyawan.show');
    Route::get('departemen', [DepartemenController::class, 'index'])->name('departemen.index');
    Route::get('jenis-pelanggaran', [JenisPelanggaranController::class, 'index'])->name('jenis-pelanggaran.index');

    // ===== ALL AUTHENTICATED USERS =====
    // Pelanggaran Management
    Route::resource('pelanggaran', PelanggaranController::class)->names([
        'index' => 'pelanggaran.index.web',
        'create' => 'pelanggaran.create',
        'store' => 'pelanggaran.store.web',
        'show' => 'pelanggaran.show.web',
        'edit' => 'pelanggaran.edit',
        'update' => 'pelanggaran.update.web',
        'destroy' => 'pelanggaran.destroy.web'
    ]);

    // Sanksi View Only
    Route::get('sanksi', [SanksiController::class, 'index'])->name('sanksi.index');
    Route::get('sanksi/{sanksi}', [SanksiController::class, 'show'])->name('sanksi.show');
    Route::get('sanksi/{sanksi}/download', [SanksiController::class, 'downloadPdf'])->name('sanksi.download');
});
