<?php

namespace App\Repositories\Banner;

use App\Models\Banner;
use Illuminate\Support\Collection;

class BannerRepository implements BannerRepositoryInterface
{
    public function findById(int $id): ?Banner
    {
        return Banner::with(['media', 'items.media'])->find($id);
    }

    public function getAll(): Collection
    {
        return Banner::with(['media', 'items.media'])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getActiveBanners(): Collection
    {
        return Banner::with(['media', 'items.media'])
            ->where('is_active', true)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function save(Banner $banner): Banner
    {
        $banner->save();
        return $banner;
    }

    public function delete(Banner $banner): bool
    {
        return $banner->delete();
    }

    public function bulkDelete(array $ids): int
    {
        return Banner::destroy($ids);
    }
}
