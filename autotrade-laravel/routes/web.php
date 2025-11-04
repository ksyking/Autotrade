<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Keep public routes minimal, then put authenticated-only stuff inside
| the auth middleware group. Breeze’s auth routes get pulled in at bottom.
*/

// ---------- Public ----------
Route::get('/', [SearchController::class, 'index'])->name('home');
Route::get('/search-json', [SearchController::class, 'json'])->name('search.json');

// ---------- Compare (session-based, no auth required) ----------
Route::get('/compare', [CompareController::class, 'show'])->name('compare');
Route::get('/compare/summary', [CompareController::class, 'summary'])->name('compare.summary');
Route::post('/compare/add', [CompareController::class, 'add'])->name('compare.add');
Route::post('/compare/remove', [CompareController::class, 'remove'])->name('compare.remove');
Route::post('/compare/clear', [CompareController::class, 'clear'])->name('compare.clear');

// ---------- Authenticated-only ----------
Route::middleware('auth')->group(function () {
    // Buyer dashboard
    Route::get('/buyer', [BuyerController::class, 'dashboard'])->name('buyer.dashboard');

    // Profile (Breeze-convention: profile.edit / update / destroy)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // (Optional) Demo seeder button on buyer page — keep if you actually use it
    // Route::post('/buyer/demo-seed', [BuyerController::class, 'demoSeed'])->name('buyer.demo.seed');
});

// Breeze auth routes (login, register, password, email verify, etc.)
require __DIR__.'/auth.php';
