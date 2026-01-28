<?php

namespace App\Queries\ListNailBookings;

class ListNailBookingQuery
{
    public function __construct(
        public ?string $customer = null,
        public ?string $startDate = null,
        public ?string $endDate = null,
        public ?string $status = null,
        public ?string $paymentStatus = null,
        public ?bool $today = false,
        public int $page = 1,
        public int $perPage = 10,
    ) {
    }
}
