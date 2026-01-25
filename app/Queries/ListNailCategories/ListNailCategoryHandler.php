<?php

namespace App\Queries\ListNailCategories;

use App\Models\NailCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListNailCategoryHandler
{
    public function execute(ListNailCategoryQuery $query): LengthAwarePaginator
    {
        $builder = NailCategory::query();

        // Filter by search
        if ($query->search) {
            $builder->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query->search . '%')
                  ->orWhere('slug', 'like', '%' . $query->search . '%');
            });
        }

        // Filter by category ID
        if ($query->categoryId !== null) {
            $builder->where('id', $query->categoryId);
        }

        // Order and eager load
        $builder->with(['children', 'parent'])
            ->ordered();

        return $builder->paginate($query->perPage, ['*'], 'page', $query->page);
    }
}
