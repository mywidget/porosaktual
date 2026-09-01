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
            ['key' => 'site_footer_logo', 'value' => null, 'group' => 'general'],
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
            ['key' => 'seo_meta_title', 'value' => 'Poros Aktual - Portal Berita Terpercaya', 'group' => 'seo'],
            ['key' => 'seo_meta_description', 'value' => 'Portal berita terkini Indonesia. Temukan berita politik, nasional, ekonomi, teknologi, olahraga, dan lifestyle terbaru.', 'group' => 'seo'],
            ['key' => 'seo_meta_keywords', 'value' => 'berita, news, Indonesia, terkini, politik, nasional, ekonomi, teknologi, olahraga, lifestyle', 'group' => 'seo'],
            ['key' => 'seo_og_image', 'value' => null, 'group' => 'seo'],

            // Route prefixes (WordPress-style)
            ['key' => 'route_post_prefix', 'value' => 'news', 'group' => 'routes'],
            ['key' => 'route_category_prefix', 'value' => 'kategori', 'group' => 'routes'],
            ['key' => 'route_tag_prefix', 'value' => 'tag', 'group' => 'routes'],
            ['key' => 'route_author_prefix', 'value' => 'penulis', 'group' => 'routes'],
            ['key' => 'route_page_prefix', 'value' => 'page', 'group' => 'routes'],
            ['key' => 'route_search_prefix', 'value' => 'pencarian', 'group' => 'routes'],
            ['key' => 'route_video_prefix', 'value' => 'video', 'group' => 'routes'],

            // Comment settings
            ['key' => 'comment_enabled', 'value' => '1', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }
    }
}
