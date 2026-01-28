<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Booking\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Display a listing of the bookings.
     */
    public function index(Request $request)
    {
        try {
            $query = new \App\Queries\ListBookings\ListBookingQuery(
                customer: $request->get('customer'),
                startDate: $request->get('start_date'),
                endDate: $request->get('end_date'),
                status: $request->get('status'),
                isPaid: $request->has('is_paid') ? (int) $request->get('is_paid') : null,
                today: (bool) $request->get('today'),
                page: (int) $request->get('page', 1),
            );

            $bookings = app(\App\Queries\ListBookings\ListBookingHandler::class)->execute($query);

            return view('admin.bookings.index', compact('bookings'));
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể lấy danh sách đặt lịch: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified booking status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'nullable|in:pending,confirmed,completed,cancelled',
            'is_paid' => 'nullable|boolean',
        ]);

        try {
            $booking = \App\Models\Booking::findOrFail($id);

            if ($request->has('status')) {
                $booking->status = $request->status;
            }

            if ($request->has('is_paid')) {
                $booking->is_paid = $request->boolean('is_paid');
            }

            $booking->save();

            return back()->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Show booking details.
     */
    public function show($id)
    {
        $booking = $this->bookingService->findById($id);
        return view('admin.bookings.show', compact('booking'));
    }
    /**
     * Remove the specified booking.
     */
    public function destroy($id)
    {
        try {
            $this->bookingService->deleteBooking($id);
            return back()->with('success', 'Xóa đặt lịch thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete bookings
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('booking_ids', []);
            if (empty($ids)) {
                return back()->with('error', 'Vui lòng chọn ít nhất một mục để xóa.');
            }

            $count = $this->bookingService->bulkDeleteBookings($ids);
            return back()->with('success', "Đã xóa {$count} mục thành công!");
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display trash list
     */
    public function trash()
    {
        $bookings = $this->bookingService->getTrashedBookings();
        return view('admin.bookings.trash', compact('bookings'));
    }

    /**
     * Restore booking
     */
    public function restore($id)
    {
        try {
            $this->bookingService->restoreBooking($id);
            return back()->with('success', 'Khôi phục đặt lịch thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Force delete booking
     */
    public function forceDelete($id)
    {
        try {
            $this->bookingService->forceDeleteBooking($id);
            return back()->with('success', 'Xóa vĩnh viễn đặt lịch thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
