trong banner-management có phần ui create và edit toi mới làm lại bạn hãy vào để xem. toi muon bạn sửa lại ui của create và edit y như create và edit banner-management . Chỉ sửa ui không thay doi logic. Nhưng thứu toi muon bạn sửa trong file này. hãy sửa lại cho tat cả management trong admin

    |
    |
    v

{{-- Top Bar: Sticky để người dùng luôn thấy nút Lưu --}}

<div class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200 mb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-4">
                <a href="{{ route('banners.index') }}"
                    class="p-2 rounded-full hover:bg-slate-100 text-slate-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Thêm Banner Mới</h2>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Banner Management System
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="window.location='{{ route('banners.index') }}'"
                    class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border border-gray-300 rounded-lg hover:bg-slate-50 shadow-sm transition-all">
                    Hủy
                </button>
                <button type="submit" form="main-banner-form"
                    class="px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md shadow-blue-200 transition-all">
                    Lưu thay đổi
                </button>
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
Thiết lập hiển thị
</h3>

                            <div class="space-y-4">
                                <div
                                    class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">Trạng thái</p>
                                        <p class="text-xs text-slate-500">Cho phép banner hiển thị</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                                        <div
                                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                        </div>
                                    </label>
                                </div>

                                <div class="p-4 rounded-xl border border-amber-100 bg-amber-50">
                                    <h4 class="text-xs font-bold text-amber-800 uppercase mb-2">Lưu ý quản trị</h4>
                                    <ul class="text-xs text-amber-700 space-y-1 list-disc pl-4 italic">
                                        <li>Banner chính sẽ là ảnh nền lớn nhất.</li>
                                        <li>Banner con thường hiển thị dưới dạng carousel hoặc grid.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Quick Action Card --}}
                        <div
                            class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg shadow-blue-200 p-6 text-white">
                            <h3 class="font-bold mb-2">Sẵn sàng xuất bản?</h3>
                            <p class="text-blue-100 text-sm mb-4">Kiểm tra kỹ các thông tin và hình ảnh trước khi lưu để đảm
                                bảo trải nghiệm người dùng.</p>
                            <button type="submit" form="main-banner-form"
                                class="w-full py-3 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-colors shadow-md">
                                Xác nhận Lưu Banner
                            </button>
                        </div>
                    </div>
