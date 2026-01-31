<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreBookingRequest;
use App\Services\Booking\BookingService;
use App\Services\Notification\TelegramService;
use App\Mail\NewBookingAdminNotification;
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
    public function store(StoreBookingRequest $request)
    {
        try {
            $validated = $request->validated();

            // Handle Payment Proof Upload
            if ($request->hasFile('payment_proof')) {
                $path = $request->file('payment_proof')->store('payment_proofs', 'minio');
                $validated['payment_proof'] = $path;
                $validated['is_paid'] = false;
                $validated['notes'] = ($validated['notes'] ?? '') . "\n[System: Khách đã gửi ảnh bill, chờ xác nhận]";
            } else {
                $validated['is_paid'] = false;
            }

            $booking = $this->bookingService->createBooking($validated);

            // 1. Send Email Notification
            $this->sendEmailNotification($booking);

            // 2. Send Telegram Notification
            try {
                $this->telegramService->sendNewBookingNotification($booking);
            } catch (\Exception $e) {
                Log::error('Failed to send Telegram notification: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Đặt lịch thành công!',
                'booking' => $booking
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating booking: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    protected function sendEmailNotification($booking)
    {
        try {
            $adminEmail = \App\Models\Setting::first()->email ?? config('mail.admin_address');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new NewBookingAdminNotification($booking));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage());
        }
    }
}
