<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CommentService;
use App\Services\SettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected CommentService $commentService;
    protected SettingService $settingService;

    public function __construct(
        CommentService $commentService,
        SettingService $settingService
    ) {
        $this->commentService = $commentService;
        $this->settingService = $settingService;
    }

    public function store(Request $request): JsonResponse
    {
        $commentEnabled = $this->settingService->get('comment_enabled', '1');
        if ($commentEnabled !== '1') {
            return response()->json([
                'success' => false,
                'message' => 'Komentar saat ini tidak aktif.',
            ], 403);
        }

        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'content' => 'required|string|max:5000',
        ]);

        $moderation = $this->settingService->get('comment_moderation', '1');
        $validated['status'] = $moderation === '1' ? 'pending' : 'approved';
        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->userAgent();

        $this->commentService->addComment($validated);

        $message = $moderation === '1'
            ? 'Komentar berhasil dikirim dan menunggu moderasi.'
            : 'Komentar berhasil dikirim.';

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
}
