@extends('admin.layouts.layout')

@section('title', 'Redis Statistics')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">
        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Redis Statistics
                </h2>
                <p class="mt-1 text-sm text-gray-500">Monitor cache usage and Redis server performance.</p>
            </div>
            <div class="flex items-center gap-3">
                @if(auth()->guard('admin')->user()->hasPermission('redis-delete'))
                    <form action="{{ route('redis.flush') }}" method="POST"
                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa toàn bộ cache? Hành động này có thể làm chậm hệ thống trong chốc lát.')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition-all">
                            <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Xóa toàn bộ Cache
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Alert Messages --}}
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

        @if (session('error'))
            <div class="mb-4 rounded-md bg-red-50 p-4 border-l-4 border-red-500">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($info['status'] === 'connected')
            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                {{-- Memory Card --}}
                <div
                    class="bg-white shadow-sm rounded-2xl border border-gray-100 hover:shadow-md transition-all duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-xl p-3 group-hover:scale-110 transition-transform">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 flex items-center gap-1">
                                        Bộ nhớ sử dụng
                                        <div class="relative group/tooltip">
                                            <svg class="h-4 w-4 text-gray-400 cursor-help" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div
                                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all z-10 text-center shadow-xl">
                                                Tổng lượng RAM Redis dùng cho dữ liệu cache. "Peak" là mức cao nhất bộ nhớ từng
                                                đạt tới.
                                                <div
                                                    class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-gray-900">
                                                </div>
                                            </div>
                                        </div>
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-bold text-gray-900">{{ $info['memory_used'] }}</div>
                                        <div class="ml-2 flex items-baseline text-sm font-semibold text-gray-400">
                                            Peak: {{ $info['memory_peak'] }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Keys Card --}}
                <div
                    class="bg-white     shadow-sm rounded-2xl border border-gray-100 hover:shadow-md transition-all duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-pink-500 rounded-xl p-3 group-hover:scale-110 transition-transform">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 flex items-center gap-1">
                                        Tổng số Keys
                                        <div class="relative group/tooltip">
                                            <svg class="h-4 w-4 text-gray-400 cursor-help" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div
                                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all z-10 text-center shadow-xl">
                                                Số lượng bản ghi dữ liệu riêng biệt đang được lưu trong database cache (SELECT
                                                1).
                                                <div
                                                    class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-gray-900">
                                                </div>
                                            </div>
                                        </div>
                                    </dt>
                                    <dd>
                                        <div class="text-2xl font-bold text-gray-900">{{ number_format($info['total_keys']) }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Uptime Card --}}
                <div
                    class="bg-white     shadow-sm rounded-2xl border border-gray-100 hover:shadow-md transition-all duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-xl p-3 group-hover:scale-110 transition-transform">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 flex items-center gap-1">
                                        Thời gian chạy
                                        <div class="relative group/tooltip">
                                            <svg class="h-4 w-4 text-gray-400 cursor-help" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div
                                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all z-10 text-center shadow-xl">
                                                Thời gian máy chủ Redis hoạt động liên tục. Reset mỗi khi restart tiến trình
                                                Redis.
                                                <div
                                                    class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-gray-900">
                                                </div>
                                            </div>
                                        </div>
                                    </dt>
                                    <dd>
                                        <div class="text-2xl font-bold text-gray-900">{{ $info['uptime'] }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Version Card --}}
                <div
                    class="bg-white     shadow-sm rounded-2xl border border-gray-100 hover:shadow-md transition-all duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-xl p-3 group-hover:scale-110 transition-transform">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 flex items-center gap-1">
                                        Phiên bản Redis
                                        <div class="relative group/tooltip">
                                            <svg class="h-4 w-4 text-gray-400 cursor-help" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div
                                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all z-10 text-center shadow-xl">
                                                Phiên bản hiện tại của phần mềm Redis đang chạy trong môi trường máy chủ.
                                                <div
                                                    class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-gray-900">
                                                </div>
                                            </div>
                                        </div>
                                    </dt>
                                    <dd>
                                        <div class="text-2xl font-bold text-gray-900">{{ $info['version'] }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Key Usage Breakdown --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100   ">
                        <div class="px-6 py-5 border-b border-gray-100 bg-white flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900">Chi tiết nhóm Keys</h3>
                            <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Toàn bộ dữ liệu bộ
                                nhớ</span>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @forelse($keyStats as $group => $data)
                                <div class="px-6 py-5 hover:bg-gray-50/50 transition-colors">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center space-x-4">
                                            <div
                                                class="h-11 w-11 rounded-xl bg-gray-100 flex items-center justify-center text-gray-500 shadow-sm border border-gray-200">
                                                @include('admin.system.redis.partials.icons.' . $data['icon'])
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <h4 class="text-base font-bold text-gray-900 leading-tight">
                                                        {{ $data['display_title'] }}
                                                    </h4>
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                                        {{ $data['count'] }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-0.5">
                                                    {{ $data['display_desc'] }}
                                                </p>
                                            </div>
                                        </div>
                                        @if(auth()->guard('admin')->user()->hasPermission('redis-delete'))
                                            <form action="{{ route('redis.delete-pattern') }}" method="POST"
                                                onsubmit="return confirm('Xóa bộ nhớ đệm thuộc nhóm {{ $data['display_title'] }}?')">
                                                @csrf
                                                <input type="hidden" name="pattern" value="{{ config('cache.prefix') }}{{ $group }}:*">
                                                <button type="submit"
                                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                    title="Giải phóng vùng nhớ này">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="bg-gray-50/80 rounded-xl p-3 border border-gray-100">
                                        <div class="flex items-center justify-between mb-3">
                                            <span
                                                class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none">Danh
                                                sách Keys</span>
                                            @if($data['count'] > 5)
                                                <div class="relative">
                                                    <input type="text" placeholder="Tìm key..."
                                                        onkeyup="filterKeys(this, '{{ $group }}')"
                                                        class="text-[10px] px-2 py-1 rounded border border-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 w-32 bg-white">
                                                </div>
                                            @endif
                                        </div>
                                        <div id="key-container-{{ $group }}"
                                            class="grid grid-cols-1 md:grid-cols-2 gap-2 max-h-[300px] overflow-y-auto pr-1 custom-scrollbar">
                                            @foreach($data['keys'] as $key)
                                                <div class="key-item bg-white px-3 py-1.5 rounded-lg text-[10px] font-mono text-gray-600 truncate border border-gray-100 shadow-sm flex items-center group/key"
                                                    data-key="{{ $key }}">
                                                    <span
                                                        class="w-1.5 h-1.5 rounded-full bg-blue-400 mr-2 opacity-50 group-hover/key:opacity-100 transition-opacity"></span>
                                                    <span class="truncate" title="{{ $key }}">{{ $key }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($data['count'] > 50)
                                            <div class="text-[9px] text-gray-400 italic mt-2 text-right">
                                                Đang hiển thị tất cả {{ $data['count'] }} bản ghi. Sử dụng thanh cuộn để xem thêm.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <p>Hệ thống hiện chưa có dữ liệu cache nào.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Server Info Sidebar --}}
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Chi tiết Server</h3>
                        </div>
                        <div class="p-6">
                            <dl class="space-y-4">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Clients kết nối</dt>
                                    <dd class="text-sm font-bold text-gray-900">{{ $info['clients'] }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">CPU Usage</dt>
                                    <dd class="text-sm font-bold text-gray-900">{{ number_format($info['cpu_usage'], 2) }}%</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Hệ điều hành</dt>
                                    <dd class="text-sm font-bold text-gray-900 text-right">
                                        {{ $info['raw_info']['os'] ?? 'Unknown' }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Tiến trình (PID)</dt>
                                    <dd class="text-sm font-bold text-gray-900">{{ $info['raw_info']['process_id'] ?? 'N/A' }}
                                    </dd>
                                </div>
                            </dl>

                            <div class="mt-8">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Mô phỏng bộ nhớ</h4>
                                <div class="relative pt-1">
                                    <div class="overflow-hidden h-3 text-xs flex rounded-full bg-blue-100">
                                        <div style="width:{{ min(100, (floatval($info['memory_used']) / max(1, floatval($info['memory_peak']))) * 100) }}%"
                                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500">
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-xs mt-2">
                                        <span class="text-gray-500">Current</span>
                                        <span class="text-gray-500">Peak</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="bg-gradient-to-br from-indigo-600 to-pink-600 rounded-2xl shadow-lg p-6 text-white">
                        <h3 class="text-lg font-bold mb-4">Phím tắt nhanh</h3>
                        <p class="text-indigo-100 text-sm mb-6">Xóa các cache patterns phổ biến nhất để giải phóng bộ nhớ.</p>
                        <div class="space-y-3">
                            <form action="{{ route('redis.delete-pattern') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pattern" value="{{ config('cache.prefix') }}*">
                                <button type="submit"
                                    class="w-full bg-white/20 hover:bg-white/30 text-white text-sm font-bold py-2 px-4 rounded-xl transition-all flex items-center justify-between">
                                    <span>Tất cả Cache App</span>
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </button>
                            </form>
                            <form action="{{ route('redis.delete-pattern') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pattern" value="{{ config('cache.prefix') }}booking:*">
                                <button type="submit"
                                    class="w-full bg-white/20 hover:bg-white/30 text-white text-sm font-bold py-2 px-4 rounded-xl transition-all flex items-center justify-between">
                                    <span>Cache Booking</span>
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-red-50 rounded-2xl p-12 text-center border-2 border-dashed border-red-200">
                <svg class="mx-auto h-16 w-16 text-red-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-xl font-bold text-red-800 mb-2">Không thể kết nối Redis Server</h3>
                <p class="text-red-600 max-w-md mx-auto">{{ $info['error'] }}</p>
                <div class="mt-8">
                    <button onclick="window.location.reload()"
                        class="bg-red-600 text-white px-6 py-2 rounded-xl hover:bg-red-700 transition-all font-bold">
                        Thử lại
                    </button>
                </div>
            </div>
        @endif
    </div>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #d1d5db;
        }
    </style>

    <script>
        function filterKeys(input, group) {
            const value = input.value.toLowerCase();
            const container = document.getElementById('key-container-' + group);
            const items = container.getElementsByClassName('key-item');

            for (let item of items) {
                const key = item.getAttribute('data-key').toLowerCase();
                if (key.includes(value)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            }
        }
    </script>
@endsection