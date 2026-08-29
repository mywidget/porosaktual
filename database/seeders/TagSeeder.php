<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = ['prabowo', 'jokowi', 'dpr', 'ekonomi-indonesia', 'inflasi', 'rupiah', 'ai', 'startup', 'covid', 'energi-baru', 'banjir', 'gempa', 'corona', 'influencer', 'livescore', 'moto-gp', 'liga-1'];
        foreach ($tags as $tag) {
            Tag::create([
                'name' => ucwords(str_replace('-', ' ', $tag)),
                'slug' => $tag,
            ]);
        }
    }
}
