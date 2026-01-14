# 📋 Chuẩn Kiến Trúc - BookingDate (A-Z)

**Tài liệu này định nghĩa quy trình hoàn chỉnh và chuẩn kiến trúc cho tính năng BookingDate từ Backend đến Frontend.**

---

## 📚 Mục Lục
1. [Tổng Quan Quy Trình](#tổng-quan-quy-trình)
2. [Cấu Trúc Thư Mục](#cấu-trúc-thư-mục)
3. [Chuẩn Đặt Tên](#chuẩn-đặt-tên)
4. [Chi Tiết Các Layer](#chi-tiết-các-layer)
5. [Views CRUD - TailwindCSS](#views-crud---tailwindcss-bắt-buộc)
6. [Ví Dụ Hoàn Chỉnh](#ví-dụ-hoàn-chỉnh)
7. [Quy Tắc Chung](#quy-tắc-chung)

---

## 🔄 Tổng Quan Quy Trình

### Request-Response Flow

```
Frontend (Blade View/Vue/React)
         ↓
    Routes (web.php)
         ↓
    Controller (Admin/BookingDateController)
         ↓
    FormRequest Validation (StoreBookingDateRequest)
         ↓
    Service Layer (BookingDateService)
         ↓
    Query Handler (ListBookingDateHandler)
         ↓
    Repository + Cache (BookingDateRepository)
         ↓
    Model (BookingDate)
         ↓
    Database (booking_dates table)
```

### Các Thao Tác Chính
- **CREATE**: Tạo booking date mới với time slots
- **READ**: Lấy danh sách, chi tiết booking date
- **UPDATE**: Cập nhật booking date và time slots
- **DELETE**: Xóa single hoặc bulk

---

## 📁 Cấu Trúc Thư Mục

### Cấu trúc Backend
```
app/
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   │       ├── BookingDateController.php     # Main controller
│   │       └── DashboardController.php
│   └── Requests/
│       └── BookingDates/
│           ├── StoreBookingDateRequest.php   # Create validation
|           |── DeleteBookingDateRequest.php  # Delete validation
│           └── UpdateBookingDateRequest.php  # Update validation
|           
│
├── Models/
│   ├── BookingDate.php                        # Main model
│   └── BookingTimeSlot.php                    # Related model
│
├── Repositories/
│   └── BookingDate/
│       ├── BookingDateRepositoryInterface.php # Contract
│       ├── BookingDateRepository.php          # Implementation
│       └── BookingDateRepositoryCache.php     # Caching decorator
│
├── Services/
│   └── BookingDate/
│       └── BookingDateService.php             # Business logic
│
├── Queries/
│   └── ListBookingDates/
│       ├── ListBookingDateQuery.php           # Query object
│       └── ListBookingDateHandler.php         # Query handler
│
└── Providers/
    └── AppServiceProvider.php                 # DI bindings

database/
├── migrations/
│   ├── 2026_01_12_161133_create_booking_dates_table.php
│   └── 2026_01_12_161303_create_booking_time_slots_table.php
└── factories/

config/
└── cache_keys.php                             # Cache key definitions

routes/
└── web.php                                    # Route definitions

resources/
└── views/
    └── admin/
        └── booking-date-management/
            ├── index.blade.php                # List view
            ├── create.blade.php               # Create form view
            └── edit.blade.php                 # Edit form view
```

---

## 📝 Chuẩn Đặt Tên

### 1. **Model & Table Name**
```php
// Model Class
class BookingDate extends Model { }           // PascalCase, Singular

// Table Name
protected $table = 'booking_dates';            // snake_case, Plural

// Related Model
class BookingTimeSlot extends Model { }        // PascalCase, Singular
protected $table = 'booking_time_slots';      // snake_case, Plural
```

### 2. **Repository Pattern**
```
BookingDate{Entity}Repository{Suffix}
├── BookingDateRepositoryInterface            # Contract (Interface)
├── BookingDateRepository                      # Implementation
└── BookingDateRepositoryCache                 # Decorator (Optional cache)
```

**Quy tắc:**
- Interface luôn có suffix `Interface`
- Implementation không suffix (base class)
- Decorator/Cache có suffix `Cache`, `Eloquent`, etc.

### 3. **Service Layer**
```
{Entity}Service
└── BookingDateService
```

**Quy tắc:**
- Service class tên: `{EntityName}Service`
- Public methods: `{action}Service` (vd: `createService`, `updateService`)
- Riêng `getAll()` không suffix

### 4. **Controller Methods**
```php
public function index()      // List all (with pagination)
public function create()     // Show create form
public function store()      // Store new record
public function show()       // Show single record
public function edit()       // Show edit form
public function update()     // Update record
public function destroy()    // Delete single record
public function bulkDelete() // Delete multiple records
```

### 5. **FormRequest Classes**
```
{Action}{Entity}Request
├── StoreBookingDateRequest         // Create form validation
├── UpdateBookingDateRequest        // Update form validation
└── DestroyBookingDateRequest       // Delete validation (optional)
```

### 6. **Query Pattern (CQRS)**
```
List{Entity}Query
├── ListBookingDateQuery             # Query object (DTO)
└── ListBookingDateHandler           # Query handler
```

**Quy tắc:**
- Query class: `List{EntityName}Query`
- Handler class: `List{EntityName}Handler`
- Query object chứa filter parameters
- Handler execute query và return paginated result

### 7. **View Files (Blade Templates)**
```
resources/views/admin/
└── booking-date-management/
    ├── index.blade.php              # List view
    ├── create.blade.php             # Create form
    └── edit.blade.php               # Edit form
```

**Quy tắc:**
- Thư mục: `{entity-name}-management` (kebab-case)
- File: `{action}.blade.php`

### 8. **Route Names**
```php
Route::prefix('booking-dates')->group(function () {
    Route::get('/list', [...])->name('booking-dates.index');
    Route::get('/create', [...])->name('booking-dates.create');
    Route::post('/store', [...])->name('booking-dates.store');
    Route::get('/{id}', [...])->name('booking-dates.show');
    Route::put('/update/{id}', [...])->name('booking-dates.update');
    Route::delete('/{id}', [...])->name('booking-dates.delete');
    Route::delete('/bulk-delete', [...])->name('booking-dates.bulk-delete');
});
```

**Quy tắc:**
- Route prefix: `kebab-case` (plural)
- Route name: `{prefix}.{action}`
- ID parameter: `/{id}` hoặc `/{bookingDateId}`

### 9. **Cache Keys**
```php
// config/cache_keys.php
'booking_dates' => [
    'prefix' => 'booking_dates',
    'open' => 'booking_dates:open',
    'by_id' => 'booking_dates:id:%s',
],
```

**Quy tắc:**
- Prefix: `snake_case` table name
- Key format: `{prefix}:{category}:{identifier}`
- Placeholder: `:%s` cho sprintf()

### 10. **Database Column Names**
```php
// Naming Convention
$table->id();                           // Primary key: id
$table->date('date')->unique();        // Field: snake_case
$table->boolean('is_open');            // Boolean prefix: is_, has_, can_
$table->timestamps();                  // created_at, updated_at

// Foreign Key
$table->foreignId('booking_date_id')   // {table_singular}_id
    ->constrained('booking_dates')
    ->onDelete('cascade');
```

---

## 🏗️ Chi Tiết Các Layer

### Layer 1: **Model** (`app/Models/`)

**Tên File**: `{EntityName}.php`  
**Namespace**: `App\Models`

```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookingDate extends Model
{
    protected $table = 'booking_dates';
    
    protected $fillable = [
        'date',
        'is_open',
    ];
    
    protected $casts = [
        'date' => 'date',
        'is_open' => 'boolean',
    ];
    
    // ===== Relations =====
    public function timeSlots(): HasMany
    {
        return $this->hasMany(BookingTimeSlot::class);
    }
    
    // ===== Factory Methods =====
    public static function make(string $date, bool $isOpen = true, array $timeSlots = []): static
    {
        $model = new static([
            'date'    => $date,
            'is_open' => $isOpen,
        ]);
        
        if ($timeSlots !== []) {
            $slots = collect($timeSlots)->map(fn(array $slot) => BookingTimeSlot::make(
                $slot['start'],
                $slot['end'],
                $slot['is_open'] ?? true
            ));
            $model->setRelation('timeSlots', $slots);
        }
        
        return $model;
    }
}
```

**Quy tắc:**
- Table name explicit: `protected $table = 'booking_dates'`
- Fillable fields rõ ràng
- Casts định type chính xác
- Relations public methods
- Factory methods tĩnh: `static function make(...)`
- Relations after Methods, Methods after Accessors

---

### Layer 2: **Migration** (`database/migrations/`)

**Tên File**: `YYYY_MM_DD_HHMMSS_create_{table_name}_table.php`  
**Quy tắc Tên**: Thứ tự thời gian, tên table plural, snake_case

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_dates', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->boolean('is_open')->default(true);
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('booking_dates');
    }
};
```

**Quy tắc:**
- Filename bắt đầu với timestamp
- Table tên plural, snake_case
- Index & constraints explicit
- Default values specified
- Always có up() và down()

---

### Layer 3: **Repository Interface** (`app/Repositories/{Entity}/`)

**Tên File**: `{Entity}RepositoryInterface.php`  
**Namespace**: `App\Repositories\{Entity}`

```php
<?php
namespace App\Repositories\BookingDate;

use App\Models\BookingDate;
use Illuminate\Support\Collection;

interface BookingDateRepositoryInterface
{
    public function findById(int $id): ?BookingDate;
    
    public function findByIds(array $ids): Collection;
    
    public function getAll(): Collection;
    
    public function save(BookingDate $bookingDate): BookingDate;
    
    public function delete(BookingDate $bookingDate): bool;
}
```

**Quy tắc:**
- Interface định nghĩa contract đầy đủ
- Method names động từ: find, get, save, delete
- Return type explicit: ?Model, Collection, bool
- Không chứa implementation logic

---

### Layer 4: **Repository Implementation** (`app/Repositories/{Entity}/`)

**Tên File**: `{Entity}Repository.php`  
**Namespace**: `App\Repositories\{Entity}`

```php
<?php
namespace App\Repositories\BookingDate;

use App\Models\BookingDate;
use Illuminate\Support\Collection;

class BookingDateRepository implements BookingDateRepositoryInterface
{
    public function findById(int $id): ?BookingDate
    {
        return BookingDate::with('timeSlots')->find($id);
    }
    
    public function findByIds(array $ids): Collection
    {
        return BookingDate::with('timeSlots')
            ->whereIn('id', $ids)
            ->get();
    }
    
    public function getAll(): Collection
    {
        return BookingDate::query()
            ->orderBy('date')
            ->get();
    }
    
    public function save(BookingDate $bookingDate): BookingDate
    {
        $bookingDate->save();
        return $bookingDate;
    }
    
    public function delete(BookingDate $bookingDate): bool
    {
        return $bookingDate->delete();
    }
}
```

**Quy tắc:**
- Implement Interface
- Chỉ chứa database query logic
- Eager load relations khi cần
- Return type match interface

---

### Layer 5: **Repository Cache Decorator** (BẮTBUỘC - Redis)

**Tên File**: `{Entity}RepositoryCache.php`  
**Namespace**: `App\Repositories\{Entity}`

```php
<?php
namespace App\Repositories\BookingDate;

use App\Models\BookingDate;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class BookingDateRepositoryCache implements BookingDateRepositoryInterface
{
    protected CacheRepository $cache;
    protected array $keys;
    
    public function __construct(protected BookingDateRepositoryInterface $bookingDateRepository)
    {
        $this->cache = Cache::driver('redis');
        $this->keys = config('cache_keys.booking_dates');
    }
    
    protected function cacheKey(int $id): string
    {
        return sprintf($this->keys['by_id'], $id);
    }
    
    public function findById(int $id): ?BookingDate
    {
        return $this->cache->remember(
            $this->cacheKey($id),
            now()->addMinutes(10),
            fn() => $this->bookingDateRepository->findById($id)
        );
    }
    
    public function save(BookingDate $bookingDate): BookingDate
    {
        $this->cache->forget($this->cacheKey($bookingDate->id));
        $this->cache->forget($this->keys['open']);
        return $this->bookingDateRepository->save($bookingDate);
    }
    
    public function delete(BookingDate $bookingDate): bool
    {
        $this->cache->forget($this->cacheKey($bookingDate->id));
        $this->cache->forget($this->keys['open']);
        return $this->bookingDateRepository->delete($bookingDate);
    }
    
    public function getAll(): Collection
    {
        return $this->cache->remember(
            $this->keys['open'],
            now()->addMinutes(10),
            fn() => $this->bookingDateRepository->getAll()
        );
    }
}
```

**Quy tắc:**
- **DECORATOR PATTERN**: Wrap another repository
- **Implement same interface**: Transparent substitution
- **Cache Driver**: Redis (config driver('redis'))
- **Invalidate cache**: Xóa cache key khi save/delete/bulkDelete
- **TTL explicit**: `now()->addMinutes(10)` (có thể tuỳ chỉnh)
- **Cache keys từ config**: `config('cache_keys.{entity}')`
- **Key format**: `{prefix}:{category}:{identifier}`
- **remember() pattern**: `$cache->remember(key, ttl, callable)`

### 🔄 Cache Flow

```
1. Client requests data
   ↓
2. CacheDecorator::findById(id)
   ↓
3. Check Redis cache for 'booking_dates:id:1'
   ↓
4. Cache HIT → Return cached model
   Cache MISS → Call Repository.findById()
   ↓
5. Repository queries database
   ↓
6. Store in Redis for 10 minutes
   ↓
7. Return to Controller

8. On Save/Delete/Update:
   ↓
   CacheDecorator invalidates related keys
   ↓
   Next request gets fresh data from DB
```

### 💾 Cache Keys Structure

```php
'booking_dates' => [
    'prefix' => 'booking_dates',           // Namespace
    'open' => 'booking_dates:open',        // All open dates list
    'by_id' => 'booking_dates:id:%s',      // Single date: booking_dates:id:1
],
```

**Sử dụng sprintf():**
```php
sprintf($this->keys['by_id'], $id)  // booking_dates:id:1
```

---

### Layer 6: **Service Layer** (`app/Services/{Entity}/`)

**Tên File**: `{Entity}Service.php`  
**Namespace**: `App\Services\{Entity}`

```php
<?php
namespace App\Services\BookingDate;

use App\Models\BookingDate;
use App\Models\BookingTimeSlot;
use App\Repositories\BookingDate\BookingDateRepositoryInterface;
use App\Repositories\BookingTimeSlot\BookingTimeSlotRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookingDateService
{
    public function __construct(
        protected BookingDateRepositoryInterface $bookingDateRepository,
        protected BookingTimeSlotRepositoryInterface $bookingTimeSlotRepository
    ) {}
    
    // ===== READ =====
    public function getAll()
    {
        return $this->bookingDateRepository->getAll();
    }
    
    public function findById(int $id): BookingDate
    {
        $bookingDate = $this->bookingDateRepository->findById($id);
        if (!$bookingDate) {
            throw new NotFoundHttpException("Not exists");
        }
        return $bookingDate;
    }
    
    // ===== CREATE =====
    public function createService(string $date, bool $isOpen, array $timeSlots): BookingDate
    {
        // Validate
        $dateExists = BookingDate::where('date', $date)->first();
        if ($dateExists) {
            throw new Exception('Lịch làm việc này đã tồn tại!');
        }
        
        // Create with transaction
        $bookingDate = BookingDate::make($date, $isOpen, $timeSlots);
        return DB::transaction(function () use ($bookingDate, $timeSlots) {
            $bookingDate = $this->bookingDateRepository->save($bookingDate);
            
            foreach ($timeSlots as $slotData) {
                $slot = BookingTimeSlot::make(
                    $slotData['start'],
                    $slotData['end'],
                    $slotData['is_open'] ?? true
                );
                $slot->booking_date_id = $bookingDate->id;
                $this->bookingTimeSlotRepository->save($slot);
            }
            
            return $bookingDate;
        });
    }
    
    // ===== UPDATE =====
    public function updateService(int $id, string $date, bool $isOpen, array $timeSlots): BookingDate
    {
        $bookingDate = $this->bookingDateRepository->findById($id);
        if (!$bookingDate) {
            throw new InvalidArgumentException("Booking date not found");
        }
        
        $bookingDate->date = $date;
        $bookingDate->is_open = $isOpen;
        
        return DB::transaction(function () use ($bookingDate, $id, $timeSlots) {
            $bookingDate = $this->bookingDateRepository->save($bookingDate);
            
            // Delete old time slots
            $oldSlots = $this->bookingTimeSlotRepository->getByBookingDate($id);
            foreach ($oldSlots as $slot) {
                $this->bookingTimeSlotRepository->delete($slot);
            }
            
            // Save new time slots
            foreach ($timeSlots as $slotData) {
                $slot = BookingTimeSlot::make(
                    $slotData['start'],
                    $slotData['end'],
                    $slotData['is_open'] ?? true
                );
                $slot->booking_date_id = $bookingDate->id;
                $this->bookingTimeSlotRepository->save($slot);
            }
            
            return $bookingDate;
        });
    }
    
    // ===== DELETE =====
    public function deleteService(int $id): void
    {
        $bookingDate = $this->bookingDateRepository->findById($id);
        if (!$bookingDate) {
            throw new NotFoundHttpException("Not exists");
        }
        
        DB::transaction(function () use ($bookingDate) {
            foreach ($bookingDate->timeSlots as $slot) {
                $this->bookingTimeSlotRepository->delete($slot);
            }
            $this->bookingDateRepository->delete($bookingDate);
        });
    }
    
    public function bulkDeleteService(array $bookingDateIds): void
    {
        DB::transaction(function () use ($bookingDateIds) {
            $bookingDates = $this->bookingDateRepository->findByIds($bookingDateIds);
            
            foreach ($bookingDates as $bookingDate) {
                foreach ($bookingDate->timeSlots as $slot) {
                    $this->bookingTimeSlotRepository->delete($slot);
                }
                $this->bookingDateRepository->delete($bookingDate);
            }
        });
    }
}
```

**Quy tắc:**
- Chứa business logic phức tạp
- Public methods có suffix `Service`: `createService()`, `updateService()`
- Exception: `getAll()`, `findById()` không suffix
- Constructor injection repositories
- DB::transaction() cho multi-step operations
- Exception handling rõ ràng
- Organized by action: READ, CREATE, UPDATE, DELETE

---

### Layer 7: **Query Pattern (Optional CQRS)** (`app/Queries/`)

**Query DTO:**
```php
<?php
namespace App\Queries\ListBookingDates;

class ListBookingDateQuery
{
    public function __construct(
        public int $page = 1,
        public int $perPage = 10,
        public ?string $date = null,
        public ?bool $isOpen = null
    ) {
        $this->date = trim($this->date ?? '');
    }
}
```

**Query Handler:**
```php
<?php
namespace App\Queries\ListBookingDates;

use App\Models\BookingDate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListBookingDateHandler
{
    public function execute(ListBookingDateQuery $query): LengthAwarePaginator
    {
        $builder = BookingDate::query();
        
        if ($query->date) {
            $builder->whereDate('date', $query->date);
        }
        
        if ($query->isOpen !== null) {
            $builder->where('is_open', $query->isOpen);
        }
        
        $builder->orderBy('date');
        
        return $builder->paginate(
            $query->perPage,
            ['*'],
            'page',
            $query->page
        );
    }
}
```

**Quy tắc:**
- Query object: DTO chứa filter parameters
- Handler: `execute(QueryObject): Result`
- Query object constructor data normalize
- Handler chỉ chứa query building logic

---

### Layer 8: **FormRequest Validation** (`app/Http/Requests/`)

**Create Request:**
```php
<?php
namespace App\Http\Requests\BookingDates;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingDateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'is_open' => ['nullable', 'boolean'],
            
            'time_slots' => ['nullable', 'array'],
            'time_slots.*.start' => ['nullable', 'date_format:H:i'],
            'time_slots.*.end' => ['nullable', 'date_format:H:i'],
            'time_slots.*.is_open' => ['required', 'boolean'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'date.required' => 'Vui lòng chọn ngày',
            'date.date' => 'Ngày không hợp lệ',
            'time_slots.*.start.date_format' => 'Giờ bắt đầu không đúng định dạng',
        ];
    }
}
```

**Update Request:**
```php
<?php
namespace App\Http\Requests\BookingDates;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingDateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'date' => [
                'required',
                'date',
                'unique:booking_dates,date,' . $this->route('id') . ',id'
            ],
            'is_open' => ['required', 'boolean'],
            'time_slots' => ['nullable', 'array'],
            'time_slots.*.start' => ['required_with:time_slots.*.end', 'date_format:H:i'],
            'time_slots.*.end' => ['required_with:time_slots.*.start', 'date_format:H:i'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'date.required' => 'Ngày là bắt buộc.',
            'date.unique' => 'Ngày đã tồn tại.',
        ];
    }
}
```

**Quy tắc:**
- Tên: `{Action}{Entity}Request`
- Methods: `authorize()`, `rules()`, `messages()`
- Rules array format (Laravel 8+)
- Messages tiếng Việt rõ ràng
- Update: add unique constraint exception

---

### Layer 9: **Controller** (`app/Http/Controllers/`)

**Tên File**: `{Entity}Controller.php`  
**Namespace**: `App\Http\Controllers\Admin`

```php
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingDates\StoreBookingDateRequest;
use App\Http\Requests\BookingDates\UpdateBookingDateRequest;
use App\Queries\ListBookingDates\ListBookingDateHandler;
use App\Queries\ListBookingDates\ListBookingDateQuery;
use App\Services\BookingDate\BookingDateService;
use Illuminate\Http\Request;

class BookingDateController extends Controller
{
    public function __construct(
        protected BookingDateService $bookingDateService
    ) {}
    
    // ===== LIST & PAGINATION =====
    public function index(Request $request)
    {
        $isOpen = $request->filled('is_open') ? (bool) $request->get('is_open') : null;
        
        $query = new ListBookingDateQuery(
            page: (int) ($request->get('page', 1)),
            perPage: (int) ($request->get('perPage', 10)),
            date: $request->get('date'),
            isOpen: $isOpen
        );
        
        $dates = app(ListBookingDateHandler::class)->execute($query);
        
        return view('admin.booking-date-management.index', compact('dates'));
    }
    
    // ===== SHOW CREATE FORM =====
    public function create()
    {
        return view('admin.booking-date-management.create');
    }
    
    // ===== STORE NEW =====
    public function store(StoreBookingDateRequest $request)
    {
        try {
            $this->bookingDateService->createService(
                $request->get('date'),
                (bool) $request->get('is_open'),
                $request->get('time_slots')
            );
            
            return redirect()
                ->route('booking-dates.index')
                ->with('success', 'Tạo ngày & khung giờ thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('booking-dates.index')
                ->with('error', $e->getMessage());
        }
    }
    
    // ===== SHOW DETAIL & EDIT FORM =====
    public function show(Request $request)
    {
        $id = (int) $request->route('id');
        $bookingDate = $this->bookingDateService->findById($id);
        return view('admin.booking-date-management.edit', compact('bookingDate'));
    }
    
    // ===== UPDATE =====
    public function update(UpdateBookingDateRequest $request)
    {
        $bookingDateId = (int) $request->route('id');
        
        try {
            $this->bookingDateService->updateService(
                $bookingDateId,
                $request->get('date'),
                $request->get('is_open'),
                $request->get('time_slots')
            );
            
            return redirect()
                ->route('booking-dates.index')
                ->with('success', 'Cập nhật ngày & khung giờ thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('booking-dates.index')
                ->with('error', $e->getMessage());
        }
    }
    
    // ===== DELETE SINGLE =====
    public function destroy(Request $request)
    {
        try {
            $id = (int) $request->route('id');
            $this->bookingDateService->deleteService($id);
            
            return redirect()
                ->route('booking-dates.index')
                ->with('success', 'Hành động xóa thành công');
        } catch (\Throwable $e) {
            return redirect()
                ->route('booking-dates.index')
                ->with('error', $e->getMessage());
        }
    }
    
    // ===== DELETE BULK =====
    public function bulkDelete(Request $request)
    {
        try {
            $bookingDateIds = $request->input('booking_date_ids', []);
            $this->bookingDateService->bulkDeleteService($bookingDateIds);
            
            return redirect()
                ->route('booking-dates.index')
                ->with('success', 'Đã xóa thành công các ngày đã chọn.');
        } catch (\Throwable $e) {
            return redirect()
                ->route('booking-dates.index')
                ->with('error', $e->getMessage());
        }
    }
}
```

**Quy tắc:**
- Constructor inject Service
- Methods: index, create, store, show, update, destroy, bulkDelete
- Wrap service calls in try-catch
- FormRequest auto-validate
- Return view/redirect with messages
- Organized by action with comments

---

### Layer 10: **Routes** (`routes/web.php`)

```php
<?php
use App\Http\Controllers\Admin\BookingDateController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::group(['prefix' => 'booking-dates', 'as' => 'booking-dates.'], function () {
        Route::get('/list', [BookingDateController::class, 'index'])->name('index');
        Route::get('/create', [BookingDateController::class, 'create'])->name('create');
        Route::post('/store', [BookingDateController::class, 'store'])->name('store');
        Route::delete('/bulk-delete', [BookingDateController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('/{id}', [BookingDateController::class, 'show'])->whereNumber('id')->name('show');
        Route::put('/update/{id}', [BookingDateController::class, 'update'])->name('update');
        Route::delete('/{id}', [BookingDateController::class, 'destroy'])->name('delete');
    });
});
```

**Quy tắc:**
- `prefix`: kebab-case, plural
- `as`: route name prefix
- Method parameter: `whereNumber('id')`
- RESTful conventions

---

### Layer 11: **Views** (`resources/views/admin/booking-date-management/`)

**index.blade.php** - List View
```blade
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Quản Lý Lịch Làm Việc</h1>
    
    <a href="{{ route('booking-dates.create') }}" class="btn btn-primary">Thêm Mới</a>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif
    
    <table class="table">
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dates as $date)
                <tr>
                    <td>{{ $date->date->format('d/m/Y') }}</td>
                    <td>{{ $date->is_open ? 'Mở' : 'Đóng' }}</td>
                    <td>
                        <a href="{{ route('booking-dates.show', $date->id) }}" class="btn btn-sm btn-info">Sửa</a>
                        <form method="POST" action="{{ route('booking-dates.delete', $date->id) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">Không có dữ liệu</td></tr>
            @endforelse
        </tbody>
    </table>
    
    {{ $dates->links() }}
</div>
@endsection
```

**create.blade.php** - Create Form
```blade
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Thêm Lịch Làm Việc</h1>
    
    <form method="POST" action="{{ route('booking-dates.store') }}">
        @csrf
        
        <div class="form-group">
            <label>Ngày <span class="text-danger">*</span></label>
            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" required>
            @error('date')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Trạng Thái</label>
            <input type="checkbox" name="is_open" value="1" checked>
            <span>Mở cửa</span>
        </div>
        
        <div class="form-group">
            <label>Khung Giờ</label>
            <div id="time-slots">
                <div class="time-slot">
                    <input type="time" name="time_slots[0][start]" placeholder="Giờ bắt đầu">
                    <input type="time" name="time_slots[0][end]" placeholder="Giờ kết thúc">
                    <input type="checkbox" name="time_slots[0][is_open]" value="1">
                </div>
            </div>
            <button type="button" id="add-slot" class="btn btn-sm btn-secondary">Thêm Khung Giờ</button>
        </div>
        
        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
</div>
@endsection
```

**Quy tắc:**
- Extend layout
- Form method POST/PUT/DELETE with @csrf
- Error display @error/@enderror
- Loop data @forelse/@empty
- Pagination {{ $dates->links() }}

---

## 🎨 Views CRUD - TailwindCSS (Bắt Buộc)

### Chuẩn Design

Tất cả Views CRUD phải sử dụng **TailwindCSS** với cấu trúc chuẩn:

**Responsive Grid Layout:**
```blade
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Main content -->
</div>
```

**Card Components:**
```blade
<div class="bg-white rounded-lg shadow">
    <div class="px-4 py-5 sm:px-6">
        <!-- Header -->
    </div>
    <div class="border-t border-gray-200">
        <!-- Content -->
    </div>
</div>
```

**Form Elements:**
```blade
<div class="space-y-6">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">
            Tên <span class="text-red-500">*</span>
        </label>
        <input 
            type="text" 
            name="name" 
            id="name"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('name') border-red-500 @enderror"
            placeholder="Nhập tên"
        >
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
```

**Buttons:**
```blade
<!-- Primary Action -->
<button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
    <i class="bi bi-save mr-2"></i> Lưu
</button>

<!-- Secondary Action -->
<button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
    <i class="bi bi-x-circle mr-2"></i> Hủy
</button>

<!-- Danger Action -->
<button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
    <i class="bi bi-trash mr-2"></i> Xóa
</button>
```

**Alert Messages:**
```blade
<!-- Success Alert -->
@if ($message = Session::get('success'))
    <div class="rounded-md bg-green-50 p-4 mb-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="h-5 w-5 text-green-400 bi bi-check-circle"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ $message }}</p>
            </div>
            <button type="button" class="ml-auto text-green-400 hover:text-green-500">
                <span class="sr-only">Đóng</span>
                <i class="bi bi-x"></i>
            </button>
        </div>
    </div>
@endif

<!-- Error Alert -->
@if ($message = Session::get('error'))
    <div class="rounded-md bg-red-50 p-4 mb-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="h-5 w-5 text-red-400 bi bi-exclamation-circle"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800">{{ $message }}</p>
            </div>
        </div>
    </div>
@endif
```

**Table with Hover:**
```blade
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                    Cột 1
                </th>
                <th class="relative px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                    Hành động
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @forelse($items as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $item->name }}
                    </td>
                    <td class="relative px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('items.show', $item->id) }}" class="text-blue-600 hover:text-blue-900">
                            Sửa
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                        Không có dữ liệu
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
```

**Pagination:**
```blade
<div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
    <div class="flex-1 flex justify-between sm:hidden">
        {{ $items->links() }}
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        {{ $items->links() }}
    </div>
</div>
```

**Checkbox & Selection:**
```blade
<div class="flex items-center">
    <input 
        type="checkbox" 
        id="select-all"
        class="h-4 w-4 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
    >
    <label for="select-all" class="ml-2 text-sm text-gray-700">
        Chọn tất cả
    </label>
</div>
```

### 📋 List View (index.blade.php) Pattern

```blade
@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold leading-7 text-gray-900">Quản Lý Danh Mục</h1>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                <i class="bi bi-plus-circle -ml-1 mr-2"></i>Thêm Mới
            </a>
        </div>
    </div>

    <!-- Alerts -->
    @if ($message = Session::get('success'))
        <div class="rounded-md bg-green-50 p-4">
            <i class="bi bi-check-circle text-green-400"></i>
            {{ $message }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <form method="GET" action="{{ route('categories.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <input type="text" name="search" placeholder="Tìm kiếm..." 
                           class="block w-full rounded-md border-gray-300 shadow-sm">
                    <select name="is_active" class="block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Trạng thái --</option>
                        <option value="1">Hoạt động</option>
                        <option value="0">Đã tắt</option>
                    </select>
                    <button type="submit" class="inline-flex justify-center px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">
                        <i class="bi bi-search"></i> Tìm kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Tên</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Slug</th>
                    <th class="relative px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->slug }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a href="{{ route('categories.show', $category->id) }}" class="text-blue-600 hover:text-blue-900">Sửa</a>
                            <form method="POST" action="{{ route('categories.delete', $category->id) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-900">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Không có dữ liệu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{ $categories->links() }}
</div>
@endsection
```

### 📝 Form View (create/edit.blade.php) Pattern

```blade
@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Tạo Danh Mục</h1>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('categories.store') }}" class="space-y-6 px-4 py-5 sm:p-6">
            @csrf

            <!-- Form Fields -->
            <div class="space-y-6">
                <!-- Input Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Tên <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('name') border-red-500 @enderror"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Textarea Field -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">
                        Mô Tả
                    </label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >{{ old('description') }}</textarea>
                </div>

                <!-- Select Field -->
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700">
                        Danh Mục Cha
                    </label>
                    <select 
                        name="parent_id" 
                        id="parent_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                        <option value="">-- Không có danh mục cha --</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Checkbox Field -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        id="is_active" 
                        value="1"
                        {{ old('is_active', true) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                    <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">
                        Hoạt động
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex space-x-3 sm:border-t sm:border-gray-200 sm:pt-5">
                <button 
                    type="submit"
                    class="inline-flex justify-center px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <i class="bi bi-save mr-2"></i> Lưu
                </button>
                <a 
                    href="{{ route('categories.index') }}"
                    class="inline-flex justify-center px-4 py-2 rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50"
                >
                    <i class="bi bi-x-circle mr-2"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
```

### 🎨 TailwindCSS Utilities Reference

**Spacing:**
- `px-4` - Padding horizontal
- `py-5` - Padding vertical
- `space-y-6` - Vertical spacing between children
- `gap-4` - Grid gap

**Typography:**
- `text-sm` - Small text
- `font-medium` - Medium weight
- `text-gray-700` - Dark gray
- `text-gray-500` - Light gray

**Colors:**
- `bg-blue-600` / `hover:bg-blue-700` - Blue button
- `bg-red-50` / `text-red-600` - Red alert
- `bg-green-50` / `text-green-600` - Green success
- `border-gray-300` - Light border

**Responsive:**
- `sm:` - Small screen (640px+)
- `md:` - Medium screen (768px+)
- `lg:` - Large screen (1024px+)
- `grid-cols-1 sm:grid-cols-2 lg:grid-cols-4` - Responsive columns

**Display:**
- `block` - Display block
- `inline-flex` - Inline flex
- `hidden` - Display none
- `space-x-3` - Horizontal spacing

---

```php
<?php
return [
    'booking_dates' => [
        'prefix' => 'booking_dates',
        'open' => 'booking_dates:open',
        'by_id' => 'booking_dates:id:%s',
    ],
    
    'booking_time_slots' => [
        'by_booking_date_id' => 'booking_time_slots:booking_date:%s',
    ],
];
```

**Quy tắc:**
- Centralize cache keys
- Format: `{prefix}:{category}:{identifier}`
- Use sprintf() placeholder `:%s`

---

### Layer 13: **Dependency Injection** (`app/Providers/AppServiceProvider.php`)

```php
<?php
namespace App\Providers;

use App\Repositories\BookingDate\BookingDateRepository;
use App\Repositories\BookingDate\BookingDateRepositoryCache;
use App\Repositories\BookingDate\BookingDateRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register repository interface to implementation
        $this->app->bind(
            BookingDateRepositoryInterface::class,
            function ($app) {
                return new BookingDateRepositoryCache(
                    new BookingDateRepository()
                );
            }
        );
    }
    
    public function boot(): void
    {
        //
    }
}
```

**Quy tắc:**
- Bind Interface to Implementation
- Cache decorator wrap repository
- Constructor auto-inject

---

## 📋 Ví Dụ Hoàn Chỉnh

### Scenario: Tạo Feature Mới "BookingService"

**Step 1: Create Model & Migration**
```bash
php artisan make:model BookingService -m
```

```php
// app/Models/BookingService.php
class BookingService extends Model
{
    protected $table = 'booking_services';
    protected $fillable = ['name', 'duration', 'price'];
    
