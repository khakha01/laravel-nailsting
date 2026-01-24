# Admin Components

Thư mục này chứa các reusable components cho admin panel.

## Media Manager Modal Component

### Mô tả
Component modal để quản lý media (hình ảnh) với MinIO storage. Component này có thể được sử dụng ở bất kỳ view nào cần chức năng chọn ảnh từ thư viện.

### File
- `media-manager-modal.blade.php`

### Cách sử dụng

#### 1. Include component vào view

```blade
{{-- Đặt ở cuối view, trước @endsection --}}
@include('admin.components.media-manager-modal')
```

#### 2. Thêm button để mở modal

```blade
<button type="button" onclick="openMediaModal()" 
    class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
    </svg>
    Chọn ảnh từ thư viện
</button>
```

#### 3. Thêm scripts cần thiết

```blade
@push('scripts')
    <script src="{{ asset('js/media-manager.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Khởi tạo MediaManager
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

            // Override confirmSelection để xử lý khi user chọn ảnh
            mediaManager.confirmSelection = function() {
                const selected = this.state.selectedItemsMap;
                if (selected.size === 0) {
                    this.closeMediaModal();
                    return;
                }

                // Xử lý các ảnh đã chọn
                selected.forEach((item) => {
                    console.log('Selected media:', item.id, item.url);
                    // TODO: Thêm logic xử lý ảnh ở đây
                    // Ví dụ: addImageRow(item.id, item.url);
                });

                this.closeMediaModal();
                this.state.selectedItemsMap.clear();
                this.updateStatus();
            }
        });
    </script>
@endpush
```

#### 4. Container để hiển thị ảnh đã chọn

```blade
<div id="imagesContainer" class="space-y-4">
    {{-- Ảnh đã chọn sẽ được thêm vào đây bằng JavaScript --}}
</div>
```

### Ví dụ hoàn chỉnh

Xem các file sau để tham khảo cách sử dụng:
- `resources/views/admin/nail-management/create.blade.php`
- `resources/views/admin/nail-management/edit.blade.php`

### Các module có thể sử dụng

Component này có thể được sử dụng cho:
- ✅ Nail Management (đang sử dụng)
- ✅ Product Management
- ✅ Category Management
- ✅ User Profile Management
- ✅ Bất kỳ module nào cần chức năng upload/chọn ảnh

### Lưu ý

1. **Dependencies**: Cần có file `public/js/media-manager.js` để component hoạt động
2. **Routes**: Đảm bảo các routes media đã được định nghĩa trong `routes/web.php`
3. **Customization**: Có thể override function `confirmSelection()` để tùy chỉnh logic xử lý ảnh
4. **Multiple instances**: Component có thể được sử dụng nhiều lần trong cùng một page, nhưng cần đảm bảo các ID elements không bị trùng lặp

### Cấu trúc dữ liệu trả về

Khi user chọn ảnh, mỗi item sẽ có cấu trúc:

```javascript
{
    id: 123,           // Media ID
    url: 'https://...' // URL của ảnh
}
```

### Tùy chỉnh giao diện

Nếu cần tùy chỉnh giao diện modal, chỉnh sửa trực tiếp file `media-manager-modal.blade.php`. Các thay đổi sẽ áp dụng cho tất cả các view sử dụng component này.
