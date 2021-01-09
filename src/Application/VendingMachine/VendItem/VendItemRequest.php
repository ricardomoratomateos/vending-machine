<?php

namespace VendingMachine\Application\VendingMachine\VendItem;

use VendingMachine\Application\VendingMachine\Exceptions\InvalidItemException;
use VendingMachine\Domain\VendingMachine\Entities\ItemInterface;
use VendingMachine\Domain\VendingMachine\Entities\Juice;
use VendingMachine\Domain\VendingMachine\Entities\Soda;
use VendingMachine\Domain\VendingMachine\Entities\Water;

class VendItemRequest
{
    const ITEM_JUICE = 'item-juice';
    const ITEM_SODA = 'item-soda';
    const ITEM_WATER = 'item-water';

    private ItemInterface $item;

    private string $itemAsString;

    /**
     * @param string $item: Use one of the class constants
     */
    public function __construct(string $item)
    {
        $this->itemAsString = $item;
        $this->setItem($item);
    }

    public function getItem(): ItemInterface
    {
        return $this->item;
    }

    public function getItemAsString(): string
    {
        return $this->itemAsString;
    }

    private function setItem(string $item): void
    {
        $class = '';

        switch ($item) {
            case self::ITEM_JUICE:
                $class = Juice::class;
                break;
            case self::ITEM_SODA:
                $class = Soda::class;
                break;
            case self::ITEM_WATER:
                $class = Water::class;
                break;
            default:
                throw new InvalidItemException();
        }

        $this->item = new $class();
    }
}
