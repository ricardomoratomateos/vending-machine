<?php

namespace VendingMachine\Infrastructure\VendingMachine\Repositories;

use VendingMachine\Domain\VendingMachine\Entities\Juice;
use VendingMachine\Domain\VendingMachine\Entities\Soda;
use VendingMachine\Domain\VendingMachine\Entities\Water;
use VendingMachine\Domain\VendingMachine\Repositories\VendingMachineRepositoryInterface;
use VendingMachine\Domain\VendingMachine\ValueObjects\Coin;
use VendingMachine\Domain\VendingMachine\ValueObjects\Price;
use VendingMachine\Domain\VendingMachine\ValueObjects\VendingMachineProduct;
use VendingMachine\Domain\VendingMachine\VendingMachine;

class InMemoryVendingMachineRepository implements VendingMachineRepositoryInterface
{
    private VendingMachine $vendingMachine;

    /**
     * Initialize a new vending machine with:
     *  - Change
     *      * Ten coins of 0.05
     *      * Ten coins of 0.10
     *      * Ten coins of 0.25
     *      * Ten coins of 1.00
     *  - Products
     *      * Ten products of juice
     *      * Ten products of soda
     *      * Ten products of water
     */
    public function __construct()
    {
        $coinValues = [0.05, 0.10, 0.25, 1];
        $coins = [];
        foreach ($coinValues as $coinValue) {
            foreach (range(1, 10) as $i) {
                $coins[] = new Coin($coinValue);
            }
        }

        $this->vendingMachine = new VendingMachine(
            [
                new VendingMachineProduct(new Juice(), 10, new Price(1.00)),
                new VendingMachineProduct(new Soda(), 10, new Price(1.50)),
                new VendingMachineProduct(new Water(), 10, new Price(0.65)),
            ],
            $coins
        );
    }

    public function getVendingMachine(): VendingMachine
    {
        return $this->vendingMachine;
    }

    public function save(VendingMachine $vendingMachine): void
    {
        $this->vendingMachine = $vendingMachine;
    }
}
