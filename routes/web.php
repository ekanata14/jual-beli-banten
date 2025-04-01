<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Auth Controller
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AdminController as AdminAdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('authCheck')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Dashboard Controller
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Admin Admin Controller
    Route::get('/admin-dashboard/admin', [AdminAdminController::class, 'index'])->name('admin.admin.index');
});

// require __DIR__.'/auth.php';
