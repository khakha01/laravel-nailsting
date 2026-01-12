@extends('admin.layouts.layout')
@section('title', 'Create Booking Date')

@section('content')
<form method="POST" action="{{route('booking-dates.store')}}">
    @csrf

    <!-- Ngày -->
    <div class="mb-4">
        <label class="block font-semibold mb-1">Ngày</label>
        <input type="date" name="date"
               class="border rounded w-full px-3 py-2"
               required>
    </div>

    <!-- Mở ngày -->
    <div class="mb-6">
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_open" value="1" checked>
            <span class="ml-2">Mở ngày này</span>
        </label>
    </div>

    <!-- Khung giờ -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-bold">Khung giờ</h3>
        <button type="button" id="addSlotBtn"
                class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
            + Thêm khung giờ
        </button>
    </div>

    <div id="slotsContainer" class="space-y-3">
        <!-- Các slot sẽ được JS thêm vào đây -->
    </div>

    <div id="noSlotsMsg" class="text-center text-gray-500 py-4 hidden">
        Chưa có khung giờ nào. Nhấn "Thêm khung giờ" để bắt đầu.
    </div>

    <button type="submit" class="mt-8 bg-pink-600 text-white px-8 py-3 rounded hover:bg-pink-700">
        Lưu
    </button>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('slotsContainer');
    const noSlotsMsg = document.getElementById('noSlotsMsg');
    const addBtn = document.getElementById('addSlotBtn');

    let slotCounter = 0;

    // Hàm tạo một slot mới
    function addTimeSlot() {
        const index = slotCounter++;
        const slotDiv = document.createElement('div');
        slotDiv.className = 'grid grid-cols-4 gap-2 items-center bg-gray-50 p-3 rounded border';

        slotDiv.innerHTML = `
            <input type="time"
                   name="time_slots[${index}][start]"
                   class="border px-2 py-1 rounded"
                   required>

            <input type="time"
                   name="time_slots[${index}][end]"
                   class="border px-2 py-1 rounded"
                   required>

            <select name="time_slots[${index}][is_open]"
                    class="border px-2 py-1 rounded">
                <option value="1" selected>Mở</option>
                <option value="0">Đóng</option>
            </select>

            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Slot ${index + 1}</span>
                <button type="button" class="remove-btn text-red-600 hover:text-red-800 text-sm font-medium">
                    Xóa
                </button>
            </div>
        `;

        container.appendChild(slotDiv);
        noSlotsMsg.classList.add('hidden');

        // Gắn sự kiện xóa cho nút vừa thêm
        slotDiv.querySelector('.remove-btn').addEventListener('click', () => {
            if (container.children.length <= 1) {
                alert('Phải có ít nhất một khung giờ!');
                return;
            }
            slotDiv.remove();

            if (container.children.length === 0) {
                noSlotsMsg.classList.remove('hidden');
            }
        });
    }

    // Sự kiện nút Thêm
    addBtn.addEventListener('click', addTimeSlot);

    // Tùy chọn: Thêm 1 slot mặc định khi load form
    addTimeSlot();
});
</script>
@endsection
