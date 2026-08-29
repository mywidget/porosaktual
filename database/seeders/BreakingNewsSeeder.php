<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BreakingNews;

class BreakingNewsSeeder extends Seeder
{
    public function run(): void
    {
        BreakingNews::create([
            'title' => 'Selamat datang di Poros Aktual - Portal Berita Terpercaya',
            'url' => '/page/tentang-kami',
            'is_active' => true,
            'priority' => 1,
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ]);
    }
}
