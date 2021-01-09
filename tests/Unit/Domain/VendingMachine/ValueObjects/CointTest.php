<?php
namespace VendingMachine\Tests\Unit\Domain\VendingMachine\ValueObjects;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\VendingMachine\ValueObjects\Coin;
use VendingMachine\Domain\VendingMachine\ValueObjects\Exceptions\InvalidCoinValueException;

class CoinTest extends TestCase
{
    public function validCoinsProvider(): array
    {
        return [
            ['value' => 0.05],
            ['value' => 0.10],
            ['value' => 0.25],
            ['value' => 1.00],
        ];
    }

    /** @dataProvider validCoinsProvider */
    public function testCreateWithAValidValue(float $value): void
    {
        $this->assertInstanceOf(Coin::class, new Coin($value));
    }

    public function testVendItemWithoutHaveEnoughMoney(): void
    {
        $this->expectException(InvalidCoinValueException::class);
        new Coin(0.03);
    }
}
