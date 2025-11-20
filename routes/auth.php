<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('auth', [AuthController::class, 'showEmailForm'])->name('auth.email.form');
    Route::post('auth', [AuthController::class, 'sendCode'])->name('auth.send.code');

    Route::get('auth/code', [AuthController::class, 'showCodeForm'])->name('auth.code.form');
    Route::post('auth/code', [AuthController::class, 'login'])->name('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

