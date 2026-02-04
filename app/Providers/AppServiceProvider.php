<?php

namespace App\Providers;

use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Banner\BannerRepository;
use App\Repositories\Banner\BannerRepositoryInterface;
use App\Repositories\BookingDate\BookingDateRepository;
use App\Repositories\BookingDate\BookingDateRepositoryInterface;
use App\Repositories\BookingTimeSlot\BookingTimeSlotRepository;
use App\Repositories\BookingTimeSlot\BookingTimeSlotRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Permission\PermissionRepositoryInterface;
use App\Repositories\Nail\NailRepository;
use App\Repositories\Nail\NailRepositoryInterface;
use App\Repositories\NailCategory\NailCategoryRepository;
use App\Repositories\NailCategory\NailCategoryRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Booking\BookingRepository;
use App\Repositories\Booking\BookingRepositoryInterface;
use App\Repositories\Booking\NailBookingRepository;
use App\Repositories\Booking\NailBookingRepositoryInterface;
use App\Repositories\Dashboard\DashboardRepository;
use App\Repositories\Dashboard\DashboardRepositoryInterface;
use App\Repositories\Setting\SettingRepository;
use App\Repositories\Setting\SettingRepositoryInterface;
use App\Repositories\Post\PostRepository;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\PostCategory\PostCategoryRepository;
use App\Repositories\PostCategory\PostCategoryRepositoryInterface;
use App\Repositories\PostTag\PostTagRepository;
use App\Repositories\PostTag\PostTagRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        # admin
        $this->app->bind(AdminRepositoryInterface::class, function ($app) {
            return new \App\Repositories\Admin\AdminRepositoryCache(
                $app->make(\App\Repositories\Admin\AdminRepository::class)
            );
        });

        # permissions
        $this->app->bind(PermissionRepositoryInterface::class, function ($app) {
            return new \App\Repositories\Permission\PermissionRepositoryCache(
                $app->make(\App\Repositories\Permission\PermissionRepository::class)
            );
        });

        # bookingDates
        $this->app->bind(BookingDateRepositoryInterface::class, function ($app) {
            return new \App\Repositories\BookingDate\BookingDateRepositoryCache(
                $app->make(\App\Repositories\BookingDate\BookingDateRepository::class)
            );
        });

        # bookingTimeSlots
        $this->app->bind(BookingTimeSlotRepositoryInterface::class, function ($app) {
            return new \App\Repositories\BookingTimeSlot\BookingTimeSlotRepositoryCache(
                $app->make(\App\Repositories\BookingTimeSlot\BookingTimeSlotRepository::class)
            );
        });

        # categories
        $this->app->bind(CategoryRepositoryInterface::class, function ($app) {
            return new \App\Repositories\Category\CategoryRepositoryCache(
                $app->make(\App\Repositories\Category\CategoryRepository::class)
            );
        });

        # products
        $this->app->bind(ProductRepositoryInterface::class, function ($app) {
            return new \App\Repositories\Product\ProductRepositoryCache(
                $app->make(\App\Repositories\Product\ProductRepository::class)
            );
        });

        # nailCategories
        $this->app->bind(NailCategoryRepositoryInterface::class, function ($app) {
            return new \App\Repositories\NailCategory\NailCategoryRepositoryCache(
                $app->make(\App\Repositories\NailCategory\NailCategoryRepository::class)
            );
        });

        # nails
        $this->app->bind(NailRepositoryInterface::class, function ($app) {
            return new \App\Repositories\Nail\NailRepositoryCache(
                $app->make(\App\Repositories\Nail\NailRepository::class)
            );
        });

        # banners
        $this->app->bind(BannerRepositoryInterface::class, function ($app) {
            return new \App\Repositories\Banner\BannerRepositoryCache(
                $app->make(\App\Repositories\Banner\BannerRepository::class)
            );
        });

        # bookings
        $this->app->bind(BookingRepositoryInterface::class, function ($app) {
            return new \App\Repositories\Booking\BookingRepositoryCache(
                $app->make(\App\Repositories\Booking\BookingRepository::class)
            );
        });

        $this->app->bind(NailBookingRepositoryInterface::class, function ($app) {
            return new \App\Repositories\Booking\NailBookingRepositoryCache(
                $app->make(\App\Repositories\Booking\NailBookingRepository::class)
            );
        });

        # dashboard
        $this->app->bind(DashboardRepositoryInterface::class, function ($app) {
            return new \App\Repositories\Dashboard\DashboardRepositoryCache(
                $app->make(\App\Repositories\Dashboard\DashboardRepository::class)
            );
        });

        # settings
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);

        # postCategories
        $this->app->bind(PostCategoryRepositoryInterface::class, function ($app) {
            return new \App\Repositories\PostCategory\PostCategoryRepositoryCache(
                $app->make(\App\Repositories\PostCategory\PostCategoryRepository::class)
            );
        });

        # postTags
        $this->app->bind(PostTagRepositoryInterface::class, function ($app) {
            return new \App\Repositories\PostTag\PostTagRepositoryCache(
                $app->make(\App\Repositories\PostTag\PostTagRepository::class)
            );
        });

        # posts
        $this->app->bind(PostRepositoryInterface::class, function ($app) {
            return new \App\Repositories\Post\PostRepositoryCache(
                $app->make(\App\Repositories\Post\PostRepository::class)
            );
        });
    }


    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $view->with('settings', \App\Models\Setting::first());
            $view->with('headerPostCategories', \App\Models\PostCategory::active()->ordered()->get());
        });
    }
}
