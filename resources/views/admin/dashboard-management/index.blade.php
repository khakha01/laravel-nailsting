@extends('admin.layouts.layout')

@section('title', 'Bảng điều khiển')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8 py-8 bg-gray-50/50 min-h-screen">
        {{-- Header Section --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Chào mừng trở lại, {{ Auth::guard('admin')->user()->name }}</h1>
            <p class="text-gray-500 text-sm mt-1">Đây là những gì đang diễn ra tại cửa hàng của bạn hôm nay.</p>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Today Bookings --}}
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            {{ $stats['today_bookings']['label'] }}
                        </p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['today_bookings']['value'] }}</h3>
                    </div>
                    <div class="p-3 bg-pink-50 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    @if($stats['today_bookings']['growth'] >= 0)
                        <span class="text-emerald-500 flex items-center font-bold">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            {{ $stats['today_bookings']['growth'] }}%
                        </span>
                    @else
                        <span class="text-red-500 flex items-center font-bold">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                            {{ abs($stats['today_bookings']['growth']) }}%
                        </span>
                    @endif
                    <span class="text-gray-400 ml-2">so với hôm qua</span>
                </div>
            </div>

            {{-- Monthly Revenue --}}
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            {{ $stats['monthly_revenue']['label'] }}
                        </p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">
                            {{ number_format($stats['monthly_revenue']['value'] / 1000, 0) }}k <span
                                class="text-sm text-gray-400 font-normal">VNĐ</span>
                        </h3>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    @if($stats['monthly_revenue']['growth'] >= 0)
                        <span class="text-emerald-500 flex items-center font-bold">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            +{{ $stats['monthly_revenue']['growth'] }}%
                        </span>
                    @else
                        <span class="text-red-500 flex items-center font-bold">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                            {{ abs($stats['monthly_revenue']['growth']) }}%
                        </span>
                    @endif
                    <span class="text-gray-400 ml-2">so với tháng trước</span>
                </div>
            </div>

            {{-- Total Customers --}}
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            {{ $stats['total_customers']['label'] }}
                        </p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_customers']['value'] }}</h3>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-blue-500 font-medium">Khách hàng định danh</span>
                    <span class="text-gray-400 ml-2">số điện thoại duy nhất</span>
                </div>
            </div>

            {{-- Inventory Quick View --}}
            <div
                class="bg-[#1e293b] rounded-2xl p-6 shadow-sm border border-gray-800 hover:shadow-lg transition-all duration-300 text-white">

                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Hệ thống</p>

                <div class="grid grid-cols-2 gap-4 mt-4">

                    <div>
                        <p class="text-2xl font-bold">{{ $stats['inventory']['nails'] }}</p>
                        <p class="text-[10px] text-slate-400 uppercase">Mẫu Nail</p>
                    </div>

                    <div>
                        <p class="text-2xl font-bold">{{ $stats['inventory']['products'] }}</p>
                        <p class="text-[10px] text-slate-400 uppercase">Sản phẩm</p>
                    </div>

                    <div>
                        <p class="text-2xl font-bold">{{ $stats['inventory']['admins'] }}</p>
                        <p class="text-[10px] text-slate-400 uppercase">Quản trị viên</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Recent Bookings Table --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-gray-800">Đặt lịch mới nhất</h2>
                        <div class="flex gap-2">
                            <a href="{{ route('bookings.index') }}"
                                class="text-xs font-medium text-pink-500 hover:text-pink-600">Xem tất cả dịch vụ</a>
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('nail-bookings.index') }}"
                                class="text-xs font-medium text-blue-500 hover:text-blue-600">Xem tất cả Nail</a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Khách
                                        hàng</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Thời
                                        gian</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Loại
                                    </th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Số
                                        tiền</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                        Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($recent_bookings as $booking)
                                                        <tr class="hover:bg-gray-50/80 transition-colors">
                                                            <td class="px-6 py-4">
                                                                <p class="text-sm font-bold text-gray-800">{{ $booking->customer_name }}</p>
                                                                <p class="text-xs text-gray-400">{{ $booking->customer_phone }}</p>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <p class="text-sm text-gray-600">{{ $booking->booking_time }}</p>
                                                                <p class="text-xs text-gray-400">{{ $booking->booking_date->format('d/m/Y') }}</p>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <span
                                                                    class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $booking->type == 'nail' ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-pink-50 text-pink-600 border border-pink-100' }}">
                                                                    {{ $booking->type == 'nail' ? 'Nail' : 'Dịch vụ' }}
                                                                </span>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <p class="text-sm font-bold text-gray-700">
                                                                    {{ number_format($booking->amount, 0, ',', '.') }}đ
                                                                </p>
                                                            </td>
                                                            <td class="px-6 py-4 text-right">
                                                                <span
                                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold 
                                                                                                                                                                                                                        @if($booking->status == 'pending') bg-yellow-50 text-yellow-700 
                                                                                                                                                                                                                        @elseif($booking->status == 'confirmed') bg-blue-50 text-blue-700 
                                                                                                                                                                                                                        @elseif($booking->status == 'completed') bg-green-50 text-green-700 
                                                                                                                                                                                                                        @else bg-red-50 text-red-700 @endif">
                                                                    {{ 
                                                                                                                                                                                                                            $booking->status == 'pending' ? 'Chờ xác nhận' :
                                    ($booking->status == 'confirmed' ? 'Đã xác nhận' :
                                        ($booking->status == 'completed' ? 'Hoàn thành' : 'Đã hủy')) 
                                                                                                                                                                                                                        }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">Chưa có dữ liệu đặt lịch.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Status Distribution & Quick Actions --}}
            <div class="space-y-8">
                {{-- Status Distribution --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                    <h2 class="text-lg font-bold text-gray-800 mb-6 font-primary text-left">Phân bổ trạng thái</h2>
                    <div class="space-y-4">
                        @foreach($status_distribution as $status => $count)
                                        <div class="group">
                                            <div class="flex justify-between items-center mb-1">
                                                <span class="text-sm font-medium text-gray-500 capitalize">
                                                    {{ 
                                                                                                                                                                    $status == 'pending' ? 'Chờ xác nhận' :
                            ($status == 'confirmed' ? 'Đã xác nhận' :
                                ($status == 'completed' ? 'Hoàn thành' : 'Đã hủy')) 
                                                                                                                                                                }}
                                                </span>
                                                <span class="text-sm font-bold text-gray-800">{{ $count }}</span>
                                            </div>
                                            <div class="w-full bg-gray-100 rounded-full h-2">
                                                <div class="h-2 rounded-full transition-all duration-1000 
                                                                                                                                                                @if($status == 'pending') bg-yellow-400 
                                                                                                                                                                @elseif($status == 'confirmed') bg-blue-400 
                                                                                                                                                                @elseif($status == 'completed') bg-emerald-400 
                                                                                                                                                                @else bg-rose-400 @endif shadow-sm"
                                                    style="width: {{ array_sum($status_distribution) > 0 ? ($count / array_sum($status_distribution)) * 100 : 0 }}%">
                                                </div>
                                            </div>
                                        </div>
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection