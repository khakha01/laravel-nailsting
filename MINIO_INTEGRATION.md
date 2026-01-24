# Hướng Dẫn Tích Hợp MinIO & Media Library

Tài liệu này tổng hợp quy trình tích hợp MinIO để quản lý và upload ảnh, cùng cấu trúc Database chuẩn để tái sử dụng cho các dự án sau này.

---

## 1. Cấu Hình Môi Trường (Config & ENV)

Để Laravel giao tiếp được với MinIO (giao thức S3), cần cấu hình như sau:

### File `.env`
Thêm/Cập nhật các biến môi trường sau để kết nối MinIO:
```ini
FILESYSTEM_DISK=minio

AWS_ACCESS_KEY_ID=minioadmin
AWS_SECRET_ACCESS_KEY=minioadmin
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=laravel-bucket
AWS_ENDPOINT=http://127.0.0.1:9000
AWS_USE_PATH_STYLE_ENDPOINT=true
```

### File `config/filesystems.php`
Thêm driver `minio` vào mảng `disks`. Driver này sử dụng `s3` driver của Laravel nhưng trỏ về MinIO endpoint.

```php
'minio' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    'bucket' => env('AWS_BUCKET'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => true, // Bắt buộc cho MinIO
    'throw' => true,
],
```

---

## 2. Cấu Trúc Database (Core & Mở Rộng)

Mô hình này tách biệt **Lưu trữ (Storage)** và **Liên kết (Association)**, giúp hệ thống linh hoạt và tối ưu.

### A. Các Bảng Bắt Buộc (Core)
Đây là "xương sống" của hệ thống media, **luôn phải có** trong mọi dự án.

1.  **`folders`**: Quản lý thư mục (nếu có tính năng folder).
    *   `id`, `name`, `parent_id` (đệ quy).
2.  **`media`**: Lưu thông tin vật lý của file trên MinIO.
    *   `id`
    *   `file_path` (đường dẫn trên MinIO, vd: `media/abc-xyz.jpg`)
    *   `folder_id` (FK -> folders)
    *   `mime_type`, `size`
    *   `created_at`, `updated_at`

### B. Các Bảng Trung Gian (Pivot - Mở Rộng)
Khi một chức năng mới cần ảnh (ví dụ: Product, Post, User), **KHÔNG** sửa bảng `media`. Thay vào đó, tạo bảng trung gian.

**Ví dụ: Module Product cần nhiều ảnh**
Tạo bảng `product_media`:
*   `product_id` (FK -> products)
*   `media_id` (FK -> media)
*   `sort_order` (Sắp xếp ảnh)
*   `is_primary` (Ảnh đại diện)

**Ưu điểm:**
*   **Tái sử dụng:** Một ảnh trong thư viện có thể dùng cho nhiều bài viết/sản phẩm khác nhau mà không cần upload lại.
*   **Toàn vẹn dữ liệu:** Xóa sản phẩm không làm mất ảnh gốc trong kho `media`.

---

## 3. Quy Trình Xử Lý & Logic

### Backend (Laravel)
Controller (vd: `MediaController`) đóng vai trò API trung tâm:
1.  **List**: Trả về danh sách folder/file (JSON) theo `folder_id`.
2.  **Upload**:
    *   Nhận file từ Request.
    *   Dùng `Storage::disk('minio')->put(...)` bắn sang MinIO.
    *   Lưu thông tin metadata vào bảng `media`.
    *   Trả về JSON (URL ảnh, ID) để Frontend hiển thị ngay.

### Frontend (JS Standalone)
Logic Frontend được đóng gói vào **`public/js/media-manager.js`**.
*   Các file View (Blade) chỉ cần gọi script và khởi tạo.
*   Không viết JS inline lan man.

**Cách dùng trong View:**
```html
<!-- 1. Include cấu trúc HTML Modal (copy từ file mẫu) -->

<!-- 2. Gọi Script -->
<script src="{{ asset('js/media-manager.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new MediaManager({
            urls: {
                index: '{{ route("media.index") }}',
                folderStore: '{{ route("media.folders.store") }}',
                folderDelete: '{{ url("media/folders") }}',
                store: '{{ route("media.store") }}'
            },
            csrfToken: '{{ csrf_token() }}'
        });
    });
</script>


```

---

## Tổng Kết
*   **Env/Config**: Cấu hình 1 lần.
*   **DB Core (`media`)**: Dùng chung cho cả dự án.
*   **Tính năng mới**: Chỉ cần tạo bảng pivot `feature_media` -> Quan hệ Many-to-Many.
*   **Frontend**: Gọi `MediaManager`, tái sử dụng UI chọn ảnh ở mọi nơi.
