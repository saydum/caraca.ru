<?php

use App\Http\Controllers\AdComplaintController;
use App\Http\Controllers\AdsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ProfileController;

Route::get('/', [AppController::class, 'index'])->name('app');
Route::get('/ads/{slug}', [AdsController::class, 'show'])->name('ads.show');
Route::get('/privacy',)->name('privacy.policy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/ads', [AdsController::class, 'index'])->name('ads.index');
    Route::get('/ads/create', [AdsController::class, 'create'])->name('ads.create');
    Route::post('/ads', [AdsController::class, 'store'])->name('ads.store');
    Route::get('/ads/{ad}/edit', [AdsController::class, 'edit'])->name('ads.edit');
    Route::put('/ads/{ad}', [AdsController::class, 'update'])->name('ads.update');
    Route::delete('/ads/{ad}', [AdsController::class, 'destroy'])->name('ads.destroy');
    Route::post('/ads/{ad}/archive', [AdsController::class, 'archive'])->name('ads.archive');

    Route::post('/ads/{ad}/complaint', [AdComplaintController::class, 'store'])
        ->name('ads.complaint');
});

Route::middleware('guest.redirect')->group(function () {
    Route::get('/app/ads/create', [AdsController::class, 'create'])->name('app.ads.create');
});

require __DIR__.'/auth.php';
require __DIR__.'/sitepolicy.php';
