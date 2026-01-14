<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingDates\StoreBookingDateRequest;
use App\Http\Requests\BookingDates\UpdateBookingDateRequest;
use App\Queries\ListBookingDates\ListBookingDateHandler;
use App\Queries\ListBookingDates\ListBookingDateQuery;
use App\Services\BookingDate\BookingDateService;
use Illuminate\Http\Request;

class BookingDateController extends Controller
{
    public function __construct(
        protected BookingDateService $bookingDateService
    ) {}

    public function index(Request $request)
    {
        $isOpen = $request->filled('is_open') ? (bool) $request->get('is_open') : null;
        $query = new ListBookingDateQuery(
            page: (int) ($request->get('page', 1)),
            perPage: (int) ($request->get('perPage', 10)),
            date: $request->get('date'),
            isOpen: $isOpen
        );

        $dates = app(ListBookingDateHandler::class)->execute($query);

        return view('admin.booking-date-management.index', compact('dates'));
    }


    public function create()
    {
        return view('admin.booking-date-management.create');
    }

    public function store(StoreBookingDateRequest $request)
    {
        try {
            $date = $request->get('date');
            $isOpen = (bool) $request->get('is_open');
            $timeSlots = $request->get('time_slots');

            $this->bookingDateService->createService($date, $isOpen, $timeSlots);

            return redirect()->route('booking-dates.index')->with('success', 'Tạo ngày & khung giờ thành công');
        } catch (\Throwable $e) {
            return redirect()->route('booking-dates.index')->with('error', $e->getMessage());
        }
    }

    public function show(Request $request)
    {
        $id = (int) $request->route('id');
        $bookingDate = $this->bookingDateService->findById($id);
        return view('admin.booking-date-management.edit', compact('bookingDate'));
    }

    public function update(UpdateBookingDateRequest $request)
    {
        $bookingDateId = (int) $request->route('id');
        $date = $request->get('date');
        $isOpen = $request->get('is_open');
        $timeSlots = $request->get('time_slots');
        $this->bookingDateService->updateService($bookingDateId, $date, $isOpen, $timeSlots);

        return redirect()
            ->route('booking-dates.index')
            ->with('success', 'Cập nhật ngày & khung giờ thành công');
    }

    public function destroy(Request $request)
    {
        $id = (int) $request->route('id');
        $this->bookingDateService->deleteService($id);
        return redirect()
            ->route('booking-dates.index')
            ->with('success', 'Hành động xóa thành công');
    }

    public function bulkDelete(Request $request)
    {
        try {
            $bookingDateIds = $request->input('booking_date_ids', []);
            $this->bookingDateService->bulkDeleteService($bookingDateIds);

            return redirect()
                ->route('booking-dates.index')
                ->with('success', 'Đã xóa thành công các ngày đã chọn.');
        } catch (\Throwable $e) {
            return redirect()
                ->route('booking-dates.index')
                ->with('error', $e->getMessage());
        }
    }
}
