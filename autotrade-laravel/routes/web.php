<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CompareController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [SearchController::class, 'index'])->name('home');

Route::get('/db-test', function () {
    try {
        $count = DB::table('listings')->count();
        return "DB OK — listings count: {$count}";
    } catch (\Throwable $e) {
        return "DB ERROR — " . $e->getMessage();
    }
});

Route::get('/search-json', [SearchController::class, 'json'])->name('search.json');

Route::get('/compare', [CompareController::class, 'index'])->name('compare');
Route::post('/compare/add', [CompareController::class, 'add'])->name('compare.add');
Route::post('/compare/remove', [CompareController::class, 'remove'])->name('compare.remove');
Route::post('/compare/clear', [CompareController::class, 'clear'])->name('compare.clear'); // optional
Route::get('/compare-summary-json', [CompareController::class, 'summary'])->name('compare.summary');
