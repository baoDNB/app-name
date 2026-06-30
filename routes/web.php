<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SharedAccountController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/accounts');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::get('/accounts/{account}/otp', [SharedAccountController::class, 'otp'])->name('accounts.otp');
    Route::resource('accounts', SharedAccountController::class)->except(['show']);
});
