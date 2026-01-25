<?php

namespace App\Services\Booking;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class BookingService
{
    /**
     * Create a new booking
     */
    public function createBooking(array $data)
    {
        return DB::transaction(function () use ($data) {
            $booking = Booking::create([
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'booking_date' => $data['booking_date'],
                'booking_time' => $data['booking_time'],
                'total_price' => $data['total_price'] ?? 0,
                'paid_amount' => $data['paid_amount'] ?? 0,
                'paid_at' => $data['paid_at'] ?? null,
                'notes' => $data['notes'] ?? null,
                'status' => 'pending',
            ]);

            if (!empty($data['services'])) {
                $booking->products()->attach($data['services']);
            }

            return $booking;
        });
    }

    /**
     * Get all bookings for admin
     */
    public function getAllBookings()
    {
        return Booking::with('products')->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * Update booking status
     */
    public function updateStatus(int $id, string $status)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $status]);
        return $booking;
    }

    /**
     * Find booking by ID
     */
    public function findById(int $id)
    {
        return Booking::with('products')->findOrFail($id);
    }
}
