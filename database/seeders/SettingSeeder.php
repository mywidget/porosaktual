<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Poros Aktual', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Portal Berita Online Terpercaya', 'group' => 'general'],
            ['key' => 'site_logo', 'value' => null, 'group' => 'general'],
            ['key' => 'site_favicon', 'value' => null, 'group' => 'general'],
            ['key' => 'site_email', 'value' => 'info@porosaktual.com', 'group' => 'general'],
            ['key' => 'site_phone', 'value' => '+62 21 1234 5678', 'group' => 'general'],
            ['key' => 'site_address', 'value' => 'Jakarta, Indonesia', 'group' => 'general'],
            ['key' => 'theme_color', 'value' => '#1d4ed8', 'group' => 'general'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/porosaktual', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/porosaktual', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/porosaktual', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/porosaktual', 'group' => 'social'],
            ['key' => 'tiktok_url', 'value' => '', 'group' => 'social'],
            ['key' => 'google_analytics', 'value' => null, 'group' => 'analytics'],
            ['key' => 'google_tag_manager', 'value' => null, 'group' => 'analytics'],
            ['key' => 'google_adsense', 'value' => null, 'group' => 'adsense'],
            ['key' => 'google_adsense_slot', 'value' => null, 'group' => 'adsense'],
            ['key' => 'google_news_verification', 'value' => null, 'group' => 'seo'],
            ['key' => 'google_search_console', 'value' => null, 'group' => 'seo'],
            ['key' => 'sitemap_index', 'value' => null, 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
