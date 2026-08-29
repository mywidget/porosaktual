<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CommentService
{
    public function getApprovedComments(int $postId): Collection
    {
        return Comment::approved()
            ->where('post_id', $postId)
            ->with('user')
            ->latest()
            ->get();
    }

    public function addComment(array $data): Comment
    {
        return Comment::create($data);
    }

    public function approveComment(int $commentId): Comment
    {
        $comment = Comment::findOrFail($commentId);
        $comment->update(['status' => 'approved']);
        return $comment;
    }

    public function rejectComment(int $commentId): Comment
    {
        $comment = Comment::findOrFail($commentId);
        $comment->update(['status' => 'rejected']);
        return $comment;
    }

    public function getPendingComments(int $limit = 20): LengthAwarePaginator
    {
        return Comment::where('status', 'pending')
            ->with(['post', 'user'])
            ->latest()
            ->paginate($limit);
    }

    public function getCommentCount(int $postId): int
    {
        return (int) Comment::where('post_id', $postId)
            ->approved()
            ->count();
    }
}
