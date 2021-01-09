<?php

use VendingMachine\Application\VendingMachine\InsertCoin\InsertCoinRequest;
use VendingMachine\Application\VendingMachine\InsertCoin\InsertCoinService;
use VendingMachine\Application\VendingMachine\ReturnCoins\ReturnCoinsRequest;
use VendingMachine\Application\VendingMachine\ReturnCoins\ReturnCoinsResponse;
use VendingMachine\Application\VendingMachine\ReturnCoins\ReturnCoinsService;
use VendingMachine\Application\VendingMachine\ServiceFactory;
use VendingMachine\Application\VendingMachine\VendItem\VendItemRequest;
use VendingMachine\Application\VendingMachine\VendItem\VendItemResponse;
use VendingMachine\Application\VendingMachine\VendItem\VendItemService;
use VendingMachine\Domain\LogicException;

function processInsertCoin(ServiceFactory $serviceFactory, $value)
{
    $coinValue = (float)$value;

    try {
        $request = new InsertCoinRequest($coinValue);
        /** @var InsertMoneyService */
        $service = $serviceFactory->make(InsertCoinService::class);

        $service($request);
    } catch (LogicException $exception) {
        echo $exception::MESSAGE;
        echo "\n";
    }
}

function processReturnCoins(ServiceFactory $serviceFactory)
{
    try {
        $request = new ReturnCoinsRequest();
        /** @var ReturnCoinsService */
        $service = $serviceFactory->make(ReturnCoinsService::class);

        /** @var ReturnCoinsResponse */
        $response = $service($request);

        $coinValues = $response->getCoinValues();
        if (empty($coinValues)) {
            echo "\n";
            return;
        }

        echo implode(', ', $coinValues);
        echo "\n";
    } catch (LogicException $exception) {
        echo $exception::MESSAGE;
        echo "\n";
    }
}

function processVendItem(ServiceFactory $serviceFactory, $value)
{
    try {
        $request = new VendItemRequest("item-$value");
        /** @var VendItemService */
        $service = $serviceFactory->make(VendItemService::class);

        /** @var VendItemResponse */
        $response = $service($request);

        $item = $response->getItem();
        $item = (explode('-', $item))[1];
        $item = strtoupper($item);

        $coinValues = $response->getChange();
        if (empty($coinValues)) {
            echo $item;
            echo "\n";
            return;
        }

        echo "$item, " . implode(', ', $coinValues);
        echo "\n";
    } catch (LogicException $exception) {
        echo $exception::MESSAGE;
        echo "\n";
    }
}
