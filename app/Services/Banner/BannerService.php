<?php

namespace App\Services\Banner;

use App\Models\Banner;
use App\Models\BannerItem;
use App\Repositories\Banner\BannerRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BannerService
{
    public function __construct(
        protected BannerRepositoryInterface $bannerRepository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->bannerRepository->getAll();
    }

    public function findById(int $id): Banner
    {
        $banner = $this->bannerRepository->findById($id);
        if (!$banner) {
            throw new NotFoundHttpException("Banner không tồn tại");
        }
        return $banner;
    }

    public function getActiveBanners(): Collection
    {
        return $this->bannerRepository->getActiveBanners();
    }

    public function createBanner(array $data): Banner
    {
        return DB::transaction(function () use ($data) {
            $banner = new Banner($data);
            $banner->save();

            if (!empty($data['items'])) {
                foreach ($data['items'] as $index => $itemData) {
                    $itemData['order'] = $index;
                    $banner->items()->create($itemData);
                }
            }

            return $banner;
        });
    }

    public function updateBanner(int $id, array $data): Banner
    {
        $banner = $this->bannerRepository->findById($id);
        if (!$banner) {
            throw new NotFoundHttpException("Banner không tồn tại");
        }

        return DB::transaction(function () use ($banner, $data) {
            $banner->update($data);

            if (isset($data['items'])) {
                // Remove existing items and recreate implies simple logic but loses IDs. 
                // Better to update or create. For simplicity given the request "create many child banners", 
                // full replacement of items might be acceptable or standard for this UI.
                // However, to keep it clean let's delete all and recreate for now 
                // as tracking individual item updates in a list form can be complex without IDs.
                // If the UI sends IDs, we could update, but "recreate" is safer for ordering.

                $banner->items()->delete();

                foreach ($data['items'] as $index => $itemData) {
                    $itemData['order'] = $index;
                    $banner->items()->create($itemData);
                }
            }

            return $banner;
        });
    }

    public function deleteBanner(int $id): void
    {
        $banner = $this->bannerRepository->findById($id);
        if (!$banner) {
            throw new NotFoundHttpException("Banner không tồn tại");
        }

        $this->bannerRepository->delete($banner);
    }

    public function bulkDeleteBanners(array $ids): int
    {
        return $this->bannerRepository->bulkDelete($ids);
    }
}
