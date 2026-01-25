<?php

namespace App\Queries\ListNails;

use App\Models\Nail;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListNailHandler
{
    public function execute(ListNailQuery $query): LengthAwarePaginator
    {
        $builder = Nail::query();

        // Eager load relationships
        $builder->with(['images.media', 'prices']);

        // Filter by search (name or slug)
        if ($query->search) {
            $builder->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query->search . '%')
                  ->orWhere('slug', 'like', '%' . $query->search . '%');
            });
        }

        // Filter by status
        if ($query->status !== null && $query->status !== '') {
            $builder->where('status', $query->status);
        }

        // Order by created_at desc
        $builder->orderBy('created_at', 'desc');

        return $builder->paginate($query->perPage, ['*'], 'page', $query->page);
    }
}
