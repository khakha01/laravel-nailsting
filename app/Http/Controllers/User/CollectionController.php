<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\BookingDate\BookingDateService;
use App\Services\Nail\NailService;

class CollectionController extends Controller
{
    public function __construct(
        protected BookingDateService $bookingDateService,
        protected NailService $nailService
    ) {
    }

    public function index()
    {
        $availableDates = $this->bookingDateService->getAvailableDates();
        $nails = $this->nailService->getCollectionNails(8);
        return view('user.collection-page.collection', compact('nails', 'availableDates'));
    }
}
