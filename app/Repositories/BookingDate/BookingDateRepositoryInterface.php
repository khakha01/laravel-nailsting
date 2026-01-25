<?php

namespace App\Repositories\BookingDate;

use App\Models\BookingDate;
use Illuminate\Support\Collection;

interface BookingDateRepositoryInterface
{
    public function findById(int $id): ?BookingDate;

    public function save(BookingDate $bookingDate): BookingDate;

    public function getAll(): Collection;

    public function getAvailable(): Collection;

    public function delete(BookingDate $bookingDate): bool;

    public function findByIds(array $bookingDateIds): Collection;

}
