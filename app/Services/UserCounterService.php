<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class UserCounterService
{
    public function getTotalUsers(): int
    {
        return Cache::remember('user_count', now()->addMinutes(5), function () {
            $dbPath = database_path('db');

            if (! File::exists($dbPath)) {
                return 0;
            }

            $files = File::glob($dbPath.'/*.sqlite');

            return count($files);
        });
    }

    public function getRemainingFreeSlots(): int
    {
        $limit = (int) config('app.free_tier_user_limit', 10);
        $current = $this->getTotalUsers();

        return max(0, $limit - $current);
    }

    public function isFreeUser(int $userNumber): bool
    {
        $limit = (int) config('app.free_tier_user_limit', 10);

        return $userNumber <= $limit;
    }

    public function getUserTier(int $userNumber): string
    {
        return $this->isFreeUser($userNumber) ? 'free' : 'trial';
    }

    public function getNextUserNumber(): int
    {
        return $this->getTotalUsers() + 1;
    }
}
