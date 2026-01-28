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
            <div class="flex items-center gap-3">
                <a href="{{ route('bookings.trash') }}"
                    class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 mr-1.5 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Thùng rác
                </a>

                {{-- Nút Xóa Nhiều (Ẩn mặc định) --}}
                <button type="submit" form="bulk-delete-form" id="bulkDeleteBtn" style="display: none;"
                    class="inline-flex items-center rounded-md bg-[#e80707] px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Xóa đã chọn <span id="selected-count-badge"
                        class="ml-1 bg-white text-red-600 py-0.5 px-2 rounded-full text-xs font-bold">0</span>
                </button>
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

        {{-- Filter Section --}}
        <div class="mb-6 space-y-4">
            {{-- Quick Filter Buttons --}}
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('bookings.index', array_merge(request()->except(['page', 'is_paid']), ['is_paid' => 1])) }}"
                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ request('is_paid') === '1' ? 'bg-green-600 text-white shadow-sm' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }} transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Đã thanh toán
                </a>
                <a href="{{ route('bookings.index', array_merge(request()->except(['page', 'is_paid']), ['is_paid' => 0])) }}"
                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ request('is_paid') === '0' ? 'bg-red-600 text-white shadow-sm' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }} transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Chưa thanh toán
                </a>
                <a href="{{ route('bookings.index', array_merge(request()->except(['page', 'today']), ['today' => 1])) }}"
                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ request('today') ? 'bg-pink-600 text-white shadow-sm' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }} transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Lịch hẹn hôm nay
                </a>
                @if(request()->anyFilled(['is_paid', 'today', 'customer', 'start_date', 'end_date', 'status']))
                    <a href="{{ route('bookings.index') }}"
                        class="text-xs text-red-500 hover:text-red-700 font-medium ml-2 underline">Xóa lọc</a>
                @endif
            </div>

            {{-- Search Form --}}
            <form action="{{ route('bookings.index') }}" method="GET"
                class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="customer" class="block text-xs font-semibold text-gray-500 uppercase mb-1">Khách
                            hàng</label>
                        <input type="text" name="customer" id="customer" value="{{ request('customer') }}"
                            placeholder="Tên hoặc số điện thoại..."
                            class="block w-full rounded-lg border-gray-300 text-sm focus:ring-pink-500 focus:border-pink-500">
                    </div>
                    <div>
                        <label for="start_date" class="block text-xs font-semibold text-gray-500 uppercase mb-1">Từ
                            ngày</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="block w-full rounded-lg border-gray-300 text-sm focus:ring-pink-500 focus:border-pink-500">
                    </div>
                    <div>
                        <label for="end_date" class="block text-xs font-semibold text-gray-500 uppercase mb-1">Đến
                            ngày</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="block w-full rounded-lg border-gray-300 text-sm focus:ring-pink-500 focus:border-pink-500">
                    </div>
                    <div class="flex items-end gap-2">
                        <div class="flex-1">
                            <label for="status" class="block text-xs font-semibold text-gray-500 uppercase mb-1">Trạng
                                thái</label>
                            <select name="status" id="status"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-pink-500 focus:border-pink-500">
                                <option value="">Tất cả</option>
                                <option value="pending" @selected(request('status') == 'pending')>Chờ xác nhận</option>
                                <option value="confirmed" @selected(request('status') == 'confirmed')>Đã xác nhận</option>
                                <option value="completed" @selected(request('status') == 'completed')>Hoàn thành</option>
                                <option value="cancelled" @selected(request('status') == 'cancelled')>Đã hủy</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">
                                <input type="checkbox" id="select-all"
                                    class="h-4 w-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                            </th>
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
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox"
                                        class="row-checkbox h-4 w-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500"
                                        value="{{ $booking->id }}">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $booking->customer_name }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ $booking->customer_phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-pink-50 p-2 rounded-lg mr-3 border border-pink-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-500" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900">{{ $booking->booking_time }}</div>
                                            <div class="text-[11px] font-medium text-pink-600">
                                                {{ $booking->booking_date->format('d/m/Y') }}</div>
                                        </div>
                                    </div>
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
                                    <div class="flex flex-col space-y-2">
                                        <span
                                            class="text-sm font-bold text-[#0c8fe1]">{{ number_format($booking->total_price, 0, ',', '.') }}đ</span>

                                        <div class="flex items-center space-x-2">
                                            <!-- Payment Proof -->
                                            @if($booking->payment_proof)
                                                <a href="{{ Storage::disk('minio')->url($booking->payment_proof) }}" target="_blank"
                                                    class="text-xs flex items-center text-pink-500 hover:text-pink-700 font-medium"
                                                    title="Xem ảnh bill">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                    </svg>
                                                    Xem Bill
                                                </a>
                                            @endif
                                        </div>

                                        <!-- Payment Toggle -->
                                        <label class="inline-flex items-center cursor-pointer">
                                            <form action="{{ route('bookings.update-status', $booking->id) }}" method="POST"
                                                id="payment-form-{{ $booking->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="is_paid" value="0">
                                                <input type="checkbox" name="is_paid" value="1"
                                                    onchange="document.getElementById('payment-form-{{ $booking->id }}').submit()"
                                                    class="sr-only peer" {{ $booking->is_paid ? 'checked' : '' }}>
                                                <div
                                                    class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-pink-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-pink-500">
                                                </div>
                                                <span
                                                    class="ms-2 text-xs font-medium text-gray-900">{{ $booking->is_paid ? 'Đã TT' : 'Chưa TT' }}</span>
                                            </form>
                                        </label>
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
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('bookings.show', $booking->id) }}"
                                            class="text-gray-400 hover:text-pink-600 transition-colors" title="Xem chi tiết">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.644C3.301 8.844 6.471 6 10 6c3.529 0 6.699 2.844 7.964 5.678a1.012 1.012 0 010 .644C16.699 15.156 13.529 18 10 18c-3.529 0-6.699-2.844-7.964-5.678z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>

                                        {{-- Delete Button --}}
                                        <form method="POST" action="{{ route('bookings.destroy', $booking->id) }}"
                                            class="inline-block"
                                            onsubmit="return confirm('Xác nhận xóa đặt lịch này? (Có thể khôi phục sau)')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-gray-400 hover:text-red-600 transition-colors pt-1" title="Xóa">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center bg-gray-50">
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

        {{-- Hidden Bulk Delete Form --}}
        <form id="bulk-delete-form" method="POST" action="{{ route('bookings.bulk-delete') }}" style="display:none"
            onsubmit="return confirm('Bạn có chắc chắn muốn xóa các mục đã chọn không?')">
            @csrf
            @method('DELETE')
        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCountBadge = document.getElementById('selected-count-badge');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');

            function updateBulkActionState() {
                const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
                const count = checkedBoxes.length;

                // Xóa input cũ trong form
                const existingInputs = bulkDeleteForm.querySelectorAll('input[name="booking_ids[]"]');
                existingInputs.forEach(input => input.remove());

                if (count > 0) {
                    bulkDeleteBtn.style.display = 'inline-flex';
                    if (selectedCountBadge) selectedCountBadge.textContent = count;

                    // Tạo input mới với tên booking_ids[]
                    checkedBoxes.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'booking_ids[]';
                        input.value = cb.value;
                        bulkDeleteForm.appendChild(input);
                    });
                } else {
                    bulkDeleteBtn.style.display = 'none';
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', () => {
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    updateBulkActionState();
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateBulkActionState);
            });
        });
    </script>

@endsection