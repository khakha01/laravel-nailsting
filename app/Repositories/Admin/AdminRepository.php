<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use Illuminate\Support\Collection;

class AdminRepository implements AdminRepositoryInterface
{
    public function findById(int $id): ?Admin
    {
        return Admin::find($id);
    }

    public function findByIds(array $ids): Collection
    {
        return Admin::whereIn('id', $ids)->get();
    }

    public function findByEmail(string $email): ?Admin
    {
        return Admin::where('email', $email)->first();
    }

    public function getAll(): Collection
    {
        return Admin::all();
    }

    public function save(Admin $admin): Admin
    {
        $admin->save();
        return $admin;
    }

    public function delete(Admin $admin): bool
    {
        return $admin->delete();
    }

    public function deleteMany(array $ids): int
    {
        return Admin::destroy($ids);
    }

    public function countAll(): int
    {
        return Admin::count();
    }
}
