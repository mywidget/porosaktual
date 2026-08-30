<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdvertisementSlot;

class AdvertisementSlotSeeder extends Seeder
{
    public function run(): void
    {
        $slots = [
            ['name' => 'Banner Atas', 'slug' => 'header-banner', 'location' => 'header', 'width' => 970, 'height' => 90, 'is_active' => true],
            ['name' => 'Leaderboard Beranda', 'slug' => 'leaderboard-home', 'location' => 'banner', 'width' => 728, 'height' => 90, 'is_active' => true],
            ['name' => 'Sidebar Atas', 'slug' => 'sidebar-top', 'location' => 'sidebar', 'width' => 300, 'height' => 250, 'is_active' => true],
            ['name' => 'Sidebar Statis', 'slug' => 'sidebar-sticky', 'location' => 'sidebar', 'width' => 300, 'height' => 600, 'is_active' => true],
            ['name' => 'Dalam Artikel Atas', 'slug' => 'in-article-top', 'location' => 'content', 'width' => 728, 'height' => 90, 'is_active' => true],
            ['name' => 'Dalam Artikel Tengah', 'slug' => 'in-article-middle', 'location' => 'content', 'width' => 728, 'height' => 90, 'is_active' => true],
            ['name' => 'Dalam Artikel Bawah', 'slug' => 'in-article-bottom', 'location' => 'content', 'width' => 728, 'height' => 90, 'is_active' => true],
            ['name' => 'Sebelum Footer', 'slug' => 'before-footer', 'location' => 'footer', 'width' => 970, 'height' => 90, 'is_active' => true],
            ['name' => 'Banner Mobile Bawah', 'slug' => 'mobile-banner-bottom', 'location' => 'banner', 'width' => 320, 'height' => 50, 'is_active' => true],
            ['name' => 'Iklan Statis Mengambang', 'slug' => 'floating-sticky', 'location' => 'sidebar', 'width' => 300, 'height' => 250, 'is_active' => true],
        ];

        foreach ($slots as $slot) {
            AdvertisementSlot::create($slot);
        }
    }
}
