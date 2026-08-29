<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BreakingNews;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPosts = Post::withTrashed()->count();
        $totalUsers = User::count();
        $totalComments = Comment::withTrashed()->count();
        $pendingComments = Comment::where('status', 'pending')->count();

        $categoryStats = Category::withCount('posts')
            ->orderByDesc('posts_count')
            ->get();

        $recentPosts = Post::with(['author', 'category'])
            ->latest()
            ->take(10)
            ->get();

        $recentComments = Comment::with(['post', 'user'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalPosts', 'totalUsers', 'totalComments', 'pendingComments',
            'categoryStats', 'recentPosts', 'recentComments'
        ));
    }
}
