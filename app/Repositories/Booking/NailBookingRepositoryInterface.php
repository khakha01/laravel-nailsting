<?php

namespace App\Repositories\Booking;

use App\Models\NailBooking;
use Illuminate\Support\Collection;
use Carbon\Carbon;

interface NailBookingRepositoryInterface
{
    public function findById(int $id): ?NailBooking;
    public function getAll(): Collection;
    public function countByDate(Carbon $date): int;
    public function sumRevenueBetween(Carbon $start, Carbon $end): float;
    public function getUniqueCustomerPhones(): Collection;
    public function getRecentBookings(int $limit): Collection;
    public function countByStatus(string $status): int;
    public function countAll(): int;
}
