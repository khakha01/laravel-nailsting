<?php

namespace App\Repositories\PostCategory;

use App\Models\PostCategory;
use Illuminate\Support\Collection;

interface PostCategoryRepositoryInterface
{
    public function findById(int $id): ?PostCategory;
    public function findBySlug(string $slug): ?PostCategory;
    public function getAll(): Collection;
    public function getActiveCategories(): Collection;
    public function getRootCategories(): Collection;
    public function save(PostCategory $category): PostCategory;
    public function delete(PostCategory $category): bool;
}
