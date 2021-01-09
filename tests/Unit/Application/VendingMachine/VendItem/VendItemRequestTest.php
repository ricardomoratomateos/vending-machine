<?php
namespace VendingMachine\Tests\Unit\Application\VendingMachine\VendItem;

use PHPUnit\Framework\TestCase;
use VendingMachine\Application\VendingMachine\Exceptions\InvalidItemException;
use VendingMachine\Application\VendingMachine\VendItem\VendItemRequest;

class VendItemRequestTest extends TestCase
{
    public function validItemsProvider(): array
    {
        return [
            ['value' => VendItemRequest::ITEM_JUICE],
            ['value' => VendItemRequest::ITEM_SODA],
            ['value' => VendItemRequest::ITEM_WATER],
        ];
    }

    /** @dataProvider validItemsProvider */
    public function testCreateRequestWithValidItem(string $value): void
    {
        $this->assertInstanceOf(VendItemRequest::class, new VendItemRequest($value));
    }

    public function testCreateRequestWithInvalidItem(): void
    {
        $this->expectException(InvalidItemException::class);
        new VendItemRequest('test');
    }
}