    public static function make(string $name, int $duration, float $price): static
    {
        return new static([
            'name' => $name,
            'duration' => $duration,
            'price' => $price,
        ]);
    }
}

// database/migrations/YYYY_MM_DD_HHMMSS_create_booking_services_table.php
public function up(): void
{
    Schema::create('booking_services', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->integer('duration'); // minutes
        $table->decimal('price', 10, 2);
        $table->timestamps();
    });
}
```

**Step 2: Create Repository**
```php
// app/Repositories/BookingService/BookingServiceRepositoryInterface.php
interface BookingServiceRepositoryInterface
{
    public function findById(int $id): ?BookingService;
    public function getAll(): Collection;
    public function save(BookingService $service): BookingService;
    public function delete(BookingService $service): bool;
}

// app/Repositories/BookingService/BookingServiceRepository.php
class BookingServiceRepository implements BookingServiceRepositoryInterface
{
    public function findById(int $id): ?BookingService
    {
        return BookingService::find($id);
    }
    
    public function getAll(): Collection
    {
        return BookingService::orderBy('name')->get();
    }
    
    public function save(BookingService $service): BookingService
    {
        $service->save();
        return $service;
    }
    
    public function delete(BookingService $service): bool
    {
        return $service->delete();
    }
}
```

**Step 3: Create Service**
```php
// app/Services/BookingService/BookingServiceService.php
class BookingServiceService
{
    public function __construct(
        protected BookingServiceRepositoryInterface $repository
    ) {}
    
    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }
    
    public function createService(string $name, int $duration, float $price): BookingService
    {
        $service = BookingService::make($name, $duration, $price);
        return $this->repository->save($service);
    }
    
    public function findById(int $id): BookingService
    {
        $service = $this->repository->findById($id);
        if (!$service) {
            throw new NotFoundHttpException("Service not found");
        }
        return $service;
    }
}
```

**Step 4: Create Controller**
```php
// app/Http/Controllers/Admin/BookingServiceController.php
class BookingServiceController extends Controller
{
    public function __construct(
        protected BookingServiceService $service
    ) {}
    
    public function index()
    {
        $services = $this->service->getAll();
        return view('admin.booking-service-management.index', compact('services'));
    }
    
    public function store(StoreBookingServiceRequest $request)
    {
        try {
            $this->service->createService(
                $request->get('name'),
                (int) $request->get('duration'),
                (float) $request->get('price')
            );
            return redirect()->route('booking-services.index')
                ->with('success', 'Tạo dịch vụ thành công');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
```

**Step 5: Create FormRequest**
```php
// app/Http/Requests/BookingServices/StoreBookingServiceRequest.php
class StoreBookingServiceRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'integer', 'min:15'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'Tên dịch vụ là bắt buộc',
            'duration.min' => 'Thời gian tối thiểu 15 phút',
        ];
    }
}
```

**Step 6: Create Routes**
```php
Route::prefix('admin')->group(function () {
    Route::group(['prefix' => 'booking-services', 'as' => 'booking-services.'], function () {
        Route::get('/list', [BookingServiceController::class, 'index'])->name('index');
        Route::post('/store', [BookingServiceController::class, 'store'])->name('store');
    });
});
```

**Step 7: Register DI**
```php
// app/Providers/AppServiceProvider.php
$this->app->bind(
    BookingServiceRepositoryInterface::class,
    BookingServiceRepository::class
);
```

---

## ✅ Quy Tắc Chung

### 1. **Naming Conventions**
| Layer | Pattern | Example |
|-------|---------|---------|
| Model | PascalCase | `BookingDate` |
| Table | snake_case + plural | `booking_dates` |
| Repository Interface | `{Entity}RepositoryInterface` | `BookingDateRepositoryInterface` |
| Repository | `{Entity}Repository` | `BookingDateRepository` |
| Service | `{Entity}Service` | `BookingDateService` |
| Controller | `{Entity}Controller` | `BookingDateController` |
| Request | `{Action}{Entity}Request` | `StoreBookingDateRequest` |
| Query | `List{Entity}Query` | `ListBookingDateQuery` |
| Handler | `List{Entity}Handler` | `ListBookingDateHandler` |
| Route Prefix | kebab-case + plural | `booking-dates` |
| View Folder | kebab-case + management | `booking-date-management` |
| Cache Key | snake_case | `booking_dates:id:%s` |

### 2. **File Organization**
- One class per file
- Filename match class name exactly
- Namespace match directory structure
- Comments for public methods

### 3. **Return Types**
- Always define return types
- Use nullable `?Model` when applicable
- Use `Collection` for multiple items
- Use `LengthAwarePaginator` for paginated results

### 4. **Error Handling**
- Use specific exceptions: `InvalidArgumentException`, `NotFoundHttpException`
- Add try-catch at Controller level
- User-friendly error messages (Vietnamese)
- Log exceptions for debugging

### 5. **Database Transactions**
- Use `DB::transaction()` cho multi-step operations
- Delete child records before parent
- Atomic operations guaranteed

### 6. **Validation**
- Always use FormRequest
- Array format rules (Laravel 8+)
- Vietnamese error messages
- Update: add unique constraint with exception

### 7. **Caching**
- Define cache keys in `config/cache_keys.php`
- Invalidate cache on save/delete
- TTL explicit (vd: 10 minutes)
- Use Redis for cache driver

### 8. **API/Response Pattern**
- Consistent response format
- HTTP status codes correct
- JSON responses structured
- Error messages in user language

### 9. **Testing**
```php
// tests/Feature/BookingDateControllerTest.php
class BookingDateControllerTest extends TestCase
{
    public function test_index_returns_list()
    {
        $response = $this->get('/admin/booking-dates/list');
        $response->assertStatus(200);
    }
    
    public function test_store_creates_booking_date()
    {
        $response = $this->post('/admin/booking-dates/store', [
            'date' => '2026-02-01',
            'is_open' => true,
            'time_slots' => [
                ['start' => '09:00', 'end' => '12:00', 'is_open' => true],
            ]
        ]);
        
        $this->assertDatabaseHas('booking_dates', [
            'date' => '2026-02-01',
        ]);
    }
}
```

### 10. **Code Style**
- PSR-12 Laravel style guide
- Comments for complex logic only
- Use type hints everywhere
- Consistent spacing & formatting

### 11. **Dependency Injection**
- Constructor injection for dependencies
- Bind Interface to Implementation
- Service locator pattern acceptable for queries
- Avoid static methods (except factories)

### 12. **Relationship Conventions**
- Method names: singular/plural match relation
- `hasMany()` return `HasMany`
- `belongsTo()` return `BelongsTo`
- Eager load in repository: `with()`

---

## 🎯 Checklist Khi Tạo Feature Mới

- [ ] Create Model & Migration
- [ ] Create Repository Interface & Implementation
- [ ] Create Service with business logic
- [ ] Create FormRequest for validation
- [ ] Create Controller with CRUD methods
- [ ] Create/Register routes
- [ ] Create Blade views (index, create, edit)
- [ ] Add cache decorator (optional)
- [ ] Register DI in AppServiceProvider
- [ ] Add config cache keys
- [ ] Write Feature tests
- [ ] Update documentation

---

## 📌 Tài Liệu Tham Khảo

- [Laravel Documentation](https://laravel.com/docs)
- [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)
- [Repository Pattern](https://martinfowler.com/eaaCatalog/repository.html)
- [CQRS Pattern](https://martinfowler.com/bliki/CQRS.html)

---

**Phiên Bản**: 1.0  
**Cập Nhật**: 2026-01-14  
**Tác Giả**: Architecture Team

