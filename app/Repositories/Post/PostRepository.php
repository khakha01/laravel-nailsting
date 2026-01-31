<?php

namespace App\Repositories\Post;

use App\Models\Post;
use Illuminate\Support\Collection;

class PostRepository implements PostRepositoryInterface
{
    public function findById(int $id): ?Post
    {
        return Post::with('category', 'author', 'media', 'tags')->find($id);
    }

    public function findBySlug(string $slug): ?Post
    {
        return Post::with('category', 'author', 'media', 'tags')
            ->where('slug', $slug)
            ->first();
    }

    public function getAll(): Collection
    {
        return Post::with('category', 'author', 'media')
            ->orderByDesc('created_at')
            ->get();
    }

    public function getPublishedPosts(): Collection
    {
        return Post::published()
            ->with('category', 'author', 'media')
            ->latestPublished()
            ->get();
    }

    public function getFeaturedPosts(): Collection
    {
        return Post::featured()
            ->published()
            ->with('category', 'author', 'media')
            ->latestPublished()
            ->get();
    }

    public function getPostsByCategory(int $categoryId): Collection
    {
        return Post::where('post_category_id', $categoryId)
            ->published()
            ->with('category', 'author', 'media')
            ->latestPublished()
            ->get();
    }

    public function save(Post $post): Post
    {
        $post->save();
        return $post;
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }

    public function bulkDelete(array $postIds): int
    {
        return Post::destroy($postIds);
    }
}
