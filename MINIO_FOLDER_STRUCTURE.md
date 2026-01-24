# MinIO Media Library - Folder Structure Documentation

## 📁 Cấu trúc Folder trong MinIO

### Cách hoạt động:

#### 1. **Upload ảnh vào Root (không folder)**
```
MinIO Bucket: nail-media/
  └── media/
      └── uuid-123.jpg
```
- Path: `media/uuid-123.jpg`
- `folder_id`: `NULL`

#### 2. **Upload ảnh vào folder "nails"**
```
MinIO Bucket: nail-media/
  └── nails/
      └── uuid-456.jpg
```
- Path: `nails/uuid-456.jpg`
- `folder_id`: ID của folder "nails"

#### 3. **Upload ảnh vào nested folder "nails/hands"**
```
MinIO Bucket: nail-media/
  └── nails/
      └── hands/
          └── uuid-789.jpg
```
- Path: `nails/hands/uuid-789.jpg`
- `folder_id`: ID của folder "hands"

---

## 🗂️ Database Structure

### Table: `folders`
```sql
id | name  | parent_id
1  | nails | NULL
2  | hands | 1
3  | feet  | 1
```

### Table: `media`
```sql
id | file_path              | folder_id
1  | media/uuid-123.jpg     | NULL
2  | nails/uuid-456.jpg     | 1
3  | nails/hands/uuid-789.jpg | 2
```

---

## 🔄 Tự động hóa

### 1. **Upload ảnh**
- System tự động build path từ folder hierarchy
- Ví dụ: folder "hands" có parent "nails" → path = `nails/hands/filename.jpg`

### 2. **Xóa folder**
- Xóa folder "nails" → **TỰ ĐỘNG XÓA**:
  - ✅ Tất cả ảnh trong folder "nails"
  - ✅ Tất cả subfolder ("hands", "feet")
  - ✅ Tất cả ảnh trong subfolder
  - ✅ Files trên MinIO
  - ✅ Records trong database

### 3. **Folder hierarchy**
```
nails/                    (folder_id: 1)
  ├── hands/              (folder_id: 2, parent_id: 1)
  │   └── long/           (folder_id: 4, parent_id: 2)
  └── feet/               (folder_id: 3, parent_id: 1)
```

Khi xóa "nails" → xóa cả "hands", "long", "feet" và tất cả ảnh

---

## 🔧 Code Implementation

### Folder Model Methods:

#### `getFullPath()`
Build path từ root đến folder hiện tại:
```php
$folder->getFullPath(); // "nails/hands/long"
```

#### `getAllMedia()`
Lấy tất cả media trong folder và subfolder (recursive):
```php
$folder->getAllMedia(); // Collection of all media
```

#### `getAllSubfolders()`
Lấy tất cả subfolder (recursive):
```php
$folder->getAllSubfolders(); // Collection of all folders
```

---

## 📝 Example Usage

### Upload ảnh vào folder "nails/hands":
1. User chọn folder "hands" trong UI
2. Upload file
3. System:
   - Tìm folder "hands" (id: 2)
   - Build path: `nails/hands/` (từ hierarchy)
   - Upload file: `nails/hands/uuid-xxx.jpg`
   - Save to DB với `folder_id = 2`

### Xóa folder "nails":
1. User click xóa folder "nails"
2. System:
   - Tìm tất cả media trong "nails" và subfolder
   - Xóa files từ MinIO
   - Xóa media records từ DB
   - Xóa folder records từ DB (cascade)

---

## ⚠️ Lưu ý

1. **Không được xóa ảnh đang được sử dụng**
   - Check `nails_count` trước khi xóa
   - Nếu ảnh đang được dùng → báo lỗi

2. **Folder path tự động**
   - Không cần tạo folder thủ công trong MinIO
   - Laravel Storage tự động tạo khi upload

3. **Performance**
   - Foreign key constraint đảm bảo data integrity
   - Index trên `folder_id` để query nhanh
