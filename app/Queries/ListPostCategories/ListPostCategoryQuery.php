<?php

namespace App\Queries\ListPostCategories;

class ListPostCategoryQuery
{
    public function __construct(
        public ?string $search = null,
        public ?bool $isActive = null,
        public ?int $parentId = null,
        public int $page = 1,
        public int $perPage = 15,
    ) {
    }
}
