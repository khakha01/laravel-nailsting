Hãy viết code Module [Tên Module, ví dụ: Product] trong Laravel tuân thủ nghiêm ngặt kiến trúc Service-Repository Pattern kết hợp Cache Decorator theo các quy chuẩn sau:

Model:

Phải có static function make(...) để khởi tạo instance (thay vì fillable).

Các thuộc tính truyền vào make phải được định nghĩa rõ ràng type.

Repository Interface:

Định nghĩa các method CRUD và Query cần thiết.

Luôn return Type rõ ràng (?Model, Collection, bool).

Eloquent Repository:

Implement Interface trên.

Sử dụng Eloquent Model để truy vấn DB.

Sử dụng Eager Loading (with()) để tránh N+1 query.

Cache Repository (Decorator Pattern):

Implement Interface trên.

Dependency Injection: Inject RepositoryInterface vào constructor.

Logic:

Với hàm Đọc (find, get): Dùng Cache::remember (Redis) trước khi gọi repository gốc.

Với hàm Ghi (save, delete): Gọi repository gốc để thực thi, sau đó dùng hàm invalidateCache() để xóa các key cache liên quan.

Tách biệt key config vào file config hoặc property array.

Service:

Chứa business logic (validate unique, logic nghiệp vụ).

Gọi Repository để lưu trữ/lấy dữ liệu.

Return Model hoặc DTO, không return Response object.

Controller:

Gọi Service.

Xử lý try/catch và trả về Redirect/Response.
