<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    protected PostService $postService;

    public function __construct(
        PostService $postService
    ) {
        $this->postService = $postService;
    }

    public function show(Request $request, string $slug)
    {
        $author = User::where('slug', $slug)->firstOrFail();

        $posts = $this->postService->getByAuthor($author->id);

        return view('frontend.author.show', compact('author', 'posts'));
    }
}
