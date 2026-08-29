<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;

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

        // Get settings from request
        $settings = $request->input('settings', []);

        // List of checkbox settings that need special handling
        $checkboxSettings = ['comment_enabled', 'comment_moderation'];

        // Ensure unchecked checkboxes are saved as '0'
        foreach ($checkboxSettings as $setting) {
            if (!isset($settings[$setting])) {
                $settings[$setting] = '0';
            }
        }

        foreach ($settings as $key => $value) {
            $group = explode('.', $key)[0] ?? 'general';
            $this->settingService->set($key, $value, $group);
        }

        return back()->with('success', 'Settings saved successfully.');
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
