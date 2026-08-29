<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\CategoryService;
use App\Services\PostService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;
    protected PostService $postService;

    public function __construct(
        CategoryService $categoryService,
        PostService $postService
    ) {
        $this->categoryService = $categoryService;
        $this->postService = $postService;
    }

    public function show(Request $request, string $slug)
    {
        $category = $this->categoryService->getCategoryBySlug($slug);

        if (!$category) {
            abort(404);
        }

        $posts = $this->postService->getPostsByCategory($slug);

        $popularPosts = \App\Models\Post::published()
            ->with(['author', 'category'])
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        $tags = Tag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(20)
            ->get();

        return view('frontend.category.show', compact('category', 'posts', 'popularPosts', 'tags'));
    }
}
