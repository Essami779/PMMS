<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Services\PermissionRegistry;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Create all permissions defined in PermissionRegistry
        $allPermissions = PermissionRegistry::getAllPermissions();

        foreach ($allPermissions as $permissionName) {
            Permission::findOrCreate($permissionName, 'web');
        }

        // 2. Roles Setup
        $superAdmin = Role::findOrCreate('Super Admin', 'web');
        $superAdmin->syncPermissions(Permission::all());

        $admin = Role::findOrCreate('Admin', 'web');
        $admin->syncPermissions([
            'dashboard.view',
            'users.manage',
            'roles.manage',
            'lookups.manage',
            'backups.manage',
            'audit.view',
            'trash.manage',
        ]);

        $manager = Role::findOrCreate('Manager', 'web');
        $manager->syncPermissions([
            'dashboard.view',
            'users.manage',
            'lookups.manage',
        ]);

        $user = Role::findOrCreate('User', 'web');
        $user->syncPermissions([
            'dashboard.view',
        ]);

        $viewer = Role::findOrCreate('Viewer', 'web');
        $viewer->syncPermissions([
            'dashboard.view',
        ]);
    }
}
