@extends('admin.layouts.layout')

@section('title', 'Chi tiết đặt lịch')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">

        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li>
                            <a href="{{ route('bookings.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Quản
                                lý đặt lịch</a>
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
                    Chi tiết đơn đặt lịch #{{ $booking->id }}
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Left Column: Info --}}
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Thông tin dịch vụ</h3>
                    </div>
                    <div class="p-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-3 text-left text-xs font-semibold text-gray-500 uppercase">Sản phẩm/Dịch
                                        vụ</th>
                                    <th class="py-3 text-right text-xs font-semibold text-gray-500 uppercase">Đơn giá</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($booking->products as $product)
                                    <tr>
                                        <td class="py-4 text-sm text-gray-700 font-medium">{{ $product->name }}</td>
                                        <td class="py-4 text-sm text-gray-700 text-right">
                                            {{ number_format($product->prices->first()?->price ?? 0, 0, ',', '.') }}đ
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50">
                                    <td class="py-4 px-2 text-sm font-bold text-gray-900">TỔNG CỘNG</td>
                                    <td class="py-4 px-2 text-lg font-bold text-pink-600 text-right">
                                        {{ number_format($booking->total_price, 0, ',', '.') }}đ
                                    </td>
                                </tr>
                                @if($booking->paid_amount > 0)
                                    <tr class="bg-green-50">
                                        <td class="py-3 px-2 text-sm font-bold text-green-800">
                                            ĐÃ THANH TOÁN
                                            <span class="block text-xs font-normal text-green-600 italic">
                                                {{ $booking->paid_at ? 'lúc ' . $booking->paid_at->format('H:i d/m/Y') : '' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-2 text-lg font-bold text-green-700 text-right">
                                            {{ number_format($booking->paid_amount, 0, ',', '.') }}đ
                                        </td>
                                    </tr>
                                @endif
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Yêu cầu đặc biệt</h3>
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
                            <label class="text-xs text-gray-400 font-bold uppercase tracking-wider block mb-1">Ngày
                                đặt</label>
                            <p class="text-sm font-bold text-gray-800">{{ $booking->booking_date->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 font-bold uppercase tracking-wider block mb-1">Khung
                                giờ</label>
                            <p class="text-sm font-bold text-gray-800">{{ $booking->booking_time }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Trạng thái</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('bookings.update-status', $booking->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="w-full rounded-xl border-gray-200 text-sm font-bold focus:ring-pink-500 focus:border-pink-500 mb-4
                                    @if($booking->status == 'pending') bg-yellow-50 text-yellow-700 @endif
                                    @if($booking->status == 'confirmed') bg-blue-50 text-blue-700 @endif
                                    @if($booking->status == 'completed') bg-green-50 text-green-700 @endif
                                    @if($booking->status == 'cancelled') bg-red-50 text-red-700 @endif">
                                <option value="pending" @selected($booking->status == 'pending')>Chờ xác nhận</option>
                                <option value="confirmed" @selected($booking->status == 'confirmed')>Đã xác nhận</option>
                                <option value="completed" @selected($booking->status == 'completed')>Hoàn thành</option>
                                <option value="cancelled" @selected($booking->status == 'cancelled')>Đã hủy</option>
                            </select>
                            <button type="submit"
                                class="w-full bg-pink-600 text-white font-bold py-2.5 rounded-xl hover:bg-pink-700 transition-all text-sm uppercase tracking-wider">
                                Cập nhật trạng thái
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection