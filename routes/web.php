<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisBerkasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/jenis-berkas/data', [JenisBerkasController::class, 'data'])->name('jenis-berkas.data');
        Route::resource('/jenis-berkas', JenisBerkasController::class)->except('edit', 'create');
        Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
        Route::resource('/users', UserController::class)->except('edit', 'create');
    });
