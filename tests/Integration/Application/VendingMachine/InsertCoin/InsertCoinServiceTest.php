<?php
namespace VendingMachine\Tests\Integration\Application\VendingMachine\InsertCoin;

use PHPUnit\Framework\TestCase;
use VendingMachine\Application\VendingMachine\InsertCoin\InsertCoinRequest;
use VendingMachine\Application\VendingMachine\InsertCoin\InsertCoinResponse;
use VendingMachine\Application\VendingMachine\InsertCoin\InsertCoinService;
use VendingMachine\Infrastructure\VendingMachine\Repositories\InMemoryVendingMachineRepository;

class InsertCoinServiceTest extends TestCase
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
    public function testInsertAValidCoin(float $value): void
    {
        $request = new InsertCoinRequest($value);
        $service = new InsertCoinService(new InMemoryVendingMachineRepository());

        $response = $service($request);

        $this->assertInstanceOf(InsertCoinResponse::class, $response);
    }
}
