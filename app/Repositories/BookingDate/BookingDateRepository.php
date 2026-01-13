<?php

namespace App\Repositories\BookingDate;

use App\Models\BookingDate;
use Illuminate\Support\Collection;

class BookingDateRepository implements BookingDateRepositoryInterface
{
    public function findById(int $id): ?BookingDate
    {
        return BookingDate::with('timeSlots')->find($id);
    }

    public function save(BookingDate $bookingDate): BookingDate
    {
        $bookingDate->save();
        return $bookingDate;
    }

    public function delete(BookingDate $bookingDate): bool
    {
        return $bookingDate->delete();
    }

    public function getAll(): Collection
    {
        return BookingDate::query()->orderBy('date')
            ->get();
    }

    public function findByIds(array $ids): Collection
    {
        return BookingDate::with('timeSlots')
            ->whereIn('id', $ids)
            ->get();
    }
}
