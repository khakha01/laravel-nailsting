<?php

namespace App\Services\NailCategory;

use App\Models\NailCategory;
use App\Repositories\NailCategory\NailCategoryRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NailCategoryService
{
    public function __construct(
        protected NailCategoryRepositoryInterface $nailCategoryRepository
    ) {}

    // ===== READ =====

    public function getAll(): Collection
    {
        return $this->nailCategoryRepository->getAll();
    }

    public function findById(int $id): NailCategory
    {
        $nailCategory = $this->nailCategoryRepository->findById($id);
        if (!$nailCategory) {
            throw new NotFoundHttpException("Danh mục nail không tồn tại");
        }
        return $nailCategory;
    }

    public function findBySlug(string $slug): NailCategory
    {
        $nailCategory = $this->nailCategoryRepository->findBySlug($slug);
        if (!$nailCategory) {
            throw new NotFoundHttpException("Danh mục nail không tồn tại");
        }
        return $nailCategory;
    }

    public function getRootCategories(): Collection
    {
        return $this->nailCategoryRepository->getRootCategories();
    }

    public function getCategoriesByParent(int $parentId): Collection
    {
        return $this->nailCategoryRepository->findByParentId($parentId);
    }

    // ===== CREATE =====

    public function createService(
        string $name,
        string $slug,
        ?int $parentId = null
    ): NailCategory {
        // Validate
        $this->validateNameUnique($name);
        $this->validateSlugUnique($slug);

        if ($parentId) {
            $this->validateParentExists($parentId);
        }

        // Create
        $nailCategory = NailCategory::make(
            $name,
            $slug,
            $parentId
        );

        return $this->nailCategoryRepository->save($nailCategory);
    }

    // ===== UPDATE =====

    public function updateService(
        int $id,
        string $name,
        string $slug,
        ?int $parentId = null
    ): NailCategory {
        $nailCategory = $this->nailCategoryRepository->findById($id);
        if (!$nailCategory) {
            throw new InvalidArgumentException("Danh mục nail không tồn tại");
        }

        // Validate
        if ($nailCategory->name !== $name) {
            $this->validateNameUnique($name);
        }

        if ($nailCategory->slug !== $slug) {
            $this->validateSlugUnique($slug);
        }

        if ($parentId && $parentId !== $nailCategory->parent_id) {
            $this->validateParentExists($parentId);
            // Prevent circular reference
            $this->validateNoCircularReference($id, $parentId);
        }

        // Update
        $nailCategory->name = $name;
        $nailCategory->slug = $slug;
        $nailCategory->parent_id = $parentId;

        return $this->nailCategoryRepository->save($nailCategory);
    }

    // ===== DELETE =====

    public function deleteService(int $id): void
    {
        $nailCategory = $this->nailCategoryRepository->findById($id);
        if (!$nailCategory) {
            throw new NotFoundHttpException("Danh mục nail không tồn tại");
        }

        // Check if has children
        if ($nailCategory->children()->exists()) {
            throw new Exception("Không thể xóa danh mục có chứa danh mục con");
        }

        $this->nailCategoryRepository->delete($nailCategory);
    }

    public function bulkDeleteService(array $nailCategoryIds): int
    {
        // Check if any category has children
        $categoriesWithChildren = NailCategory::whereIn('id', $nailCategoryIds)
            ->with('children')
            ->get()
            ->filter(fn(NailCategory $cat) => $cat->children()->exists());

        if ($categoriesWithChildren->isNotEmpty()) {
            throw new Exception("Một số danh mục có chứa danh mục con và không thể xóa");
        }

        return DB::transaction(function () use ($nailCategoryIds) {
            return $this->nailCategoryRepository->bulkDelete($nailCategoryIds);
        });
    }

    // ===== Validation Methods =====

    /**
     * Validate category name is unique
     */
    private function validateNameUnique(string $name): void
    {
        if (NailCategory::where('name', $name)->exists()) {
            throw new Exception("Tên danh mục nail đã tồn tại");
        }
    }

    /**
     * Validate category slug is unique
     */
    private function validateSlugUnique(string $slug): void
    {
        if (NailCategory::where('slug', $slug)->exists()) {
            throw new Exception("Slug danh mục nail đã tồn tại");
        }
    }

    /**
     * Validate parent category exists
     */
    private function validateParentExists(int $parentId): void
    {
        if (!NailCategory::find($parentId)) {
            throw new Exception("Danh mục cha không tồn tại");
        }
    }

    /**
     * Validate no circular reference
     */
    private function validateNoCircularReference(int $categoryId, int $parentId): void
    {
        // Check if parent is a descendant of this category
        $parent = NailCategory::find($parentId);
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

