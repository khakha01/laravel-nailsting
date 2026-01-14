<?php

namespace App\Services\BookingDate;

use App\Models\BookingDate;
use App\Models\BookingTimeSlot;
use App\Repositories\BookingDate\BookingDateRepositoryInterface;
use App\Repositories\BookingTimeSlot\BookingTimeSlotRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookingDateService
{
    public function __construct(
        protected BookingDateRepositoryInterface $bookingDateRepository,
        protected BookingTimeSlotRepositoryInterface $bookingTimeSlotRepository
    ) {}

    public function getAll()
    {
        return $this->bookingDateRepository->getAll();
    }

    public function createService(string $date, bool $isOpen, array $timeSlots): BookingDate
    {
        $dateExists = BookingDate::where('date', $date)->first();
        if ($dateExists) {
            throw new Exception('Lịch làm việc này đã tồn tại!');
        }

        $bookingDate = BookingDate::make($date, $isOpen, $timeSlots);
        return DB::transaction(function () use ($bookingDate, $timeSlots) {

            $bookingDate = $this->bookingDateRepository->save($bookingDate);

            foreach ($timeSlots as $slotData) {
                $slot = BookingTimeSlot::make($slotData['start'], $slotData['end'], $slotData['is_open'] ?? true);
                $slot->booking_date_id = $bookingDate->id;
                $this->bookingTimeSlotRepository->save($slot);
            }

            return $bookingDate;
        });
    }

    public function updateService(int $id, string $date, bool $isOpen, array $timeSlots): BookingDate
    {
        $bookingDate = $this->bookingDateRepository->findById($id);
        if (!$bookingDate) {
            throw new InvalidArgumentException("Booking date not found");
        }

        $bookingDate->date = $date;
        $bookingDate->is_open = $isOpen;

        return DB::transaction(function () use ($bookingDate, $id, $timeSlots) {
            // Save the updated booking date
            $bookingDate = $this->bookingDateRepository->save($bookingDate);

            // Delete old time slots
            $oldSlots = $this->bookingTimeSlotRepository->getByBookingDate($id);
            foreach ($oldSlots as $slot) {
                $this->bookingTimeSlotRepository->delete($slot);
            }

            // Save new time slots
            foreach ($timeSlots as $slotData) {
                $slot = BookingTimeSlot::make($slotData['start'], $slotData['end'], $slotData['is_open'] ?? true);
                $slot->booking_date_id = $bookingDate->id;
                $this->bookingTimeSlotRepository->save($slot);
            }

            return $bookingDate;
        });
    }

    public function findById(int $id): BookingDate
    {
        $bookingDate = $this->bookingDateRepository->findById($id);
        return $bookingDate;
    }

    public function deleteService(int $id)
    {
        $bookingDate = $this->bookingDateRepository->findById($id);
        if (!$bookingDate) {
            throw new NotFoundHttpException("Not exists");
        }

        DB::transaction(function () use ($bookingDate) {
            foreach ($bookingDate->timeSlots as $slot) {
                $this->bookingTimeSlotRepository->delete($slot);
            }
            $this->bookingDateRepository->delete($bookingDate);
        });
    }

    public function bulkDeleteService(array $bookingDateIds): void
    {
        if (empty($bookingDateIds)) {
            throw new InvalidArgumentException('Vui lòng chọn ít nhất một ngày để xóa.');
        }
        DB::transaction(function () use ($bookingDateIds) {

            $bookingDates = $this->bookingDateRepository->findByIds($bookingDateIds);

            if ($bookingDates->isEmpty()) {
                throw new InvalidArgumentException('Không tìm thấy ngày booking hợp lệ.');
            }

            foreach ($bookingDates as $bookingDate) {
                foreach ($bookingDate->timeSlots as $slot) {
                    $this->bookingTimeSlotRepository->delete($slot);
                }

                $this->bookingDateRepository->delete($bookingDate);
            }
        });
    }
}
