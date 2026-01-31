<?php

namespace App\Services\PostCategory;

use App\Models\PostCategory;
use App\Repositories\PostCategory\PostCategoryRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PostCategoryService
{
    public function __construct(
        protected PostCategoryRepositoryInterface $postCategoryRepository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->postCategoryRepository->getAll();
    }

    public function getActiveCategories(): Collection
    {
        return $this->postCategoryRepository->getActiveCategories();
    }

    public function findById(int $id): PostCategory
    {
        $category = $this->postCategoryRepository->findById($id);
        if (!$category) {
            throw new \Exception("Danh mục không tồn tại");
        }
        return $category;
    }

    public function create(array $data): PostCategory
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category = new PostCategory($data);
        return $this->postCategoryRepository->save($category);
    }

    public function update(int $id, array $data): PostCategory
    {
        $category = $this->findById($id);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->fill($data);
        return $this->postCategoryRepository->save($category);
    }

    public function delete(int $id): bool
    {
        $category = $this->findById($id);
        return $this->postCategoryRepository->delete($category);
    }
}
