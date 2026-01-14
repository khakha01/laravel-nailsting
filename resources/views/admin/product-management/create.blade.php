@extends('admin.layouts.layout')

@section('title', 'Thêm sản phẩm')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">
        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Thêm Sản Phẩm Mới
                </h2>
                <p class="mt-1 text-sm text-gray-500">Tạo mới sản phẩm, dịch vụ và cấu hình giá.</p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                    </svg>
                    Quay lại danh sách
                </a>
            </div>
        </div>

        {{-- Error Alert --}}
        @if ($errors->any())
            <div class="mb-6 rounded-md bg-red-50 p-4 border-l-4 border-red-500">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Vui lòng kiểm tra lại dữ liệu:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul role="list" class="list-disc space-y-1 pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Column: Main Content --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Card 1: Thông tin chung --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-6 sm:p-8">
                            <h3 class="text-base font-semibold leading-6 text-gray-900 mb-6 border-b pb-2">Thông tin chung</h3>
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                {{-- Name --}}
                                <div class="sm:col-span-4">
                                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">
                                        Tên sản phẩm <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6"
                                            placeholder="Ví dụ: Cắt da tay">
                                    </div>
                                </div>

                                 {{-- Slug --}}
                                <div class="sm:col-span-6">
                                    <label for="slug" class="block text-sm font-medium leading-6 text-gray-900">
                                        Slug (Đường dẫn) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6 bg-gray-50"
                                            placeholder="tu-dong-tao-tu-ten">
                                        @error('slug')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Đường dẫn thân thiện SEO (Ví dụ: cham-soc-da-mat).</p>
                                </div>


                                {{-- Code --}}
                                <div class="sm:col-span-2">
                                    <label for="code" class="block text-sm font-medium leading-6 text-gray-900">
                                        Mã sản phẩm
                                    </label>
                                    <div class="mt-2">
                                        <input type="text" name="code" id="code" value="{{ old('code') }}"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6"
                                            placeholder="Mã tự động nếu để trống">
                                    </div>
                                </div>

                                {{-- Category --}}
                                <div class="sm:col-span-3">
                                    <label for="category_id" class="block text-sm font-medium leading-6 text-gray-900">
                                        Danh mục <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <select id="category_id" name="category_id" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                            <option value="">-- Chọn danh mục --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Unit --}}
                                <div class="sm:col-span-3">
                                    <label for="unit" class="block text-sm font-medium leading-6 text-gray-900">
                                        Đơn vị tính <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <select id="unit" name="unit" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                            @foreach ($units as $value => $label)
                                                <option value="{{ $value }}" @selected(old('unit') == $value)>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="sm:col-span-6">
                                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Mô tả chi tiết</label>
                                    <div class="mt-2">
                                        <textarea id="description" name="description" rows="3"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Cấu hình giá (Dynamic) --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="flex items-center justify-between mb-6 border-b pb-2">
                                <h3 class="text-base font-semibold leading-6 text-gray-900">Cấu hình giá</h3>
                                <button type="button" id="addPriceBtn"
                                    class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
                                    </svg>
                                    Thêm giá
                                </button>
                            </div>

                            <div id="pricesContainer" class="space-y-4">
    {{-- Lấy dữ liệu cũ nếu validate lỗi, mặc định 1 dòng --}}
    @php
        $oldPrices = old('prices', [['price_type' => 'fixed', 'price' => '', 'price_min' => '', 'price_max' => '']]);
    @endphp

    @foreach($oldPrices as $index => $price)
        @php
            $type = $price['price_type'] ?? 'fixed';
            $isRange = $type === 'range';
        @endphp

        <div class="price-item bg-gray-50 p-4 rounded-lg border border-gray-200 relative group animate-fade-in-down">
            {{-- Nút xóa --}}
            <button type="button" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 remove-price transition-colors" title="Xóa dòng này">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Cột 1: Chọn loại giá --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Loại giá</label>
                    {{-- Thêm class js-price-type-select để bắt sự kiện JS --}}
                    <select name="prices[{{ $index }}][price_type]" class="js-price-type-select block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                        <option value="fixed" {{ $type == 'fixed' ? 'selected' : '' }}>Giá cố định</option>
                        <option value="per_nail" {{ $type == 'per_nail' ? 'selected' : '' }}>Từng móng</option>
                        <option value="range" {{ $type == 'range' ? 'selected' : '' }}>Khoảng giá</option>
                    </select>
                </div>

                {{-- Cột 2: Ô nhập giá (Thay đổi tùy theo loại) --}}
                <div class="price-input-wrapper">

                    {{-- Trường hợp 1: Giá đơn (Fixed/Per Nail) --}}
                    <div class="js-single-price {{ $isRange ? 'hidden' : '' }}">
                        <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Giá tiền (VNĐ)</label>
                        <input type="number" name="prices[{{ $index }}][price]" step="1000" value="{{ $price['price'] ?? '' }}"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                    </div>

                    {{-- Trường hợp 2: Khoảng giá (Range - Min/Max) --}}
                    <div class="js-range-price grid grid-cols-2 gap-2 {{ !$isRange ? 'hidden' : '' }}">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Thấp nhất</label>
                            <input type="number" name="prices[{{ $index }}][price_min]" step="1000" value="{{ $price['price_min'] ?? '' }}"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Cao nhất</label>
                            <input type="number" name="prices[{{ $index }}][price_max]" step="1000" value="{{ $price['price_max'] ?? '' }}"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
