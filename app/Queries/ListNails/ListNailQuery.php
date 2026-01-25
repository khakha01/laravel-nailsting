<?php

namespace App\Queries\ListNails;

class ListNailQuery
{
    public function __construct(
        public ?string $search = null,
        public ?string $status = null,
        public int $page = 1,
        public int $perPage = 15,
    ) {
        $this->search = trim($this->search ?? '');
    }
}
