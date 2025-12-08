<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Public routes first; authenticated routes are grouped below.
*/

// ---------- Public ----------
Route::get('/', [SearchController::class, 'index'])->name('home');
Route::get('/search-json', [SearchController::class, 'json'])->name('search.json');

// ---------- Compare (session-based, no auth required) ----------
Route::get('/compare', [CompareController::class, 'index'])->name('compare');
Route::get('/compare/summary', [CompareController::class, 'summary'])->name('compare.summary');

Route::match(['GET', 'POST'], '/compare/add', [CompareController::class, 'add'])->name('compare.add');
Route::match(['GET', 'POST'], '/compare/remove', [CompareController::class, 'remove'])->name('compare.remove');
Route::match(['GET', 'POST'], '/compare/clear', [CompareController::class, 'clear'])->name('compare.clear');

// ---------- Authenticated-only ----------
Route::middleware('auth')->group(function () {
    // Buyer
    Route::get('/buyer', [BuyerController::class, 'dashboard'])->name('buyer.dashboard');

    // Vehicle browser (uses favorites on vehicles table)
    Route::get('/buyer/vehicles', [BuyerController::class, 'browse'])->name('buyer.vehicles');
    Route::post(
        '/buyer/vehicles/{vehicle}/favorite',
        [BuyerController::class, 'toggleFavorite']
    )->name('buyer.favorite');

    // NEW: save listing from the homepage to watchlist (AJAX)
    Route::post(
        '/buyer/listings/{listing}/save',
        [BuyerController::class, 'saveListing']
    )->name('buyer.watchlist.save');

    // Watchlist
    Route::get('/buyer/watchlist', [BuyerController::class, 'watchlist'])->name('buyer.watchlist');
    Route::delete(
        '/buyer/vehicles/{vehicle}/favorite',
        [BuyerController::class, 'unfavorite']
    )->name('buyer.unfavorite');

    // NEW: lightweight JSON endpoint for live watchlist count
    Route::get('/buyer/watchlist/count', [BuyerController::class, 'watchlistCount'])->name('buyer.watchlist.count');

    // Seller dashboard
    Route::get('/seller', [SellerDashboardController::class, 'index'])
        ->name('seller.dashboard');

    // Listings (Create + Store)
    Route::get('/listings/create', [ListingController::class, 'create'])
        ->name('listings.create');

    Route::post('/listings', [ListingController::class, 'store'])
        ->name('listings.store');

    // Breeze-style dashboard view
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile (Breeze conventions)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Debug (temporary)
    Route::get('/debug/favorites', function () {
        $dbName = \Illuminate\Support\Facades\DB::select('select database() as db')[0]->db ?? null;
        return response()->json([
            'db' => $dbName,
            'has_favorites_table' => \Illuminate\Support\Facades\Schema::hasTable('favorites'),
            'favorites_count' => \Illuminate\Support\Facades\DB::table('favorites')->count(),
            'sample_rows' => \Illuminate\Support\Facades\DB::table('favorites')->limit(5)->get(),
            'user_id' => auth()->id(),
        ]);
    });
});

// Breeze auth routes (login, register, password reset, etc.)
require __DIR__ . '/auth.php';

Route::get('/ping', function () {
    return 'pong';
});
