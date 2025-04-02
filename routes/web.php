<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Auth Controller
use App\Http\Controllers\AuthController;

// Admin Controller
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AdminController as AdminAdminController;

// Penjual Controller
use App\Http\Controllers\Penjual\DashboardController as PenjualDashboardController;
use App\Http\Controllers\Admin\PenjualController as AdminPenjualController;
use App\Http\Controllers\Admin\PelangganController as AdminPelangganController;

// Pelanggan Controller
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('redirectIfAuthenticated')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});


Route::middleware('authCheck')->group(function () {
    // Profile Controller
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Dashboard Controller
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Admin Admin Controller
    Route::get('/admin-dashboard/admin', [AdminAdminController::class, 'index'])->name('admin.admin.index');
    Route::get('/admin-dashboard/admin/create', [AdminAdminController::class, 'create'])->name('admin.admin.create');
    Route::get('/admin-dashboard/admin/edit/{id}', [AdminAdminController::class, 'edit'])->name('admin.admin.edit');
    Route::post('/admin-dashboard/admin/store', [AdminAdminController::class, 'store'])->name('admin.admin.store');
    Route::put('/admin-dashboard/admin/update', [AdminAdminController::class, 'update'])->name('admin.admin.update');
    Route::delete('/admin-dashboard/admin/delete', [AdminAdminController::class, 'destroy'])->name('admin.admin.destroy');

    // Admin Penjual Controller
    Route::get('/admin-dashboard/penjual', [AdminPenjualController::class, 'index'])->name('admin.penjual.index');
    Route::get('/admin-dashboard/penjual/create', [AdminPenjualController::class, 'create'])->name('admin.penjual.create');
    Route::get('/admin-dashboard/penjual/edit/{id}', [AdminPenjualController::class, 'edit'])->name('admin.penjual.edit');
    Route::post('/admin-dashboard/penjual/store', [AdminPenjualController::class, 'store'])->name('admin.penjual.store');
    Route::put('/admin-dashboard/penjual/update', [AdminPenjualController::class, 'update'])->name('admin.penjual.update');
    Route::delete('/admin-dashboard/penjual/delete', [AdminPenjualController::class, 'destroy'])->name('admin.penjual.destroy');

    // Admin Pelanggan Controller
    Route::get('/admin-dashboard/pelanggan', [AdminPelangganController::class, 'index'])->name('admin.pelanggan.index');
    Route::get('/admin-dashboard/pelanggan/create', [AdminPelangganController::class, 'create'])->name('admin.pelanggan.create');
    Route::get('/admin-dashboard/pelanggan/edit/{id}', [AdminPelangganController::class, 'edit'])->name('admin.pelanggan.edit');
    Route::post('/admin-dashboard/pelanggan/store', [AdminPelangganController::class, 'store'])->name('admin.pelanggan.store');
    Route::put('/admin-dashboard/pelanggan/update', [AdminPelangganController::class, 'update'])->name('admin.pelanggan.update');
    Route::delete('/admin-dashboard/pelanggan/delete', [AdminPelangganController::class, 'destroy'])->name('admin.pelanggan.destroy');

    // Penjual Dashboard Controller
    Route::get('/penjual-dashboard', [PenjualDashboardController::class, 'index'])->name('penjual.dashboard');

    // Pelanggan Dashboard Controller
    Route::get('/pelanggan-dashboard', [PelangganDashboardController::class, 'index'])->name('pelanggan.dashboard');
});

// require __DIR__.'/auth.php';
