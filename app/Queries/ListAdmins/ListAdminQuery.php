<?php

namespace App\Queries\ListAdmins;

class ListAdminQuery
{
    public function __construct(
        public int $page = 1,
        public int $perPage = 15,
        public ?string $search = null,
        public ?bool $isActive = null,
    ) {
        $this->search = trim($this->search ?? '');
    }
}
