<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure roles exist
        if (Role::count() === 0) {
            $this->call(RolePermissionSeeder::class);
        }

        // 1. Super Admin (admin@admin.com & admin@gmail.com)
        $superAdmin1 = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'مدير النظام العام',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin1->syncRoles(['Super Admin']);

        $superAdmin2 = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'مسؤول النظام (أدمن)',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin2->syncRoles(['Super Admin']);

        // 2. Manager (manager@admin.com & manager@gmail.com)
        $manager1 = User::updateOrCreate(
            ['email' => 'manager@admin.com'],
            [
                'name' => 'مدير العمليات والإدارة',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $manager1->syncRoles(['Manager']);

        $manager2 = User::updateOrCreate(
            ['email' => 'manager@gmail.com'],
            [
                'name' => 'مدير الإدارة',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );
        $manager2->syncRoles(['Manager']);

        // 3. Normal User (user@admin.com & user@gmail.com)
        $user1 = User::updateOrCreate(
            ['email' => 'user@admin.com'],
            [
                'name' => 'مستخدم المنظومة',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $user1->syncRoles(['User']);

        $user2 = User::updateOrCreate(
            ['email' => 'viewer@gmail.com'],
            [
                'name' => 'مستخدم استعراض واطلاع',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );
        $user2->syncRoles(['Viewer']);
    }
}
