<?php

namespace App\Repositories\Banner;

use App\Models\Banner;
use Illuminate\Support\Collection;

interface BannerRepositoryInterface
{
    public function findById(int $id): ?Banner;

    public function getAll(): Collection;

    public function getActiveBanners(): Collection;

    public function save(Banner $banner): Banner;

    public function delete(Banner $banner): bool;

    public function bulkDelete(array $ids): int;
}
