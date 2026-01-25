<?php

namespace App\Http\Controllers\User;

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
     * Store a newly created booking in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string',
            'services' => 'required|array',
            'services.*' => 'exists:products,id',
            'total_price' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        try {
            // Add payment info manually since this is called AFTER user confirms payment
            $validated['paid_amount'] = $validated['total_price'];
            $validated['paid_at'] = now();

            $booking = $this->bookingService->createBooking($validated);
            return response()->json([
                'success' => true,
                'message' => 'Đặt lịch thành công!',
                'booking' => $booking
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
