<?php

namespace App\Queries\ListPosts;

class ListPostQuery
{
    public function __construct(
        public ?string $search = null,
        public ?string $status = null,
        public ?int $postCategoryId = null,
        public int $page = 1,
        public int $perPage = 15,
    ) {
    }
}
