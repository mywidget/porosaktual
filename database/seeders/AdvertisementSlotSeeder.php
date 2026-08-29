<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdvertisementSlot;

class AdvertisementSlotSeeder extends Seeder
{
    public function run(): void
    {
        $slots = [
            ['name' => 'Header Banner', 'slug' => 'header-banner', 'location' => 'header', 'width' => 970, 'height' => 90, 'is_active' => true],
            ['name' => 'Leaderboard Home', 'slug' => 'leaderboard-home', 'location' => 'banner', 'width' => 728, 'height' => 90, 'is_active' => true],
            ['name' => 'Sidebar Top', 'slug' => 'sidebar-top', 'location' => 'sidebar', 'width' => 300, 'height' => 250, 'is_active' => true],
            ['name' => 'Sidebar Sticky', 'slug' => 'sidebar-sticky', 'location' => 'sidebar', 'width' => 300, 'height' => 600, 'is_active' => true],
            ['name' => 'In Article Top', 'slug' => 'in-article-top', 'location' => 'content', 'width' => 728, 'height' => 90, 'is_active' => true],
            ['name' => 'In Article Middle', 'slug' => 'in-article-middle', 'location' => 'content', 'width' => 728, 'height' => 90, 'is_active' => true],
            ['name' => 'In Article Bottom', 'slug' => 'in-article-bottom', 'location' => 'content', 'width' => 728, 'height' => 90, 'is_active' => true],
            ['name' => 'Before Footer', 'slug' => 'before-footer', 'location' => 'footer', 'width' => 970, 'height' => 90, 'is_active' => true],
            ['name' => 'Mobile Banner Bottom', 'slug' => 'mobile-banner-bottom', 'location' => 'banner', 'width' => 320, 'height' => 50, 'is_active' => true],
            ['name' => 'Floating Sticky Ads', 'slug' => 'floating-sticky', 'location' => 'sidebar', 'width' => 300, 'height' => 250, 'is_active' => true],
        ];

        foreach ($slots as $slot) {
            AdvertisementSlot::create($slot);
        }
    }
}
