<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookingDateController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NailCategoryController;
use App\Http\Controllers\Admin\NailController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\User\AppointmentController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\MediaController;
use Illuminate\Support\Facades\Route;

/**
 * Router User
 */
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\NailBookingController;
use App\Http\Controllers\User\CollectionController;
use App\Http\Controllers\User\PricingController;

/**
 * Router User
 */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment');
Route::get('/collection', [CollectionController::class, 'index'])->name('collection');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::post('/nail-booking', [NailBookingController::class, 'store'])->name('nail-booking.store');


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
Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Admin Management
    Route::group(['prefix' => 'admins', 'as' => 'admins.', 'middleware' => 'permission:admin-view'], function () {
        Route::get('/list', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create')->middleware('permission:admin-create');
        Route::post('/store', [AdminController::class, 'store'])->name('store')->middleware('permission:admin-create');
        Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit')->middleware('permission:admin-edit');
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update')->middleware('permission:admin-edit');
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy')->middleware('permission:admin-delete');
        Route::get('/{admin}/assign-permissions', [AdminController::class, 'assignPermissionsForm'])->name('assign-permissions')->middleware('permission:admin-assign-permission');
        Route::post('/{admin}/assign-permissions', [AdminController::class, 'assignPermissions'])->name('assign-permissions.store')->middleware('permission:admin-assign-permission');
    });

    // Permission Management
    Route::group(['prefix' => 'permissions', 'as' => 'permissions.', 'middleware' => 'permission:permission-view'], function () {
        Route::get('/list', [PermissionController::class, 'index'])->name('index');
        Route::get('/create', [PermissionController::class, 'create'])->name('create')->middleware('permission:permission-create');
        Route::post('/store', [PermissionController::class, 'store'])->name('store')->middleware('permission:permission-create');
        Route::get('/{permission}', [PermissionController::class, 'show'])->name('show');
        Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('edit')->middleware('permission:permission-edit');
        Route::put('/{permission}', [PermissionController::class, 'update'])->name('update')->middleware('permission:permission-edit');
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy')->middleware('permission:permission-delete');
        Route::get('/{permission}/assign-admins', [PermissionController::class, 'assignAdminsForm'])->name('assign-admins');
        Route::post('/{permission}/assign-admins', [PermissionController::class, 'assignAdmins'])->name('assign-admins.store');
    });

    Route::group(['prefix' => 'booking-dates', 'as' => 'booking-dates.', 'middleware' => 'permission:booking-view'], function () {
        Route::get('/list', [BookingDateController::class, 'index'])->name('index');
        Route::get('/create', [BookingDateController::class, 'create'])->name('create')->middleware('permission:booking-edit');
        Route::post('/store', [BookingDateController::class, 'store'])->name('store')->middleware('permission:booking-edit');
        Route::delete('/bulk-delete', [BookingDateController::class, 'bulkDelete'])->name('bulk-delete')->middleware('permission:booking-delete');
        Route::get('/{id}', [BookingDateController::class, 'show'])->whereNumber('id')->name('show');
        Route::put('/update/{id}', [BookingDateController::class, 'update'])->name('update')->middleware('permission:booking-edit');
        Route::delete('/{id}', [BookingDateController::class, 'destroy'])->name('destroy')->middleware('permission:booking-delete');
    });

    Route::group(['prefix' => 'bookings', 'as' => 'bookings.', 'middleware' => 'permission:booking-view'], function () {
        Route::get('/list', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('index');
        Route::get('/trash', [\App\Http\Controllers\Admin\BookingController::class, 'trash'])->name('trash'); // <-- New Route
        Route::post('/{id}/restore', [\App\Http\Controllers\Admin\BookingController::class, 'restore'])->name('restore')->middleware('permission:booking-edit'); // <-- New Route
        Route::delete('/{id}/force', [\App\Http\Controllers\Admin\BookingController::class, 'forceDelete'])->name('force-delete')->middleware('permission:booking-delete'); // <-- New Route
        Route::get('/{id}', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->whereNumber('id')->name('show');
        Route::patch('/update-status/{id}', [\App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('update-status')->middleware('permission:booking-edit');
        Route::delete('/bulk-delete', [\App\Http\Controllers\Admin\BookingController::class, 'bulkDelete'])->name('bulk-delete')->middleware('permission:booking-delete');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\BookingController::class, 'destroy'])->name('destroy')->middleware('permission:booking-delete');
    });

    Route::group(['prefix' => 'nail-bookings', 'as' => 'nail-bookings.', 'middleware' => 'permission:nail-booking-view'], function () {
        Route::get('/list', [\App\Http\Controllers\Admin\NailBookingController::class, 'index'])->name('index');
        Route::get('/trash', [\App\Http\Controllers\Admin\NailBookingController::class, 'trash'])->name('trash');
        Route::post('/{id}/restore', [\App\Http\Controllers\Admin\NailBookingController::class, 'restore'])->name('restore')->middleware('permission:nail-booking-edit');
        Route::delete('/{id}/force', [\App\Http\Controllers\Admin\NailBookingController::class, 'forceDelete'])->name('force-delete')->middleware('permission:nail-booking-delete');
        Route::get('/{id}', [\App\Http\Controllers\Admin\NailBookingController::class, 'show'])->whereNumber('id')->name('show');
        Route::patch('/update-status/{id}', [\App\Http\Controllers\Admin\NailBookingController::class, 'updateStatus'])->name('update-status')->middleware('permission:nail-booking-edit');
        Route::delete('/bulk-delete', [\App\Http\Controllers\Admin\NailBookingController::class, 'bulkDelete'])->name('bulk-delete')->middleware('permission:nail-booking-delete');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\NailBookingController::class, 'destroy'])->name('destroy')->middleware('permission:nail-booking-delete');
    });


    Route::group(['prefix' => 'categories', 'as' => 'categories.', 'middleware' => 'permission:category-view'], function () {
        Route::get('/list', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create')->middleware('permission:category-create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store')->middleware('permission:category-create');
        Route::get('/tree', [CategoryController::class, 'tree'])->name('tree');
        Route::delete('/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('bulk-delete')->middleware('permission:category-delete');
        Route::get('/{id}', [CategoryController::class, 'show'])->whereNumber('id')->name('show');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update')->middleware('permission:category-edit');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy')->middleware('permission:category-delete');
    });

    Route::group(['prefix' => 'products', 'as' => 'products.', 'middleware' => 'permission:product-view'], function () {
        Route::get('/list', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create')->middleware('permission:product-create');
        Route::post('/store', [ProductController::class, 'store'])->name('store')->middleware('permission:product-create');
        Route::delete('/bulk-delete', [ProductController::class, 'bulkDelete'])->name('bulk-delete')->middleware('permission:product-delete');
        Route::get('/by-category/{id}', [ProductController::class, 'byCategory'])->whereNumber('id')->name('by-category');
        Route::get('/{product}', [ProductController::class, 'show'])->whereNumber('product')->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->whereNumber('product')->name('edit')->middleware('permission:product-edit');
        Route::put('/{product}', [ProductController::class, 'update'])->whereNumber('product')->name('update')->middleware('permission:product-edit');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->whereNumber('product')->name('destroy')->middleware('permission:product-delete');
    });

    Route::group(['prefix' => 'nail-categories', 'as' => 'nail-categories.', 'middleware' => 'permission:nail-category-view'], function () {
        Route::get('/list', [NailCategoryController::class, 'index'])->name('index');
        Route::get('/create', [NailCategoryController::class, 'create'])->name('create')->middleware('permission:nail-category-create');
        Route::post('/store', [NailCategoryController::class, 'store'])->name('store')->middleware('permission:nail-category-create');
        Route::delete('/bulk-delete', [NailCategoryController::class, 'bulkDelete'])->name('bulk-delete')->middleware('permission:nail-category-delete');
        Route::get('/{id}', [NailCategoryController::class, 'show'])->whereNumber('id')->name('show');
        Route::put('/update/{id}', [NailCategoryController::class, 'update'])->whereNumber('id')->name('update')->middleware('permission:nail-category-edit');
        Route::delete('/{id}', [NailCategoryController::class, 'destroy'])->whereNumber('id')->name('destroy')->middleware('permission:nail-category-delete');
    });

    Route::group(['prefix' => 'nails', 'as' => 'nails.', 'middleware' => 'permission:nail-view'], function () {
        Route::get('/list', [NailController::class, 'index'])->name('index');
        Route::get('/create', [NailController::class, 'create'])->name('create')->middleware('permission:nail-create');
        Route::post('/store', [NailController::class, 'store'])->name('store')->middleware('permission:nail-create');
        Route::delete('/bulk-delete', [NailController::class, 'bulkDelete'])->name('bulk-delete')->middleware('permission:nail-delete');
        Route::get('/{id}', [NailController::class, 'show'])->whereNumber('id')->name('show');
        Route::put('/update/{id}', [NailController::class, 'update'])->whereNumber('id')->name('update')->middleware('permission:nail-edit');
        Route::delete('/{id}', [NailController::class, 'destroy'])->whereNumber('id')->name('destroy')->middleware('permission:nail-delete');
    });
    // Media Library (MinIO)
    Route::group(['prefix' => 'media', 'as' => 'media.', 'middleware' => 'permission:media-view'], function () {
        Route::get('/', [MediaController::class, 'index'])->name('index');
        Route::post('/', [MediaController::class, 'store'])->name('store')->middleware('permission:media-upload');
        Route::post('/bulk-delete', [MediaController::class, 'bulkDestroy'])->name('bulk-delete')->middleware('permission:media-delete');
        Route::delete('/{id}', [MediaController::class, 'destroy'])->name('destroy')->middleware('permission:media-delete');
        Route::post('/folders', [MediaController::class, 'storeFolder'])->name('folders.store')->middleware('permission:media-upload');
        Route::delete('/folders/{id}', [MediaController::class, 'destroyFolder'])->name('folders.destroy')->middleware('permission:media-delete');
    });

    Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
        Route::get('/list', [\App\Http\Controllers\Admin\BannerController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\BannerController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Admin\BannerController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [\App\Http\Controllers\Admin\BannerController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [\App\Http\Controllers\Admin\BannerController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\BannerController::class, 'destroy'])->name('destroy');
        Route::delete('/bulk-delete', [\App\Http\Controllers\Admin\BannerController::class, 'bulkDelete'])->name('bulk-delete');
    });
});



require __DIR__ . '/auth.php';
