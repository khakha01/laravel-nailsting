<?php

namespace App\Providers;

use App\Repositories\BookingDate\BookingDateRepository;
use App\Repositories\BookingDate\BookingDateRepositoryInterface;
use App\Repositories\BookingTimeSlot\BookingTimeSlotRepository;
use App\Repositories\BookingTimeSlot\BookingTimeSlotRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        # bookingDates
        $this->app->bind(BookingDateRepositoryInterface::class, BookingDateRepository::class); // khi có người hỏi BookingDateRepositoryInterface -> thì đưa cho họ BookingDateRepository

        # bookingTimeSlots
        $this->app->bind(BookingTimeSlotRepositoryInterface::class, BookingTimeSlotRepository::class);
    }


    public function boot(): void
    {
        //
    }
}
