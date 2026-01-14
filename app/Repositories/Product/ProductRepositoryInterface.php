<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function findById(int $id): ?Product;

    public function findByIds(array $ids): Collection;

    public function findByCode(string $code): ?Product;

    public function getAll(): Collection;

    public function getActiveProducts(): Collection;

    public function getProductsByCategory(int $categoryId): Collection;

    public function save(Product $product): Product;

    public function delete(Product $product): bool;

    public function bulkDelete(array $productIds): int;
}
