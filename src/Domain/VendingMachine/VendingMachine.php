<?php

namespace VendingMachine\Domain\VendingMachine;

use VendingMachine\Domain\VendingMachine\Entities\ItemInterface;
use VendingMachine\Domain\VendingMachine\Exceptions\HasNotEnoughMoneyException;
use VendingMachine\Domain\VendingMachine\ValueObjects\Coin;
use VendingMachine\Domain\VendingMachine\Exceptions\MachineHasNotEnoughChangeException;
use VendingMachine\Domain\VendingMachine\ValueObjects\Price;
use VendingMachine\Domain\VendingMachine\ValueObjects\VendingMachineProduct;

class VendingMachine
{
    /** @var VendingMachineProduct[] */
    private array $products;

    /** @var Coin[] */
    private array $change;

    /** @var Coin[] */
    private array $insertedCoins;

    /**
     * @param VendingMachineProduct[] $products
     * @param Coin[] $change
     */
    public function __construct(
        array $products,
        array $change
    ) {
        $this->products = $products;
        $this->change = $change;
        $this->insertedCoins = [];
    }

    /**
     * @param Coin[] $coins
     */
    public function addChange(array $coins): void
    {
        $this->change = array_merge($this->change, $coins);
    }

    public function insertCoin(Coin $coin): void
    {
        $this->insertedCoins[] = $coin;
    }

    /**
     * @return Coin[]
     */
    public function returnCoins(): array
    {
        $insertedCoins = $this->insertedCoins;
        $this->insertedCoins = [];

        return $insertedCoins;
    }

    public function addItemsOf(ItemInterface $item, int $quantity): void
    {
        foreach ($this->products as $product) {
            if ($product->getItem() === $item) {
                $product->addItems($quantity);
            }
        }
    }

    /**
     * @param ItemInterface $item
     * @return Coin[] Change
     */
    public function vendItemOf(ItemInterface $item): array
    {
        $productToVend = null;
        foreach ($this->products as $product) {
            $productClass = get_class($product->getItem());
            if ($productClass === get_class($item)) {
                $productToVend = $product;
                break;
            }
        }

        if (!$this->hasEnoughMoney($productToVend->getPrice())) {
            throw new HasNotEnoughMoneyException();
        }
        if (!$this->hasEnoughChange($productToVend->getPrice())) {
            throw new MachineHasNotEnoughChangeException();
        }

        $product->vendItem();

        return $this->calculateChange($productToVend->getPrice());
    }

    private function hasEnoughMoney(Price $price): bool
    {
        $valueOfInsertedCoins = $this->transformInsertedCoinsToFloat();

        return $valueOfInsertedCoins >= $price->getValue();
    }

    private function hasEnoughChange(Price $price): bool
    {
        $valueOfInsertedCoins = $this->transformInsertedCoinsToFloat();
        $valueToReturn = $valueOfInsertedCoins - $price->getValue();
        if ($valueToReturn == 0) {
            return true;
        }

        foreach ($this->change as $coin) {
            if (round($valueToReturn, 2) === 0.00) {
                break;
            }

            if ($coin->getValue() <= $valueToReturn) {
                $valueToReturn -= $coin->getValue();
            }
        }

        return round($valueToReturn, 2) === 0.00;
    }

    private function calculateChange(Price $price): array
    {
        $valueOfInsertedCoins = $this->transformInsertedCoinsToFloat();

        $coinsToReturn = [];
        $valueToReturn = $valueOfInsertedCoins - $price->getValue();
        foreach ($this->change as $i => $coin) {
            if ($valueToReturn === 0) {
                break;
            }

            if ($coin->getValue() <= $valueToReturn) {
                $coinsToReturn[] = $coin;
                $valueToReturn -= $coin->getValue();
                unset($this->change[$i]);
            }
        }


        return $coinsToReturn;
    }

    private function transformInsertedCoinsToFloat(): float
    {
        $valueOfInsertedCoins = 0.0;
        foreach ($this->insertedCoins as $insertedCoin) {
            $valueOfInsertedCoins += $insertedCoin->getValue();
        }

        return $valueOfInsertedCoins;
    }
}