</div>
                        </div>
                    </div>

                </div>

                {{-- Right Column: Settings & Actions --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- Status Card --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4">Cài đặt hiển thị</h3>

                            {{-- Toggle Switch --}}
                            <div class="flex items-start mb-6">
                                <div class="flex h-6 items-center">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-pink-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                        <span class="ml-3 text-sm font-medium text-gray-900">Hoạt động</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Display Order --}}
                            <div>
                                <label for="display_order" class="block text-sm font-medium leading-6 text-gray-900">Thứ tự hiển thị</label>
                                <div class="mt-2">
                                    <input type="number" name="display_order" id="display_order" value="{{ old('display_order', 0) }}" min="0"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Số nhỏ hiển thị trước.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Card --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-5 sm:p-6">
                            <button type="submit"
                                class="flex w-full justify-center rounded-md bg-[#0c8fe1] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-pink-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Lưu Sản Phẩm
                            </button>

                            <a href="{{ route('products.index') }}"
                                class="mt-3 flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                                Hủy bỏ
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

@push('scripts')
<script src="{{ asset('js/slug.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Đếm index bắt đầu từ số lượng hiện có (để không trùng name)
        let priceIndex = {{ count(old('prices', [1])) }};

        const container = document.getElementById('pricesContainer');
        const addBtn = document.getElementById('addPriceBtn');

        // 1. Hàm thêm dòng giá mới
        addBtn.addEventListener('click', function() {
            const html = `
                <div class="price-item bg-gray-50 p-4 rounded-lg border border-gray-200 relative group animate-fade-in-down mt-4">
                    <button type="button" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 remove-price transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Loại giá</label>
                            <select name="prices[${priceIndex}][price_type]" class="js-price-type-select block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                <option value="fixed">Giá cố định</option>
                                <option value="per_nail">Từng móng</option>
                                <option value="range">Khoảng giá</option>
                            </select>
                        </div>

                        <div class="price-input-wrapper">
                            <div class="js-single-price">
                                <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Giá tiền (VNĐ)</label>
                                <input type="number" name="prices[${priceIndex}][price]" step="1000"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                            </div>

                            <div class="js-range-price grid grid-cols-2 gap-2 hidden">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Thấp nhất</label>
                                    <input type="number" name="prices[${priceIndex}][price_min]" step="1000"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Cao nhất</label>
                                    <input type="number" name="prices[${priceIndex}][price_max]" step="1000"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            priceIndex++;
        });

        // 2. Event Delegation: Xử lý sự kiện Xóa + Thay đổi Select (cho cả item cũ và mới)
        container.addEventListener('click', function(e) {
            // Xử lý nút xóa
            if (e.target.closest('.remove-price')) {
                e.target.closest('.price-item').remove();
            }
        });

        container.addEventListener('change', function(e) {
            // Xử lý khi đổi Select box
            if (e.target.classList.contains('js-price-type-select')) {
                const select = e.target;
                const wrapper = select.closest('.grid').querySelector('.price-input-wrapper');
                const singlePriceDiv = wrapper.querySelector('.js-single-price');
                const rangePriceDiv = wrapper.querySelector('.js-range-price');

                if (select.value === 'range') {
                    // Nếu chọn Range -> Hiện 2 ô, ẩn 1 ô
                    singlePriceDiv.classList.add('hidden');
                    rangePriceDiv.classList.remove('hidden');

                    // (Optional) Reset value ô single để tránh gửi thừa
                    // singlePriceDiv.querySelector('input').value = '';
                } else {
                    // Nếu chọn Fixed/PerNail -> Hiện 1 ô, ẩn 2 ô
                    singlePriceDiv.classList.remove('hidden');
                    rangePriceDiv.classList.add('hidden');

                    // (Optional) Reset value ô range
                    // rangePriceDiv.querySelectorAll('input').forEach(i => i.value = '');
                }
            }
        });
    });
</script>
@endpush

@endsection
