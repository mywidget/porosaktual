<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Response;

class RssController extends Controller
{
    protected PostService $postService;

    public function __construct(
        PostService $postService
    ) {
        $this->postService = $postService;
    }

    public function index(): Response
    {
        $posts = Post::query()
            ->published()
            ->with(['author', 'category'])
            ->latest('published_at')
            ->take(20)
            ->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
        $xml .= '<channel>';
        $xml .= '<title>' . htmlspecialchars(config('app.name')) . '</title>';
        $xml .= '<link>' . url('/') . '</link>';
        $xml .= '<description>' . htmlspecialchars(config('app.description', '')) . '</description>';
        $xml .= '<language>id-id</language>';
        $xml .= '<atom:link href="' . url('/feed') . '" rel="self" type="application/rss+xml"/>';

        foreach ($posts as $post) {
            $xml .= '<item>';
            $xml .= '<title>' . htmlspecialchars($post->title) . '</title>';
            $xml .= '<link>' . route('post.show', $post->slug) . '</link>';
            $xml .= '<guid isPermaLink="true">' . route('post.show', $post->slug) . '</guid>';
            $xml .= '<description>' . htmlspecialchars($post->excerpt) . '</description>';
            $xml .= '<pubDate>' . $post->published_at->toRfc2822String() . '</pubDate>';
            $xml .= '<category>' . htmlspecialchars($post->category->name) . '</category>';
            $xml .= '<dc:creator>' . htmlspecialchars($post->author->name) . '</dc:creator>';
            $xml .= '</item>';
        }

        $xml .= '</channel>';
        $xml .= '</rss>';

        return response($xml, 200)
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }
}
