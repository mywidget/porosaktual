<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected PostService $postService;

    public function __construct(
        PostService $postService
    ) {
        $this->postService = $postService;
    }

    public function index()
    {
        return view('frontend.search.index');
    }

    public function search(Request $request)
    {
        if (!$request->filled('q')) {
            return view('frontend.search.index');
        }

        $request->validate([
            'q' => 'required|string|min:2',
        ]);

        $query = $request->input('q');
        $posts = $this->postService->searchPosts($query);

        return view('frontend.search.results', compact('query', 'posts'));
    }

    public function searchAjax(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:2',
        ]);

        $query = $request->input('q');
        $results = $this->postService->searchPosts($query);

        $data = $results->getCollection()->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => $post->excerpt,
                'url' => route('post.show', $post->slug),
                'category' => $post->category->name,
                'published_at' => $post->published_at->diffForHumans(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $results->total(),
        ]);
    }
}
