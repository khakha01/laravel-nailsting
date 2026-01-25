<?php

namespace App\Queries\ListNailCategories;

class ListNailCategoryQuery
{
    public function __construct(
        public int $page = 1,
        public int $perPage = 15,
        public ?string $search = null,
        public ?int $categoryId = null,
    ) {
        $this->search = trim($this->search ?? '');
    }
}
