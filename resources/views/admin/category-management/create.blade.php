@extends('admin.layouts.layout')

@section('title', 'Thêm Danh Mục')

@section('content')

    <div class="min-h-screen bg-[#f8fafc] pb-12">
        {{-- Top Bar: Sticky để người dùng luôn thấy nút Lưu --}}
        <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('categories.index') }}"
                            class="p-2 rounded-full hover:bg-slate-100 text-slate-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Thêm Danh Mục Mới</h2>
                            <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Category Management System
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="window.location='{{ route('categories.index') }}'"
                            class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-gray-300 rounded-lg hover:bg-slate-50 shadow-sm transition-all">
                            Hủy
                        </button>
                        <button type="submit" form="main-category-form"
                            class="px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md shadow-blue-200 transition-all">
                            Lưu thay đổi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Flash Error Message --}}
            @if ($errors->any())
                <div class="mb-6 flex items-center p-4 text-red-800 border-t-4 border-red-500 bg-red-50 rounded-lg shadow-sm"
                    role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium">Có lỗi xảy ra khi gửi form:</h3>
                        <ul class="mt-2 text-sm list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form id="main-category-form" action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    {{-- Cột Trái: Content --}}
                    <div class="lg:col-span-8 space-y-8">

                        {{-- Card: Thông tin chung --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                                    Thông tin danh mục
                                </h3>
                            </div>

                            <div class="p-6 space-y-6">
                                {{-- Name --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">
                                        Tên Danh Mục <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                                        placeholder="Ví dụ: Chăm sóc da mặt"
                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900 placeholder:text-slate-400">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Slug --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">
                                        Slug (Đường dẫn) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                                        placeholder="tu-dong-tao-tu-ten"
                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900 bg-slate-50">
                                    @error('slug')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-slate-500">Đường dẫn thân thiện SEO (Ví dụ: cham-soc-da-mat).</p>
                                </div>

                                {{-- Parent Category --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">Danh Mục Cha</label>
                                    <select id="parent_id" name="parent_id"
                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900">
                                        <option value="">-- Không có danh mục cha (Danh mục gốc) --</option>
                                        @foreach($parentCategories as $parent)
                                            <option value="{{ $parent->id }}" 
                                                {{ (old('parent_id', request('parent_id')) == $parent->id) ? 'selected' : '' }}>
                                                {{ $parent->indent_name ?? $parent->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Description --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">Mô Tả</label>
                                    <textarea id="description" name="description" rows="4"
                                        placeholder="Nhập mô tả ngắn về danh mục này..."
                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-sm text-slate-700">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-slate-500">Tối đa 1000 ký tự.</p>
                                </div>

                                {{-- Display Order --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">Thứ Tự Hiển Thị</label>
                                    <input type="number" name="display_order" id="display_order" value="{{ old('display_order', 0) }}" min="0"
                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900">
                                    <p class="mt-1 text-xs text-slate-500">Số nhỏ hiển thị trước (Mặc định: 0).</p>
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
                                        <p class="text-xs text-slate-500">Cho phép danh mục hiển thị</p>
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
                                        <li>Danh mục cha sẽ chứa các danh mục con.</li>
                                        <li>Thứ tự hiển thị giúp sắp xếp danh mục.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Quick Action Card --}}
                        <div
                            class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg shadow-blue-200 p-6 text-white">
                            <h3 class="font-bold mb-2">Sẵn sàng xuất bản?</h3>
                            <p class="text-blue-100 text-sm mb-4">Kiểm tra kỹ các thông tin trước khi lưu để đảm
                                bảo trải nghiệm người dùng.</p>
                            <button type="submit" form="main-category-form"
                                class="w-full py-3 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-colors shadow-md">
                                Xác nhận Lưu Danh Mục
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@push('scripts')
<script src="{{ asset('js/slug.js') }}"></script>
@endpush

@endsection
