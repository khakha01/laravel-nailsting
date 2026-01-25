<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\BookingDate\BookingDateService;
use App\Services\Category\CategoryService;

class AppointmentController extends Controller
{
    public function __construct(
        protected BookingDateService $bookingDateService,
        protected CategoryService $categoryService,
    ) {
    }

    public function index()
    {
        $availableDates = $this->bookingDateService->getAvailableDates();
        $bookingServices = $this->categoryService->getBookingServices();

        return view('user.appointment-page.appointment', compact('availableDates', 'bookingServices'));
    }
}
