<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage-dashboard',
            'manage-posts',
            'manage-categories',
            'manage-tags',
            'manage-users',
            'manage-pages',
            'manage-advertisements',
            'manage-comments',
            'manage-menus',
            'manage-media',
            'manage-settings',
            'manage-breaking-news',
            'publish-posts',
            'edit-own-posts',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Admin — semua akses
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permissions);

        // Editor — bisa manage konten + komentar + breaking news, tapi TIDAK bisa manage users/settings
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $editor->syncPermissions([
            'manage-dashboard',
            'manage-posts',
            'manage-categories',
            'manage-tags',
            'manage-pages',
            'manage-comments',
            'manage-media',
            'manage-menus',
            'manage-breaking-news',
            'manage-advertisements',
            'publish-posts',
            'edit-own-posts',
        ]);

        // Wartawan — hanya bisa manage post sendiri + media
        $wartawan = Role::firstOrCreate(['name' => 'wartawan']);
        $wartawan->syncPermissions([
            'manage-dashboard',
            'edit-own-posts',
            'manage-media',
        ]);

        // User — akses dashboard saja
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->syncPermissions([
            'manage-dashboard',
        ]);

        // Pastikan admin user pertama punya role admin
        $adminUser = User::where('email', 'admin@porosaktual.com')->first();
        if ($adminUser && !$adminUser->hasRole('admin')) {
            $adminUser->assignRole('admin');
        }
    }
}
