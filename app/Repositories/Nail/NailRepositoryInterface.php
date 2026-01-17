<?php

namespace App\Repositories\Nail;

use App\Models\Nail;
use Illuminate\Support\Collection;

interface NailRepositoryInterface
{
    public function findById(int $id): ?Nail;

    public function findByIds(array $ids): Collection;

    public function findBySlug(string $slug): ?Nail;

    public function getAll(): Collection;

    public function getActiveNails(): Collection;

    public function save(Nail $nail): Nail;

    public function delete(Nail $nail): bool;

    public function bulkDelete(array $nailIds): int;
}

