<?php
namespace VendingMachine\Tests\Unit\Infrastructure\VendingMachine\Repositories;

use PHPUnit\Framework\TestCase;
use VendingMachine\Infrastructure\VendingMachine\Repositories\InMemoryVendingMachineRepository;

class InMemoryVendingMachineRespositoryTest extends TestCase
{
    public function testGetAndSaveAVendingMachine(): void
    {
        $repository = new InMemoryVendingMachineRepository();
        $vendingMachine = $repository->getVendingMachine();

        $this->assertNull($repository->save($vendingMachine));
    }
}
