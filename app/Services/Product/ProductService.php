<?php

namespace App\Services\Product;

use App\Enums\ProductUnitEnum;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Repositories\Product\ProductRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {}


    public function getAll(): Collection
    {
        return $this->productRepository->getAll();
    }

    public function findById(int $id): Product
    {
        $product = $this->productRepository->findById($id);
        if (!$product) {
            throw new NotFoundHttpException("Sản phẩm không tồn tại");
        }
        return $product;
    }

    public function findByCode(string $code): Product
    {
        $product = $this->productRepository->findByCode($code);
        if (!$product) {
            throw new NotFoundHttpException("Sản phẩm không tồn tại");
        }
        return $product;
    }

    public function getActiveProducts(): Collection
    {
        return $this->productRepository->getActiveProducts();
    }

    public function getProductsByCategory(int $categoryId): Collection
    {
        return $this->productRepository->getProductsByCategory($categoryId);
    }

    // ===== CREATE =====

    public function createService(
        int $categoryId,
        string $name,
        ?string $code = null,
        string $slug,
        ?string $description = null,
        ProductUnitEnum $unit = ProductUnitEnum::LAN,
        bool $isActive = true,
        int $displayOrder = 0,
        ?array $prices = null
    ): Product {

        $this->validateSlugUnique($slug);

        if (!$this->categoryExists($categoryId)) {
            throw new Exception('Danh mục không tồn tại');
        }

        if ($code && $this->codeExists($code)) {
            throw new Exception('Mã sản phẩm đã tồn tại');
        }

        // Create with transaction
        $product = Product::make($categoryId, $name, $code, $slug, $description, $unit, $isActive, $displayOrder);

        return DB::transaction(function () use ($product, $prices) {
            $product = $this->productRepository->save($product);

            // Add prices
            if ($prices) {
                foreach ($prices as $priceData) {
                    $this->addPrice($product->id, $priceData);
                }
            }

            return $product;
        });
    }

    // ===== UPDATE =====

    public function updateService(
        int $id,
        int $categoryId,
        string $name,
        ?string $code = null,
        string $slug,
        ?string $description = null,
        ProductUnitEnum $unit = ProductUnitEnum::LAN,
        bool $isActive = true,
        int $displayOrder = 0,
        ?array $prices = null
    ): Product {
        $product = $this->productRepository->findById($id);
        if (!$product) {
            throw new InvalidArgumentException("Sản phẩm không tồn tại");
        }

        // Validate
        if (!$this->categoryExists($categoryId)) {
            throw new Exception('Danh mục không tồn tại');
        }

        if ($product->code !== $code && $code && $this->codeExists($code)) {
            throw new Exception('Mã sản phẩm đã tồn tại');
        }

        if ($product->slug !== $slug) {
            $this->validateSlugUnique($slug);
        }

        // Update
        $product->category_id = $categoryId;
        $product->name = $name;
        $product->code = $code;
        $product->slug = $slug;
        $product->description = $description;
        $product->unit = $unit;
        $product->is_active = $isActive;
        $product->display_order = $displayOrder;

        return DB::transaction(function () use ($product, $prices) {
            $product = $this->productRepository->save($product);

            if ($prices !== null) {
                $product->prices()->delete();

                foreach ($prices as $priceData) {
                    $this->addPrice($product->id, $priceData);
                }
            }

            return $product;
        });
    }

    // ===== DELETE =====

    public function deleteService(int $id): void
    {
        $product = $this->productRepository->findById($id);
        if (!$product) {
            throw new NotFoundHttpException("Sản phẩm không tồn tại");
        }

        DB::transaction(function () use ($product) {
            // Delete related prices
            $product->prices()->delete();
            // Delete product
            $this->productRepository->delete($product);
        });
    }

    public function bulkDeleteService(array $productIds): int
    {
        return DB::transaction(function () use ($productIds) {
            // Delete all related prices
            ProductPrice::whereIn('product_id', $productIds)->delete();
            // Delete products
            return $this->productRepository->bulkDelete($productIds);
        });
    }

    // ===== Price Management =====

    public function addPrice(int $productId, array $priceData): ProductPrice
    {
        $price = ProductPrice::make(
            $productId,
            $priceData['price_type'] ?? 'fixed',
            $priceData['price'] ?? null,
            $priceData['price_min'] ?? null,
            $priceData['price_max'] ?? null,
            $priceData['note'] ?? null
        );


        return $price->save() ? $price : throw new Exception('Không thể thêm giá');
    }


    private function categoryExists(int $categoryId): bool
    {
        return \App\Models\Category::find($categoryId) !== null;
    }

    private function codeExists(string $code): bool
    {
        return Product::where('code', $code)->exists();
    }

    private function validateSlugUnique(string $slug): void
    {
        if (Product::where('slug', $slug)->exists()) {
            throw new Exception("Slug sản phẩm đã tồn tại");
        }
    }
}
