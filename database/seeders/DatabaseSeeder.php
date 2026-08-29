<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            SettingSeeder::class,
            AdvertisementSlotSeeder::class,
            MenuSeeder::class,
            PageSeeder::class,
            BreakingNewsSeeder::class,
            PostSeeder::class,
        ]);
    }
}
