@extends('admin.layouts.layout')
@section('title', 'Edit Booking Date')

@section('content')
<div class="max-w-4xl mx-left px-4 py-10 bg-gray-50 min-h-screen">

    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
            Chỉnh sửa ngày làm việc
        </h2>
        <p class="mt-1 text-sm text-gray-500">Cập nhật thông tin ngày và điều chỉnh các khung giờ hoạt động.</p>
    </div>

    <form method="POST" action="{{ route('booking-dates.update', $bookingDate->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Card 1: Thông tin chung --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Thông tin chung</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Date Input --}}
                <div>
                    <label for="date" class="block text-sm font-medium leading-6 text-gray-900 mb-2">Ngày áp dụng</label>
                    <div class="relative">
                        <input type="date" name="date" id="date" required
                               value="{{ old('date', $bookingDate->date->format('Y-m-d')) }}"
                               class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                {{-- Status Toggle --}}
                <div class="flex items-center h-full pt-6">
                    <label class="relative inline-flex items-center cursor-pointer group">
                        <input type="checkbox" name="is_open" value="1"
                               {{ old('is_open', $bookingDate->is_open) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-pink-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 group-hover:text-green-700 transition-colors">Đang mở (Cho phép đặt lịch)</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Card 2: Cấu hình Slot --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <div>
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Cấu hình khung giờ</h3>
                    <p class="mt-1 text-xs text-gray-500">Thêm hoặc xóa các khoảng thời gian.</p>
                </div>
                <button type="button" id="addSlotBtn"
                        class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-pink-600 shadow-sm ring-1 ring-inset ring-pink-300 hover:bg-pink-50 transition-all">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Thêm khung giờ
                </button>
            </div>

            <div class="p-6 bg-gray-50/50 min-h-[150px]">
                <div id="slotsContainer" class="space-y-3">
                    @forelse( $bookingDate->timeSlots as $index => $slot)
                        {{-- Existing Slot Item --}}
                        <div class="group relative bg-white p-4 rounded-lg border border-gray-200 shadow-sm transition-all hover:shadow-md hover:border-pink-200 flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between slot-item">
                            <div class="flex items-center gap-4 flex-1 w-full sm:w-auto">
                                {{-- Start Time --}}
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Bắt đầu</label>
                                    <input type="time" name="time_slots[{{ $index }}][start]" required
                                           value="{{ old("time_slots.$index.start", optional($slot->start_time)->format('H:i')) }}"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                </div>

                                <div class="text-gray-400 mt-5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </div>

                                {{-- End Time --}}
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Kết thúc</label>
                                    <input type="time" name="time_slots[{{ $index }}][end]" required
                                           value="{{ old("time_slots.$index.end", optional($slot->end_time)->format('H:i')) }}"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div class="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-end border-t sm:border-t-0 border-gray-100 pt-3 sm:pt-0 mt-2 sm:mt-0">
                                {{-- Status Select --}}
                                <div class="w-32">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Trạng thái</label>
                                    <select name="time_slots[{{ $index }}][is_open]"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                        <option value="1" {{ old("time_slots.$index.is_open", $slot->is_open) ? 'selected' : '' }}>Mở</option>
                                        <option value="0" {{ !old("time_slots.$index.is_open", $slot->is_open) ? 'selected' : '' }}>Đóng</option>
                                    </select>
                                </div>

                                {{-- Delete Button --}}
                                <div class="flex items-end h-full mt-5">
                                    <button type="button" class="remove-btn p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors" title="Xóa slot này">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Empty State --}}
                        <div id="noSlotsMsg" class="text-center py-10">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500">Chưa có khung giờ nào.</p>
                            <p class="text-xs text-gray-400">Nhấn nút "Thêm khung giờ" để bắt đầu.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end gap-x-4 pt-4 border-t border-gray-200">
            <a href="{{ route('booking-dates.index') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">Hủy bỏ</a>
            <button type="submit" class="rounded-md bg-pink-600 px-8 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-pink-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600 transition-all">
                Cập nhật thay đổi
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('slotsContainer');
        const addBtn = document.getElementById('addSlotBtn');
        const noSlotsMsg = document.getElementById('noSlotsMsg');

        // Bắt đầu counter dựa trên số lượng slot đã có sẵn để tránh trùng index name
        let slotCounter = document.querySelectorAll('.slot-item').length;

        // Hàm kiểm tra và ẩn hiện thông báo rỗng
        function checkEmpty() {
            const currentSlots = container.querySelectorAll('.slot-item').length;
            if (noSlotsMsg) {
                 if (currentSlots > 0) {
                    noSlotsMsg.classList.add('hidden');
                } else {
                    noSlotsMsg.classList.remove('hidden');
                }
            }
        }

        // Gắn sự kiện xóa cho các slot ĐÃ CÓ SẴN (Render từ Server)
        container.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Tìm đến thẻ cha div.slot-item để xóa
                this.closest('.slot-item').remove();
                checkEmpty();
            });
        });

        // Hàm tạo slot mới (Giống hệt trang Create nhưng đồng bộ UI)
        function addTimeSlot() {
            const index = slotCounter++;
            const slotDiv = document.createElement('div');

            slotDiv.className = 'slot-item group relative bg-white p-4 rounded-lg border border-gray-200 shadow-sm transition-all hover:shadow-md hover:border-pink-200 flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between animate-fade-in-down';

            slotDiv.innerHTML = `
                <div class="flex items-center gap-4 flex-1 w-full sm:w-auto">
                    {{-- Start Time --}}
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Bắt đầu</label>
                        <input type="time" name="time_slots[${index}][start]" required
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                    </div>

                    <div class="text-gray-400 mt-5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </div>

                    {{-- End Time --}}
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Kết thúc</label>
                        <input type="time" name="time_slots[${index}][end]" required
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-end border-t sm:border-t-0 border-gray-100 pt-3 sm:pt-0 mt-2 sm:mt-0">
                    {{-- Status Select --}}
                    <div class="w-32">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Trạng thái</label>
                        <select name="time_slots[${index}][is_open]"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                            <option value="1" selected>Mở</option>
                            <option value="0">Đóng</option>
                        </select>
                    </div>

                    {{-- Delete Button --}}
                    <div class="flex items-end h-full mt-5">
                        <button type="button" class="remove-btn p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors" title="Xóa slot này">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;

            container.appendChild(slotDiv);
            checkEmpty();

            // Gắn sự kiện xóa cho slot MỚI vừa tạo
            slotDiv.querySelector('.remove-btn').addEventListener('click', () => {
                slotDiv.remove();
                checkEmpty();
            });
        }

        addBtn.addEventListener('click', addTimeSlot);

        // Chạy check lần đầu để ẩn thông báo nếu đã có data cũ
        checkEmpty();
    });
</script>

@endsection
