<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Politik', 'slug' => 'politik', 'description' => 'Berita politik terkini', 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Nasional', 'slug' => 'nasional', 'description' => 'Berita nasional Indonesia', 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Internasional', 'slug' => 'internasional', 'description' => 'Berita internasional', 'is_active' => true, 'sort_order' => 3],
            ['name' => 'Ekonomi', 'slug' => 'ekonomi', 'description' => 'Berita ekonomi dan keuangan', 'is_active' => true, 'sort_order' => 4],
            ['name' => 'Bisnis', 'slug' => 'bisnis', 'description' => 'Berita bisnis dan entrepreneur', 'is_active' => true, 'sort_order' => 5],
            ['name' => 'Teknologi', 'slug' => 'teknologi', 'description' => 'Berita teknologi dan gadget', 'is_active' => true, 'sort_order' => 6],
            ['name' => 'Lifestyle', 'slug' => 'lifestyle', 'description' => 'Berita lifestyle dan gaya hidup', 'is_active' => true, 'sort_order' => 7],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'description' => 'Berita olahraga nasional dan internasional', 'is_active' => true, 'sort_order' => 8],
            ['name' => 'Otomotif', 'slug' => 'otomotif', 'description' => 'Berita otomotif', 'is_active' => true, 'sort_order' => 9],
            ['name' => 'Hiburan', 'slug' => 'hiburan', 'description' => 'Berita hiburan dan selebriti', 'is_active' => true, 'sort_order' => 10],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'description' => 'Berita pendidikan', 'is_active' => true, 'sort_order' => 11],
            ['name' => 'Islami', 'slug' => 'islami', 'description' => 'Berita Islami dan religi', 'is_active' => true, 'sort_order' => 12],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Subcategories
        $nasional = Category::where('slug', 'nasional')->first();
        if ($nasional) {
            Category::create(['name' => 'Hukum & Kriminal', 'slug' => 'hukum-kriminal', 'parent_id' => $nasional->id, 'description' => 'Berita hukum dan kriminal', 'is_active' => true, 'sort_order' => 1]);
            Category::create(['name' => 'Politik', 'slug' => 'politik-nasional', 'parent_id' => $nasional->id, 'description' => 'Politik nasional', 'is_active' => true, 'sort_order' => 2]);
        }
    }
}
