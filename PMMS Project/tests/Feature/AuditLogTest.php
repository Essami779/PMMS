<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('Super Admin');

        $this->regularUser = User::factory()->create();
        $this->regularUser->assignRole('Viewer');

        activity()
            ->causedBy($this->admin)
            ->log('قام مسؤول النظام بتسجيل الدخول');
    }

    public function test_audit_index_can_be_rendered_for_authorized_user(): void
    {
        $response = $this->actingAs($this->admin)->get(route('audit.index'));

        $response->assertStatus(200);
        $response->assertViewIs('audit.index');
        $response->assertSee('قام مسؤول النظام بتسجيل الدخول');
    }

    public function test_super_admin_can_bulk_destroy_audit_logs(): void
    {
        $ids = Activity::pluck('id')->toArray();
        $this->assertNotEmpty($ids);

        $response = $this->actingAs($this->admin)->delete(route('audit.bulkDestroy'), [
            'ids' => $ids,
        ]);

        $response->assertRedirect(route('audit.index'));
        $this->assertEquals(0, Activity::count());
    }

    public function test_unauthorized_user_cannot_access_audit_logs(): void
    {
        $response = $this->actingAs($this->regularUser)->get(route('audit.index'));

        $response->assertStatus(403);
    }
}
