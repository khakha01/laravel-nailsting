@extends('admin.layouts.layout')

@section('title', 'Thêm nail')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">
        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Thêm Nail Mới
                </h2>
                <p class="mt-1 text-sm text-gray-500">Tạo mới nail, hình ảnh và cấu hình giá.</p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <a href="{{ route('nails.index') }}"
                    class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z"
                            clip-rule="evenodd" />
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
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                clip-rule="evenodd" />
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

        <form action="{{ route('nails.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Column: Main Content --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Card 1: Thông tin chung --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-6 sm:p-8">
                            <h3 class="text-base font-semibold leading-6 text-gray-900 mb-6 border-b pb-2">Thông tin chung
                            </h3>
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                {{-- Name --}}
                                <div class="sm:col-span-6">
                                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">
                                        Tên nail <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6"
                                            placeholder="Ví dụ: Nail art hoa hồng">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Slug --}}
                                <div class="sm:col-span-6">
                                    <label for="slug" class="block text-sm font-medium leading-6 text-gray-900">
                                        Slug (Đường dẫn) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6 bg-gray-50"
                                            placeholder="tu-dong-tao-tu-ten">
                                        @error('slug')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Đường dẫn thân thiện SEO (Ví dụ: nail-art-hoa-hong).
                                    </p>
                                </div>

                                {{-- Description --}}
                                <div class="sm:col-span-6">
                                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Mô tả
                                        chi tiết</label>
                                    <div class="mt-2">
                                        <textarea id="description" name="description" rows="4"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">{{ old('description') }}</textarea>
                                        @error('description')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Hình ảnh (Dynamic) --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="flex items-center justify-between mb-6 border-b pb-2">
                                <h3 class="text-base font-semibold leading-6 text-gray-900">Hình ảnh</h3>
                                <button type="button" id="addImageBtn"
                                    class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Thêm hình ảnh
                                </button>
                            </div>

                            <div id="imagesContainer" class="space-y-4">
                                @php
                                    $oldImages = old('images', [['image_path' => '', 'is_primary' => false, 'sort_order' => 0]]);
                                @endphp

                                @foreach ($oldImages as $index => $image)
                                    <div
                                        class="image-item bg-gray-50 p-4 rounded-lg border border-gray-200 relative group">
                                        <button type="button"
                                            class="absolute top-2 right-2 text-gray-400 hover:text-red-500 remove-image transition-colors"
                                            title="Xóa dòng này">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                        <div class="space-y-4">
                                            {{-- File Upload Input --}}
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Hình ảnh <span class="text-red-500">*</span></label>
                                                <input type="file" name="images[{{ $index }}][image]" accept="image/*" required
                                                    onchange="previewImage(this, 'preview-{{ $index }}')"
                                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 cursor-pointer">
                                                @error("images.$index.image")
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                                {{-- Preview --}}
                                                <div id="preview-{{ $index }}" class="mt-2 hidden">
                                                    <img src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                                </div>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Thứ tự</label>
                                                    <input type="number" name="images[{{ $index }}][sort_order]"
                                                        value="{{ $image['sort_order'] ?? $index }}" min="0"
                                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                                </div>
                                                <div class="flex items-end">
                                                    <div class="flex items-center">
                                                        <input type="checkbox" name="images[{{ $index }}][is_primary]" value="1"
                                                            class="h-4 w-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500"
                                                            {{ ($image['is_primary'] ?? ($index === 0)) ? 'checked' : '' }}>
                                                        <label class="ml-2 text-sm text-gray-700">Hình ảnh chính</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Card 3: Cấu hình giá (Dynamic) --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="flex items-center justify-between mb-6 border-b pb-2">
                                <h3 class="text-base font-semibold leading-6 text-gray-900">Cấu hình giá</h3>
                                <button type="button" id="addPriceBtn"
                                    class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Thêm giá
                                </button>
                            </div>

                            <div id="pricesContainer" class="space-y-4">
                                @php
                                    $oldPrices = old('prices', [['title' => '', 'price' => '', 'is_default' => false]]);
                                @endphp

                                @foreach ($oldPrices as $index => $price)
                                    <div
                                        class="price-item bg-gray-50 p-4 rounded-lg border border-gray-200 relative group">
                                        <button type="button"
                                            class="absolute top-2 right-2 text-gray-400 hover:text-red-500 remove-price transition-colors"
                                            title="Xóa dòng này">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Tiêu đề giá <span class="text-red-500">*</span></label>
                                                <input type="text" name="prices[{{ $index }}][title]"
                                                    value="{{ $price['title'] ?? '' }}" required
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6"
                                                    placeholder="VD: Giá cơ bản, Nail dài">
                                                @error("prices.$index.title")
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Giá (VNĐ) <span class="text-red-500">*</span></label>
                                                <input type="text" name="prices[{{ $index }}][price]"
                                                    value="{{ $price['price'] ?? '' }}" required
                                                    oninput="formatCurrency(this)"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6"
                                                    placeholder="100000">
                                                @error("prices.$index.price")
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mt-3 flex items-center">
                                            <input type="checkbox" name="prices[{{ $index }}][is_default]" value="1"
                                                class="h-4 w-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500"
                                                {{ ($price['is_default'] ?? ($index === 0)) ? 'checked' : '' }}>
                                            <label class="ml-2 text-sm text-gray-700">Giá mặc định</label>
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
                            <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4">Trạng thái</h3>

                            <div class="flex items-start">
                                <div class="flex h-6 items-center">
                                    <select name="status" id="status"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Dừng</option>
                                    </select>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Hoạt động: Nail sẽ hiển thị trên website.<br>
                                Dừng: Nail sẽ bị ẩn đi.
                            </p>
                        </div>
                    </div>

                    {{-- Actions Card --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-5 sm:p-6">
                            <button type="submit"
                                class="flex w-full justify-center rounded-md bg-[#0c8fe1] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-pink-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Lưu Nail
                            </button>

                            <a href="{{ route('nails.index') }}"
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
        <script src="{{ asset('js/format-currency.js') }}"></script>

        <script>
            // Preview image khi chọn file
            function previewImage(input, previewId) {
                const preview = document.getElementById(previewId);
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.querySelector('img').src = e.target.result;
                        preview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.classList.add('hidden');
                }
            }
            document.addEventListener('DOMContentLoaded', function() {
                let imageIndex = {{ count(old('images', [1])) }};
                let priceIndex = {{ count(old('prices', [1])) }};

                const imagesContainer = document.getElementById('imagesContainer');
                const pricesContainer = document.getElementById('pricesContainer');
                const addImageBtn = document.getElementById('addImageBtn');
                const addPriceBtn = document.getElementById('addPriceBtn');

                // Thêm hình ảnh
                addImageBtn.addEventListener('click', function() {
                    const html = `
                        <div class="image-item bg-gray-50 p-4 rounded-lg border border-gray-200 relative group">
                            <button type="button" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 remove-image transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Hình ảnh <span class="text-red-500">*</span></label>
                                    <input type="file" name="images[${imageIndex}][image]" accept="image/*" required
                                        onchange="previewImage(this, 'preview-${imageIndex}')"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 cursor-pointer">
                                    <div id="preview-${imageIndex}" class="mt-2 hidden">
                                        <img src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Thứ tự</label>
                                        <input type="number" name="images[${imageIndex}][sort_order]" value="${imageIndex}" min="0"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div class="flex items-end">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="images[${imageIndex}][is_primary]" value="1"
                                                class="h-4 w-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                                            <label class="ml-2 text-sm text-gray-700">Hình ảnh chính</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    imagesContainer.insertAdjacentHTML('beforeend', html);
                    imageIndex++;
                });

                // Thêm giá
                addPriceBtn.addEventListener('click', function() {
                    const html = `
                        <div class="price-item bg-gray-50 p-4 rounded-lg border border-gray-200 relative group">
                            <button type="button" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 remove-price transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Tiêu đề giá <span class="text-red-500">*</span></label>
                                    <input type="text" name="prices[${priceIndex}][title]" required
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6"
                                        placeholder="VD: Giá cơ bản">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Giá (VNĐ) <span class="text-red-500">*</span></label>
                                    <input type="text" name="prices[${priceIndex}][price]" required
                                        oninput="formatCurrency(this)"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6"
                                        placeholder="100000">
                                </div>
                            </div>
                            <div class="mt-3 flex items-center">
                                <input type="checkbox" name="prices[${priceIndex}][is_default]" value="1"
                                    class="h-4 w-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                                <label class="ml-2 text-sm text-gray-700">Giá mặc định</label>
                            </div>
                        </div>
                    `;
                    pricesContainer.insertAdjacentHTML('beforeend', html);
                    priceIndex++;
                });

                // Xóa hình ảnh
                imagesContainer.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-image')) {
                        e.target.closest('.image-item').remove();
                    }
                });

                // Xóa giá
                pricesContainer.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-price')) {
                        e.target.closest('.price-item').remove();
                    }
                });
            });
        </script>
    @endpush

@endsection

