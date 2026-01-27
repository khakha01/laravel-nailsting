@extends('admin.layouts.layout')

@section('title', 'Cập nhật Banner')

@section('content')

    <div class="min-h-screen bg-[#f8fafc] pb-12">
        {{-- Top Bar: Sticky --}}
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
                            <h2 class="text-xl font-bold text-slate-900">Cập nhật Banner</h2>
                            <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">ID: #{{ $banner->id }} -
                                Banner Management System</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="window.location='{{ route('banners.index') }}'"
                            class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-gray-300 rounded-lg hover:bg-slate-50 shadow-sm transition-all">
                            Hủy
                        </button>
                        <button type="submit" form="main-banner-form"
                            class="px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md shadow-blue-200 transition-all">
                            Cập nhật thay đổi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Flash Error Message --}}
            @if (session('error'))
                <div class="mb-6 flex items-center p-4 text-red-800 border-t-4 border-red-500 bg-red-50 rounded-lg shadow-sm"
                    role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3 text-sm font-medium">{{ session('error') }}</div>
                </div>
            @endif

            <form id="main-banner-form" action="{{ route('banners.update', $banner->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    {{-- Cột Trái: Content --}}
                    <div class="lg:col-span-8 space-y-8">

                        {{-- Card: Banner Cha --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                                    Thông tin Banner chính
                                </h3>
                            </div>

                            <div class="p-6 space-y-8">
                                {{-- Image Upload Section --}}
                                <div
                                    class="flex flex-col md:flex-row items-start md:items-center gap-6 p-5 bg-slate-50/50 rounded-2xl border border-slate-200">
                                    <div id="parent-preview-container"
                                        class="relative group w-full md:w-72 h-40 bg-white rounded-xl border border-gray-300 flex items-center justify-center overflow-hidden shadow-sm">
                                        <img src="{{ get_media_url($banner->media) }}" class="w-full h-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors pointer-events-none">
                                        </div>
                                    </div>

                                    <div class="flex-1 space-y-4">
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-900">Hình ảnh banner chính</h4>
                                            <p class="text-xs text-slate-500 mt-1">Định dạng: JPG, PNG, WEBP. Tối ưu:
                                                1920x1080px.</p>
                                        </div>

                                        <input type="hidden" name="media_id" id="parent_media_id"
                                            value="{{ old('media_id', $banner->media_id) }}">
                                        <button type="button" onclick="openMediaModal('parent')"
                                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold text-blue-700 bg-white border border-gray-300 rounded-lg hover:border-blue-500 hover:text-blue-500 transition-all shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Thay đổi hình ảnh
                                        </button>
                                    </div>
                                </div>

                                {{-- Form Fields --}}
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-800 mb-2">Tiêu đề Banner</label>
                                        <input type="text" name="title" value="{{ old('title', $banner->title) }}"
                                            placeholder="Ví dụ: Bộ sưu tập mùa hè 2024"
                                            class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900 placeholder:text-slate-400">
                                    </div>

                                    <div class="space-y-5">
                                        <div>
                                            <label class="block text-sm font-bold text-slate-800 mb-2">Mô tả chính (Dòng
                                                1)</label>
                                            <textarea name="description_1" rows="2" placeholder="Nhập nội dung mô tả..."
                                                class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-sm text-slate-700">{{ old('description_1', $banner->description_1) }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-slate-800 mb-2">Mô tả bổ sung (Dòng
                                                2)</label>
                                            <textarea name="description_2" rows="2" placeholder="Nhập thêm chi tiết..."
                                                class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-sm text-slate-700">{{ old('description_2', $banner->description_2) }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-slate-800 mb-2">Mô tả phụ (Dòng
                                                3)</label>
                                            <textarea name="description_3" rows="2" placeholder="Thông tin thêm..."
                                                class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-sm text-slate-700">{{ old('description_3', $banner->description_3) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                                        <div>
                                            <label class="block text-sm font-bold text-slate-800 mb-2">Nhãn nút bấm</label>
                                            <input type="text" name="button_text"
                                                value="{{ old('button_text', $banner->button_text) }}"
                                                placeholder="Ví dụ: Mua sắm ngay"
                                                class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-slate-800 mb-2">Đường dẫn
                                                (URL)</label>
                                            <div class="relative flex items-center">
                                                <span class="absolute left-4 text-slate-400 text-sm">https://</span>
                                                <input type="text" name="button_link"
                                                    value="{{ old('button_link', $banner->button_link) }}"
                                                    placeholder="yourwebsite.com/promotion"
                                                    class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all pl-16 pr-4 py-3 text-slate-900">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Card: Banner Con --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div
                                class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 flex items-center justify-between">
                                <h3 class="font-bold text-slate-800">Danh sách Banner con</h3>
                                <button type="button" onclick="addBannerItem()"
                                    class="inline-flex items-center gap-2 px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md shadow-blue-200 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Thêm mục mới
                                </button>
                            </div>
                            <div id="bannerItemsContainer" class="p-6 space-y-6">
                                @foreach($banner->items as $index => $item)
                                    <div class="banner-item group bg-white p-6 rounded-2xl border border-slate-200 relative transition-all hover:shadow-md hover:border-blue-300"
                                        data-index="{{ $index }}">
                                        <button type="button"
                                            class="absolute -top-3 -right-3 h-8 w-8 flex items-center justify-center bg-white text-slate-400 hover:text-red-600 rounded-full border border-slate-200 shadow-sm transition-all remove-item opacity-0 group-hover:opacity-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>

                                        <div class="flex items-center gap-3 mb-6">
                                            <span
                                                class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 text-xs font-bold item-index-label">
                                                #{{ $index + 1 }}
                                            </span>
                                            <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Thông tin
                                                Banner con</h4>
                                            <div class="ml-auto flex items-center gap-2">
                                                <label class="relative inline-flex items-center cursor-pointer scale-75">
                                                    <input type="checkbox" name="items[{{ $index }}][is_active]" value="1"
                                                        class="sr-only peer" {{ $item->is_active ? 'checked' : '' }}>
                                                    <div
                                                        class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                    </div>
                                                </label>
                                                <span class="text-xs font-medium text-slate-500">Hiển thị</span>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                                            <div class="lg:col-span-4 space-y-3">
                                                <div
                                                    class="relative w-full aspect-video bg-slate-50 rounded-xl border border-gray-300 overflow-hidden flex items-center justify-center preview-container shadow-inner">
                                                    <img src="{{ get_media_url($item->media) }}"
                                                        class="w-full h-full object-cover">
                                                </div>
                                                <input type="hidden" name="items[{{ $index }}][media_id]" class="item-media-id"
                                                    value="{{ $item->media_id }}">
                                                <button type="button"
                                                    class="select-image-btn w-full py-2 text-xs font-bold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors flex items-center justify-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    Chọn ảnh
                                                </button>
                                            </div>

                                            <div class="lg:col-span-8 space-y-4">
                                                <input type="text" name="items[{{ $index }}][title]" value="{{ $item->title }}"
                                                    placeholder="Tiêu đề chính..."
                                                    class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-sm font-semibold">

                                                <div class="grid grid-cols-2 gap-4">
                                                    <input type="text" name="items[{{ $index }}][button_text]"
                                                        value="{{ $item->button_text }}" placeholder="Tên nút (CTA)"
                                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-sm">
                                                    <input type="text" name="items[{{ $index }}][button_link]"
                                                        value="{{ $item->button_link }}" placeholder="Đường dẫn (URL)"
                                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-sm">
                                                </div>

                                                <div class="space-y-3 pt-2 border-t border-slate-100">
                                                    <textarea name="items[{{ $index }}][description_1]" rows="1"
                                                        placeholder="Mô tả 1..."
                                                        class="w-full rounded-xl border border-gray-300 bg-slate-50/30 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2 text-sm italic">{{ $item->description_1 }}</textarea>
                                                    <textarea name="items[{{ $index }}][description_2]" rows="1"
                                                        placeholder="Mô tả 2..."
                                                        class="w-full rounded-xl border border-gray-300 bg-slate-50/30 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2 text-xs">{{ $item->description_2 }}</textarea>
                                                    <textarea name="items[{{ $index }}][description_3]" rows="1"
                                                        placeholder="Mô tả 3..."
                                                        class="w-full rounded-xl border border-gray-300 bg-slate-50/30 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2 text-xs">{{ $item->description_3 }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $banner->is_active ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg shadow-blue-200 p-6 text-white">
                            <h3 class="font-bold mb-2">Cập nhật ngay?</h3>
                            <p class="text-blue-100 text-sm mb-4">Các thay đổi sẽ được áp dụng ngay lập tức trên hệ thống
                                website.</p>
                            <button type="submit" form="main-banner-form"
                                class="w-full py-3 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-colors shadow-md">
                                Lưu thay đổi Banner
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Media Manager Modal --}}
    @include('admin.components.media-manager-modal')

    <template id="banner-item-template">
        <div
            class="banner-item group bg-white p-6 rounded-2xl border border-slate-200 relative transition-all hover:shadow-md hover:border-blue-300">
            <button type="button"
                class="absolute -top-3 -right-3 h-8 w-8 flex items-center justify-center bg-white text-slate-400 hover:text-red-600 rounded-full border border-slate-200 shadow-sm transition-all remove-item opacity-0 group-hover:opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="flex items-center gap-3 mb-6">
                <span
                    class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 text-xs font-bold item-index-label">
                    #__INDEX__
                </span>
                <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Thông tin Banner con</h4>
                <div class="ml-auto flex items-center gap-2">
                    <label class="relative inline-flex items-center cursor-pointer scale-75">
                        <input type="checkbox" name="items[__INDEX__][is_active]" value="1" class="sr-only peer" checked>
                        <div
                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                        </div>
                    </label>
                    <span class="text-xs font-medium text-slate-500">Hiển thị</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-4 space-y-3">
                    <div
                        class="relative w-full aspect-video bg-slate-50 rounded-xl border border-gray-300 overflow-hidden flex items-center justify-center preview-container shadow-inner">
                        <span class="text-[10px] text-slate-400 font-medium uppercase tracking-tight">Chưa chọn ảnh</span>
                    </div>
                    <input type="hidden" name="items[__INDEX__][media_id]" class="item-media-id">
                    <button type="button"
                        class="select-image-btn w-full py-2 text-xs font-bold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Chọn ảnh
                    </button>
                </div>

                <div class="lg:col-span-8 space-y-4">
                    <input type="text" name="items[__INDEX__][title]" placeholder="Tiêu đề chính..."
                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-sm font-semibold">

                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="items[__INDEX__][button_text]" placeholder="Tên nút (CTA)"
                            class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-sm">
                        <input type="text" name="items[__INDEX__][button_link]" placeholder="Đường dẫn (URL)"
                            class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-sm">
                    </div>

                    <div class="space-y-3 pt-2 border-t border-slate-100">
                        <textarea name="items[__INDEX__][description_1]" rows="1" placeholder="Mô tả 1..."
                            class="w-full rounded-xl border border-gray-300 bg-slate-50/30 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2 text-sm italic"></textarea>
                        <textarea name="items[__INDEX__][description_2]" rows="1" placeholder="Mô tả 2..."
                            class="w-full rounded-xl border border-gray-300 bg-slate-50/30 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2 text-xs"></textarea>
                        <textarea name="items[__INDEX__][description_3]" rows="1" placeholder="Mô tả 3..."
                            class="w-full rounded-xl border border-gray-300 bg-slate-50/30 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2 text-xs"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </template>

    @push('scripts')
        <script src="{{ asset('js/media-manager.js') }}"></script>
        <script>
            let currentMediaContext = null; // 'parent' or index (integer)
            let itemCount = {{ count($banner->items) }};

            document.addEventListener('DOMContentLoaded', function () {
                const mediaManager = new MediaManager({
                    urls: {
                        index: '{{ route('media.index') }}',
                        store: '{{ route('media.store') }}',
                        folderStore: '{{ route('media.folders.store') }}',
                        folderDelete: '{{ route('media.folders.destroy', ['id' => '__ID__']) }}'.replace('__ID__', ''),
                        mediaDelete: '{{ route('media.destroy', ['id' => '__ID__']) }}'.replace('__ID__', ''),
                        mediaBulkDelete: '{{ route('media.bulk-delete') }}',
                    },
                    csrfToken: '{{ csrf_token() }}'
                });

                window.openMediaModal = function (context) {
                    currentMediaContext = context;
                    mediaManager.openMediaModal();
                };

                mediaManager.confirmSelection = function () {
                    const selected = Array.from(this.state.selectedItemsMap.values());
                    if (selected.length === 0) {
                        this.closeMediaModal();
                        return;
                    }

                    const item = selected[0];

                    if (currentMediaContext === 'parent') {
                        document.getElementById('parent_media_id').value = item.id;
                        document.getElementById('parent-preview-container').innerHTML = `<img src="${item.url}" class="w-full h-full object-cover">`;
                    } else if (typeof currentMediaContext === 'number' || !isNaN(currentMediaContext)) {
                        const container = document.querySelector(`.banner-item[data-index="${currentMediaContext}"]`);
                        if (container) {
                            container.querySelector('.item-media-id').value = item.id;
                            container.querySelector('.preview-container').innerHTML = `<img src="${item.url}" class="w-full h-full object-cover">`;
                        }
                    }

                    this.closeMediaModal();
                    this.state.selectedItemsMap.clear();
                    this.updateStatus();
                }

                document.getElementById('bannerItemsContainer').addEventListener('click', function (e) {
                    if (e.target.closest('.remove-item')) {
                        e.target.closest('.banner-item').remove();
                    }
                    if (e.target.closest('.select-image-btn')) {
                        const item = e.target.closest('.banner-item');
                        const index = item.dataset.index;
                        openMediaModal(parseInt(index));
                    }
                });
            });

            function addBannerItem() {
                const template = document.getElementById('banner-item-template');
                const container = document.getElementById('bannerItemsContainer');

                let html = template.innerHTML;
                html = html.replace(/__INDEX__/g, itemCount);

                const temp = document.createElement('div');
                temp.innerHTML = html;
                const newItem = temp.firstElementChild;
                newItem.setAttribute('data-index', itemCount);

                container.appendChild(newItem);
                itemCount++;
            }
        </script>
    @endpush

@endsection