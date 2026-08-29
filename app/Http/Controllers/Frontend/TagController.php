<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\PostService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected PostService $postService;

    public function __construct(
        PostService $postService
    ) {
        $this->postService = $postService;
    }

    public function show(Request $request, string $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $posts = $this->postService->getPostsByTag($slug);

        return view('frontend.tag.show', compact('tag', 'posts'));
    }
}
