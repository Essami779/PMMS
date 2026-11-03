<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class BackupTest extends TestCase
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

    public function test_backups_index_page_is_accessible_for_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('backups.index'));
        $response->assertStatus(200);
        $response->assertViewIs('backups.index');
    }

    public function test_admin_can_create_a_backup(): void
    {
        $response = $this->actingAs($this->admin)->post(route('backups.store'));
        $response->assertRedirect(route('backups.index'));

        $backupDir = storage_path('app/backups');
        $files = File::files($backupDir);

        $this->assertNotEmpty($files);
    }

    public function test_path_traversal_is_prevented_on_download(): void
    {
        $response = $this->actingAs($this->admin)->get(route('backups.download', ['filename' => 'non_existent_file.sql']));
        
        $response->assertRedirect(route('backups.index'));
        $response->assertSessionHas('error');
    }

    public function test_admin_can_bulk_delete_backups(): void
    {
        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true, true);
        }

        $file1 = 'test-bulk-backup-1.sql';
        $file2 = 'test-bulk-backup-2.sql';

        File::put($backupDir . '/' . $file1, 'SQL DUMP 1');
        File::put($backupDir . '/' . $file2, 'SQL DUMP 2');

        $response = $this->actingAs($this->admin)->delete(route('backups.bulkDestroy'), [
            'filenames' => [$file1, $file2]
        ]);

        $response->assertRedirect(route('backups.index'));
        $response->assertSessionHas('success');

        $this->assertFileDoesNotExist($backupDir . '/' . $file1);
        $this->assertFileDoesNotExist($backupDir . '/' . $file2);
    }
}
