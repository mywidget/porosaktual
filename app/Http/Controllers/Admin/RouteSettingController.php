<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RouteSettingController extends Controller
{
    protected SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $routes = [
            'post' => $this->settingService->get('route_post_prefix', 'news'),
            'category' => $this->settingService->get('route_category_prefix', 'kategori'),
            'tag' => $this->settingService->get('route_tag_prefix', 'tag'),
            'author' => $this->settingService->get('route_author_prefix', 'penulis'),
            'page' => $this->settingService->get('route_page_prefix', 'page'),
            'search' => $this->settingService->get('route_search_prefix', 'pencarian'),
            'video' => $this->settingService->get('route_video_prefix', 'video'),
        ];

        return view('admin.settings.routes', compact('routes'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'route_post_prefix' => 'nullable|string|max:50',
            'route_category_prefix' => 'nullable|string|max:50',
            'route_tag_prefix' => 'nullable|string|max:50',
            'route_author_prefix' => 'nullable|string|max:50',
            'route_page_prefix' => 'nullable|string|max:50',
            'route_search_prefix' => 'nullable|string|max:50',
            'route_video_prefix' => 'nullable|string|max:50',
        ]);

        foreach ($validated as $key => $value) {
            $value = trim($value, '/');
            $this->settingService->set($key, $value, 'routes');
        }

        // Clear all route-related caches
        Cache::forget('all_settings');
        Cache::forget('poros-aktual-cache-all_settings');
        Cache::forget('settings_all');

        return redirect()->route('admin.settings.routes')->with('success', 'Pengaturan route berhasil disimpan. Restart server jika route belum berubah.');
    }
}
