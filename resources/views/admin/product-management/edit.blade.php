@extends('admin.layouts.layout')

@section('title', 'Sửa sản phẩm')

@section('content')

    <div class="min-h-screen bg-[#f8fafc] pb-12">
        {{-- Top Bar: Sticky để người dùng luôn thấy nút Lưu --}}
        <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('products.index') }}"
                            class="p-2 rounded-full hover:bg-slate-100 text-slate-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Sửa Sản Phẩm</h2>
                            <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Product Management System
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="window.location='{{ route('products.index') }}'"
                            class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border border-gray-300 rounded-lg hover:bg-slate-50 shadow-sm transition-all">
                            Hủy
                        </button>
                        <button type="submit" form="main-product-form"
                            class="px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md shadow-blue-200 transition-all">
                            Lưu thay đổi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="mb-6 flex items-center p-4 text-red-800 border-t-4 border-red-500 bg-red-50 rounded-lg shadow-sm"
                    role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Vui lòng kiểm tra lại dữ liệu:</h3>
                        <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form id="main-product-form" action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    {{-- Left Column: Main Content --}}
                    <div class="lg:col-span-8 space-y-8">

                        {{-- Card: Thông tin chung --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                                    Thông tin chung: <span class="text-blue-600 font-bold ml-1">{{ $product->name }}</span>
                                </h3>
                            </div>

                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Name --}}
                                    <div class="md:col-span-2">
                                        <label for="name" class="block text-sm font-bold text-slate-800 mb-2">
                                            Tên sản phẩm <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                                            required
                                            class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900 placeholder:text-slate-400"
                                            placeholder="Ví dụ: Cắt da tay">
                                    </div>

                                    {{-- Slug --}}
                                    <div class="md:col-span-2">
                                        <label for="slug" class="block text-sm font-bold text-slate-800 mb-2">
                                            Slug (Đường dẫn) <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}"
                                            required
                                            class="w-full rounded-xl border border-gray-300 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900"
                                            placeholder="tu-dong-tao-tu-ten">
                                        @error('slug')
                                            <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-slate-500 italic">Đường dẫn thân thiện SEO (Ví dụ: cham-soc-da-mat).</p>
                                    </div>

                                    {{-- Code --}}
                                    <div>
                                        <label for="code" class="block text-sm font-bold text-slate-800 mb-2">
                                            Mã sản phẩm
                                        </label>
                                        <input type="text" name="code" id="code" value="{{ old('code', $product->code) }}"
                                            class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900"
                                            placeholder="Mã tự động nếu để trống">
                                    </div>

                                    {{-- Category --}}
                                    <div>
                                        <label for="category_id" class="block text-sm font-bold text-slate-800 mb-2">
                                            Danh mục <span class="text-red-500">*</span>
                                        </label>
                                        <select id="category_id" name="category_id" required
                                            class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900">
                                            <option value="">-- Chọn danh mục --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Unit --}}
                                    <div>
                                        <label for="unit" class="block text-sm font-bold text-slate-800 mb-2">
                                            Đơn vị tính <span class="text-red-500">*</span>
                                        </label>
                                        <select id="unit" name="unit" required
                                            class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900">
                                            @foreach ($units as $value => $label)
                                                <option value="{{ $value }}" @selected(old('unit', $product->unit?->value) == $value)>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    {{-- Description --}}
                                    <div class="md:col-span-2">
                                        <label for="description" class="block text-sm font-bold text-slate-800 mb-2">Mô tả chi tiết</label>
                                        <textarea id="description" name="description" rows="4"
                                            class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-700 text-sm">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Price Configuration Card --}}
                        @php
                            $prices = old('prices', $product->prices->toArray());
                        @endphp
                        @include('admin.components.price-configuration', [
                            'prices' => $prices,
                            'inputName' => 'prices',
                            'title' => 'Cấu hình giá Sản phẩm'
                        ])

                    </div>

                    {{-- Right Column: Settings & Actions --}}
                    <div class="lg:col-span-4 space-y-6">

                        {{-- Display Settings Card --}}
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
                                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">Trạng thái</p>
                                        <p class="text-xs text-slate-500">Cho phép sản phẩm hiển thị</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" @checked(old('is_active', $product->is_active))>
                                        <div
                                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                        </div>
                                    </label>
                                </div>

                                {{-- Display Order --}}
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <label for="display_order" class="block text-sm font-bold text-slate-700 mb-2">Thứ tự hiển thị</label>
                                    <input type="number" name="display_order" id="display_order"
                                        value="{{ old('display_order', $product->display_order) }}" min="0"
                                        class="w-full rounded-lg border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-3 py-2 text-sm text-slate-900">
                                    <p class="mt-1 text-[10px] text-slate-500 italic">Số nhỏ hiển thị trước.</p>
                                </div>

                                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-2">
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-slate-500">Ngày tạo:</span>
                                        <span class="font-bold text-slate-700">{{ $product->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-slate-500">Cập nhật:</span>
                                        <span class="font-bold text-slate-700">{{ $product->updated_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>

                                <div class="p-4 rounded-xl border border-amber-100 bg-amber-50">
                                    <h4 class="text-xs font-bold text-amber-800 uppercase mb-2">Lưu ý quản trị</h4>
                                    <ul class="text-xs text-amber-700 space-y-1 list-disc pl-4 italic">
                                        <li>Sản phẩm khi hoạt động sẽ hiển thị trên bảng giá.</li>
                                        <li>Hãy kiểm tra kỹ cấu hình giá trước khi lưu.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Quick Action Card --}}
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg shadow-blue-200 p-6 text-white">
                            <h3 class="font-bold mb-2">Sẵn sàng xuất bản?</h3>
                            <p class="text-blue-100 text-sm mb-4">Kiểm tra kỹ các thông tin và cấu hình giá trước khi lưu để đảm bảo trải nghiệm người dùng tốt nhất.</p>
                            <button type="submit" form="main-product-form"
                                class="w-full py-3 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-colors shadow-md">
                                Xác nhận Cập Nhật Sản Phẩm
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/slug.js') }}"></script>
        <script src="{{ asset('js/format-currency.js') }}"></script>
    @endpush

@endsection
