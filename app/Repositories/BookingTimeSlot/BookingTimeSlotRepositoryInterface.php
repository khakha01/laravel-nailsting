<?php
namespace App\Repositories\BookingTimeSlot;

interface BookingTimeSlotRepositoryInterface
{
    public function save(int $bookingDateId, array $slots): void;

    public function deleteByBookingDate(int $bookingDateId): void;

    public function getByBookingDate(int $bookingDateId);
}
