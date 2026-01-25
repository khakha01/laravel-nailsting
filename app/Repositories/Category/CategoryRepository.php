<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function findById(int $id): ?Category
    {
        return Category::with('children', 'parent')->find($id);
    }

    public function findByIds(array $ids): Collection
    {
        return Category::with('children', 'parent')
            ->whereIn('id', $ids)
            ->get();
    }

    public function findBySlug(string $slug): ?Category
    {
        return Category::with('children', 'parent')
            ->where('slug', $slug)
            ->first();
    }

    public function getAll(): Collection
    {
        return Category::query()
            ->with('children', 'parent')
            ->ordered()
            ->get();
    }

    public function getRootCategories(): Collection
    {
        return Category::query()
            ->root()
            // Eager load children recursively to avoid N+1 queries
            // This loads up to 5 levels deep - adjust if needed
            ->with('children.children.children.children.children')
            ->ordered()
            ->get();
    }

    public function getActiveCategories(): Collection
    {
        return Category::query()
            ->active()
            ->with('children', 'parent')
            ->ordered()
            ->get();
    }

    public function getActiveCategoriesWithProducts(): Collection
    {
        return Category::query()
            ->active()
            // Only get categories that have products or (optional) load all
            // Ideally we only want categories that have products for the booking page?
            // User requirement: "show ra data ra theo form đó".
            // We will load all active categories and their active products.
            ->with(['products' => function ($query) {
                $query->where('is_active', true)->with('prices');
            }])
            ->ordered()
            ->get();
    }

    public function getCategoriesTree(): Collection
    {
        return $this->getRootCategories()
            ->map(function (Category $category) {
                return $this->buildTree($category);
            });
    }

    public function save(Category $category): Category
    {
        $category->save();
        return $category;
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    public function bulkDelete(array $categoryIds): int
    {
        return Category::destroy($categoryIds);
    }

    public function findByParentId(int $parentId): Collection
    {
        return Category::query()
            ->where('parent_id', $parentId)
            ->with('children')
            ->ordered()
            ->get();
    }

    /**
     * Build hierarchical tree structure
     */
    private function buildTree(Category $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
            'is_active' => $category->is_active,
            'display_order' => $category->display_order,
            'children' => $category->children
                ->map(fn(Category $child) => $this->buildTree($child))
                ->toArray(),
        ];
    }
}
