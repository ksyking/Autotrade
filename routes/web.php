<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('auth.page', ['tab' => 'login']);
});

Route::middleware('guest')->group(function () {
    // One page that shows either the login or register tab
    Route::get('/auth', [AuthController::class, 'showAuth'])->name('auth.page');

    // Form submits
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Optional redirects for legacy links
    Route::get('/login', fn() => redirect()->route('auth.page', ['tab' => 'login']))->name('login');
    Route::get('/register', fn() => redirect()->route('auth.page', ['tab' => 'register']))->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/autotrade', fn() => view('autotrade.index'))->name('autotrade.home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
