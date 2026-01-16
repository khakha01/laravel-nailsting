<?php

namespace App\Queries\ListPermissions;

use App\Models\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListPermissionHandler
{
    public function execute(ListPermissionQuery $query): LengthAwarePaginator
    {
        $builder = Permission::query();

        // Filter by search
        if (!empty($query->search)) {
            $builder->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query->search}%")
                  ->orWhere('code', 'like', "%{$query->search}%")
                  ->orWhere('description', 'like', "%{$query->search}%");
            });
        }

        // Filter by group
        if (!empty($query->group)) {
            $builder->where('group', $query->group);
        }

        return $builder->orderBy('group')
            ->orderBy('name')
            ->paginate($query->perPage, ['*'], 'page', $query->page);
    }
}
