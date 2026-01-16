<?php

namespace App\Queries\ListAdmins;

use App\Models\Admin;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListAdminHandler
{
    public function execute(ListAdminQuery $query): LengthAwarePaginator
    {
        $builder = Admin::with('permissions');

        // Filter by search
        if (!empty($query->search)) {
            $builder->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query->search}%")
                  ->orWhere('email', 'like', "%{$query->search}%")
                  ->orWhere('phone', 'like', "%{$query->search}%");
            });
        }

        // Filter by active status
        if ($query->isActive !== null) {
            $builder->where('is_active', $query->isActive);
        }

        return $builder->paginate($query->perPage, ['*'], 'page', $query->page);
    }
}
