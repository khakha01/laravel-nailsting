<?php

namespace App\Queries\ListNailBookings;

use App\Models\NailBooking;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListNailBookingHandler
{
    public function execute(ListNailBookingQuery $query): LengthAwarePaginator
    {
        $builder = NailBooking::with('nail');

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

        if ($query->paymentStatus) {
            $builder->where('payment_status', $query->paymentStatus);
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
