<?php

namespace App\ValueObjects;

class WeeklyMetrics
{
    public function __construct(
        public readonly float $totalHours,
        public readonly array $weeklyEarnings
    ) {}
}
