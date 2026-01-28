<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function findById(int $id): ?Product
    {
        return Product::with('category', 'prices')->find($id);
    }

    public function findByIds(array $ids): Collection
    {
        return Product::with('category', 'prices')
            ->whereIn('id', $ids)
            ->get();
    }

    public function findByCode(string $code): ?Product
    {
        return Product::with('category', 'prices')
            ->where('code', $code)
            ->first();
    }

    public function getAll(): Collection
    {
        return Product::query()
            ->with('category', 'prices')
            ->ordered()
            ->get();
    }

    public function getActiveProducts(): Collection
    {
        return Product::query()
            ->active()
            ->with('category', 'prices')
            ->ordered()
            ->get();
    }

    public function getProductsByCategory(int $categoryId): Collection
    {
        return Product::query()
            ->byCategory($categoryId)
            ->with('category', 'prices')
            ->ordered()
            ->get();
    }

    public function save(Product $product): Product
    {
        $product->save();
        return $product;
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function bulkDelete(array $productIds): int
    {
        return Product::destroy($productIds);
    }

    public function countAll(): int
    {
        return Product::count();
    }
}
