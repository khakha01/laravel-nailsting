<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Post\PostService;
use App\Services\PostCategory\PostCategoryService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        protected PostService $postService,
        protected PostCategoryService $postCategoryService
    ) {
    }

    /**
     * Display a listing of blog categories and recent posts.
     */
    public function index()
    {
        $categories = $this->postCategoryService->getActiveCategories();
        $posts = $this->postService->getPublishedPosts();

        return view('user.post-page.index', compact('categories', 'posts'));
    }

    /**
     * Handle root level slugs for both categories and posts.
     */
    public function detail($slug)
    {
        // 1. Try to find a blog category
        $category = $this->postCategoryService->findBySlug($slug);
        if ($category) {
            $categories = $this->postCategoryService->getActiveCategories();
            $posts = $this->postService->getPostsByCategory($category->id);
            $currentCategory = $category;
            return view('user.post-page.index', compact('categories', 'posts', 'currentCategory'));
        }

        // 2. Try to find a blog post
        $post = $this->postService->findBySlug($slug);
        if ($post) {
            $relatedPosts = $this->postService->getPostsByCategory($post->post_category_id)
                ->where('id', '!=', $post->id)
                ->take(3);
            return view('user.post-page.show', compact('post', 'relatedPosts'));
        }

        // 3. Not found
        abort(404);
    }

    /**
     * Legacy category method (fallback)
     */
    public function category($slug)
    {
        return $this->detail($slug);
    }

    /**
     * Legacy show method (fallback)
     */
    public function show($categorySlug, $postSlug = null)
    {
        // If postSlug is provided, use it, otherwise use categorySlug as post slug
        return $this->detail($postSlug ?? $categorySlug);
    }
}
