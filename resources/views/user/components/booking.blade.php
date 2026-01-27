<section id="booking-section" class="relative overflow-hidden">
    <div class="absolute top-0 left-0 w-96 h-96 bg-pink-100/30 rounded-full blur-[100px] -ml-48 -mt-48"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-100/20 rounded-full blur-[100px] -mr-48 -mb-48"></div>

    <form id="booking-form" action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data"
        class="relative z-10">
        @csrf
        <main class="max-w-2xl mx-auto py-8 space-y-6 antialiased">
            <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div
                            class="bg-pink-500 text-white w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold shadow-sm">
                            1</div>
                        <h2 class="text-lg font-bold text-gray-800">Thông tin đặt lịch</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                        <div class="relative">
                            <label
                                class="text-xs font-semibold text-pink-500 uppercase tracking-wider mb-1 block ml-1">Họ
                                và
                                tên</label>
                            <input type="text" name="customer_name" id="customer_name"
                                placeholder="Vui lòng nhập họ tên" required
                                class="w-full rounded-xl border-gray-100 bg-gray-50 p-3 focus:bg-white focus:ring-2 focus:ring-pink-200 focus:border-pink-400 outline-none transition-all">
                        </div>
                        <div class="relative">
                            <label
                                class="text-xs font-semibold text-pink-500 uppercase tracking-wider mb-1 block ml-1">Số
                                điện
                                thoại</label>
                            <input type="tel" name="customer_phone" id="customer_phone"
                                placeholder="Vui lòng nhập số điện thoại" required
                                class="w-full rounded-xl border-gray-100 bg-gray-50 p-3 focus:bg-white focus:ring-2 focus:ring-pink-200 focus:border-pink-400 outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between px-1">
                            <label class="text-[11px] font-bold text-pink-500 uppercase tracking-tight">Chọn thời
                                gian</label>
                        </div>

                        <input type="hidden" name="booking_date" id="selected_date">
                        <input type="hidden" name="booking_time" id="selected_time">

                        <div class="flex space-x-2 overflow-x-auto pb-1 scrollbar-hide" id="date-list">
                            @foreach($availableDates as $date)
                                <div class="date-item flex-shrink-0 w-12 bg-white border border-gray-100 rounded-xl py-2 text-center cursor-pointer hover:border-pink-300 transition-all group"
                                    onclick="selectBookingDate('{{ $date->date->format('Y-m-d') }}', this)">
                                    <span
                                        class="block text-[9px] text-gray-400 font-medium uppercase group-hover:text-pink-500">{{ $date->date->format('D') }}</span>
                                    <span
                                        class="block text-sm font-bold text-gray-700 group-hover:text-pink-600">{{ $date->date->format('d') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="relative">
                            <p id="slots-placeholder"
                                class="text-[11px] text-gray-400 text-center py-2 bg-gray-50/50 rounded-xl border border-dashed">
                                Vui lòng chọn ngày...
                            </p>

                            @foreach($availableDates as $date)
                                <div class="time-slots-group hidden flex flex-wrap gap-2 justify-start"
                                    id="slots-{{ $date->date->format('Y-m-d') }}">
                                    @forelse($date->timeSlots->where('is_open', true) as $slot)
                                        <div class="slot-item px-3 py-1.5 bg-white border border-gray-100 rounded-lg text-xs font-bold text-gray-600 hover:border-pink-400 hover:text-white-500 cursor-pointer transition-all shadow-sm"
                                            onclick="selectBookingTime('{{ $slot->start_time->format('H:i') }}', this)">
                                            {{ $slot->start_time->format('H:i') }} - {{ $slot->end_time->format('H:i') }}
                                        </div>
                                    @empty
                                        <p class="w-full text-[11px] text-red-400 text-center py-2">Đã kín lịch</p>
                                    @endforelse
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div
                            class="bg-pink-500 text-white w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold shadow-sm">
                            2</div>
                        <h2 class="text-lg font-bold text-gray-800">Chọn dịch vụ làm đẹp</h2>
                    </div>

                    <div class="space-y-6">
                        @foreach($bookingServices as $category)
                            @if($category->products->isNotEmpty())
                                <div>
                                    <h3
                                        class="text-[11px] font-bold text-pink-400 uppercase tracking-widest mb-3 flex items-center">
                                        {{ $category->name }}
                                        <div class="flex-grow h-[1px] bg-pink-100 ml-3"></div>
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @foreach($category->products as $product)
                                            <label
                                                class="group relative flex items-center justify-between p-3 rounded-xl border border-gray-50 bg-gray-50/50 hover:bg-white hover:border-pink-200 hover:shadow-md transition-all cursor-pointer">
                                                <div class="flex items-center space-x-3">
                                                    <div class="relative flex items-center justify-center">
                                                        <input type="checkbox" name="services[]" value="{{ $product->id }}"
                                                            data-price="{{ $product->prices->first()?->price ?? 0 }}"
                                                            data-name="{{ $product->name }}"
                                                            class="service-check w-5 h-5 text-pink-500 border-gray-200 rounded-lg focus:ring-pink-400 transition-all cursor-pointer">
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <span
                                                            class="text-sm font-semibold text-gray-700 group-hover:text-pink-600 transition-colors">{{ $product->name }}</span>
                                                        <span
                                                            class="text-[10px] text-gray-400 line-clamp-1">{{ Str::limit($product->description, 35) }}</span>
                                                    </div>
                                                </div>
                                                <span
                                                    class="text-sm font-bold text-gray-800 bg-white px-2 py-1 rounded-lg border border-gray-100 shadow-sm">{{ number_format($product->prices->first()?->price ?? 0, 0, ',', '.') }}đ</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="mt-8">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 block ml-1">Yêu
                            cầu
                            đặc
                            biệt</label>
                        <textarea name="notes" id="notes"
                            class="w-full rounded-xl border-gray-100 bg-gray-50 p-3 focus:bg-white focus:ring-2 focus:ring-pink-200 outline-none text-sm transition-all"
                            rows="2" placeholder="Ví dụ: Làm móng nhọn, mẫu đính đá..."></textarea>
                    </div>
                </div>

                <div
                    class="bg-white border-t border-pink-100 p-5 flex items-center justify-between shadow-[0_-10px_20px_-5px_rgba(255,182,193,0.2)]">
                    <div class="flex flex-col">
                        <input type="hidden" name="total_price" id="total_price_input" value="0">
                        <span class="text-[10px] text-pink-400 uppercase font-black tracking-widest">Tổng thanh
                            toán</span>
                        <span class="text-2xl font-black text-gray-800" id="total-price">0đ</span>
                    </div>
                    <button type="button" onclick="showConfirmationModal()"
                        class="bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold py-3 px-8 rounded-xl shadow-[0_4px_15px_rgba(244,63,94,0.3)] hover:shadow-none hover:translate-y-0.5 active:scale-95 transition-all uppercase text-sm tracking-wider">
                        Đặt lịch ngay
                    </button>
                </div>
            </div>
        </main>
    </form>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="hideConfirmationModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

                <!-- Step 1: Confirmation -->
                <div id="step-1-content">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-pink-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Xác nhận đặt lịch
                                </h3>
                                <div class="mt-4 space-y-3 text-sm text-gray-600">
                                    <p><span class="font-semibold text-gray-800">Khách hàng:</span> <span
                                            id="confirm-name"></span></p>
                                    <p><span class="font-semibold text-gray-800">Số điện thoại:</span> <span
                                            id="confirm-phone"></span></p>
                                    <p><span class="font-semibold text-gray-800">Thời gian:</span> <span
                                            id="confirm-time"></span></p>
                                    <div>
                                        <span class="font-semibold text-gray-800">Dịch vụ đã chọn:</span>
                                        <ul id="confirm-services" class="list-disc list-inside ml-2 mt-1 space-y-1">
                                        </ul>
                                    </div>
                                    <p class="text-lg font-bold text-pink-600 mt-4">Tổng cộng: <span
                                            id="confirm-total"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" onclick="proceedToPayment()"
                            class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-pink-600 text-base font-medium text-white hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                            Xác nhận & Thanh toán
                        </button>
                        <button type="button" onclick="hideConfirmationModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                            Quay lại
                        </button>
                    </div>
                </div>

                <!-- Step 2: Pay with VietQR -->
                <div id="step-2-content" class="hidden">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-2">Thanh toán đặt lịch</h3>
                        <p class="text-sm text-gray-600 mb-6">Quét mã QR để thanh toán và hoàn tất.</p>

                        <div class="flex justify-center mb-6">
                            <img id="vietqr-image" src="" alt="VietQR Payment"
                                class="w-64 h-auto object-contain shadow-lg rounded-xl border border-gray-200">
                        </div>

                        <div class="space-y-1">
                            <p class="text-sm font-bold text-pink-600">Số tiền: <span id="payment-amount">0đ</span></p>
                            <p class="text-xs text-gray-500">Nội dung: <span id="payment-content">...</span></p>
                        </div>

                        <div class="mt-4 text-left">
                            <label class="block text-sm font-medium text-gray-700 mb-2">📸 Tải lên ảnh giao dịch
                                (Bill)</label>
                            <input type="file" id="payment_proof_upload" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 transition-all border border-gray-200 rounded-lg p-1">
                            <p class="text-xs text-gray-400 mt-1">*Vui lòng upload ảnh chụp màn hình chuyển khoản thành
                                công
                            </p>
                        </div>

                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" onclick="submitBooking()"
                            class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                            Hoàn tất & Gửi bill
                        </button>
                        <button type="button" onclick="hideConfirmationModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                            Hủy
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function selectBookingDate(dateStr, element) {
            document.getElementById('selected_date').value = dateStr;
            document.getElementById('selected_time').value = '';

            document.querySelectorAll('.date-item').forEach(el => {
                el.classList.remove('border-pink-500', 'bg-pink-50', 'ring-1', 'ring-pink-500');
                el.classList.add('bg-gray-50', 'border-gray-200');
            });
            element.classList.remove('bg-gray-50', 'border-gray-200');
            element.classList.add('border-pink-500', 'bg-pink-50', 'ring-1', 'ring-pink-500');

            document.getElementById('slots-placeholder').style.display = 'none';
            document.querySelectorAll('.time-slots-group').forEach(el => el.classList.add('hidden'));

            const targetSlots = document.getElementById('slots-' + dateStr);
            if (targetSlots) {
                targetSlots.classList.remove('hidden');
            }

            document.querySelectorAll('.slot-item').forEach(el => {
                el.classList.remove('bg-pink-500', 'text-white', 'border-pink-500');
                el.classList.add('bg-white', 'text-gray-700', 'border-gray-200');
            });
        }

        function selectBookingTime(timeStr, element) {
            document.getElementById('selected_time').value = timeStr;

            document.querySelectorAll('.slot-item').forEach(el => {
                el.classList.remove('bg-pink-500', 'text-white', 'border-pink-500');
                el.classList.add('bg-white', 'text-gray-700', 'border-gray-200');
            });
            element.classList.remove('bg-white', 'text-gray-700', 'border-gray-200');
            element.classList.add('bg-pink-500', 'text-white', 'border-pink-500');
        }

        function showConfirmationModal() {
            // Validate inputs
            const name = document.getElementById('customer_name').value;
            const phone = document.getElementById('customer_phone').value;
            const date = document.getElementById('selected_date').value;
            const time = document.getElementById('selected_time').value;
            const services = document.querySelectorAll('.service-check:checked');

            if (!name || !phone || !date || !time || services.length === 0) {
                alert('Vui lòng điền đầy đủ thông tin và chọn ít nhất 1 dịch vụ!');
                return;
            }

            // Fill review info
            document.getElementById('confirm-name').textContent = name;
            document.getElementById('confirm-phone').textContent = phone;
            document.getElementById('confirm-time').textContent = time + ' - ' + date;

            const servicesList = document.getElementById('confirm-services');
            servicesList.innerHTML = '';
            services.forEach(s => {
                const li = document.createElement('li');
                li.textContent = s.dataset.name;
                servicesList.appendChild(li);
            });

            document.getElementById('confirm-total').textContent = document.getElementById('total-price').textContent;

            // Reset to Step 1
            document.getElementById('step-1-content').classList.remove('hidden');
            document.getElementById('step-2-content').classList.add('hidden');

            // Show modal
            document.getElementById('confirmation-modal').classList.remove('hidden');
        }

        function proceedToPayment() {
            const BANK_ID = 'MB';
            const ACCOUNT_NO = '0353123771';
            const ACCOUNT_NAME = 'HUYNH KHA';
            const TEMPLATE = 'compact';

            const phone = document.getElementById('customer_phone').value;
            const totalAmount = parseFloat(document.getElementById('total_price_input').value);

            // Fixed Deposit: 50,000 VND
            const depositAmount = 50000;

            // **Generate QR Code CLIENT SIDE - No DB submit yet**
            const content = `COC ${phone}`; // Use Phone as identifier

            // Update Modal Text
            document.getElementById('payment-amount').textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(depositAmount).replace('₫', 'đ');
            document.getElementById('payment-content').innerHTML = content + '<br><span class="text-xs text-gray-500 font-normal">(Cọc trước 50k)</span>';

            // Update instructional text
            const step2Title = document.querySelector('#step-2-content h3');
            if (step2Title) step2Title.textContent = "Thanh toán tiền cọc";

            const step2Desc = document.querySelector('#step-2-content p.text-gray-600');
            if (step2Desc) step2Desc.textContent = `Vui lòng chuyển khoản cọc 50,000đ để giữ lịch.`;

            const qrUrl = `https://img.vietqr.io/image/${BANK_ID}-${ACCOUNT_NO}-${TEMPLATE}.png?amount=${depositAmount}&addInfo=${encodeURIComponent(content)}&accountName=${encodeURIComponent(ACCOUNT_NAME)}`;
            document.getElementById('vietqr-image').src = qrUrl;

            // Switch to Step 2
            document.getElementById('step-1-content').classList.add('hidden');
            document.getElementById('step-2-content').classList.remove('hidden');
        }

        function hideConfirmationModal() {
            document.getElementById('confirmation-modal').classList.add('hidden');
        }

        function submitBooking() {
            // Logic: Validated via Payment Step -> Now submit to DB
            const form = document.getElementById('booking-form');
            const formData = new FormData(form);

            // Handle Payment Proof File
            const fileInput = document.getElementById('payment_proof_upload');
            if (fileInput.files.length > 0) {
                formData.append('payment_proof', fileInput.files[0]);
            } else {
                // Optional: Alert user if they haven't uploaded? 
                // For now, let's just warn or allow empty. 
                // If allow empty, backend sees no file -> Pending Payment (No Proof).
            }

            const submitBtn = event.target;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Đặt lịch thành công! Số tiền cọc đã được ghi nhận. Admin sẽ xác nhận lịch sớm nhất.');
                        window.location.reload();
                    } else {
                        alert(data.message || 'Có lỗi xảy ra, vui lòng thử lại!');
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Tôi đã thanh toán';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi gửi yêu cầu!');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Tôi đã thanh toán';
                });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const serviceChecks = document.querySelectorAll('.service-check');
            const totalPriceEl = document.getElementById('total-price');
            const totalPriceInput = document.getElementById('total_price_input');

            function calculateTotal() {
                let total = 0;
                serviceChecks.forEach(checkbox => {
                    if (checkbox.checked) {
                        total += parseFloat(checkbox.getAttribute('data-price')) || 0;
                    }
                });
                totalPriceInput.value = total;
                totalPriceEl.textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total).replace('₫', 'đ');
            }

            serviceChecks.forEach(checkbox => {
                checkbox.addEventListener('change', calculateTotal);
            });
        });
    </script>
</section>