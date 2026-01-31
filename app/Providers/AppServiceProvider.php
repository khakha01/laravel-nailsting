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

        # banners
        $this->app->bind(BannerRepositoryInterface::class, BannerRepository::class);

        # bookings
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);

        $this->app->bind(NailBookingRepositoryInterface::class, NailBookingRepository::class);

        # dashboard
        $this->app->bind(DashboardRepositoryInterface::class, DashboardRepository::class);

        # settings
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);

        # postCategories
        $this->app->bind(PostCategoryRepositoryInterface::class, PostCategoryRepository::class);

        # postTags
        $this->app->bind(PostTagRepositoryInterface::class, PostTagRepository::class);

        # posts
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
    }


    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $view->with('settings', \App\Models\Setting::first());
        });
    }
}
