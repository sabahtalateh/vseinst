<?php

namespace App\Tests\Unit\Currency;

use App\Currency\CreateCurrencyException;
use App\Currency\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    public function testBadDecimalsThrowsException(): void
    {
        $this->expectException(CreateCurrencyException::class);
        new Currency(10, 999);
    }

    public function testCurrencyAddCorrect(): void
    {
        $currency = new Currency(0, 52);
        $currency = $currency->add(new Currency(0, 49));

        $this->assertTrue($currency->equals(new Currency(1, 1)));
        $this->assertFalse($currency->equals(new Currency(1, 0)));
    }
}
