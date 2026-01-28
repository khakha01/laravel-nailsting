<?php

namespace App\Queries\ListBookings;

class ListBookingQuery
{
    public function __construct(
        public ?string $customer = null,
        public ?string $startDate = null,
        public ?string $endDate = null,
        public ?string $status = null,
        public ?int $isPaid = null,
        public ?bool $today = false,
        public int $page = 1,
        public int $perPage = 10,
    ) {
    }
}
