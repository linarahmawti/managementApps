<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KaryawanProgressReportController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (request()->user()->role === 'admin') {
        return redirect('/admin');
    } else {
        return redirect()->route('karyawan.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Karyawan routes
    Route::middleware(['role:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/dashboard', [KaryawanController::class, 'dashboard'])->name('dashboard');
        Route::get('/input-progress', [KaryawanController::class, 'inputProgress'])->name('input-progress');
        Route::post('/progress', [KaryawanController::class, 'storeProgress'])->name('progress.store');
        Route::get('/assignment/{id}', [KaryawanController::class, 'showAssignment'])->name('assignment.show');

        // Progress Reports CRUD
        Route::resource('reports', KaryawanProgressReportController::class)->except(['index', 'show']);
        Route::get('/reports', [KaryawanProgressReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [KaryawanProgressReportController::class, 'show'])->name('reports.show');

        // Delivery History
        Route::get('/history', [KaryawanController::class, 'history'])->name('history');
    });

    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
        Route::get('/history', [AdminController::class, 'history'])->name('history');
    });
});

require __DIR__.'/auth.php';
