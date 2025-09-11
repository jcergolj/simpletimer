<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DatabaseBackupController extends Controller
{
    public function download(): BinaryFileResponse
    {
        $databasePath = database_path('database.sqlite');

        if (! File::exists($databasePath)) {
            abort(404, 'Database file not found');
        }

        if (! File::isReadable($databasePath)) {
            abort(403, 'Database file is not readable');
        }

        Log::info('Database backup downloaded', [
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email,
            'timestamp' => now()->toDateTimeString(),
        ]);

        $filename = 'simpletimer_backup_'.now()->format('Y-m-d_H-i-s').'.sqlite';

        return response()->download($databasePath, $filename, [
            'Content-Type' => 'application/x-sqlite3',
        ]);
    }
}
