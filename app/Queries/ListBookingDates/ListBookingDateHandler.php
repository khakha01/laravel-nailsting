<?php

namespace App\Queries\ListBookingDates;

use App\Models\BookingDate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListBookingDateHandler
{
    public function execute(ListBookingDateQuery $query): LengthAwarePaginator
    {
        $builder = BookingDate::query();

        if ($query->date) {
            $builder->whereDate('date', $query->date);
        }

        if ($query->isOpen !== null) {
            $builder->where('is_open', $query->isOpen);
        }
        $builder->orderBy('date');

        return $builder->paginate($query->perPage, ['*'], 'page', $query->page);
    }
}
