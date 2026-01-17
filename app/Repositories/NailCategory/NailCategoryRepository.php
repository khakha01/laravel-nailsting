<?php

namespace App\Repositories\NailCategory;

use App\Models\NailCategory;
use Illuminate\Support\Collection;

class NailCategoryRepository implements NailCategoryRepositoryInterface
{
    public function findById(int $id): ?NailCategory
    {
        return NailCategory::with('children', 'parent')->find($id);
    }

    public function findByIds(array $ids): Collection
    {
        return NailCategory::with('children', 'parent')
            ->whereIn('id', $ids)
            ->get();
    }

    public function findBySlug(string $slug): ?NailCategory
    {
        return NailCategory::with('children', 'parent')
            ->where('slug', $slug)
            ->first();
    }

    public function getAll(): Collection
    {
        return NailCategory::query()
            ->with('children', 'parent')
            ->ordered()
            ->get();
    }

    public function getRootCategories(): Collection
    {
        return NailCategory::query()
            ->root()
            ->with('children')
            ->ordered()
            ->get();
    }

    public function save(NailCategory $nailCategory): NailCategory
    {
        $nailCategory->save();
        return $nailCategory;
    }

    public function delete(NailCategory $nailCategory): bool
    {
        return $nailCategory->delete();
    }

    public function bulkDelete(array $nailCategoryIds): int
    {
        return NailCategory::destroy($nailCategoryIds);
    }

    public function findByParentId(int $parentId): Collection
    {
        return NailCategory::query()
            ->where('parent_id', $parentId)
            ->with('children')
            ->ordered()
            ->get();
    }
}

