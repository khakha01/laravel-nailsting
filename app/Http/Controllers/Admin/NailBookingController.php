<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Booking\NailBookingService;
use Illuminate\Http\Request;
use App\Models\NailBooking;

class NailBookingController extends Controller
{
    protected $nailBookingService;

    public function __construct(NailBookingService $nailBookingService)
    {
        $this->nailBookingService = $nailBookingService;
    }

    /**
     * Display a listing of the nail bookings.
     */
    public function index(Request $request)
    {
        try {
            $query = new \App\Queries\ListNailBookings\ListNailBookingQuery(
                customer: $request->get('customer'),
                startDate: $request->get('start_date'),
                endDate: $request->get('end_date'),
                status: $request->get('status'),
                paymentStatus: $request->get('payment_status'),
                today: (bool) $request->get('today'),
                page: (int) $request->get('page', 1),
            );

            $bookings = app(\App\Queries\ListNailBookings\ListNailBookingHandler::class)->execute($query);

            return view('admin.nail-bookings.index', compact('bookings'));
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể lấy danh sách đặt lịch nail: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified booking status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'nullable|in:pending,confirmed,completed,cancelled',
            'payment_status' => 'nullable|in:unpaid,deposit_paid,fully_paid',
        ]);

        try {
            $booking = NailBooking::findOrFail($id);

            if ($request->has('status')) {
                $booking->status = $request->status;
            }

            if ($request->has('payment_status')) {
                $booking->payment_status = $request->payment_status;
            }

            if ($request->has('admin_notes')) {
                $booking->admin_notes = $request->admin_notes;
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
        $booking = $this->nailBookingService->findById($id);
        return view('admin.nail-bookings.show', compact('booking'));
    }

    /**
     * Remove the specified booking.
     */
    public function destroy($id)
    {
        try {
            $this->nailBookingService->deleteBooking($id);
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

            $count = $this->nailBookingService->bulkDeleteBookings($ids);
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
        $bookings = $this->nailBookingService->getTrashedBookings();
        return view('admin.nail-bookings.trash', compact('bookings'));
    }

    /**
     * Restore booking
     */
    public function restore($id)
    {
        try {
            $this->nailBookingService->restoreBooking($id);
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
            $this->nailBookingService->forceDeleteBooking($id);
            return back()->with('success', 'Xóa vĩnh viễn đặt lịch thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
