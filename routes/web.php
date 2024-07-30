<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('divisi')->group(function () {
        Route::get('/', [\App\Http\Controllers\DivisiController::class, 'index'])->name('divisi.index');
        Route::post('/store', [\App\Http\Controllers\DivisiController::class, 'store'])->name('divisi.store');
        Route::put('/{divisi}', [\App\Http\Controllers\DivisiController::class, 'update'])->name('divisi.update');
        Route::delete('/{divisi}', [\App\Http\Controllers\DivisiController::class, 'destroy'])->name('divisi.destroy');
    });

    Route::prefix('karyawan')->group(function () {
        Route::get('/index', [\App\Http\Controllers\KaryawanController::class, 'index'])->name('karyawan.index');
        Route::post('/store', [\App\Http\Controllers\KaryawanController::class, 'store'])->name('karyawan.store');
        Route::put('/{karyawan}', [\App\Http\Controllers\KaryawanController::class, 'update'])->name('karyawan.update');
        Route::delete('/foto/{karyawan}', [\App\Http\Controllers\KaryawanController::class, 'deleteImage'])->name('karyawan.foto.destroy');
        Route::delete('/{karyawan}', [\App\Http\Controllers\KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    });

    Route::prefix('pekerjaan')->group(function () {
        Route::get('/', [\App\Http\Controllers\PekerjaanController::class, 'index'])->name('pekerjaan.index');
        Route::post('/store', [\App\Http\Controllers\PekerjaanController::class, 'store'])->name('pekerjaan.store');
        Route::put('/{pekerjaan}', [\App\Http\Controllers\PekerjaanController::class, 'update'])->name('pekerjaan.update');
        Route::delete('/{pekerjaan}', [\App\Http\Controllers\PekerjaanController::class, 'destroy'])->name('pekerjaan.destroy');
    });
});

require __DIR__.'/auth.php';
