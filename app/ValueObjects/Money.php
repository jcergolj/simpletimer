<?php

namespace App\ValueObjects;

use App\Enums\Currency;
use Illuminate\Contracts\Support\Arrayable;
use InvalidArgumentException;
use JsonSerializable;

class Money implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly int $amount, // Amount in currency minor units
        public readonly Currency $currency = Currency::USD
    ) {}

    public static function from(array $data): self
    {
        return new self(
            amount: (int) ($data['amount'] ?? 0),
            currency: isset($data['currency']) ? Currency::from($data['currency']) : Currency::USD
        );
    }

    public static function fromDecimal(float $amount, Currency|string $currency = Currency::USD): self
    {
        $currency = is_string($currency) ? Currency::from($currency) : $currency;

        return new self(
            amount: self::toMinorUnits($amount, $currency),
            currency: $currency
        );
    }

    public static function fromValidated(array $data): ?self
    {
        if (! isset($data['hourly_rate']['amount'])) {
            return null;
        }

        $hourly_rate = $data['hourly_rate'];

        $currency = is_string($hourly_rate['currency'])
            ? Currency::from($hourly_rate['currency'])
            : $hourly_rate['currency'];

        return new self(
            amount: self::toMinorUnits((float) $hourly_rate['amount'], $currency),
            currency: $currency
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency->value,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function formatted(): string
    {
        $symbol = $this->currency->symbol();
        $decimalAmount = $this->toDecimal();

        return $symbol.number_format($decimalAmount, $this->currency->minorUnit());
    }

    public function formattedForCsv(): string
    {
        $symbol = $this->currency->symbol();
        $decimalAmount = $this->toDecimal();

        return $symbol.number_format($decimalAmount, $this->currency->minorUnit(), '.', '');
    }

    public function toDecimal(): float
    {
        return $this->amount / (10 ** $this->currency->minorUnit());
    }

    public function toInputValue(): string
    {
        return number_format($this->toDecimal(), $this->currency->minorUnit(), '.', '');
    }

    public function equals(Money $other): bool
    {
        return $this->amount === $other->amount && $this->currency === $other->currency;
    }

    public function earnings(int $durationInSeconds): Money
    {
        $hours = $durationInSeconds / 3600;

        return new Money(
            amount: (int) round($this->amount * $hours),
            currency: $this->currency
        );
    }

    private static function toMinorUnits(float $amount, Currency $currency): int
    {
        $minorUnits = $amount * (10 ** $currency->minorUnit());

        throw_if(! is_finite($minorUnits) || $minorUnits > PHP_INT_MAX || $minorUnits < PHP_INT_MIN, InvalidArgumentException::class, 'Money amount is outside the supported range.');

        return (int) round($minorUnits);
    }
}
