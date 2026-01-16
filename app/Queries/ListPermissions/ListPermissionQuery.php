<?php

namespace App\Queries\ListPermissions;

class ListPermissionQuery
{
    public function __construct(
        public int $page = 1,
        public int $perPage = 15,
        public ?string $search = null,
        public ?string $group = null,
    ) {
        $this->search = trim($this->search ?? '');
        $this->group = trim($this->group ?? '');
    }
}
