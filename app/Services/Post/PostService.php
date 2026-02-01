<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->postRepository->getAll();
    }

    public function findById(int $id): Post
    {
        $post = $this->postRepository->findById($id);
        if (!$post) {
            throw new \Exception("Bài viết không tồn tại");
        }
        return $post;
    }

    public function create(array $data): Post
    {
        return DB::transaction(function () use ($data) {
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            $data['author_id'] = Auth::id();

            if (($data['status'] ?? Post::STATUS_DRAFT) === Post::STATUS_PUBLISHED && empty($data['published_at'])) {
                $data['published_at'] = now();
            }

            $post = new Post($data);
            $post = $this->postRepository->save($post);

            if (!empty($data['tag_ids'])) {
                $post->tags()->sync($data['tag_ids']);
            }

            return $post;
        });
    }

    public function update(int $id, array $data): Post
    {
        return DB::transaction(function () use ($id, $data) {
            $post = $this->findById($id);

            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            if (($data['status'] ?? $post->status) === Post::STATUS_PUBLISHED && empty($post->published_at) && empty($data['published_at'])) {
                $data['published_at'] = now();
            }

            $post->fill($data);
            $post = $this->postRepository->save($post);

            if (isset($data['tag_ids'])) {
                $post->tags()->sync($data['tag_ids']);
            }

            return $post;
        });
    }

    public function delete(int $id): bool
    {
        $post = $this->findById($id);
        return $this->postRepository->delete($post);
    }

    public function bulkDelete(array $ids): int
    {
        return $this->postRepository->bulkDelete($ids);
    }

    public function getPostsByCategory(int $categoryId): Collection
    {
        return $this->postRepository->getPostsByCategory($categoryId);
    }
}
