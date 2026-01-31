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
                'is_paid' => $data['is_paid'] ?? false,
                'notes' => $data['notes'] ?? null,
                'status' => 'pending',
                'payment_proof' => $data['payment_proof'] ?? null,
            ]);

            if (!empty($data['services'])) {
                $booking->products()->attach($data['services']);
            }

            return $booking->load('products');
        });
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
    /**
     * Find booking by ID
     */
    public function findById(int $id)
    {
        return Booking::with('products')->findOrFail($id);
    }

    /**
     * Delete a booking (Soft Delete)
     */
    public function deleteBooking(int $id)
    {
        $booking = Booking::findOrFail($id);
        return $booking->delete();
    }

    /**
     * Bulk delete bookings
     */
    public function bulkDeleteBookings(array $ids)
    {
        return Booking::whereIn('id', $ids)->delete();
    }

    /**
     * Get trashed bookings
     */
    public function getTrashedBookings()
    {
        return Booking::onlyTrashed()->with('products')->orderBy('deleted_at', 'desc')->paginate(10);
    }

    /**
     * Restore a booking
     */
    public function restoreBooking(int $id)
    {
        $booking = Booking::withTrashed()->findOrFail($id);
        return $booking->restore();
    }

    /**
     * Force delete a booking
     */
    public function forceDeleteBooking(int $id)
    {
        $booking = Booking::withTrashed()->findOrFail($id);
        return $booking->forceDelete();
    }
}
