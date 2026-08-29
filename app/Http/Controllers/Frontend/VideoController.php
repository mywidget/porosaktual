<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class VideoController extends Controller
{
    protected SettingService $settingService;

    public function __construct(
        SettingService $settingService
    ) {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $videos = Post::query()
            ->published()
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.video.index', compact('videos'));
    }
}
