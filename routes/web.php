<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mahasiswa\AuthController;
use App\Http\Controllers\Mahasiswa\DashboardController;
use App\Http\Controllers\Mahasiswa\PendaftaranController;

Route::get('/', function () {
    return redirect()->route('mahasiswa.login');
});

// Mahasiswa Auth Routes
Route::group(['prefix' => 'mahasiswa', 'as' => 'mahasiswa.'], function () {
    // Guest Routes
    Route::middleware('guest:mahasiswa')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
    });

    // Authenticated Routes
    Route::middleware('auth:mahasiswa')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Pendaftaran Routes
        Route::get('/daftar', [PendaftaranController::class, 'showForm'])->name('daftar');
        Route::post('/daftar/payment', [PendaftaranController::class, 'createPayment'])->name('daftar.payment');
        Route::post('/daftar/callback', [PendaftaranController::class, 'handleCallback'])->name('daftar.callback');
        Route::get('/daftar/form-data', [PendaftaranController::class, 'showFormData'])->name('daftar.form-data');
        Route::post('/daftar/form-data', [PendaftaranController::class, 'submitFormData'])->name('daftar.submit-form-data');
    });
});
