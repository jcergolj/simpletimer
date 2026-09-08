<?php

namespace App\Services;

use App\Models\TimeEntry;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TimerStateService
{
    public function getRunningTimer(): ?TimeEntry
    {
        return TimeEntry::query()
            ->with(['client', 'project.client'])
            ->whereNull('end_time')
            ->first();
    }

    public function executeWithLock(Request $request, Closure $callback): mixed
    {
        return Cache::lock('running-timer:'.sha1(strtolower($request->getHost())), 10)
            ->block(5, $callback);
    }

    public function stopRunningTimer(): void
    {
        $timeEntry = TimeEntry::whereNull('end_time')->first();

        if ($timeEntry === null) {
            return;
        }

        $end = now();

        $timeEntry->update([
            'end_time' => $end,
            'duration' => $end->diffInSeconds($timeEntry->start_time),
        ]);
    }

    public function stopRunningTimerAndReturn(): ?TimeEntry
    {
        $runningTimer = $this->getRunningTimer();

        if ($runningTimer instanceof TimeEntry) {
            $this->stopRunningTimer();
            $runningTimer->refresh();
        }

        return $runningTimer;
    }
}
