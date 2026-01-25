@extends('admin.layouts.layout')
@section('title', 'Thêm Ngày Làm Việc')

@section('content')
    <div class="min-h-screen bg-[#f8fafc] pb-12">
        {{-- Top Bar: Sticky --}}
        <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('booking-dates.index') }}"
                            class="p-2 rounded-full hover:bg-slate-100 text-slate-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Thêm Ngày Làm Việc Mới</h2>
                            <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Booking Date Management
                                System</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="window.location='{{ route('booking-dates.index') }}'"
                            class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-gray-300 rounded-lg hover:bg-slate-50 shadow-sm transition-all">
                            Hủy
                        </button>
                        <button type="submit" form="main-booking-form"
                            class="px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md shadow-blue-200 transition-all">
                            Lưu thay đổi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form id="main-booking-form" method="POST" action="{{ route('booking-dates.store') }}">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    {{-- Cột Trái: Content --}}
                    <div class="lg:col-span-8 space-y-8">
                        {{-- Card 1: Thông tin chung --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                                    Thông tin chung
                                </h3>
                            </div>

                            <div class="p-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">Ngày áp dụng <span
                                            class="text-red-500">*</span></label>
                                    <input type="date" name="date" id="date" min="{{ date('Y-m-d') }}" required
                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900">
                                </div>
                            </div>
                        </div>

                        {{-- Card 2: Cấu hình Slot --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div
                                class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 flex justify-between items-center">
                                <div>
                                    <h3 class="font-bold text-slate-800">Cấu hình khung giờ</h3>
                                    <p class="mt-1 text-xs text-slate-500">Thêm các khoảng thời gian khách có thể đặt.</p>
                                </div>
                                <button type="button" id="addSlotBtn"
                                    class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-all">
                                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                    </svg>
                                    Thêm khung giờ
                                </button>
                            </div>

                            <div class="p-6 bg-slate-50/50 min-h-[150px]">
                                <div id="slotsContainer" class="space-y-3"></div>
                                <div id="noSlotsMsg" class="text-center py-10 hidden">
                                    <div
                                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-3">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-500">Chưa có khung giờ nào được tạo.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Cột Phải: Sidebar --}}
                    <div class="lg:col-span-4 space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                                Cài đặt hiển thị
                            </h3>

                            <div
                                class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <div>
                                    <p class="text-sm font-bold text-slate-700">Trạng thái</p>
                                    <p class="text-xs text-slate-500">Cho phép đặt lịch</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_open" value="1" checked class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg shadow-blue-200 p-6 text-white">
                            <h3 class="font-bold mb-2">Sẵn sàng tạo?</h3>
                            <p class="text-blue-100 text-sm mb-4">Kiểm tra kỹ các thông tin trước khi lưu.</p>
                            <button type="submit" form="main-booking-form"
                                class="w-full py-3 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-colors shadow-md">
                                Xác nhận Lưu
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('slotsContainer');
            const noSlotsMsg = document.getElementById('noSlotsMsg');
            const addBtn = document.getElementById('addSlotBtn');
            let slotCounter = 0;

            function checkEmpty() {
                if (container.children.length === 0) {
                    noSlotsMsg.classList.remove('hidden');
                } else {
                    noSlotsMsg.classList.add('hidden');
                }
            }

            function addTimeSlot() {
                const index = slotCounter++;
                const slotDiv = document.createElement('div');
                slotDiv.className = 'group relative bg-white p-4 rounded-lg border border-gray-200 shadow-sm transition-all hover:shadow-md hover:border-blue-200 flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between';
                slotDiv.innerHTML = `
                        <div class="flex items-center gap-4 flex-1 w-full sm:w-auto">
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Bắt đầu</label>
                                <input type="time" name="time_slots[${index}][start]" required
                                       class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                            </div>
                            <div class="text-gray-400 mt-5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Kết thúc</label>
                                <input type="time" name="time_slots[${index}][end]" required
                                       class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-end">
                            <div class="w-32">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Trạng thái</label>
                                <select name="time_slots[${index}][is_open]" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    <option value="1" selected>Mở</option>
                                    <option value="0">Đóng</option>
                                </select>
                            </div>
                            <div class="flex items-end h-full mt-5">
                                <button type="button" class="remove-btn p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `;
                container.appendChild(slotDiv);
                checkEmpty();
                slotDiv.querySelector('.remove-btn').addEventListener('click', () => {
                    if (container.children.length <= 1) {
                        alert('Phải có ít nhất một khung giờ hoạt động!');
                        return;
                    }
                    slotDiv.remove();
                    checkEmpty();
                });
            }

            addBtn.addEventListener('click', addTimeSlot);
            addTimeSlot();
        });
    </script>

@endsection