<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetUnitController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    // Route for Admin
    Route::middleware('is_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::resource('categories', CategoryController::class)->except('show');
        Route::resource('assets', AssetController::class);
        Route::resource('assets.units', AssetUnitController::class);
    });

    // Route for User
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });
});
