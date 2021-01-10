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
        if (empty($this->change)) {
            return false;
        }

        $changeCopy = $this->change;
        while ($valueToReturn > 0.00) {
            $coinToReturnIndex = array_keys($changeCopy)[0];
            $coinToReturn = $changeCopy[$coinToReturnIndex];
            for ($i = 1; $i < count($changeCopy); $i++) {
                if (
                    isset($changeCopy[$i]) &&
                    $changeCopy[$i]->getValue() <= $valueToReturn &&
                    $changeCopy[$i]->getValue() > $coinToReturn->getValue()
                ) {
                    $coinToReturnIndex = $i;
                    $coinToReturn = $changeCopy[$i];
                }
            }

            $coinsToReturn[] = $coinToReturn;
            $valueToReturn -= $coinToReturn->getValue();
            $valueToReturn = round($valueToReturn, 2);
            unset($changeCopy[$coinToReturnIndex]);
        }

        return $valueToReturn === 0.00;
    }

    private function calculateChange(Price $price): array
    {
        $valueOfInsertedCoins = $this->transformInsertedCoinsToFloat();

        $coinsToReturn = [];
        $valueToReturn = $valueOfInsertedCoins - $price->getValue();

        while ($valueToReturn > 0.00) {
            $coinToReturnIndex = array_keys($this->change)[0];
            $coinToReturn = $this->change[$coinToReturnIndex];

            for ($i = 1; $i < count($this->change); $i++) {
                if (
                    isset($this->change[$i]) &&
                    $this->change[$i]->getValue() <= $valueToReturn &&
                    $this->change[$i]->getValue() > $coinToReturn->getValue()
                ) {
                    $coinToReturnIndex = $i;
                    $coinToReturn = $this->change[$i];
                }
            }

            $coinsToReturn[] = $coinToReturn;
            $valueToReturn -= $coinToReturn->getValue();
            $valueToReturn = round($valueToReturn, 2);
            unset($this->change[$coinToReturnIndex]);
        }
        
        $this->insertedCoins = [];

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
