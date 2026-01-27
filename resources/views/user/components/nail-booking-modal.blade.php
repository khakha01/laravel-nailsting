{{-- Nail Booking Modal --}}
<div id="nail-booking-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
            onclick="closeNailBookingModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        {{-- Modal Container - Increased max-width to 3xl for better 2-column layout --}}
        <div
            class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border border-gray-100">

            <form id="nail-booking-form" action="{{ route('nail-booking.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                {{-- Hidden Fields --}}
                <input type="hidden" name="nail_id" id="nail_id">
                <input type="hidden" name="nail_price" id="nail_price">
                <input type="hidden" name="booking_date" id="nail_booking_date">
                <input type="hidden" name="booking_time" id="nail_booking_time">
                <input type="hidden" name="customer_email" id="nail_customer_email"> {{-- Hidden email field --}}

                {{-- Step 1: Customer Info & Booking Time --}}
                <div id="nail-step-1-content">
                    <div class="bg-white px-6 pt-8 pb-4">
                        {{-- Header Section - Thanh thoát --}}
                        <div class="flex items-center justify-between mb-6 px-1">
                            <h3 class="text-lg font-bold text-gray-800 tracking-tight">Đặt lịch dịch vụ</h3>
                            <span
                                class="text-[9px] font-semibold text-pink-500 bg-pink-50 px-2.5 py-1 rounded-md uppercase tracking-widest border border-pink-100">Bước
                                1/2</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                            {{-- CỘT TRÁI: DỊCH VỤ & THÔNG TIN KHÁCH HÀNG --}}
                            <div class="md:col-span-5 space-y-4">
                                <div class="bg-gray-50 rounded-[1.5rem] p-5 border border-gray-100/80 shadow-sm">
                                    {{-- Thông tin sản phẩm --}}
                                    <div class="flex items-center gap-4 mb-5 pb-5 border-b border-gray-200/50">
                                        <img id="modal_nail_image" src="" alt="Nail"
                                            class="w-14 h-14 rounded-xl object-cover shadow-sm bg-white ring-2 ring-white">
                                        <div class="flex-1 min-w-0">
                                            <h4 id="modal_nail_name"
                                                class="font-semibold text-gray-800 text-sm truncate"></h4>
                                            <p class="text-[11px] text-gray-500 mt-0.5">Giá niêm yết: <span
                                                    id="modal_nail_price" class="text-pink-600 font-bold"></span></p>
                                        </div>
                                    </div>

                                    {{-- Form nhập liệu --}}
                                    <div class="space-y-3.5">
                                        <div class="relative">
                                            <label
                                                class="text-[10px] font-medium text-gray-400 uppercase tracking-widest mb-1 block ml-1">Họ
                                                tên khách hàng</label>
                                            <input type="text" name="customer_name" id="nail_customer_name"
                                                placeholder="Tên của bạn..." required
                                                class="w-full rounded-xl border-gray-100 bg-white p-2.5 text-sm focus:ring-2 focus:ring-pink-100 focus:border-pink-300 outline-none transition-all shadow-sm">
                                        </div>
                                        <div class="relative">
                                            <label
                                                class="text-[10px] font-medium text-gray-400 uppercase tracking-widest mb-1 block ml-1">Số
                                                điện thoại</label>
                                            <input type="tel" name="customer_phone" id="nail_customer_phone"
                                                placeholder="Số điện thoại..." required
                                                class="w-full rounded-xl border-gray-100 bg-white p-2.5 text-sm focus:ring-2 focus:ring-pink-100 focus:border-pink-300 outline-none transition-all shadow-sm">
                                        </div>
                                        <input type="hidden" name="customer_email" id="nail_customer_email">
                                    </div>
                                </div>
                            </div>

                            {{-- CỘT PHẢI: LỊCH TRÌNH & GHI CHÚ --}}
                            <div class="md:col-span-7 space-y-4">
                                <div
                                    class="bg-gray-50 rounded-[1.5rem] p-5 border border-gray-100/80 shadow-sm flex flex-col h-full">
                                    <label
                                        class="text-[10px] font-medium text-gray-400 uppercase tracking-widest mb-3 block ml-1">Chọn
                                        thời gian giữ chỗ</label>

                                    {{-- Chọn Ngày --}}
                                    <div class="flex space-x-2 overflow-x-auto pb-3 scrollbar-hide select-none"
                                        id="nail-date-list">
                                        @foreach($availableDates as $date)
                                            <div class="nail-date-item flex-shrink-0 w-11 bg-white rounded-xl py-2.5 text-center cursor-pointer hover:shadow-sm transition-all group border border-gray-100"
                                                onclick="selectNailBookingDate('{{ $date->date->format('Y-m-d') }}', this)">
                                                <span
                                                    class="block text-[8px] text-gray-400 font-medium uppercase group-hover:text-pink-400">{{ $date->date->format('D') }}</span>
                                                <span
                                                    class="block text-sm font-bold text-gray-700 group-hover:text-pink-600">{{ $date->date->format('d') }}</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Chọn Giờ (Hiển thị Bắt đầu - Kết thúc) --}}
                                    <div class="mt-2 flex-1">
                                        <div id="nail-slots-placeholder"
                                            class="h-24 flex items-center justify-center bg-white/50 rounded-xl border border-dashed border-gray-200 text-[11px] text-gray-400 px-4 text-center">
                                            Vui lòng chọn ngày để xem lịch trống
                                        </div>

                                        @foreach($availableDates as $date)
                                            <div class="nail-time-slots-group hidden flex flex-wrap gap-2"
                                                id="nail-slots-{{ $date->date->format('Y-m-d') }}">
                                                @forelse($date->timeSlots->where('is_open', true) as $slot)
                                                    <div class="nail-slot-item px-3 py-2 bg-white rounded-lg text-[10px] font-semibold text-gray-600 hover:text-pink-600 shadow-sm cursor-pointer transition-all border border-gray-100 active:scale-95"
                                                        onclick="selectNailBookingTime('{{ $slot->start_time->format('H:i') }}', this)">
                                                        {{ $slot->start_time->format('H:i') }} -
                                                        {{ $slot->end_time->format('H:i') }}
                                                    </div>
                                                @empty
                                                    <div
                                                        class="w-full py-8 text-center text-[11px] text-red-400 font-medium bg-red-50/30 rounded-xl">
                                                        Rất tiếc, hôm nay đã hết chỗ</div>
                                                @endforelse
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Ghi chú --}}
                                    <div class="mt-4 pt-4 border-t border-gray-200/50">
                                        <textarea name="notes" id="nail_notes" rows="1"
                                            placeholder="Ghi chú thêm yêu cầu..."
                                            class="w-full rounded-xl border-transparent bg-white/80 p-2.5 text-xs focus:ring-2 focus:ring-pink-100 outline-none transition-all shadow-sm resize-none"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Footer mini: Terms (Đã làm to hơn) --}}
                        <div class="mt-6 flex justify-center">
                            <label
                                class="flex items-center cursor-pointer group bg-pink-50/50 px-5 py-3 rounded-2xl border border-pink-100/50 transition-all hover:bg-pink-50">
                                <input type="checkbox" name="terms_accepted" id="nail_terms_accepted" value="1" required
                                    onchange="toggleNailPaymentButton()"
                                    class="h-5 w-5 rounded border-gray-300 text-pink-500 focus:ring-pink-200 transition-all shadow-sm cursor-pointer">
                                <span
                                    class="ml-3 text-sm font-medium text-gray-600 group-hover:text-pink-700 transition-colors">Tôi
                                    xác nhận thông tin trên là chính xác</span>
                            </label>
                        </div>
                    </div>

                    {{-- Nút bấm chính --}}
                    <div class="px-6 pb-8 pt-2 flex flex-col sm:flex-row-reverse gap-3">
                        <button type="button" id="nail_proceed_payment_btn" onclick="proceedToNailPayment()" disabled
                            class="w-full sm:w-auto px-10 py-3 bg-gray-200 text-gray-500 text-sm font-bold rounded-xl transition-all shadow-md shadow-gray-200/50 cursor-not-allowed uppercase tracking-wider">
                            Tiếp theo
                        </button>
                        <button type="button" onclick="closeNailBookingModal()"
                            class="w-full sm:w-auto px-8 py-3 bg-white text-gray-400 text-sm font-semibold rounded-xl hover:text-gray-600 transition-all">
                            Hủy bỏ
                        </button>
                    </div>
                </div>


                {{-- Step 2: Payment (KEEP ORIGINAL UI AS REQUESTED) --}}
                <div id="nail-step-2-content" class="hidden">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-2">Thanh toán tiền cọc</h3>
                        <p class="text-sm text-gray-600 mb-6">Vui lòng chuyển khoản cọc 50,000đ để giữ lịch.</p>

                        <div class="flex justify-center mb-6">
                            <img id="nail-vietqr-image" src="" alt="VietQR Payment"
                                class="w-64 h-auto object-contain shadow-lg rounded-xl border border-gray-200">
                        </div>

                        <div class="space-y-1">
                            <p class="text-sm font-bold text-pink-600">Số tiền: 50,000đ</p>
                            <p class="text-xs text-gray-500">Nội dung: <span id="nail-payment-content">...</span></p>
                        </div>

                        <div class="mt-4 text-left">
                            <label class="block text-sm font-medium text-gray-700 mb-2">📸 Tải lên ảnh giao dịch
                                (Bill)</label>
                            <input type="file" name="payment_proof" id="nail_payment_proof_upload" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 transition-all border border-gray-200 rounded-lg p-1">
                            <p class="text-xs text-gray-400 mt-1">*Vui lòng upload ảnh chụp màn hình chuyển khoản thành
                                công</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" onclick="submitNailBooking()"
                            class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                            Hoàn tất & Gửi bill
                        </button>
                        <button type="button" onclick="closeNailBookingModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                            Hủy
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    let selectedNailData = {};

    function openNailBookingModal(nailId, nailName, nailImage, nailPrice, priceDisplay) {
        selectedNailData = {
            id: nailId,
            name: nailName,
            image: nailImage,
            price: nailPrice,
            priceDisplay: priceDisplay
        };

        // Fill modal with nail info
        document.getElementById('nail_id').value = nailId;
        document.getElementById('nail_price').value = nailPrice;
        document.getElementById('modal_nail_name').textContent = nailName;
        document.getElementById('modal_nail_price').textContent = priceDisplay;
        document.getElementById('modal_nail_image').src = nailImage;

        // Reset form
        document.getElementById('nail-booking-form').reset();
        document.getElementById('nail_booking_date').value = '';
        document.getElementById('nail_booking_time').value = '';

        // Reset date/time selection UI
        document.querySelectorAll('.nail-date-item').forEach(el => {
            el.classList.remove('border-pink-500', 'bg-pink-50', 'ring-1', 'ring-pink-500');
            el.classList.add('bg-white', 'border-gray-100');
        });
        document.querySelectorAll('.nail-slot-item').forEach(el => {
            el.classList.remove('bg-pink-500', 'text-white', 'border-pink-500');
            el.classList.add('bg-white', 'text-gray-600', 'border-gray-100');
        });
        document.getElementById('nail-slots-placeholder').style.display = 'block';
        document.querySelectorAll('.nail-time-slots-group').forEach(el => el.classList.add('hidden'));

        // Reset steps
        document.getElementById('nail-step-1-content').classList.remove('hidden');
        document.getElementById('nail-step-2-content').classList.add('hidden');

        // Show modal
        document.getElementById('nail-booking-modal').classList.remove('hidden');
    }

    function closeNailBookingModal() {
        document.getElementById('nail-booking-modal').classList.add('hidden');
    }

    function selectNailBookingDate(dateStr, element) {
        document.getElementById('nail_booking_date').value = dateStr;
        document.getElementById('nail_booking_time').value = '';

        document.querySelectorAll('.nail-date-item').forEach(el => {
            el.classList.remove('border-pink-500', 'bg-pink-50', 'ring-1', 'ring-pink-500');
            el.classList.add('bg-white', 'border-gray-100');
        });
        element.classList.remove('bg-white', 'border-gray-100');
        element.classList.add('border-pink-500', 'bg-pink-50', 'ring-1', 'ring-pink-500');

        document.getElementById('nail-slots-placeholder').style.display = 'none';
        document.querySelectorAll('.nail-time-slots-group').forEach(el => el.classList.add('hidden'));

        const targetSlots = document.getElementById('nail-slots-' + dateStr);
        if (targetSlots) {
            targetSlots.classList.remove('hidden');
        }

        document.querySelectorAll('.nail-slot-item').forEach(el => {
            el.classList.remove('bg-pink-500', 'text-white', 'border-pink-500');
            el.classList.add('bg-white', 'text-gray-600', 'border-gray-100');
        });
    }

    function selectNailBookingTime(timeStr, element) {
        document.getElementById('nail_booking_time').value = timeStr;

        document.querySelectorAll('.nail-slot-item').forEach(el => {
            el.classList.remove('bg-pink-500', 'text-white', 'border-pink-500');
            el.classList.add('bg-white', 'text-gray-600', 'border-gray-100');
        });
        element.classList.remove('bg-white', 'text-gray-600', 'border-gray-100');
        element.classList.add('bg-pink-500', 'text-white', 'border-pink-500');
    }

    function toggleNailPaymentButton() {
        const termsAccepted = document.getElementById('nail_terms_accepted').checked;
        const paymentBtn = document.getElementById('nail_proceed_payment_btn');

        if (termsAccepted) {
            paymentBtn.disabled = false;
            paymentBtn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
            paymentBtn.classList.add('bg-pink-600', 'text-white', 'hover:bg-pink-700', 'cursor-pointer');
        } else {
            paymentBtn.disabled = true;
            paymentBtn.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
            paymentBtn.classList.remove('bg-pink-600', 'text-white', 'hover:bg-pink-700', 'cursor-pointer');
        }
    }

    function proceedToNailPayment() {
        // Validate inputs
        const name = document.getElementById('nail_customer_name').value;
        const phone = document.getElementById('nail_customer_phone').value;
        const date = document.getElementById('nail_booking_date').value;
        const time = document.getElementById('nail_booking_time').value;

        if (!name || !phone || !date || !time) {
            alert('Vui lòng điền đầy đủ thông tin và chọn thời gian!');
            return;
        }

        const BANK_ID = 'MB';
        const ACCOUNT_NO = '0353123771';
        const ACCOUNT_NAME = 'HUYNH KHA';
        const TEMPLATE = 'compact';
        const depositAmount = 50000;

        const content = `NAIL ${phone}`;
        document.getElementById('nail-payment-content').textContent = content;

        const qrUrl = `https://img.vietqr.io/image/${BANK_ID}-${ACCOUNT_NO}-${TEMPLATE}.png?amount=${depositAmount}&addInfo=${encodeURIComponent(content)}&accountName=${encodeURIComponent(ACCOUNT_NAME)}`;
        document.getElementById('nail-vietqr-image').src = qrUrl;

        // Switch to Step 2
        document.getElementById('nail-step-1-content').classList.add('hidden');
        document.getElementById('nail-step-2-content').classList.remove('hidden');
    }

    function submitNailBooking() {
        const form = document.getElementById('nail-booking-form');
        const formData = new FormData(form);

        const submitBtn = event.target;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

        // Get CSRF token from meta tag or form
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
            document.querySelector('input[name="_token"]')?.value;

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Đặt lịch nail thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất.');
                    closeNailBookingModal();
                    window.location.reload();
                } else {
                    alert(data.message || 'Có lỗi xảy ra, vui lòng thử lại!');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Hoàn tất & Gửi bill';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi gửi yêu cầu!');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Hoàn tất & Gửi bill';
            });
    }
</script>