<?php

namespace App\Providers;

use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\AdminRepositoryCache;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\BookingDate\BookingDateRepository;
use App\Repositories\BookingDate\BookingDateRepositoryInterface;
use App\Repositories\BookingTimeSlot\BookingTimeSlotRepository;
use App\Repositories\BookingTimeSlot\BookingTimeSlotRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Permission\PermissionRepositoryCache;
use App\Repositories\Permission\PermissionRepositoryInterface;
use App\Repositories\Nail\NailRepository;
use App\Repositories\Nail\NailRepositoryCache;
use App\Repositories\Nail\NailRepositoryInterface;
use App\Repositories\NailCategory\NailCategoryRepository;
use App\Repositories\NailCategory\NailCategoryRepositoryCache;
use App\Repositories\NailCategory\NailCategoryRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryCache;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        # admin
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);

        # permissions
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);

        # bookingDates
        $this->app->bind(BookingDateRepositoryInterface::class, BookingDateRepository::class);

        # bookingTimeSlots
        $this->app->bind(BookingTimeSlotRepositoryInterface::class, BookingTimeSlotRepository::class);

        # categories
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);

        # products
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        # nailCategories
        $this->app->bind(NailCategoryRepositoryInterface::class, NailCategoryRepository::class);

        # nails
        $this->app->bind(NailRepositoryInterface::class, NailRepository::class);
    }


    public function boot(): void
    {
        //
    }
}
