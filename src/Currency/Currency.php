<?php

namespace App\Currency;

class Currency
{
    const DECIMAL_PRECISION = 2;

    protected $integer;

    protected $decimal;

    public function __construct(int $integer = 0, int $decimal = 0)
    {
        $maxDecimals = pow(10, self::DECIMAL_PRECISION) - 1;
        if ($decimal > $maxDecimals) {
            throw new CreateCurrencyException("Max decimals is {$maxDecimals}");
        }

        $this->integer = $integer;
        $this->decimal = $decimal;
    }

    public function getInteger(): int
    {
        return $this->integer;
    }

    public function getDecimal(): int
    {
        return $this->decimal;
    }

    public function add(Currency $add): Currency
    {
        $newCurrency = new Currency($this->integer, $this->decimal);
        $newCurrency->integer += $add->integer;

        $totalDecimals = $newCurrency->decimal + $add->decimal;
        $decimalsInUnit = pow(10, self::DECIMAL_PRECISION);
        $additionalInteger = (int) ($totalDecimals / $decimalsInUnit);
        $decimals = $totalDecimals - ($additionalInteger * $decimalsInUnit);

        $newCurrency->integer += $additionalInteger;
        $newCurrency->decimal = $decimals;

        return $newCurrency;
    }

    public static function fromString(string $currency): Currency
    {
        $parts = explode('.', $currency);
        if (count($parts) !== 2) {
            throw new CreateCurrencyException('Invalid currency format. Use [digits].[digits] (199.00)');
        }

        if (!is_numeric($parts[0]) || !is_numeric($parts[1])) {
            throw new CreateCurrencyException('Invalid character in currency string. use digits only.');
        }

        $decimalPrecision = self::DECIMAL_PRECISION;
        if (mb_strlen($parts[1]) > $decimalPrecision) {
            throw new CreateCurrencyException("Decimal part should contain {$decimalPrecision} digits.");
        }

        return new Currency($parts[0], $parts[1]);
    }

    public function equals(Currency $that): bool
    {
        return $this->integer === $that->integer && $this->decimal === $that->decimal;
    }
}
