<?php
namespace VendingMachine\Tests\Unit\Domain\VendingMachine;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\VendingMachine\Entities\Water;
use VendingMachine\Domain\VendingMachine\Exceptions\HasNotEnoughMoneyException;
use VendingMachine\Domain\VendingMachine\Exceptions\MachineHasNotEnoughChangeException;
use VendingMachine\Domain\VendingMachine\ValueObjects\Coin;
use VendingMachine\Domain\VendingMachine\ValueObjects\Price;
use VendingMachine\Domain\VendingMachine\ValueObjects\VendingMachineProduct;
use VendingMachine\Domain\VendingMachine\VendingMachine;

class VendingMachineTest extends TestCase
{
    public function testReturnCoinsWithoutInsertBefore(): void
    {
        $vendingMachine = new VendingMachine([], []);

        $this->assertEmpty($vendingMachine->returnCoins());
    }

    public function testReturnCoinsWithInsertBefore(): void
    {
        $vendingMachine = new VendingMachine([], []);
        $vendingMachine->insertCoin(new Coin(0.05));
        $vendingMachine->insertCoin(new Coin(0.05));
        $vendingMachine->insertCoin(new Coin(0.05));

        $this->assertCount(3, $vendingMachine->returnCoins());
    }

    public function testVendItemWithoutHaveEnoughMoney(): void
    {
        $vendingMachine = new VendingMachine(
            [new VendingMachineProduct(new Water(), 1, new Price(1.00))],
            []
        );

        $this->expectException(HasNotEnoughMoneyException::class);
        $vendingMachine->vendItemOf(new Water());
    }

    public function testVendItemHavingEnoughMoneyButMachineHasNotChange(): void
    {
        $vendingMachine = new VendingMachine(
            [new VendingMachineProduct(new Water(), 1, new Price(1.00))],
            []
        );
        $vendingMachine->insertCoin(new Coin(1.00));
        $vendingMachine->insertCoin(new Coin(0.05));

        $this->expectException(MachineHasNotEnoughChangeException::class);
        $vendingMachine->vendItemOf(new Water());
    }

    public function testVendItemWithMachineWithoutChangeButWithExactlyInsertMoney(): void
    {
        $vendingMachine = new VendingMachine(
            [new VendingMachineProduct(new Water(), 1, new Price(1.00))],
            []
        );
        $vendingMachine->insertCoin(new Coin(1.00));

        $change = $vendingMachine->vendItemOf(new Water());

        $this->assertEmpty($change);
    }

    public function testVendItemWithMachineWithChange(): void
    {
        $vendingMachine = new VendingMachine(
            [new VendingMachineProduct(new Water(), 1, new Price(1.00))],
            [new Coin(0.05)]
        );
        $vendingMachine->insertCoin(new Coin(1.00));
        $vendingMachine->insertCoin(new Coin(0.05));

        $change = $vendingMachine->vendItemOf(new Water());

        $this->assertCount(1, $change);
    }
}
