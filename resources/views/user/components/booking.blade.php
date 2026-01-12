<main class="max-w-2xl mx-auto px-4 py-6 space-y-6">

        <div class="bg-white rounded-xl shadow-sm p-5 border border-pink-100">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <span class="bg-pink-100 text-pink-600 w-8 h-8 rounded-full flex items-center justify-center mr-2 text-sm">1</span>
                Thông tin & Lịch hẹn
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Họ tên</label>
                    <input type="text" placeholder="Nhập tên của bạn" class="w-full rounded-lg border-gray-300 border p-2.5 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                    <input type="tel" placeholder="09xxxxxxx" class="w-full rounded-lg border-gray-300 border p-2.5 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ngày làm</label>
                    <input type="date" class="w-full rounded-lg border-gray-300 border p-2.5 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 outline-none text-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Giờ đến (Dự kiến)</label>
                    <input type="time" class="w-full rounded-lg border-gray-300 border p-2.5 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 outline-none text-gray-600">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border border-pink-100">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <span class="bg-pink-100 text-pink-600 w-8 h-8 rounded-full flex items-center justify-center mr-2 text-sm">2</span>
                Chọn dịch vụ
            </h2>
            <p class="text-xs text-gray-500 mb-4 italic">* Giá có thể thay đổi tùy thuộc vào độ phức tạp thực tế.</p>

            <div class="mb-6">
                <h3 class="text-md font-bold text-pink-700 uppercase mb-3 border-b border-pink-100 pb-1">Nail - Sơn Gel</h3>
                <div class="space-y-3">
                    <label class="flex items-start justify-between p-3 rounded-lg border border-gray-200 hover:border-pink-300 cursor-pointer transition bg-gray-50 hover:bg-white select-service">
                        <div class="flex items-center">
                            <input type="checkbox" data-price="10000" class="w-5 h-5 text-pink-600 border-gray-300 rounded focus:ring-pink-500 service-check">
                            <span class="ml-3 text-gray-700 font-medium">Cắt da</span>
                        </div>
                        <span class="text-gray-900 font-bold">10K</span>
                    </label>

                    <label class="flex items-start justify-between p-3 rounded-lg border border-gray-200 hover:border-pink-300 cursor-pointer transition bg-gray-50 hover:bg-white select-service">
                        <div class="flex items-center">
                            <input type="checkbox" data-price="20000" class="w-5 h-5 text-pink-600 border-gray-300 rounded focus:ring-pink-500 service-check">
                            <span class="ml-3 text-gray-700 font-medium">Tháo sơn Gel</span>
                        </div>
                        <span class="text-gray-900 font-bold">20K</span>
                    </label>

                    <label class="flex items-start justify-between p-3 rounded-lg border border-gray-200 hover:border-pink-300 cursor-pointer transition bg-gray-50 hover:bg-white select-service">
                        <div class="flex items-center">
                            <input type="checkbox" data-price="25000" class="w-5 h-5 text-pink-600 border-gray-300 rounded focus:ring-pink-500 service-check">
                            <span class="ml-3 text-gray-700 font-medium">Tháo móng úp</span>
                        </div>
                        <span class="text-gray-900 font-bold">25K</span>
                    </label>

                    <label class="flex items-start justify-between p-3 rounded-lg border border-gray-200 hover:border-pink-300 cursor-pointer transition bg-gray-50 hover:bg-white select-service">
                        <div class="flex items-center">
                            <input type="checkbox" data-price="80000" class="w-5 h-5 text-pink-600 border-gray-300 rounded focus:ring-pink-500 service-check">
                            <div class="ml-3">
                                <span class="block text-gray-700 font-medium">Sơn Gel</span>
                                <span class="block text-xs text-gray-500">Màu, thạch, mix màu</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="block text-gray-900 font-bold">80K - 100K</span>
                        </div>
                    </label>

                    <label class="flex items-start justify-between p-3 rounded-lg border border-gray-200 hover:border-pink-300 cursor-pointer transition bg-gray-50 hover:bg-white select-service">
                        <div class="flex items-center">
                            <input type="checkbox" data-price="100000" class="w-5 h-5 text-pink-600 border-gray-300 rounded focus:ring-pink-500 service-check">
                            <span class="ml-3 text-gray-700 font-medium">Mắt mèo</span>
                        </div>
                        <span class="text-gray-900 font-bold">100K - 120K</span>
                    </label>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-md font-bold text-pink-700 uppercase mb-3 border-b border-pink-100 pb-1">Úp Móng</h3>
                <label class="flex items-start justify-between p-3 rounded-lg border border-gray-200 hover:border-pink-300 cursor-pointer transition bg-gray-50 hover:bg-white select-service">
                    <div class="flex items-center">
                        <input type="checkbox" data-price="50000" class="w-5 h-5 text-pink-600 border-gray-300 rounded focus:ring-pink-500 service-check">
                        <span class="ml-3 text-gray-700 font-medium">Úp móng Base</span>
                    </div>
                    <span class="text-gray-900 font-bold">50K</span>
                </label>
            </div>

            <div class="mb-6">
                <h3 class="text-md font-bold text-pink-700 uppercase mb-3 border-b border-pink-100 pb-1">Trang trí Nails</h3>

                <div class="p-3 rounded-lg border border-gray-200 hover:border-pink-300 transition bg-gray-50 hover:bg-white mb-3">
                    <label class="flex items-center justify-between cursor-pointer">
                        <div class="flex items-center">
                            <input type="checkbox" data-price="3000" data-type="per-nail" class="w-5 h-5 text-pink-600 border-gray-300 rounded focus:ring-pink-500 service-check-qty">
                            <div class="ml-3">
                                <span class="block text-gray-700 font-medium">Trang trí / Ombre / Tráng gương</span>
                            </div>
                        </div>
                        <span class="text-gray-900 font-bold">3K/ngón</span>
                    </label>
                    <div class="hidden qty-input mt-3 pl-8 flex items-center animate-fade-in">
                        <span class="text-sm text-gray-500 mr-2">Số ngón:</span>
                        <div class="flex items-center border border-gray-300 rounded-md">
                            <button type="button" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-l-md btn-minus">-</button>
                            <input type="number" value="1" min="1" max="10" class="w-10 text-center text-sm border-none focus:ring-0 p-1 bg-white input-qty">
                            <button type="button" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-r-md btn-plus">+</button>
                        </div>
                    </div>
                </div>

                <div class="p-3 rounded-lg border border-gray-200 hover:border-pink-300 transition bg-gray-50 hover:bg-white mb-3">
                    <label class="flex items-center justify-between cursor-pointer">
                        <div class="flex items-center">
                            <input type="checkbox" data-price="8000" data-type="per-nail" class="w-5 h-5 text-pink-600 border-gray-300 rounded focus:ring-pink-500 service-check-qty">
                            <span class="ml-3 text-gray-700 font-medium">French (Đầu móng)</span>
                        </div>
                        <span class="text-gray-900 font-bold">8K/ngón</span>
                    </label>
                    <div class="hidden qty-input mt-3 pl-8 flex items-center animate-fade-in">
                        <span class="text-sm text-gray-500 mr-2">Số ngón:</span>
                        <div class="flex items-center border border-gray-300 rounded-md">
                            <button type="button" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-l-md btn-minus">-</button>
                            <input type="number" value="1" min="1" max="10" class="w-10 text-center text-sm border-none focus:ring-0 p-1 bg-white input-qty">
                            <button type="button" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-r-md btn-plus">+</button>
                        </div>
                    </div>
                </div>

                <div class="p-3 rounded-lg border border-gray-200 hover:border-pink-300 transition bg-gray-50 hover:bg-white mb-3">
                    <label class="flex items-center justify-between cursor-pointer">
                        <div class="flex items-center">
                            <input type="checkbox" data-price="2000" data-type="per-nail" class="w-5 h-5 text-pink-600 border-gray-300 rounded focus:ring-pink-500 service-check-qty">
                            <div class="ml-3">
                                <span class="block text-gray-700 font-medium">Đính Charm / Đá</span>
                                <span class="block text-xs text-gray-500">Đá khối, charm lớn (2k - 5k)</span>
                            </div>
                        </div>
                        <span class="text-gray-900 font-bold">Từ 2K/ngón</span>
                    </label>
                    <div class="hidden qty-input mt-3 pl-8 flex items-center animate-fade-in">
                        <span class="text-sm text-gray-500 mr-2">Số ngón:</span>
                        <div class="flex items-center border border-gray-300 rounded-md">
                            <button type="button" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-l-md btn-minus">-</button>
                            <input type="number" value="1" min="1" max="10" class="w-10 text-center text-sm border-none focus:ring-0 p-1 bg-white input-qty">
                            <button type="button" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-r-md btn-plus">+</button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-4">
                <textarea class="w-full rounded-lg border-gray-300 border p-3 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 outline-none text-sm" rows="3" placeholder="Ghi chú thêm cho tiệm (Ví dụ: Mẫu móng muốn làm, yêu cầu đặc biệt...)"></textarea>
            </div>
        </div>

    </main>
<div class="w-full bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] p-4 z-40">
        <div class="max-w-2xl mx-auto flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Tạm tính:</p>
                <p class="text-xl font-bold text-pink-600" id="total-price">0đ</p>
            </div>
            <button class="bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200">
                Xác nhận đặt
            </button>
        </div>
    </div>
