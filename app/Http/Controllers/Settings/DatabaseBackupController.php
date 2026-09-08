<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\TenantDatabaseService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PDO;
use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DatabaseBackupController extends Controller
{
    public function download(TenantDatabaseService $tenantDb): BinaryFileResponse
    {
        $databasePath = $tenantDb->getActiveDatabasePath();

        if ($databasePath === null || ! File::exists($databasePath)) {
            abort(404, __('Database file not found.'));
        }

        if (! File::isReadable($databasePath)) {
            abort(403, __('Database file is not readable.'));
        }

        Log::info('Database backup downloaded', [
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email,
            'timestamp' => now()->toDateTimeString(),
        ]);

        $filename = 'simpletimer_backup_'.now()->format('Y-m-d_H-i-s').'.sqlite';
        $snapshotPath = tempnam(sys_get_temp_dir(), 'simpletimer-backup-');

        throw_unless($snapshotPath !== false, RuntimeException::class, 'Unable to create a database backup snapshot.');

        File::delete($snapshotPath);

        try {
            $database = new PDO('sqlite:'.$databasePath, options: [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
            $database->exec('PRAGMA busy_timeout = 10000');
            $quotedSnapshotPath = $database->quote($snapshotPath);

            $database->exec("VACUUM INTO {$quotedSnapshotPath}");
            $database = null;

            throw_unless(File::exists($snapshotPath), RuntimeException::class, 'Unable to create a database backup snapshot.');

            return response()->download($snapshotPath, $filename, [
                'Content-Type' => 'application/x-sqlite3',
            ])->deleteFileAfterSend(true);
        } catch (\Throwable $exception) {
            if (File::exists($snapshotPath)) {
                File::delete($snapshotPath);
            }

            throw $exception;
        }
    }
}
