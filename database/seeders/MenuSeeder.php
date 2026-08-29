<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            ['name' => 'Home', 'url' => '/', 'location' => 'header', 'sort_order' => 0, 'is_active' => true],
            ['name' => 'Politik', 'url' => '/kategori/politik', 'location' => 'header', 'sort_order' => 1, 'is_active' => true],
            ['name' => 'Nasional', 'url' => '/kategori/nasional', 'location' => 'header', 'sort_order' => 2, 'is_active' => true],
            ['name' => 'Ekonomi', 'url' => '/kategori/ekonomi', 'location' => 'header', 'sort_order' => 3, 'is_active' => true],
            ['name' => 'Teknologi', 'url' => '/kategori/teknologi', 'location' => 'header', 'sort_order' => 4, 'is_active' => true],
            ['name' => 'Olahraga', 'url' => '/kategori/olahraga', 'location' => 'header', 'sort_order' => 5, 'is_active' => true],
            ['name' => 'Video', 'url' => '/video', 'location' => 'header', 'sort_order' => 6, 'is_active' => true],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }

        // Footer menus
        $footerMenus = [
            ['name' => 'Profil', 'url' => '/page/profil', 'location' => 'footer', 'sort_order' => 0, 'is_active' => true],
            ['name' => 'Visi & Misi', 'url' => '/page/visi-misi', 'location' => 'footer', 'sort_order' => 1, 'is_active' => true],
            ['name' => 'Redaksi', 'url' => '/page/redaksi', 'location' => 'footer', 'sort_order' => 2, 'is_active' => true],
            ['name' => 'Pedoman Siber', 'url' => '/page/pedoman-siber', 'location' => 'footer', 'sort_order' => 3, 'is_active' => true],
            ['name' => 'Disclaimer', 'url' => '/page/disclaimer', 'location' => 'footer', 'sort_order' => 4, 'is_active' => true],
            ['name' => 'Privacy Policy', 'url' => '/page/privacy-policy', 'location' => 'footer', 'sort_order' => 5, 'is_active' => true],
            ['name' => 'Kontak', 'url' => '/page/kontak', 'location' => 'footer', 'sort_order' => 6, 'is_active' => true],
        ];

        foreach ($footerMenus as $menu) {
            Menu::create($menu);
        }
    }
}
