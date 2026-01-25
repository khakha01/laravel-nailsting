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
    public function index()
    {
        $bookings = $this->bookingService->getAllBookings();
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Update the specified booking status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        try {
            $this->bookingService->updateStatus($id, $request->status);
            return back()->with('success', 'Cập nhật trạng thái thành công!');
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
}
