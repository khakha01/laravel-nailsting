<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-sm border border-gray-100;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #fce7f3;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #db2777;
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }

        .info-group {
            margin-bottom: 20px;
            background: #f9fafb;
            padding: 15px;
            rounded: 8px;
        }

        .info-label {
            font-weight: bold;
            color: #4b5563;
            width: 150px;
            display: inline-block;
        }

        .info-value {
            color: #111827;
            font-weight: 500;
        }

        .payment-status {
            background: #dcfce7;
            color: #166534;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
            margin-top: 5px;
        }

        .services-list {
            list-style: none;
            padding: 0;
            margin-top: 10px;
        }

        .service-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #e5e7eb;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            font-weight: bold;
            font-size: 18px;
            color: #db2777;
            border-top: 2px solid #fce7f3;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🔔 Đơn đặt lịch mới #{{ $booking->id }}</h1>
            <p style="margin-top: 5px; color: #666;">Có một khách hàng vừa đặt lịch hẹn mới!</p>
        </div>

        <div class="info-group">
            <h3>👤 Thông tin khách hàng</h3>
            <div><span class="info-label">Họ tên:</span> <span class="info-value">{{ $booking->customer_name }}</span>
            </div>
            <div><span class="info-label">Số điện thoại:</span> <span class="info-value"><a
                        href="tel:{{ $booking->customer_phone }}"
                        style="text-decoration: none; color: #0c8fe1;">{{ $booking->customer_phone }}</a></span></div>
            <div><span class="info-label">Thời gian:</span> <span class="info-value">{{ $booking->booking_time }} -
                    {{ $booking->booking_date->format('d/m/Y') }}</span></div>
            @if($booking->notes)
                <div><span class="info-label">Ghi chú:</span> <span class="info-value">{{ $booking->notes }}</span></div>
            @endif
        </div>

        <div class="info-group">
            <h3>💅 Dịch vụ đã chọn</h3>
            <ul class="services-list">
                @foreach($booking->products as $product)
                    <li class="service-item">
                        <span>{{ $product->name }}</span>
                        <span>{{ number_format($product->prices->first()?->price ?? 0, 0, ',', '.') }}đ</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="info-group">
            <h3>💰 Thông tin thanh toán</h3>
            <div class="total-row">
                <span>Tổng tiền:</span>
                <span>{{ number_format($booking->total_price, 0, ',', '.') }}đ</span>
            </div>

            <div style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 15px;">
                <div style="margin-bottom: 5px;"><span class="info-label">Trạng thái:</span>
                    @if($booking->paid_amount > 0)
                        <span class="payment-status">✅ ĐÃ ĐẶT CỌC</span>
                    @else
                        <span
                            style="background: #fee2e2; color: #991b1b; padding: 5px 10px; border-radius: 4px; font-weight: bold;">❌
                            CHƯA THANH TOÁN</span>
                    @endif
                </div>
                @if($booking->paid_amount > 0)
                    <div><span class="info-label">Số tiền cọc:</span> <span class="info-value"
                            style="color: #059669; font-weight: bold;">{{ number_format($booking->paid_amount, 0, ',', '.') }}đ</span>
                    </div>
                    <div><span class="info-label">Thời gian chuyển:</span> <span
                            class="info-value">{{ $booking->paid_at->format('H:i:s d/m/Y') }}</span></div>
                @endif
            </div>
        </div>

        <div class="footer">
            <p>Email này được gửi tự động từ hệ thống đặt lịch NailSting.</p>
            <p><a href="{{ route('admin.dashboard') }}" style="color: #db2777;">Truy cập trang quản trị</a></p>
        </div>
    </div>
</body>

</html>