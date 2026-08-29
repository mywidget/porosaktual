<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    protected Category $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->query()
            ->with('children')
            ->orderBy('sort_order')
            ->get();
    }

    public function find(int $id): ?Category
    {
        return $this->model->query()
            ->with(['parent', 'children'])
            ->find($id);
    }

    public function findBySlug(string $slug): ?Category
    {
        return $this->model->query()
            ->with(['parent', 'children'])
            ->where('slug', $slug)
            ->first();
    }

    public function create(array $data): Category
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Category
    {
        $category = $this->model->findOrFail($id);
        $category->update($data);
        return $category->fresh(['parent', 'children']);
    }

    public function delete(int $id): bool
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function getRoot(): Collection
    {
        return $this->model->query()
            ->root()
            ->with('children')
            ->orderBy('sort_order')
            ->get();
    }

    public function getActive(): Collection
    {
        return $this->model->query()
            ->active()
            ->with('children')
            ->orderBy('sort_order')
            ->get();
    }
}
