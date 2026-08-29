<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
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
            Permission::create(['name' => $permission]);
        }

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo($permissions);

        $editor = Role::create(['name' => 'editor']);
        $editor->givePermissionTo(['manage-posts', 'manage-categories', 'manage-tags', 'manage-comments', 'publish-posts', 'manage-media']);

        $wartawan = Role::create(['name' => 'wartawan']);
        $wartawan->givePermissionTo(['edit-own-posts', 'manage-media']);
    }
}
