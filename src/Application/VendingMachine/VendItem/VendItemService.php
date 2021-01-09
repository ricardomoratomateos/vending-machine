<?php

namespace VendingMachine\Application\VendingMachine\VendItem;

use VendingMachine\Application\VendingMachine\AbstractService;

class VendItemService extends AbstractService
{
    public function __invoke(
        VendItemRequest $request
    ): VendItemResponse {
        $vendingMachine = $this->repository->getVendingMachine();

        $item = $request->getItem();
        $change = $vendingMachine->vendItemOf($item);

        $this->repository->save($vendingMachine);

        return new VendItemResponse(
            $request->getItemAsString(),
            $change
        );
    }
}
