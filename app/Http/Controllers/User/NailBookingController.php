<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\NailBooking;
use App\Models\Nail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class NailBookingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_phone' => 'required|string|max:20',
                'customer_email' => 'nullable|email|max:255',
                'nail_id' => 'required|exists:nails,id',
                'nail_price' => 'required|numeric|min:0',
                'booking_date' => 'required|date',
                'booking_time' => 'required',
                'notes' => 'nullable|string',
                'terms_accepted' => 'required|boolean|accepted',
                'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);

            // Calculate amounts
            $depositAmount = 50000; // Fixed deposit
            $totalAmount = $validated['nail_price'];
            $remainingAmount = $totalAmount - $depositAmount;

            // Handle payment proof upload
            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('nail-bookings/payment-proofs', 'public');
            }

            // Create nail booking
            $nailBooking = NailBooking::create([
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'] ?? null,
                'nail_id' => $validated['nail_id'],
                'nail_price' => $validated['nail_price'],
                'booking_date' => $validated['booking_date'],
                'booking_time' => $validated['booking_time'],
                'deposit_amount' => $depositAmount,
                'total_amount' => $totalAmount,
                'remaining_amount' => $remainingAmount,
                'payment_proof' => $paymentProofPath,
                'status' => 'pending',
                'payment_status' => $paymentProofPath ? 'deposit_paid' : 'unpaid',
                'notes' => $validated['notes'] ?? null,
                'terms_accepted' => $validated['terms_accepted'],
            ]);

            // TODO: Send email notification
            // TODO: Send Telegram notification

            Log::info('Nail booking created successfully', ['booking_id' => $nailBooking->id]);

            return response()->json([
                'success' => true,
                'message' => 'Đặt lịch nail thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất.',
                'booking_id' => $nailBooking->id,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng kiểm tra lại thông tin!',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating nail booking', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau!',
            ], 500);
        }
    }
}
