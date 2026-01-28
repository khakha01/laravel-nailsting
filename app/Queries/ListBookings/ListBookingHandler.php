<?php

namespace App\Queries\ListBookings;

use App\Models\Booking;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListBookingHandler
{
    public function execute(ListBookingQuery $query): LengthAwarePaginator
    {
        $builder = Booking::with('products');

        if ($query->customer) {
            $builder->where(function ($q) use ($query) {
                $q->where('customer_name', 'like', "%{$query->customer}%")
                    ->orWhere('customer_phone', 'like', "%{$query->customer}%");
            });
        }

        if ($query->startDate) {
            $builder->whereDate('booking_date', '>=', $query->startDate);
        }

        if ($query->endDate) {
            $builder->whereDate('booking_date', '<=', $query->endDate);
        }

        if ($query->status) {
            $builder->where('status', $query->status);
        }

        if ($query->isPaid !== null) {
            $builder->where('is_paid', $query->isPaid);
        }

        if ($query->today) {
            $builder->whereDate('booking_date', now()->toDateString());
        }

        return $builder->orderBy('booking_date', 'desc')
            ->orderBy('booking_time', 'desc')
            ->paginate($query->perPage, ['*'], 'page', $query->page)
            ->withQueryString();
    }
}
