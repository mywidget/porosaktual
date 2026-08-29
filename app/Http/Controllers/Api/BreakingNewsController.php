<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BreakingNews;
use Illuminate\Http\JsonResponse;

class BreakingNewsController extends Controller
{
    public function index()
    {
        $breakingNews = BreakingNews::active()
            ->orderBy('published_at', 'desc')
            ->get();

        return response()->json($breakingNews);
    }
}
