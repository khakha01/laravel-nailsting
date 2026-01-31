<?php

namespace App\Repositories\Post;

use App\Models\Post;
use Illuminate\Support\Collection;

interface PostRepositoryInterface
{
    public function findById(int $id): ?Post;
    public function findBySlug(string $slug): ?Post;
    public function getAll(): Collection;
    public function getPublishedPosts(): Collection;
    public function getFeaturedPosts(): Collection;
    public function getPostsByCategory(int $categoryId): Collection;
    public function save(Post $post): Post;
    public function delete(Post $post): bool;
    public function bulkDelete(array $postIds): int;
}
