<?php

namespace App\Repositories\PostTag;

use App\Models\PostTag;
use Illuminate\Support\Collection;

interface PostTagRepositoryInterface
{
    public function findById(int $id): ?PostTag;
    public function findByName(string $name): ?PostTag;
    public function getAll(): Collection;
    public function save(PostTag $tag): PostTag;
    public function delete(PostTag $tag): bool;
}
