<?php

namespace App\Queries\ListPostCategories;

use App\Models\PostCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListPostCategoryHandler
{
    public function execute(ListPostCategoryQuery $query): LengthAwarePaginator
    {
        return PostCategory::query()
            ->with(['parent', 'children'])
            ->when($query->search, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('name', 'like', "%{$query->search}%")
                        ->orWhere('slug', 'like', "%{$query->search}%");
                });
            })
            ->when($query->isActive !== null, function ($q) use ($query) {
                return $q->where('is_active', $query->isActive);
            })
            ->when($query->parentId !== null, function ($q) use ($query) {
                return $q->where('parent_id', $query->parentId);
            })
            ->ordered()
            ->paginate($query->perPage, ['*'], 'page', $query->page);
    }
}
