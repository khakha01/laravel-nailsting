@extends('admin.layouts.layout')

@section('title', 'Booking Date Management')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">

        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Quản lý lịch làm việc
                </h2>
                <p class="mt-1 text-sm text-gray-500">Cấu hình ngày và khung giờ hoạt động của hệ thống.</p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0 gap-2">
                {{-- Nút Xóa Nhiều (Logic mới: Ẩn mặc định, hiện khi có chọn) --}}
                <button type="submit" form="bulk-delete-form" id="bulkDeleteBtn" style="display: none;"
                    class="inline-flex items-center rounded-md bg-[#e80707] px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Xóa đã chọn <span id="selected-count-badge" class="ml-1 bg-white text-red-600 py-0.5 px-2 rounded-full text-xs font-bold">0</span>
                </button>

                <a href="{{ route('booking-dates.create') }}"
                    class="inline-flex items-center rounded-md bg-[#0c8fe1] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-pink-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600 transition-all duration-200">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Thêm ngày mới
                </a>
            </div>
        </div>

        {{-- Success --}}
        @if (session('success'))
            @include('admin.components.alert', ['type' => 'success', 'message' => session('success')])
        @endif

        {{-- Error --}}
        @if (session('error'))
            @include('admin.components.alert', ['type' => 'error', 'message' => session('error')])
        @endif


        {{-- Filter Section --}}
        <form method="GET" class="mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">

                <div class="mb-4 flex items-center gap-2 text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#0c8fe1]" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="font-semibold text-sm uppercase tracking-wide">Bộ lọc tìm kiếm</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

                    <div class="md:col-span-4">
                        <label class="block text-xs font-medium text-gray-500 uppercase mb-1.5 ml-1">
                            Ngày booking
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                {{-- Icon Calendar --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" name="date" value="{{ request('date') }}"
                                class="w-full pl-10 rounded-lg border-gray-200 bg-gray-50 text-gray-700 focus:bg-white focus:border-pink-500 focus:ring-pink-500 sm:text-sm h-10 transition-colors">
                        </div>
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-xs font-medium text-gray-500 uppercase mb-1.5 ml-1">
                            Trạng thái
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <select name="is_open"
                                class="w-full pl-10 rounded-lg border-gray-200 bg-gray-50 text-gray-700 focus:bg-white focus:border-pink-500 focus:ring-pink-500 sm:text-sm h-10 transition-colors appearance-none">
                                <option value="">Tất cả trạng thái</option>
                                <option value="1" {{ request('is_open') === '1' ? 'selected' : '' }}>Đang mở</option>
                                <option value="0" {{ request('is_open') === '0' ? 'selected' : '' }}>Đã đóng</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-4 flex items-center gap-2">
                        <button type="submit"
                            class="inline-flex justify-center items-center gap-2 rounded-lg bg-[#000] px-4 h-10 text-sm font-medium text-white shadow-sm hover:bg-[#0c8fe1] focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                            Lọc
                        </button>

                        <a href="{{ route('booking-dates.index') }}"
                            class="inline-flex justify-center items-center rounded-lg border border-gray-200 bg-white px-4 h-10 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-pink-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset
                        </a>
                    </div>
                </div>
            </div>

        </form>

        {{-- Main Table Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">
                                <input type="checkbox" id="select-all" class="h-4 w-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Ngày / Thứ
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Trạng thái
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Khung giờ hoạt động
                            </th>
                            <th scope="col" class="relative px-6 py-4">
                                <span class="sr-only">Thao tác</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($dates as $date)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{-- Checkbox Row --}}
                                    <input type="checkbox" class="booking-date-checkbox h-4 w-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500" value="{{ $date->id }}">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-pink-50 text-pink-600 font-bold border border-pink-100">
                                            {{ $date->date->format('d') }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $date->date->format('d/m/Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $date->date->format('l') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($date->is_open)
                                        <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                            <span class="w-1.5 h-1.5 bg-green-600 rounded-full mr-1.5"></span>
                                            Đang mở
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                            <span class="w-1.5 h-1.5 bg-red-600 rounded-full mr-1.5"></span>
                                            Đã đóng
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    @if ($date->timeSlots->isEmpty())
                                        <span class="text-sm text-gray-400 italic flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            Chưa cấu hình
                                        </span>
                                    @else
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($date->timeSlots as $slot)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-sm font-medium border {{ $slot->is_open ? 'bg-gray-50 text-gray-700 border-gray-200' : 'bg-red-50 text-red-400 border-red-100 line-through decoration-red-400' }}">
                                                    {{ $slot->start_time->format('H:i') }} -
                                                    {{ $slot->end_time->format('H:i') }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('booking-dates.show', $date->id) }}"
                                            class="text-gray-400 hover:text-indigo-600 transition-colors"
                                            title="Chỉnh sửa">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </a>

                                        {{-- Delete Button --}}
                                        <form method="POST" action="{{ route('booking-dates.destroy', $date->id) }}"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa ngày làm việc này không? Hành động này không thể hoàn tác.')"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors pt-1" title="Xóa">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center bg-gray-50">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">Chưa có ngày làm việc nào được cấu hình.</p>
                                        <a href="{{ route('booking-dates.create') }}" class="mt-3 text-sm font-medium text-pink-600 hover:text-pink-500 hover:underline">
                                            Thêm ngày đầu tiên
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="border-t border-gray-200 bg-gray-50 px-4 py-3 sm:px-6">
                    {{ $dates->withQueryString()->links() }}
                </div>

            </div>
        </div>

        {{-- Hidden Bulk Delete Form --}}
        <form id="bulk-delete-form" method="POST" action="{{ route('booking-dates.bulk-delete') }}" style="display:none"
        onsubmit="return confirm('Bạn có chắc chắn muốn xóa các ngày đã chọn không?')">
        @csrf
        @method('DELETE')
    </form>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.booking-date-checkbox');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const selectedCountBadge = document.getElementById('selected-count-badge');
        const bulkDeleteForm = document.getElementById('bulk-delete-form');

        function updateBulkActionState() {
            const checkedBoxes = document.querySelectorAll('.booking-date-checkbox:checked');
            const count = checkedBoxes.length;

            // 1. Xóa các input hidden cũ trong form để tránh trùng lặp
            const existingInputs = bulkDeleteForm.querySelectorAll('input[name="booking_date_ids[]"]');
            existingInputs.forEach(input => input.remove());

            if (count > 0) {
                // Hiện nút và cập nhật số lượng
                bulkDeleteBtn.style.display = 'inline-flex';
                // Kiểm tra nếu có badge thì mới update text (phòng trường hợp HTML thiếu badge)
                if(selectedCountBadge) selectedCountBadge.textContent = count;

                // 2. Tạo input hidden mới cho từng dòng đã chọn
                // name="booking_date_ids[]" (có ngoặc vuông) giúp Laravel hiểu là Array
                checkedBoxes.forEach(cb => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'booking_date_ids[]'; // <-- Quan trọng: tên biến khớp với Controller
                    input.value = cb.value;
                    bulkDeleteForm.appendChild(input);
                });
            } else {
                // Ẩn nút nếu không chọn gì
                bulkDeleteBtn.style.display = 'none';
            }
        }

        // Sự kiện cho nút "Chọn tất cả"
        if(selectAll) {
            selectAll.addEventListener('change', () => {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateBulkActionState();
            });
        }

        // Sự kiện cho từng checkbox dòng
        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateBulkActionState);
        });
    });
</script>
@endsection
