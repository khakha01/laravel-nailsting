<?php

use App\Http\Controllers\Admin\BookingDateController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

/**
 * Router User
 */
Route::get('/', function () {
    return view('home');
})->name('/');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * Router Admin
 */
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::group(['prefix' => 'booking-dates', 'as' => 'booking-dates.'], function () {
        Route::get('/list', [BookingDateController::class, 'index'])->name('index');
        Route::get('/create', [BookingDateController::class, 'create'])->name('create');
        Route::post('/store', [BookingDateController::class, 'store'])->name('store');
        Route::delete('/bulk-delete', [BookingDateController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('/{id}', [BookingDateController::class, 'show'])->whereNumber('id')->name('show');
        Route::put('/update/{id}', [BookingDateController::class, 'update'])->name('update');
        Route::delete('/{id}', [BookingDateController::class, 'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
        Route::get('/list', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/tree', [CategoryController::class, 'tree'])->name('tree');
        Route::delete('/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('/{id}', [CategoryController::class, 'show'])->whereNumber('id')->name('show');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::get('/list', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::delete('/bulk-delete', [ProductController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('/by-category/{id}', [ProductController::class, 'byCategory'])->whereNumber('id')->name('by-category');
        Route::get('/{product}', [ProductController::class, 'show'])->whereNumber('product')->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->whereNumber('product')->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->whereNumber('product')->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->whereNumber('product')->name('destroy');
    });
});


require __DIR__ . '/auth.php';
