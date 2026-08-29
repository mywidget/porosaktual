<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\AdvertisementService;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\VisitorService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected PostService $postService;
    protected CategoryService $categoryService;
    protected AdvertisementService $advertisementService;
    protected VisitorService $visitorService;

    public function __construct(
        PostService $postService,
        CategoryService $categoryService,
        AdvertisementService $advertisementService,
        VisitorService $visitorService
    ) {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
        $this->advertisementService = $advertisementService;
        $this->visitorService = $visitorService;
    }

    public function index(Request $request)
    {
        $highlights = $this->postService->getHighlightPosts(5);

        $heroPost = $highlights->first();
        $featuredPosts = $highlights->skip(1)->take(3);

        $trendingPosts = $this->postService->getTrendingPosts(10);
        $latestPosts = $this->postService->getLatestPosts(15);
        $editorsChoice = $this->postService->getHighlightPosts(6);
        $popularPosts = $this->postService->getPopularPostsThisWeek(10);
        $popularThisWeek = $this->postService->getPopularPostsThisWeek(6);

        $categories = $this->categoryService->getRootCategories();
        $categoryPostsMap = [];
        foreach ($categories as $category) {
            $categoryPostsMap[$category->slug] = $this->postService->getPublishedPosts($category->id, 4);
        }

        $popularTags = Tag::withCount('posts')->orderBy('posts_count', 'desc')->limit(20)->get();

        $adsHeader = $this->advertisementService->getAdsForSlot('header-banner');
        $adsSidebar = $this->advertisementService->getAdsForSlot('sidebar-top');
        $adsFooter = $this->advertisementService->getAdsForSlot('before-footer');
        $adsInline = $this->advertisementService->getAdsForSlot('in-article-top');

        return view('frontend.home', compact(
            'heroPost',
            'featuredPosts',
            'trendingPosts',
            'latestPosts',
            'editorsChoice',
            'popularPosts',
            'popularThisWeek',
            'categories',
            'categoryPostsMap',
            'popularTags',
            'adsHeader',
            'adsSidebar',
            'adsFooter',
            'adsInline',
        ));
    }
}
