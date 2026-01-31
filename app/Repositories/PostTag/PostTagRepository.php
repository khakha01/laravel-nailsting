<?php

namespace App\Repositories\PostTag;

use App\Models\PostTag;
use Illuminate\Support\Collection;

class PostTagRepository implements PostTagRepositoryInterface
{
    public function findById(int $id): ?PostTag
    {
        return PostTag::find($id);
    }

    public function findByName(string $name): ?PostTag
    {
        return PostTag::where('name', $name)->first();
    }

    public function getAll(): Collection
    {
        return PostTag::all();
    }

    public function save(PostTag $tag): PostTag
    {
        $tag->save();
        return $tag;
    }

    public function delete(PostTag $tag): bool
    {
        return $tag->delete();
    }
}
