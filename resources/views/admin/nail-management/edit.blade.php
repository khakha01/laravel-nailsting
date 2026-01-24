@extends('admin.layouts.layout')

@section('title', 'Sửa nail')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">
        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Sửa Nail
                </h2>
                <p class="mt-1 text-sm text-gray-500">Cập nhật thông tin: <span class="font-semibold text-gray-900">{{ $nail->name }}</span></p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <a href="{{ route('nails.index') }}"
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

        <form action="{{ route('nails.update', $nail->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Column: Main Content --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Card 1: Thông tin chung --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-6 sm:p-8">
                            <h3 class="text-base font-semibold leading-6 text-gray-900 mb-6 border-b pb-2">Thông tin chung</h3>
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                {{-- Name --}}
                                <div class="sm:col-span-6">
                                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">
                                        Tên nail <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <input type="text" name="name" id="name" value="{{ old('name', $nail->name) }}" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Slug --}}
                                <div class="sm:col-span-6">
                                    <label for="slug" class="block text-sm font-medium leading-6 text-gray-900">
                                        Slug <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <input type="text" name="slug" id="slug" value="{{ old('slug', $nail->slug) }}" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6 bg-gray-50"
                                            placeholder="tu-dong-tao-tu-ten">
                                        @error('slug')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="sm:col-span-6">
                                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Mô tả chi tiết</label>
                                    <div class="mt-2">
                                        <textarea id="description" name="description" rows="4"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">{{ old('description', $nail->description) }}</textarea>
                                        @error('description')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Hình ảnh (MinIO Integration) --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="flex items-center justify-between mb-6 border-b pb-2">
                                <h3 class="text-base font-semibold leading-6 text-gray-900">Hình ảnh</h3>
                                <button type="button" onclick="openMediaModal()"
                                    class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Chọn ảnh từ thư viện
                                </button>
                            </div>

                            <div id="imagesContainer" class="space-y-4">
                                @php
                                    // Prepare old images or load from DB
                                    $oldImages = old('images', $nail->images->map(fn($img) => [
                                        'media_id' => $img->media_id,
                                        'preview_url' => $img->media ? $img->media->url : '',
                                        'is_primary' => $img->is_primary,
                                        'sort_order' => $img->sort_order,
                                    ])->toArray());
                                @endphp

                                @foreach ($oldImages as $index => $image)
                                    @if(isset($image['media_id']))
                                        <div class="image-item bg-gray-50 p-4 rounded-lg border border-gray-200 relative group">
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
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Hình ảnh</label>
                                                    <div class="mt-2">
                                                        <img src="{{ $image['preview_url'] ?? '#' }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                                        <input type="hidden" name="images[{{ $index }}][media_id]" value="{{ $image['media_id'] }}">
                                                        <input type="hidden" name="images[{{ $index }}][preview_url]" value="{{ $image['preview_url'] ?? '' }}">
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
                                                                {{ ($image['is_primary'] ?? false) ? 'checked' : '' }}>
                                                            <label class="ml-2 text-sm text-gray-700">Hình ảnh chính</label>
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
                    @php
                        $prices = old('prices', $nail->prices->toArray());
                    @endphp
                    @include('admin.components.price-configuration', [
                        'prices' => $prices,
                        'inputName' => 'prices',
                        'title' => 'Cấu hình giá Nail'
                    ])

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
                                        <option value="active" {{ old('status', $nail->status) === 'active' ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="inactive" {{ old('status', $nail->status) === 'inactive' ? 'selected' : '' }}>Dừng</option>
                                    </select>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Hoạt động: Nail sẽ hiển thị trên website.<br>
                                Dừng: Nail sẽ bị ẩn đi.
                            </p>

                            <hr class="my-4 border-gray-100">

                            <div class="space-y-2">
                                <p class="text-xs text-gray-500 flex justify-between">
                                    <span>Ngày tạo:</span>
                                    <span class="font-medium text-gray-700">{{ $nail->created_at->format('d/m/Y H:i') }}</span>
                                </p>
                                <p class="text-xs text-gray-500 flex justify-between">
                                    <span>Cập nhật cuối:</span>
                                    <span class="font-medium text-gray-700">{{ $nail->updated_at->format('d/m/Y H:i') }}</span>
                                </p>
                            </div>
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
                                Cập Nhật
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
                let imageIndex = {{ count($oldImages) }};
                
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
                
                // Track deleted images if needed (though we just remove from DOM for now)

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
                        <div class="image-item bg-gray-50 p-4 rounded-lg border border-gray-200 relative group">
                            <button type="button" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 remove-image transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Hình ảnh</label>
                                    <div class="mt-2">
                                        <img src="${previewUrl}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                        <input type="hidden" name="images[${imageIndex}][media_id]" value="${mediaId}">
                                        <input type="hidden" name="images[${imageIndex}][preview_url]" value="${previewUrl}">
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
