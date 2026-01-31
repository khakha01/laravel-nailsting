<?php

namespace App\Queries\ListPosts;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class ListPostHandler
{
    public function execute(ListPostQuery $query): LengthAwarePaginator
    {
        return Post::query()
            ->with(['category', 'author', 'media'])
            ->when($query->search, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('title', 'like', "%{$query->search}%")
                        ->orWhere('slug', 'like', "%{$query->search}%");
                });
            })
            ->when($query->status, function ($q) use ($query) {
                return $q->where('status', $query->status);
            })
            ->when($query->postCategoryId, function ($q) use ($query) {
                return $q->where('post_category_id', $query->postCategoryId);
            })
            ->orderByDesc('created_at')
            ->paginate($query->perPage, ['*'], 'page', $query->page);
    }
}
