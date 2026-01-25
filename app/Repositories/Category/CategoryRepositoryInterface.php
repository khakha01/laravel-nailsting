<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function findById(int $id): ?Category;

    public function findByIds(array $ids): Collection;

    public function findBySlug(string $slug): ?Category;

    public function getAll(): Collection;

    public function getRootCategories(): Collection;

    public function getActiveCategories(): Collection;

    public function getActiveCategoriesWithProducts(): Collection;

    public function getCategoriesTree(): Collection;

    public function save(Category $category): Category;

    public function delete(Category $category): bool;

    public function bulkDelete(array $categoryIds): int;

    public function findByParentId(int $parentId): Collection;
}
