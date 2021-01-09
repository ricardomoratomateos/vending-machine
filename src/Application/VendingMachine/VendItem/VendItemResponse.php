<?php

namespace VendingMachine\Application\VendingMachine\VendItem;

use VendingMachine\Application\VendingMachine\Exceptions\InvalidItemException;
use VendingMachine\Domain\VendingMachine\ValueObjects\Coin;

class VendItemResponse
{
    const ITEM_JUICE = 'item-juice';
    const ITEM_SODA = 'item-soda';
    const ITEM_WATER = 'item-water';

    private string $item;

    /** @var Coin[] */
    private array $change;

    /**
     * @param string $item: Use one of the class constants
     */
    public function __construct(string $item, array $change)
    {
        $this->setItem($item);
        $this->change = $change;
    }

    public function getItem(): string
    {
        return $this->item;
    }

    /**
     * @return float[]
     */
    public function getChange(): array
    {
        return array_map(function (Coin $coin) {
            return $coin->getValue();
        }, $this->change);
    }

    private function setItem(string $item): void
    {
        switch ($item) {
            case self::ITEM_JUICE:
            case self::ITEM_SODA:
            case self::ITEM_WATER:
                break;
            default:
                throw new InvalidItemException();
        }

        $this->item = $item;
    }
}
