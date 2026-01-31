<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreNailBookingRequest;
use App\Services\Booking\NailBookingService;
use App\Services\Notification\TelegramService;
use Illuminate\Support\Facades\Log;

class NailBookingController extends Controller
{
    protected $nailBookingService;
    protected $telegramService;

    public function __construct(NailBookingService $nailBookingService, TelegramService $telegramService)
    {
        $this->nailBookingService = $nailBookingService;
        $this->telegramService = $telegramService;
    }

    public function store(StoreNailBookingRequest $request)
    {
        try {
            $validated = $request->validated();

            // Handle payment proof upload
            if ($request->hasFile('payment_proof')) {
                $validated['payment_proof'] = $request->file('payment_proof')->store('nail-bookings/payment-proofs', 'minio');
            }

            // Create nail booking via service
            $nailBooking = $this->nailBookingService->createBooking($validated);

            // Send Telegram notification
            try {
                $this->telegramService->sendNewNailBookingNotification($nailBooking);
            } catch (\Exception $e) {
                Log::error('Failed to send Telegram notification (Nail): ' . $e->getMessage());
            }

            Log::info('Nail booking created successfully', ['booking_id' => $nailBooking->id]);

            return response()->json([
                'success' => true,
                'message' => 'Đặt lịch nail thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất.',
                'booking_id' => $nailBooking->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Error creating nail booking', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }
}
