<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Booking\BookingService;
use App\Services\Notification\TelegramService;
use App\Mail\NewBookingAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected $bookingService;
    protected $telegramService;

    public function __construct(BookingService $bookingService, TelegramService $telegramService)
    {
        $this->bookingService = $bookingService;
        $this->telegramService = $telegramService;
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
            'payment_proof' => 'nullable|image|max:5120', // Max 5MB
        ]);

        try {
            // Handle Payment Proof Upload
            if ($request->hasFile('payment_proof')) {
                $path = $request->file('payment_proof')->store('payment_proofs', 'minio'); // Storing on MinIO as configured
                $validated['payment_proof'] = $path;

                // Status remains pending until Admin confirms
                $validated['is_paid'] = false;
                $validated['notes'] = ($validated['notes'] ?? '') . "\n[System: Khách đã gửi ảnh bill, chờ xác nhận]";
            } else {
                // Default: Pending payment
                $validated['is_paid'] = false;
            }


            $booking = $this->bookingService->createBooking($validated);

            // 1. Send Email Notification
            try {
                Mail::to(config('mail.admin_address'))->send(new NewBookingAdminNotification($booking));
            } catch (\Exception $e) {
                Log::error('Failed to send email/telegram: ' . $e->getMessage());
            }

            // 2. Send Telegram Notification
            try {
                $this->telegramService->sendNewBookingNotification($booking);
            } catch (\Exception $e) {
                Log::error('Failed to send email/telegram: ' . $e->getMessage());
            }

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
