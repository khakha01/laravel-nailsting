<?php

namespace App\Providers;

use App\Repositories\BookingDate\BookingDateRepository;
use App\Repositories\BookingDate\BookingDateRepositoryInterface;
use App\Repositories\BookingTimeSlot\BookingTimeSlotRepository;
use App\Repositories\BookingTimeSlot\BookingTimeSlotRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryCache;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        # bookingDates
        $this->app->bind(BookingDateRepositoryInterface::class, BookingDateRepository::class);

        # bookingTimeSlots
        $this->app->bind(BookingTimeSlotRepositoryInterface::class, BookingTimeSlotRepository::class);

        # categories
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);

        # products
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }


    public function boot(): void
    {
        //
    }
}

