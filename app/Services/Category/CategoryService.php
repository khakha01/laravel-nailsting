<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    // ===== READ =====

    public function getAll(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    public function findById(int $id): Category
    {
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            throw new NotFoundHttpException("Danh mục không tồn tại");
        }
        return $category;
    }

    public function findBySlug(string $slug): Category
    {
        $category = $this->categoryRepository->findBySlug($slug);
        if (!$category) {
            throw new NotFoundHttpException("Danh mục không tồn tại");
        }
        return $category;
    }

    public function getRootCategories(): Collection
    {
        return $this->categoryRepository->getRootCategories();
    }

    public function getActiveCategories(): Collection
    {
        return $this->categoryRepository->getActiveCategories();
    }

    public function getCategoriesTree(): Collection
    {
        return $this->categoryRepository->getCategoriesTree();
    }

    public function getCategoriesByParent(int $parentId): Collection
    {
        return $this->categoryRepository->findByParentId($parentId);
    }

    // ===== CREATE =====

    public function createService(
        string $name,
        string $slug,
        ?int $parentId = null,
        ?string $description = null,
        bool $isActive = true,
        int $displayOrder = 0
    ): Category {
        // Validate
        $this->validateNameUnique($name);
        $this->validateSlugUnique($slug);

        if ($parentId) {
            $this->validateParentExists($parentId);
        }

        // Create
        $category = Category::make(
            $name,
            $slug,
            $parentId,
            $description,
            $isActive,
            $displayOrder
        );

        return $this->categoryRepository->save($category);
    }

    // ===== UPDATE =====

    public function updateService(
        int $id,
        string $name,
        string $slug,
        ?int $parentId = null,
        ?string $description = null,
        bool $isActive = true,
        int $displayOrder = 0
    ): Category {
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            throw new InvalidArgumentException("Danh mục không tồn tại");
        }

        // Validate
        if ($category->name !== $name) {
            $this->validateNameUnique($name);
        }

        if ($category->slug !== $slug) {
            $this->validateSlugUnique($slug);
        }

        if ($parentId && $parentId !== $category->parent_id) {
            $this->validateParentExists($parentId);
            // Prevent circular reference
            $this->validateNoCircularReference($id, $parentId);
        }

        // Update
        $category->name = $name;
        $category->slug = $slug;
        $category->parent_id = $parentId;
        $category->description = $description;
        $category->is_active = $isActive;
        $category->display_order = $displayOrder;

        return $this->categoryRepository->save($category);
    }

    // ===== DELETE =====

    public function deleteService(int $id): void
    {
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            throw new NotFoundHttpException("Danh mục không tồn tại");
        }

        // Check if has children
        if ($category->children()->exists()) {
            throw new Exception("Không thể xóa danh mục có chứa danh mục con");
        }

        $this->categoryRepository->delete($category);
    }

    public function bulkDeleteService(array $categoryIds): int
    {
        // Check if any category has children
        $categoriesWithChildren = Category::whereIn('id', $categoryIds)
            ->with('children')
            ->get()
            ->filter(fn(Category $cat) => $cat->children()->exists());

            if ($categoriesWithChildren->isNotEmpty()) {
            throw new Exception("Một số danh mục có chứa danh mục con và không thể xóa");
        }

        return DB::transaction(function () use ($categoryIds) {
            return $this->categoryRepository->bulkDelete($categoryIds);
        });
    }

    // ===== Validation Methods =====

    /**
     * Validate category name is unique
     */
    private function validateNameUnique(string $name): void
    {
        if (Category::where('name', $name)->exists()) {
            throw new Exception("Tên danh mục đã tồn tại");
        }
    }

    /**
     * Validate category slug is unique
     */
    private function validateSlugUnique(string $slug): void
    {
        if (Category::where('slug', $slug)->exists()) {
            throw new Exception("Slug danh mục đã tồn tại");
        }
    }

    /**
     * Validate parent category exists
     */
    private function validateParentExists(int $parentId): void
    {
        if (!Category::find($parentId)) {
            throw new Exception("Danh mục cha không tồn tại");
        }
    }

    /**
     * Validate no circular reference
     */
    private function validateNoCircularReference(int $categoryId, int $parentId): void
    {
        // Check if parent is a descendant of this category
        $parent = Category::find($parentId);
        if (!$parent) {
            return;
        }

        $current = $parent->parent;
        while ($current) {
            if ($current->id === $categoryId) {
                throw new Exception("Không thể gán danh mục con làm danh mục cha (circular reference)");
            }
            $current = $current->parent;
        }
    }
}
