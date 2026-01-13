<?php

use App\Http\Controllers\Admin\BookingDateController;
use App\Http\Controllers\Admin\DashboardController;
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
        Route::get('/{id}', [BookingDateController::class, 'show'])->name('show');
        Route::put('/update/{id}', [BookingDateController::class, 'update'])->name('update');
        Route::delete('/{id}', [BookingDateController::class, 'destroy'])->name('delete');
    });
});


require __DIR__ . '/auth.php';
