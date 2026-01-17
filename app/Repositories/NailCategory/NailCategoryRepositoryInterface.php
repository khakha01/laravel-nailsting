<?php

namespace App\Repositories\NailCategory;

use App\Models\NailCategory;
use Illuminate\Support\Collection;

interface NailCategoryRepositoryInterface
{
    public function findById(int $id): ?NailCategory;

    public function findByIds(array $ids): Collection;

    public function findBySlug(string $slug): ?NailCategory;

    public function getAll(): Collection;

    public function getRootCategories(): Collection;

    public function save(NailCategory $nailCategory): NailCategory;

    public function delete(NailCategory $nailCategory): bool;

    public function bulkDelete(array $nailCategoryIds): int;

    public function findByParentId(int $parentId): Collection;
}

