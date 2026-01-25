@extends('admin.layouts.layout')

@section('title', 'Quản lý đặt lịch')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">

        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Quản lý đặt lịch
                </h2>
                <p class="mt-1 text-sm text-gray-500">Xem và quản lý các yêu cầu đặt lịch từ khách hàng.</p>
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 p-4 border-l-4 border-green-500">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Khách hàng</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Thời gian</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Dịch vụ</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Tổng tiền</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Trạng thái</th>
                            <th scope="col" class="relative px-6 py-4"><span class="sr-only">Hành động</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $booking->customer_name }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ $booking->customer_phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->booking_time }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->booking_date->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($booking->products as $product)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-pink-50 text-pink-700 border border-pink-100">
                                                {{ $product->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-bold text-[#0c8fe1]">{{ number_format($booking->total_price, 0, ',', '.') }}đ</span>
                                        @if($booking->paid_amount > 0)
                                            <span class="text-xs text-green-600 font-semibold mt-1">
                                                Đã TT: {{ number_format($booking->paid_amount, 0, ',', '.') }}đ
                                            </span>
                                            <span class="text-[10px] text-gray-400">
                                                {{ $booking->paid_at ? $booking->paid_at->format('H:i d/m') : '' }}
                                            </span>
                                        @else
                                            <span class="text-xs text-red-400 italic mt-1">Chưa thanh toán</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('bookings.update-status', $booking->id) }}" method="POST"
                                        id="status-form-{{ $booking->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status"
                                            onchange="document.getElementById('status-form-{{ $booking->id }}').submit()" class="text-xs font-semibold rounded-full px-2.5 py-1 focus:ring-pink-500 focus:border-pink-500 border-none
                                                            @if($booking->status == 'pending') bg-yellow-50 text-yellow-700 @endif
                                                            @if($booking->status == 'confirmed') bg-blue-50 text-blue-700 @endif
                                                            @if($booking->status == 'completed') bg-green-50 text-green-700 @endif
                                                            @if($booking->status == 'cancelled') bg-red-50 text-red-700 @endif
                                                            ">
                                            <option value="pending" @selected($booking->status == 'pending')>Chờ xác nhận</option>
                                            <option value="confirmed" @selected($booking->status == 'confirmed')>Đã xác nhận
                                            </option>
                                            <option value="completed" @selected($booking->status == 'completed')>Hoàn thành
                                            </option>
                                            <option value="cancelled" @selected($booking->status == 'cancelled')>Đã hủy</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('bookings.show', $booking->id) }}"
                                        class="text-gray-400 hover:text-pink-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 010-.644C3.301 8.844 6.471 6 10 6c3.529 0 6.699 2.844 7.964 5.678a1.012 1.012 0 010 .644C16.699 15.156 13.529 18 10 18c-3.529 0-6.699-2.844-7.964-5.678z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center bg-gray-50">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">Chưa có yêu cầu đặt lịch nào.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="border-t border-gray-200 bg-gray-50 px-4 py-3 sm:px-6">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection