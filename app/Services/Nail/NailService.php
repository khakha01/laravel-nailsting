<?php

namespace App\Services\Nail;

use App\Models\Nail;
use App\Models\NailImage;
use App\Models\NailPrice;
use App\Repositories\Nail\NailRepositoryInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NailService
{
    public function __construct(
        protected NailRepositoryInterface $nailRepository
    ) {}

    // ===== READ =====

    public function getAll(): Collection
    {
        return $this->nailRepository->getAll();
    }

    public function findById(int $id): Nail
    {
        $nail = $this->nailRepository->findById($id);
        if (!$nail) {
            throw new NotFoundHttpException("Nail không tồn tại");
        }
        return $nail;
    }

    public function findBySlug(string $slug): Nail
    {
        $nail = $this->nailRepository->findBySlug($slug);
        if (!$nail) {
            throw new NotFoundHttpException("Nail không tồn tại");
        }
        return $nail;
    }

    public function getActiveNails(): Collection
    {
        return $this->nailRepository->getActiveNails();
    }

    // ===== CREATE =====
/*
    public function createService(
        string $name,
        string $slug,
        ?string $description = null,
        string $status = 'active',
        ?array $images = null,
        ?array $prices = null
    ): Nail {
        // Validate
        $this->validateSlugUnique($slug);

        // Create with transaction
        $nail = Nail::make($name, $slug, $description, $status);

        return DB::transaction(function () use ($nail, $images, $prices) {
            $nail = $this->nailRepository->save($nail);

            // Add images
            if ($images) {
                foreach ($images as $index => $imageData) {
                    $this->addImage($nail->id, $imageData, $index === 0);
                }
            }

            // Add prices
            if ($prices) {
                foreach ($prices as $index => $priceData) {
                    $this->addPrice($nail->id, $priceData, $index === 0);
                }
            }

            return $nail;
        });
    }
*/
public function createService($name, $slug, $description, $status, $images, $prices): Nail
    {
        return DB::transaction(function () use ($name, $slug, $description, $status, $images, $prices) {
            $nail = Nail::create([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'status' => $status
            ]);

            // Xử lý ảnh bằng Spatie
            if ($images) {
                foreach ($images as $imageData) {
                    if (isset($imageData['image']) && $imageData['image'] instanceof UploadedFile) {
                        $nail->addMedia($imageData['image'])
                             ->withCustomProperties([
                                 'is_primary' => $imageData['is_primary'] ?? false,
                                 'sort_order' => $imageData['sort_order'] ?? 0
                             ])
                             ->toMediaCollection('nail_images');
                    }
                }
            }

            // Xử lý giá (Giữ nguyên logic cũ của bạn)
            if ($prices) {
                foreach ($prices as $index => $priceData) {
                    $this->addPrice($nail->id, $priceData, $index === 0);
                }
            }

            return $nail;
        });
    }
    // ===== UPDATE =====

    public function updateService(
        int $id,
        string $name,
        string $slug,
        ?string $description = null,
        string $status = 'active',
        ?array $images = null,
        ?array $prices = null
    ): Nail {
        $nail = $this->nailRepository->findById($id);
        if (!$nail) {
            throw new InvalidArgumentException("Nail không tồn tại");
        }

        // Validate
        if ($nail->slug !== $slug) {
            $this->validateSlugUnique($slug);
        }

        // Update
        $nail->name = $name;
        $nail->slug = $slug;
        $nail->description = $description;
        $nail->status = $status;

        return DB::transaction(function () use ($nail, $images, $prices) {
            $nail = $this->nailRepository->save($nail);

            // Update images
            if ($images !== null) {
                $nail->images()->delete();

                foreach ($images as $index => $imageData) {
                    $this->addImage($nail->id, $imageData, $index === 0, $index);
                }
            }

            // Update prices
            if ($prices !== null) {
                $nail->prices()->delete();

                foreach ($prices as $index => $priceData) {
                    $this->addPrice($nail->id, $priceData, $index === 0);
                }
            }

            return $nail;
        });
    }

    // ===== DELETE =====

    public function deleteService(int $id): void
    {
        $nail = $this->nailRepository->findById($id);
        if (!$nail) {
            throw new NotFoundHttpException("Nail không tồn tại");
        }

        DB::transaction(function () use ($nail) {
            // Delete related images and prices (cascade will handle)
            $nail->images()->delete();
            $nail->prices()->delete();
            // Delete nail
            $this->nailRepository->delete($nail);
        });
    }

    public function bulkDeleteService(array $nailIds): int
    {
        return DB::transaction(function () use ($nailIds) {
            // Delete all related images and prices
            NailImage::whereIn('nail_id', $nailIds)->delete();
            NailPrice::whereIn('nail_id', $nailIds)->delete();
            // Delete nails
            return $this->nailRepository->bulkDelete($nailIds);
        });
    }

    // ===== Image Management =====

    public function addImage(int $nailId, array $imageData, bool $isPrimary = false, int $sortOrder = 0): NailImage
    {
        $imagePath = $this->uploadImage($imageData);

        $image = NailImage::make(
            $imagePath,
            $isPrimary,
            $sortOrder
        );
        $image->nail_id = $nailId;

        return $image->save() ? $image : throw new Exception('Không thể thêm hình ảnh');
    }

    /**
     * Upload image file to storage
     * @param array $imageData ['image' => UploadedFile|string, 'image_path' => string|null]
     * @return string Image path relative to storage/public
     */
    protected function uploadImage(array $imageData): string
    {
        // Nếu có file mới upload
        if (isset($imageData['image']) && $imageData['image'] instanceof UploadedFile) {
            $file = $imageData['image'];
            $folder = 'nails';

            // Tạo folder nếu chưa tồn tại
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }

            // Tạo tên file unique: timestamp_randomname.extension
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs($folder, $filename, 'public');

            return $path; // Returns: nails/1234567890_abc123_filename.jpg
        }

        // Nếu có image_path cũ (khi edit không upload mới)
        if (isset($imageData['image_path']) && !empty($imageData['image_path'])) {
            return $imageData['image_path'];
        }

        throw new Exception('Hình ảnh là bắt buộc');
    }

    // ===== Price Management =====

    public function addPrice(int $nailId, array $priceData, bool $isDefault = false): NailPrice
    {
        $price = NailPrice::make(
            $priceData['title'] ?? '',
            $this->sanitizeMoney($priceData['price'] ?? 0),
            $isDefault
        );
        $price->nail_id = $nailId;

        return $price->save() ? $price : throw new Exception('Không thể thêm giá');
    }

    // ===== Validation Methods =====

    private function validateSlugUnique(string $slug): void
    {
        if (Nail::where('slug', $slug)->exists()) {
            throw new Exception("Slug nail đã tồn tại");
        }
    }

    private function sanitizeMoney($value): float
    {
        if (is_numeric($value)) {
            return (float) $value;
        }

        if (is_string($value)) {
            return (float) preg_replace('/[^0-9.]/', '', $value);
        }

        return 0.0;
    }
}

