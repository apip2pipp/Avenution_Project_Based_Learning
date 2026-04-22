<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AnalysisExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_analysis_export(): void
    {
        $this->get(route('admin.analyses.export'))
            ->assertRedirect(route('login'));
    }

    public function test_non_admin_user_gets_forbidden_when_accessing_analysis_export(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.analyses.export'))
            ->assertForbidden();
    }

    public function test_admin_can_download_analysis_export_excel_file(): void
    {
        Role::findOrCreate('admin', 'web');
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)
            ->get(route('admin.analyses.export'));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $contentDisposition = $response->headers->get('content-disposition', '');
        $this->assertStringContainsString('attachment;', $contentDisposition);
        $this->assertStringContainsString('analysis-report-', $contentDisposition);
        $this->assertStringContainsString('.xlsx', $contentDisposition);
    }
}
