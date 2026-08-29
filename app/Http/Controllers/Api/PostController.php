<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::published()
            ->with(['author:id,name,avatar,slug', 'category:id,name,slug'])
            ->orderBy('published_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return PostResource::collection($posts);
    }

    public function show($slug)
    {
        $post = Post::published()
            ->with(['author:id,name,avatar,slug', 'category:id,name,slug', 'tags:id,name,slug'])
            ->where('slug', $slug)
            ->firstOrFail();

        $post->increment('views_count');

        return new PostResource($post);
    }

    public function trending()
    {
        $posts = Post::published()
            ->with(['author:id,name,avatar,slug', 'category:id,name,slug'])
            ->where('is_trending', true)
            ->orderBy('views_count', 'desc')
            ->limit(10)
            ->get();

        return PostResource::collection($posts);
    }
}
