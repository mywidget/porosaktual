<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@porosaktual.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'slug' => 'admin',
            'bio' => 'Administrator Poros Aktual',
            'role' => 'admin',
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        $editor = User::create([
            'name' => 'Editor Utama',
            'email' => 'editor@porosaktual.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'slug' => 'editor-utama',
            'bio' => 'Editor Utama Poros Aktual',
            'role' => 'editor',
            'is_active' => true,
        ]);
        $editor->assignRole('editor');

        $wartawan = User::create([
            'name' => 'Budi Santoso',
            'email' => 'wartawan@porosaktual.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'slug' => 'budi-santoso',
            'bio' => 'Wartawan senior di bidang politik dan nasional.',
            'role' => 'wartawan',
            'is_active' => true,
        ]);
        $wartawan->assignRole('wartawan');
    }
}
