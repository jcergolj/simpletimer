<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Settings;

use App\Http\Controllers\Settings\DatabaseBackupController;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use PDO;
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
        Config::set('database.connections.sqlite.database', database_path('template.sqlite'));

        $response = $this->actingAs($user)->get(route('settings.database-backup.download'));

        $response->assertOk();
        $response->assertDownload();
    }

    #[Test]
    public function returns_correct_content_type(): void
    {
        $user = User::factory()->create();
        Config::set('database.connections.sqlite.database', database_path('template.sqlite'));

        $response = $this->actingAs($user)->get(route('settings.database-backup.download'));

        $response->assertHeader('Content-Type', 'application/x-sqlite3');
    }

    #[Test]
    public function filename_contains_timestamp(): void
    {
        $user = User::factory()->create();
        Config::set('database.connections.sqlite.database', database_path('template.sqlite'));

        $response = $this->actingAs($user)->get(route('settings.database-backup.download'));

        $contentDisposition = $response->headers->get('Content-Disposition');
        $this->assertStringContainsString('simpletimer_backup_', (string) $contentDisposition);
        $this->assertStringContainsString('.sqlite', (string) $contentDisposition);
    }

    #[Test]
    public function backup_is_a_separate_snapshot_that_contains_wal_data(): void
    {
        $user = User::factory()->create();
        $originalDatabasePath = Config::get('database.connections.sqlite.database');
        $databasePath = tempnam(sys_get_temp_dir(), 'simpletimer-database-');
        $this->assertIsString($databasePath);
        unlink($databasePath);

        $pdo = new PDO('sqlite:'.$databasePath);
        $pdo->exec('PRAGMA journal_mode = WAL');
        $pdo->exec('CREATE TABLE snapshot_data (value TEXT NOT NULL)');
        $pdo->exec("INSERT INTO snapshot_data (value) VALUES ('committed in wal')");

        Config::set('database.connections.sqlite.database', $databasePath);

        try {
            $response = $this->actingAs($user)->get(route('settings.database-backup.download'));
            $snapshotPath = $response->baseResponse->getFile()->getPathname();

            $this->assertNotSame($databasePath, $snapshotPath);

            $snapshot = new PDO('sqlite:'.$snapshotPath);
            $this->assertSame(
                'committed in wal',
                $snapshot->query('SELECT value FROM snapshot_data')->fetchColumn()
            );
        } finally {
            Config::set('database.connections.sqlite.database', $originalDatabasePath);
            if (is_file($databasePath)) {
                unlink($databasePath);
            }
            if (isset($snapshotPath) && is_file($snapshotPath)) {
                unlink($snapshotPath);
            }
        }
    }
}
