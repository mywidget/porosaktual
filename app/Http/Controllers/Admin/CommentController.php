<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index(Request $request)
    {
        $query = Comment::with(['post', 'user'])->withTrashed();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $comments = $query->latest()->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $this->commentService->approveComment($comment->id);

        return back()->with('success', 'Comment approved.');
    }

    public function reject(Comment $comment)
    {
        $this->commentService->rejectComment($comment->id);

        return back()->with('success', 'Comment rejected.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
