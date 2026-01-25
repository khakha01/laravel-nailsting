<?php

namespace App\Services\Notification;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $botToken;
    protected $chatId;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
        $this->chatId = config('services.telegram.chat_id');
    }

    public function sendMessage($message)
    {
        if (!$this->chatId) {
            Log::warning('Telegram Chat ID not configured.');
            return;
        }

        try {
            $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

            $response = Http::post($url, [
                'chat_id' => $this->chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            if (!$response->successful()) {
                Log::error('Telegram API Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Telegram Send Error: ' . $e->getMessage());
        }
    }

    public function sendPhoto($photoPath, $caption)
    {
        if (!$this->chatId) {
            return;
        }

        try {
            $url = "https://api.telegram.org/bot{$this->botToken}/sendPhoto";

            // Get file content from Storage (MinIO or Local)
            $photoContent = \Illuminate\Support\Facades\Storage::disk('minio')->get($photoPath);
            $photoName = basename($photoPath);

            $response = Http::attach('photo', $photoContent, $photoName)
                ->post($url, [
                    'chat_id' => $this->chatId,
                    'caption' => $caption,
                    'parse_mode' => 'HTML',
                ]);

            if (!$response->successful()) {
                Log::error('Telegram API Photo Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Telegram Send Photo Error: ' . $e->getMessage());
            // Fallback to text message if photo fails
            $this->sendMessage($caption . "\n\n⚠️ <i>Không gửi được ảnh: {$e->getMessage()}</i>");
        }
    }

    public function sendNewBookingNotification($booking)
    {
        $products = $booking->products->map(function ($p) {
            // Căn lề dịch vụ cho đẹp
            return "▫️ <i>{$p->name}</i>";
        })->join("\n");

        $paidStatus = $booking->is_paid
            ? "✅ <b>Đã thanh toán</b>"
            : "⚠️ <b>Chưa thanh toán</b>";

        // Custom status if proof provided but not approved yet
        if ($booking->payment_proof && !$booking->is_paid) {
            $paidStatus = "⏳ <b>Đã gửi bill, chờ xác nhận</b>";
        }

        // Header bắt mắt hơn
        $message = "✨ <b>YÊU CẦU ĐẶT LỊCH MỚI</b> ✨\n"
            . "<b>ID:</b> <code>#{$booking->id}</code>\n"
            . "----------------------------------\n\n"

            // Thông tin khách hàng theo cụm
            . "👤 <b>KHÁCH HÀNG</b>\n"
            . "├ <b>Tên:</b> {$booking->customer_name}\n"
            . "└ <b>SĐT:</b> {$booking->customer_phone}\n\n"

            // Lịch hẹn nổi bật
            . "⏰ <b>LỊCH HẸN</b>\n"
            . "└ <code>{$booking->booking_time}</code> | <code>{$booking->booking_date->format('d/m/Y')}</code>\n\n"

            // Dịch vụ dùng bullet point tinh tế
            . "💅 <b>DỊCH VỤ CHỌN</b>\n"
            . "{$products}\n"
            . "----------------------------------\n\n"

            // Thanh toán & Ghi chú
            . "💵 <b>TỔNG: " . number_format($booking->total_price) . "đ</b>\n"
            . "{$paidStatus}\n"
            . ($booking->notes ? "\n📝 <b>GHI CHÚ:</b> <i>{$booking->notes}</i>\n" : "")

            . "\n🚀 <a href='" . config('app.url') . "/admin/bookings/{$booking->id}'>Xem chi tiết trên Admin</a>";

        if ($booking->payment_proof) {
            $this->sendPhoto($booking->payment_proof, $message);
        } else {
            $this->sendMessage($message);
        }
    }
}
