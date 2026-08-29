<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::active()
            ->withCount('posts')
            ->orderBy('name')
            ->get();

        return CategoryResource::collection($categories);
    }

    public function posts($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = $category->posts()
            ->published()
            ->with(['author:id,name,avatar,slug', 'category:id,name,slug'])
            ->orderBy('published_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return PostResource::collection($posts);
    }
}
