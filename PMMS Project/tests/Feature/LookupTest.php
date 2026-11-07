<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LookupTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('Super Admin');
    }

    public function test_lookups_index_can_be_rendered(): void
    {
        $response = $this->actingAs($this->admin)->get(route('lookups.index'));
        $response->assertStatus(200);
        $response->assertViewIs('lookups.index');
    }

    public function test_admin_can_add_unit_lookup(): void
    {
        $response = $this->actingAs($this->admin)->post(route('lookups.units.store'), [
            'name' => 'إدارة التطوير والابتكار',
            'code' => 'DEV-99',
            'color_code' => 'indigo',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('units', [
            'name' => 'إدارة التطوير والابتكار',
            'code' => 'DEV-99',
        ]);
    }

    public function test_admin_can_add_currency_lookup(): void
    {
        $response = $this->actingAs($this->admin)->post(route('lookups.currencies.store'), [
            'code' => 'EUR',
            'name' => 'اليورو الأوروبي',
            'symbol' => '€',
            'exchange_rate' => 1.15,
            'color_code' => 'indigo',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('currencies', [
            'code' => 'EUR',
            'symbol' => '€',
        ]);
    }
}
