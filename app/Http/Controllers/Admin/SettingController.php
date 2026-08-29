<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    protected SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $settings = $this->settingService->all();
        $grouped = $settings->groupBy(function ($value, $key) {
            return explode('.', $key)[0] ?? 'general';
        });

        return view('admin.settings.index', compact('settings', 'grouped'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);

        $settings = $request->input('settings', []);

        $checkboxSettings = ['comment_enabled', 'comment_moderation'];

        foreach ($checkboxSettings as $setting) {
            if (!isset($settings[$setting])) {
                $settings[$setting] = '0';
            }
        }

        foreach ($settings as $key => $value) {
            $group = match(true) {
                str_starts_with($key, 'seo_') => 'seo',
                str_starts_with($key, 'social_') => 'social',
                str_starts_with($key, 'google_') => 'analytics',
                str_starts_with($key, 'adsense_') => 'adsense',
                default => 'general',
            };
            $this->settingService->set($key, $value, $group);
        }

        $fileFields = [
            'site_logo' => 'general',
            'site_favicon' => 'general',
            'site_footer_logo' => 'general',
            'seo_og_image' => 'seo',
        ];
        foreach ($fileFields as $field => $group) {
            if ($request->hasFile($field)) {
                $existing = $this->settingService->get($field);
                if ($existing && Storage::disk('public')->exists($existing)) {
                    Storage::disk('public')->delete($existing);
                }
                $path = $request->file($field)->store('settings', 'public');
                $this->settingService->set($field, $path, $group);
            }
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function website()
    {
        $settings = $this->settingService->getGroup('website');

        return view('admin.settings.website', compact('settings'));
    }

    public function social()
    {
        $settings = $this->settingService->getGroup('social');

        return view('admin.settings.social', compact('settings'));
    }

    public function analytics()
    {
        $settings = $this->settingService->getGroup('analytics');

        return view('admin.settings.analytics', compact('settings'));
    }
}
