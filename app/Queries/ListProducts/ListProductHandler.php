<?php

namespace App\Queries\ListProducts;

use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ListProductHandler
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function execute(ListProductQuery $query): LengthAwarePaginator
    {
        $products = Product::query()
            ->with(['category', 'prices'])
            ->when($query->search, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('name', 'like', "%{$query->search}%")
                        ->orWhere('code', 'like', "%{$query->search}%");
                });
            })
            ->when($query->categoryId !== null, function ($q) use ($query) {
                return $q->where('category_id', $query->categoryId);
            })
            ->when($query->isActive !== null, function ($q) use ($query) {
                return $q->where('is_active', $query->isActive);
            })
            ->orderBy('display_order')
            ->paginate($query->perPage, ['*'], 'page', $query->page);

        return $products;
    }
}
