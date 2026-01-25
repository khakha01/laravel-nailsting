<?php

namespace App\Queries\ListCategories;

class ListCategoryQuery
{
    public function __construct(
        public int $page = 1,
        public int $perPage = 10,
        public ?string $search = null,
        public ?bool $isActive = null,
        public ?int $categoryId = null,
    ) {
        $this->search = trim($this->search ?? '');
    }
}
