<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\LookupSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
        $this->seed(LookupSeeder::class);
    }

    public function test_roles_index_requires_permission(): void
    {
        $user = User::factory()->create(); // No role / permissions

        $response = $this->actingAs($user)->get(route('roles.index'));
        $response->assertStatus(403);
    }

    public function test_super_admin_can_access_roles_index(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $response = $this->actingAs($admin)->get(route('roles.index'));
        $response->assertStatus(200);
        $response->assertViewIs('roles.index');
    }

    public function test_admin_can_create_new_role(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $response = $this->actingAs($admin)->post(route('roles.store'), [
            'name' => 'Auditor Role',
            'permissions' => ['audit.view', 'lookups.manage'],
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('roles', ['name' => 'Auditor Role']);

        $role = Role::findByName('Auditor Role');
        $this->assertTrue($role->hasPermissionTo('audit.view'));
        $this->assertTrue($role->hasPermissionTo('lookups.manage'));
    }

    public function test_viewer_role_cannot_manage_users(): void
    {
        $viewer = User::factory()->create();
        $viewer->assignRole('Viewer');

        $response = $this->actingAs($viewer)->get(route('users.index'));
        $response->assertStatus(403);
    }

    public function test_manager_role_cannot_manage_backups(): void
    {
        $manager = User::factory()->create();
        $manager->assignRole('Manager');

        $response = $this->actingAs($manager)->get(route('backups.index'));
        $response->assertStatus(403);
    }

    public function test_sync_matrix_updates_permissions_accurately(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $userRole = Role::findByName('User');

        $matrixPayload = [
            $userRole->id => [
                'dashboard.view' => '1',
                'audit.view' => '1',
            ],
        ];

        $response = $this->actingAs($admin)->post(route('roles.matrix.sync'), [
            'matrix' => $matrixPayload,
        ]);

        $response->assertSessionHas('success');

        $userRole->refresh();
        $this->assertTrue($userRole->hasPermissionTo('dashboard.view'));
        $this->assertTrue($userRole->hasPermissionTo('audit.view'));
        $this->assertFalse($userRole->hasPermissionTo('backups.manage'));
    }
}
