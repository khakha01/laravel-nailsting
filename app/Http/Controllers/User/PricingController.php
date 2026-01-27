<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Category\CategoryService;
use App\Services\BookingDate\BookingDateService;

class PricingController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
        protected BookingDateService $bookingDateService
    ) {
    }

    public function index()
    {
        $categories = $this->categoryService->getBookingServices();

        return view('user.pricing-page.pricing', compact('categories'));
    }
}
