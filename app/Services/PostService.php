<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Tag;
use App\Repositories\PostRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Cache;

class PostService
{
    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getPublishedPosts(?int $categoryId = null, int $limit = 15): LengthAwarePaginator
    {
        if ($categoryId) {
            return $this->postRepository->getByCategory($categoryId);
        }

        return $this->postRepository->all();
    }

    public function getTrendingPosts(int $limit = 10): Collection
    {
        return Cache::remember('trending_posts', 3600, function () use ($limit) {
            return Post::query()
                ->published()
                ->trending()
                ->with(['author', 'category', 'tags'])
                ->orderByDesc('views_count')
                ->latest('published_at')
                ->take($limit)
                ->get();
        });
    }

    public function getBreakingNews(int $limit = 10): Collection
    {
        return Cache::remember('breaking_news', 1800, function () use ($limit) {
            return Post::query()
                ->published()
                ->breaking()
                ->with(['author', 'category', 'tags'])
                ->latest('published_at')
                ->take($limit)
                ->get();
        });
    }

    public function getHighlightPosts(int $limit = 10): Collection
    {
        return Cache::remember('highlight_posts', 3600, function () use ($limit) {
            return Post::query()
                ->published()
                ->highlight()
                ->with(['author', 'category', 'tags'])
                ->latest('published_at')
                ->take($limit)
                ->get();
        });
    }

    public function getSponsoredPosts(int $limit = 5): Collection
    {
        return Cache::remember('sponsored_posts', 7200, function () use ($limit) {
            return Post::query()
                ->published()
                ->sponsored()
                ->with(['author', 'category', 'tags'])
                ->latest('published_at')
                ->take($limit)
                ->get();
        });
    }

    public function getRelatedPosts(Post $post, int $limit = 5): Collection
    {
        return Post::query()
            ->published()
            ->with(['author', 'category', 'tags'])
            ->where('id', '!=', $post->id)
            ->where(function ($query) use ($post) {
                $query->where('category_id', $post->category_id)
                    ->orWhereHas('tags', function ($q) use ($post) {
                        $q->whereIn('tags.id', $post->tags->pluck('id'));
                    });
            })
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    public function searchPosts(string $query): LengthAwarePaginator
    {
        return $this->postRepository->search($query);
    }

    public function getPostsByCategory(string $slug): LengthAwarePaginator
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return new Paginator(collect(), 0, 15);
        }

        return $this->postRepository->getByCategory($category->id);
    }

    public function getPostsByTag(string $slug): LengthAwarePaginator
    {
        $tag = Tag::where('slug', $slug)->first();

        if (!$tag) {
            return new Paginator(collect(), 0, 15);
        }

        return Post::query()
            ->published()
            ->with(['author', 'category', 'tags'])
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('tags.id', $tag->id);
            })
            ->latest('published_at')
            ->paginate(15);
    }

    public function incrementViews(Post $post, Request $request): void
    {
        $ip = $request->ip();
        $today = now()->toDateString();

        $hasViewed = PostView::where('post_id', $post->id)
            ->where('ip_address', $ip)
            ->whereDate('created_at', $today)
            ->exists();

        if (!$hasViewed) {
            PostView::create([
                'post_id' => $post->id,
                'ip_address' => $ip,
                'user_agent' => $request->userAgent(),
            ]);

            $post->increment('views_count');
        }
    }

    public function getPopularPostsThisWeek(int $limit = 10): Collection
    {
        return Cache::remember('popular_posts_week', 3600, function () use ($limit) {
            return Post::query()
                ->published()
                ->with(['author', 'category', 'tags'])
                ->where('published_at', '>=', now()->subWeek())
                ->orderByDesc('views_count')
                ->take($limit)
                ->get();
        });
    }

    public function getLatestPosts(int $limit = 10): Collection
    {
        return Cache::remember('latest_posts', 900, function () use ($limit) {
            return Post::query()
                ->published()
                ->with(['author', 'category', 'tags'])
                ->latest('published_at')
                ->take($limit)
                ->get();
        });
    }

    public function getByAuthor(int $userId): LengthAwarePaginator
    {
        return $this->postRepository->getByAuthor($userId);
    }
}
