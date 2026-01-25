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
    ) {
    }

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

    /**
     * Lấy danh sách nails cho homepage
     * @param int $limit Số lượng nails cần lấy
     * @return Collection
     */
    public function getHomePageNails(int $limit = 6): Collection
    {
        return $this->nailRepository->getActiveNails()->take($limit);
    }

    // ===== CREATE =====
    public function createService($name, $slug, $description, $status, $images, $prices): Nail
    {
        return DB::transaction(function () use ($name, $slug, $description, $status, $images, $prices) {
            $nail = Nail::create([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'status' => $status
            ]);

            // Process Images (MinIO/MediaLibrary)
            if ($images) {
                foreach ($images as $index => $imageData) {
                    if (!empty($imageData['media_id'])) {
                        $this->addImage(
                            $nail->id,
                            $imageData['media_id'],
                            $imageData['is_primary'] ?? ($index === 0),
                            $imageData['sort_order'] ?? $index
                        );
                    }
                }
            }

            // Process Prices
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
                    if (!empty($imageData['media_id'])) {
                        $this->addImage($nail->id, $imageData['media_id'], $imageData['is_primary'] ?? ($index === 0), $index);
                    }
                }
            }

            // Update prices
            if ($prices !== null) {
                $nail->prices()->delete();

                foreach ($prices as $index => $priceData) {
                    $this->addPrice($nail->id, $priceData, $priceData['is_default'] ?? false);
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

    public function addImage(int $nailId, int $mediaId, bool $isPrimary = false, int $sortOrder = 0): NailImage
    {
        $image = new NailImage([
            'media_id' => $mediaId,
            'is_primary' => $isPrimary,
            'sort_order' => $sortOrder
        ]);
        $image->nail_id = $nailId;

        return $image->save() ? $image : throw new Exception('Không thể thêm hình ảnh');
    }

    // ===== Price Management =====

    public function addPrice(int $nailId, array $priceData, bool $isDefault = false): NailPrice
    {
        $price = NailPrice::make(
            $priceData['price_type'] ?? 'fixed',
            $this->sanitizeMoney($priceData['price'] ?? null),
            $this->sanitizeMoney($priceData['price_min'] ?? null),
            $this->sanitizeMoney($priceData['price_max'] ?? null),
            $priceData['note'] ?? null,
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

    private function sanitizeMoney(?string $value): ?float
    {
        if (!$value) {
            return null;
        }

        return (float) preg_replace('/[^0-9]/', '', $value);
    }
}

