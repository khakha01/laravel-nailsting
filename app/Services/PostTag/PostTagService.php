<?php

namespace App\Services\PostTag;

use App\Models\PostTag;
use App\Repositories\PostTag\PostTagRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PostTagService
{
    public function __construct(
        protected PostTagRepositoryInterface $postTagRepository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->postTagRepository->getAll();
    }

    public function findById(int $id): PostTag
    {
        $tag = $this->postTagRepository->findById($id);
        if (!$tag) {
            throw new \Exception("Tag không tồn tại");
        }
        return $tag;
    }

    public function create(array $data): PostTag
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $tag = new PostTag($data);
        return $this->postTagRepository->save($tag);
    }

    public function update(int $id, array $data): PostTag
    {
        $tag = $this->findById($id);
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $tag->fill($data);
        return $this->postTagRepository->save($tag);
    }

    public function delete(int $id): bool
    {
        $tag = $this->findById($id);
        return $this->postTagRepository->delete($tag);
    }
}
