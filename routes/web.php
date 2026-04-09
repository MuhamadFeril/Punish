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
        Route::post('karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
        Route::get('karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
        Route::get('karyawan/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
        Route::put('karyawan/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');
        Route::delete('karyawan/{karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

        // Departemen Management
        Route::resource('departemen', DepartemenController::class)->except(['index']);

        // Jenis Pelanggaran Management
        Route::resource('jenis-pelanggaran', JenisPelanggaranController::class)->except(['index']);
    });

    // All authenticated users can view
    Route::get('karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('karyawan/{karyawan}', [KaryawanController::class, 'show'])->name('karyawan.show');
    Route::get('departemen', [DepartemenController::class, 'index'])->name('departemen.index');
    Route::get('jenis-pelanggaran', [JenisPelanggaranController::class, 'index'])->name('jenis-pelanggaran.index');

    // ===== ALL AUTHENTICATED USERS =====
    // Pelanggaran Management
    Route::resource('pelanggaran', PelanggaranController::class);

    // Sanksi View Only
    Route::resource('sanksi', SanksiController::class)->only(['index', 'show']);
});
