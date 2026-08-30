<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostView;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPosts = Post::withTrashed()->count();
        $totalUsers = User::count();
        $totalComments = Comment::withTrashed()->count();
        $pendingComments = Comment::where('status', 'pending')->count();
        $totalViews = Post::sum('views_count');

        $viewsData = PostView::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

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
            'totalViews', 'viewsData',
            'categoryStats', 'recentPosts', 'recentComments'
        ));
    }

    public function viewsData(Request $request)
    {
        $period = $request->input('period', '7d');
        $days = match($period) {
            '30d' => 30,
            '90d' => 90,
            default => 7,
        };

        $data = PostView::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $labels = [];
        $values = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d M');
            $values[] = $data[$date] ?? 0;
        }

        return response()->json(['labels' => $labels, 'data' => $values]);
    }
}
