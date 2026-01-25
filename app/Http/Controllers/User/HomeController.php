<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\BookingDate\BookingDateService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        protected BookingDateService $bookingDateService,
        protected \App\Services\Category\CategoryService $categoryService
    ) {}

    public function index()
    {
        $availableDates = $this->bookingDateService->getAvailableDates();
        $bookingServices = $this->categoryService->getBookingServices();
        return view('home', compact('availableDates', 'bookingServices'));
    }
}
