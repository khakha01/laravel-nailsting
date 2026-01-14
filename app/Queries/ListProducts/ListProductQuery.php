<?php

namespace App\Queries\ListProducts;

class ListProductQuery
{
    public function __construct(
        public ?string $search = null,
        public ?int $categoryId = null,
        public ?bool $isActive = null,
        public int $page = 1,
        public int $perPage = 15,
    ) {}
}
