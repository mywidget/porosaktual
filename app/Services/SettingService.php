<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    protected int $cacheTTL = 3600;

    public function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting_{$key}", $this->cacheTTL, function () use ($key, $default) {
            return Setting::get($key, $default);
        });
    }

    public function set(string $key, mixed $value = null, string $group = 'general'): Setting
    {
        $setting = Setting::set($key, $value, $group);

        Cache::forget("setting_{$key}");
        Cache::forget("setting_group_{$group}");
        Cache::forget('settings_all');
        Cache::forget('poros-aktual-cache-all_settings');
        Cache::forget('all_settings');

        return $setting;
    }

    public function getGroup(string $group): \Illuminate\Support\Collection
    {
        return Cache::remember("setting_group_{$group}", $this->cacheTTL, function () use ($group) {
            return Setting::where('group', $group)->pluck('value', 'key');
        });
    }

    public function all(): \Illuminate\Support\Collection
    {
        return Cache::remember('settings_all', $this->cacheTTL, function () {
            return Setting::pluck('value', 'key');
        });
    }

    public static function getAllSettings(): array
    {
        return cache()->remember('all_settings', 3600, function () {
            return \App\Models\Setting::pluck('value', 'key')->toArray();
        });
    }
}
