<?php

namespace App\Queries\ListCategories;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListCategoryHandler
{
    public function execute(ListCategoryQuery $query): LengthAwarePaginator
    {
        $builder = Category::query();

        // Filter by search
        if ($query->search) {
            $builder->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query->search . '%')
                  ->orWhere('slug', 'like', '%' . $query->search . '%')
                  ;
            });
        }

        // Filter by active status
        if ($query->isActive !== null) {
            $builder->where('is_active', $query->isActive);
        }
        
        // Filter by category ID
        if ($query->categoryId !== null) {
            $builder->where('id', $query->categoryId);
        }

        // Order and paginate
        $builder->with('children', 'parent')
            ->ordered();


        return $builder->paginate( $query->perPage, ['*'], 'page', $query->page);
    }
}
