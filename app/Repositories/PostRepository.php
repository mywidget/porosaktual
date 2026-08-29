<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PostRepository
{
    protected Post $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function all(): LengthAwarePaginator
    {
        return $this->model->query()
            ->published()
            ->with(['author', 'category', 'tags'])
            ->latest('published_at')
            ->paginate(15);
    }

    public function find(int $id): ?Post
    {
        return $this->model->query()
            ->with(['author', 'category', 'tags'])
            ->find($id);
    }

    public function findBySlug(string $slug): ?Post
    {
        return $this->model->query()
            ->with(['author', 'category', 'tags'])
            ->where('slug', $slug)
            ->first();
    }

    public function create(array $data): Post
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Post
    {
        $post = $this->model->findOrFail($id);
        $post->update($data);
        return $post->fresh(['author', 'category', 'tags']);
    }

    public function delete(int $id): bool
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function getByCategory(int $categoryId): LengthAwarePaginator
    {
        return $this->model->query()
            ->published()
            ->with(['author', 'category', 'tags'])
            ->byCategory($categoryId)
            ->latest('published_at')
            ->paginate(15);
    }

    public function getByAuthor(int $authorId): LengthAwarePaginator
    {
        return $this->model->query()
            ->published()
            ->with(['author', 'category', 'tags'])
            ->where('author_id', $authorId)
            ->latest('published_at')
            ->paginate(15);
    }

    public function getTrending(): Collection
    {
        return $this->model->query()
            ->published()
            ->trending()
            ->with(['author', 'category', 'tags'])
            ->latest('published_at')
            ->take(10)
            ->get();
    }

    public function search(string $query): LengthAwarePaginator
    {
        return $this->model->query()
            ->published()
            ->with(['author', 'category', 'tags'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('excerpt', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%");
            })
            ->latest('published_at')
            ->paginate(15);
    }
}
