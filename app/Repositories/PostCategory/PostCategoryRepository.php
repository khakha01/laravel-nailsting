<?php

namespace App\Repositories\PostCategory;

use App\Models\PostCategory;
use Illuminate\Support\Collection;

class PostCategoryRepository implements PostCategoryRepositoryInterface
{
    public function findById(int $id): ?PostCategory
    {
        return PostCategory::with('parent', 'children')->find($id);
    }

    public function findBySlug(string $slug): ?PostCategory
    {
        return PostCategory::with('parent', 'children')->where('slug', $slug)->first();
    }

    public function getAll(): Collection
    {
        return PostCategory::query()->ordered()->get();
    }

    public function getActiveCategories(): Collection
    {
        return PostCategory::query()->active()->ordered()->get();
    }

    public function getRootCategories(): Collection
    {
        return PostCategory::query()->root()->ordered()->get();
    }

    public function save(PostCategory $category): PostCategory
    {
        $category->save();
        return $category;
    }

    public function delete(PostCategory $category): bool
    {
        return $category->delete();
    }
}
