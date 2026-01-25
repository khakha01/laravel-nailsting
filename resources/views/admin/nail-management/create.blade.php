@extends('admin.layouts.layout')

@section('title', 'Thêm Nail')

@section('content')

    <div class="min-h-screen bg-[#f8fafc] pb-12">
        {{-- Top Bar: Sticky để người dùng luôn thấy nút Lưu --}}
        <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('nails.index') }}"
                            class="p-2 rounded-full hover:bg-slate-100 text-slate-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Thêm Nail Mới</h2>
                            <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Nail Management System
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="window.location='{{ route('nails.index') }}'"
                            class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-gray-300 rounded-lg hover:bg-slate-50 shadow-sm transition-all">
                            Hủy
                        </button>
                        <button type="submit" form="main-nail-form"
                            class="px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md shadow-blue-200 transition-all">
                            Lưu thay đổi
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

            {{-- Validation Error Alert --}}
            @if ($errors->any())
                <div class="mb-6 flex items-center p-4 text-red-800 border-t-4 border-red-500 bg-red-50 rounded-lg shadow-sm"
                    role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium">Vui lòng kiểm tra lại dữ liệu:</h3>
                        <div class="mt-2 text-sm">
                            <ul role="list" class="list-disc space-y-1 pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form id="main-nail-form" action="{{ route('nails.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    {{-- Cột Trái: Content --}}
                    <div class="lg:col-span-8 space-y-8">

                        {{-- Card 1: Thông tin chung --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                                    Thông tin chung
                                </h3>
                            </div>

                            <div class="p-6 space-y-6">
                                {{-- Name --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">
                                        Tên nail <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                        placeholder="Ví dụ: Nail art hoa hồng"
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
                                        class="w-full rounded-xl border border-gray-300 bg-slate-50 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900 placeholder:text-slate-400">
                                    <p class="mt-1 text-xs text-slate-500">Đường dẫn thân thiện SEO (Ví dụ:
                                        nail-art-hoa-hong).</p>
                                    @error('slug')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Description --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">Mô tả chi tiết</label>
                                    <textarea id="description" name="description" rows="4" placeholder="Nhập mô tả chi tiết về nail..."
                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-sm text-slate-700">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Card 2: Hình ảnh (MinIO Integration) --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 flex items-center justify-between">
                                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                                    Hình ảnh
                                </h3>
                                <button type="button" onclick="openMediaModal()"
                                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold text-blue-700 bg-white border border-gray-300 rounded-lg hover:border-blue-500 hover:text-blue-500 transition-all shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Chọn ảnh từ thư viện
                                </button>
                            </div>

                            <div class="p-6">
                                <div id="imagesContainer" class="space-y-4">
                                    @php
                                        $oldImages = old('images', []);
                                    @endphp

                                    @foreach ($oldImages as $index => $image)
                                        @if(isset($image['media_id']))
                                            <div class="image-item group bg-slate-50/50 p-5 rounded-2xl border border-slate-200 relative transition-all hover:shadow-md hover:border-blue-300">
                                                <button type="button"
                                                    class="absolute -top-3 -right-3 h-8 w-8 flex items-center justify-center bg-white text-slate-400 hover:text-red-600 rounded-full border border-slate-200 shadow-sm transition-all remove-image opacity-0 group-hover:opacity-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>

                                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                                                    <div class="lg:col-span-4">
                                                        <img src="{{ $image['preview_url'] ?? '#' }}" class="w-full h-32 object-cover rounded-xl border border-gray-300 shadow-sm">
                                                        <input type="hidden" name="images[{{ $index }}][media_id]" value="{{ $image['media_id'] }}">
                                                        <input type="hidden" name="images[{{ $index }}][preview_url]" value="{{ $image['preview_url'] ?? '' }}">
                                                    </div>

                                                    <div class="lg:col-span-8 space-y-4">
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div>
                                                                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Thứ tự</label>
                                                                <input type="number" name="images[{{ $index }}][sort_order]"
                                                                    value="{{ $image['sort_order'] ?? $index }}" min="0"
                                                                    class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-sm">
                                                            </div>
                                                            <div class="flex items-end">
                                                                <label class="flex items-center cursor-pointer">
                                                                    <input type="checkbox" name="images[{{ $index }}][is_primary]" value="1"
                                                                        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                        {{ ($image['is_primary'] ?? false) ? 'checked' : '' }}>
                                                                    <span class="ml-2 text-sm font-medium text-slate-700">Hình ảnh chính</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Card 3: Cấu hình giá (Dynamic) - Reusable Component --}}
                        @include('admin.components.price-configuration', [
                            'prices' => old('prices', []),
                            'inputName' => 'prices',
                            'title' => 'Cấu hình giá Nail'
                        ])

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
                                        <p class="text-xs text-slate-500">Cho phép nail hiển thị</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <select name="status" id="status"
                                            class="block rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Hoạt động</option>
                                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Dừng</option>
                                        </select>
                                    </label>
                                </div>

                                <div class="p-4 rounded-xl border border-amber-100 bg-amber-50">
                                    <h4 class="text-xs font-bold text-amber-800 uppercase mb-2">Lưu ý quản trị</h4>
                                    <ul class="text-xs text-amber-700 space-y-1 list-disc pl-4 italic">
                                        <li>Nail hoạt động sẽ hiển thị trên website.</li>
                                        <li>Hình ảnh chính sẽ được ưu tiên hiển thị.</li>
                                        <li>Giá mặc định sẽ được hiển thị đầu tiên.</li>
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
                            <button type="submit" form="main-nail-form"
                                class="w-full py-3 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-colors shadow-md">
                                Xác nhận Lưu Nail
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Media Manager Modal (Reusable Component) --}}
    @include('admin.components.media-manager-modal')

    @push('scripts')
        <script src="{{ asset('js/slug.js') }}"></script>
        <script src="{{ asset('js/format-currency.js') }}"></script>
        <script src="{{ asset('js/media-manager.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // 1. Initialize MinIO Media Manager
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

                // 2. Override confirmSelection to add rows to our specific form
                let imageIndex = {{ count(old('images', [])) }};
                
                // Recalculate index based on existing inputs in DOM to avoid collisions
                const updateImageIndex = () => {
                    const existingInputs = document.querySelectorAll('input[name^="images["][name$="][media_id]"]');
                    if(existingInputs.length > 0) {
                        imageIndex = Math.max(...Array.from(existingInputs).map(input => {
                            const match = input.name.match(/images\[(\d+)\]/);
                            return match ? parseInt(match[1]) : 0;
                        })) + 1;
                    }
                };
                updateImageIndex();

                mediaManager.confirmSelection = function() {
                    const selected = this.state.selectedItemsMap;
                    if (selected.size === 0) {
                        this.closeMediaModal();
                        return;
                    }

                    selected.forEach((item) => {
                        addNailImageRow(item.id, item.url);
                    });

                    this.closeMediaModal();
                    this.state.selectedItemsMap.clear();
                    this.updateStatus();
                }

                function addNailImageRow(mediaId, previewUrl) {
                    const html = `
                        <div class="image-item group bg-slate-50/50 p-5 rounded-2xl border border-slate-200 relative transition-all hover:shadow-md hover:border-blue-300">
                            <button type="button" class="absolute -top-3 -right-3 h-8 w-8 flex items-center justify-center bg-white text-slate-400 hover:text-red-600 rounded-full border border-slate-200 shadow-sm transition-all remove-image opacity-0 group-hover:opacity-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                                <div class="lg:col-span-4">
                                    <img src="${previewUrl}" class="w-full h-32 object-cover rounded-xl border border-gray-300 shadow-sm">
                                    <input type="hidden" name="images[${imageIndex}][media_id]" value="${mediaId}">
                                    <input type="hidden" name="images[${imageIndex}][preview_url]" value="${previewUrl}">
                                </div>
                                <div class="lg:col-span-8 space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Thứ tự</label>
                                            <input type="number" name="images[${imageIndex}][sort_order]" value="${imageIndex}" min="0"
                                                class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-sm">
                                        </div>
                                        <div class="flex items-end">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="checkbox" name="images[${imageIndex}][is_primary]" value="1"
                                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                <span class="ml-2 text-sm font-medium text-slate-700">Hình ảnh chính</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    document.getElementById('imagesContainer').insertAdjacentHTML('beforeend', html);
                    imageIndex++;
                }

                // Xóa hình ảnh
                document.getElementById('imagesContainer').addEventListener('click', function(e) {
                    if (e.target.closest('.remove-image')) {
                        e.target.closest('.image-item').remove();
                    }
                });
            });
        </script>
    @endpush

@endsection
