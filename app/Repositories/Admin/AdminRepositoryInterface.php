<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use Illuminate\Support\Collection;

interface AdminRepositoryInterface
{
    public function findById(int $id): ?Admin;
    public function findByIds(array $ids): Collection;
    public function findByEmail(string $email): ?Admin;
    public function getAll(): Collection;
    public function save(Admin $admin): Admin;
    public function delete(Admin $admin): bool;
    public function deleteMany(array $ids): int;
    public function countAll(): int;
}
