<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function getActiveCategories(): Collection
    {
        return Category::query()
            ->active()
            ->with('children')
            ->orderBy('sort_order')
            ->get();
    }

    public function getRootCategories(): Collection
    {
        return Category::query()
            ->root()
            ->active()
            ->with(['children' => function ($query) {
                $query->active()->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();
    }

    public function getCategoryBySlug(string $slug): ?Category
    {
        return Category::query()
            ->with(['parent', 'children'])
            ->where('slug', $slug)
            ->first();
    }

    public function getPostCount(int $categoryId): int
    {
        return (int) Category::where('id', $categoryId)
            ->withCount('posts')
            ->value('posts_count');
    }
}
