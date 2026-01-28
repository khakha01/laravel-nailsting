<?php

namespace App\Services\Booking;

use App\Models\NailBooking;
use Illuminate\Support\Facades\DB;

class NailBookingService
{
    /**
     * Create a new nail booking
     */
    public function createBooking(array $data)
    {
        return DB::transaction(function () use ($data) {
            return NailBooking::create([
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => $data['customer_email'] ?? null,
                'nail_id' => $data['nail_id'],
                'nail_price' => $data['nail_price'] ?? 0,
                'booking_date' => $data['booking_date'],
                'booking_time' => $data['booking_time'],
                'deposit_amount' => $data['deposit_amount'] ?? 50000,
                'total_amount' => $data['total_amount'] ?? 0,
                'remaining_amount' => $data['remaining_amount'] ?? 0,
                'payment_proof' => $data['payment_proof'] ?? null,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'notes' => $data['notes'] ?? null,
                'terms_accepted' => $data['terms_accepted'] ?? false,
            ]);
        });
    }



    /**
     * Find booking by ID
     */
    public function findById(int $id)
    {
        return NailBooking::with('nail')->findOrFail($id);
    }

    /**
     * Delete a booking (Soft Delete)
     */
    public function deleteBooking(int $id)
    {
        $booking = NailBooking::findOrFail($id);
        return $booking->delete();
    }

    /**
     * Bulk delete bookings
     */
    public function bulkDeleteBookings(array $ids)
    {
        return NailBooking::whereIn('id', $ids)->delete();
    }

    /**
     * Get trashed bookings
     */
    public function getTrashedBookings()
    {
        return NailBooking::onlyTrashed()->with('nail')->orderBy('deleted_at', 'desc')->paginate(10);
    }

    /**
     * Restore a booking
     */
    public function restoreBooking(int $id)
    {
        $booking = NailBooking::withTrashed()->findOrFail($id);
        return $booking->restore();
    }

    /**
     * Force delete a booking
     */
    public function forceDeleteBooking(int $id)
    {
        $booking = NailBooking::withTrashed()->findOrFail($id);
        return $booking->forceDelete();
    }
}
