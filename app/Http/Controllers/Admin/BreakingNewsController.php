<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BreakingNews;
use Illuminate\Http\Request;

class BreakingNewsController extends Controller
{
    public function index(Request $request)
    {
        $query = BreakingNews::with('post');

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sort_by')) {
            $sortBy = $request->sort_by;
            $order = $request->sort_order === 'asc' ? 'asc' : 'desc';
            if ($sortBy === 'priority') {
                $query->orderBy('priority', $order);
            } elseif ($sortBy === 'created_at') {
                $query->orderBy('created_at', $order);
            } elseif ($sortBy === 'start_date') {
                $query->orderBy('start_date', $order);
            }
        } else {
            $query->orderByDesc('priority')->latest();
        }

        $limit = $request->input('limit', 20);
        $breakingNews = $query->paginate($limit)->appends($request->query());

        return view('admin.breaking-news.index', compact('breakingNews'));
    }

    public function create()
    {
        return view('admin.breaking-news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'post_id' => 'nullable|exists:posts,id',
            'is_active' => 'nullable|boolean',
            'priority' => 'required|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? true;

        if (!empty($validated['post_id']) && empty($validated['url'])) {
            $post = \App\Models\Post::find($validated['post_id']);
            $validated['url'] = route('post.show', $post->slug);
        }

        BreakingNews::create($validated);

        return redirect()->route('admin.breaking-news.index')->with('success', 'Breaking news created successfully.');
    }

    public function edit(BreakingNews $breakingNews)
    {
        return view('admin.breaking-news.edit', compact('breakingNews'));
    }

    public function update(Request $request, BreakingNews $breakingNews)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'post_id' => 'nullable|exists:posts,id',
            'is_active' => 'nullable|boolean',
            'priority' => 'required|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if (!empty($validated['post_id']) && empty($validated['url'])) {
            $post = \App\Models\Post::find($validated['post_id']);
            $validated['url'] = route('post.show', $post->slug);
        }

        $breakingNews->update($validated);

        return redirect()->route('admin.breaking-news.index')->with('success', 'Breaking news updated successfully.');
    }

    public function destroy(BreakingNews $breakingNews)
    {
        $breakingNews->delete();

        return redirect()->route('admin.breaking-news.index')->with('success', 'Breaking news deleted successfully.');
    }

    public function toggle(BreakingNews $breakingNews)
    {
        $breakingNews->update(['is_active' => !$breakingNews->is_active]);

        return back()->with('success', 'Status updated.');
    }
}
