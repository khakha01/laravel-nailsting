<?php

namespace App\Repositories\BookingDate;

use App\Models\BookingDate;
use Illuminate\Support\Collection;

interface BookingDateRepositoryInterface
{
    public function findByDate(string $date): ?BookingDate;

    public function save(array $data): BookingDate;

    public function getOpenDates(): Collection;
}
