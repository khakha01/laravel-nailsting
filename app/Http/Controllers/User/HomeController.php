<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\BookingDate\BookingDateService;
use App\Services\Category\CategoryService;
use App\Services\Nail\NailService;
use App\Services\Banner\BannerService;
use App\Services\Post\PostService;
use App\Services\PostCategory\PostCategoryService;

class HomeController extends Controller
{
    public function __construct(
        protected BookingDateService $bookingDateService,
        protected CategoryService $categoryService,
        protected NailService $nailService,
        protected BannerService $bannerService,
        protected PostService $postService,
        protected PostCategoryService $postCategoryService
    ) {
    }

    public function index()
    {
        $availableDates = $this->bookingDateService->getAvailableDates();
        $bookingServices = $this->categoryService->getBookingServices();
        $nails = $this->nailService->getHomePageNails(6);

        // Get feedback banner by configured ID
        $feedbackBannerId = config('banners.feedback_banner_id');
        $feedbackBanner = $feedbackBannerId ? $this->bannerService->findById($feedbackBannerId) : null;

        // Get home banner by configured ID
        $homeBannerId = config('banners.home_banner_id');
        $homeBanner = $homeBannerId ? $this->bannerService->findById($homeBannerId) : null;

        // Get blog posts by configured category ID
        $blogCategoryId = config('posts.home_blog_category_id');
        $blogCategory = null;
        $homeBlogs = collect();

        if ($blogCategoryId) {
            $blogCategory = $this->postCategoryService->findById($blogCategoryId);
            $homeBlogs = $this->postService->getPostsByCategory($blogCategoryId);
        }

        return view('home', compact('availableDates', 'bookingServices', 'nails', 'feedbackBanner', 'homeBanner', 'homeBlogs', 'blogCategory'));
    }
}
