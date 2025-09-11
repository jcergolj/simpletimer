<?php

namespace App\Enums;

enum ExceptionCode: string
{
    case HourlyRateAmountMissing = 'hourly_rate_amount_missing';
    case HourlyRateCurrencyMissing = 'hourly_rate_currency_missing';

    public function forHuman(): string
    {
        return match ($this) {
            self::HourlyRateAmountMissing => 'Hourly rate amount is missing',
            self::HourlyRateCurrencyMissing => 'Hourly rate currency is missing',
        };
    }
}
