<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\SeoService;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    protected PostService $postService;
    protected CategoryService $categoryService;
    protected SeoService $seoService;

    public function __construct(
        PostService $postService,
        CategoryService $categoryService,
        SeoService $seoService
    ) {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
        $this->seoService = $seoService;
    }

    public function index(): Response
    {
        $xml = $this->seoService->generateSitemap();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }

    public function news(): Response
    {
        $xml = $this->seoService->generateNewsSitemap();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}
