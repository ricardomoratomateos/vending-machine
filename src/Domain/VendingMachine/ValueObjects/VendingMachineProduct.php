<?php

namespace VendingMachine\Domain\VendingMachine\ValueObjects;

use VendingMachine\Domain\VendingMachine\Entities\ItemInterface;

class VendingMachineProduct
{
    private ItemInterface $item;

    private int $quantity;

    private Price $price;

    public function __construct(
        ItemInterface $item,
        int $quantity,
        Price $price
    ) {
        $this->item = $item;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function getItem(): ItemInterface
    {
        return $this->item;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function addItems(int $quantity): void
    {
        $this->quantity += $quantity;
    }

    public function vendItem(): void
    {
        $this->quantity -= 1;
    }
}
