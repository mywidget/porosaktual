<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json(['message' => 'Query must be at least 2 characters'], 422);
        }

        $posts = Post::published()
            ->with(['author:id,name,avatar,slug', 'category:id,name,slug'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%")
                  ->orWhere('excerpt', 'LIKE', "%{$query}%");
            })
            ->orderBy('published_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return PostResource::collection($posts);
    }
}
