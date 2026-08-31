<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\CategoryService;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected PostService $postService;
    protected CategoryService $categoryService;

    public function __construct(PostService $postService, CategoryService $categoryService)
    {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $query = Post::with(['author', 'category', 'tags']);

        // Wartawan hanya bisa lihat post sendiri
        if (auth()->user()->hasRole('wartawan')) {
            $query->where('author_id', auth()->id());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('author_id') && !auth()->user()->hasRole('wartawan')) {
            $query->where('author_id', $request->author_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $limit = $request->input('limit', 20);
        $posts = $query->latest()->paginate($limit);
        $categories = Category::orderBy('name')->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = $this->categoryService->getActiveCategories();
        $tags = Tag::orderBy('name')->get();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'required|in:draft,published,scheduled',
            'scheduled_at' => 'nullable|date|after:now',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'og_image' => 'nullable|image|max:2048',
            'featured_image_position' => 'nullable|in:top,center,bottom',
            'is_trending' => 'nullable|boolean',
            'is_breaking' => 'nullable|boolean',
            'is_highlight' => 'nullable|boolean',
            'is_sponsored' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['author_id'] = auth()->id();

        // Wartawan selalu simpan sebagai draft
        if (auth()->user()->hasRole('wartawan')) {
            $validated['status'] = 'draft';
            unset($validated['scheduled_at']);
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $validated['featured_image_position'] = $validated['featured_image_position'] ?? 'center';

        $tags = collect($validated['tags'] ?? []);
        unset($validated['tags']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }
        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $request->file('og_image')->store('posts/og', 'public');
        }

        $validated['reading_time'] = max(1, ceil(str_word_count(strip_tags($validated['content'])) / 200));

        $post = Post::create($validated);
        $post->tags()->sync($tags);

        $this->clearPostCache();

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        // Wartawan hanya bisa edit post sendiri
        if (auth()->user()->hasRole('wartawan') && $post->author_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah berita ini.');
        }

        $post->load('tags');
        $categories = $this->categoryService->getActiveCategories();
        $tags = Tag::orderBy('name')->get();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        // Wartawan hanya bisa edit post sendiri
        if (auth()->user()->hasRole('wartawan') && $post->author_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah berita ini.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'required|in:draft,published,scheduled',
            'scheduled_at' => 'nullable|date|after:now',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'og_image' => 'nullable|image|max:2048',
            'featured_image_position' => 'nullable|in:top,center,bottom',
            'is_trending' => 'nullable|boolean',
            'is_breaking' => 'nullable|boolean',
            'is_highlight' => 'nullable|boolean',
            'is_sponsored' => 'nullable|boolean',
        ]);

        if ($validated['title'] !== $post->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Wartawan tidak bisa ubah status — selalu draft
        if (auth()->user()->hasRole('wartawan')) {
            $validated['status'] = 'draft';
            unset($validated['scheduled_at']);
            unset($validated['is_trending']);
            unset($validated['is_breaking']);
            unset($validated['is_highlight']);
            unset($validated['is_sponsored']);
        }

        if ($validated['status'] === 'published' && !$post->published_at) {
            $validated['published_at'] = now();
        }

        $tags = collect($validated['tags'] ?? []);
        unset($validated['tags']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }
        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $request->file('og_image')->store('posts/og', 'public');
        }

        $validated['reading_time'] = max(1, ceil(str_word_count(strip_tags($validated['content'])) / 200));
        $validated['featured_image_position'] = $validated['featured_image_position'] ?? 'center';

        $post->update($validated);
        $post->tags()->sync($tags);

        $this->clearPostCache();

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        // Wartawan hanya bisa hapus post sendiri
        if (auth()->user()->hasRole('wartawan') && $post->author_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus berita ini.');
        }

        $post->delete();

        $this->clearPostCache();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }

    public function publish(Post $post)
    {
        // Wartawan tidak bisa publish
        if (auth()->user()->hasRole('wartawan')) {
            abort(403, 'Wartawan tidak dapat mempublikasikan berita.');
        }

        $post->update([
            'status' => 'published',
            'published_at' => $post->published_at ?? now(),
        ]);

        $this->clearPostCache();

        return back()->with('success', 'Post published successfully.');
    }

    public function schedule(Request $request, Post $post)
    {
        if (auth()->user()->hasRole('wartawan')) {
            abort(403, 'Wartawan tidak dapat menjadwalkan berita.');
        }

        $request->validate([
            'scheduled_at' => 'required|date|after:now',
        ]);

        $post->update([
            'status' => 'scheduled',
            'scheduled_at' => $request->scheduled_at,
        ]);

        return back()->with('success', 'Post scheduled successfully.');
    }

    public function toggleTrending(Post $post)
    {
        if (auth()->user()->hasRole('wartawan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        $post->update(['is_trending' => !$post->is_trending]);

        return back()->with('success', 'Trending status updated.');
    }

    public function toggleBreaking(Post $post)
    {
        if (auth()->user()->hasRole('wartawan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        $post->update(['is_breaking' => !$post->is_breaking]);

        return back()->with('success', 'Breaking status updated.');
    }

    public function toggleHighlight(Post $post)
    {
        if (auth()->user()->hasRole('wartawan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        $post->update(['is_highlight' => !$post->is_highlight]);

        return back()->with('success', 'Highlight status updated.');
    }

    public function bulkAction(Request $request)
    {
        if (auth()->user()->hasRole('wartawan')) {
            abort(403, 'Anda tidak memiliki akses untuk bulk action.');
        }

        $request->validate([
            'action' => 'required|in:publish,draft,delete',
            'ids' => 'required|array',
        ]);

        $ids = $request->ids;

        switch ($request->action) {
            case 'publish':
                Post::whereIn('id', $ids)->update(['status' => 'published', 'published_at' => now()]);
                break;
            case 'draft':
                Post::whereIn('id', $ids)->update(['status' => 'draft']);
                break;
            case 'delete':
                Post::whereIn('id', $ids)->delete();
                break;
        }

        $this->clearPostCache();

        return back()->with('success', 'Bulk action completed.');
    }

    private function clearPostCache(): void
    {
        Cache::forget('latest_posts');
        Cache::forget('trending_posts');
        Cache::forget('breaking_news');
        Cache::forget('highlight_posts');
        Cache::forget('sponsored_posts');
        Cache::forget('popular_posts_week');
    }
}
