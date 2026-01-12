<?php

namespace App\Repositories\BookingDate;

use App\Models\BookingDate;
use Illuminate\Support\Collection;

class BookingDateRepository implements BookingDateRepositoryInterface
{
    public function findByDate(string $date): ?BookingDate
    {
        return BookingDate::whereDate('date', $date)->first();
    }

    public function save(array $data): BookingDate
    {
        return BookingDate::create($data);
    }

    public function getOpenDates(): Collection
    {
        return BookingDate::where('is_open', true)
            ->orderBy('date')
            ->get();
    }
}
