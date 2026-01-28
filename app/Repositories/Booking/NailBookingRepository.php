<?php

namespace App\Repositories\Booking;

use App\Models\NailBooking;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NailBookingRepository implements NailBookingRepositoryInterface
{
    protected $model;

    public function __construct(NailBooking $model)
    {
        $this->model = $model;
    }

    public function findById(int $id): ?NailBooking
    {
        return $this->model->find($id);
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function countByDate(Carbon $date): int
    {
        return $this->model->whereDate('booking_date', $date)->count();
    }

    public function sumRevenueBetween(Carbon $start, Carbon $end): float
    {
        return (float) $this->model->whereBetween('booking_date', [$start, $end])
            ->where('status', 'completed')
            ->sum('total_amount');
    }

    public function getUniqueCustomerPhones(): Collection
    {
        return DB::table('nail_bookings')->select('customer_phone')->distinct()->get()->pluck('customer_phone');
    }

    public function getRecentBookings(int $limit): Collection
    {
        return $this->model->select(
            'id',
            'customer_name',
            'customer_phone',
            'booking_date',
            'booking_time',
            'status',
            'total_amount as amount',
            DB::raw("'nail' as type"),
            'created_at'
        )
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function countByStatus(string $status): int
    {
        return $this->model->where('status', $status)->count();
    }

    public function countAll(): int
    {
        return $this->model->count();
    }
}
