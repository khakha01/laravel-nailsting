<?php

namespace App\Repositories\Nail;

use App\Models\Nail;
use Illuminate\Support\Collection;

class NailRepository implements NailRepositoryInterface
{
    public function findById(int $id): ?Nail
    {
        return Nail::with('images', 'prices')->find($id);
    }

    public function findByIds(array $ids): Collection
    {
        return Nail::with('images', 'prices')
            ->whereIn('id', $ids)
            ->get();
    }

    public function findBySlug(string $slug): ?Nail
    {
        return Nail::with('images', 'prices')
            ->where('slug', $slug)
            ->first();
    }

    public function getAll(): Collection
    {
        return Nail::query()
            ->with('images', 'prices')
            ->ordered()
            ->get();
    }

    public function getActiveNails(): Collection
    {
        return Nail::query()
            ->active()
            ->with('images', 'prices')
            ->ordered()
            ->get();
    }

    public function save(Nail $nail): Nail
    {
        $nail->save();
        return $nail;
    }

    public function delete(Nail $nail): bool
    {
        return $nail->delete();
    }

    public function bulkDelete(array $nailIds): int
    {
        return Nail::destroy($nailIds);
    }
}

