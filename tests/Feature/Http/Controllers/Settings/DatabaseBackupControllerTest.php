<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Settings;

use App\Http\Controllers\Settings\DatabaseBackupController;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(DatabaseBackupController::class)]
#[CoversMethod(DatabaseBackupController::class, 'download')]
final class DatabaseBackupControllerTest extends TestCase
{
    #[Test]
    public function auth_middleware_is_applied(): void
    {
        $response = $this->get(route('settings.database-backup.download'));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function user_can_download_database_backup(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('settings.database-backup.download'));

        $response->assertOk();
        $response->assertDownload();
    }

    #[Test]
    public function returns_correct_content_type(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('settings.database-backup.download'));

        $response->assertHeader('Content-Type', 'application/x-sqlite3');
    }

    #[Test]
    public function filename_contains_timestamp(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('settings.database-backup.download'));

        $contentDisposition = $response->headers->get('Content-Disposition');
        $this->assertStringContainsString('simpletimer_backup_', (string) $contentDisposition);
        $this->assertStringContainsString('.sqlite', (string) $contentDisposition);
    }
}
