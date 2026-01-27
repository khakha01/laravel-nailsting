@extends('admin.layouts.layout')

@section('title', 'Chi tiết đặt lịch Nail')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">

        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li>
                            <a href="{{ route('nail-bookings.index') }}"
                                class="text-sm text-gray-500 hover:text-gray-700">Quản
                                lý đặt lịch Nail</a>
                        </li>
                        <li>
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </li>
                        <li>
                            <span class="text-sm font-medium text-gray-700">Chi tiết #{{ $booking->id }}</span>
                        </li>
                    </ol>
                </nav>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Chi tiết đơn đặt lịch Nail #{{ $booking->id }}
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Left Column: Info --}}
            <div class="md:col-span-2 space-y-6">
                {{-- Nail Service Info --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 text-pink-600 font-bold">
                        <h3 class="text-sm uppercase tracking-wider">Thông tin mẫu Nail</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start gap-6">
                            @if($booking->nail && $booking->nail->primary_image_url)
                                <div
                                    class="w-48 h-48 flex-shrink-0 rounded-xl overflow-hidden shadow-md border border-gray-100">
                                    <img src="{{ $booking->nail->primary_image_url }}" alt="{{ $booking->nail->name }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @endif
                            <div class="flex-1 space-y-4">
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900">
                                        {{ $booking->nail->name ?? 'Nail không tồn tại' }}
                                    </h4>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-pink-50 p-3 rounded-lg">
                                        <p class="text-[10px] text-pink-400 font-bold uppercase">Giá mẫu</p>
                                        <p class="text-lg font-bold text-pink-600">
                                            {{ number_format($booking->nail_price, 0, ',', '.') }}đ
                                        </p>
                                    </div>
                                    <div class="bg-blue-50 p-3 rounded-lg">
                                        <p class="text-[10px] text-blue-400 font-bold uppercase">Tiền cọc</p>
                                        <p class="text-lg font-bold text-blue-600">
                                            {{ number_format($booking->deposit_amount, 0, ',', '.') }}đ
                                        </p>
                                    </div>
                                </div>
                                <div class="border-t border-gray-100 pt-4">
                                    <div class="flex justify-between items-center bg-gray-50 p-4 rounded-xl">
                                        <span class="text-sm font-bold text-gray-700 uppercase">TỔNG CỘNG</span>
                                        <span
                                            class="text-2xl font-black text-gray-900">{{ number_format($booking->total_amount, 0, ',', '.') }}đ</span>
                                    </div>
                                    <div class="flex justify-between items-center mt-2 px-4">
                                        <span class="text-sm font-medium text-gray-500 italic">Còn lại cần thanh
                                            toán:</span>
                                        <span
                                            class="text-sm font-bold text-red-500">{{ number_format($booking->remaining_amount, 0, ',', '.') }}đ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment Proof --}}
                @if($booking->payment_proof)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Chứng thực chuyển khoản (Cọc)
                            </h3>
                            <a href="{{ Storage::disk('minio')->url($booking->payment_proof) }}" target="_blank"
                                class="text-xs text-pink-600 hover:underline font-medium">Mở ảnh lớn</a>
                        </div>
                        <div class="p-6 flex justify-center bg-gray-100/50">
                            <div class="max-w-md w-full rounded-lg shadow-lg overflow-hidden border-2 border-white">
                                <img src="{{ Storage::disk('minio')->url($booking->payment_proof) }}" alt="Payment Proof"
                                    class="w-full h-auto">
                            </div>
                        </div>
                    </div>
                @endif


                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Ghi chú từ khách hàng</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 italic">
                            {{ $booking->notes ?? 'Không có ghi chú nào.' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Right Column: Status & Customer --}}
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Thông tin khách hàng</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="text-xs text-gray-400 font-bold uppercase tracking-wider block mb-1">Họ và
                                tên</label>
                            <p class="text-sm font-bold text-gray-800">{{ $booking->customer_name }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 font-bold uppercase tracking-wider block mb-1">Số điện
                                thoại</label>
                            <p class="text-sm font-bold text-[#0c8fe1]">{{ $booking->customer_phone }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 font-bold uppercase tracking-wider block mb-1">Email</label>
                            <p class="text-sm font-bold text-gray-800">{{ $booking->customer_email ?? 'N/A' }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-gray-400 font-bold uppercase tracking-wider block mb-1">Ngày
                                    đặt</label>
                                <p class="text-sm font-bold text-gray-800">
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 font-bold uppercase tracking-wider block mb-1">Khung
                                    giờ</label>
                                <p class="text-sm font-bold text-gray-800">
                                    {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Trạng thái & Thanh toán</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <form action="{{ route('nail-bookings.update-status', $booking->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Trạng thái đơn</label>
                                <select name="status" class="w-full rounded-xl border-gray-200 text-sm font-bold focus:ring-pink-500 focus:border-pink-500
                                                @if($booking->status == 'pending') bg-yellow-50 text-yellow-700 @endif
                                                @if($booking->status == 'confirmed') bg-blue-50 text-blue-700 @endif
                                                @if($booking->status == 'completed') bg-green-50 text-green-700 @endif
                                                @if($booking->status == 'cancelled') bg-red-50 text-red-700 @endif">
                                    <option value="pending" @selected($booking->status == 'pending')>Chờ xác nhận</option>
                                    <option value="confirmed" @selected($booking->status == 'confirmed')>Đã xác nhận</option>
                                    <option value="completed" @selected($booking->status == 'completed')>Hoàn thành</option>
                                    <option value="cancelled" @selected($booking->status == 'cancelled')>Đã hủy</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Tình trạng thanh
                                    toán</label>
                                <select name="payment_status"
                                    class="w-full rounded-xl border-gray-200 text-sm font-bold focus:ring-pink-500 focus:border-pink-500
                                                @if($booking->payment_status == 'unpaid') bg-red-50 text-red-700 @endif
                                                @if($booking->payment_status == 'deposit_paid') bg-blue-50 text-blue-700 @endif
                                                @if($booking->payment_status == 'fully_paid') bg-green-50 text-green-700 @endif">
                                    <option value="unpaid" @selected($booking->payment_status == 'unpaid')>Chưa thanh toán
                                    </option>
                                    <option value="deposit_paid" @selected($booking->payment_status == 'deposit_paid')>Đã cọc
                                        50k</option>
                                    <option value="fully_paid" @selected($booking->payment_status == 'fully_paid')>Đã thanh
                                        toán hết</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Ghi chú nội bộ
                                    (Admin)</label>
                                <textarea name="admin_notes" rows="3"
                                    class="w-full rounded-xl border-gray-200 text-sm focus:ring-pink-500 focus:border-pink-500"
                                    placeholder="Chỉ admin mới thấy...">{{ $booking->admin_notes }}</textarea>
                            </div>

                            <button type="submit"
                                class="w-full bg-pink-600 text-white font-bold py-2.5 rounded-xl hover:bg-pink-700 transition-all text-sm uppercase tracking-wider shadow-md">
                                Cập nhật thông tin đơn
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection